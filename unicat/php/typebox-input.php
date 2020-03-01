<?php 
	session_start();
	$host = "localhost";
	$username = "root";
	$password = "";
	$db = "unicat";

	$conn = mysqli_connect($host, $username, $password, $db); 


	$sender_email = $_SESSION['email'];
	$sender_name = $_SESSION['name'];
	$receiver_email = $_POST['receiver_email'];
	$receiver_name = $_POST['receiver_name'];
	$sender_message = $_POST['sender_message'];

	date_default_timezone_set('Europe/Istanbul');
	$date = date("H:i:s");

	
	$sql = "SELECT msg_no FROM chat_logs WHERE sender_email = '$sender_email' AND receiver_email = '$receiver_email' OR sender_email = '$receiver_email' AND receiver_email = '$sender_email' ORDER BY msg_no DESC LIMIT 1";
	$result = $conn->query($sql);
	

	if ($result->num_rows > 0) {
		$row = mysqli_fetch_row($result);
		$msg_no = $row[0] + 1;
		//echo $msg_no;			
	} 
	else {
		$msg_no = 1;
	}
		
	
	$sql = "INSERT INTO chat_logs(sender_email, sender_name, sender_message, receiver_email, receiver_name, date, msg_no) VALUES('$sender_email', '$sender_name','$sender_message','$receiver_email', '$receiver_name','$date', '$msg_no')";
	mysqli_query($conn, $sql);

/* ****** */
	
	$query2 = mysqli_query($conn,"SELECT COUNT(*) FROM message_list WHERE receiver_email = '$receiver_email' AND sender_email = '$sender_email'");
	$result = mysqli_fetch_array($query);
	$msg_counter = $result[0];
	$msg_list_exist;

	
	if($msg_counter == "0") {			
			$msg_counter++;
			$query_add_1 = mysqli_query($conn, "INSERT INTO message_list(sender_email, receiver_email, last_message, id) VALUES('$sender_email', '$receiver_email', '$sender_message', '$msg_counter')");
			mysqli_query($conn, $query_add_1);			
			
			$query_add_2 = mysqli_query($conn, "INSERT INTO message_list(sender_email, receiver_email, last_message, id) VALUES('$receiver_email', '$sender_email', '$sender_message', '$msg_counter')");
			mysqli_query($conn, $query_add_2);	
			
			$msg_list_exists = false;			
	}

	else {
			$query_update_1 = mysqli_query($conn, "UPDATE message_list SET last_message = '$sender_message' WHERE sender_email = '$sender_email' AND receiver_email = '$receiver_email'");		
			
			$query_update_2 = mysqli_query($conn, "UPDATE message_list SET last_message = '$sender_message' WHERE sender_email = '$receiver_email' AND receiver_email = '$sender_email'");	
						
			$msg_list_exists = true;
	}

	$last_message_query = mysqli_query($conn, "SELECT sender_message FROM message_list WHERE sender_email='$sender_email' AND receiver_email='$receiver_email' OR sender_email='$receiver_email' AND receiver_email='$sender_email' ORDER BY msg_no DESC LIMIT 1");
	$last_message_result = mysqli_fetch_row($last_message_query);
	$last_message = $last_message_result[0];


	//echo json_encode(array('friend_email' => $receiver_email, 'last_message' => $sender_message, 'msg_list_exists' => $msg_list_exists));
	


?>