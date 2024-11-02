<?php

namespace Controller;

use \Config\Consts;

class AuthController extends Controller {
    protected $customer;

    protected $customerAuth;

    public function __construct()
    {
        parent::__construct();

        $this->loadModel("Customer", "customer_model");
        $this->loadModel("Auth", "auth_model");

        $this->customer = null;

        if(isset($_COOKIE["auth_token"])) {
            $this->customerAuth = $this->auth_model->getByToken($_COOKIE["auth_token"]);

            if($this->customerAuth !== null) {
                $this->customer = $this->customer_model->getById($this->customerAuth["customer_id"]);

                $date = (new \DateTime("now"))->modify("+" . Consts::TOKEN_EXPIRES_SECONDS . " SECONDS");

                $this->auth_model->update($this->customerAuth["id"], [
                    "date_expires" => $date->format("Y-m-d H:i:s"),
                ]);
            }
        }
    }
}