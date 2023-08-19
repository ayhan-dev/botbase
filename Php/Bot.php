<?php

error_reporting(0);
define('API_KEY','6175:AA*****');
$API_URL   = 'https://api.telegram.org/bot'.API_KEY. '/';

$update = json_decode(file_get_contents("php://input"),true);

    $message    = $update['message'];
    $from_id    = $update['message']['from']['id'];
    $chat_id    = $update['message']['chat']['id'];
    $chat_type  = $update['message']['chat']['type'];
    $text       = $message['text'];
    $first_name = $update['message']['from']['first_name'];
    $message_id = $update['message']['message_id'];

function exec_curl_request($handle){
    $response = curl_exec($handle);
    if ($response === false) {
        $errno = curl_errno($handle);
        $error = curl_error($handle);
        error_log("Curl returned error $errno: $error\n");
        curl_close($handle);
        return false;
    }
    $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
    curl_close($handle);
    if ($http_code >= 500) {
        sleep(10);
        return false;
    } elseif ($http_code != 200) {
        $response = json_decode($response, true);
        error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
        if ($http_code == 401) {
            throw new Exception('Invalid access token provided');
        }
        return false;
    } else {
        $response = json_decode($response, true);
        if (isset($response['description'])) {
            error_log("Request was successfull: {$response['description']}\n");
        }
        $response = $response['result'];
    }
    return $response;
}

function bot($method, $parameters){
    global $API_URL;
    if (!is_string($method)) {
        error_log("Method name must be a string\n");
        return false;
    }
    if (!$parameters) {
        $parameters = array();
    } elseif (!is_array($parameters)) {
        error_log("Parameters must be an array\n");
        return false;
    }
    foreach ($parameters as $key => &$val) {
        if (!is_numeric($val) && !is_string($val) && !is_a($val, 'CURLFile')) {
            $val = json_encode($val);
        }
    }
    $url = $API_URL . $method;
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $parameters);
    return exec_curl_request($handle);
}

function sendmessage($chat_id,$text,$keyboard = "false",$message_id = "false"){
   return bot('sendMessage',[
        'chat_id'       => $chat_id,
        'text'          => $text,
        'reply_markup'  => $keyboard,
        'message_id'    => $message_id,
        'disable_web_page_preview' => true,
        'parse_mode'    =>'MarkDown'
    ]);
}

if(isset($update['message']) and $chat_type == "private"){

    if ($text == '/start'){
    sendmessage ($from_id,"hi ayhan - @Ayhan_dev");
}
}
