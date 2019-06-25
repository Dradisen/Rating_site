<?php

class Model{
    
    public $DBH = null;
    public $queries = null;

    public function get_data(){}

    function __construct(){
        $host = $GLOBALS['setting']['host'];
        $database = $GLOBALS['setting']['db'];
        $user = $GLOBALS['setting']['user'];
        $password = $GLOBALS['setting']['password'];

        $this->connect($host, $database, $user, $password);
    }
    
    function connect($host, $db, $name, $pass){
        try{
            $dsn = "mysql:host=$host; dbname=$db; charset=UTF8";
            $this->DBH = new PDO($dsn, $name, $pass);
            //var_dump("connect", $this->DBH);
        }catch(PDOException $e){
            dump( $e->getMessage() );
        }
    }
}

/*
Класс для удобного вывода запросов.
*/

class QueryObjects{
    private $data = null;
    private $pointer = null;

    public function __construct($data){
        $this->data = $data;
        $this->pointer = 0;
    }

    //возвращает данные текущей строки 
    public function fetch(){
        if($this->pointer < count($this->data)){        
            return $this->data[$this->pointer++];
        }
    }

    //возвращает кол-во строк
    public function count(){
        return count($this->data);
    }

    //возвращает "указатель" на начало.
    public function reset_pointer(){
        $this->pointer = 0;
    }
}

?>