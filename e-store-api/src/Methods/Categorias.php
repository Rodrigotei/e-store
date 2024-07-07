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
    public function insertCategory($category, $img){
        $sql = $this->pdo->prepare('INSERT INTO `categorias` (`categoria`, `imagem`) VALUES (?, ?)');
        $sql->execute(array($category, $img));
        return true;
    }
    public function deleteCat($idDelete){
        $sql = $this->pdo->prepare('DELETE FROM `categorias` WHERE `id` = ?');
        $sql->execute(array($idDelete));
        return true;
    }
    public function editCategory($nameCategory, $id){
        $sql = $this->pdo->prepare('UPDATE `categorias` SET `categoria` = ? WHERE `id` = ?');
        $sql->execute(array($nameCategory, $id));
        return true;
    }
    public function     updateCategoryImage($nameCategory, $nameImgCategory, $id){
        $sql = $this->pdo->prepare('UPDATE `categorias` SET `categoria` = ?, `imagem` = ? WHERE `id` = ?');
        $sql->execute(array($nameCategory, $nameImgCategory, $id));
        return true;
    }
}