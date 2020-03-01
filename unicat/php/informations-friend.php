<?php 
    session_start();
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "unicat";

    $conn = mysqli_connect($host, $username, $password, $db);  
		$friend_email = $_POST['friend_email'];


		$online_friend_ct = 0;
		$offline_friend_ct = 0;
			 
		$sql_user_info = "SELECT user_nickname, user_email, user_about, user_status, user_lastseen FROM user_information WHERE user_email = '$friend_email'";
		$result = $conn->query($sql_user_info);		

			
		if ($result->num_rows > 0) {  		
			
		 $row = mysqli_fetch_row($result);
		 
		 foreach($row as $key) {	
				$user_nickname = $row[0];	
				$user_email    = $row[1];	
				$user_about    = $row[2];	
				$user_status   = $row[3];	
				$user_lastseen = $row[4];			
			 			
			}			
		 
		 echo json_encode(array('user_nickname' => $user_nickname, 'user_email' => $user_email, 'user_about' => $user_about, 'user_status' => $user_status, 'user_lastseen' => $user_lastseen));	

	 }


    $conn->close();
?>