<?php

//Контроллер основного приложения сайта
class Controller_apps extends Controller{

    public $model_workers = null;
    public $model_ratings = null;

    public $months = array(
        1 => "Январь",
        2 => "Февраль",
        3 => "Март",
        4 => "Апрель",
        5 => "Май",
        6 => "Июнь",
        7 => "Июль",
        8 => "Август",
        9 => "Сентябрь",
        10 => "Октябрь",
        11 => "Ноябрь",
        12 => "Декабрь",
    );

//-----------------------------------------------------
    function __construct(){
        $this->model_workers = new Model_Workers();
        $this->model_ratings = new Model_ratings();
        $this->view = new View();
    }
//-----------------------------------------------------
//Главная страница.
    function action_index(){
        $data['workers'] = $this->model_workers->get_data()->all();
        $data['ratings_last_month'] = $this->model_ratings->get_data_last_month()->all();
        $data['month'] = $this->months;
        
        for($i = 1; $i <= 12; $i++){
            $data['ratings'][] = $this->model_ratings->get_data((int)"20".date('y'), $i)->all();
        }
        
        return  $this->view->render('','main.php', $data);
    }
}

?>