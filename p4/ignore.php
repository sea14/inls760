<?php

	//initalizing variables
	$titleSearch = "nada"; //default value
	$keySearch = "nothinghere"; //default value
	$comboFields = "blah"; //default value
	$startYear = "zippo"; //default value
	$endYear = "zwei"; //default value
	$minSecs = "there"; //default value
	$maxSecs = "anything"; //default value
	$sound = "noise"; //default value
	$color = "crossfade"; //default value

	if(isset($_POST['titleSearch']) || isset($_POST['keySearch']) || isset($_POST['comboFields']) || isset($_POST['startYear']) ||
		isset ($_POST['endYear']) || isset($_POST['minSecs']) || isset($_POST['maxSecs']) || isset($_POST['sound']) || isset($_POST['color'])){
	//if the user has provided text we sanitize and check for magic quotes below
	if(get_magic_quotes_gpc()){

		//magic_quotes is on, do nothing

		$titleSearch = htmlentities(strip_tags($_POST['titleSearch']));
		$comboFields = htmlentities(strip_tags($_POST['comboFields']));
		$keySearch = htmlentities(strip_tags($_POST['keySearch']));
		$startYear = htmlentities(strip_tags($_POST['startYear']));
		$endYear = htmlentities(strip_tags($_POST['endYear']));
		$minSecs = htmlentities(strip_tags($_POST['minSecs']));
		$maxSecs = htmlentities(strip_tags($_POST['maxSecs']));
		$sound = htmlentities(strip_tags($_POST['sound']));
		$color = htmlentities(strip_tags($_POST['color']));
		echo $keySearch;
		echo $titleSearch;
	}
	else{
	
		//magic quotes isn't on, so addslashes

		$titleSearch = addSlashes(htmlentities(strip_tags($_POST['titleSearch'])));
		$keySearch = addSlashes(htmlentities(strip_tags($_POST['keySearch'])));
		$comboFields = addSlashes(htmlentities(strip_tags($_POST['comboFields'])));
		$startYear = addSlashes(htmlentities(strip_tags($_POST['startYear'])));
		$endYear = addSlashes(htmlentities(strip_tags($_POST['endYear'])));
		$minSecs = addSlashes(htmlentities(strip_tags($_POST['minSecs'])));
		$maxSecs = addSlashes(htmlentities(strip_tags($_POST['maxSecs'])));
		$sound = addSlashes(htmlentities(strip_tags($_POST['sound'])));
		$color = addSlashes(htmlentities(strip_tags($_POST['color'])));
	}

	//connect to db
	require ("dbconnect.php");

	//constructing the sorting capability below
	
	
	//set up query based on user input
	$query = "SELECT * FROM p4records
		 WHERE keywords LIKE '%$keySearch%')"; 
		//(title IS NULL OR title LIKE '%$titleSearch%') (keywords LIKE '%$keySearch%')";
		//AND (keywords IS NULL OR keywords LIKE '%$keySearch%')";
		//AND (sound IS NULL OR sound LIKE '%$sound%').
		//AND (color IS NULL OR color LIKE '%$color%')";
	//AND keywords LIKE '%$keySearch%' AND sound LIKE '%$sound%' AND color LIKE '%$color%'";
	//"AND durationsec BETWEEN '%$minSecs%' AND '%$maxSecs%'";
	//"AND MATCH(title, description, keywords) " .
	//"AGAINST ('" . $comboFields . "')";
	$result = mysql_query($query);

	//table headers
	echo '<table>';
	echo '<tr><th><a href="?sortby=videoid">Video ID</a></th>';
	echo '<th><a href="?sortby=title">Title</a></th>';
	echo '<th><a href="?sortby=year">Year</a></th>';
	echo '<th><a href="?sortby=sound">Sound</a></th>';
	echo '<th><a href="?sortby=color">Color</a></th>';
	echo '<th><a href="?sortby=durationsec">Duration (seconds)</a></th>';
	echo '<th><a href="?sortby=genre">Genre</a></th></tr>';
	
	echo $keySearch;

	//loop through the results and output them
	while ($row = mysql_fetch_array($result)) {

		$vidID = $row['videoid'];
		$vidTitle = $row['title'];
		$vidYear = $row['creationyear'];
		$vidSound = $row['sound'];
		$vidColor = $row['color'];
		$vidDuration = $row['durationsec'];
		$vidGenre = $row['genre'];


		echo '<tr><td>'.$vidID.'</a></td>'.'<td>' .$vidTitle.'</th>'.'<td>' .$vidYear.'</td>';
		echo '<td>' .$vidSound. '</td>'. '<td>' .$vidColor.'</td>'.'<td>' .$vidDuration.'</td>';
		echo '<td>' .$vidGenre.'</td>';

	}
	echo '</table>';



		echo "</br>";
		//display the current query for the user
		echo $keySearch;
		echo "You searched for $titleSearch and also searched for $keySearch. You searched between a range of $minSecs";
		
		

		echo "</br>";

	}



	//ask user if they want to go back to create a new query
	echo 'Would you like to <a href= "http://ruby.ils.unc.edu/~seaustin/seaustin-p4/search.html">search</a> again?'

?>
