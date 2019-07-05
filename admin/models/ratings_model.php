<?php
class Model_Ratings extends Model{

    //Основные данные рейтинга с местами
    function get_data($year=null, $month=null){

        $where_option = "ORDER BY date DESC, rating DESC";

        if($year == null){

        }else if($year && ($month == null)){
            if($year >= 2000 && $year <= (int)"20".date('y')){
                $where_option = "WHERE YEAR(date) = '$year' ORDER BY date DESC,rating DESC";
            }else{
                return NULL;
            }
        }else if($year != null && $month != null){
            if(($year >= 2000 && $year <= (int)"20".date('y')) && ($month >= 1 && $month <= 12)){
                $where_option = "WHERE YEAR(date) = '$year' AND MONTH(date)='$month' 
                                ORDER BY date DESC, rating DESC";
            }else{
                return NULL;
            }
        }

        $query = "SELECT id, worker, rating, MONTH(date) as month, YEAR(date) as year
                FROM ratings ".$where_option;
        $result = $this->DBH->query($query);


        $return_array = [];
        $i = 0;
        $num_place = 0;
        $temp_month = null;
        $rating = null;
        while($row = $result->fetch()){
            if($row['month'] != $temp_month){
                $num_place = 0;
                $rating = null;
            }
            if($rating != $row['rating']){
                $num_place++;
            }
            $row['place'] = $num_place;
            $rating = $row['rating'];
            $temp_month = $row['month'];
            $return_array[$i] = $row;
            $i++;
        }
        $this->queries = $return_array;
        return $this;
    }

    //Запрос рейтинга за последний существующий месяц в бд.
    function get_data_last_month(){
        $query = "SELECT *, MONTH(date) as month FROM ratings ORDER BY date DESC, rating DESC";
        $STH = $this->DBH->prepare($query);
        $STH->execute();

        $row = $STH->fetch();
        $month = $row['month'];

        $query = "SELECT *, MONTH(date) as month, YEAR(date) as year 
                  FROM ratings 
                  WHERE MONTH(date)='$month'
                  ORDER BY date DESC, rating DESC";
        
        $result = $this->DBH->query($query);

        $return_array = [];
        $i = 0;
        $num_place = 0;
        $temp_month = null;
        $rating = null;
        while($row = $result->fetch()){
            if($row['month'] != $temp_month){
                $num_place = 0;
                $rating = null;
            }
            if($rating != $row['rating']){
                $num_place++;
            }
            $row['place'] = $num_place;
            $rating = $row['rating'];
            $temp_month = $row['month'];
            $return_array[$i] = $row;
            $i++;
        }
        $this->queries = $return_array;

        return $this;
    }

    //Запрос рейтинга первых трёх победителей.
    function filter_top_place(){
        $place = 0;
        $result = [];
        $names = [];
        $j = 0;
        for($i = 0; $i < count($this->queries); $i++){
            
            if($place != $this->queries[$i]['place']){
                if($place == 3){ break; }
                $names = [];
                $names[] =  $this->queries[$i]['worker'];
                $result[$j]['place'] = $this->queries[$i]['place'];
                $result[$j]['rating'] = $this->queries[$i]['rating'];
                $result[$j]['names'] = $names;
                $place++;
            }else if($place == $this->queries[$i]['place']){
                $names[] =  $this->queries[$i]['worker'];
                $result[--$j]['names'] = $names;
            
            }
            $j++;
        }
        
        return new QueryObjects($result);

    }

    //Основные данные рейтинга
    function get_id($id = null){
        $where_option = "";
        $arr = null;
        if($id){ 
            $where_option = " WHERE id= :id"; $arr = array('id'=> (int)$id);
        }

        $STH = $this->DBH->prepare("SELECT id, worker, rating, 
                                                YEAR(date) as year,
                                                MONTH(date) as month
                                            FROM ratings".$where_option);
        $STH->execute($arr);
        $this->queries = $STH->fetchAll();
        return $this;
    }

    //Создание рейтинга
    function create($data){
        $date_year = (int)$data['date_year'];
        $date_month = (int)$data['date_month'];
        $rating = (int)$data['rating'];
        $worker_id = (int)$data['worker_id'];

        $date = "".$date_year."-".$date_month."-"."01";

        $row = $this->DBH->query("SELECT * FROM workers WHERE id='$worker_id'")->fetch();

        $STH = $this->DBH->prepare(
            "INSERT INTO ratings(fk, worker, date, rating)
            VALUES(:fk, :worker, :date, :rating)"
        );

        $result = $STH->execute(array(
            'fk'=> $worker_id,
            'worker'=> $row['worker'],
            'date'=> $date,
            'rating'=> $rating
        ));

        return ($result) ? true : false;

    }

    //Редактирование рейтинга
    function edit($data){
        $fk= (int)$data['id'];
        $date_year = (int)$data['date_year'];
        $date_month = (int)$data['date_month'];
        $rating = (int)$data['rating'];

        $date = "".$date_year."-".$date_month."-"."01";

        $STH = $this->DBH->prepare("UPDATE ratings 
                                    SET date=:date, rating=:rating
                                    WHERE id=:id");
        $result = $STH->execute(array('id'=> $fk, 'rating'=>$rating, 'date'=>$date ));

        return ($result) ? true : false;
    }

    //Подсчет среднего рейтинга за всё время.
    function avg_rating(){
        $STH = $this->DBH->prepare("SELECT AVG(rating) as avg FROM ratings");
        $STH->execute();
        
        return (int)$STH->fetch()['avg'];
    }

    function avg_rating_last_month(){
        $STH = $this->DBH->prepare("SELECT MONTH(date) as month, YEAR(date) as year
                                    FROM ratings ORDER BY date DESC");
        $STH->execute();
        $row = $STH->fetch();

        $month = $row['month'];
        $year = $row['year'];

        $STH = $this->DBH->prepare("SELECT AVG(rating) as avg FROM ratings
                                    WHERE MONTH(date)=$month AND YEAR(date)=$year");
        $STH->execute();
        $row = $STH->fetch();
        return $row['avg'];
    }

    //Удаление рейтинга.
    function delete($id){
        $STH = $this->DBH->prepare("DELETE FROM ratings WHERE id= :id");
        $result = $STH->execute(array('id'=> (int)$id));
        return ($result) ? true : false;
    }

    //Вывод данных
    function all(){
        return new QueryObjects($this->queries);
    }

}

?>