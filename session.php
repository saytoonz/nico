<?php 
	session_start();
	if (!isset($_SESSION['user_id'])) {
		$login_user="";
	} else {
		$login_user=$_SESSION['user_id'];
	}
	
 ?>