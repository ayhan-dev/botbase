<?php
// https://github.com/ayhan-dev/bot_telegram_php

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

if (isset($message) and $chat_type == "supergroup") {
if($message['new_chat_title']   or 
   $message['new_chat_photo']   or 
   $message['new_chat_member']  or 
   $message['left_chat_member'] or 
   $message['pinned_message']   or
   $message['kick_member']      or
   $message['photo']            or
   $message['video']            or
   $message['sticker']          or
   $message['video_note']       or
   $message['forward_from']     or
   $message['animation']){
  $api->deleteMessag(array('chat_id'    => $message['chat']['id'],'message_id' => $message['message_id']));
}


if(isset($message['new_chat_member'])){ 
    $api->kickChatMember(array(
                   'chat_id'    => $chat_id,
                   'user_id'    => $message['new_chat_member']['id'],
                   'until_date' => time() + (32 * 24 * 60 * 60)
    ));
}}


if ($message['new_chat_member']['id'] == $id){
    $api->setChatPermissions(array(
            'chat_id'                       => $message['chat']['id'],
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
    ));
}
