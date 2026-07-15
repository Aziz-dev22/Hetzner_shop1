<?php

class UserManager
{

    private $db;


    public function __construct(Database $database)
    {
        $this->db = $database;
    }



    public function exists($userId)
    {

        $result = $this->db->query(
            "SELECT user_id FROM users WHERE user_id=?",
            [$userId]
        );


        return $result->num_rows > 0;

    }




    public function create($userId)
    {

        if($this->exists($userId)){

            return false;

        }


        return $this->db->insert(
            "users",
            [
                "user_id"=>$userId,
                "step"=>"none",
                "coin"=>0
            ]
        );

    }




    public function get($userId)
    {

        $result=$this->db->query(
            "SELECT * FROM users WHERE user_id=?",
            [$userId]
        );


        return $result->fetch_assoc();

    }




    public function setStep(
        $userId,
        $step
    )
    {

        return $this->db->update(
            "users",
            [
                "step"=>$step
            ],
            [
                "user_id"=>$userId
            ]
        );

    }





    public function getStep($userId)
    {

        $user=$this->get($userId);


        return $user['step'] ?? null;

    }





    public function getBalance($userId)
    {

        $user=$this->get($userId);


        return $user['coin'] ?? 0;

    }





    public function addBalance(
        $userId,
        $amount
    )
    {

        $balance=$this->getBalance($userId);


        return $this->db->update(
            "users",
            [
                "coin"=>$balance+$amount
            ],
            [
                "user_id"=>$userId
            ]
        );

    }





    public function removeBalance(
        $userId,
        $amount
    )
    {

        $balance=$this->getBalance($userId);


        if($balance < $amount){

            return false;

        }


        return $this->db->update(
            "users",
            [
                "coin"=>$balance-$amount
            ],
            [
                "user_id"=>$userId
            ]
        );

    }



}
