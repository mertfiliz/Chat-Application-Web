<?php 
    session_start();
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "unicat";

    $conn = mysqli_connect($host, $username, $password, $db);    
    
 		$loggedEmail = $_SESSION['email'];
 		$row_counter_friends = $_POST['row_counter_friends'];

		$query = mysqli_query($conn,"SELECT COUNT(*) FROM friend_list WHERE user_email = '$loggedEmail'");
		$count = mysqli_fetch_array($query);
		$msg_count = $count[0];

		
    $sql = "SELECT friend_email FROM friend_list WHERE user_email = '$loggedEmail' AND friend_no = '$row_counter_friends'";
    $result = $conn->query($sql);

		if ($result->num_rows > 0) {  			
			$row = mysqli_fetch_row($result);
			
			foreach($row as $key) {	
				$friend_email = $row[0];									
			}
			
			//echo $friend_email . "-" . $row_counter_friends;
			echo json_encode(array('friend_email' => $friend_email, 'ct' => $msg_count));
					
		}						

    $conn->close();
?>