<?php
//Базовый класс представления
class View{

    public function render($content_view, $template_view, $data=null){
        include $_SERVER['DOCUMENT_ROOT']."/admin/views/".$template_view;
    }
}


?>