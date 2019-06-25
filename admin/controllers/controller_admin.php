<?php

//Контроллер админки.
class Controller_admin extends Controller{
    
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

    function __construct(){
        $this->model = new Model_Admin();
        $this->model_workers = new Model_Workers();
        $this->model_ratings = new Model_ratings();
        $this->view = new View();
    }

    //Главный контроллер входа
    function action_index(){
        $this->isAuth();
        return Header("Location: /admin/workers");
    }

    function action_workers(){
        $this->isAuth();

        
        $data['js_source'] = array(
            "<script src='/static/js/modal_window.js'></script>",
        );
        $data['workers'] = $this->model_workers->get_data()->all();
        $data['ratings'] = $this->model_ratings->get_data_last_month()->all();
        $data['places'] = $this->model_ratings->get_data_last_month()->filter_top_place();
        $data['avg'] = $this->model_ratings->avg_rating();
        $data['months'] = $this->months;

        return $this->view->render('workers.php','base_template.php', $data); 
    }

    function action_workers_add($url_data){
        $this->isAuth();

        if(isset($_POST['name'], $_POST['position'])&&
                ($_POST['name']&&$_POST['position'])!=""){

            $data = array(
                'name'=> $_POST['name'],
                'position'=>$_POST['position'],
            );

            $result = $this->model_workers->create($data);
            $data['query'] = ($result) ? true : false;
            return $this->view->render('workers_add.php', 'base_template.php', $data);
        }
        return $this->view->render('workers_add.php', 'base_template.php');
    }

    function action_workers_edit($url_data){
        $this->isAuth();

        $data['css_source'] = array(
            "<link href='/static/css/style.css' rel='stylesheet'>"
        );
        $data['js_source'] = array(
            "<script src='https://cdn.jsdelivr.net/npm/vue'></script>",
            '<script src="/static/js/vue/workers_edit.js"></script>'
        );

        if(isset($_POST['name'], $_POST['position'])&&
                ($_POST['name']&&$_POST['position'])!=""){
    
            $data = array(
                'id'=> $url_data['id'],
                'name'=> $_POST['name'],
                'position'=>$_POST['position'],
            );

            $result = $this->model_workers->edit($data);
            $data['query'] = ($result) ? true : false;
            return Header("Location: /admin/workers");
        }

        $data['worker'] = $this->model_workers->get_id($url_data['id'])->all();
        return $this->view->render('workers_edit.php', 'base_template.php', $data);
    }

    function action_workers_delete($url_data){
        $this->isAuth();

        if(isset($url_data['id'])){
            $this->model_workers->delete((int)$url_data['id']);
        }
        return Header("Location: /admin/workers");
    }


    function action_rating(){
        $this->isAuth();

        $data['rating'] = $this->model_ratings->get_data()->all();
        $data['months'] = $this->months;
        
        $data['css_source'] = array(
            "<link href='/static/css/style.css' rel='stylesheet'>"
        );
        $data['js_source'] = array(
            "<script src='https://cdn.jsdelivr.net/npm/vue'></script>",
            "<script src='https://unpkg.com/axios/dist/axios.min.js'></script>",
            '<script src="/static/js/vue/rating.js"></script>'
        );
        return $this->view->render('rating.php','base_template.php', $data); 
    }

    function action_rating_edit($url_data){
        $this->isAuth();

        $data['css_source'] = array(
            "<link href='/static/css/style.css' rel='stylesheet'>"
        );
        $data['js_source'] = array(
            "<script src='https://cdn.jsdelivr.net/npm/vue'></script>",
            '<script src="/static/js/vue/rating_add.js"></script>'
        );
        $data['months'] = $this->months;
        
            if(isset($_POST['date_year'],
                $_POST['date_month'],$_POST['rating'],$_POST['worker_id'])&&
                ($_POST['date_year']&&
                $_POST['date_month']&&$_POST['rating']&&$_POST['worker_id']) != ""){

                $data_query = array(
                    'date_year' => $_POST['date_year'],
                    'date_month' => $_POST['date_month'],
                    'worker_id' => $_POST['worker_id'],
                    'rating' => $_POST['rating'],
                    'id'=>$url_data['id'],
                );
                $data['query_1'] = $this->model_ratings->edit($data_query);

                if(!$data['query_1']){
                    $data['rating'] = $this->model_ratings->get_id((int)$url_data['id'])->all();
                    return $this->view->render('rating_edit.php', 'base_template.php', $data);
                }else{
                    return Header('Location: /admin/rating');
                }
            }

        $data['rating'] = $this->model_ratings->get_id((int)$url_data['id'])->all();
        return $this->view->render('rating_edit.php', 'base_template.php', $data);
    }

    function action_rating_add($url_data){
        $this->isAuth();

        $data['css_source'] = array(
            "<link href='/static/css/style.css' rel='stylesheet'>"
        );
        $data['js_source'] = array(
            "<script src='https://cdn.jsdelivr.net/npm/vue'></script>",
            '<script src="/static/js/vue/rating_add.js"></script>'
        );
        $data['workers'] = $this->model_workers->get_data()->all();
        $data['months'] = $this->months;
        
        if(isset($_POST['date_year'],
                 $_POST['date_month'],$_POST['rating'],$_POST['worker_id'])&&
                 ($_POST['date_year']&&
                 $_POST['date_month']&&$_POST['rating']&&$_POST['worker_id']) != ""){

            $data_query = array(
                'date_year' => $_POST['date_year'],
                'date_month' => $_POST['date_month'],
                'worker_id' => $_POST['worker_id'],
                'rating' => $_POST['rating'],
            );

            $data['query'] = $this->model_ratings->create($data_query);
            
            return $this->view->render('rating_add.php', 'base_template.php', $data);
        }
        
        return $this->view->render('rating_add.php', 'base_template.php', $data);

    }

    function action_rating_api($url_data){
        $this->isAuth();

        $data['json'] = $this->model_ratings->get_data()->all();
        return $this->view->render('', 'api.php', $data);

    }

    function action_rating_delete($url_data){
        $this->isAuth();

        if(isset($url_data['id'])){
            $this->model_ratings->delete((int)$url_data['id']);
        }
        return Header("Location: /admin/rating");
    }


    function action_login(){

        if(isset($_POST['login'], $_POST['password'])){
            $name = $_POST['login'];
            $pass = $_POST['password'];

            if($this->model->getUser($name, $pass)){
               return Header("Location: /admin/workers");
            }
        }
        return $this->view->render('','login.php');
    }

    function action_logout(){
        unset($_SESSION['user']);
        return Header('Location: /admin');
    }

    function isAuth(){
        if($_SESSION['user'] == 'admin'){
            return true;
        }else{
            return Header("Location: /admin/login");
        }
    }

    function error_page(){
        return $this->view->render('404.php','base_template.php');
    }
}

?>