<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {//if somebody is accessing to internal pages of the web page without logging redirect to the logging page
		header('Location: index.php');//redirect to logging page
	}

	if (isset($_GET['bill_no'])) {
		// getting the user information
		$Bill_NO = mysqli_real_escape_string($connection, $_GET['bill_no']);

			$query = "SELECT * FROM customerbuys WHERE customerbuys.Bill_NO = {$Bill_NO}";
			$full_bills = mysqli_query($connection, $query);

			if ($full_bills) {//$result && 
				//query succesful
			}else{
				header('Location: final-bill.php?err=full_view_failed');
			}
		
	}else{
		header('Location: final-bill.php');//if parameter is not passed then send to user.php file again 
	}

	$full_bill_list = '';
	while ($full_bill = mysqli_fetch_assoc($full_bills)) {//fetch data row by row to associative array
		$full_bill_list .= "<tr>";
		$full_bill_list .= "<td>{$full_bill['Bill_NO']}</td>";
		$full_bill_list .= "<td>{$full_bill['F_NO']}</td>";
		$full_bill_list .= "<td>{$full_bill['Qunatity']}</td>";
		$full_bill_list .= "<td>{$full_bill['Price']}</td>";
		$full_bill_list .= "<td>{$full_bill['Time']}</td>";
		//$full_bill_list .= "<td><a href=\"edit-full-bill.php?bill_no={$full_bill['Bill_NO']}&food_no={$full_bill['F_NO']}\">Edit</a></td>";
		//user_id={$user['id']}--->this provides the related id for the page making global variable to access from any where using 
		$full_bill_list .= "<td><a href=\"delete-full-bill.php?bill_no={$full_bill['Bill_NO']}&food_no={$full_bill['F_NO']}\"
						onclick=\"return confirm('Are you sure?');\">Delete</a></td>";  //displaying a confirm box
		$full_bill_list .= "</tr>";
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>final bill</title>
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
		<h1>Bill &nbsp;&nbsp;<span><a href="final-bill.php"> << Back to Bill</a></span></h1>
		<table class="masterlist">
			<tr>
				<th>Bill No</th>
				<th>Food No</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Date</th>
				<!--<th>Edit</th>-->
				<th>Delete</th>
			</tr>

			<?php echo $full_bill_list; ?>

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