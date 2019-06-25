<?php

class Controller_apps extends Controller{

    public $model_workers = null;
    public $model_ratings = null;

    function __construct(){
        $this->model_workers = new Model_Workers();
        $this->model_ratings = new Model_ratings();
        $this->view = new View();
    }

    //Главная страница.
    function action_index(){
        $data['workers'] = $this->model_workers->get_data()->all();
        $data['ratings'] = $this->model_ratings->get_data_last_month()->all();
        return  $this->view->render('','main.php', $data);
    }
}

?>