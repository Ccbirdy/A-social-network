<?php
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
?>


<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Chengcheng's website program!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> <!-- jquery link https://developers.google.com/speed/libraries-->
	<script src="assets/js/register.js"></script>
</head>
<body>
	<div class="wrapper" >	

		<div class="login_box">
			<div class="login_header">
				<h3>CCfeed!</h3>
				Login or sign up below!
			</div>

			<div id="first">
				<form action="register.php" method = "POST"> 
					<input type="email" name="log_email" placeholder = "Email address"  value ="<?php
					if(isset($_SESSION['log_email'])){
						echo $_SESSION['log_email'];
					}		
					?>" required> 
					<br>
					<input type="password" name="log_password" placeholder = "Password" > 
					<br>				
					<?php if(in_array("Email or password was incorrect<br>",$error_array)) echo "Email or password was incorrect<br>";?>
					<input type = "submit" name = "login_button" value="Login">
					<br>
					<a href="#" id="signup" class="signup">Need an account? Register here!</a>
				</form>	
			</div>

			<div id="second">
				<form action= "register.php" method = "POST"> 
					<input type = "text" name = "register_vorname" placeholder="first name" value ="<?php
					if(isset($_SESSION['reg_vname']))
					{
						echo $_SESSION['reg_vname'];
					}
					?>"required>
					<br>
					<?php if(in_array("Your first name must between 2 and 25 characters.<br>", $error_array)) echo "Your first name must between 2 and 25 characters.<br>"; ?>


					<input type = "text" name = "register_nachname" placeholder="last name" value ="<?php
					if(isset($_SESSION['reg_lname']))
					{
						echo $_SESSION['reg_lname'];
					}
					?>"required>
					<br>
					<?php if(in_array("Your last name must between 2 and 25 characters.<br>", $error_array)) echo "Your last name must between 2 and 25 characters.<br>"; ?>



					<input type = "email" name = "register_email" placeholder="email" value ="<?php
					if(isset($_SESSION['reg_email']))
					{
						echo $_SESSION['reg_email'];
					}
					?>"required>
					<br>

					<input type = "email" name = "register_email2" placeholder="Confirm Email" value ="<?php
					if(isset($_SESSION['reg_email2']))
					{
						echo $_SESSION['reg_email2'];
					}
					?>"required>
					<br>

					<?php if(in_array("Email already in use.<br>", $error_array)) echo "Email already in use.<br>"; 
					 else if(in_array("Invalid format.<br>", $error_array)) echo "Invalid format.<br>"; 
					 else if(in_array("Emails do not match.<br>", $error_array)) echo "Emails do not match.<br>"; ?>


					<input type = "password" name = "register_password" placeholder="password" required>
					<br>
					<input type = "password" name = "register_password2" placeholder="confirm password" required>
					<br>
					
					<?php if(in_array("Your password do not match.<br>", $error_array)) echo "Your password do not match.<br>"; 
					else if(in_array("Your password can only contain english characters or numbers.<br>", $error_array)) echo "Your password can only contain english characters or numbers.<br>"; 
					else if(in_array("Your password must between 5 and 30 characters.<br>", $error_array)) echo "Your password must between 5 and 30 characters.<br>"; ?>

					<input type = "submit" name = "register_button" value="Register">
					<br>

					<?php if(in_array("<span style= 'color: #14C800;'>You are all set! Go ahead and login! </span><br>", $error_array)) echo "<span style= 'color: #14C800;'>You are all set! Go ahead and login! </span><br>"; ?>
					<a href="#" id="signin" class="signin">Already have an account? Sign in here!</a>


				</form>
			</div>
		</div>	

	</div>
</body>
</html>