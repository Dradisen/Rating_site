<?php
class Model_Workers extends Model{

    function get_data(){
        $STH = $this->DBH->prepare("SELECT * FROM workers");
        $STH->execute();
        $this->queries = $STH->fetchAll();
        return $this;
        
    }

    function get_id($id=null){
        $STH = $this->DBH->prepare("SELECT * FROM workers WHERE id=:id");
        $STH->execute(array('id'=> (int)$id));
        
        if(!$STH->rowCount()){
            throw new Exception("id not found");
        }

        $this->queries = $STH->fetchAll();
        return $this;
        
    }


    function create($data){
        $name = strip_tags($data['name']);
        $position = strip_tags($data['position']);

        $data_add = array(
            'name'=> $name,
            'position'=> $position,
        );

        $STH = $this->DBH->prepare("INSERT INTO workers(worker, position)
                                    VALUES(:name, :position)");
        $result = $STH->execute($data_add);

        return ($result) ? true : false;
    }

    function edit($data){

        $id = (int)$data['id'];
        $name = strip_tags($data['name']);
        $position = strip_tags($data['position']);

        $STH = $this->DBH->prepare("UPDATE workers 
                                    SET worker=:name , position=:position
                                    WHERE id=:id");
        $result = $STH->execute(array('id'=> $id, 'name'=> $name, 'position'=>$position));

        if(!$result){ return false; }

        $STH = $this->DBH->prepare("UPDATE ratings 
                                    SET worker=:name 
                                    WHERE fk=:id");
        $result = $STH->execute(array('id'=> $id, 'name'=> $name));

        return ($result) ? true : false;

    }

    function delete($id){
        $STH = $this->DBH->prepare("DELETE FROM workers WHERE id= :id");
        $result = $STH->execute(array('id'=> (int)$id));

        if(!$STH->rowCount()){
            throw new Exception("id not found");
        }
        return ($result) ? true : false;
    }


    function all(){
        return new QueryObjects($this->queries);
    }
}

?>