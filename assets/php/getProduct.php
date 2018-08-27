<?php

$arr = $_POST;
//print_r($arr);
$newarr = array();

function __autoload($class_name){
    include "includes/" . $class_name . ".php";
}

if(is_ajax_request()){
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        // POST
        errorCheker($arr);
        getPro($newarr);
    } else {
        // GET
        $readall = array();
        $readall = DbHandler::select_cmd(['table' => 'products']);
        echo json_encode($readall);
    }
    
}

function errorCheker($array){
    global $newarr;
    
    foreach($array as $key=>$value)
    {
        if($key == "product_name"){
        //$nkey = substr($key,0,4);
        //$vkey = substr($key,4,4);
        array_push($newarr, $key);
        }
        /*if($nkey == "name"){
            if(!empty($value)){
                $name = test_input($value);
                if(!preg_match("'/[^a-z_\-0-9]/i'", $name)){
                    $assoc = array('0' => 'error', '1' => 'Only letters, numbers and white spaces allowed in', '2' =>$key, '3'=>'last');
                    echo json_encode($assoc);
                    exit;
                }else{
                    array_push($newarr, $key);
                }
            }
        }*/
    }
}

function getPro($data){
    global $arr;
    $read = array();
    //print_r($data);
    if(!empty($data)){
        $col = array();
        $val = array();
        for($num = 0; $num < count($data); $num++){
            array_push($col, $data[$num]);
            array_push($val, $arr[$data[$num]]);
        }
        $read = DbHandler::select_cmd([
            'table' => 'products',
            'col' => $col,
            'val' => $val,
            'type' => 'like'
        ]);

    }
    echo json_encode($read);
    /*if($read){
        if($read == 1){
            $assoc = array('0' => 'updat', '1' => 'Created');
            echo json_encode($assoc);
            exit;
        }else{
            $assoc = array('0' => 'uperr', '1' => "something went wrong");
            echo json_encode($assoc);
            exit;
        }
    }else{
        $assoc = array('0' => 'uperr', '1' => 'no values have been entered');
        echo json_encode($assoc);
        exit;
    }*/
}

function is_ajax_request(){
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

?>
