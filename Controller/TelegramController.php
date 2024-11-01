<?php

namespace Controller;

use \Config\Config;

class TelegramController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/logs/telegram.log", file_get_contents("php://input") . "\n", FILE_APPEND);

        $data = json_decode(file_get_contents("php://input"), true);
        if(json_last_error() !== JSON_ERROR_NONE) {
            //return;
        }

       //$data = json_decode('{"update_id":627521468,"callback_query":{"id":"1857679853414790783","from":{"id":432524795,"is_bot":false,"first_name":"Sky","last_name":"Tree \ud83d\ude0e","username":"skytree2024","language_code":"ru"},"message":{"message_id":110,"from":{"id":7066245101,"is_bot":true,"first_name":"itcluster_bot","username":"itcluster_test_bot"},"chat":{"id":432524795,"first_name":"Sky","last_name":"Tree \ud83d\ude0e","username":"skytree2024","type":"private"},"date":1730134434,"text":"Hello customer!","reply_markup":{"inline_keyboard":[[{"text":"My bills","callback_data":"/get/bills"}],[{"text":"Create Bill","callback_data":"/create/bill"}],[{"text":"Transfer","callback_data":"/transfer"}]]}},"chat_instance":"-7198161299411667515","data":"/get/bills"}}', true);
        $chatId = 0;
        $text = "";

        if(isset($data["message"]) && isset($data["message"]["chat"]) && isset($data["message"]["chat"]["id"])) {
            $chatId = (int)$data["message"]["chat"]["id"];
            $text = $data["message"]["text"];
        }

        if(isset($data["callback_query"]) && isset($data["callback_query"]["message"]) && isset($data["callback_query"]["message"]["chat"]) && isset($data["callback_query"]["message"]["chat"]["id"])) {
            $chatId = (int)$data["callback_query"]["message"]["chat"]["id"];
            $text = $data["callback_query"]["data"];
        }

        $text = trim($text, "/");

        if($text !== "" && $chatId !== 0) {
            $routes = Config::getTelegramRoutes();
            for ($i = 0, $count = count($routes); $i < $count; $i++) {
                if(preg_match("#^" . $routes[$i]["command"] . "$#", $text)){
                    if (!class_exists($routes[$i]["controller"], true)) {
                        continue;
                    }

                    $class = $routes[$i]["controller"];

                    $obj = new $class($chatId);

                    if (!method_exists($obj, $routes[$i]["action"])) {
                        continue;
                    }

                    $params = $routes[$i]["params"];

                    if(strpos($params, "$") !== false){
                        $params = preg_replace("#^" . $routes[$i]["command"] . "$#", $params, $text);
                        $params = explode("/", $params);
                    } else {
                        $params = [];
                    }

                    array_unshift($params, $text);

                    call_user_func_array([$obj, $routes[$i]["action"]], $params);
                }
            }
        }
    }
}