<?php 

namespace Api\Methods;

class Produtos extends ConnectionDB
{
    public function selectAllProducts(){
        $sql = $this->pdo->prepare('SELECT * FROM `produtos`');
        $sql->execute();
        $select = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $select;
    }
    public function selectProdutc($id){
        $sql = $this->pdo->prepare('SELECT * FROM `produtos` WHERE `id` = ?');
        $sql->execute(array($id));
        $select = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $select;
    }
    public function selectLastProdutc(){
        $sql = $this->pdo->prepare('SELECT * FROM `produtos` ORDER BY `id` DESC LIMIT 6 ');
        $sql->execute();
        $select = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $select;
    }
    public function selectImgProduct($id){
        $sql = $this->pdo->prepare('SELECT * FROM `fotos_produto` WHERE `id_produto` = ?');
        $sql->execute(array($id));
        $select = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $select;
    }
}