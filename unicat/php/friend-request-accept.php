<?php 
    session_start();
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "unicat";

    $conn = mysqli_connect($host, $username, $password, $db);    
    
 		$loggedEmail = $_SESSION['email'];
		$loggedName = $_SESSION['name'];
		$friend_request_email = $_POST['friend_request_email'];

		//echo $friend_request_email;

		// BAŞLANGIÇ not_no
		// Silinmesi istenen request not_no alınır.

		$sql_check = "SELECT friend_no FROM friend_list WHERE user_email = '$loggedEmail' ORDER BY friend_no DESC LIMIT 1";		
		$result_check = $conn->query($sql_check);


		if ($result_check->num_rows > 0) {
			$row_check = mysqli_fetch_row($result_check);
			$friend_no = $row_check[0] + 1;
			//echo $msg_no;			
		} 
		else {
			$friend_no = 1;
		}


		$sql_self_add_friend = "INSERT INTO friend_list(user_email, friend_email, friend_no) VALUES('$loggedEmail', '$friend_request_email', '$friend_no')";
		mysqli_query($conn, $sql_self_add_friend);

		$sql_check = "SELECT friend_no FROM friend_list WHERE user_email = '$friend_request_email' ORDER BY friend_no DESC LIMIT 1";		
		$result_check = $conn->query($sql_check);


		if ($result_check->num_rows > 0) {
			$row_check = mysqli_fetch_row($result_check);
			$friend_no = $row_check[0] + 1;
			//echo $msg_no;			
		} 
		else {
			$friend_no = 1;
		}


		$sql_friend_add_friend = "INSERT INTO friend_list(user_email, friend_email, friend_no) VALUES('$friend_request_email', '$loggedEmail', '$friend_no')";
		mysqli_query($conn, $sql_friend_add_friend);
			
			
 
		$sql_select_start = "SELECT not_no FROM friend_requests WHERE receiver_email = '$loggedEmail' AND sender_email = '$friend_request_email'";
	  $result_select_start = mysqli_query($conn,$sql_select_start);		

		$row_select_start = $result_select_start->fetch_assoc();
		$update_start = (int) $row_select_start['not_no']; 

	
		// BİTİŞ not_no
		// En son not_no alınır.

		$sql_select_end = "SELECT not_no FROM friend_requests WHERE receiver_email = '$loggedEmail' ORDER BY not_no DESC LIMIT 1";
	  $result_select_end = mysqli_query($conn,$sql_select_end);

		$row_select_end = $result_select_end->fetch_assoc();
		$update_end = (int) $row_select_end['not_no'];

		// not_no arttırılarak delete, update işlemi yapılır.
		while($update_start <= $update_end) { 
		
			$sql_delete = "DELETE FROM friend_requests WHERE receiver_email = '$loggedEmail' AND sender_email = '$friend_request_email'";
			mysqli_query($conn,$sql_delete);
			
			
			$update_start_new = $update_start + 1;
			$sql_update = "UPDATE friend_requests SET not_no = '$update_start' WHERE receiver_email = '$loggedEmail' AND not_no = '$update_start_new'";
			mysqli_query($conn, $sql_update);
			
		
			
			//echo "\nBaslangıc: " . $update_start_new . " - Değiştirilcek yeni veri: " . $update_start;
			$update_start++;
		} 

		$conn->close();

?>