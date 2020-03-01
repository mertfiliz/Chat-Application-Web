<!DOCTYPE html>

<?php 

	session_start();
	$host = "localhost";
	$username = "root";
	$password = "";
	$db = "unicat";

	$conn = mysqli_connect($host, $username, $password, $db); 

	$_SESSION['logged'] = "0";

	// Eğer oturum açık değilse, session sıfırla. 
	if(empty($_SESSION['email'])) {            
		session_destroy();
	}
	else {     
		// Mevcut oturum acıksa profile' e yönlendir. Giriş sayfasını açma.
		echo "<script type='text/javascript'> document.location = 'http://localhost/unicat/profile.php'; </script>";
	}

?>

<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Unicat</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Favicons
			================================================== -->
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">

	<!-- Slider
			================================================== -->
	<link href="css/owl.carousel.css" rel="stylesheet" media="screen">
	<link href="css/owl.theme.css" rel="stylesheet" media="screen">

	<link rel="stylesheet" href="index.css">

	<!-- Stylesheet
			================================================== -->
	<link rel="stylesheet" type="text/css"  href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/nivo-lightbox/nivo-lightbox.css">
	<link rel="stylesheet" type="text/css" href="css/nivo-lightbox/default.css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300" rel="stylesheet" type="text/css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<script>            
		$(document).ready(function() {

			$(window).load(function() {
				$(".login-panel").hide();
			});


			$(".login-btn").click(function() {
				$(".login-panel").toggle();
				$(".register-btn").toggle();

			})

			$(".login-button").click(function() {
				$(".login-panel").show();

				var emailText = $(".login-email").val();
				var passwordText = $(".login-password").val();
				if(emailText == "") {
					$(".alertMessageEmail").html("Email address cannot be empty!");
				}
				else if(passwordText == "") {
					$(".alertMessageEmail").html("");
					$(".alertMessageLogin").html("Password cannot be empty!");
				}
				else {
					$(".alertMessageEmail").html("");
					$(".alertMessageLogin").html("");
					$.ajax({
						url:"login.php",
						type:"post",
						data:{sendEmail:emailText, sendPassword:passwordText},
						success: function(result) {
							var loginResult = result;  

							if(loginResult == 0) {
								$(".alertMessage").html("Informations are wrong!");
							}
							else { 
								$.ajax({
									url:"login-validate.php",
									type:"post",
									data:{loggedEmail:emailText},
									success: function(resultLogged) { 
										<?php $_SESSION["logged"] = "1"; ?>                                   

										var url = "http://localhost/unicat/profile.php";
										$(location).attr('href',url); 
									},
								});
							} 
						},
					});
				}  
			})

			$(".close-button").click(function() {
					$(".login-email").val("");
					$(".login-password").val("");
			})
		})        
	</script>

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

	<nav id="menu" class="navbar navbar-default navbar-fixed-top">
		<div class="container"> 
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand page-scroll" href="http://localhost/unicat/index.php">Unicat</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="http://localhost/unicat/register.php" class="register-btn">Register</a></li>
					<li><a href="" class="login-btn" data-toggle="modal" data-target="#loginModal" >Login</a></li>
					<div class="login-panel">
						<div class="login-panel-form">
							<div class="login-space"></div>
							<input class="login-input login-email" name="login-email" type="text" placeholder="Email"> 
							<div class="alertMessageEmail alertMsg"></div> 
							<div class="login-space"></div>             
							<input class="login-input login-password" name="login-password" type="password" placeholder="Password">
							<div class="alertMessageLogin alertMsg"></div> 
							<div class="login-space"></div> 
							<div class="login-space"></div>  
							<center><button type="button" class="btn-default login-button">Login</button></center>
							<div class="alertMessage alertMsg"></div>  
						</div> 
					</div>
				</ul>
			</div>		
		</div>
	</nav>

	<header id="header">
		<div class="intro">
			<div class="overlay">
				<div class="container">
					<div class="row">
						<div class="intro-text"> <span>Welcome to</span>
							<h1>Unicat</h1>
							<p>Join, Add Friends and Communicate easily!<br>Change Themes and Send Custom Emojies!</p>
							<a href="#about" class="btn btn-custom btn-lg page-scroll">Learn More</a>            
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>



	<div id="footer">
		<center><div class="footer-text">Unicat Chat Application - 2018 </div></center>
	</div>

	<script type="text/javascript" src="js/jquery.1.11.1.js"></script> 
	<script type="text/javascript" src="js/bootstrap.js"></script> 
	<script type="text/javascript" src="js/SmoothScroll.js"></script> 
	<script type="text/javascript" src="js/jquery.counterup.js"></script> 
	<script type="text/javascript" src="js/waypoints.js"></script> 
	<script type="text/javascript" src="js/nivo-lightbox.js"></script> 
	<script type="text/javascript" src="js/jquery.isotope.js"></script> 
	<script type="text/javascript" src="js/jqBootstrapValidation.js"></script> 
	<script type="text/javascript" src="js/contact_me.js"></script> 
	<script type="text/javascript" src="js/owl.carousel.js"></script> 
	<script type="text/javascript" src="js/main.js"></script>
</body>

</html>