<?php 
	include 'session.php';
	include 'connect_db.php';
?>
<?php

	$dated =  date("jS F, Y - ");
			
		$hour = date("g");
		$hour = $hour - 2;
		$am_pm = date("A");

		if ($hour=="-1") {
			$hour ="12";
			
		}elseif ($hour=="0") {
			$hour ="1";
			
		}else{
			$hour = "$hour";
		}
		$time = date(":i ");

			mysql_query("UPDATE users SET login='no',last_entry='$dated$hour$time$am_pm' WHERE user_id='$login_user' AND active='yes'");

	session_destroy();

		?>
			<script>
				location.replace("index.php")
			</script>

		<?php
 ?>