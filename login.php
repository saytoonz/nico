<?php 

	include  'session.php';
	include 'connect_db.php';
 ?>

 <?php 

  ?>

 <?php 

	$dbManagerQuery =mysql_query("SELECT * FROM dbManager WHERE DoneWithPeriod='no' LIMIT 1");
	if (mysql_num_rows($dbManagerQuery)!==0) {
		$fetchdbMan = mysql_fetch_assoc($dbManagerQuery);
			$id = $fetchdbMan['id'];
			$dateGiven = $fetchdbMan['dateGiven'];
			$Alert1 = $fetchdbMan['Alert1'];
			$Alert2 = $fetchdbMan['Alert2'];
			$Alert3 = $fetchdbMan['Alert3'];
			$Alert4 = $fetchdbMan['Alert4'];
			$Alert5 = $fetchdbMan['Alert5'];
			$dateEnding = $fetchdbMan['dateEnding'];

			$today = date("Y-m-d");

			if ($today==$dateEnding) {

				mysql_query("UPDATE dbManager SET DoneWithPeriod='all' WHERE id='$id' AND DoneWithPeriod='no'");
				?>
			 		<script type="text/javascript">
			 			alert("Please Software completely expired\nContact Nsromapa for Update\n0559 685 442 / 0548 157 455");
			 			location.replace("logout.php");
			 			
			 		</script>
			 		<?php
			}
			

				if ($today=="$Alert1") {
					?>
			 		<script type="text/javascript">
			 			alert("Please Software has 5 days to expire\nContact Nsromapa for Update\n0559 685 442 / 0548 157 455");
			 		</script>
			 		<?php
				}elseif ($today=="$Alert2") {
					?>
			 		<script type="text/javascript">
			 			alert("Please Software has 4 days to expire\nContact Nsromapa for Update\n0559 685 442 / 0548 157 455");
			 		</script>
			 		<?php
				} elseif ($today=="$Alert3") {
					?>
			 		<script type="text/javascript">
			 			alert("Please Software has 3 days to expire\nContact Nsromapa for Update\n0559 685 442 / 0548 157 455");
			 		</script>
			 		<?php
				} elseif ($today=="$Alert4") {
					?>
			 		<script type="text/javascript">
			 			alert("Please Software has 2 days to expire\nContact Nsromapa for Update\n0559 685 442 / 0548 157 455");
			 		</script>
			 		<?php
				} elseif ($today=="$Alert5") {
					?>
			 		<script type="text/javascript">
			 			alert("Please Software has 1 day to expire\nContact Nsromapa for Update\n0559 685 442 / 0548 157 455");
			 		</script>
			 		<?php
				} 
				

 			if (isset($_POST['loginside'])) {
 			
 			$login_name=$_POST['username'];
 			$login_password=$_POST['userpassword'];

 			if ($login_name !="" OR $login_password !="") {
 				
 					$login_password=md5($login_password);

 						$select=("SELECT * FROM users WHERE username='$login_name' AND password='$login_password' AND active='yes' ");
 						
 						$effect=mysql_query($select,$cn);
 							if (!$effect) {
 								die("No User Found");
 							}

 						if (mysql_num_rows($effect)===1) {

 							if ($fetch=mysql_fetch_assoc($effect)) {
					

 							$user_id=$fetch['user_id'];
 							$_SESSION['user_id']=$user_id;

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

			mysql_query("UPDATE users SET login='yes',last_entry='$dated $hour$time$am_pm' WHERE user_id='$user_id' AND active='yes'");

 								
		?>
		<script> 
			window.location.href=('home.php?SERVER=<?php echo "$login_name";?>');
		</script>
		<?php

 							}
 						}else{

 							?>
 								<script>
 									location.replace("index.php?error1");
 								</script>
 							<?php
 						}

 			} else {
 				?>
 					<script>
 						location.replace("index.php?error2")
 					</script>
 				<?php
 			}
 			
 		}

 	}else{
 		?>
 		<script type="text/javascript">
 			alert("Please Software has expired\nContact Nsromapa for Update now\n0559 685 442 / 0548 157 455");

 			location.replace("logout.php");
 		</script>
 		<?php
 	}
  ?>
  <?php include 'close_connect.php';  ?>