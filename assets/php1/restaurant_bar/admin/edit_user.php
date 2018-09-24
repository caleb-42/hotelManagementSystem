<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$update_user = json_decode($_POST["update_user"], true);

// $update_user = '{"user": "sprite", "type": "soft-drink", "category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_user": "yes", "current_stock": 50}';
// $update_user = json_decode($update_user, true);
function generateHash($password) {
	if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
		$salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
		return crypt($password, $salt);
	}
}

$id = $update_user["id"];
$old_user_name = $update_user["user_name"];
$user_name = $update_user["new_user_name"] ? $update_user["new_user_name"] : $update_user["user_name"];
$user = $update_user["new_user"] ? $update_user["new_user"] : $update_user["user"];
$role = $update_user["new_role"] ? $update_user["new_role"] : $update_user["role"];
$password = $update_user["new_password"] ? generateHash($update_user["new_password"]) : "";

$msg_response="";

if ($user == "" || $role == "" || $user_name == "") {
	$msg_response = "The fields 'user name', 'role', and 'user' are all compulsory";
	die($msg_response);
}

if ($old_user_name != $user_name) {
	$duplicate_check_query = "SELECT * FROM restaurant_users WHERE role = '$role' AND user_name = '$user_name'";
    $duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

    if (mysqli_num_rows($duplicate_check_result) > 0) {
	   $msg_response = "This user profile details conflicts with a user name already in use";
	   die($msg_response);
    }
}

if ($password) {
	$update_user_query = "UPDATE restaurant_users SET user = '$user', role = '$role', user_name = '$user_name', password = '$password' WHERE id = $id";
} else {
	$update_user_query = "UPDATE restaurant_users SET user = '$user', role = '$role', user_name = '$user_name' WHERE id = $id";
}

$update_user_result = mysqli_query($dbConn, $update_user_query);

if ($update_user_result) {
	$msg_response = $user . " was successfully updated";
} 

echo $msg_response;
?>