<?php

class PaymentManager
{

    private Database $db;
    private UserManager $users;
    private Logger $logger;


    public function __construct(
        Database $db,
        UserManager $users,
        Logger $logger
    ){

        $this->db = $db;
        $this->users = $users;
        $this->logger = $logger;

    }



    public function create(
        $userId,
        $amount,
        $method,
        $currency=null
    ){

        $orderId =
            strtoupper(
                uniqid("PAY-")
            );


        $this->db->insert(
            "payments",
            [

                "order_id"=>$orderId,

                "user_id"=>$userId,

                "amount"=>$amount,

                "method"=>$method,

                "currency"=>$currency,

                "status"=>"pending"

            ]
        );



        $this->logger->info(
            "Payment created",
            [
                "user"=>$userId,
                "order"=>$orderId
            ]
        );


        return $orderId;

    }





    public function submitTx(
        $orderId,
        $txid
    ){

        return $this->db->update(
            "payments",
            [

                "txid"=>$txid

            ],
            [

                "order_id"=>$orderId

            ]
        );

    }





    public function get(
        $orderId
    ){

        $result =
            $this->db->query(
                "SELECT * FROM payments WHERE order_id=?",
                [
                    $orderId
                ]
            );


        return $result->fetch_assoc();

    }





    public function approve(
        $orderId
    ){

        $payment =
            $this->get($orderId);



        if(!$payment){

            return false;

        }



        if($payment['status']=="paid"){

            return false;

        }



        $this->db->update(
            "payments",
            [
                "status"=>"paid"
            ],
            [
                "order_id"=>$orderId
            ]
        );



        $this->users->addBalance(
            $payment['user_id'],
            $payment['amount']
        );



        $this->logger->info(
            "Payment approved",
            [
                "order"=>$orderId
            ]
        );


        return true;

    }




    public function reject(
        $orderId
    ){

        return $this->db->update(
            "payments",
            [
                "status"=>"rejected"
            ],
            [
                "order_id"=>$orderId
            ]
        );

    }



}
