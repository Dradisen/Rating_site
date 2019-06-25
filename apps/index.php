<?php
require_once "core/view.php";
require_once "core/model.php";
require_once "core/controller.php";
require_once "core/route.php";

function dump($obj){
    echo "<pre>";
    print_r($obj);
    echo "</pre>";
}

Route::start();

?>