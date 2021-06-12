<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	if (isset($_GET['supply_no'])) {
		// getting the user information
		$supply_No = mysqli_real_escape_string($connection, $_GET['supply_no']);

		$query = "DELETE FROM supply WHERE supply.supply_NO = {$supply_No} LIMIT 1";
		$result = mysqli_query($connection, $query);

		if ($result) {//$result && 
			//user deleted
			header('Location: supply.php?msg=deleted');
		}else{
			header('Location: supply.php?err=delete_failed');
		}
		
	}else{
		header('Location: supply.php');//if parameter is not passed then send to .php file again 
	}
?>
	