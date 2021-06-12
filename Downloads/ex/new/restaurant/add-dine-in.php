<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {//if one try to acces this page directly the direct to the index page
		header('Location: index.php');
	}

	$errors = array();//creating an empty array 
	$employee_id = '';//this is to put entered values by the user 
	$bill_no = 0;
	$payment = 0;

	if (isset($_POST['submit'])) {//is admin has submit the form,this global variable is post as our method is post
		//putting entered values to initialized variables to display again after wrong value is entered by the user
		$employee_id = $_POST['employee_id'];
		$bill_no = $_POST['bill_no'];

		// checking required fields
		$req_fields = array('employee_id', 'bill_no');
		//what we get from the function is also an array so it has to merge to the existing array otherwise it will be a component inside the arra "errors" ---> array_merge(existing_array, new_array);
		$errors = array_merge($errors, check_req_fields($req_fields));//merging

		// checking if email address already exists
		$bill_no = mysqli_real_escape_string($connection, $_POST['bill_no']);//to prevent sql injection to avoid harming to database(sanitizing)

		$query = "SELECT * FROM customer WHERE Bill_NO = {$bill_no} LIMIT 1";//$email is the sanitized variable

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {//if query is succedful
			if (mysqli_num_rows($result_set) == 1) {//if there is any row mean there is same email as entred
				$errors[] = 'This bill already exists';
			}
		}
		if ($employee_id[0] != 'W') {//if query is succedful
				$errors[] = 'Employee does not belong to here';
		}

		$query = "SELECT * FROM employee WHERE Employeeid = '{$employee_id}' LIMIT 1";//$email is the sanitized variable

		$result_set1 = mysqli_query($connection, $query);
		if ($result_set1) {//if query is succedful
			if (mysqli_num_rows($result_set) == 0) {//if there is any row mean there is same email as entred
				$errors[] = 'This waiter not found';
			}
		}

		if (empty($errors)) {//if there is no error was found then we can send the data to the database 
			// no errors found... adding new record
			$employee_id = mysqli_real_escape_string($connection, $_POST['employee_id']);
			$bill_no = mysqli_real_escape_string($connection, $_POST['bill_no']);

			$query = "INSERT INTO customer ( ";
			$query .= "Bill_NO, Date, Payment";
			$query .= ") VALUES (";
			$query .= "{$bill_no}, CURDATE(), {$payment}";
			$query .= ")";

			$query1 = "INSERT INTO dine_in ( ";
			$query1 .= "Bill_NO, EMP_ID";
			$query1 .= ") VALUES (";
			$query1 .= "{$bill_no}, '{$employee_id}'";
			$query1 .= ")";

			$result = mysqli_query($connection, $query);
			$result1 = mysqli_query($connection, $query1);

			if ($result && $result1) {
				// query successful... redirecting to users page
				header('Location: dine_in.php?employee_added=true');
			} else {
				$errors[] = 'Failed to add the new record.';
			}


		}



	}



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add New Member</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<header>
		<div class="appname">User Management System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?>! <a href="logout.php">Log Out</a></div>
	</header>

	<main>
		<h1>Add New Member<span> <a href="dine_in.php">< Back to List</a></span></h1><!-- back to user page -->

		<?php 

			if (!empty($errors)) {//checking that is there are any errors in the form submission
				display_errors($errors);//display any type of errors
			}

		 ?>

		<form action="add-dine-in.php" method="post" class="userform"><!-- creating the form -->
			

			<p>
				<label for="">Bill No:</label>
				<input type="number" name="bill_no" <?php echo 'value="' . $bill_no . '"'; ?>>
			</p>

			<p>
				<label for="">Employee Id:</label>
				<input type="text" name="employee_id" <?php echo 'value="' . $employee_id . '"'; ?>>
			</p>

			<p>
				<label for="">&nbsp;</label>
				<button type="submit" name="submit">Add</button>
			</p>

		</form>
	</main>
	<div class="footer">
  		<p class="foot">This website is optimized for managing the system. While using this site, you agree to have read and accepted our terms of use, cookie and privacy policy.Copyright 2005-2020.</p> 
  		<p class="foot">Powered by CD Team. Contact us.0123456789</p>
  		<p class="foot">All Rights Reserved.</p>
	</div>
</body>
</html>