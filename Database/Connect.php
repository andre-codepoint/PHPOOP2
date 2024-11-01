<?php

namespace Database;

use \Config\Config;

class Connect {

    private static $connect;

    public static function getInstance() {
        if(self::$connect === null) {
            $className = Config::getDatabase()["class"];
            self::$connect = new $className();
        }

        return self::$connect;
    }
}