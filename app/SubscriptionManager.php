<?php

class SubscriptionManager
{

    private Database $db;
    private ServerManager $servers;
    private Logger $logger;


    public function __construct(
        Database $db,
        ServerManager $servers,
        Logger $logger
    ){

        $this->db = $db;
        $this->servers = $servers;
        $this->logger = $logger;

    }



    public function add(
        $userId,
        $serverId,
        $days,
        $price
    ){

        $expire =
            date(
                "Y-m-d H:i:s",
                strtotime("+".$days." days")
            );


        return $this->db->insert(
            "subscriptions",
            [

                "user_id"=>$userId,

                "server_id"=>$serverId,

                "expire_at"=>$expire,

                "price"=>$price,

                "status"=>"active"

            ]
        );

    }





    public function checkExpired()
    {


        $result =
        $this->db->query(
            "
            SELECT *
            FROM subscriptions
            WHERE expire_at < NOW()
            AND status='active'
            "
        );



        while(
            $row=$result->fetch_assoc()
        ){

            $this->servers->powerOff(
                $row['server_id']
            );


            $this->db->update(
                "subscriptions",
                [
                    "status"=>"expired"
                ],
                [
                    "id"=>$row['id']
                ]
            );



            $this->logger->info(
                "Server expired",
                [
                    "server"=>$row['server_id']
                ]
            );

        }

    }





    public function getRemaining(
        $serverId
    ){

        $result =
        $this->db->query(
            "
            SELECT expire_at
            FROM subscriptions
            WHERE server_id=?
            ",
            [
                $serverId
            ]
        );


        return $result->fetch_assoc();

    }


}
