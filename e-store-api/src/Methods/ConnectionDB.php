<?php
namespace Api\Methods;

class ConnectionDB
{
    protected $pdo;
    public function __construct()
    {
        try {
            $this->pdo = new \PDO('mysql:host=localhost; dbname='.DBNAME,DBUSER,DBPASS);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("set names utf8");
        } catch (\PDOException $e) {
            echo 'Erro de conexão: ' . $e->getMessage();
            die();
        }
    }
}