<?php
$con = mysqli_connect("localhost", "root","", "social");
if(mysqli_connect_errno()) // error number
{
    echo "Fail to connect: " . mysqli_connect_errno();
}

$query = mysqli_query($con,"INSERT INTO test VALUES(NULL,'OPTIMUS pRIME')");

?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Swirlfeed</title>
	</head>
	<body>
	Hallo Chengcheng !!!
	this is version 2
	try to connect sql，
	deliberate change no exist sql
	</body>
	</html>	