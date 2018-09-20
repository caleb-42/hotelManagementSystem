<?php
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

$stmt = $conn->prepare("SELECT password FROM restaurant_users WHERE user_name=?");
$stmt->bind_param("s", $username);
$stmt->execute();

$stmt->bind_result($hashed);
while ($stmt->fetch()) {
	$hashedPassword = $hashed;
}

$stmt->close();

if (!verify($password, $hashedPassword)) {
	$username = "";
	$password = "";
	header("Location:  ../../../logon.php?output=Login failed, please retry with a valid username and password");
} else {
	$sql_insert_login = "INSERT INTO users_session (username, logged_out, user_role) VALUES ('$username', 0, 'User')";
	mysqli_query($conn, $sql_insert_login);
	session_id(4);
	session_start();
	$_SESSION["user"] = $username;
	header("Location: ../../../index.php");
}
?>