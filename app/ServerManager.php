<?php

class ServerManager
{

    private $hetzner;
    private $logger;


    public function __construct(
        Hetzner $hetzner,
        Logger $logger
    ){

        $this->hetzner = $hetzner;
        $this->logger  = $logger;

    }



    public function create(
        $userId,
        $type,
        $location,
        $image="ubuntu-22.04"
    ){

        $name =
            "user-".$userId."-".time();



        $result =
            $this->hetzner->create(
                $name,
                $type,
                $image,
                $location
            );


        $this->logger->hetzner(
            "Server created",
            [
                "user"=>$userId,
                "type"=>$type
            ]
        );


        return $result;

    }





    public function delete($serverId)
    {

        $result =
            $this->hetzner->delete(
                $serverId
            );


        $this->logger->hetzner(
            "Server deleted",
            [
                "id"=>$serverId
            ]
        );


        return $result;

    }





    public function list()
    {

        return
            $this->hetzner->list();

    }





    public function info($serverId)
    {

        return
            $this->hetzner->info(
                $serverId
            );

    }





    public function powerOn($serverId)
    {

        return
            $this->hetzner->powerOn(
                $serverId
            );

    }





    public function powerOff($serverId)
    {

        return
            $this->hetzner->powerOff(
                $serverId
            );

    }





    public function rebuild(
        $serverId,
        $image="ubuntu-22.04"
    )
    {

        return
            $this->hetzner->rebuild(
                $serverId,
                $image
            );

    }





    public function resetPassword($serverId)
    {

        return
            $this->hetzner->resetPassword(
                $serverId
            );

    }


}
