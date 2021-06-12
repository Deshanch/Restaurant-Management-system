<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	if (isset($_GET['waiter_no'])) {
		// getting the user information
		$EMP_NO = mysqli_real_escape_string($connection, $_GET['waiter_no']);

			$query1 = "DELETE FROM Dine_In WHERE Dine_In.Emp_ID = '{$EMP_NO}' LIMIT 1";
			$query2 = "DELETE FROM waiter WHERE waiter.EmployeeId = '{$EMP_NO}' LIMIT 1";
			$query = "DELETE FROM employee WHERE employee.EmployeeId = '{$EMP_NO}' LIMIT 1";//
			
			$result1 = mysqli_query($connection, $query1);
			$result2 = mysqli_query($connection, $query2);
			$result = mysqli_query($connection, $query);

			if ($result1 && $result2 && $result) {//$result && 
			//if ($result2 && $result) {
				//user deleted
				header('Location: waiters.php?msg=deleted');
			}else{
				header('Location: waiters.php?err=delete_failed');
			}
		
	}else{
		header('Location: waiters.php');//if parameter is not passed then send to .php file again 
	}
?>
	