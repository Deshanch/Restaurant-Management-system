<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {//if user defined in the id is not logged in then redirect to the loggin page
		header('Location: index.php');
	}

	$errors = array();
	$emp_id = '';
	$fname = '';
	$lname = '';
	$dob ='';//
	$salary = 0;

	if (isset($_GET['cooking_staff_no'])) {//if the parameter passed to this page is set
		// getting the user information
		$emp_id = mysqli_real_escape_string($connection, $_GET['cooking_staff_no']);//sanitizing
		$query = "SELECT * FROM employee WHERE EmployeeId = '{$emp_id}' LIMIT 1";

		$result_set = mysqli_query($connection, $query);//getting information

		if ($result_set) {//if result_set is set
			if (mysqli_num_rows($result_set) == 1) {//if there is a matchig row
				// employee found
				$result = mysqli_fetch_assoc($result_set);
				$fname = $result['FName'];
				$lname = $result['LName'];
				$dob = $result['DOB'];
				$salary = $result['Salary'];
			} else {
				// user not found
				header('Location: cooking-staff.php?err=not_found');	
			}
		} else {
			// query unsuccessful
			header('Location: cooking-staff.php?err=query_failed');
		}
	}

	if (isset($_POST['submit'])) {
		//this post method is belong to this page
		$emp_id = $_POST['emp_id'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$dob = $_POST['dob'];
		$salary = $_POST['salary'];
		
		// checking required fields
		$req_fields = array('emp_id', 'fname', 'lname', 'dob', 'salary');
		$errors = array_merge($errors, check_req_fields($req_fields));

		if (empty($errors)) {
			// no errors found... adding new record
			$fname = mysqli_real_escape_string($connection, $_POST['fname']);
			$lname = mysqli_real_escape_string($connection, $_POST['lname']);
			$dob = mysqli_real_escape_string($connection, $_POST['dob']);
			$salary = mysqli_real_escape_string($connection, $_POST['salary']);
			$emp_id = mysqli_real_escape_string($connection, $_POST['emp_id']);
			// email address is already sanitized
			$query = "UPDATE employee SET ";
			$query .= "FName = '{$fname}', ";
			$query .= "LName = '{$lname}', ";
			$query .= "DOB = '{$dob}' ,";
			$query .= "Salary = {$salary} ";
			$query .= "WHERE EmployeeId = '{$emp_id}' LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
				header('Location:cooking-staff.php?employee_modified=true');
			} else {
				$errors[] = 'Failed to modify the record.';
			}


		}



	}



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>View / Modify Cooking Staff</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<header>
		<div class="appname">User Management System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?>! <a href="logout.php">Log Out</a></div>
	</header>

	<main>
		<h1>View / Modify Cooking Staff<span> <a href="cooking-staff.php">< Back to List</a></span></h1>

		<?php 

			if (!empty($errors)) {
				display_errors($errors);
			}

		 ?>

		<form action="modify-cooking_staff.php" method="post" class="userform">
			<input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
			<p>
				<label for="">First Name:</label>
				<input type="text" name="fname" <?php echo 'value="' . $fname . '"'; ?>>
			</p>

			<p>
				<label for="">Last Name:</label>
				<input type="text" name="lname" <?php echo 'value="' . $lname . '"'; ?>>
			</p>

			<p>
				<label for="">Date Of Birth:</label>
				<input type="text" name="dob" <?php echo 'value="' . $dob . '"'; ?>>
			</p>

			<p>
				<label for="">Salary:</label>
				<input type="number" name="salary" <?php echo 'value="' . $salary . '"'; ?>>
			</p>

			<p>
				<label for="">&nbsp;</label>
				<button type="submit" name="submit">Save</button>
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