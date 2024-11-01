<?php

namespace Model;

abstract class Model {
    private $connect;

    protected $table;

    public function __construct()
    {
    }

    public function setConnect($connect) {
        $this->connect = $connect;
    }

    public function exec($sql, $prepare = []) {
        return $this->connect->exec($sql, $prepare);
    }

    public function execOne($sql, $prepare = []) {
        return $this->connect->execOne($sql, $prepare);
    }

    public function getAll() {
        return $this->connect->exec("SELECT * FROM `" . $this->table . "`");
    }

    public function getById($id) {
        $prepare = [
            ":id" => (int)$id,
        ];

        return $this->connect->execOne("SELECT * FROM `" . $this->table . "` WHERE `id`=':id' LIMIT 1", $prepare);
    }

    public function create($data) {
        $fields = "";
        $values = "";

        foreach($data as $key => $value) {
            $fields .= "`" . $key . "`,";
            $values .= "'" . $this->connect->prepare($value) . "',";
        }

        $fields = substr($fields, 0, -1);
        $values = substr($values, 0, -1);

        $this->connect->exec("INSERT INTO `" . $this->table . "`(" . $fields .") VALUES (" . $values . ")");
        return (int)$this->connect->getLastId();
    }

    public function update($id, $data) {
        $prepare = [
            ":id" => (int)$id,
        ];

        $sql = "";

        foreach($data as $field => $value) {
            $sql .= "`" . $field . "`=':" . $field . "',";

            $prepare[":" . $field] = $value;
        }

        $sql = substr($sql, 0, -1);

        $this->connect->exec("UPDATE `" . $this->table . "` SET " . $sql . " WHERE `id`=':id' LIMIT 1", $prepare);
    }

    public function remove($id) {
        $prepare = [
            ":id" => (int)$id,
        ];

        $this->connect->exec("DELETE FROM `" . $this->table . "` WHERE `id`=':id' LIMIT 1", $prepare);
    }
}