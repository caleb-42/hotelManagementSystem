<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$del_customers = json_decode($_POST["del_customers"], true);
//$del_customers = '{"customers": [{"full_name": "Ewere", "id": 3}, {"full_name": "Ewere", "id": 4}]}';

$deleted = [];

//$del_customers = json_decode($del_customers, true);
$del_array = $del_customers["customers"];
$no_of_customers = count($del_array);

$delete_customers_query = $conn->prepare("DELETE FROM restaurant_customers WHERE full_name = ? AND id = ?");
$delete_customers_query->bind_param("si", $full_name, $id);

for ($i=0; $i < $no_of_customers; $i++) { 
 	$full_name = $del_array[$i]["full_name"];
 	$id = $del_array[$i]["id"];
 	$delete_customers_query->execute();
 	$deleted[] = $full_name;
}
$delete_customers_query->close();
$deleted_customers = json_encode($deleted);

if(count($deleted)){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY DELETED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>