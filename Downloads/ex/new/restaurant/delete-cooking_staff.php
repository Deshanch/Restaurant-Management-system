<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	if (isset($_GET['cooking_staff_no'])) {
		// getting the user information
		$EMP_NO = mysqli_real_escape_string($connection, $_GET['cooking_staff_no']);

			$query1 = "DELETE FROM cookingstaff WHERE cookingstaff.EmployeeId = '{$EMP_NO}' LIMIT 1";
			$query = "DELETE FROM employee WHERE employee.EmployeeId = '{$EMP_NO}' LIMIT 1";//
			
			$result1 = mysqli_query($connection, $query1);
			$result = mysqli_query($connection, $query);

			if ($result1 && $result) {//$result && 
				//user deleted
				header('Location: cooking-staff.php?msg=deleted');
			}else{
				header('Location: cooking-staff.php?err=delete_failed');
			}
		
	}else{
		header('Location: cooking-staff.php');//if parameter is not passed then send to .php file again 
	}
?>
	