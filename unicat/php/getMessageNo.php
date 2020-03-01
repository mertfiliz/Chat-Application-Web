<?php 
	session_start();
	$host = "localhost";
	$username = "root";
	$password = "";
	$db = "unicat";

	$conn = mysqli_connect($host, $username, $password, $db); 

	$sender_email = $_SESSION['email'];
	$receiver_email = $_POST['receiver_email'];
	
	$sql = "SELECT msg_no FROM chat_logs WHERE sender_email = '$sender_email' AND receiver_email = '$receiver_email' ORDER BY msg_no DESC LIMIT 1";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
			$row = mysqli_fetch_row($result);
			$msg_no = $row[0];
			echo $msg_no;			
	}

?>