<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {//if user defined in the id is not logged in then redirect to the loggin page
		header('Location: index.php');
	}

	$errors = array();
	$supplier_no = '';
	$sname = '';

	if (isset($_GET['supplier_no'])) {//if the parameter passed to this page is set
		// getting the user information
		$supplier_no = mysqli_real_escape_string($connection, $_GET['supplier_no']);//sanitizing
		$query = "SELECT * FROM supplier WHERE S_Id = '{$supplier_no}' LIMIT 1";

		$result_set = mysqli_query($connection, $query);//getting information

		if ($result_set) {//if result_set is set
			if (mysqli_num_rows($result_set) == 1) {//if there is a matchig row
				// employee found
				$result = mysqli_fetch_assoc($result_set);
				$sname = $result['Name'];
			} else {
				// user not found
				header('Location:suppliers.php?err=not_found');	
			}
		} else {
			// query unsuccessful
			header('Location:suppliers.php?err=query_failed');
		}
	}

	if (isset($_POST['submit'])) {
		//this post method is belong to this page
		$supplier_no = $_POST['supplier_no'];
		$sname = $_POST['sname'];
		
		// checking required fields
		$req_fields = array('supplier_no', 'sname');
		$errors = array_merge($errors, check_req_fields($req_fields));

		if (empty($errors)) {
			// no errors found... adding new record
			$sname = mysqli_real_escape_string($connection, $_POST['sname']);
			$supplier_no = mysqli_real_escape_string($connection, $_POST['supplier_no']);
			// email address is already sanitized
			$query = "UPDATE supplier SET ";
			$query .= "Name = '{$sname}' ";
			$query .= "WHERE S_Id = '{$supplier_no}' LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
				header('Location:suppliers.php?employee_modified=true');
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
	<title>View / Modify Suppliers</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<header>
		<div class="appname">User Management System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?>! <a href="logout.php">Log Out</a></div>
	</header>

	<main>
		<h1>View / Modify Suppliers<span> <a href="suppliers.php">< Back to List</a></span></h1>

		<?php 

			if (!empty($errors)) {
				display_errors($errors);
			}

		 ?>

		<form action="modify-suppliers.php" method="post" class="userform">
			<input type="hidden" name="supplier_no" value="<?php echo $supplier_no; ?>">
			<p>
				<label for="">Supplier Name:</label>
				<input type="text" name="sname" <?php echo 'value="' . $sname . '"'; ?>>
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