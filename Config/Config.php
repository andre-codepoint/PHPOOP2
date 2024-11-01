<?php

namespace Config;

class Config {

    private function __construct()
    {
    }

    public static function getDatabase() {
        return [
            "class" => "\\Database\\MysqlConnect",
            "host" => "localhost",
            "database" => "it_cluster",
            "port" => 3306,
            "username" => "u_it_cluster",
            "password" => "8TrsAcJo",
            "charset" => "utf8mb4",
        ];
    }

    public function getTelegramRoutes() {
        return  [
            [
                "command" => "start",
                "controller" => "\\Controller\\CommandController",
                "action" => "start",
                "params" => "",
            ],[
                "command" => "get/bills",
                "controller" => "\\Controller\\CommandController",
                "action" => "getBills",
                "params" => "",
            ],[
                "command" => "create/bill",
                "controller" => "\\Controller\\CommandController",
                "action" => "createBill",
                "params" => "",
            ],[
                "command" => "transfer",
                "controller" => "\\Controller\\CommandController",
                "action" => "transfer",
                "params" => "",
            ],
        ];
    }

    public static function getRoutes() {
        return [
            "GET" => [
              [
                  "uri" => "",
                  "controller" => "\\Controller\\HomeController",
                  "action" => "index",
                  "params" => "",
              ], [
                    "uri" => "auth/telegram",
                    "controller" => "\\Controller\\CustomerController",
                    "action" => "auth",
                    "params" => "",
                ], [
                    "uri" => "logout",
                    "controller" => "\\Controller\\CustomerController",
                    "action" => "logout",
                    "params" => "",
                ], [
                    "uri" => "cabinet",
                    "controller" => "\\Controller\\CabinetController",
                    "action" => "index",
                    "params" => "",
                ], [
                    "uri" => "webhook/telegram",
                    "controller" => "\\Controller\\TelegramController",
                    "action" => "index",
                    "params" => "",
                ],
            ],
            "POST" => [
                [
                    "uri" => "webhook/telegram",
                    "controller" => "\\Controller\\TelegramController",
                    "action" => "index",
                    "params" => "",
                ],
            ],
            "CONSOLE" => [
                [
                    "uri" => "remove/auth/innactive",
                    "controller" => "\\Controller\\ConsoleController",
                    "action" => "removeAuth",
                    "params" => "",
                ],
            ],
        ];
    }
}