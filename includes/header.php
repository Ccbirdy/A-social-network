<?php 
require 'config/config.php';
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");

if (isset($_SESSION['username'])) {         /* if you not logged in , you cant see index.php  */
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn' ");
	$user = mysqli_fetch_array($user_details_query);
}
else {
	header("Location: register.php");
}
?>

<html>
<head>
	<title>welcome to CC and her friends !</title>     <!-- https://getbootstrap.com/docs/5.0/getting-started/download/-->

	<!-- Javascript  -->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<!--You are calling the ready function before the jQuery JavaScript is included. Reference jQuery first. -->		
	<script src="https://kit.fontawesome.com/fd2ffeb797.js" crossorigin="anonymous"></script>
    <!-- https://stackoverflow.com/questions/12458522/bootstrap-dropdown-not-working/65096525#65096525   -->
    <!-- without this cannot dropdown  -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>  <!-- make sure you are including jQuery before bootstrap. -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/bootbox.min.js"></script>
	<script src="assets/js/demo.js"></script>
	<script src="assets/js/jquery.Jcrop.js"></script>
	<script src="assets/js/jcrop_bits.js"></script>


	<!-- CSS  -->
	<!-- <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">  -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />



</head>
<body>	

	<div class="top_bar">

		<div class="logo">
			<a href="index.php">CC and her friends!</a>		
			<!--  <img src="">		 -->			
		</div>

		<nav>
			  <a href="<?php echo $userLoggedIn; ?>">
					<?php echo $user['first_name'] ?>
				</a>

				<a href="index.php">
					<i class="fas fa-igloo"></i> 
				</a>	

				<a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')">
					<i class="far fa-envelope"></i> 
				</a>

				<a href="#">
					<i class="fas fa-inbox"></i>
				</a>	

				<a href="requests.php">
					<i class="fas fa-user-friends"></i>
				</a>

				<a href="upload.php">
					<i class="fas fa-cog"></i>
				</a>

				<a href="includes/handlers/logout.php">
					<i class="fas fa-sign-out-alt"></i>
				</a>


		</nav>
		
		<!--Dropdown Message Box (From Navigation Menu)-->
		<div class="dropdown_data_window" style="height:0px; border:none;"></div>
		<input type="hidden" id="dropdown_data_type" value="">
	</div>

	<script> // from index.php 
	var userLoggedIn = '<?php echo $userLoggedIn; ?>';

	$(document).ready(function() {

		$('.dropdown_data_window').scroll(function() {
			var inner_height = $('.dropdown_data_window').innerHeight(); //Div containing data
			var scroll_top = $('.dropdown_data_window').scrollTop();
			var page = $('.dropdown_data_window').find('.nextPageDropdownData').val(); // loof for these in Message.php
			var noMoreData = $('.dropdown_data_window').find('.noMoreDropdownData').val();

			if ((scroll_top + inner_height >= $('.dropdown_data_window')[0].scrollHeight) && noMoreData == 'false') {

				var pageName; //Holds name of page to send ajax request to
				var type = $('#dropdown_data_type').val();


				if(type == 'notification')
					pageName = "ajax_load_notifications.php";
				else if(type = 'message')
					pageName = "ajax_load_messages.php"


				var ajaxReq = $.ajax({
					url: "includes/handlers/" + pageName,
					type: "POST",
					data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
					cache:false,

					success: function(response) {
						$('.dropdown_data_window').find('.nextPageDropdownData').remove(); //Removes current .nextpage 
						$('.dropdown_data_window').find('.noMoreDropdownData').remove(); //Removes current .nextpage 


						$('.dropdown_data_window').append(response);
					}
				});

			} //End if 

			return false;

		}); //End (window).scroll(function())


	});

	</script>	

	<div class ="wrapper">