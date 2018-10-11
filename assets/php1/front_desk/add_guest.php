<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

 //$new_guest = json_decode($_POST["new_guest"], true);

 $new_guest = '{"guest_name":"Ewere", "guest_type_gender": "male", "phone_number":"08023456789", "contact_address":"webplay nigeria ltd", "total_rooms_booked":9, "no_of_nights":8, "room_outstanding": 4000}';

 $new_guest = json_decode($new_guest, true);

 $guest_name = mysqli_real_escape_string($dbConn, $new_guest["guest_name"]);
 $guest_type_gender = $new_guest["guest_type_gender"]; // guest_type_gender = 'company' or 'male' or 'female'
 $phone_number = $new_guest["phone_number"];
 $contact_address = $new_guest["contact_address"];
 $total_rooms_booked = $new_guest["total_rooms_booked"];
 $no_of_nights = $new_guest["no_of_nights"];
 $d = strtotime("+"."$no_of_nights days");
 $check_out_date = date("Y-m-d", $d);
 var_dump($check_out_date);
 $room_outstanding = $new_guest["room_outstanding"];

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

 $add_new_guest_query = "INSERT INTO frontdesk_guests (guest_id, guest_name, guest_type_gender, phone_number, contact_address, room_outstanding, check_out_date, check_out_time, total_rooms_booked) VALUES('$guest_id', '$guest_name', '$guest_type_gender', '$phone_number', '$contact_address', $room_outstanding, '$check_out_date', CURRENT_TIME, $total_rooms_booked)";
 $add_new_guest_result = mysqli_query($dbConn, $add_new_guest_query);

 if($add_new_guest_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = $guest_name . " SUCCESSFULLY ADDED";
 } else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG". mysqli_error($dbConn);
 }

 $response_message = json_encode($msg_response);
 echo $response_message;
?>