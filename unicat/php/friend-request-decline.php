<?php 
    session_start();
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "unicat";

    $conn = mysqli_connect($host, $username, $password, $db);    
    
 		$loggedEmail = $_SESSION['email'];
		$friend_request_email = $_POST['friend_request_email'];

		//echo $friend_request_email;

		// BAŞLANGIÇ not_no
		// Silinmesi istenen request not_no alınır.

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

		// Some problems here.
/*
		$sql_select_end = "SELECT not_no FROM friend_requests WHERE receiver_email = '$loggedEmail' AND sender_email = '$friend_request_email' ORDER BY not_no DESC LIMIT 1";
	  $result_select_end = mysqli_query($conn,$sql_select_end);
	
		$result_select_start+=1;

		for($result_select_start;$result_select_end;$result_select_start++) {
			$sql_update = "UPDATE friend_requests SET not_no = '$result_select_start' WHERE receiver_email = '$loggedEmail' AND sender_email = '$friend_request_email' AND not_no = '$result_select_start'";
		}
		
	
  	$sql_delete = "DELETE FROM friend_requests WHERE receiver_email = '$loggedEmail' AND sender_email = '$friend_request_email'";
	  mysqli_query($conn,$sql_delete);
*/
		$conn->close();

?>