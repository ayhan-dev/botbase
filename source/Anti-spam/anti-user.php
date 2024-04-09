<?php

error_reporting(0);
include "telegram.php";

$api = new Telegram("6179391015");

if (!is_file('URL.log')){ 
    $api->setHook('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    file_put_contents('URL.log',"OK"); 
}

$message     = $api->message();
$text        = $api->Text();
$from_id     = $api->message()['from']['id'];
$chat_id     = $api->message()['chat']['id'];
$chat_type   = $$api->message()['chat']['type'];
$message_id  = $api->message()['message_id'];


if (isset($message) && $chat_type == "private") {
    if (in_array($text, ['/start', 'start'])) {
        $api->sendMessage(array('chat_id' =>$from_id, 'text' =>"HI {$from_id} | @Ayhan_Dev"));
    }
}

if ($text == "/list" or preg_match('/^list (.*)/i', $text, $us)) {
    $ids = $reply_id ?? $us[1]; 
    $sta = $api->getChatMember(array('chat_id'=>$chat_id,'user_id'=>$from_id)['result']['status']);

if($sta == 'creator' or $sta == 'administrator'){
    file_put_contents("list.txt", $ids . "\n", FILE_APPEND);
    sendMessage($chat_id, "ok");
}} 

if (!$text) {
    $file = file_get_contents("list.txt");
    $from = explode("\n", $file);
    foreach ($from as $idl) {
        if ($from_id == $idl) {
             $api->deleteMessag(array('chat_id'    => $message['chat']['id'],'message_id' => $message['message_id']));
        }
    }
}
