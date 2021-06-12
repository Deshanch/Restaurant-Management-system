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
		$bill_no = mysqli_real_escape_string($connection, $_GET['bill_no']);

			$query1 = "DELETE FROM dine_in WHERE dine_in.Bill_NO = {$bill_no}";
			$query2 = "DELETE FROM delivering WHERE delivering.Bill_NO = {$bill_no}";
			$query3 = "DELETE FROM TAKE_AWAY WHERE TAKE_AWAY.Bill_NO = {$bill_no}";
			$query4 = "DELETE FROM CustomerBuys WHERE CustomerBuys.Bill_NO = {$bill_no}";
			$query = "DELETE FROM customer WHERE customer.Bill_NO = {$bill_no}";//

			$result1 = mysqli_query($connection, $query1);
			$result2 = mysqli_query($connection, $query2);
			$result3 = mysqli_query($connection, $query3);
			$result4 = mysqli_query($connection, $query4);
			$result = mysqli_query($connection, $query);

			if ($result1 && $result2 && $result3 && $result4 && $result) {//$result && 
				//user deleted
				header('Location: final-bill.php?msg=deleted');
			}else{
				header('Location: final-bill.php?err=delete_failed');
			}
		
	}else{
		header('Location: final-bill.php');//if parameter is not passed then send to .php file again 
	}
?>
	