<?php

$output = "";

function __autoload($class_name){
    include "includes/" . $class_name . ".php";
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function generateHash($password) {
	if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
		$salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
		return crypt($password, $salt);
	}
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
    if (isset($_POST['cat'])){
        $cat = test_input($_POST["cat"]);
    }
    $ech = "false";
    if (isset($_POST['echo'])){
        $ech = $_POST['echo'];
    }
    
    if (!(empty($username) || empty($password) || empty($cat))) {
        $hashedPassword = generateHash($password);
        
        $users = DbHandler::select_cmd([
            "table" => "users",
            "col" => ["username"],
            "cond" => ["="],
            "qcol" => ["username"],
            "qval" => [$username]
        ]);

        switch($users[1]){
            case "error":
                $output = $users[2];
                $ech == "true" ? print ($output) : $ech;    
                break;
            case "success":
                $output = "This username has already been taken, please try a different one";
                $ech == "true" ? print ($output) : $ech;
                break;
            case "empty":
                if(!empty($users[3])){
                    $output = "This username has already been taken, please try a different one";
                    $ech ? print ($output) : $ech;
                }else{
                    $users = DbHandler::insert_cmd([
                        "table" => "users",
                        "col" => ["username","password","category"],
                        "val" => [$username,$hashedPassword,$cat]
                    ]);
                    $output = $users[2];
                    $ech ? print ($output) : $ech;
                }
            break;
        }
    }
    else{
        $output = "all inputs must be selected";
        $ech == "true" ? print ($output) : $ech;
    }
}


?>