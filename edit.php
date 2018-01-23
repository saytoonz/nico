

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

	$utab = $_GET['nsromapaAllowEditUserEnteredInformationsWithSecID'];

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
  
            }
            

   
            $qq = mysql_query("SELECT * FROM users WHERE id='$utab' AND active='yes'AND user_id!='ADMINISTRATOR' LIMIT 1");
            if (mysql_num_rows($qq)===1) {

            		$fetchInfo = mysql_fetch_assoc($qq);
	            		$id = $fetchInfo['id'];
	            		$user_id = $fetchInfo['user_id'];
	            		$fullname = $fetchInfo['fullname'];
	            		$username = $fetchInfo['username'];
	            		$mobile = $fetchInfo['mobile'];
	            		$address = $fetchInfo['address'];
	            		$add_date = $fetchInfo['add_date'];
            }else{

	            	?>
	            <script type="text/javascript">
	            	location.replace("home.php");
	            </script>
	            	<?php

            }
  
 ?>




<!DOCTYPE html>
<html lang="en">
<body>

  <!--small Section div-->
  <section id="breadcrumb">
    <div class="container"><!--Section container-->
      <div class="row"><!--Section row-->
        <ol class="breadcrumb">
          <li class="active">Edit Staff Info</li>
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
          <a href="home.php" class="list-group-item  main-color-bg"> Dashboard</a>

          <?php
            $select = mysql_query("SELECT * FROM users WHERE user_id='$login_user'");
            $myFetch = mysql_fetch_assoc($select);
            
            $name = $myFetch['fullname'];

          ?>
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

        <div class="col-lg-9 col-md-9" ><!--main col2 right-->
          
        <div class="panel panel-default"><!--panel div-->
          <div class="panel-heading"><!--panel heading-->
            <h3 class="panel-title">Edit Staff Information.</h3>
          </div><!--panel heading-->

          <div class="panel-body" id="dash"><!--panel body-->
            
          <!--search div-->
        <div id="sells" class="row col-md-12 col-lg-12">

       
<?php 
echo "<form action=\"#\" method=\"post\" autocomplete=\"off\">

        <div id=\"search\" class=\"input-group col-lg-6\" >

          <input type=\"text\" value=\"$user_id\" placeholder=\"Staff ID\" id=\"item\" class=\"form-control input-sm\" disabled=\"disabled\"><br><br><br>


          <input type=\"text\" name=\"fullname\" value=\"$fullname\" placeholder=\"Enter Full Name\" id=\"item\" class=\"form-control input-sm\"><br><br><br>

          <input type=\"text\" value=\"$username\" placeholder=\"Username\" id=\"item\" class=\"form-control input-sm\"  disabled=\"disabled\"><br><br><br>

          <input type=\"text\" name=\"mobile\" value=\"$mobile\" placeholder=\"Mobile\" id=\"item\" class=\"form-control input-sm\"><br><br><br>

          <input type=\"text\" name=\"address\" value=\"$address\" placeholder=\"Address\" id=\"item\" class=\"form-control input-sm\"><br><br><br>

          <input type=\"text\"value=\"$add_date\" placeholder=\"Username\" id=\"item\" class=\"form-control input-sm\"  disabled=\"disabled\"><br><br><br>

          
          
        </div>


        <div class=\"input-group-btn\">
            <input class=\"btn btn-info\" type=\"submit\" name=\"Update\" value=\"Update\">
          
          </div>


        <div class=\"input-group-btn\">
            <input class=\"btn btn-danger\" type=\"submit\" name=\"Cancel\" value=\"Cancel\" >
          
          </div>
        </form>";




		if (isset($_POST['Cancel'])) {
			?>
	            <script type="text/javascript">
        				alert('Canceled');
	            	location.replace("manage_employee.php");
	            </script>
	            	<?php
		}





        if (isset($_POST['Update'])) {

        	$fullname = $_POST['fullname'];
			$mobile = $_POST['mobile'];
        	$address = $_POST['address'];


              $update=("UPDATE users SET fullname='$fullname', mobile='$mobile', address='$address' WHERE id='$utab' AND active='yes' AND user_id!='ADMINISTRATOR'");

            $queryupdaate=mysql_query($update,$cn);

        		?>
        			<script type="text/javascript">
        				alert('Done');
	            	location.replace("manage_employee.php");
        			</script>
        		<?php
        }

 ?>


   
</div>

      </div>
    </div><!--modal dialog-->
    
  </div><!--ends modal div-->

 
 



  <!--Ends reciept script-->

   <?php include 'footer.php'; ?>

    <!--Link of Javascript--> 
  <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>