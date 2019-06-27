<?php

//Контроллер основного приложения сайта
class Controller_apps extends Controller{

    public $model_workers = null;
    public $model_ratings = null;

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
        
        for($i = 1; $i <= 12; $i++){
            $data['ratings'][] = $this->model_ratings->get_data((int)"20".date('y'), $i)->all();
        }
        
        return  $this->view->render('','main.php', $data);
    }
}

?>