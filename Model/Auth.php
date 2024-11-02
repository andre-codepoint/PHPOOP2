<?php

namespace Model;

class Auth extends Model {
    protected $table = "customer_auth";

    public function __construct()
    {
        parent::__construct();
    }

    public function getByToken($token) {
        $prepare = [
            ":token" => $token,
        ];

        $date = (new \DateTime("now"))->format("Y-m-d H:i:s");

        return $this->execOne("SELECT * FROM `" . $this->table . "` WHERE `token`=':token' AND `date_expires`>'" . $date . "' LIMIT 1", $prepare);
    }

    public function removeAllInnactive() {
        $date = (new \DateTime("now"))->format("Y-m-d H:i:s");

        $this->exec("DELETE FROM `" . $this->table . "` WHERE `date_expires` < " . $date);
    }
}