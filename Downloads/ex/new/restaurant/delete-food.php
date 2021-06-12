<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	if (isset($_GET['food_no'])) {
		// getting the user information
		$F_NO = mysqli_real_escape_string($connection, $_GET['food_no']);

			$query1 = "DELETE FROM customerbuys WHERE customerbuys.F_NO = '{$F_NO}'";
			$query2 = "DELETE FROM prepare WHERE prepare.F_NO = '{$F_NO}'";
			$query = "DELETE FROM foodbeverages WHERE foodbeverages.F_NO = '{$F_NO}' LIMIT 1";//
			
			$result1 = mysqli_query($connection, $query1);
			$result2 = mysqli_query($connection, $query2);
			$result = mysqli_query($connection, $query);

			if ($result1 && $result2) {//$result && 
				//user deleted
				header('Location: foods.php?msg=food_deleted');
			}else{
				header('Location: foods.php?err=delete_failed');
			}
		
	}else{
		header('Location: foods.php');//if parameter is not passed then send to .php file again 
	}
?>
	