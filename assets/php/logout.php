<?php
ob_start();
require_once "./includes/start_session.php";
require_once "./includes/functions.php";

function __autoload($class_name){
    include "includes/" . $class_name . ".php";
}

function getuser(){
    $users = DbHandler::select_cmd(['table' => 'users_session',
                                    'qcol' => ["username"],
                                    'qval' => [$_SESSION['username']],
                                    'cond' => ["="]]);

    $lastuser = 0;
    $log_on = 0;
    foreach($users[3] as $user){
        if($user["session_log"] > $lastuser){
            $lastuser = $user["session_log"];
            $log_on = $user["log_on"];
        }
    }
    echo $lastuser;
    $user_info = [$lastuser, $log_on];
    $_SESSION = array();
    setcookie(session_name(), ' ', time()-42000, '/');
    session_destroy();
    return $user_info;
}

if(isset($_COOKIE[session_name()])){
    $user_info = getuser();
    date_default_timezone_set('Africa/Lagos');
    $date = new DateTime();
    $d = $date->getTimestamp();
    $t = date("Y-m-d H:i:s", $d);
    $t_corr = $t . " <br/>";
    $duration = round(strtotime($t) - strtotime($user_info[1]));
    $duration = date('H:i:s', $duration);
    echo $t;
    DbHandler::update_cmd(['table' => 'users_session',
                           'col' => ["log_off","logged_out","duration"],
                           'val' => [$t, 1, $duration],
                           'qcol' => ["session_log"],
                           'qval' => [$user_info[0]],
                           'cond' => ["="]]);
    
    
    //echo $_SESSION['username'];
    //
    //print_r ($lastuser);
    
}



custom_redirect_to("../../LogIn.php");
    //ob_end_flush();
?>
