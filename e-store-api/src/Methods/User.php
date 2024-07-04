<?php
namespace Api\Methods;

class User extends ConnectionDB
{
    public function selectUserLogin($user, $pass){
        $sql = $this->pdo->prepare('SELECT * FROM `users` WHERE `user` = ? AND `password` = ?');
        $sql->execute(array($user, $pass));
        if($sql->rowCount() > 0){
            return true;
        }
        return false;
    }
    //=========================================================================================================
                                            //CRIAR CLIENT
    //=========================================================================================================
    public function selectClient($idClient){
        $this->deleteClient();
        $sql = $this->pdo->prepare('SELECT * FROM `clients` WHERE `id_client` = ?');
        $sql->execute(array($idClient));
        $select = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $select;
    }
    public function selectAllClients(){
        $sql = $this->pdo->prepare('SELECT * FROM `clients`');
        $sql->execute();
        return $sql->rowCount();
    }
    public function createClient($idClient){
        $data = date('Y-m-d');
        $sql = $this->pdo->prepare('INSERT INTO `clients` (id_client, `date`) VALUES (?, ?) ');
        $sql->execute(array($idClient, $data));
        return true;
    }
    public function deleteClient() {
        try{
            $sql = $this->pdo->prepare('DELETE FROM `clients` WHERE `date` < DATE_SUB(CURDATE(), INTERVAL 1 MONTH)');
            $sql->execute();
            return true;
        }catch(\PDOException){
            return false;
        }
    }    
}