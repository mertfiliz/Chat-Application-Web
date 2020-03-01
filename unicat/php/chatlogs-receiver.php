<?php 
	session_start();
	$host = "localhost";
	$username = "root";
	$password = "";
	$db = "unicat";

	$conn = mysqli_connect($host, $username, $password, $db); 
	
	$sender_email = $_SESSION['email'];
	$receiver_email = $_POST['receiver_email'];
	$row_counter = $_POST['row_counter'];

	// Alıcı göndericiye kaç mesaj attı
	$query_r = mysqli_query($conn,"SELECT COUNT(*) FROM chat_logs WHERE receiver_email = '$sender_email' AND sender_email = '$receiver_email'");
	$count_r = mysqli_fetch_array($query_r);
	$msg_count_r = $count_r[0];

	// RECEIVER PART
	$sql = "SELECT sender_message FROM chat_logs WHERE receiver_email = '$sender_email' AND sender_email = '$receiver_email' AND msg_no = '$row_counter' ";

	$result = $conn->query($sql);

		if ($result->num_rows > 0) {

			$row = mysqli_fetch_row($result);

			foreach($row as $key) {
				$message = $row[0];
				echo json_encode(array('message_receiver' => $message, 'ct_r' => $msg_count_r));
			}
		}

?>