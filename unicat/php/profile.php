<!DOCTYPE html>

<?php 
	session_start();
	$host = "localhost";
	$username = "root";
	$password = "";
	$db = "unicat";

	$conn = mysqli_connect($host, $username, $password, $db); 


	if(empty($_SESSION['email']))
	{           
		header("Location: http://localhost/unicat/index.php");  
		exit();
	}
	else {
		$loggedEmail = $_SESSION['email']; 
		$loggedName = $_SESSION['name'];         
	}

	$t1 = "123";
?>

<html>
		<head>
		<title>Chat</title>
		
			
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
		<link rel="stylesheet" type="text/css"  href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/nivo-lightbox/nivo-lightbox.css">
		<link rel="stylesheet" type="text/css" href="css/nivo-lightbox/default.css">
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300" rel="stylesheet" type="text/css">
		
				
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
		
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="mert.css">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

   
   
		<script>		
			
			var receiver_email = "";	
			var receiver_name = "Chat Bot";

			var row_counter = 1;
			var row_counter_notifications = 1;
			var row_counter_friends = 1;

			var msgNo_counter;

				
			var friend_email = "none";
			var friend_nickname = "none";
			var friend_about = "none";
			var friend_status = "none";
			
			var onlineCollapse = false;
			
			var online_friend_ct = 0;
			var offline_friend_ct = 0;
			
			var online_friend;
			
			var selected_friend_email;
			var friend_selected = false;
			
			var message_loaded = false;
			
			var hasMessages = [];
						
					
			$(document).ready(function() {	
				
				
				informations();		
				checkHasMessages();
				
				setInterval(function(){
					showFriends();					
					printAllMessage();
					printAllLastMessage();
					getFriendRequestNotifications();		
						
				},50); 
				
			
				function informations() {
					var loggedEmail = '<?php echo $loggedEmail; ?>';
					var loggedName = '<?php echo $loggedName; ?>';

					$.ajax({
						url:"informations-user.php",
						type:"post",
						dataType:"JSON",
						data:{loggedEmail: loggedEmail, loggedName:loggedName},
						success: function(result) {

						$(".nickname").append(result.user_nickname);						
						$(".status").append(result.user_status);						
						$(".about").append(result.user_about);						

						}
					})
				}
				
				/* Email address target silme 
					$(".btn").on("click", function() {
						 //Online_Friend_Counter();		
					})
				*/
				function Remove_From_Online() {
					if(onlineCollapse) { /* EGER TUM LISTE DOLDUYSA */
						//alert(online_friend_ct);					
						for(var ctt=0;ctt<online_friend_ct;ctt++) {
							var b = $(".friend_information").eq(ctt).attr("value");

							if(b == "testbot2@gmail.com") {
								$(".friend_information").eq(ctt).closest("li").remove();
								break;
							}					
						}
					}
				}
				
			 				
				
			function showFriends() {
			 $.ajax({
				 url:"show-friend-list.php",
				 type:"post",
				 dataType:"json",					 
				 data:{row_counter_friends:row_counter_friends},
				 success: function(result) {					 
					 
					if(row_counter_friends <= result.ct) {
						friend_email = result.friend_email;						
						
						//alert(row_counter_friends);
							$.ajax({
								url:"informations-friend.php",
								type:"post",
								async: false,
								dataType:"json",							
								data:{friend_email:friend_email},
								success: function(result) {									
										
									if(result.user_status == "Online") {
										online_friend_ct++;
										
										$(".section_online").append('<li><div class="d-flex bd-highlight  friend_information" value="'+friend_email+'"><div class="friend_photo"><img src="dog.jpg" class="rounded-circle user_img"> </div><div class="friend_info"><span class="friend_nickname">'+result.user_nickname+'</span><p class="friend_about">'+result.user_about+'</p><p class="friend_status">'+result.user_status+'</p></div></div></li>');	
									
									}
									
									else if(result.user_status == "Offline") {
										offline_friend_ct++;
										
										$(".section_offline").append('<li><div class="d-flex bd-highlight friend_information" value="'+friend_email+'"><div class="friend_photo"><img src="dog.jpg" class="rounded-circle user_img"> </div><div class="friend_info"><span class="friend_nickname">'+result.user_nickname+'</span><p class="friend_about">'+result.user_about+'</p><p class="friend_status">'+result.user_status+'</p></div></div></li>');									
									}									
								}		
							})			
						row_counter_friends++;
					 }						
									 
				 if(row_counter_friends > result.ct) {		
					 onlineCollapse = true;
					 
					 $(".online_ct").html(' ('+online_friend_ct+') ');
					 $(".offline_ct").html(' ('+offline_friend_ct+') ');
				
				 }			
					  
				 }
							
			 })		
				
			}
				
			/*
			function Online_Friend_Counter() {
				var loggedEmail = '<?php echo $loggedEmail; ?>';
				$.ajax({
					url:"online-friend-counter.php",
					type:"post",
					dataType:"json",					 
				  data:{row_counter_friends:row_counter_friends},
					success: function(result) {
						alert(result);
					}					
				})
			}
			*/
												
			/* Getting Friend Email and Name	*/
			$(document).on('click', '.friend_information', function() {		
				if(friend_selected == false) {
					friend_email = $(this).attr('value');
					receiver_email = $(this).attr('value');
					friend_nickname = $(this).find('.friend_nickname').html();
					friend_about = $(this).find('.friend_about').html();
					friend_status = $(this).find('.friend_status').html();
					//alert(friend_email + "-" + friend_nickname);

					$('.selected_friend_nickname').html(friend_nickname);
					$('.selected_friend_about').html(friend_about);
					$('.selected_friend_status').html(friend_status);
				
					
					$('.chatbox').css("visibility", "visible");
					$(".chatlogs").html(''); // Mesaj kutusunu temizliyor.
					row_counter = 1; // Baştan göstermesi için ilk texte dönüyoruz.
					selected_friend_email = friend_email;
					friend_selected = true;	
				}
				else {
					var selected_friend_email_new =  $(this).attr('value');
					if(selected_friend_email == selected_friend_email_new) {
						
					}
					else {					
						friend_email = $(this).attr('value');
						receiver_email = $(this).attr('value');
						friend_nickname = $(this).find('.friend_nickname').html();
						friend_about = $(this).find('.friend_about').html();
						friend_status = $(this).find('.friend_status').html();
						//alert(friend_email + "-" + friend_nickname);

						$('.selected_friend_nickname').html(friend_nickname);
						$('.selected_friend_about').html(friend_about);
						$('.selected_friend_status').html(friend_status);


						$('.chatbox').css("visibility", "visible");
						$(".chatlogs").html(''); // Mesaj kutusunu temizliyor.
						row_counter = 1; // Baştan göstermesi için ilk texte dönüyoruz.
						selected_friend_email = friend_email;
					}				
				}
				
			}); 
				
				
			$(document).on('click', '.message_information', function() {		
				if(friend_selected == false) {
					friend_email = $(this).attr('value');
					receiver_email = $(this).attr('value');
					friend_nickname = $(this).find('.friend_nickname').html();
					friend_about = $(this).find('.friend_about').html();
					friend_status = $(this).find('.friend_status').html();
					//alert(friend_email + "-" + friend_nickname);

					$('.selected_friend_nickname').html(friend_nickname);
					$('.selected_friend_about').html(friend_about);
					$('.selected_friend_status').html(friend_status);
				
					
					$('.chatbox').css("visibility", "visible");
					$(".chatlogs").html(''); // Mesaj kutusunu temizliyor.
					row_counter = 1; // Baştan göstermesi için ilk texte dönüyoruz.
					selected_friend_email = friend_email;
					friend_selected = true;
				}
				else {
					var selected_friend_email_new =  $(this).attr('value');
					if(selected_friend_email == selected_friend_email_new) {
						
					}
					else {					
						friend_email = $(this).attr('value');
						receiver_email = $(this).attr('value');
						friend_nickname = $(this).find('.friend_nickname').html();
						friend_about = $(this).find('.friend_about').html();
						friend_status = $(this).find('.friend_status').html();
						//alert(friend_email + "-" + friend_nickname);

						$('.selected_friend_nickname').html(friend_nickname);
						$('.selected_friend_about').html(friend_about);
						$('.selected_friend_status').html(friend_status);


						$('.chatbox').css("visibility", "visible");
						$(".chatlogs").html(''); // Mesaj kutusunu temizliyor.
						row_counter = 1; // Baştan göstermesi için ilk texte dönüyoruz.
						selected_friend_email = friend_email;
					}				
				}				
			});	
			
				
			function checkHasMessages() {
				/* Some problems here 
				
				$.ajax({
					url:"check-has-message.php",
					type:"post",
					data:{receiver_email:receiver_email},
					success: function(result) {
						alert(result);
					}					
				})
				*/
			}
				
			function printAllMessage() {
				$.ajax({
				 url:"chatlogs-output.php",
				 type:"post",
				 dataType: 'json',
				 async: false,
				 data:{row_counter:row_counter, receiver_email:receiver_email},
				 success: function(result) {	
					
					if(row_counter <= result.ct) {	
																	
						if(result.sender_email == result.logged_email ) {

							$( ".chatlogs").append('<div class="d-flex justify-content-start mb-4"><div class="img_cont_msg"><img src="cat.jpg" class="rounded-circle user_img_msg"></div><div class="msg_cotainer">'+result.message+ '<span class="msg_time">'+result.date+'</span></div></div>');
						}			

						else {			

							$( ".chatlogs").append('<div class="d-flex justify-content-end mb-4"><div class="msg_cotainer_send">'+result.message+'<span class="msg_time_send">'+result.date+'</span></div><div class="img_cont_msg"><img src="dog.jpg" class="rounded-circle user_img_msg"></div></div>');
				
						}		
						
						row_counter++;
						printAllMessage();
						scrolldown();
					}					 
					 
					if(row_counter> result.ct){
						message_loaded = true;
					}

				 }	
				})
		 } 
		
		function printAllLastMessage() {
			$.ajax({
				url:"show-last-message.php",
				type:"post",
				dataType:"JSON",
				async:"false",
				data: {},
				success: function(result) {
					//$(".message-list").append('<li><div class="d-flex bd-highlight message_information" value="'+result.friend_email+'"><div class="friend_photo"><img src="dog.jpg" class="rounded-circle user_img"></div><div class="friend_info"><span class="message-list-nickname">'+result.friend_email+'</span><p class="message-list-last">'+result.last_message+'</p><p class="message-list-status">Online</p></div></li>');	
				}
			})
		}
				
		/* MESAJ YOLLAMA KISMI */ 
		$(".typebox-button").click(function() {
			var sender_message = $(".typebox-input").val();			
			if(sender_message != "") {/* Mesaj boş degilse */
				
				/* Mesajları listeler */
				$.ajax({
					url:"typebox-input.php",
					type:"post",
					async:"false",				
					data:{receiver_email:receiver_email, receiver_name:receiver_name, sender_message:sender_message},
					success: function(result) {
						$(".typebox-input").val("");	
					  //printAllMessage();								
					}					
				})
				
				
				/* Son mesajları yazar */
				$.ajax({
					url:"check-has-message.php",
					type:"post",		
					async:"false",
					dataType:"JSON",
					data: {friend_email:friend_email},
					success: function(result) {											
						
						//var f_email = result.friend_email;						
						
						/* Some problems here */
						
					
						/*
						if(result.msg_list_exists) {
						//	alert("daha once konusma kaydi var");
							$(".message_information").each(function() {
								var emailExistCheck = $(this).attr('value');
								
								if(emailExistCheck == f_email) {
									$(this).find('.message-list-last').html(result.last_message);
									return false;
								}								
							})	
							//$(this).closest(".notif-border").find('#notification-friend-email').html();

						}
						
						else {
							$(".message-list").append('<li><div class="d-flex bd-highlight message_information" value="'+result.friend_email+'"><div class="friend_photo"><img src="dog.jpg" class="rounded-circle user_img"></div><div class="friend_info"><span class="message-list-nickname">'+result.friend_email+'</span><p class="message-list-last">'+result.last_message+'</p><p class="message-list-status">Online</p></div></li>');	
						}
						*/
			}
				})
			}
		});
			
		$(".input-group-prepend").click(function() {
			var add_friend_request = $(".search").val();
			
			$.ajax({
				url:"add-friend-request-validate.php",
				type:"post",
				data:{add_friend_request:add_friend_request},
				success: function(result) {
					alert(result);
				}
			})		
		
		})
				
		$(document).on('click', '.accept-btn', function() {
			$friend_request_email = $(this).closest(".notif-border").find('#notification-friend-email').html();
			//alert($friend_request_email);
			 
			 $.ajax({
				 url:"friend-request-accept.php",
				 type:"post",
				 data:{friend_request_email:$friend_request_email},
				 success: function(result) {		
					 $(".notification-friend").html("");
					 row_counter_notifications = 1;
				 }
			 })			 
		 });
				
		$(document).on('click', '.decline-btn', function() {
			$friend_request_email = $(this).closest(".notif-border").find('#notification-friend-email').html();
			//alert($friend_request_email);
						 
			 $.ajax({
				 url:"friend-request-decline.php",
				 type:"post",			 
				 data:{friend_request_email:$friend_request_email},
				 success: function(result) {		
					 $(".notification-friend").html("");
					 row_counter_notifications = 1;
					alert(result);
				 }
			 })	
			 
		 });
				
		function getFriendRequestNotifications() {
			$.ajax({
				url:"get-friend-request-notifications.php",
				type:"post",
				dataType: 'json',
				async: false,
				data:{row_counter_notifications:row_counter_notifications},
				success: function(result) {
					$name_surname = result.sender_name + ' ' + result.sender_surname;					
					
					if(row_counter_notifications <= result.ct) {					
						$(".notification-friend").append('<div class="notif-border"><div><b>'+$name_surname+'</b> wants to be your friend.</div><div id="notification-friend-email">'+result.sender_email+'</div><div><a class="accept-btn"><i class="fas fa-check"> Accept</i></a><a class="decline-btn"><i class="fas fa-times"> Decline</i></a></div>');
					}							
					row_counter_notifications++;
					//getFriendRequestNotifications();					
				}
			})
		}
		
				
		function scrolldown() {
			$('.chatlogs').scrollTop($('.chatlogs')[0].scrollHeight);
		}
												
		$(".sign-out").click(function() { 
			var signOut = confirm("Do you want to sign out?");

			if(signOut) {
					$.ajax({    
							url:"sign-out.php",
							type:"post",
							data:{signOut:signOut},
							success: function(result) {
									if(result = "1") {																						
										window.location.href = 'index.php';
									}
							} 
					});
			}
		});
				
		// COLLAPSE SECTION
				
		$(".online-btn").click (function() {
			if(onlineCollapse == true) {
				$(".collapseOn").collapse("toggle");	
			}	

		})		

		$(".offline-btn").click (function() {
			if(onlineCollapse == true) {
				$(".collapseOff").collapse("toggle");	
			}					

		})			
				
		// MENU_TAB ACTIVE
				
		$(".menu_tab").on("click", function() {
			$(".menu_tab").find(".active").removeClass('active');
			$(this).parent('.btn').addClass('active');
		})
				
		// FRIEND HOVER DISPLAY DROPDOWN
				
		$(".friend_information").on("mouseover" , function() {
			var a = $(this).closest(".friend_information").html();			
		})
						
				
	});			
		
	

		</script>
			
		
	</head>
	<body>
		
	
		<div class="container-fluid">				
			<div class="row justify-content">
				
				<div class="col-md-12">							
						<div class="user-spaces"></div>		
					<div class="top-panel top-panel-text"><a href="http://localhost/unicat/index.php">UNICAT</a>	
						<a href="#" class="sign-out sign-out">Sign Out</a>		
						<a href="" class="right"><?php echo $loggedName; ?></a>	
							
					</div>	
				</div>
			
				<div class="col-md-5 col-xl-3 chat">
					<div class="card mb-sm-3 mb-md-0 contacts_card">						
						<div class="user-panel">
							<ui class="contacts">
								<div class="user-spaces">
									<div class="d-flex bd-highlight">
										<div class="img_cont">
										 <img src="cat.jpg" class="rounded-circle user_img"> 
											<span class="online_icon"></span>
										</div>
										<div class="user_info">
											<span class="nickname"><!--Nickname--></span>
											<p class="about"><!--~This is what i'm thinking~--></p>
											<p class="status"><!--Online--></p>
										</div>										
									</div>			
								</div>
							</ui>							
					</div>
					<div class="card-header">
						<div class="input-group">
							<input spellcheck="false" type="text" placeholder="Add Friend" name="" class="form-control search">
							<div class="input-group-prepend">
								<span class="input-group-text search_btn"><i class="fas fa-plus"></i></span>
							</div>						
							
						</div>
						<div class="navbar menu_tab">
							
							<a class="btn friendlist_tab active" href="#friendlist_tab" data-toggle="tab"><i class="fas fa-user-friends"></i></a>
							<a class="btn notification_tab "href="#notification_tab" data-toggle="tab"><i class="far fa-bell"></i></a>
							<a class="btn messages_tab "href="#messages_tab" data-toggle="tab"><i class="far fa-comments"></i></a>																	
						</div>			
					</div>							
						
					<div class="card-body contacts_body scrollbar-notification square thin">
						<div class="tab-content">
						<div class="tab-pane active" id="friendlist_tab">
							<div class="menu-name">Friend List</div>
							
					
						<ui class="contacts friend_section-favorite">
							<a class="btn favourite-btn" ><i class="fas fa-star favorite-icon"></i> Favorite (0) <i class="fas fa-sort-down icon-right"></i></a>
						</ui>
							
						<ui class="contacts friend_section-online">
							
								<a class="btn online-btn" >
									<i class="fas fa-user-friends online-icon"></i>
									Online
									<span class="online_ct"></span>
									<i class="fas fa-sort-down icon-right"></i>
								</a>
							
							<!--
								<div class="collapse collapseOn show" id="onlineSection">
									<div class="section_online"></div>
								</div>
							-->
							<div class="section_online collapse collapseOn show" id="onlineSection"></div>
								
								
						</ui>
							
						<ui class="contacts friend_section-offline">
							
							<a class="btn offline-btn" >
								<i class="fas fa-user-friends offline-icon"></i>
								Offline
								<span class="offline_ct"></span>
								<i class="fas fa-sort-down icon-right"></i>
							</a>
							
							<div class="section_offline collapse collapseOff hide" id="offlineSection"></div>	
							
						</ui>
														
						</div>
							
							
							<div class="tab-pane" id="notification_tab">
								 <div class="menu-name">Notifications</div>								
								 <div class="notification-friend ">		
								</div>
								
								<ul>	
									<li>
										<div class="d-flex bd-highlight notification_friend">

										</div>
									</li>	
								</ul>
							</div>			
							
							<div class="tab-pane" id="messages_tab">
								 <div class="menu-name">Messages</div>
								 <div class="message-list">
							<!--
									 <li>
									 	<div class="d-flex bd-highlight message_information">
										 	<div class="friend_photo"><img src="https://2.bp.blogspot.com/-8ytYF7cfPkQ/WkPe1-rtrcI/AAAAAAAAGqU/FGfTDVgkcIwmOTtjLka51vineFBExJuSACLcBGAs/s320/31.jpg" class="rounded-circle user_img">
											</div>
											<div class="friend_info">
												<span class="message-list-nickname">Test</span>
												<p class="message-list-last">Son mesaj</p>												
												<p class="message-list-status">Online</p>												
											</div>
										</div>
									 </li>				
									 
									  <li>
									 	<div class="d-flex bd-highlight message_information">
										 	<div class="friend_photo"><img src="https://2.bp.blogspot.com/-8ytYF7cfPkQ/WkPe1-rtrcI/AAAAAAAAGqU/FGfTDVgkcIwmOTtjLka51vineFBExJuSACLcBGAs/s320/31.jpg" class="rounded-circle user_img">
											</div>
											<div class="friend_info">
												<span class="message-list-nickname">Test</span>
												<p class="message-list-last">Son mesaj</p>												
												<p class="message-list-status">Online</p>												
											</div>
										</div>
									 </li>					
									 
									  <li>
									 	<div class="d-flex bd-highlight message_information">
										 	<div class="friend_photo"><img src="https://2.bp.blogspot.com/-8ytYF7cfPkQ/WkPe1-rtrcI/AAAAAAAAGqU/FGfTDVgkcIwmOTtjLka51vineFBExJuSACLcBGAs/s320/31.jpg" class="rounded-circle user_img">
											</div>
											<div class="friend_info">
												<span class="message-list-nickname">Test</span>
												<p class="message-list-last">Son mesaj</p>												
												<p class="message-list-status">Online</p>												
											</div>
										</div>
									 </li>					
							
									!-->
									
								 </div>
							</div>
							
						</div>
					</div>
					<div class="card-footer"></div>
					</div>
				</div>
				<div class="col-md-7 col-xl-9 chat">
					<div class="card chatbox" >
						<div class="card-header msg_head chat-top-section">			
						<div class="user-spaces">	
							<div class="d-flex bd-highlight">
								<div class="img_cont">
								<img src="dog.jpg" class="rounded-circle user_img">
									<span class="online_icon"></span>
								</div>
								<div class="user_info">
									<span class="selected_friend_nickname scrollbar-dusty-grass square thin"></span>
									<p class="selected_friend_about"></p>
									<p class="selected_friend_status"></p>
								</div>
								<div class="video_cam">
									<span><i class="fas fa-video"></i></span>
									<span><i class="fas fa-phone"></i></span>
								</div>
								</div>		
							</div>
							<span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
							<div class="action_menu">
								<ul>
									<li><i class="fas fa-user-circle"></i> View profile</li>
									<li><i class="fas fa-users"></i> Add to close friends</li>
									<li><i class="fas fa-plus"></i> Add to group</li>
									<li><i class="fas fa-ban"></i> Block</li>
								</ul>
							</div>
						</div>
						
					
						<div class="card-body msg_card_body chatlogs scrollbar-dusty-grass square thin">
							<div class="d-flex justify-content-start mb-4">
								<div class="img_cont_msg">							
								</div>								
							</div>
							<div class="d-flex justify-content-end mb-4">								
								<div class="img_cont_msg">
									<img src="cat.jpg" class="rounded-circle user_img_msg"> 
								</div>
							</div>							
						</div> 
						<div class="card-footer">
							<div class="input-group">
								<div class="input-group-append">
									<span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
								</div>
								<textarea spellcheck="false" class="form-control type_msg typebox-input" placeholder="Type your message..."></textarea>
								<div class="input-group-append typebox-button">
									<span class="input-group-text send_btn"><i class="fas fa-location-arrow "></i></span>
								</div>
							</div>
						</div>
						
					</div>
					 
				</div>
				<div class="col-md-12">		
				</div>
			</div>
				
			</div>
		
	</body>
</html> 
