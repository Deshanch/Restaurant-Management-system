<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {//if one try to acces this page directly the direct to the index page
		header('Location: index.php');
	}

	$errors = array();//creating an empty array 
	$s_id = '';//this is to put entered values by the user 
	$supplier_name = '';

	if (isset($_POST['submit'])) {//is admin has submit the form,this global variable is post as our method is post
		//putting entered values to initialized variables to display again after wrong value is entered by the user
		$s_id = $_POST['s_id'];
		$supplier_name = $_POST['supplier_name'];

		// checking required fields
		$req_fields = array('s_id', 'supplier_name',);
		//what we get from the function is also an array so it has to merge to the existing array otherwise it will be a component inside the arra "errors" ---> array_merge(existing_array, new_array);
		$errors = array_merge($errors, check_req_fields($req_fields));//merging

		// checking if email address already exists
		$s_id = mysqli_real_escape_string($connection, $_POST['s_id']);//to prevent sql injection to avoid harming to database(sanitizing)
		$query = "SELECT * FROM supplier WHERE S_ID = '{$s_id}' LIMIT 1";//$email is the sanitized variable

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {//if query is succedful
			if (mysqli_num_rows($result_set) == 1) {//if there is any row mean there is same email as entred
				$errors[] = 'This supplier already exists';
			}
		}

		if (empty($errors)) {//if there is no error was found then we can send the data to the database 
			// no errors found... adding new record
			$s_id = mysqli_real_escape_string($connection, $_POST['s_id']);
			$supplier_name = mysqli_real_escape_string($connection, $_POST['supplier_name']);

			$query = "INSERT INTO supplier ( ";
			$query .= "S_ID  ,name";
			$query .= ") VALUES (";
			$query .= "'{$s_id}', '{$supplier_name}'";
			$query .= ")";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
				header('Location: suppliers.php?food_added=true');
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
	<title>Add New Supplier</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<header>
		<div class="appname">User Management System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?>! <a href="logout.php">Log Out</a></div>
	</header>

	<main>
		<h1>Add New Supplier<span> <a href="suppliers.php">< Back to Supplier List</a></span></h1><!-- back to user page -->

		<?php 

			if (!empty($errors)) {//checking that is there are any errors in the form submission
				display_errors($errors);//display any type of errors
			}

		 ?>

		<form action="add-supplier.php" method="post" class="userform"><!-- creating the form -->
			
			<p>
				<label for="">Supplier Id:</label>
				<input type="text" name="s_id" <?php echo 'value="' . $s_id . '"'; ?>>
			</p>

			<p>
				<label for="">Supplier Name:</label>
				<input type="text" name="supplier_name" <?php echo 'value="' . $supplier_name . '"'; ?>>
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