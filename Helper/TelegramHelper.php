<?php

namespace Helper;

use \Config\Consts;

class TelegramHelper {

    public static function send($method, $gets, $body = []) {
        $queries = http_build_query($gets);

        $curl = curl_init("https://api.telegram.org/bot" . Consts::TELEGRAM_TOKEN . "/" . $method . "?" . $queries);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");

        if(count($body) > 0) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        }

        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);

        return (int)$result["result"]["message_id"];
    }
}