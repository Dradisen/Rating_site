<?php
header("Content-Type: application/json; charset=utf-8", true);
while($row = $data['json']->fetch()){
    $d[] = $row;
}

echo json_encode($d, JSON_UNESCAPED_UNICODE);
?>