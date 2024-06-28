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
}