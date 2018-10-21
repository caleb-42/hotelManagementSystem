<?php
 include "../settings/connect.php"; //$database handler $dbConn or $conn

  $get_guests_sql = "SELECT * FROM frontdesk_guests WHERE checked_in = 'YES'";
  $get_guests_result = mysqli_query($dbConn, $get_guests_sql);
  $get_guests_array = [];

  function get_all_frontdesk_guests($guests_result, $guests_array) {
    $guests_array = [];

    if (mysqli_num_rows($guests_result) > 0){
 	  while($rows = mysqli_fetch_assoc($guests_result)) {
 		$guests_array[] = $rows;
 	  }
 	  $get_guests_json = json_encode($guests_array);
 	  return $get_guests_json;
    }
  }

  $frontdesk_guests = get_all_frontdesk_guests($get_guests_result, $get_guests_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $frontdesk_guests;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  } 
?>