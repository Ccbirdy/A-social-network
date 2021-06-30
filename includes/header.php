<?php 
require 'config/config.php';

if (isset($_SESSION['username'])) {         /* if you not logged in , you cant see index.php  */
	$userLoggedIn = $_SESSION['username'];
}
else {
	header("Location: register.php");
}

?>


<html>
<head>
	<title>welcome to ccfeed</title>
</head>
<body>