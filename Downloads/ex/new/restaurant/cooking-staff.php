<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {//if somebody is accessing to internal pages of the web page without logging redirect to the logging page
		header('Location: index.php');//redirect to logging page
	}

	$cooking_staff_list = '';

	// getting the list of users
	//$query = "SELECT * FROM prepare GROUP BY prepare.F_NO";//getting all the results
	$query = "SELECT cookingstaff.EmployeeId, employee.FName, employee.LName, employee.DOB, employee.Salary FROM cookingstaff, employee WHERE cookingstaff.EmployeeId = employee.EmployeeId GROUP BY cookingstaff.EmployeeId";
	$cooking_staff = mysqli_query($connection, $query);//pass the query

	verify_query($cooking_staff);

	while ($cook = mysqli_fetch_assoc($cooking_staff)) {//fetch data row by row to associative array
		$cooking_staff_list .= "<tr>";
		$cooking_staff_list .= "<td>{$cook['EmployeeId']}</td>";
		$cooking_staff_list .= "<td>{$cook['FName']}</td>";
		$cooking_staff_list .= "<td>{$cook['LName']}</td>";
		$cooking_staff_list .= "<td>{$cook['DOB']}</td>";
		$cooking_staff_list .= "<td>{$cook['Salary']}</td>";
		$cooking_staff_list .= "<td><a href=\"modify-cooking_staff.php?cooking_staff_no={$cook['EmployeeId']}\">Edit</a></td>";
		//user_id={$user['id']}--->this provides the related id for the page making global variable to access from any where using _GET
		$cooking_staff_list .= "<td><a href=\"delete-cooking_staff.php?cooking_staff_no={$cook['EmployeeId']}\"
						onclick=\"return confirm('Are you sure?');\">Delete</a></td>";  //displaying a confirm box
		$cooking_staff_list .= "</tr>";
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>cooking staff</title>
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
		<h1>Cooking Staff<span><a href="add-cooking-staff.php">+ Add New</a></span></h1>

		<table class="masterlist">
			<tr>
				<th>Employee Id</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Date Of Birth</th>
				<th>Salary</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>

			<?php echo $cooking_staff_list; ?>

		</table>
	</main>
	</div>
	<div class="footer">
  		<p class="foot">This website is optimized for managing the system. While using this site, you agree to have read and accepted our terms of use, cookie and privacy policy.Copyright 2005-2020.</p> 
  		<p class="foot">Powered by Chamli Deshan. Contact us.0123456789</p>
  		<p class="foot">All Rights Reserved.</p>
	</div>
</body>
</html>