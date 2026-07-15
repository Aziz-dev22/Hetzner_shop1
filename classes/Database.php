<?php

class Database
{
    private static ?Database $instance = null;

    private mysqli $connection;


    private function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {

            $this->connection = new mysqli(
                DB_HOST,
                DB_USER,
                DB_PASS,
                DB_NAME
            );

            $this->connection->set_charset("utf8mb4");


        } catch (Exception $e) {

            throw new Exception(
                "Database connection failed"
            );

        }
    }


    public static function getInstance(): Database
    {
        if(self::$instance === null){

            self::$instance = new Database();

        }

        return self::$instance;
    }


    public function getConnection(): mysqli
    {
        return $this->connection;
    }


    public function query(
        string $sql,
        array $params = []
    ){

        $stmt = $this->connection->prepare($sql);


        if(!empty($params)){

            $types = "";

            foreach($params as $param){

                $types .= is_int($param)
                    ? "i"
                    : "s";

            }


            $stmt->bind_param(
                $types,
                ...$params
            );

        }


        $stmt->execute();


        return $stmt->get_result();

    }


    public function insert(
        string $table,
        array $data
    ){

        $columns = implode(
            ",",
            array_keys($data)
        );


        $placeholders = implode(
            ",",
            array_fill(
                0,
                count($data),
                "?"
            )
        );


        $sql="
        INSERT INTO {$table}
        ({$columns})
        VALUES
        ({$placeholders})
        ";


        $stmt=$this->connection->prepare($sql);


        $values=array_values($data);


        $types=str_repeat(
            "s",
            count($values)
        );


        $stmt->bind_param(
            $types,
            ...$values
        );


        $stmt->execute();


        return $this->connection->insert_id;

    }


    public function update(
        string $table,
        array $data,
        array $where
    ){

        $set=[];


        foreach($data as $key=>$value){

            $set[]="$key=?";

        }


        $condition=[];


        foreach($where as $key=>$value){

            $condition[]="$key=?";

        }


        $sql="
        UPDATE {$table}
        SET ".implode(",",$set)."
        WHERE ".implode(" AND ",$condition);


        $stmt=$this->connection->prepare($sql);


        $values=array_merge(
            array_values($data),
            array_values($where)
        );


        $types=str_repeat(
            "s",
            count($values)
        );


        $stmt->bind_param(
            $types,
            ...$values
        );


        $stmt->execute();


        return $stmt->affected_rows;

    }


}
