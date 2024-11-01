<?php

namespace Model;

class Customer extends Model {
    protected $table = "customer";

    public function __construct()
    {
        parent::__construct();
    }

    public function getByChatId($chatId) {
        $prepare = [
            ":chat_id" => $chatId,
        ];

        return $this->execOne("SELECT * FROM `" . $this->table . "` WHERE `chat_id`=':chat_id' LIMIT 1", $prepare);
    }
}