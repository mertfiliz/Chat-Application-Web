<?php 
	session_start();
	$host = "localhost";
	$username = "root";
	$password = "";
	$db = "unicat";

	$conn = mysqli_connect($host, $username, $password, $db);    

	$loggedEmail = $_POST['loggedEmail'];  

	//$_SESSION['loggedEmail'] = $loggedEmail; 

	date_default_timezone_set('Europe/Istanbul');
	$date = date("Y-m-d H:i:s");

	$status = "Online";

	$sql_lastseen = "UPDATE user_information SET user_lastseen = '$date', user_status = '$status' WHERE user_email = '$loggedEmail'";
	mysqli_query($conn, $sql_lastseen);

	$conn->close();
?>