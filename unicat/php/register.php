<!DOCTYPE html>
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

<!-- Stylesheet
    ================================================== -->
<link rel="stylesheet" type="text/css"  href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/nivo-lightbox/nivo-lightbox.css">
<link rel="stylesheet" type="text/css" href="css/nivo-lightbox/default.css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300" rel="stylesheet" type="text/css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="index.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
	$(document).ready(function() {           
                
		$(".register-button").click(function() {   
				var nameValue = $('.register-name').val();
				var surnameValue = $('.register-surname').val();
				var emailValue = $('.register-email').val();
				var passwordValue = $('.register-password').val();
				var password2Value = $('.register-password2').val(); 

				var isEmailValid = validateEmail(emailValue);                
				var passwordLength;
				var passwordIsCorrect;

				var checkRegister;

				if(passwordValue.length < 6) {
						passwordLength = false;
				}
				else {
						passwordLength = true;
				}

				if(passwordValue != password2Value) {
						passwordIsCorrect = false;
				}
				else {
						passwordIsCorrect = true;
				}

			 if(nameValue == "") {
				$(".alertMessageName").html("Name cannot be empty!"); 

			 } 
			 else {
						$(".alertMessageName").html(""); 
						if(surnameValue == "") {
								$(".alertMessageSurname").html("Surname cannot be empty!");
						}
						else {
								$(".alertMessageSurname").html("");
								if(emailValue == "") {
										$(".alertMessageEmail").html("Email cannot be empty!");
								}                        
								else {
										$(".alertMessageEmail").html("");
										if(!isEmailValid) {
												$(".alertMessageEmail").html("Email address is not valid!");
										}
										else {
												$(".alertMessageEmail").html("");
												if(passwordValue == "") {
														$(".alertMessagePassword").html("Password cannot be empty!");
												}
												else {
														$(".alertMessagePassword").html("");
														if(!passwordLength) {
																$(".alertMessagePassword").html("Password must be at least 6 digits");
														}
														else {
																$(".alertMessagePassword").html(""); 
																if(password2Value == "") {
																		$(".alertMessagePassword2").html("Re-Password cannot be empty!");
																}
																else {
																		$(".alertMessagePassword2").html("");
																		if(!passwordIsCorrect) {
																				$(".alertMessagePassword2").html("Passwords doesn't match!");
																		}
																		else {
																				$(".alertMessagePassword2").html("");

																				$.ajax({
																					 url:"register-validate.php",
																					 type:"post",
																					 data:{
																							 sendName:nameValue,
																							 sendSurname:surnameValue,
																							 sendEmail:emailValue,
																							 sendPassword:passwordValue,
																							 sendPassword2:password2Value
																					 },     
																						success: function(result) { 
																								checkRegister = result;                                                       
																								// if user exists.
																								if(checkRegister == true) {
																										$(".alertMessage").html("User Exists!");
																										$(".register-name").val("");
																										$(".register-surname").val("");
																										$(".register-email").val("");
																										$(".register-password").val("");
																										$(".register-password2").val("");
																								}

																								// if it's a new user.                                                     
																								if(checkRegister == false) {    
																										alert("Register Completed!");
																										var url = "profile.php";
																										$(location).attr('href',url);  
																								}                                                        
																					 }, 
																				 });
																		}
																}
														}
												}
										} 
								}
						}
				}               
		 })                           
	})


	function validateEmail(isEmail) {
		 var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

		 if (filter.test(isEmail)) {
				 return true;
		 }
		 else {
				 return false;
		 }
	}
	
</script>

</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">




<nav id="menu" class="navbar navbar-default navbar-fixed-top">
  <div class="container"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand page-scroll" href="http://localhost/unicat/index.php">Unicat</a> </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container-fluid --> 
</nav>
<!-- Header -->
<header id="header">  
 	<div class="intro">
    <div class="overlay">    
     
      <div class="container">
        <div class="col-sm-3"></div>                     
        <div class="col-sm-6">       
        	   
					<div class="register-border">    
							<center><div class="register-header">REGISTER</div></center>         
						<div class="register-form">
								<span>
									<input name="name" class="register-input register-name" type="text" placeholder="Name">
									<div class="register-space alertMessageName messageAlerts"></div>                   
								</span>

								<span>
									<input name="surname" class="register-input register-surname" type="text" placeholder="Surname">
									<div class="register-space alertMessageSurname messageAlerts"></div>
								</span>

								<span>
									<input name="email" class="register-input register-email" type="text" placeholder="Email">
									<div class="register-space alertMessageEmail messageAlerts" ></div> 
								</span>

								<span>
									<input name="password" class="register-input register-password" type="password" placeholder="Password">
									<div class="register-space alertMessagePassword messageAlerts" ></div>
								</span>

								<span>
									<input name="password2" class="register-input register-password2" type="password" placeholder="Confirm Password">
									<div class="register-space alertMessagePassword2 messageAlerts"></div>
								</span>

								<span>
									<center><button class="btn-default register-button" type="button">Register</button></center>
									<div class="register-space alertMessage"></div>
								</span> 
								
						</div>
					</div>          
          <div class="intro-text"></div>
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