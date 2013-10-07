<?php

	//initalizing variables
	$titleSearch = "Nothing"; //default value
	$keySearch = "Nothing"; //default value
	$comboFields = "Nothing"; //default value
	$startYear = "Nothing"; //default value
	$endYear = "Nothing"; //default value
	$minSecs = "Nothing"; //default value
	$maxSecs = "Nothing"; //default value
	$sound = "Nothing"; //default value
	$color = "Nothing"; //default value
	
	if(isset($_GET['titleSearch']) || isset($_GET['keySearch']) || isset($_GET['comboFields']) || 
		isset($_GET['startYear']) || isset ($_GET['endYear']) || isset($_GET['minSecs']) 
		|| isset($_GET['maxSecs']) || isset($_GET['sound']) || isset($_GET['color'])){
	
		//check for magic quotes below
		if(get_magic_quotes_gpc()){

			//magic_quotes is on, do nothing

			$titleSearch = htmlentities(strip_tags($_GET['titleSearch']));
			$comboFields = htmlentities(strip_tags($_GET['comboFields']));
			$keySearch = htmlentities(strip_tags($_GET['keySearch']));
			$startYear = htmlentities(strip_tags($_GET['startYear']));
			$endYear = htmlentities(strip_tags($_GET['endYear']));
			$minSecs = htmlentities(strip_tags($_GET['minSecs']));
			$maxSecs = htmlentities(strip_tags($_GET['maxSecs']));
			$sound = htmlentities(strip_tags($_GET['sound']));
			$color = htmlentities(strip_tags($_GET['color']));
		
		}
		else{
	
			//magic quotes isn't on, so addslashes

			$titleSearch = addSlashes(htmlentities(strip_tags($_GET['titleSearch'])));
			$keySearch = addSlashes(htmlentities(strip_tags($_GET['keySearch'])));
			$comboFields = addSlashes(htmlentities(strip_tags($_GET['comboFields'])));
			$startYear = addSlashes(htmlentities(strip_tags($_GET['startYear'])));
			$endYear = addSlashes(htmlentities(strip_tags($_GET['endYear'])));
			$minSecs = addSlashes(htmlentities(strip_tags($_GET['minSecs'])));
			$maxSecs = addSlashes(htmlentities(strip_tags($_GET['maxSecs'])));
			$sound = addSlashes(htmlentities(strip_tags($_GET['sound'])));
			$color = addSlashes(htmlentities(strip_tags($_GET['color'])));
		}

	}
	//connect to db
	require ("dbconnect.php");
	
	if($endYear == "Nothing"){

		$endYear = "5000";
	}	

	//building sort functionality below
	$sort = "";
	$sortby = array('videoid', 'title', 'sound', 'creationyear', 'color', 'durationsec', 'genre');

	if(isset($_GET['sortby']) && in_array($_GET['sortby'], $sortby)){

		$sort = mysql_real_escape_string($_GET['sortby']);
	}else{

		$sort = 'videoid';

	}


	//if statements for building query are here. checking to see if value is empty
	if(empty($titleSearch)){
	
		$titleQuery = "title IS NOT NULL";

	}else{
		$titleQuery = "title LIKE '%".$titleSearch."%'";
	}

	if(empty($keySearch)){

		$keyQuery = "keywords IS NOT NULL";

	}else{
		$keyQuery = "keywords LIKE '%".$keySearch."%'";
	}

	if(empty($sound)){
		
		$soundQuery = "sound IS NOT NULL";

	}else{

		$soundQuery = "sound LIKE '%".$sound."%'";

	}
	if(empty($color)){
		
		$colorQuery = "color IS NOT NULL";

	}else{

		$colorQuery = "color LIKE '%".$color."%'";
	}

	if(empty($endYear)){

		$endQuery = "creationyear IS NOT NULL";

	}else{

		$endQuery = "creationyear <".$endYear;
	}

	if(empty($startYear)){

		$startQuery = "creationyear IS NOT NULL";
	}else{

		$startQuery = "creationyear >".$startYear;

	}
	if(empty($minSecs)){

		$minQuery = "durationsec IS NOT NULL";

	}else{
		$minQuery = "durationsec >".$minSecs;
	}
	if(empty($maxSecs)){

		$maxQuery = "durationsec IS NOT NULL";
	
	}else{
		$maxQuery = "durationsec <".$maxSecs;
	}
	if(empty($comboFields)){
		$comboQuery = "";
	}else{
		$comboQuery = " AND MATCH(title, description, keywords) AGAINST ('". $comboFields ."')";
	}
	$fullQuery = "SELECT * FROM p4records WHERE ".$titleQuery." AND ".$keyQuery." AND ".$soundQuery.
			" AND ".$colorQuery." AND ".$endQuery." AND ".$startQuery." AND ".$minQuery." AND ".$maxQuery.
			$comboQuery.
			" ORDER BY $sort ASC";
	
	$result = mysql_query($fullQuery);

			
	//table headers and really long URLs because of the query
	echo'<table>';
	echo '<th><a href="?sortby=videoid&titleSearch='.$titleSearch.'&keySearch='.$keySearch.
		'&comboFields='.$comboFields.'&startYear='.$startYear.'&endYear='.$endYear.
		'&minSecs='.$minSecs.'&maxSecs='.$maxSecs.'&sound='.$sound.
		'&color='.$color.'">Video ID</a></th>';

	echo '<th><a href="?sortby=title&titleSearch='.$titleSearch.'&keySearch='.$keySearch.
		'&comboFields='.$comboFields.'&startYear='.$startYear.'&endYear='.$endYear.
		'&minSecs='.$minSecs.'&maxSecs='.$maxSecs.'&sound='.$sound.
		'&color='.$color.'">Title</a></th>';

	echo '<th><a href="?sortby=creationyear&titleSearch='.$titleSearch.'&keySearch='.$keySearch.
		'&comboFields='.$comboFields.'&startYear='.$startYear.'&endYear='.$endYear.
		'&minSecs='.$minSecs.'&maxSecs='.$maxSecs.'&sound='.$sound.
		'&color='.$color.'">Year</a></th>';

	echo '<th><a href="?sortby=sound&titleSearch='.$titleSearch.'&keySearch='.$keySearch.
		'&comboFields='.$comboFields.'&startYear='.$startYear.'&endYear='.$endYear.
		'&minSecs='.$minSecs.'&maxSecs='.$maxSecs.'&sound='.$sound.
		'&color='.$color.'">Sound</a></th>';
	
	
	echo '<th><a href="?sortby=color&titleSearch='.$titleSearch.'&keySearch='.$keySearch.
		'&comboFields='.$comboFields.'&startYear='.$startYear.'&endYear='.$endYear.
		'&minSecs='.$minSecs.'&maxSecs='.$maxSecs.'&sound='.$sound.
		'&color='.$color.'">Color</a></th>';

	echo '<th><a href="?sortby=durationsec&titleSearch='.$titleSearch.'&keySearch='.$keySearch.
		'&comboFields='.$comboFields.'&startYear='.$startYear.'&endYear='.$endYear.
		'&minSecs='.$minSecs.'&maxSecs='.$maxSecs.'&sound='.$sound.
		'&color='.$color.'">Duration (sec)</a></th>';

	echo '<th><a href="?sortby=genre&titleSearch='.$titleSearch.'&keySearch='.$keySearch.
		'&comboFields='.$comboFields.'&startYear='.$startYear.'&endYear='.$endYear.
		'&minSecs='.$minSecs.'&maxSecs='.$maxSecs.'&sound='.$sound.
		'&color='.$color.'">Genre</a></th></tr>';

	$rowNumber = mysql_num_rows($result);
		echo '</br>';	
	

	if($rowNumber == 0){
	
		echo "Sorry, your search returned no results!";
	
	}

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
		//display the current query for the user via a series of if-statements
		echo "You searched for the following: <ul>";
		if(!empty($titleSearch)){
			echo "<li>".$titleSearch." as a video title </li>";
		}
		if(!empty($keySearch)){
			echo "<li>".$keySearch." in the keywords box </li>";
		}
		if(!empty($comboFields)){
			echo "<li>".$comboFields." over the title, description and keywords fields combined. </li>";
		}
		if (!empty($startYear)){
			echo '<li> You searched for videos starting at the year '.$startYear.'</li>';
		}
		if(!empty($endYear)){
			echo '<li> You searched for videos with a maximum year of '.$endYear.'</li>';
		}
		if (!empty($minSecs)){
			echo '<li> You searched for videos with a minimum length of '.$minSecs.'</li>';;
		}
		if(!empty($maxSecs)){
			echo '<li> You wanted videos with a maximum length of '.$maxSecs.'</li>';
		}
		if(!empty($sound)){
			echo '<li> You wanted videos with only sound. </li>';
		}
		if(!empty($color)){
			echo '<li>You wanted videos with only color. </li>';
		}
		echo "</ul>";
		echo "</br>";

	//ask user if they want to go back to create a new query
	echo 'Would you like to <a href= "http://ruby.ils.unc.edu/~seaustin/seaustin-p4/search.html">search</a> again?';

?>
