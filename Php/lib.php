<?php
class bot {
    private $__token;
    public function __construct($token = null, $admin = null, $text = null) {
        @system("clear");
        if (!file_exists(".offset")) {
            file_put_contents(".offset", 0);
        }
        $connected = @fsockopen("www.google.com", 80);
        if (!$connected) {
            throw new Exception("\033[0;31m"."Error To Connect "."\033[1;32m"."api.telegram.org");
            fclose($connected);
            exit;
        } else {
            if (is_null($token)) {
                $this->__token = readline($color->brown."input bot token : "."\033[1;32m");
            } else {
                $this->__token = $token;
                if (!is_null($admin)) {
                    $this->sendMessage([
                        'chat_id' => $admin,
                        'text' => $text,
                        'parse_mode' => 'html'
                    ]);
                }
            }
            while (true) {
                $offset = file_get_contents(".offset");
                @$update = $this->did('getUpdates', [
                    "offset" => $offset,
                    "limit" => 100,
                    "timeout" => 0
                ])["result"];
                try {
                    foreach ($update as $fromServer) {
                        $update_id = $fromServer["update_id"];
                        file_put_contents('.offset', $update_id +1);
                        $this->onUpdate($fromServer);
                    }
                }catch(Exception $e) {}
            }
        }
    }
    
    public function did($method, $data = []) { 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot".$this->__token."/$method"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
        $exec = curl_exec($ch); 
        $exec = json_decode($exec, true); 
        if ($exec['ok'] == false) { 
            throw new Exception("\033[0;31mAPI : ".$exec['error_code']." ".$exec['description']); 
        } else { 
            return $exec; 
        } 
    }


    
    public function forwardMessage($data = []) {
        return $this->did("forwardMessage", $data);
    }
    public function sendMessage($data = []) {
        return $this->did("sendMessage", $data);
    }
    public function sendPhoto($data = []) {
        return $this->did("sendPhoto", $data);
    }
    public function sendAudio($data = []) {
        return $this->did("sendAudio", $data);
    }
    public function sendVoice($data = []) {
        return $this->did("sendVoice", $data);
    }public function sendPoll($data = []) {
    return $this->did("sendPoll", $data);
}
public function sendLocation($data = []) {
    return $this->did("sendLocation", $data);
}
public function editMessageText($data = []) {
    return $this->did("editMessageText", $data);
}public function editMessageCaption($data = []) {
    return $this->did("editMessageCaption", $data);
}
public function editMessageReplyMarkup($data = []) {
    return $this->did("editMessageReplyMarkup", $data);
}
public function sendDocument($data = []) {
    return $this->did("sendDocument", $data);
}
public function sendContact($data = []) {
    return $this->did("sendContact", $data);
}
public function sendSticker($data = []) {
    return $this->did("sendSticker", $data);
}
public function sendAnimation($data = []) {
    return $this->did("sendAnimation", $data);
}
public function sendVenue($data = []) {
    return $this->did("sendVenue", $data);
}
public function sendDice($data = []) {
    return $this->did("sendDice", $data);
}
public function sendChatAction($data = []) {
    return $this->did("sendChatAction", $data);
}
public function getFile($data = []) {
    return $this->did("getFile", $data);
}
public function sendMediaGroup($data = []) {
    return $this->did("sendMediaGroup", $data);
}
public function sendVideoNote($data = []) {
    return $this->did("sendVideoNote", $data);
}
public function sendInvoice($data = []) {
    return $this->did("sendInvoice", $data);
}
public function sendGame($data = []) {
    return $this->did("sendGame", $data);
}

public function sendVenue($data = []) {
    return $this->did("sendVenue", $data);
}




}
