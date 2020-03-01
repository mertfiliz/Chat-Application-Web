<?php 
	session_start();
	$host = "localhost";
	$username = "root";
	$password = "";
	$db = "unicat";

	$conn = mysqli_connect($host, $username, $password, $db); 

	$loggedEmail = $_SESSION['loggedEmail'];

	$last_message_query = mysqli_query($conn, "SELECT receiver_email, last_message FROM message_list WHERE sender_email='$loggedEmail'");
	$last_message_result = mysqli_fetch_row($last_message_query);
	$last_message = $last_message_result[0];

	echo json_encode(array('last_message' => $last_message));

?>