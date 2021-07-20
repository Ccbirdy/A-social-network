<?php 
require 'config/config.php';

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
	<script src="assets/js/bootstrap.js"></script>
	<script src="https://kit.fontawesome.com/fd2ffeb797.js" crossorigin="anonymous"></script>
    <!-- https://stackoverflow.com/questions/12458522/bootstrap-dropdown-not-working/65096525#65096525   -->
    <!-- without this cannot dropdown  -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

	<!-- CSS  -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css"> 
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">



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

				<a href="#">
					<i class="far fa-envelope"></i> 
				</a>

				<a href="#">
					<i class="fas fa-inbox"></i>
				</a>	

				<a href="#">
					<i class="fas fa-user-friends"></i>
				</a>

				<a href="includes/handlers/logout.php">
					<i class="fas fa-sign-out-alt"></i>
				</a>


		</nav>
	</div>

	<div class ="wrapper">