<?php

namespace Controller;

class CabinetController extends AuthController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if($this->customer === null) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /");
            return;
        }

        $this->data("customer", $this->customer);

        $this->display("cabinet");
    }
}