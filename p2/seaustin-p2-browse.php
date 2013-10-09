<html>
<head>
	 <link rel="stylesheet" type="text/css" href="seaustin-p2-styles.css"/>
</head>
<body>

<?php
//connect to the database
$connect = mysql_connect('pearl.ils.unc.edu', 'webdb_3', 'blaaaaah') or trigger_error("SQL", E_USER_ERROR);
$db = mysql_select_db('webdb_3', $connect) or trigger_error("SQL", E_USER_ERROR);



$sort = "";
$sortby = array('authors', 'title', 'publication', 'year', 'type');
//array for sort options, inspired by http://stackoverflow.com/questions/10772783/php-pagination-not-working-after-sorting

	if(isset($_GET['sortby']) && in_array($_GET['sortby'], $sortby)){

		$sort = mysql_real_escape_string($_GET['sortby']);
	
	} else{

		$sort = 'itemnum';

	} //close else statement
	

	//most of pagination was learned through this tutorial: http://www.phpfreaks.com/tutorial/basic-pagination
	//find out the number of rows in the database
	$sql_pages = "SELECT COUNT(*) FROM p2records";
	$result = mysql_query($sql_pages, $connect) or trigger_error("SQL", E_USER_ERROR);
	$row_num = mysql_fetch_row($result);
	$number_rows = $row_num[0];

	$rowsperpage = 25;
	$totalpages = ceil($number_rows / $rowsperpage); //round up number of pages using ceil
	//get the current page or set it to a default page
	if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
	
		//make sure currentpage is an integer
		$currentpage = (int) $_GET['currentpage'];
		} else{
	
			//the default page number
			$currentpage = 1;
		} //close else


	$offset = ($currentpage - 1) * $rowsperpage;

	//get the query from the database
	$sql = "SELECT * FROM p2records ORDER BY $sort ASC LIMIT $offset, $rowsperpage";
	$result = mysql_query($sql, $connect) or trigger_error("SQL", E_USER_ERROR);

		 echo '<table>';
       		 echo '<tr><th><a href="?sortby=authors">Author</a></th>';
       		 echo '<th><a href="?sortby=title">Title</a></th>';
       		 echo '<th><a href="?sortby=publication">Publication</a></th>';
		 echo '<th><a href="?sortby=year">Year</a></th>';
        	 echo '<th><a href="?sortby=type">Type</a></th></tr>';

	//while we can fetch rows to fulfill the query, print out the table
	while ($row = mysql_fetch_assoc($result)){

	    	 //inspired by http://sudobash.net/web-dev-populate-phphtml-table-from-mysql-database/

                $itemNum = $row['itemnum'];
                $author = $row['authors'];
                $title = $row['title'];
                $publication = $row['publication'];
                $year = $row['year'];
                $type = $row['type'];
                $url = $row['url'];

        	//listing everything out for readability purposes
                echo '<td>'.$author.'</td>';
                echo '<td><a href='.$url.'">'.$title.'</a></td>';
                echo '<td>'.$publication.'</td>';
                echo '<td>'.$year.'</td>';
                echo '<td>'.$type.'</td>'; 
		echo "</tr>";
	} //close while loop 

		//close the table
		echo "</table>";

	//pagination links built below
	if($currentpage > 1){

		//get the previous page number
		$previousPage = $currentpage - 1;
		
		//show link to go back one page
		echo '<div class="link_buttons">';
		echo '<div id="backward">';
		echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$previousPage'>Go back a page?</a></div> ";
		echo '</div></div>';

	} //end if

	//range of the number of links to show
	$range = 2;

	
	for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++){


		//check if it's a valid page number
		if (($x > 0) && ($x <= $totalpages)) {

			if($x == $currentpage){
				// "highlight" current page, center it
				echo '<div class="announcement">';
				echo "You are on page ";
				echo "[<b>$x</b>] of $totalpages ";
				echo '</div>';
		
			//if we're not on the current page
			} else{
				echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'></a> ";

			} //end else
		
		} //end if


	} //close for loop

	//if we're not on the last page, show "Go forward a page?" option
	if($currentpage != $totalpages) {
		$nextpage = $currentpage + 1;
	
		//print out the forward link for next page
		echo '<div class="link_buttons"> <div id="forward">';
		echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>Go forward a page?</a> ";
		echo '</div> </div>';
	} //close if

?> <!--close php-->
</body>

</html>
