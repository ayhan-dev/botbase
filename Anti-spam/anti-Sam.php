<?php
error_reporting(0);
define('API_KEY','6249758725');

$API_URL   = 'https://api.telegram.org/bot'.API_KEY. '/';

$update = json_decode(file_get_contents("php://input"),true);


if(isset($update['message'])){
    $from_id    = $update['message']['from']['id'];
    $chat_id    = $update['message']['chat']['id'];
    
    $chat_type  = $update['message']['chat']['type'];
    $message_id = $update['message']['message_id'];
}


function exe_cute_Curl_Request($handle){
    $response = curl_exec($handle);

    if ($response === false) {
        $errno = curl_errno($handle);
        $error = curl_error($handle);
        throw new Exception("Curl returned error $errno: $error\n");
    }

    $httpCode = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
    curl_close($handle);

    if ($httpCode >= 500) {
        sleep(10);
        return false;
    } 
    
    elseif ($httpCode != 200) {
        $response = json_decode($response, true);
        throw new Exception("Request has failed with error {$response['error_code']}: {$response['description']}\n");
    } else {
        $response = json_decode($response, true);
        if (isset($response['description'])) {
            error_log("Request was successful: {$response['description']}\n");
        }
        $response = $response['result'];
    }
    return $response;
}

function bot($method, $parameters){
    global $API_URL;

    if (!is_string($method)) {
        throw new Exception("Method name must be a string\n");
    }

    if (!$parameters) {
        $parameters = array();
    } elseif (!is_array($parameters)) {
        throw new Exception("Parameters must be an array\n");
    }

    foreach ($parameters as $key => &$val) {
        if (!is_numeric($val) && !is_string($val) && !is_a($val, 'CURLFile')) {
            $val = json_encode($val);
        }
    }

    $url    = $API_URL . $method;
    $handle = curl_init($url);

    curl_setopt_array($handle, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_POSTFIELDS => $parameters
    ));

    return exe_cute_Curl_Request($handle);
}




function sendMessage($chatId, $text, $keyboard = false, $messageId = false) {
    $parameters = array(
        'chat_id' => $chatId,
        'text' => $text,
    );
    if ($keyboard) {
        $parameters['reply_markup'] = $keyboard;
    }

    if ($messageId) {
        $parameters['reply_to_message_id'] = $messageId;
    }

    return bot('sendMessage', $parameters);
}

//start bot private 
if (isset($update['message']) && $chat_type == "private") {
    if (in_array($text, ['/start', 'start'])) {
        sendMessage($from_id, "hi - Download  project :  github.com/ayhan-dev/Anit-spam");
    }
}






if (isset($update['message']) and $chat_type == "supergroup") {
if($update['message']['new_chat_title']   or 
   $update['message']['new_chat_photo']   or 
   $update['message']['new_chat_member']  or 
   $update['message']['left_chat_member'] or 
   $update['message']['pinned_message']   or
   $update['message']['kick_member']      or
   $update['message']['photo']            or
   $update['message']['video']            or
   $update['message']['sticker']          or
   $update['message']['video_note']       or
   $update['message']['forward_from']     or
   $update['message']['animation']){
 bot('deletemessage',[
                   'chat_id'    => $update['message']['chat']['id'],
                   'message_id' => $update['message']['message_id'] 
    ]);
}


if(isset($update['message']['new_chat_member'])){ 
    bot('kickChatMember', [
                   'chat_id'    => $chat_id,
                   'user_id'    => $update['message']['new_chat_member']['id'],
                   'until_date' => time() + (32 * 24 * 60 * 60)
        ]);
}}


if ($update['message']['new_chat_member']['id'] == $id){
    bot('setChatPermissions', [
            'chat_id'                       => $update['message']['chat']['id'],
            'permissions'                   => json_encode([
                'can_send_messages'         => true,
                'can_post_messages'         => true,
                'can_add_web_page_previews' => false,
                'can_send_other_messages'   => false,
                'can_send_media_messages'   => false,
                'can_change_info'           => false,
                'can_pin_messages'          => false,
                'can_invite_users'          => false
            ])
    ]);
}



 //checkSpamStatus($userId,$chat);
