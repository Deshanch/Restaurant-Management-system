<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	if (isset($_GET['item_no'])) {
		// getting the user information
		$item_No = mysqli_real_escape_string($connection, $_GET['item_no']);

		$query1 = "DELETE FROM supply WHERE supply.II_NO = '{$item_No}'";
		$query2 = "DELETE FROM prepare WHERE prepare.I_NO = '{$item_No}'";
		$query = "DELETE FROM rawmaterial WHERE rawmaterial.I_NO = '{$item_No}' LIMIT 1";

		$result1 = mysqli_query($connection, $query1);
		$result2 = mysqli_query($connection, $query2);
		$result = mysqli_query($connection, $query);

		if ($result1 && $result2stock && $result) {//$result && 
			//user deleted
			header('Location: stock.php?msg=deleted');
		}else{
			header('Location: stock.php?err=delete_failed');
		}
		
	}else{
		header('Location: stock.php');//if parameter is not passed then send to .php file again 
	}
?>
	