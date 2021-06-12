<?php session_start(); ?><!-- to use session variable have to start the session always -->
<?php require_once('inc/connection.php'); ?><!-- include the file of connection  to the this page and this has to be added to every page in this project-->
<?php require_once('inc/functions.php'); ?><!-- this file also have to import to this -->
<?php 
	//in the post method check the related buttons and inputs are operated correctly $_POST global variable is used for this. 
	// check for form submission
	if (isset($_POST['submit'])) {

		$errors = array();//initialized an array to get errors

		// check if the username and password has been entered
		if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1 ) {
			$errors[] = 'Username is Missing / Invalid';
		}
		//this "trim removes all the spaces in the entered one"
		if (!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1 ) {
			$errors[] = 'Password is Missing / Invalid';
		}

		// check if there are any errors in the form
		if (empty($errors)) {//if there is no error 
			// save username and password into variables
			$email 		= mysqli_real_escape_string($connection, $_POST['email']);
			//this "mysqli_real_escape_string($connection, $FORM ELEMENT)" prevents the damage to the internal system if the user is 
			//entered an sql query to the inputs
			$password 	= mysqli_real_escape_string($connection, $_POST['password']);
			$hashed_password = sha1($password);//converting to the protected type of the password

			// prepare database query
			$query = "SELECT * FROM user 
						WHERE email = '{$email}' 
						AND password = '{$hashed_password}' 
						LIMIT 1";

			$result_set = mysqli_query($connection, $query);//this how a query is given to the database to get the results 

			verify_query($result_set);

			if (mysqli_num_rows($result_set) == 1) {//even if the query is succesful, there can be no record, this is to check that 
				// valid user found
				$user = mysqli_fetch_assoc($result_set);//fetch data from the selected row as an associative array
				$_SESSION['user_id'] = $user['id'];//getting data to variable from the associative array to a session varaible(global and can access from any where)
				$_SESSION['first_name'] = $user['first_name'];
				// updating last login
				$query = "UPDATE user SET last_login = NOW() ";//this now() function update both date and time if date then date if time then time if both then both
				$query .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";

				$result_set = mysqli_query($connection, $query);

				verify_query($result_set);

				// redirect to users.php
				header('Location: users.php');//redirecting to another php file
			} else {
				// user name and password invalid
				$errors[] = 'Invalid Username / Password';
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Log In - Restaurant Management System</title>
	<link rel="stylesheet" href="css/main.css"><!-- link the css file inside the html this is normal as liking -->
</head>
<body class="main_page">
	<header>
		<div class="appname_main">Restaurant Management System</div>
	</header>
	<div class="index-page-bg"></div>
	<div class="login"><!-- this is just a division -->

		<form action="index.php" method="post"><!-- creating the form and action also same as this as we processing is also done inside this file  and method is post  -->
			
			<fieldset class="login"><!-- tag is used to group related elements in a form and draws a box around the related elements -->
				<legend><h1>Log In</h1></legend>

				<?php 
					if (isset($errors) && !empty($errors)) {//if the array is set and if the array is not empty means there is any error
						echo '<p class="error">Invalid Username / Password</p>';//here this class is to name the paragraph and the 
						                                                         //name of the class can be used to access the class 
						                                                          //from any where(in css file) 
					}
				?>

				<?php 
				//'logout' is the parameter set in the logging
					if (isset($_GET['logout'])) {//if the user is logged out
						echo '<p class="info">You have successfully logged out from the system</p>';
					}
				?>

				<p>
					<label for="">Username:</label>
					<input type="text" name="email" id="" placeholder="Email Address">
				</p>

				<p>
					<label for="">Password:</label>
					<input type="password" name="password" id="" placeholder="Password">
				</p>

				<p>
					<button type="submit" name="submit">Log In</button>
				</p>

			</fieldset>

		</form>		

	</div> <!-- .login -->
	<div class="footer">
  		<p class="foot">This website is optimized for managing the system. While using this site, you agree to have read and accepted our terms of use, cookie and privacy policy.Copyright 2005-2020.</p> 
  		<p class="foot">Powered by CD Team. Contact us.0123456789</p>
  		<p class="foot">All Rights Reserved.</p>
	</div>
</body>
</html>
<?php mysqli_close($connection); ?><!-- close the connection -->