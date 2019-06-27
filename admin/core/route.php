<?php

//Роутер админки
class Route{

    static function start(){

        //Основные адреса ["Вызывающий контроллер" => "Адрес"]
        $url_pattern = array(
            "index" => "admin",
            "workers" => "admin/workers",
            "workers_add" => "admin/workers/add",
            "workers_edit" => "admin/workers/edit/(?P<id>[0-9]+)",
            "workers_delete" => "admin/workers/delete/(?P<id>[0-9+]+)",
            "rating" => "admin/rating",
            "rating_add" => "admin/rating/add",
            "rating_api" => "admin/rating/api",
            "rating_edit" => "admin/rating/edit/(?P<id>[0-9]+)",
            "rating_delete" => "admin/rating/delete/(?P<id>[0-9]+)",
            "login" => "admin/login",
            "logout" => "admin/logout",
        );

        //Имя приложения(имя контроллера) и основной вызывающий его контроллер
        $controller_name = "Admin";
        $action_name = "index";
        $routes = explode('?', $_SERVER['REQUEST_URI']);

        //Старт роутинга
        $search_url = false;
        foreach($url_pattern as $key => $val){
            if(preg_match("@^/".$val."[/]{0,1}$@i", $routes[0], $matches)){
                $search_url = true;
                $action_name = $key;
                break;
            }
        }

        if(!$search_url){
            Route::ErrorPage404();
            exit();
        }
        
        $model_name = "Model_".$controller_name;
        $controller_name = "Controller_".$controller_name;
        $action_name = "action_".$action_name;

        
        $model_file = strtolower($model_name).".php";
        $model_path = $_SERVER['DOCUMENT_ROOT']."/admin/models/".$model_file;
        
        if( file_exists($model_path) ){
            include $model_path;
        }

        $controller_file = strtolower($controller_name).".php";
        $controller_path = $_SERVER['DOCUMENT_ROOT'].
                            "/admin/controllers/".$controller_file;

        if( file_exists($controller_path) ){
            include $controller_path;
        }else{
            Route::ErrorPage404();
            exit();
        }

        
        $controller = new $controller_name;
        $action = $action_name;
        
        
        if( method_exists($controller, $action) ){
            try{
                $controller->$action($matches);
            }catch(Exception $e){
                Route::ErrorPage404();
            }
        }else{
            Route::ErrorPage404();
            exit();
        }

    }

    function ErrorPage404(){
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404.php');
    }
}

?>