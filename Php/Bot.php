<?php

include 'lib.php';

$token = "6195507430:AAEQAVfqacaizHINgCYkVGPEQ5MQWJ_tuR8";

try {
    class las_bot extends Bot {
        const TOKEN = $token;

        public function onUpdate($update) {
            $text = $update['message']['text'];
            if ($text === "/start") {
                $this->sendMessage([
                    'chat_id' => $update['message']['chat']['id'],
                    'text' => 'hi my bibi :) @ayhan_dev',
                ]);
            }
        }
    }

    $bot = new las_bot($token);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
