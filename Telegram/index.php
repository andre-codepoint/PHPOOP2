<?php
const TOKEN = '7914669752:AAGTXIEqPbnCNydYE1YqSFLw0pIZCFQsh7Y';
$url = 'https://api.telegram.org/bot' . TOKEN . '/getUpdates';
$response=json_decode(file_get_contents($url), JSON_OBJECT_AS_ARRAY);
if ($response['ok']) {
    foreach ($response['result'] as $update) {
        echo  $update['message']['text']."\n";
    }
    }
#var_dump($response);