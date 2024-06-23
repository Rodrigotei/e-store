<?php
namespace Api\Methods;

use PDOException;

class carrinho extends ConnectionDB
{
    public function obterCarrinho($user){
        $sql = $this->pdo->prepare('SELECT * FROM `carrinho` WHERE `user` = ?');
        $sql->execute(array($user));
        $select = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $select;
    }
    public function obterQuantidadeCarrinho($user){
        $deleteCart = $this->deleteCartAbandoned();
        if($deleteCart == true){
            $sql = $this->pdo->prepare('SELECT * FROM `carrinho` WHERE `user` = ?');
            $sql->execute(array($user));
            $select = $sql->fetchAll(\PDO::FETCH_ASSOC);
            return count($select);
        }
    }
    public function selecionarProdutoInd($idProduto, $user){
        $sql = $this->pdo->prepare('SELECT * FROM `carrinho` WHERE `user` = ? AND `id_produto` = ?');
        $sql->execute(array($user, $idProduto));
        $select = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $select;
    }
    public function addCart($idProduct, $qtdProduct,$idUser,$date){
        try{
            $sql = $this->pdo->prepare('INSERT INTO `carrinho` (`id_produto`, `qtd`, `user`, `date`) VALUES (?,?,?,?)');
            $sql->execute(array($idProduct, $qtdProduct, $idUser,$date));
            return true;
        }catch(PDOException){
            return false;
        }
    }
    public function updateQtdProduct($idProduto, $user){
        try{
            $sql = $this->pdo->prepare('UPDATE `carrinho` SET `qtd` = `qtd` + 1 WHERE `id_produto` = ? AND `user` = ?');
            $sql->execute(array($idProduto, $user));
            return true;
        }catch(PDOException){
            return false;
        }
    }
    public function decreaseQtd($idProduto, $user){
        try{
            $sql = $this->pdo->prepare('UPDATE `carrinho` SET `qtd` = `qtd` - 1 WHERE `id_produto` = ? AND `user` = ?');
            $sql->execute(array($idProduto, $user));
            return true;
        }catch(PDOException){
            return false;
        }
    }
    public function deleteProduct($idProduto, $user){
        try{
            $sql = $this->pdo->prepare('DELETE FROM `carrinho` WHERE `id_produto` = ? AND `user` = ?');
            $sql->execute(array($idProduto, $user));
            return true;
        }catch(PDOException){
            return false;
        }
    } 
    public function deleteCartAbandoned() {
        try{
            $sql = $this->pdo->prepare('DELETE FROM `carrinho` WHERE `date` < CURDATE()');
            $sql->execute();
            return true;
        }catch(PDOException){
            return false;
        }
    }    
}

