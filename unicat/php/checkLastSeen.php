<?php 
	session_start();
	$host = "localhost";
	$username = "root";
	$password = "";
	$db = "unicat";

	$conn = mysqli_connect($host, $username, $password, $db);    

	$loggedEmail = $_POST['loggedEmail'];  

	date_default_timezone_set('Europe/Istanbul');
	

	$sql_getlastseen_status= "SELECT user_lastseen, user_status FROM user_information WHERE user_email = '$loggedEmail'";
	$result = mysqli_query($conn,$sql_getlastseen_status);

	if ($result->num_rows > 0) {  			
		 $row = mysqli_fetch_row($result);
		 
		 foreach($row as $key) {	
			 $date_lastseen = $row[0];
			 $status = $row[1];
		 }
	}

	$dt = new DateTime();
	$dateNow = $dt->format('Y-m-d H:i:s');

	$diff = abs(strtotime($dateNow) - strtotime($date_lastseen));	

	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
	$minutes  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
	$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60)); 

//printf("%d years, %d months, %d days\n", $years, $months, $days);

//echo "Last: " . $date_lastseen . "\nNow: " . $dateNow . "\nYears: " . $years . "\nMonths: " . $months ."\nDays: " . $days . "\nHours: " . $hours . "\nMinutes: " . $minutes . "\nSeconds: " . $seconds ;

echo json_encode(array("status" => $status, "awaytime" => $minutes));

	$conn->close();
?>