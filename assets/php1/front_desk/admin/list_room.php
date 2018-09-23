<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

  $get_rooms_sql = "SELECT * FROM frontdesk_rooms";
  $get_rooms_result = mysqli_query($dbConn, $get_rooms_sql);
  $get_rooms_array = [];

  function get_all_frontdesk_rooms($rooms_result, $rooms_array) {
    $rooms_array = [];

    if (mysqli_num_rows($rooms_result) > 0){
 	  while($rows = mysqli_fetch_assoc($rooms_result)) {
 		$rooms_array[] = $rows;
 	  }
 	  $get_rooms_json = json_encode($rooms_array);
 	  return $get_rooms_json;
    }
  }

  $frontdesk_rooms = get_all_frontdesk_rooms($get_rooms_result, $get_rooms_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $frontdesk_rooms;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>