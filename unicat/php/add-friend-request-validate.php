<?php 
    session_start();
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "unicat";

    $conn = mysqli_connect($host, $username, $password, $db);    

    $add_friend_request = $_POST['add_friend_request'];  

 		$loggedEmail = $_SESSION['email'];
 

    $sql = "SELECT email FROM users WHERE email = '$add_friend_request' AND email != '$loggedEmail'";
    $result = $conn->query($sql);

		$sql_friend = "SELECT * FROM friend_list WHERE user_email = '$loggedEmail' AND friend_email = '$add_friend_request'";
    $result_friend = $conn->query($sql_friend);

		if ($result_friend->num_rows > 0) {
			//EĞER ARKADAS OLARAK EKLIYSE
			echo "You already friends with " . $add_friend_request;
		}
		else {
			if ($result->num_rows > 0) {  			
				// EĞER EMAİL KAYDI VARSA

				$sqlRequestExists = "SELECT * FROM friend_requests WHERE sender_email = '$loggedEmail' AND receiver_email = '$add_friend_request' OR sender_email = '$add_friend_request' AND receiver_email = '$loggedEmail'";
				$resultRequestExists = mysqli_query($conn, $sqlRequestExists);


				if(mysqli_num_rows($resultRequestExists) >= 1) {  				
					echo "Friend request on hold!";
				}
				else { 			
					date_default_timezone_set('Europe/Istanbul');
					$date = date("Y-m-d H:i:s");

					$sql_check = "SELECT not_no FROM friend_requests WHERE receiver_email = '$add_friend_request' ORDER BY not_no DESC LIMIT 1";		
					$result_check = $conn->query($sql_check);


					if ($result_check->num_rows > 0) {
						$row_check = mysqli_fetch_row($result_check);
						$not_no = $row_check[0] + 1;
						//echo $msg_no;			
					} 
					else {
						$not_no = 1;
					}

					$sql_request = "INSERT INTO friend_requests(sender_email, receiver_email, date, not_no) VALUES('$loggedEmail', '$add_friend_request','$date', '$not_no')";
					$result_request = $conn->query($sql_request);				

					echo "Friend request sent to " . "$add_friend_request";
				}					
			} 
		
			else {
				echo  "Email doesn't exists!";
			}
		}
		
		

    $conn->close();
?>