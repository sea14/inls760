<?php
	session_start();
	$old_user = $_SESSION['valid_user'];
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) { //both the dark and the light get cookies
	
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
?>
<h1>Logout</h1>

<?php
	if(!empty($old_user)){
		echo "You are now logged out.<br>";
	}else{
		echo "You were not logged in, so of course you couldn't log out!";
	}
?>
<p></p>
	<a href="seaustin-p3-login.php">Login</a>
	<a href="seaustin-p3-page1.php">Page 1</a>
	<a href="seaustin-p3-page2.php">Page 2</a>
	<a href="seaustin-p3-page3.php">Page 3</a>
	<a href="seaustin-p3-page4.php">Page 4</a>
	<a href="seaustin-p3-logout.php">Log Out</a>


</body>


</html>
