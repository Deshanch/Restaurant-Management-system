<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	if (isset($_GET['bill_no'])) {
		// getting the user information
		$Bill_No = mysqli_real_escape_string($connection, $_GET['bill_no']);

			$query = "DELETE FROM take_away WHERE take_away.Bill_NO = {$Bill_No} LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {//$result && 
				//user deleted
				header('Location: take_away.php?msg=deleted');
			}else{
				header('Location: take_away.php?err=delete_failed');
			}
		
	}else{
		header('Location: take_away.php');//if parameter is not passed then send to .php file again 
	}
?>
	