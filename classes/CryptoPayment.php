<?php

class CryptoPayment
{

    private string $usdtAddress;
    private string $trxAddress;


    public function __construct()
    {

        $this->usdtAddress =
            USDT_BEP20_ADDRESS;


        $this->trxAddress =
            TRX_ADDRESS;

    }



    public function create(
        $userId,
        $amount,
        $currency
    )
    {

        $orderId =
            "CRYPTO-".$userId."-".time();



        if($currency=="USDT"){

            return [

                "order_id"=>$orderId,

                "currency"=>"USDT BEP20",

                "network"=>"BEP20",

                "amount"=>$amount,

                "address"=>$this->usdtAddress

            ];

        }



        if($currency=="TRX"){

            return [

                "order_id"=>$orderId,

                "currency"=>"TRX",

                "network"=>"TRON",

                "amount"=>$amount,

                "address"=>$this->trxAddress

            ];

        }



        return false;

    }



}
