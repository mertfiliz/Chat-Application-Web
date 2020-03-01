
    <?php 
        session_start();
        $host = "localhost";
        $username = "root";
        $password = "";
        $db = "unicat";
    
        $conn = mysqli_connect($host, $username, $password, $db); 

        $name = $_POST['sendName'];
        $surname = $_POST['sendSurname'];
        $email = $_POST['sendEmail'];
        $password = $_POST['sendPassword'];

        $sqlUserExists = "SELECT * FROM users WHERE email = '$email'";
        $resultUserExists = mysqli_query($conn, $sqlUserExists);


        if(mysqli_num_rows($resultUserExists) >= 1) {  
            $userExists = true;        
            echo $userExists;
        }
        else {     
            $userExists = false;
            echo $userExists;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $sql = "INSERT INTO users (name, surname, email, password) VALUES('$name', '$surname','$email','$password')";
            mysqli_query($conn, $sql);
					
						$sql_user_info = "INSERT INTO user_information(user_nickname, user_email, user_about, user_status) VALUES('$name', '$email', 'Hey!', 'Online')";
						mysqli_query($conn, $sql_user_info);
        }

   

    

    ?>
    
