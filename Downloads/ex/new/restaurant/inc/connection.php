<?php 
    //this file is needed for every project usually
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'restaurant'; //database what we created

	$connection = mysqli_connect('localhost', 'root', '', 'restaurant');//this to connect to database

	// Checking the connection
	if (mysqli_connect_errno()) {
		die('Database connection failed ' . mysqli_connect_error());
	}

?>