<?php 
    session_start();
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "unicat";

    $conn = mysqli_connect($host, $username, $password, $db);    

		$nickname = $_POST['nickname'];
		$about = $_POST['about'];
		$loggedEmail = $_SESSION['email'];

		$sql = "UPDATE user_information SET user_nickname = '$nickname', user_about = '$about' WHERE user_email = '$loggedEmail'";
		mysqli_query($conn, $sql);




    $conn->close();
?>