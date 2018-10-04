<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

 $new_guest = json_decode($_POST["new_guest"], true);

 $guest_name = mysqli_real_escape_string($dbConn, $new_guest["guest_name"]);
 $gender_type_gender = $new_guest["gender_type_gender"]; // guest_type_gender = 'company' or 'male' or 'female'
 $phone_number = $new_guest["phone_number"];
 $contact_address = $new_guest["contact_address"];
 $total_rooms_booked = $new_guest["total_rooms_booked"];

 $rand_id = mt_rand(0, 100000);
 $guest_id = "LOD_" . $rand_id;

 $duplicate_id_query = "SELECT * FROM frontdesk_guests WHERE guest_id = '$guest_id'";
 $duplicate_id_result = mysqli_query($dbConn, $duplicate_id_query);

 while (mysqli_num_rows($duplicate_id_result) > 0) {
	$rand_id = mt_rand(0, 100000);
    $guest_id = "LOD_" . $rand_id;

    $duplicate_id_query = "SELECT * FROM frontdesk_guests WHERE guest_id = '$guest_id'";
    $duplicate_id_result = mysqli_query($dbConn, $duplicate_id_query);
 }

 $add_new_guest_query = "INSERT INTO frontdesk_guests (guest_id, full_name, gender, phone_number, contact_address, outstanding_balance) VALUES('$guest_id', '$full_name', $gender, $phone_number, $contact_address, 0,)";
 $add_new_guest_result = mysqli_query($dbConn, $add_new_guest_query);

 if($add_new_guest_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = $full_name . "SUCCESSFULLY ADDED";
 } else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
 }

 $response_message = json_encode($msg_response);
 echo $response_message;
?>