<?php
namespace Api\Methods;

class Categorias extends ConnectionDB
{
    public function selectCategorias(){
        $sql = $this->pdo->prepare('SELECT * FROM `categorias`');
        $sql->execute();
        $select = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $select;
    }
    public function selectProdutosCat($id){
        $sql = $this->pdo->prepare('SELECT * FROM `produtos` WHERE `id_categoria` = ?');
        $sql->execute(array($id));
        $select = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $select;
    }
}