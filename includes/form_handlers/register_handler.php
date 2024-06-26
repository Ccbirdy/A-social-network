<?php
// declaring variables to prevent errors
$vorname = ""; // first name
$nachname = ""; // last name
$em = ""; // email
$em2 = ""; // email2
$password = ""; // password
$password2 = ""; // password2
$date = ""; //sign up date
$error_array = array(); //holds error message

if(isset($_POST['register_button']))
{
	// register form values

	// first name
	$vorname = strip_tags($_POST['register_vorname']);// for safe get rid of <a> // remove gtml tags
	$vorname = str_replace(' ', '', $vorname); // get rid of space // remove spaces
	$vorname = ucfirst(strtolower($vorname)); // Uppercase first letter  // change into small buchstabe
	$_SESSION['reg_vname'] = $vorname; // stroe first name into session variable

	// last name
	$nachname = strip_tags($_POST['register_nachname']);// for safe get rid of <a> // remove gtml tags
	$nachname = str_replace(' ', '', $nachname); // get rid of space // remove spaces
	$nachname = ucfirst(strtolower($nachname)); // Uppercase first letter  // change into small buchstabe
	$_SESSION['reg_lname'] = $nachname;

	// email
	$em = strip_tags($_POST['register_email']);// for safe get rid of <a> // remove gtml tags
	$em = str_replace(' ', '', $em); // get rid of space // remove spaces
	//$em = ucfirst(strtolower($em)); // Uppercase first letter  // change into small buchstabe
	$_SESSION['reg_email'] = $em;

	// email2
	$em2 = strip_tags($_POST['register_email2']);// for safe get rid of <a> // remove gtml tags
	$em2 = str_replace(' ', '', $em2); // get rid of space // remove spaces
	//$em2 = ucfirst(strtolower($em2)); // Uppercase first letter  // change into small buchstabe
	$_SESSION['reg_email2'] = $em2;

	// password
	$password = strip_tags($_POST['register_password']);// for safe get rid of <a> // remove gtml tags
	//$password = str_replace(' ', '', $password); //   password may include space  
	//$password = ucfirst(strtolower($password)); //   password also cant convert to lower
	$password2 = strip_tags($_POST['register_password2']);// for safe get rid of <a> // remove gtml tags

	$date = date("Y-m-d"); // get current date

	if($em == $em2)
	{
		// check if email in valid format
		if(filter_var($em, FILTER_VALIDATE_EMAIL))
		{
			$em = filter_var($em, FILTER_VALIDATE_EMAIL);  // = rhs : the validate version of email

			// check if email already exists
			$e_check = mysqli_query($con, "SELECT email FROM users WHERE email = '$em' " );

			// count the number of rows returned
			$num_rows = mysqli_num_rows($e_check);

			if($num_rows > 0)
			{
				array_push($error_array, "Email already in use.<br>");
			}


		}
		else
		{
			array_push($error_array, "Invalid format.<br>");
		}
	

	}
	else
	{
		array_push($error_array, "Emails do not match.<br>");
	}

	if(strlen($vorname) > 25 || strlen($vorname) < 2)
	{
		array_push($error_array, "Your first name must between 2 and 25 characters.<br>");
	}

	if(strlen($nachname) > 25 || strlen($nachname) < 2)
	{
		array_push($error_array, "Your last name must between 2 and 25 characters.<br>");
	}

	if($password != $password2)
	{
		array_push($error_array, "Your password do not match.<br>");
	}
	else
	{
		if(preg_match('/[^A-Za-z0-9]/', $password))
		{
			array_push($error_array, "Your password can only contain english characters or numbers.<br>");
		}
	}

	if(strlen($password) > 30 || strlen($password) <5 )
	{
		array_push($error_array, "Your password must between 5 and 30 characters.<br>");
	}

	if(empty($error_array))
	{
		$password = md5($password) ; // Encrypt password before sending todatabase
		// generate username by concatenating first  name and last name
		$username = strtolower($vorname . "_" . $nachname );
		$check_username_query = mysqli_query( $con, "SELECT username FROM users WHERE username = '$username'" );

		$i = 0;
		// if username exists, add nummer to username
		while(mysqli_num_rows($check_username_query) != 0)
		{
			$i++;
			$username = $username . "_" . $i;
			$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'" );
		}

		//profile picture assignment
		$rand = rand(1,3); // random number between 1 and 2
		if($rand ==1)
			$profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
		if($rand ==2)
			$profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";
		if($rand ==3)
			$profile_pic = "assets/images/profile_pics/defaults/head_carrot.png";


		$query = mysqli_query($con, "INSERT INTO users VALUES ('', '$vorname', '$nachname', '$username', '$em', '$password', '$date', '$profile_pic','0','0','no',',' )");
		array_push($error_array, "<span style= 'color: #14C800;'>You are all set! Go ahead and login! </span><br>");

		// Clear session variables
		$_SESSION['reg_vname']  = "";
		$_SESSION['reg_lname']  = "";
		$_SESSION['reg_email']  = "";
		$_SESSION['reg_email2']  = "";
	}
}
?>