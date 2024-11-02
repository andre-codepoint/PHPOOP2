<?php

namespace Controller;

use \Database\Connect;

abstract class Controller {

    private $data;

    public function __construct()
    {
        $this->data = [];
    }

    protected function loadModel($title, $alias = "") {
        if($alias === "") {
            $alias = $title;
        }

        $className = "\\Model\\" . $title;

        $this->{$alias} = new $className();
        $this->{$alias}->setConnect(Connect::getInstance());
    }

    protected function data($variable, $data) {
        $this->data[$variable] = $data;
    }

    protected function display($title) {
        foreach($this->data as $variable => $data) {
            $$variable = $data;
        }

        include_once($_SERVER["DOCUMENT_ROOT"] . "/View/" . $title . ".php");
    }
}