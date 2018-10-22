<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$default_user = '{"user_name":"admin", "role":"admin", "user_pass": "webplay", "user": "Admin"}';
$new_user = json_decode($default_user, true);

$user_name = $new_user["user_name"];
$user = $new_user["user"];
$role = $new_user["role"];
$user_pass = $new_user["user_pass"];
$msg_response=["OUTPUT", "NOTHING HAPPENED"];


if ($user_name == "" || $role == "" || $user_pass == "") {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "THE FIELDS 'USERNAME', 'ROLE', AND 'PASSWORD' ARE ALL COMPULSORY";
	$response_message = json_encode($msg_response);
	die($response_message);
}

$duplicate_check_query = "SELECT * FROM restaurant_users WHERE user_name = '$user_name'";
$duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

if (mysqli_num_rows($duplicate_check_result) > 0) {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "THIS USERNAME IS ALREADY TAKEN";
	$response_message = json_encode($msg_response);
	die($response_message);
}

function generateHash($password) {
	if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
		$salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
		return crypt($password, $salt);
	}
}

$hashedPassword = generateHash($user_pass);

$add_user_query = "INSERT INTO restaurant_users (user_name, user, role, password) VALUES ('$user_name', '$user', '$role', '$hashedPassword')";

$add_user_result = mysqli_query($dbConn, $add_user_query);

if($add_user_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY ADDED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>