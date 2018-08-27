<?php
sleep(3);
$arr = $_POST;
//print_r($arr);
$newarr = array();

function __autoload($class_name){
    include "includes/" . $class_name . ".php";
}

/*...............error checking................*/
if(is_ajax_request()){
    errorCheker($arr);
    createReg($newarr);
}

function createReg($data){
    global $arr;
    $read = array();
    //print_r($data);
    if(!empty($data)){
        $col = array();
        $val = array();
        for($num = 0; $num < count($data); $num++){
            array_push($col, substr($data[$num], 8- strlen($data[$num])));
            array_push($val, $arr[$data[$num]]);
        }
        $read = DbHandler::insert_cmd([
            'table' => 'magic_users',
            'col' => $col,
            'val' => $val
        ]);

    }
    //echo json_encode($read);
    if($read){
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
    }
}

function errorCheker($array){
    global $newarr;
    foreach($array as $key=>$value)
    {
        $nkey = substr($key,0,4);
        $vkey = substr($key,4,4);
        if($nkey == "name"){
            if(!empty($value)){
                $name = test_input($value);
                if(!preg_match("/^[a-zA-Z  ]*$/", $name)){
                    $assoc = array('0' => 'error', '1' => 'Only letters and white spaces allowed in', '2' =>$key, '3'=>'last');
                    echo json_encode($assoc);
                    exit;
                }else{
                    array_push($newarr, $key);
                }
            }
        }elseif($nkey == "numb"){

            if(!empty($value)){
                $num = test_input($value);
                if(!preg_match("/^[1-9][0-9]*$/", $num)){
                    $assoc = array('0' => 'error', '1' => 'Only numbers are allowed in', '2' =>$key, '3'=>'last');
                    echo json_encode($assoc);
                    exit;
                }else{
                    array_push($newarr, $key);
                }
            }
        }elseif($nkey == "stus"){
            if(!empty($value)){
                $name = test_input($value);
                /*if(!preg_match("/^[a-zA-Z  ]*$/", $name)){
                    $assoc = array('0' => 'error', '1' => 'Only letters and white spaces allowed in', '2' =>$key, '3'=>'last');
                    echo json_encode($assoc);
                    exit;
                }else */if(strtolower($name) != "ok"){
                    $assoc = array('0' => 'error', '1' => 'Only OK allowed in', '2' =>$key, '3'=>'last');
                    echo json_encode($assoc);
                    exit;
                }else{
                    array_push($newarr, $key);
                }
            }
        }elseif($nkey == "gend"){
            if(!empty($value)){
                $name = test_input($value);
                if(strtolower($name) != "male" && strtolower($name) != "female"){
                    $assoc = array('0' => 'error', '1' => 'Only male and female allowed in', '2' =>$key, '3'=>'last');
                    echo json_encode($assoc);
                    exit;
                }else{
                    array_push($newarr, $key);
                }
            }
        }elseif($nkey == "adrs"){
            if(!empty($value)){
                $address = test_input($value);
                array_push($newarr, $key);
            }
        }elseif($nkey == "mail"){
            if(!empty($value)){
                $email = test_input($value);
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $assoc = array('0' => 'error', '1' => 'Invalid email format at', '2' =>$key, '3'=>'last');
                    echo json_encode($assoc);
                    exit;
                }else{
                    array_push($newarr, $key);
                }
            }
        }elseif($nkey == "date"){
            if(!empty($value)){
                $date = test_input($value);
                if(!preg_match("/^((((19|[2-9]\d)\d{2})\-(0[13578]|1[02])\-(0[1-9]|[12]\d|3[01]))|(((19|[2-9]\d)\d{2})\-(0[13456789]|1[012])\-(0[1-9]|[12]\d|30))|(((19|[2-9]\d)\d{2})\-02\-(0[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))\-02\-29))$/", $date)){
                    $assoc = array('0' => 'error', '1' => 'wrong date format in', '2' =>$key, '3'=>'last');
                    echo json_encode($assoc);
                    exit;
                }else{
                    array_push($newarr, $key);
                }
            }
        }
    }
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
/*...............error checking................*/

function is_ajax_request(){
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

?>
