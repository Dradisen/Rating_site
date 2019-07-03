<?php

//Модель админки
class Model_Admin extends Model{

    //Пойск юзера в бд
    function getUser($name, $password){
        $name = strip_tags($name);
        
        $STH = $this->DBH->prepare("SELECT * FROM users WHERE name= :name");
        $STH->execute(array('name'=> $name));

        if($row = $STH->fetch(PDO::FETCH_LAZY)){
            $pswd = hash('sha256', $password);
            if(($row['name']==$name)&&($row['password']==$pswd)){
                $_SESSION['user'] = $name;
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    function addUser($data){
        $arr = array(
            'name'=>(string)$data['name'],
            'privilege'=>1,
            'password'=> hash('sha256', $data['password'])
        );

        $STH = $this->DBH->prepare("INSERT INTO users(name, privilege, password)
                                    VALUES(:name, :privilege, :password)");
        $result = $STH->execute($arr);

        return $result ? true : false;
    }

    function registrate($data){
        $STH = $this->DBH->prepare("SELECT * FROM users");
        $STH->execute();

        $count = $STH->rowCount();

        if($count){
            return false;
        }

        return $this->addUser($data);
        

    }

}
require_once "ratings_model.php";
require_once "workers_model.php";
?>