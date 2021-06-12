<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {//if user defined in the id is not logged in then redirect to the loggin page
		header('Location: index.php');
	}

	$errors = array();
	//$bill_no = 0;
	$food_no = '';//this is to put entered values by the user 
	$quantity = 0;
	//$priceTot = 0.00;
	//$price = 0.00;

	if (isset($_GET['bill_no'])) {//if the parameter passed to this page is set
		// getting the user information
		$bill_no = mysqli_real_escape_string($connection, $_GET['bill_no']);//sanitizing  {$bill_no}
		$query = "SELECT * FROM customer WHERE Bill_NO ={$bill_no} LIMIT 1";

		$result_set = mysqli_query($connection, $query);//getting information  

		if ($result_set) {//if result_set is set
			if (mysqli_num_rows($result_set) == 0) {//if there is any row mean there is same email as entred
					header('Location: final-bill.php?err=query_failed__');
			}
			else{
				
			}
		} else {
			// query unsuccessful
			header('Location: final-bill.php?err=query_failed');
		}

	}
	else{
		header('Location: final-bill.php');//if parameter is not passed then send to user.php file again 
	}

	if (isset($_POST['submit'])) {
		$food_no = $_POST['food_no'];
		$bill_no = $_POST['bill_no'];
		$quantity = $_POST['quantity'];
		// checking required fields
		$req_fields = array('food_no', 'quantity');
		//what we get from the function is also an array so it has to merge to the existing array otherwise it will be a component inside the arra "errors" ---> array_merge(existing_array, new_array);
		$errors = array_merge($errors, check_req_fields($req_fields));//merging

		// checking if email address already exists
		$food_no = mysqli_real_escape_string($connection, $_POST['food_no']);//to prevent sql injection to avoid harming to database(sanitizing)
		$bill_no = mysqli_real_escape_string($connection, $_POST['bill_no']);
		if (empty($errors)) {
			$query1 = "SELECT * FROM foodbeverages WHERE F_NO = '{$food_no}' LIMIT 1";//$email is the sanitized variable

			$result_set1 = mysqli_query($connection, $query1);

			if ($result_set1) {//if query is succedful
				if (mysqli_num_rows($result_set1) == 0) {//if there is any row mean there is same email as entred
					$errors[] = 'Food does not exist';
				}
			}
		}	

		if (empty($errors)) {
			// no errors found... adding new record
			$quantity = mysqli_real_escape_string($connection, $_POST['quantity']);

			$query2 = "SELECT Price FROM foodbeverages WHERE F_NO = '{$food_no}'";
			$result2 = mysqli_query($connection, $query2);
			$prices = mysqli_fetch_row($result2);
			$price = $prices[0];

			$query4 = "INSERT INTO customerbuys ( ";
			$query4 .= "Bill_NO,F_NO, Qunatity,Price,Time";
			$query4 .= ") VALUES (";
			$query4 .= "{$bill_no}, '{$food_no}', {$quantity},{$price}, CURDATE()";
			$query4 .= ")";

			$query5 = "UPDATE customer SET Payment=Payment+($price*$quantity) WHERE Bill_NO={$bill_no}";
			$query6 = "UPDATE foodbeverages SET Availability=Availability-($quantity) WHERE F_NO='{$food_no}'";

			$result4 = mysqli_query($connection, $query4);
			$result5 = mysqli_query($connection, $query5);
			$result6 = mysqli_query($connection, $query6);

			if ($result5 && $result6 && $result4) {//$result4 && 
				// query successful... redirecting to users page
				header('Location: add-bill.php?buy_added=true');
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
	<title>add buy</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<header>
		<div class="appname">User Management System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?>! <a href="logout.php">Log Out</a></div>
	</header>

	<main>
		<h1>Add Buy<span> <a href="final-bill.php">< Back to List</a></span></h1>

		<?php 
			if (!empty($errors)) {
				display_errors($errors);
			}
		 ?>

		<form action="add-bill.php" method="post" class="userform">
			<input type="hidden" name="bill_no" value="<?php echo $bill_no; ?>">
			<!--<p>
				<label for="">Bill No:</label>
				<input type="number" name="bill_no" <?php echo 'value="' . $bill_no . '"'; ?>>
			</p>-->
			<p>
				<label for="">Food No:</label>
				<input type="text" name="food_no" <?php echo 'value="' . $food_no . '"'; ?>>
			</p>

			<p>
				<label for="">Quantity:</label>
				<input type="number" name="quantity" <?php echo 'value="' . $quantity . '"'; ?>>
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