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
    public function insertProduct($nameProduct, $descProduct, $priceProduct, $nameImgProduct, $idCategory){
        $sql = $this->pdo->prepare('INSERT INTO `produtos` (`nome`, `descricao`, `preco`, `img`, `id_categoria`) VALUES (?,?,?,?,?)');
        $sql->execute(array($nameProduct, $descProduct, $priceProduct, $nameImgProduct, $idCategory));
        return true;
    }
    public function deleteProd($idDelete){
        $sql = $this->pdo->prepare('DELETE FROM `produtos` WHERE `id` = ?');
        $sql->execute(array($idDelete));
        return true;
    }
    public function editProduct($name,$desc, $price, $id){
        $sql = $this->pdo->prepare('UPDATE `produtos` SET `nome` = ?, `descricao` = ?, `preco` = ? WHERE `id` = ?');
        $sql->execute(array($name,$desc, $price, $id));
        return true;
    }
    public function  editProductImg($name,$desc, $price, $img,$id){
        $sql = $this->pdo->prepare('UPDATE `produtos` SET `nome` = ?, `descricao` = ?, `preco` = ?, `img` = ? WHERE `id` = ?');
        $sql->execute(array($name,$desc, $price, $img, $id));
        return true;
    }
}