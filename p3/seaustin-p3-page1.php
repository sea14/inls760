<html>
<head>
<title>Page 1</title>
</head>
<body>
<h1>Page 1</h1>
<p></p>
<?php
	session_start();
	if(isset($_SESSION['valid_user'])){
	//user is logged in
	echo 'Welcome, '. $_SESSION['valid_user'] .'<br>You are logged in as a';

	if($_SESSION['usertype'] == 'jediknight'){
		
		echo ' Jedi Knight. Use the force.';
	
	}
	if($_SESSION['usertype'] == 'stormtrooper'){

		echo ' Storm Trooper.';

		}
	}
	else{ //if not logged in, no valid session
	
	echo "You don't seem to be logged in.";

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
