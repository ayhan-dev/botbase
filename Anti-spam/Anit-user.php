<?php
error_reporting(0);
define('API_KEY','6');

$API_URL   = 'https://api.telegram.org/bot'.API_KEY. '/';
$update = json_decode(file_get_contents("php://input"),true);


if(isset($update['message'])){
    $text       = $update['message']['text'];
    
    $from_id    = $update['message']['from']['id'];
    $chat_id    = $update['message']['chat']['id'];
    
    $chat_type  = $update['message']['chat']['type'];
    $first_name = $update['message']['from']['first_name'];
    $message_id = $update['message']['message_id'];
    $reply_id   = $update['message']['reply_to_message']['from']['id'];
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


if (isset($update['message']) && $chat_type == "private") {
    if (in_array($text, ['/start', 'start'])) {
        sendMessage($from_id, "hi - https://github.com/ayhan-dev/Anit-spam/Anit-user.php");
    }
}




if ($text == "/list" or preg_match('/^list (.*)/i', $text, $us)) {
    $ids = $reply_id ?? $us[1]; 
$data = bot('getChatMember',[
    'chat_id'=>$chat_id,
    'user_id'=>$from_id]);
$sta = $data['result']['status'];
if($sta == 'creator' or $sta == 'administrator'){
    file_put_contents("list.txt", $ids . "\n", FILE_APPEND);
    sendMessage($chat_id, "ok");
}} 

if (!$update['message']['text']) {
    $file = file_get_contents("list.txt");
    $from = explode("\n", $file);
    
    foreach ($from as $idl) {
        if ($from_id == $idl) {
            bot('deletemessage', [
                'chat_id' => $update['message']['chat']['id'],
                'message_id' => $update['message']['message_id']
            ]);
        }
    }
}
