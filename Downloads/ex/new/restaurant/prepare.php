<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {//if somebody is accessing to internal pages of the web page without logging redirect to the logging page
		header('Location: index.php');//redirect to logging page
	}

	$Prepared_food_list = '';

	// getting the list of users
	//$query = "SELECT * FROM prepare GROUP BY prepare.F_NO";//getting all the results
	$query = "SELECT prepare.F_NO, prepare.I_NO, prepare.Amount, prepare.food_amount FROM prepare ORDER BY prepare.F_NO";
	$Prepared_foods = mysqli_query($connection, $query);//pass the query

	verify_query($Prepared_foods);

	while ($Prepared_food = mysqli_fetch_assoc($Prepared_foods)) {//fetch data row by row to associative array
		$Prepared_food_list .= "<tr>";
		$Prepared_food_list .= "<td>{$Prepared_food['F_NO']}</td>";
		$Prepared_food_list .= "<td>{$Prepared_food['I_NO']}</td>";
		$Prepared_food_list .= "<td>{$Prepared_food['Amount']}</td>";
		$Prepared_food_list .= "<td>{$Prepared_food['food_amount']}</td>";
		//$Prepared_food_list .= "<td><a href=\"modify-Prepared_foods.php?Prepared_food_no={$Prepared_food['F_NO']}\">Edit</a></td>";
		//user_id={$user['id']}--->this provides the related id for the page making global variable to access from any where using _GET
		$Prepared_food_list .= "<td><a href=\"delete-Prepared_food.php?Prepared_food_no={$Prepared_food['F_NO']}&item_no={$Prepared_food['I_NO']}\"
						onclick=\"return confirm('Are you sure?');\">Delete</a></td>";  //displaying a confirm box
		$Prepared_food_list .= "</tr>";
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Food & Beverages</title>
	<link rel="stylesheet" href="css/main.css"><!-- import the css file -->
</head>
<body>
	<div class="wrapper">
  		<header>
		<div class="appname">Restaurant Management System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?>! <a href="logout.php">Log Out</a></div>
	</header>
	<div class="navbar">
		  <a href="users.php">Management</a>	
		  <div class="dropdown">
		    <button class="dropbtn">Food & Beverages</button>
		    <div class="dropdown-content">
		      <a href="foods.php">Show Room</a>
		      <a href="prepare.php">Kitchen</a>
		    </div>
		  </div> 
		  <div class="dropdown">
		    <button class="dropbtn">Employees</button>
		    <div class="dropdown-content">
		      <a href="cooking-staff.php">Cooking Staff</a>
		      <a href="waiters.php">Waiters</a>
		      <a href="delivery-boys.php">Delivering Staff</a>
		    </div>
		  </div> 
		  <a href="final-bill.php">Customers Bill</a>
		  <div class="dropdown">
		    <button class="dropbtn">Customers Services</button>
		    <div class="dropdown-content">
		      <a href="delivery.php">Deliver</a>
		      <a href="dine_in.php">Dine In</a>
		      <a href="take_away.php">Take Away</a>
		    </div>
		  </div>
		  <a href="stock.php">Stock</a>
		  <div class="dropdown">
		    <button class="dropbtn">Suppliers</button>
		    <div class="dropdown-content">
		      <a href="suppliers.php">Personal Details</a>
		      <a href="supply.php">Exchanges</a>
		    </div>
		  </div>
		</div>
	<main>
		<h1>Kitchen<span><a href="add-kitchen.php">+ Add New</a></span></h1>

		<table class="masterlist">
			<tr>
				<th>Food Number</th>
				<th>Item Number</th>
				<th>Item Amount Used</th>
				<th>Made Amount</th>
				<!--<th>Edit</th>-->
				<th>Delete</th>
			</tr>

			<?php echo $Prepared_food_list; ?>

		</table>
	</main>
	</div>
	<div class="footer">
  		<p class="foot">This website is optimized for managing the system. While using this site, you agree to have read and accepted our terms of use, cookie and privacy policy.Copyright 2005-2020.</p> 
  		<p class="foot">Powered by CD Team. Contact us.0123456789</p>
  		<p class="foot">All Rights Reserved.</p>
	</div>
</body>
</html>