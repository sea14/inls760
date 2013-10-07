<?php
	$h = 'pearl.ils.unc.edu';
	$u = 'webdb_3';
	$p = 'jacktuckerjet1994';
	$dbname = 'webdb_3';
	$db = mysql_connect($h, $u, $p)
		or die('Could not connect');
	mysql_select_db($dbname)
		or die('Could not select db');
?>
