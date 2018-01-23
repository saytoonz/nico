<?php 
	$cn=mysql_connect("localhost","root","");
	if (!$cn) {
		die("No Database Connected");
	}

	$select_db=mysql_select_db("shopnico", $cn);

		if (!$select_db) {
			die("No Database Selected");
		}
	
	
 ?>