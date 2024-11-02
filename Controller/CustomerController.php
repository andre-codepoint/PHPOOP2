<?php

namespace Controller;

use \Config\Consts;

class CustomerController extends AuthController {
    public function __construct()
    {
        parent::__construct();
    }
    /*
    https://it-cluster.evgeniychvertkov.com/auth/telegram/?id=432524795&first_name=Sky&last_name=Tree%20%F0%9F%98%8E&username=skytree2024&photo_url=https%3A%2F%2Ft.me%2Fi%2Fuserpic%2F320%2FXOW0jIlTyAQgjnC0yRLlss6UPSu7fZR1mlM0JoNAXnE.jpg&auth_date=1728919945&hash=552177a65f434a3ca04275f716e6ba90302133441a781fd33f9378e0eceba876
    */
    public function auth() {
        if(!isset($_GET["auth_date"]) || !isset($_GET["first_name"]) || !isset($_GET["id"])
            || !isset($_GET["username"]) || !isset($_GET["hash"])) {
            exit();
        }

        $hash = $_GET["hash"];

        unset($_GET["hash"]);

        $data = [];
        foreach ($_GET as $key => $value) {
            $data[] = $key . '=' . $value;
        }

        sort($data);

        $checkString = implode("\n", $data);

        $secretKey = hash('sha256', Consts::TELEGRAM_TOKEN, true);
        $hashGen = hash_hmac("sha256", $checkString, $secretKey);
        if ((strcmp($hashGen, $hash) !== 0) || ((time() - $_GET['auth_date']) > 86400)) {
            exit();
        }

        $customer = $this->customer_model->getByChatId($_GET["id"]);

        if($customer === null) {
            $this->customer_model->create([
                "firstname" => $_GET["firs_tname"],
                "lastname" => (isset($_GET["last_name"])) ? $_GET["last_name"] : "",
                "username" => $_GET["username"],
                "chat_id" => $_GET["id"],
            ]);

            $customer = $this->customer_model->getByChatId($_GET["id"]);
        }

        $authToken = base64_encode(hash_hmac("sha256", md5(time() . $customer["id"]), $customer["id"], $customer["id"]));

        $date = (new \DateTime("now"))->modify("+" . Consts::TOKEN_EXPIRES_SECONDS . " SECONDS");

        $auth = null;

        if(isset($_COOKIE["auth_token"]) && (int)$customer["id"] === (int)$this->customer["id"]) {
            $auth = $this->auth_model->getByToken($_COOKIE["auth_token"]);
        }

        if($auth === null || !isset($_COOKIE["auth_token"])) {
            $this->auth_model->create([
                "customer_id" => (int)$customer["id"],
                "token" => $authToken,
                "date_expires" => $date->format("Y-m-d H:i:s"),
            ]);

            $auth = $this->auth_model->getByToken($authToken);
        }

        $this->auth_model->update($auth["id"], [
            "date_expires" => $date->format("Y-m-d H:i:s"),
        ]);

        setcookie("auth_token", $authToken, $date->getTimestamp(), "/");

        header("HTTP/1.1 301 Moved Permanently");
        header("Location: /cabinet/");
    }

    public function logout() {
        if($this->customer !== null) {
            $this->auth_model->remove($this->customerAuth["id"]);
        }

        header("HTTP/1.1 301 Moved Permanently");
        header("Location: /");
    }
}