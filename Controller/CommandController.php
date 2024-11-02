<?php

namespace Controller;

use \Config\Consts;
use \Helper\TelegramHelper;

class CommandController extends Controller {

    private $chatId;

    public function __construct($chatId)
    {
        parent::__construct();

        $this->chatId = $chatId;
    }

    public function start() {
        $gets = [
            "text" => Consts::TELEGRAM_WELCOME_INIT,
            "chat_id" => $this->chatId,
        ];

        $body = [
            "reply_markup" => json_encode([
                "inline_keyboard" => [
                    [
                        [
                            "text" => "My bills",
                            "callback_data" => "/get/bills",
                        ],
                    ],[
                        [
                            "text" => "Create Bill",
                            "callback_data" => "/create/bill",
                        ],
                    ],[
                        [
                            "text" => "Transfer",
                            "callback_data" => "/transfer",
                        ],
                    ],
                ],
                'one_time_keyboard' => true,
                'resize_keyboard' => true,
            ], JSON_UNESCAPED_UNICODE),
        ];

        TelegramHelper::send("sendMessage", $gets, $body);
    }

    public function getBills() {
        $gets = [
            "text" => "This is get bills",
            "chat_id" => $this->chatId,
        ];

        TelegramHelper::send("sendMessage", $gets);
    }

    public function createBill() {
        $gets = [
            "text" => "This is create bills",
            "chat_id" => $this->chatId,
        ];

        TelegramHelper::send("sendMessage", $gets);
    }

    public function transfer() {
        $gets = [
            "text" => "This is transfer",
            "chat_id" => $this->chatId,
        ];

        TelegramHelper::send("sendMessage", $gets);
    }
}