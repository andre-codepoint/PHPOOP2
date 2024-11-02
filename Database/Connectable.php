<?php

namespace Database;

interface Connectable {

    public function exec($sql);

    public function prepare($value);

    public function getLastId();

    public function close();
}