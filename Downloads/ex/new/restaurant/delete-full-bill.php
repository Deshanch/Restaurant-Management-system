<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	if (isset($_GET['bill_no']) && isset($_GET['food_no'])) {
		// getting the user information
		$bill_no = mysqli_real_escape_string($connection, $_GET['bill_no']);
		$food_no = mysqli_real_escape_string($connection, $_GET['food_no']);

			$query1 = "SELECT Qunatity FROM customerbuys WHERE Bill_NO = {$bill_no} AND F_NO = '{$food_no}'";
			$result1 = mysqli_query($connection, $query1);
			$quantitys = mysqli_fetch_row($result1);
			$quantity = $quantitys[0];
			$query2 = "UPDATE foodbeverages SET Availability=Availability+{$quantity} WHERE F_NO = '{$food_no}'";
			$result2 = mysqli_query($connection, $query2);
			$query3 = "SELECT Price FROM customerbuys WHERE Bill_NO = {$bill_no} AND F_NO = '{$food_no}'";
			$result3 = mysqli_query($connection, $query3);
			$prices = mysqli_fetch_row($result3);
			$price = $prices[0];
			$query4 = "UPDATE customer SET Payment=Payment-{$price} WHERE Bill_NO = {$bill_no}";
			$result4 = mysqli_query($connection, $query4);
			$query = "DELETE FROM customerbuys WHERE customerbuys.Bill_NO = {$bill_no} AND customerbuys.F_NO = '{$food_no}'";//
			$result = mysqli_query($connection, $query);

			if ($result && $result1 && $result2 && $result3 && $result4) {//$result && 
				//user deleted
				header('Location: final-bill.php?msg=deleted');
			}else{
				header('Location: final-bill.php?err=delete_failed');
			}
		
	}else{
		header('Location: final-bill.php');//if parameter is not passed then send to .php file again 
	}
?>
	