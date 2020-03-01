<?php 
	session_start();
	$host = "localhost";
	$username = "root";
	$password = "";
	$db = "unicat";

	$conn = mysqli_connect($host, $username, $password, $db); 

	$logged_email = $_SESSION['email'];

	
	$sql = "SELECT not_no FROM friend_requests WHERE receiver_email = '$logged_email' ORDER BY not_no DESC LIMIT 1";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
			$row = mysqli_fetch_row($result);
			$msg_no = $row[0];
			echo $msg_no;			
	}

?>