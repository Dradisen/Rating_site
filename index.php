<?php

//Запускаем setting натсройки
if(file_exists('setting/setting_prod.php')){
   $setting = include_once('setting/setting_prod.php');
}else if(file_exists('setting/setting_dev.php')){
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $setting = include_once('setting/setting_dev.php');
}

$route = explode('?', $_SERVER['REQUEST_URI']);

//Роутинг основных приложений. 
$url_pattern = array(
    'admin' => "admin/index.php",
    '.*'=> 'apps/index.php',
);


//Запускаем роутинг
$search_url = false;
foreach($url_pattern as $key => $val){
    if(preg_match("@^/".$key."[/]{0,1}@i", $route[0], $matches)){
        $search_url = true;
        include_once $val;
        break;
    }
}

?>