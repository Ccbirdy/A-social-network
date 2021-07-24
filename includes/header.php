<?php 
require 'config/config.php';
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");
include("includes/classes/Notification.php");

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
		<!--  search form   -->
		<div class="search">

			<form action="search.php" method="GET" name="search_form">
				<input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn; ?>')" name="q" placeholder="Search..." autocomplete="off" id="search_text_input">

				<div class="button_holder">
					<img src="assets/images/icons/magnifying_glass.png">
				</div>

			</form>

			<div class="search_results">
			</div>

			<div class="search_results_footer_empty">
			</div>



		</div>





		<nav>
			<?php
				//Unread messages 
				$messages = new Message($con, $userLoggedIn);
				$num_messages = $messages->getUnreadNumber();

				//Unread notifications 
				$notifications = new Notification($con, $userLoggedIn);
				$num_notifications = $notifications->getUnreadNumber();

				//friend request bedge 
				$user_obj = new User($con, $userLoggedIn);
				$num_requests = $user_obj->getNumberOfFriendRequests();

				
			?>

			<a href="<?php echo $userLoggedIn; ?>">
				<?php echo $user['first_name'] ?>
			</a>

			<a href="index.php">
				<i class="fas fa-igloo"></i> 
			</a>	

			<a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')">
				<i class="far fa-envelope"></i> 
				<?php
				if($num_messages > 0)
				 echo '<span class="notification_badge" id="unread_message">' . $num_messages . '</span>';
				?>
			</a>

			<a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'notification')">
				<i class="fa fa-bell fa-lg"></i>
				<?php
				if($num_notifications > 0)
				 echo '<span class="notification_badge" id="unread_notification">' . $num_notifications . '</span>';
				?>
			</a>	

			<a href="requests.php">
				<i class="fas fa-user-friends"></i>
				<?php
				if($num_requests > 0)
				 echo '<span class="notification_badge" id="unread_requests">' . $num_requests . '</span>';
				?>				
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
	<!--infinite scroll message dropdown window -->
	<script>// change limit in ajax_load_messages.php
    $(function(){
 
        var userLoggedIn = '<?php echo $userLoggedIn; ?>';
        var dropdownInProgress = false;
 
        $(".dropdown_data_window").scroll(function() { // use drop down window so the 2 scroll dont scroll together
            var bottomElement = $(".dropdown_data_window a").last();
            var noMoreData = $('.dropdown_data_window').find('.noMoreDropdownData').val();
 
            // isElementInViewport uses getBoundingClientRect(), which requires the HTML DOM object, not the jQuery object. The jQuery equivalent is using [0] as shown below.
            if (isElementInView(bottomElement[0]) && noMoreData == 'false') {
                loadPosts();
            }
        });
 
        function loadPosts() {
            if(dropdownInProgress) { //If it is already in the process of loading some posts, just return
                return;
            }
            
            dropdownInProgress = true;
 
            var page = $('.dropdown_data_window').find('.nextPageDropdownData').val() || 1; //If .nextPage couldn't be found, it must not be on the page yet (it must be the first time loading posts), so use the value '1'
 
            var pageName; //Holds name of page to send ajax request to
            var type = $('#dropdown_data_type').val();
 			// infinite scroll don't work on drop down and post at same time
            if(type == 'notification')
                pageName = "ajax_load_notifications.php";
            else if(type == 'message')
                pageName = "ajax_load_messages.php";
 
            $.ajax({
                url: "includes/handlers/" + pageName,
                type: "POST",
                data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                cache:false,
 
                success: function(response) {
 
                    $('.dropdown_data_window').find('.nextPageDropdownData').remove(); //Removes current .nextpage 
                    $('.dropdown_data_window').find('.noMoreDropdownData').remove();
 
                    $('.dropdown_data_window').append(response);
 
                    dropdownInProgress = false;
                }
            });
        }
 
        //Check if the element is in view
        function isElementInView (el) {
            var rect = el.getBoundingClientRect();
 
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && //* or $(window).height()
                rect.right <= (window.innerWidth || document.documentElement.clientWidth) //* or $(window).width()
            );
        }
    });
 
	</script>

	<div class ="wrapper">