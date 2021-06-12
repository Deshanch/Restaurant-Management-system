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
	$Fname = '';
	$Lname = '';
	$dob ='';//
	$salary = 0;

	if (isset($_POST['submit'])) {//is admin has submit the form,this global variable is post as our method is post
		//putting entered values to initialized variables to display again after wrong value is entered by the user
		$employee_id = $_POST['employee_id'];
		$Fname = $_POST['Fname'];
		$Lname = $_POST['Lname'];
		$dob = $_POST['dob'];
		//$dob = explode("-",$dob);
		//$dob = "$dob[2]-$dob[1]-$dob[0]";
		$salary = $_POST['salary'];

		// checking required fields
		$req_fields = array('employee_id', 'Fname', 'Lname', 'dob', 'salary');
		//what we get from the function is also an array so it has to merge to the existing array otherwise it will be a component inside the arra "errors" ---> array_merge(existing_array, new_array);
		$errors = array_merge($errors, check_req_fields($req_fields));//merging

		// checking if email address already exists
		$employee_id = mysqli_real_escape_string($connection, $_POST['employee_id']);//to prevent sql injection to avoid harming to database(sanitizing)

		$query = "SELECT * FROM waiter WHERE EmployeeId = '{$employee_id}' LIMIT 1";//$email is the sanitized variable

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {//if query is succedful
			if (mysqli_num_rows($result_set) == 1) {//if there is any row mean there is same email as entred
				$errors[] = 'Employee already exist';
			}
		}
		if ($employee_id[0] != 'W') {//if query is succedful
				$errors[] = 'Employee does not belong to here';
		}


		if (empty($errors)) {//if there is no error was found then we can send the data to the database 
			// no errors found... adding new record
			$employee_id = mysqli_real_escape_string($connection, $_POST['employee_id']);
			$Fname = mysqli_real_escape_string($connection, $_POST['Fname']);
			$Lname = mysqli_real_escape_string($connection, $_POST['Lname']);
			$dob = mysqli_real_escape_string($connection, $_POST['dob']);
			$salary = mysqli_real_escape_string($connection, $_POST['salary']);
			// email address is already sanitized
			//$hashed_password = sha1($availability);

			$query = "INSERT INTO employee ( ";
			$query .= "EmployeeId, FName, LName, DOB, Salary";
			$query .= ") VALUES (";
			$query .= "'{$employee_id}', '{$Fname}', '{$Lname}','{$dob}', {$salary}";
			$query .= ")";

			$query1 = "INSERT INTO waiter ( ";
			$query1 .= "EmployeeId";
			$query1 .= ") VALUES (";
			$query1 .= "'{$employee_id}'";
			$query1 .= ")";

			$result = mysqli_query($connection, $query);
			$result1 = mysqli_query($connection, $query1);

			if ($result && $result1) {
				// query successful... redirecting to users page
				header('Location: waiters.php?employee_added=true');
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
		<h1>Add New Member<span> <a href="waiters.php">< Back to List</a></span></h1><!-- back to user page -->

		<?php 

			if (!empty($errors)) {//checking that is there are any errors in the form submission
				display_errors($errors);//display any type of errors
			}

		 ?>

		<form action="add-waiters.php" method="post" class="userform"><!-- creating the form -->
			
			<p>
				<label for="">Employee Id:</label>
				<input type="text" name="employee_id" <?php echo 'value="' . $employee_id . '"'; ?>>
			</p>

			<p>
				<label for="">First Name:</label>
				<input type="text" name="Fname" <?php echo 'value="' . $Fname . '"'; ?>>
			</p>

			<p>
				<label for="">Last Name:</label>
				<input type="text" name="Lname" <?php echo 'value="' . $Lname . '"'; ?>>
			</p>

			<p>
				<label for="">Date Of Birth:</label>
				<input type="text" name="dob" placeholder="YYYY-MM-DD"<?php echo 'value="' . $dob . '"'; ?>>
			</p>

			<p>
				<label for="">Salary:</label>
				<input type="number" name="salary" <?php echo 'value="' . $salary . '"'; ?>>
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