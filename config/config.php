<?php
ob_start(); // truns on output buffering
session_start(); // save the wrong message to edit

$timezone = date_default_timezone_set("Europe/Berlin"); //https://www.php.net/manual/en/timezones.europe.php

// connect to database
$con = mysqli_connect("localhost", "root","", "social");
if(mysqli_connect_errno()) 
{
    echo "Fail to connect: " . mysqli_connect_errno();
}

?>