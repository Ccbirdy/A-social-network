<?php

if(isset($_POST['login_button'])) {

	$email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); // make sure email correct fotmat // sanitize email

	$_SESSION['log_email'] = $email; // store email into session varible
	$password = md5($_POST['log_password']); // get password

	$check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'"); 
	 // check users table , look for email address, and password match
	$check_login_query = mysqli_num_rows($check_database_query);

	if($check_login_query == 1 ) {
		$row  = mysqli_fetch_array($check_database_query); // result from query store in array row
		$username = $row['username'];

		if($row['user_closed'] == "yes") {
    	$reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE email='$email'");
        }

		$_SESSION['username'] = $username;  // as long as session cotain username make the login
		header("Location: index.php");
		exit();
	}
	else {
		array_push($error_array, "Email or password was incorrect<br>");
		echo "HELLO";
	}
 
 
}
 
?>