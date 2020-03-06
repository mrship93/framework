<?php


namespace vendor\core;


use mysql_xdevapi\Exception;

class Db
{
    private $pdo;
    private static $instanse;
    public static $countSql = 0;
    public static $queries = [];

    private function __construct()
    {
        $db = require ROOT . '/config/config_db.php';
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];
        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass'], $options);
    }
    public static function instanse() {
        if (self::$instanse === null) {
            self::$instanse = new self;
        }
        return self::$instanse;
    }

    public function execute($sql) {
        self::$countSql++;
        self::$queriee[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    public function query($sql, $params = []) {
        self::$countSql++;
        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute($params);
        if($res !== false) {
            return $stmt->fetchAll();
        }
        //return [];
        throw new \Exception("errorReturn");
    }

}