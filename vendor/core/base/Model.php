<?php


namespace vendor\core\base;
use vendor\core\Db;

abstract class Model
{
    private $pdo;
    protected $table; //таблица из базы данных
    protected $pk = 'id'; //первичный ключ

    public function __construct()
    {
        $this->pdo = Db::instanse();
    }

    public function query($sql) {
        return $this->pdo->execute($sql);
    }

    public function findAll() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql);
    }

    public function findOne($id, $field = '') {
        $field = $field ?: $this->pk;
        $sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";
        return $this->pdo->query($sql, [$id]);
    }

    public function findBySql($sql, $params = []) {
        return $this->pdo->query($sql, $params);
    }

    public function findLike($string, $field, $table = ''){
        $table = $table ?: $this->table;
        $sql = "SELECT * FROM $table WHERE $field LIKE ?";
        return $this->pdo->query($sql, ['%' . $string . '%']);
    }
}