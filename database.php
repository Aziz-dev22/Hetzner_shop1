<?php

require_once __DIR__ . '/config.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {

    $db = new mysqli(
        DB_HOST,
        DB_USER,
        DB_PASS,
        DB_NAME
    );

    $db->set_charset("utf8mb4");

} catch (Exception $e) {

    die("Database Connection Failed.");

}

$db->query("
CREATE TABLE IF NOT EXISTS users(
    user_id BIGINT PRIMARY KEY,
    step VARCHAR(50) DEFAULT NULL,
    coin DECIMAL(15,2) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$euro = EURO_PRICE;
$api_key = HETZNER_TOKEN;

function update($table,$data,$where){

    global $db;

    $set=[];

    foreach($data as $key=>$value){

        $set[]="$key='". $db->real_escape_string($value)."'";

    }

    $whereSql=[];

    foreach($where as $key=>$value){

        $whereSql[]="$key='". $db->real_escape_string($value)."'";

    }

    $sql="UPDATE {$table} SET ".implode(',',$set)." WHERE ".implode(' AND ',$whereSql);

    $db->query($sql);

    return $db->affected_rows;

}

function insert($table,$data){

    global $db;

    $columns=array_keys($data);

    $values=array_map(function($v) use($db){

        return "'".$db->real_escape_string($v)."'";

    },array_values($data));

    $sql="INSERT INTO {$table}(".implode(',',$columns).") VALUES(".implode(',',$values).")";

    $db->query($sql);

    return $db->insert_id;

}
