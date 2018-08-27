<?php 

function __autoload($class_name){
    include "includes/" . $class_name . ".php";
}

if($_GET["c"] == "get"){
    $inv = DbHandler::select_cmd(['table' => 'invoice',
                                  'col' => ['id'],
                                  'val' => [1],
                                  'type' => "equal"]); 
    echo json_encode($inv);
}else{
    DbHandler::update_cmd(['table' => 'invoice',
                           'col' => ["inv"],
                           'val' => [$_GET["c"]],
                           'wherecol' => ['id'],
                           'whereval' => [1]]);
}
?>