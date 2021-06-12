<?php 
  //********* THIS CAN BE USED TO ANY LOGOUT PAGE IN ANY WEBSITE****************

	session_start();//to handle the session variable have to start the session

	$_SESSION = array();//have to empty the the global session array when logout
	//when a session is start a cookie is stored in the browser, if a cookie is set have to expire the cookie artificially
	if (isset($_COOKIE[session_name()])) {//if the cookie is set
		setcookie(session_name(), '', time()-86400, '/');//here we gave the expiration time so it expires automatically
		//setcookie(cookieName, value, expirationTime, toWhichItShouldBeEffected);
		//cookieName-->session name
		//value-->give a blank
		//expirationTime-->current time-(24 x 60 x 60) means it get expired after one day
		//toWhichItShouldBeEffected-->'/' means root folder mean affect to full website
	}

	session_destroy();//when logging out full session is destroyed

	// redirecting the user to the login page
	header('Location: index.php?logout=yes');//give a parameter to check whether that user is logged out

 ?>