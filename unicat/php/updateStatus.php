<?php 
	session_start();
	$host = "localhost";
	$username = "root";
	$password = "";
	$db = "unicat";

	$conn = mysqli_connect($host, $username, $password, $db);    

	$loggedEmail = $_POST['loggedEmail']; 

	$status = $_POST['status'];			

	$sql_updateStatus = "UPDATE user_information SET user_status = '$status' WHERE user_email = '$loggedEmail'";
	$result = mysqli_query($conn,$sql_updateStatus);
	
	$conn->close();
?>