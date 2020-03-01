<?php 
    session_start();
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "unicat";

    $conn = mysqli_connect($host, $username, $password, $db);    
    
 		$loggedEmail = $_SESSION['email'];
		$row_counter_notifications = $_POST['row_counter_notifications'];

		$query = mysqli_query($conn,"SELECT COUNT(*) FROM friend_requests WHERE receiver_email = '$loggedEmail'");
		$count = mysqli_fetch_array($query);
		$msg_count = $count[0];
 

    $sql = "SELECT sender_email FROM friend_requests WHERE receiver_email = '$loggedEmail' AND not_no = '$row_counter_notifications'";
    $result = $conn->query($sql);
		
    if ($result->num_rows > 0) {  			
			$row = mysqli_fetch_row($result);
			
			foreach($row as $key) {	
				$sender_em = $row[0];	
			}
			
			$sql_name = "SELECT name FROM users WHERE email = '$sender_em'";
			$result_name = $conn->query($sql_name);
			
			$sql_surname = "SELECT surname FROM users WHERE email = '$sender_em'";
			$result_surname = $conn->query($sql_surname);
			
			$name = mysqli_fetch_row($result_name);
			$surname = mysqli_fetch_row($result_surname);
			
			$name = $name;
			$surname = $surname;
			
			echo json_encode(array('sender_name' => $name, 'sender_surname' => $surname, 'sender_email' => $sender_em, 'ct' => $msg_count));
			
			/*
			while($row = $result->fetch_assoc()) {
       	$sender = $row['sender_email'];
				print_r($sender);
      }
			*/
			
    } 
		else {
			echo "No notifications!";
		}
		

    $conn->close();
?>