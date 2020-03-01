
    <?php 
        session_start();
        $host = "localhost";
        $username = "root";
        $password = "";
        $db = "unicat";
    
        $conn = mysqli_connect($host, $username, $password, $db); 

        $email = $_POST['sendEmail'];
        $password = $_POST['sendPassword'];
    
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        $check = mysqli_fetch_array($result);
        
        if(isset($check)) {
            echo 1;
        } else {
            echo 0;
        }

    

    ?>
    
