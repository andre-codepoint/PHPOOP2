<?php

namespace newcode\database;

// https://core.telegram.org/bot/setwebhooks
// https://core.telegram.org/bots/webhooks
// https://core.telegram.org/bots/api

//
// 7066245101:AAEwlOAiTbwmSG4GDPHqmoyMmDlDAgTdW9U @itcluster_test_bot
// <script async src="https://telegram.org/js/telegram-widget.js?22" data-telegram-login="itcluster_test_bot" data-size="large" data-auth-url="it-cluster.evgeniychvertkov.com/auth/telegram/" data-request-access="write"></script>
// https://core.telegram.org/widgets/login

/*
 *
https://api.telegram.org/bot7066245101:AAEwlOAiTbwmSG4GDPHqmoyMmDlDAgTdW9U/getWebhookInfo
https://api.telegram.org/bot7066245101:AAEwlOAiTbwmSG4GDPHqmoyMmDlDAgTdW9U/setWebhook?url=https://it-cluster.evgeniychvertkov.com/webhook/telegram/

function sendMessage($message, $chatId, $token)
{
    $curl = curl_init("https://api.telegram.org/bot" . $token .
        "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&parse_mode=HTML");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    $result = json_decode(curl_exec($curl), true);
    curl_close($curl);

    return (int)$result["result"]["message_id"];
}

function sendButton($button, $chatId, $token)
{
    $button["chat_id"] = $chatId;

    $curl = curl_init("https://api.telegram.org/bot" . $token . "/sendMessage?parse_mode=HTML");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $button);
    $result = json_decode(curl_exec($curl), true);
    curl_close($curl);

    return (int)$result["result"]["message_id"];
}

$button = [
    "text" => "button",
    "reply_markup" => json_encode([
        "keyboard" => [
            [
                [
                    "text" => "btn",
                    "callback_data" => "url",
                ],
            ],
        ],
        'one_time_keyboard' => true,
        'resize_keyboard' => true,
    ], JSON_UNESCAPED_UNICODE),
];



CREATE

private $token = "utu2H42BW7aL4QfX91b0v7K1CkoyGQTbEiKyvm1xybO8";
private $host = "https://api.monobank.ua";
$data = [
"amount" => $amount * 100,
"ccy" => (int)$currency["ccy"],
"merchantPaymInfo" => [
"reference" => $externalId . "-" . $invoiceId . "-" . $date,
"destination" => $consultTariff["description_payment"] . ": № " . $invoiceId. " (" . $consultTariff["title"] . ")",
"customerEmails" => ["billing@evgeniychvertkov.com"],
],
"redirectUrl" => "https://it-cluster.evgeniychvertkov.com/billing/monobank/success/?invoice=" . $invoiceId,
"webHookUrl" => "https://it-cluster.evgeniychvertkov.com/billing/monobank/webhook/?invoice=" . $invoiceId,
"paymentType" => $billingType["alias"],
"saveCardData" => [
"saveCard" => false,
],
];

$header = [
"Content-Type: application/json",
"X-Token: " . $this->token,
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $this->host . "/api/merchant/invoice/create");

curl_setopt($curl, CURLOPT_UPLOAD, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

$result = json_decode(curl_exec($curl), true);
curl_close($curl);
isset($result["pageUrl"]) && isset($result["invoiceId"])

WEBHOOK
public function webhook() {
$bodyMonobank = file_get_contents("php://input");

$log = [
"datetime" => (new \DateTime("now"))->format("Y-m-d H:i:s"),
"action" => "webhook",
"get" => $_GET,
"post" => $_POST,
"header" => getallheaders(),
"input" => $bodyMonobank,
];

file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/log/monobank.log",json_encode($log) . "\n", FILE_APPEND);

$headers = getallheaders();
foreach($headers as $key => $value) {
$headers[mb_strtolower($key)] = $value;
}

if(!isset($headers["x-sign"])) {
exit();
}

$publicKey = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/cache/mono.pk");

$signature = base64_decode($headers["x-sign"]);
$publicKey = openssl_get_publickey(base64_decode($publicKey));
$isVerify = openssl_verify($bodyMonobank, $signature, $publicKey, OPENSSL_ALGO_SHA256);

if($isVerify !== 1) {
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $this->host . "/api/merchant/pubkey");

$header = [
"X-Token: " . $this->token,
];

curl_setopt($curl, CURLOPT_UPLOAD, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

$publicKey = curl_exec($curl);
curl_close($curl);

file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/cache/mono.pk", $publicKey);
}

$publicKey = openssl_get_publickey(base64_decode($publicKey));
$isVerify = openssl_verify($bodyMonobank, $signature, $publicKey, OPENSSL_ALGO_SHA256);

if($isVerify !== 1) {
exit();
}

$data = json_decode($bodyMonobank, true);

if($data["status"] === "success") {

$reference = explode("-", $data["reference"]);

$payment = $this->billing->getPaymentByInvoiceNumber($reference[1]);
if($payment === null) {
exit();
}

$data["finalAmount"]
}
}

*/
