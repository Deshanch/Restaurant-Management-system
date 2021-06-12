<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	if (isset($_GET['supplier_no'])) {
		// getting the user information
		$supplier_No = mysqli_real_escape_string($connection, $_GET['supplier_no']);

		$query1 = "DELETE FROM supply WHERE supply.SS_ID = '{$supplier_No}'";
		$query = "DELETE FROM  supplier WHERE  supplier.S_ID = '{$supplier_No}' LIMIT 1";

		$result1 = mysqli_query($connection, $query1);
		$result = mysqli_query($connection, $query);

		if ($result1 && $result) {//$result && 
			//user deleted
			header('Location: suppliers.php?msg=deleted');
		}else{
			header('Location: suppliers.php?err=delete_failed');
		}
		
	}else{
		header('Location: suppliers.php');//if parameter is not passed then send to .php file again 
	}
?>
	