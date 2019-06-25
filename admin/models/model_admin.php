<?php

class Model_Admin extends Model{

    function getUser($name, $password){
        $name = strip_tags($name);
        
        $STH = $this->DBH->prepare("SELECT * FROM users WHERE name= :name");
        $STH->execute(array('name'=> $name));

        if($row = $STH->fetch(PDO::FETCH_LAZY)){
            $pswd = hash('sha256', $password);
            if(($row['name']==$name)&&($row['password']==$pswd)){
                $_SESSION['user'] = "admin";
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
require_once "ratings_model.php";
require_once "workers_model.php";
?>