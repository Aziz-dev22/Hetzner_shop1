<?php

class Hetzner
{
    private string $token;
    private string $api = "https://api.hetzner.cloud/v1";

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    private function request(string $method, string $endpoint, array $data = [])
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->api . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->token}",
                "Content-Type: application/json"
            ]
        ]);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }

        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return [
            'status' => $http,
            'body' => json_decode($response, true)
        ];
    }

    public function create($name,$type,$image,$location)
    {
        return $this->request("POST","/servers",[
            "name"=>$name,
            "server_type"=>$type,
            "image"=>$image,
            "location"=>$location
        ]);
    }

    public function delete($id)
    {
        return $this->request("DELETE","/servers/$id");
    }

    public function list()
    {
        return $this->request("GET","/servers");
    }

    public function info($id)
    {
        return $this->request("GET","/servers/$id");
    }

    public function powerOn($id)
    {
        return $this->request("POST","/servers/$id/actions/poweron");
    }

    public function powerOff($id)
    {
        return $this->request("POST","/servers/$id/actions/poweroff");
    }

    public function rebuild($id,$image="ubuntu-22.04")
    {
        return $this->request("POST","/servers/$id/actions/rebuild",[
            "image"=>$image
        ]);
    }

    public function resetPassword($id)
    {
        return $this->request("POST","/servers/$id/actions/reset_password");
    }
}
