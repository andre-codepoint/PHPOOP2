<?php

namespace Database;

use \Config\Config;

class MysqlConnect implements Connectable {

    private $connect;

    public function __construct(){
        $config = Config::getDatabase();

        $this->connect = mysqli_connect($config["host"], $config["username"],
            $config["password"], $config["database"], $config["port"]);

        if(mysqli_connect_error()){
            throw new Exception("Failed mysql connect.");
        }

        mysqli_set_charset($this->connect, $config["charset"]);
    }

    public function exec($sql, $prepare = []){
        $result = [];

        foreach($prepare as $key => $value) {

            $sql = str_replace($key, $this->prepare($value), $sql);
        }

        $rows = mysqli_query($this->connect, $sql);

        if(!is_bool($rows) && $rows !== 1){
            for(;$row = mysqli_fetch_assoc($rows);) {
                $result[] = $row;
            }
            mysqli_free_result($rows);
        }else{
            $result = $rows;
        }
        mysqli_more_results($this->connect);
        mysqli_use_result($this->connect);

        return $result;
    }

    public function execOne($sql, $prepare = []){
        $result = $this->exec($sql, $prepare);

        if(!isset($result[0])) {
            return null;
        }

        return $result[0];
    }

    public function prepare($value){
        return mysqli_real_escape_string($this->connect, trim($value));
    }

    public function getLastId(){
        return mysqli_insert_id($this->connect);
    }

    public function close(){
        return mysqli_close($this->connect);
    }
}