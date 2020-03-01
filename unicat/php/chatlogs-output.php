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
	//$msgNo_counter = $_POST['msgNo_counter'];

	// Gönderici alıcıya kaç mesaj attı
	$query = mysqli_query($conn,"SELECT COUNT(*) FROM chat_logs WHERE sender_email = '$sender_email' AND receiver_email = '$receiver_email'");
	$count = mysqli_fetch_array($query);
	$msg_count = $count[0];

  // Alıcıdan kaç mesaj geldi?
	$query_r = mysqli_query($conn,"SELECT COUNT(*) FROM chat_logs WHERE receiver_email = '$sender_email' AND sender_email = '$receiver_email'");
	$count_r = mysqli_fetch_array($query_r);
	$msg_count_r = $count_r[0];

	// toplam mesaj sayısı
	$msg_total_no = $msg_count + $msg_count_r;


	// SENDER PART
	$sql = "SELECT sender_message, sender_email, receiver_email, sender_name, receiver_name, date FROM chat_logs WHERE sender_email = '$sender_email' AND receiver_email = '$receiver_email' AND msg_no = '$row_counter' OR sender_email='$receiver_email' AND receiver_email='$sender_email' AND msg_no = '$row_counter'";
	//$sql2 = "SELECT sender_email FROM chat_logs WHERE msg_no = '$row_counter'"; 

	$result = $conn->query($sql);
	//$result2 = $conn->query($sql2);


	if ($result->num_rows > 0) {		

		//$rowCheck = mysqli_fetch_row($result2); //Mesajı atanı ayırt etmek için.
		$row = mysqli_fetch_row($result);

		foreach($row as $key) {			
			$message = $row[0];				
			$sender_em = $row[1];				
			$receiver_em = $row[2];				
			$sender_name = $row[3];				
			$receiver_name = $row[4];
			$date = $row[5];
		}
		
		$date2 = substr($date, 0, 5);
		/*
		foreach($rowCheck as $key) {			
			$message2 = $rowCheck[0];					
		}
		*/
		
		echo json_encode(array('sender_email' => $sender_em, 'sender_name' => $sender_name, 'receiver_name' => $receiver_name, 'date' => $date2, 'logged_email' => $sender_email, 'receiver_email' => $receiver_em, 'message' => $message, /* 'message2' => $message2, */'ct' => $msg_total_no));
	

		
	}
	

?>