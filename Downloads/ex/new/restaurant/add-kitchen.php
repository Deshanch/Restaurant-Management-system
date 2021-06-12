<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {//if one try to acces this page directly the direct to the index page
		header('Location: index.php');
	}

	$errors = array();//creating an empty array 
	$food_no = '';//this is to put entered values by the user 
	$item_no = '';
	$item_amount = 0;
	$made_amount = 0;

	if (isset($_POST['submit'])) {//is admin has submit the form,this global variable is post as our method is post
		//putting entered values to initialized variables to display again after wrong value is entered by the user
		$food_no = $_POST['food_no'];
		$item_no = $_POST['item_no'];
		$item_amount = $_POST['item_amount'];
		$made_amount = $_POST['made_amount'];

		// checking required fields
		$req_fields = array('food_no', 'item_no', 'item_amount', 'made_amount');
		//what we get from the function is also an array so it has to merge to the existing array otherwise it will be a component inside the arra "errors" ---> array_merge(existing_array, new_array);
		$errors = array_merge($errors, check_req_fields($req_fields));//merging

		// checking if email address already exists
		$food_no = mysqli_real_escape_string($connection, $_POST['food_no']);//to prevent sql injection to avoid harming to database(sanitizing)
		$item_no = mysqli_real_escape_string($connection, $_POST['item_no']);

		$query = "SELECT * FROM prepare WHERE F_NO = '{$food_no}' AND I_NO = '{$item_no}'LIMIT 1";//$email is the sanitized variable

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {//if query is succedful
			if (mysqli_num_rows($result_set) == 1) {//if there is any row mean there is same email as entred
				$errors[] = 'Food and added item already exist';
			}
		}
		$query = "SELECT * FROM foodbeverages WHERE F_NO = '{$food_no}'";//$email is the sanitized variable

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {//if query is succedful
			if (mysqli_num_rows($result_set) == 0) {//if there is any row mean there is same email as entred
				$errors[] = 'The Food you are adding does not exist in showroom :) Please check';
			}
		}
		$query = "SELECT * FROM rawmaterial WHERE I_NO = '{$item_no}'";//$email is the sanitized variable

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {//if query is succedful
			if (mysqli_num_rows($result_set) == 0) {//if there is any row mean there is same email as entred
				$errors[] = 'The Ingredient you are adding does not exist in stocks :) Please check';
			}
		}

		if (empty($errors)) {//if there is no error was found then we can send the data to the database 
			// no errors found... adding new record
			$food_no = mysqli_real_escape_string($connection, $_POST['food_no']);
			$item_no = mysqli_real_escape_string($connection, $_POST['item_no']);
			$item_amount = mysqli_real_escape_string($connection, $_POST['item_amount']);
			$made_amount = mysqli_real_escape_string($connection, $_POST['made_amount']);
			// email address is already sanitized
			//$hashed_password = sha1($availability);

			$query = "INSERT INTO prepare ( ";
			$query .= "I_NO,F_NO,Amount,food_amount";
			$query .= ") VALUES (";
			$query .= "'{$item_no}','{$food_no}', {$item_amount}, {$made_amount}";
			$query .= ")";

			$query1 = "UPDATE rawmaterial SET avalibility=avalibility-($item_amount) WHERE I_NO='{$item_no}'";

			$result = mysqli_query($connection, $query);
			$result1 = mysqli_query($connection, $query1);


			if ($result && $result1) {
				// query successful... redirecting to users page
				header('Location: prepare.php?food_added=true');
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
	<title>Add New One</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<header>
		<div class="appname">User Management System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?>! <a href="logout.php">Log Out</a></div>
	</header>

	<main>
		<h1>Add New One<span> <a href="prepare.php">< Back to List</a></span></h1><!-- back to user page -->

		<?php 

			if (!empty($errors)) {//checking that is there are any errors in the form submission
				display_errors($errors);//display any type of errors
			}

		 ?>

		<form action="add-kitchen.php" method="post" class="userform"><!-- creating the form -->
			
			<p>
				<label for="">Food Number:</label>
				<input type="text" name="food_no" <?php echo 'value="' . $food_no . '"'; ?>>
			</p>

			<p>
				<label for="">Item Number:</label>
				<input type="text" name="item_no" <?php echo 'value="' . $item_no . '"'; ?>>
			</p>

			<p>
				<label for="">Item Amount Used:</label>
				<input type="number" name="item_amount" <?php echo 'value="' . $item_amount . '"'; ?>>
			</p>

			<p>
				<label for="">Made Amount:</label>
				<input type="number" name="made_amount" <?php echo 'value="' . $made_amount . '"'; ?>>
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