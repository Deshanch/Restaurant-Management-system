<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {//if user defined in the id is not logged in then redirect to the loggin page
		header('Location: index.php');
	}

	$errors = array();
	$food_no = '';
	$food_name = '';
	$price = 0;

	if (isset($_GET['food_no'])) {//if the parameter passed to this page is set
		// getting the user information
		$food_no = mysqli_real_escape_string($connection, $_GET['food_no']);//sanitizing
		$query = "SELECT * FROM foodbeverages WHERE F_NO = '{$food_no}' LIMIT 1";

		$result_set = mysqli_query($connection, $query);//getting information

		if ($result_set) {//if result_set is set
			if (mysqli_num_rows($result_set) == 1) {//if there is a matchig row
				// user found
				$result = mysqli_fetch_assoc($result_set);
				$food_name = $result['Item'];
				$price = $result['Price'];
			} else {
				// user not found
				header('Location: foods.php?err=food_not_found');	
			}
		} else {
			// query unsuccessful
			header('Location: foods.php?err=query_failed');
		}
	}

	if (isset($_POST['submit'])) {
		//this post method is belong to this page
		$food_name = $_POST['food_name'];
		$price = $_POST['price'];
		$food_no = $_POST['food_no'];

		// checking required fields
		$req_fields = array('food_name', 'price');
		$errors = array_merge($errors, check_req_fields($req_fields));

		if (empty($errors)) {
			// no errors found... adding new record
			$food_name = mysqli_real_escape_string($connection, $_POST['food_name']);
			$price = mysqli_real_escape_string($connection, $_POST['price']);
			$food_no = mysqli_real_escape_string($connection, $_POST['food_no']);
			// email address is already sanitized

			$query = "UPDATE foodbeverages SET ";
			$query .= "Item = '{$food_name}', ";
			$query .= "Price = {$price} ";
			$query .= "WHERE F_NO = '{$food_no}' LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
				header('Location:foods.php?user_modified=true');
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
	<title>View / Modify Foods</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<header>
		<div class="appname">User Management System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?>! <a href="logout.php">Log Out</a></div>
	</header>

	<main>
		<h1>View / Modify Foods<span> <a href="foods.php">< Back to Show Room</a></span></h1>

		<?php 

			if (!empty($errors)) {
				display_errors($errors);
			}

		 ?>

		<form action="modify-foods.php" method="post" class="userform">
			<input type="hidden" name="food_no" value="<?php echo $food_no; ?>"><!-- hidden from users-->

			<p>
				<label for="">Food Name:</label>
				<input type="text" name="food_name" <?php echo 'value="' . $food_name . '"'; ?>>
			</p>

			<p>
				<label for="">Price:</label>
				<input type="number" name="price" <?php echo 'value="' . $price . '"'; ?>>
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