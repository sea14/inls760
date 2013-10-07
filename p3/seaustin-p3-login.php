<html>
<head>
<title>Login</title>
</head>
<body>
<?php
	//initializing variables
	$fuser = "none"; //default value
	$fpass = "nada"; //default value
	
	if(isset($_POST['fuser']) && isset($_POST['fpass'])){
	//user has given a username and password, try to log them in	

	//checking for magic quotes, sanitizing user input below
	if(get_magic_quotes_gpc()){
		//magic_quotes gpc is on, so do nothng
		$fuser = htmlentities(strip_tags($_POST['fuser']));
		$fpass = htmlentities(strip_tags($_POST['fpass']));

	} else {
		//magic quotes_gpc is off, so use addslashes
		$fuser = addslashes(htmlentities(strip_tags($_POST['fuser'])));
		$fpass = addslashes(htmlentities(strip_tags($_POST['fpass'])));
	}

	//connect to db
	require "dbconnect.php";


	//query database
	$query = 'select usertype from p3users ' . "where username = '$fuser' "
		. "and password = sha1('$fpass')";

	//echo "query = $query" . "<br>";
	$result = mysql_query($query);
	//echo mysql_error($db);

	$num_rows = mysql_num_rows($result);
	
	if($num_rows>0){
	
		session_start(); //begin the session
		$row = mysql_fetch_row($result);
		$_SESSION['valid_user'] = $fuser;
		$_SESSION['usertype'] = $row[0];
	}
	mysql_close($db);
	}

?>
	
<h1>Login Page</h1>

<?php
	if(isset($_SESSION['valid_user'])) {
	//user has logged in

	echo 'Welcome, ' . $_SESSION['valid_user'] . '<br>';
	echo 'You are logged as a ';

	if ($_SESSION['usertype'] == 'jediknight') {
		echo 'Jedi Knight. Use the force.';
		}
	if($_SESSION['usertype'] == 'stormtrooper') {
		echo 'Storm Trooper.';
		}
	}else{
	if(isset($fuser) && $fuser !="none") { //if we're having login problems
		echo "There seems to be a problem with either your password or your username.<br>";
		echo "Did you enter your password and your username correctly?";
	}else{
		echo "You're not logged in--would you please do so below?";
	}
?>

	<!--form below-->
	<p></p>
	<form method = "post" action="seaustin-p3-login.php">
	Username&nbsp;<input type="text" name = "fuser"><p>
	Password&nbsp;<input type="password" name="fpass"><p>
	<input type="submit" value="Login">
	<p></p>
<?php
	}
?>

	<p></p>
	<a href="seaustin-p3-login.php">Login</a>
	<a href="seaustin-p3-page1.php">Page 1</a>
	<a href="seaustin-p3-page2.php">Page 2</a>
	<a href="seaustin-p3-page3.php">Page 3</a>
	<a href="seaustin-p3-page4.php">Page 4</a>
	<a href="seaustin-p3-logout.php">Log Out</a>





</html>
