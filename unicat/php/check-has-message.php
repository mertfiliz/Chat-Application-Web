<?php

		session_start();
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "unicat";

    $conn = mysqli_connect($host, $username, $password, $db);    
 
 		$loggedEmail = $_SESSION['email'];
 		$friend_email = $_POST['friend_email'];

		$query = mysqli_query($conn,"SELECT COUNT(*) FROM message_list WHERE receiver_email = '$friend_email' AND sender_email = '$loggedEmail'");
		$result = mysqli_fetch_array($query);
		$msg_counter = $result[0];
  	$msg_list_exist;

		/* Bu kısımda 2 kullanıcı arasında geçen en son kimden mesaj geldiği önemli olmayan son mesajı alır. */
		$last_message_query = mysqli_query($conn, "SELECT sender_message FROM chat_logs WHERE sender_email='$loggedEmail' AND receiver_email='$friend_email' OR sender_email='$friend_email' AND receiver_email='$loggedEmail' ORDER BY msg_no DESC LIMIT 1");
		$last_message_result = mysqli_fetch_row($last_message_query);
		$last_message = $last_message_result[0];

		/* Some problems here */

		if($msg_counter == "0") {			
			$query_add_1 = mysqli_query($conn, "INSERT INTO message_list(sender_email, receiver_email, last_message) VALUES('$loggedEmail', '$friend_email', '$last_message')");
			mysqli_query($conn, $query_add_1);			
			
			$query_add_2 = mysqli_query($conn, "INSERT INTO message_list(sender_email, receiver_email, last_message) VALUES('$friend_email', '$loggedEmail', '$last_message')");
			mysqli_query($conn, $query_add_2);	
			
			$msg_list_exists = false;
			
		}
		/* Eğer daha önce bir mesaj kaydı var ise iki tarafin son mesajını da güncelle*/
		else {
			$query_update_1 = mysqli_query($conn, "UPDATE message_list SET last_message = '$last_message' WHERE sender_email = '$loggedEmail' AND receiver_email = '$friend_email'");		
			
			$query_update_2 = mysqli_query($conn, "UPDATE message_list SET last_message = '$last_message' WHERE sender_email = '$friend_email' AND receiver_email = '$loggedEmail'");	
						
			$msg_list_exists = true;
		}

		echo json_encode(array('friend_email' => $friend_email, 'last_message' => $last_message, 'msg_list_exists' => $msg_list_exists));


?>