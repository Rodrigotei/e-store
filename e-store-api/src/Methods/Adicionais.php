<?php
namespace Api\Methods;

class Adicionais extends ConnectionDB
{
    public function selectAdicionais($id){
        $sql = $this->pdo->prepare('SELECT * FROM `adicionais` WHERE `id_produto` = ?');
        $sql->execute(array($id));
        $select = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $select;
    }
    public function selectAllAdicionais(){
        $sql = $this->pdo->prepare('SELECT * FROM `adicionais`');
        $sql->execute();
        $select = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $select;
    }
}