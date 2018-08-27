<?php
sleep(3);
    require_once "assets/php/includes/start_session.php";
    require_once "assets/php/includes/functions.php";

    $output = "";

validatePost();

function __autoload($class_name){
    include "includes/" . $class_name . ".php";
}

function validatePost(){
    if($_SERVER["REQUEST_METHOD"] == "POST") {

        if($_POST["username"] != NULL && $_POST["password"] != NULL){
            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);
            checkDB($username, $password);
        }

        else if($_POST["username"] == NULL && $_POST["password"] != NULL){
            $output = "please input username";
        }else if($_POST["password"] == NULL && $_POST["username"] != NULL){
            $output = "please input password";
        }else{
            $output = "please input username and password";
        }

    }
}


function checkDB($user, $pass){

    global $output;

    /*$users = DbHandler::select_cmd(['table' => 'users',
                                    'qcol' => ["username","category"],
                                    'qval' => [$user, "admin"],
                                    'conj' => ["AND"],
                                    'cond' => ["="]]);*/
    
    $users = ["output", "success"];
    //print_r($users);

    switch($users[1]){
        case "error":
            $output = $users[2];
            break;
        case "empty":
            $output = "wrong username or password";
            break;
        case "success":
            /*if(!empty($users[3])){
                $found_user = $users[3][0];
                if(verify($pass, $found_user["password"])){*/
                    $output = "authorization granted";
                    /*date_default_timezone_set('Africa/Lagos');
                    $date = new DateTime();
                    $d = $date->getTimestamp();
                    $t = date("Y-m-d H:i:s", $d);
                    DbHandler::insert_cmd([
                        "table" => "users_session",
                        "col" => ["username","log_on","logged_out","user_role"],
                        "val" => [$found_user["username"], $t , 0, $found_user["category"]]
                    ]);*/
                    
                    /*$_SESSION['user_id'] = $found_user['id'];
                    $_SESSION['username'] = $found_user['username'];
                    //echo $_SESSION['username'];
                    custom_redirect_to("./././index.php");
                    exit();*/
                /*}else{
                    $output = "wrong username or password";
                }
            }else{
                $output = "wrong username or password";
            }*/
            break;
    }

}

function verify($password, $hashedPassword) {
    return crypt($password, $hashedPassword) == $hashedPassword;
}



?>
