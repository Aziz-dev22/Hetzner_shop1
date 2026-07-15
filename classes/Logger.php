<?php

class Logger
{

    private string $file;


    public function __construct()
    {

        $dir = __DIR__ . '/../storage/logs';


        if(!is_dir($dir)){

            mkdir(
                $dir,
                0755,
                true
            );

        }


        $this->file =
            $dir . '/app.log';

    }



    public function write(
        string $type,
        string $message,
        array $data = []
    )
    {

        $log = [
            'time'=>date('Y-m-d H:i:s'),
            'type'=>$type,
            'message'=>$message,
            'data'=>$data
        ];


        file_put_contents(
            $this->file,
            json_encode(
                $log,
                JSON_UNESCAPED_UNICODE
            )
            . PHP_EOL,
            FILE_APPEND
        );

    }



    public function info(
        string $message,
        array $data=[]
    )
    {

        $this->write(
            'INFO',
            $message,
            $data
        );

    }



    public function error(
        string $message,
        array $data=[]
    )
    {

        $this->write(
            'ERROR',
            $message,
            $data
        );

    }



    public function telegram(
        string $message,
        array $data=[]
    )
    {

        $this->write(
            'TELEGRAM',
            $message,
            $data
        );

    }



    public function hetzner(
        string $message,
        array $data=[]
    )
    {

        $this->write(
            'HETZNER',
            $message,
            $data
        );

    }

}
