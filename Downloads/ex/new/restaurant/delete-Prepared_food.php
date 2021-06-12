<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	if (isset($_GET['Prepared_food_no']) && isset($_GET['item_no'])) {
		// getting the user information
		$Prepared_food_No = mysqli_real_escape_string($connection, $_GET['Prepared_food_no']);
		$item_No = mysqli_real_escape_string($connection, $_GET['item_no']);

			$query = "DELETE FROM prepare WHERE prepare.F_NO = '{$Prepared_food_No}' AND prepare.I_NO = '{$item_No}' LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {//$result && 
				//user deleted
				header('Location: prepare.php?msg=deleted');
			}else{
				header('Location: prepare.php?err=delete_failed');
			}
		
	}else{
		header('Location: prepare.php');//if parameter is not passed then send to .php file again 
	}
?>
	