<?php

class View{

    public function render($content_view, $template_view, $data=null){

        include $_SERVER['DOCUMENT_ROOT']."/apps/views/".$template_view;
    
    }
}


?>