<?php
sleep(3);
include "../settings/connect.php";  //database name = $dbConn

function generateHash($password) {
	if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
		$salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
		return crypt($password, $salt);
	}
}

function verify($password, $hashedPassword) {
	return crypt($password, $hashedPassword) == $hashedPassword;
}

$username = $_POST["username"];
$password = $_POST["password"];

$stmt = $conn->prepare("SELECT password, role FROM restaurant_users WHERE user_name=?");
$stmt->bind_param("s", $username);
$stmt->execute();

$stmt->bind_result($hashed, $role);
while ($stmt->fetch()) {
	$hashedPassword = $hashed;
}

$stmt->close();

if (!verify($password, $hashedPassword)) {
	$username = "";
	$password = "";
	header("Location:  ../../restaurant/login.php?output=Login failed, please retry with a valid username and password");
} else {
	$sql_log_out = "SELECT * FROM restaurant_sessions WHERE user_name = '$username' AND role = '$role' AND logged_on_state = 'LOGGED IN'";
	$sql_log_out_result = mysqli_query($dbConn, $sql_log_out);
	if (mysqli_num_rows($sql_log_out_result) > 0) {
		$update_log_out = "UPDATE restaurant_sessions SET logged_on_state = 'TERMINATED' WHERE user_name= '$username' AND role = '$role' AND logged_on_state = 'LOGGED IN'";

		$update_log_out_result = mysqli_query($dbConn, $update_log_out);
	}
	$sql_insert_login = "INSERT INTO restaurant_sessions (user_name, role, logged_on_state) VALUES ('$username', '$role', 'LOGGED IN')";
	mysqli_query($dbConn, $sql_insert_login);
	session_start();
	$_SESSION["user_name"] = $username;
	$_SESSION["role"] = $role;
	header("Location: ../../restaurant/index.php");
}
?>