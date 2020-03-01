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


	$query = mysqli_query($conn,"SELECT COUNT(*) FROM chat_logs");

	$count = mysqli_fetch_array($conn,$query);

	$total_count = $count[0];

	echo $total_count;

?>