<?php
/**
 * Created by PhpStorm.
 * User: Leon
 * Date: 2017-11-25
 * Time: 9:30 PM
 */
//http://culttt.com/2012/10/01/roll-your-own-pdo-php-class/ explains a lot of this


class DB
{
    private $host = 'localhost';
    private $db = 'forget_it';
    private $user = 'Leon';
    private $pass = '';
    private $charset = 'utf8mb4';

    private $conn;
    private $error;
    private $sql;

    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,];
        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass, $opt);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function query($query){
        $this->sql = $this->conn->prepare($query);
    }

    public function bind($param, $value, $type = null){
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->sql->PDO::bindValue($param, $value, $type);
    }

    public function execute(){
        return $this->sql->PDO::execute();
    }

    public function single(){
        $this->execute();
        return $this->sql->PDO::fetch(PDO::FETCH_ASSOC);
    }

    public function result_set(){
        $this->execute();
        return $this->sql->PDO::fetchAll(PDO::FETCH_ASSOC);
    }

}