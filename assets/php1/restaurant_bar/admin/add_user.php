<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$new_user = json_decode($_POST["new_user"], true);

$user_name = $new_user["user_name"];
$user = $new_user["user"];
$role = $new_user["role"];
$user_pass = $new_user["user_pass"];
$msg_response = "";


if ($user_name == "" || $role == "" || $user_pass == "") {
	$msg_response = "The fields 'User name', 'Role', and 'Password' are all compulsory";
	die($msg_response);
}

$duplicate_check_query = "SELECT * FROM restaurant_users WHERE user_name = '$user_name'";
$duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

if (mysqli_num_rows($duplicate_check_result) > 0) {
	$msg_response = "This user name is already taken";
	die($msg_response);
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

if ($add_user_result) {
	$msg_response = $user_name ." was successfully added as a restaurant application user";
}

echo $msg_response;
?>