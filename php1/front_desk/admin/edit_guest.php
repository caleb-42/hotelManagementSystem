<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

 $update_guest = json_decode($_POST["update_guest"], true);

 $guest_id = $update_guest["guest_id"];
 $guest_type_gender = $update_guest["new_guest_type_gender"] ? $update_guest["new_guest_type_gender"] : $update_guest["guest_type_gender"];
 $guest_name = $update_guest["new_guest_name"] ? $update_guest["new_guest_name"] : $update_guest["guest_name"];
 $guest_name = mysqli_real_escape_string($dbConn, $guest_name);
 $phone_number = $update_guest["new_phone_number"] ? $update_guest["new_phone_number"] : $update_guest["phone_number"];
 $contact_address = $update_guest["new_contact_address"] ? $update_guest["new_contact_address"] : $update_guest["contact_address"];
 $contact_address = mysqli_real_escape_string($dbConn, $contact_address);
?>