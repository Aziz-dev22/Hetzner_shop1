<?php

class Telegram
{
    private string $token;
    private string $api;

    public function __construct(string $token)
    {
        $this->token = $token;
        $this->api = "https://api.telegram.org/bot{$token}/";
    }

    private function request(string $method, array $params = [])
    {
        $ch = curl_init();

        curl_setopt_array($ch,[
            CURLOPT_URL=>$this->api.$method,
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_POST=>true,
            CURLOPT_POSTFIELDS=>$params,
            CURLOPT_CONNECTTIMEOUT=>10,
            CURLOPT_TIMEOUT=>30
        ]);

        $result=curl_exec($ch);

        if(curl_errno($ch)){
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        return json_decode($result,true);
    }

    public function sendMessage($chat,$text,$keyboard=null,$mode=null)
    {
        return $this->request("sendMessage",[
            "chat_id"=>$chat,
            "text"=>$text,
            "parse_mode"=>$mode,
            "reply_markup"=>$keyboard
        ]);
    }

    public function editMessage($chat,$message,$text,$keyboard=null)
    {
        return $this->request("editMessageText",[
            "chat_id"=>$chat,
            "message_id"=>$message,
            "text"=>$text,
            "reply_markup"=>$keyboard
        ]);
    }

    public function deleteMessage($chat,$message)
    {
        return $this->request("deleteMessage",[
            "chat_id"=>$chat,
            "message_id"=>$message
        ]);
    }

    public function answerCallback($id,$text="")
    {
        return $this->request("answerCallbackQuery",[
            "callback_query_id"=>$id,
            "text"=>$text
        ]);
    }

    public function setWebhook($url)
    {
        return $this->request("setWebhook",[
            "url"=>$url
        ]);
    }

    public function getWebhookInfo()
    {
        return $this->request("getWebhookInfo");
    }
}
