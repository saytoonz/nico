<?php
  include_once 'connect_db.php';
  include_once 'session.php';
  include 'header.php';
 ?>


<?php
if ($login_user) {
}else{
  die("<center>
      Please Login First!
      <br /><br />
      <a href=\"index.php\">Go to Login Screen</a>
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


 ?>




<!DOCTYPE html>
<html lang="en">
<body>
  <!--small Section div-->
  <section id="breadcrumb">
    <div class="container"><!--Section container-->
      <div class="row"><!--Section row-->
        <ol class="breadcrumb">
          <li class="active">Available Stock</li>
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
          <a href="home.php" class="list-group-item active main-color-bg"> Dashboard</a>

          <?php
            $selectuser = mysql_query("SELECT * FROM users WHERE user_id='$login_user'");
            $myFetch = mysql_fetch_assoc($selectuser);

            $name = $myFetch['fullname'];

          ?>
          <a href="home.php?<?php echo $name; ?>" class="list-group-item"><span class="glyphicon glyphicon-user"></span> Staff <span class="badge"><?php echo $name; ?> </span></a>

          <a style="cursor: pointer;" class="list-group-item" data-toggle="modal" data-target="#addStock"><span class="glyphicon glyphicon-shopping-cart"></span> Add Stock <span class="badge">New</span></a>



          <?php

            if ($login_user=="ADMINISTRATOR") {
              echo "<a href=\"manage_employee.php\" class=\"list-group-item\"><span class=\"glyphicon glyphicon-cog\"></span> Manage Employees </a>

          <a href=\"report.php\" class=\"list-group-item \"><span class=\"glyphicon glyphicon-list-alt\"></span> Report</a>";
            }

           ?>


        </div>
        <!--ends Left panel for Add,Manage etc-->
        <div class="well">
          <img src="images/Untitled-1.png" class=" img img-responsive img-circle" width="200px">
        </div><!--ends well div-->

        </div><!--end main col1-->

        <div  class="col-lg-9 col-md-9" ><!--main col2-->

        <div class="panel panel-default"><!--panel div-->

           <div id="tab">
          <div class="panel-heading"><!--panel heading-->
            <h3 class="panel-title">Available Stocks</h3>
          </div><!--panel heading-->
          <table  class=" table-responsive table table-striped table-hover cursor pointer">

             <thead>
              <tr>

                  <th>Item Name</th>
                  <th>Unit Price</th>
                  <th>Item Quantity</th>
                  <th>Last Updates Date</th>
              </tr>
            </thead>

          <!--Php for view available stock-->
            <?php
              $selectavai=mysql_query("SELECT * FROM additems WHERE itemqty !=0 ORDER BY itemname ASC ");

              while ($avalable=mysql_fetch_assoc($selectavai)) {


                $itemname=$avalable['itemname'];
                $itemprice=$avalable['itemprice'];
                $itemqty=$avalable['itemqty'];
                $itemdate=$avalable['itemdate'];

              /////////////////Html table for available stock///
                ?>
                  <tbody>
                    <tr class="">

                        <td><?php echo  $itemname; ?> </td>
                        <td><?php echo $itemprice; ?> </td>
                        <td><?php echo $itemqty; ?> </td>
                        <td><?php echo $itemdate; ?> </td>
                    </tr>
                  </tbody>
                <?php
              ///////////////Ends html table for available stock/
              }

             ?>
          <!--Ends php vew available report-->

            </table>
            </div>



<!--Script for print reciept-->

      <script type="text/javascript">
        function printDiv(tab) {
     var printContents = document.getElementById("tab").innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
      </script>
  <!--Ends reciept script-->

        <div id="tab">
            <button id="printing" class="btn btn-primary"  onclick="printDiv('tab')">Print List </button>
        </div>
          </div><!--panel body-->
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


 <!--Script for print reciept-->

      <script type="text/javascript">
        function printDiv(content<?php echo"$id";?>) {
     var printContents = document.getElementById("content<?php echo"$id";?>").innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
      </script>
  <!--Ends reciept script-->

   <?php include 'footer.php'; ?>

    <!--Link of Javascript-->
  <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
