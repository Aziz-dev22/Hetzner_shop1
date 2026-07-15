<?php

require_once __DIR__.'/config/config.php';

require_once __DIR__.'/classes/Telegram.php';
require_once __DIR__.'/classes/Database.php';
require_once __DIR__.'/classes/Hetzner.php';
require_once __DIR__.'/classes/Logger.php';


$telegram = new Telegram(BOT_TOKEN);

$db = Database::getInstance();

$hetzner = new Hetzner(
    HETZNER_TOKEN
);

$logger = new Logger();



$update = json_decode(
    file_get_contents("php://input"),
    true
);



if(!$update){

    exit;

}



try {


    if(isset($update['message'])){


        $chat_id =
            $update['message']['chat']['id'];


        $text =
            $update['message']['text'] ?? '';



        $logger->telegram(
            "New message",
            [
                'user'=>$chat_id,
                'text'=>$text
            ]
        );



        if($text == "/start"){


            $telegram->sendMessage(
                $chat_id,
                "👋 به ربات Hetzner Shop خوش آمدید."
            );


        }



    }



    if(isset($update['callback_query'])){


        $callback =
            $update['callback_query'];


        $chat_id =
            $callback['from']['id'];


        $data =
            $callback['data'];



        $telegram->answerCallback(
            $callback['id']
        );



        $logger->telegram(
            "Callback",
            [
                'user'=>$chat_id,
                'data'=>$data
            ]
        );


    }



}
catch(Exception $e){


    $logger->error(
        $e->getMessage()
    );


}
