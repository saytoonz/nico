<?php
  include_once 'connect_db.php';
  include_once 'session.php';
  include 'header.php';
 ?>


<?php
if ($login_user=="ADMINISTRATOR") {
}else{
  die("<center>
      Please Login First!
      <br /><br />
      <a href=\"logout.php\">Please Login as ADMINISTRATOR for Access</a>
    </center>");
}
?>
<?php

	///////////Add Stocks///////

			  //////////////////When Click On Add Iteem////////////////////

      if (isset($_POST['add'])) {


            ////////////Get post from inputs////////////
            $itemname= ucwords(mb_strtolower($_POST['itemname']));
            $itemdate=date("jS F, Y");
            $itemprice=$_POST['itemprice'];
            $itemqty=$_POST['itemqty'];
            $total= ($itemprice * $itemqty);

           if (!empty($itemname) AND !empty($itemqty) AND !empty($itemprice)) {

                $selectitm=("SELECT * FROM additems WHERE itemname='$itemname' LIMIT 1");

                  $queryitm=mysql_query($selectitm, $cn);

                    if (!$queryitm) {

                        die('Could not get data'.mysql_error());
                    }

                        if ($row=mysql_num_rows($queryitm)===1) {

                            $get=mysql_fetch_assoc($queryitm);
                            $id=$get['id'];
                            $itemnamedb=$get['itemname'];
                            $itemdatedb=$get['itemdate'];
                            $itempricedb=$get['itemprice'];
                            $itemqtydb=$get['itemqty'];

                            $addqty=$itemqtydb + $_POST['itemqty'];


                              if ($itemnamedb === $_POST['itemname']) {

                                ////////////////Update Item when item name is equal to entered itemname////////////

                                $upquery=mysql_query("UPDATE additems SET itemdate='$itemdate', itemprice='$itemprice', itemqty='$addqty' WHERE id='$id' LIMIT 1");
                                if ($upquery) {
                                  ?>
                              <script>
                                alert ('Stock has successfully Updated to the list');
                              </script>
                          <?php
                                }

                              }
                              ////////////////Insert into item when item name is not in database//////////////

                        }else {
                                $insertitem=("INSERT INTO additems (itemname, itemdate, itemprice, itemqty) VALUES('$itemname', '$itemdate','$itemprice','$itemqty')");

                    $queryinsert=mysql_query($insertitem, $cn);

                              $stocklistinsert=mysql_query("INSERT INTO stocklist (itemname, itemprice, itemqty, total, itemdate)VALUES('$itemname','$itemprice', '$itemqty', '$total', '$itemdate')");

                      if ($queryinsert===TRUE) {

                        ///////////////////When item successfully inserted , Display this//////////////////
                          ?>
                              <script>
                                alert ('New stock has successfully Added to the list');
                              </script>
                          <?php

                      }else {

                        ///////////////////When item not successfully inserted , Display this//////////////////

                        ?>
                          <script>
                              alert("Error In Adding Item, Please Try Again later!!! ")
                          </script>
                        <?php
                      }
                              }

                 } else {


           }

            } ///////////Ends Add Stocks///////


            /////////////////Add Staff/////////////////


            /////////////////Click to add Stafff////////////////

 		if (isset($_POST['add_staff'])) {


 			$staffid=$_POST['userid'];
 			$full_name=$_POST['fullname'];
 			$username=$_POST['username'];
 			$mobile=$_POST['mobile'];
 			$address=$_POST['address'];

 			//////////////When fields are not empty////////////
 				if ($full_name !=='' || $username !=="" || $mobile !=="" || $address !=="" || $staffid !=="") {

 					$selectuserid = mysql_query("SELECT user_id FROM users WHERE user_id='$staffid'");

 					if (mysql_num_rows($selectuserid)!==0) {
 						?>
 							<script>
 								alert("Staff ID already exits!");
 							</script>
 						<?php
 					} else {


 						$password=md5($staffid);

 								$insert=("INSERT INTO users (user_id, fullname, username, password, mobile, address) VALUES ('$staffid', '$full_name', '$username', '$password', '$mobile', '$address')");

 							$query=mysql_query($insert, $cn);
 								if ($query===TRUE) {

 									echo "

 										<script>
 											alert ('$full_name .has been added to our staffs');
 										</script>

 									";
 						}else{
 							?>
 							<script>
 								alert("unable to add Staff, Try again!!! IF it continues, Contact Nsromapa");
 							</script>
 						<?php
 						}
 					/////////////Ends insert//////////////


 					//////////////When fields are empty////////////

 					}




 				} else {

 					?>
 						<script>
 							alert("All Fields Must be Fill!!!")
 						</script>
 					<?php
 				}



 		}

/////////////////Ends Add Staff/////////////////


 		///////////////Get number of staff///////////

			$queryselect = mysql_query("SELECT * FROM users WHERE active='yes' AND user_id!='ADMINISTRATOR'");
			$selectnum = mysql_num_rows($queryselect);


 		////////////Ends number of staff//////////////



 ?>


<!DOCTYPE html>
<html lang="en">
<body>

	<!--small Section div-->
	<section id="breadcrumb">
		<div class="container"><!--Section container-->
			<div class="row"><!--Section row-->
				<ol class="breadcrumb">
					<li class="active">Manage Staff</li>
				</ol>
			</div><!--ens Section row-->
		</div><!--ends Section container-->
	</section>
	<!--ends small Section div-->


	<!--main nav-->
	<section id="main">
		<div class="container"><!--main container-->
			<div class="row"><!--main row-->
				<div class="col-lg-3 col-md-3" ><!--main col1-->

				<!--Left panel for Add,Manage etc-->
				<div class="list-group ">
					<a href="home.php" class="list-group-item  main-color-bg"> Home</a>


					<a href="home.php?<?php echo $name; ?>" class="list-group-item"><span class="glyphicon glyphicon-user"></span> Staff <span class="badge"><?php echo $name; ?> </span></a>

					<a style="cursor: pointer;" class="list-group-item" data-toggle="modal" data-target="#addStock"><span class="glyphicon glyphicon-shopping-cart"></span> Add Stock <span class="badge">New</span></a>


					<?php

						if ($login_user=="ADMINISTRATOR") {
							echo "<a href=\"manage_employee.php\" class=\"list-group-item active\"><span class=\"glyphicon glyphicon-cog\"></span> Manage Employees </a>

					<a href=\"report.php\" class=\"list-group-item \"><span class=\"glyphicon glyphicon-list-alt\"></span> Report</a>";
						}

					 ?>



				</div>
				<!--ends Left panel for Add,Manage etc-->

				<!--progress bar-->
				<div class="well"><!--well div-->
					<img src="images/Untitled-1.png" class=" img img-responsive img-circle" width="200px">

				</div><!--ends well div-->

				</div><!--end main col1-->

				<div class="col-lg-9 col-md-9" ><!--main col2-->

				<div class="panel panel-default"><!--panel div-->
					<div class="panel-heading"><!--panel heading-->
						<h3 class="panel-title">Staff Details</h3>
					</div><!--panel heading-->

					<div class="panel-body" id="dash"><!--panel body-->
						<div class="col-lg-4 col-md-4">
							<a style="cursor: pointer;" class="list-group-item" data-toggle="modal" data-target="#addStaff">
								<div class="well" id="user">
									<h3><span class="glyphicon glyphicon-user"></span></h3>
									<h4>ADD STAFF</h4>
								</div>
							</a>

						</div>


						<div class="col-lg-4 col-md-4">
							<a style="cursor: pointer;" class="list-group-item" data-toggle="modal" data-target="#viewStaff">
								<div class="well">
									<h3><span class="glyphicon glyphicon-list-alt"></span></h3>

								<form action="" method="post">
									<input type="submit" name="view" class="btn btn-default" value="VIEW STAFF">
								</form>
								</div>
							</a>
						</div>

						<div class="col-lg-4 col-md-4">
							<a style="cursor: pointer;" class="list-group-item" data-toggle="modal" data-target="">
								<div class="well">
									<h3><span class="glyphicon glyphicon-book"></span></h3>
									<h4>TOTAL STAFF</h4><h4><?php echo $selectnum;  ?> </h4>
								</div>
							</a>


						</div>
					</div><!--panel body-->
				</div><!--end panel div-->

				<!--Latest sale-->
			<div class="panel panel-default"><!--panel div-->
			<div class="panel-heading">
			<h3 class="panel-title"></h3>
			</div>

			<div class="panel-body">

			</div>
	</div><!--panel div-->


				</div><!--end main col2-->
			</div><!--main row-->
		</div><!--ends main container-->
	</section>
	<!--ends main nav-->

	<!--Add sTOCK-->
	<!--modal div-->
	<div class="modal fade "  id="addStock" tabindex="-1" role="dialog" aria-labelledby="">
		<!--modal dialog-->
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">

				<form action="#addStock" method="post">
				<div class="modal-header">

				<button type="button" id="" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span> </button>
				<h4 class="modal-title" id="">Add sale</h4>
				</div>
				<div class="modal-body">

					<!-- name-->
      			<div class="form-group">
      				<label for="itemname">Item Name</label>
      				<input type="text" name="itemname" id="itemname" class="form-control" placeholder="Item">
      			</div>
      			<!-- ends name-->

      			<!-- qty-->
      			<div class="form-group">
      				<label for="itemqty">Item Quantity</label>
      				<input type="text" name="itemqty" id="itemqty" class="form-control" placeholder="Quantity">
      			</div>
      			<!-- ends qty-->

      			<!-- price-->
      			<div class="form-group">
      				<label for="itemprice">Item Price</label>
      				<input type="text" name="itemprice" id="itemprice" class="form-control" placeholder="Price">
      			</div>
      			<!-- ends price-->

      			<!-- DATE-->
      			<div class="form-group">
      				<label for="itemdate">Date</label>
      				<input type="text" name="itemdate" id="itemdate" class="form-control" disabled="disabled" value="<?php echo date('jS F, Y'); ?>">
      			</div>
      			<!-- ends DATE-->

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="submit" name="add" class="btn btn-primary" value="ADD">
				</div>

				</form><!--Form ends-->
			</div>
		</div><!--modal dialog-->

	</div><!--ends modal div-->






	<!--Add Staff-->
	<!--modal div-->
	<div class="modal fade "  id="addStaff" tabindex="-1" role="dialog" aria-labelledby="">
		<!--modal dialog-->
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">

				<form action="#addStaff" method="post">
				<div class="modal-header">

				<button type="button" id="" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span> </button>
				<h4 class="modal-title" id="">Add New Staff</h4>
				</div>
				<div class="modal-body">

					<!-- Full Name-->
      			<div class="form-group">
      				<label for="fullname">Full Name</label>
      				<input input type="text" name="fullname" placeholder="Full Name" required="required" id="fullname" class="form-control">
      			</div>
      			<!-- ends Full Name-->

      			<!-- User Name-->
      			<div class="form-group">
      				<label for="username">User Name</label>
      				<input type="text" name="username" placeholder="Username" required="required" id="username" class="form-control" placeholder="User Name">
      			</div>
      			<!-- ends User Name-->

      			<!-- Mobile Number-->
      			<div class="form-group">
      				<label for="number">Mobile</label>
      				<input type="text" name="mobile" placeholder="Mobile" required="required" maxlength="10" id="number" class="form-control" >
      			</div>
      			<!-- ends Mobile Number-->

      			<!-- Address-->
      			<div class="form-group">
      				<label for="address">Address</label>
      				<input type="text" name="address" placeholder="Address" required="required" id="address" class="form-control" >
      			</div>
      			<!-- ends Address-->

      			<!-- Staff Id-->
      			<div class="form-group">
      				<label for="staff_id">Staff Id</label>
      				<input type="text" name="userid" placeholder="Staff Id" required="required" id="staff_id" class="form-control" >
      			</div>
      			<!-- ends Staff Id-->

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="submit" name="add_staff" class="btn btn-primary" value="ADD">
				</div>

				</form><!--Form ends-->
			</div>
		</div><!--modal dialog-->

	</div><!--ends modal div for Staffs-->



	<!--View Staff and Edit-->
	<!--modal div-->
	<form action="" method="post">
	<div class="modal fade "  id="viewStaff" tabindex="-1" role="dialog" aria-labelledby="">

		<!--modal dialog-->
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">


				<div class="modal-header">

				<button type="button" id="" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span> </button>
				<h3 class="modal-title" id="">View Staff</h3>
				</div>
				<div class=" table-responsive modal-body col-xs-12">

				<table class="table table-bordered table-hover " >

					<tr class="danger">

						<th >Full Name</th>
						<th >Staff Id</th>
						<th >Mobile</th>
						<th >Address</th>
						<th >Date</th>
						<th >Action</th>
					</tr>

		<!--Php for View Staff-->

			<?php
					$select_staff_view = mysql_query("SELECT * FROM users WHERE active ='yes' AND user_id!='ADMINISTRATOR' ORDER BY fullname ASC") or die("Could not get data");

 						while ($row = mysql_fetch_assoc($select_staff_view)) {

 						$id = $row['id'];
 						$user_id = $row['user_id'];
 						$fullname = $row['fullname'];
 						$mobile = $row['mobile'];
 						$address = $row['address'];
 						$add_date = $row['add_date'];



 						if (isset($_POST["resetD$id"])) {

 								$resPass = md5($user_id);

 							$update=mysql_query("UPDATE users SET password='$resPass' WHERE id='$id'");

				 				?>
									<script type="text/javascript">
										alert("Password reseted to Staff ID...");
										location.replace("manage_employee.php");
									</script>
								<?php
 						}

 								////////////////Delete Staff/////////////

		if (isset($_POST["delete_staff$id"])) {



				 mysql_query("UPDATE users SET active='no' WHERE id='$id'")or die("Could Not update, Try again!!!".mysql_error());

				mysql_query("INSERT INTO deleted_staff(user_id, fullname, mobile, address)VALUES('$user_id','$fullname', '$mobile' ,'$address')")or die(mysql_error());

				?>
					<script type="text/javascript">
						location.replace("manage_employee.php");
					</script>
				<?php

		}




 			/////////////////Html table for View Staff//////
 					?>

 					<tr class="active" ondblclick="location.replace('edit.php?nsromapaAllowEditUserEnteredInformationsWithSecID=<?php echo $id ?>');">
						<td><?php echo $fullname; ?></td>
						<td><?php echo $user_id; ?></td>
						<td><?php echo $mobile; ?></td>
						<td><?php echo $address; ?></td>
						<td><?php echo $add_date; ?></td>

						<td>



						<?php echo "<input type=\"submit\" value=\"Reset Password\" name=\"resetD$id\" class=\"btn btn-info\" id=\"resetpass\">

						<input type=\"submit\" value=\"Deactivate\" name=\"delete_staff$id\" class=\"btn btn-danger\">"; ?>

						 </td>
					</tr>

 					<?php

 			////////////Ends Html table for view staff/////////


	}///////Ends While

 		///////////////////Ends Delete staff//////////

			 ?>

		<!--Ends Php View Staff-->

      			</table> <!--Ends View staff table-->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>


			</div>
		</div><!--modal dialog-->

	</div><!--ends modal div for view staff and edit-->
	</form><!--Form ends-->



   <?php include 'footer.php'; ?>


    <!--Link of Javascript-->
	<script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
