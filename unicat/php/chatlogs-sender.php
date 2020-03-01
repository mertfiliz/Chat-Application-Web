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

	// Gönderici alıcıya kaç mesaj attı
	$query = mysqli_query($conn,"SELECT COUNT(*) FROM chat_logs WHERE sender_email = '$sender_email' AND receiver_email = '$receiver_email'");
	$count = mysqli_fetch_array($query);
	$msg_count_s = $count[0];


	// SENDER PART
	$sql = "SELECT sender_message FROM chat_logs WHERE sender_email = '$sender_email' AND receiver_email = '$receiver_email' AND msg_no = '$row_counter' ";

	$result = $conn->query($sql);

		if ($result->num_rows > 0) {

			$row = mysqli_fetch_row($result);

			foreach($row as $key) {
				$message = $row[0];
				echo json_encode(array('message_sender' => $message, 'ct_s' => $msg_count_s));
			}
		}

		
	

?>