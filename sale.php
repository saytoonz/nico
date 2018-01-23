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

    $gtotal="";

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



         /////////////////Delete sell item btn////////




  ///////////////////////wHEN CLICK ON bUY////////////

    if (isset($_POST['buyandprint'])) {


      $select_frm_sell = mysql_query("SELECT * FROM sellitem");
      $fetch_frm_sell = mysql_fetch_assoc($select_frm_sell);
      $item_id_sell = $fetch_frm_sell['itemid'];
      $item_name_sell = $fetch_frm_sell['itemname'];
      $item_price_sell = $fetch_frm_sell['item_price'];
      $item_qty_sell = $fetch_frm_sell['quantity'];
      $item_date_sell = $fetch_frm_sell['sell_date'];
      $item_total_sell = $fetch_frm_sell['total_amount'];

      if (!empty($item_price_sell) AND !empty($item_total_sell)) {
         /////////fetch fromm additems db taable//////////
      $select_frm_additm = mysql_query("SELECT * FROM additems WHERE id='$item_id_sell'");
      $fetch_frm_add = mysql_fetch_assoc($select_frm_additm);

      $item_name_add = $fetch_frm_add['itemname'];
      $item_price_add = $fetch_frm_add['itemprice'];
      $item_qty_add = $fetch_frm_add['itemqty'];

      $qty_left = $item_qty_add - $item_qty_sell;

      /////////fetch fromm users db taable//////////
      $select_frm_staff = mysql_query("SELECT * FROM users WHERE user_id='$login_user'");
      $fetch_frm_staff = mysql_fetch_assoc($select_frm_staff);

      $staff_name = $fetch_frm_staff['user_id'];




             $select_sell_list = mysql_query("SELECT * FROM sellitem");
             $num_rows = mysql_num_rows($select_sell_list);
              while ($culn = mysql_fetch_assoc($select_sell_list)) {

                $gtotal += $culn['total_amount'];

            }

            $systemdate = date("Y-m-d");


        //////////////Post from customers inputs//////////////////////
            $Cname=$_POST['Cname'];
            $Caddress=$_POST['Caddress'];
            $Cmobile=$_POST['Cmobile'];

        $insert_sale =("INSERT INTO sale (itemname, itemprice, itemqty, totalamount, staffname, grandtotal, itemdate, qtyleft, Cname, Caddress, Cmobile, dateSold) VALUES('$item_name_sell', '$item_price_sell','$item_qty_sell','$item_total_sell', '$staff_name', '$gtotal' ,'$item_date_sell','$qty_left', '$Cname', '$Caddress', '$Cmobile','$systemdate')");

        mysql_query($insert_sale)or die("no insert ".mysql_error());



      $qquery = mysql_query("SELECT max(id) FROM sale");
      $getQuery = mysql_fetch_assoc($qquery);
      $lastid = mysql_result($qquery, 0);


              $select_sell_list = mysql_query("SELECT * FROM sellitem");
             $num_rows = mysql_num_rows($select_sell_list);
              while ($culn = mysql_fetch_assoc($select_sell_list)) {


                $Sellitemid = $culn['itemid'];
                $quantity = $culn['quantity'];
                $itemname = $culn['itemname'];
                $amount = $culn['total_amount'];

                mysql_query("INSERT INTO receiptitems VALUES('', '$lastid','$itemname','$quantity', '$amount')");

                 $select_frm_additm = mysql_query("SELECT * FROM additems WHERE id='$Sellitemid'");
                   while ( $fetch_frm_add = mysql_fetch_assoc($select_frm_additm)) {

                    $item_id = $fetch_frm_add['id'];
                    $item_qty_add2 = $fetch_frm_add['itemqty'];

                    $qty_left2 = $item_qty_add2 - $quantity;

                      mysql_query("UPDATE additems SET itemqty = '$qty_left2' WHERE id='$item_id'");
                   };

            }

      ?>
      <script type="text/javascript">
        location.replace('receipts.php?rnO=FrmSaeRec<?php echo $lastid; ?>');
      </script>
      <?php

       }
     }

  ////////////////Ends click on Buy/////////////////////

 ?>




<!DOCTYPE html>
<html lang="en">
<body>

  <!--small Section div-->
  <section id="breadcrumb">
    <div class="container"><!--Section container-->
      <div class="row"><!--Section row-->
        <ol class="breadcrumb">
          <li class="active">Sale</li>
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
            $select = mysql_query("SELECT * FROM users WHERE user_id='$login_user'");
            $myFetch = mysql_fetch_assoc($select);

            $name = $myFetch['fullname'];

          ?>
          <a href="home.php?<?php echo $name; ?>" class="list-group-item"><span class="glyphicon glyphicon-user"></span> Staff <span class="badge"><?php echo $name; ?> </span></a>

          <a style="cursor: pointer;" class="list-group-item" data-toggle="modal" data-target="#addStock"><span class="glyphicon glyphicon-shopping-cart"></span> Add Stock <span class="badge">New</span></a>


          <?php

            if ($login_user=="ADMINISTRATOR") {
              echo "<a href=\"manage_employee.php\" class=\"list-group-item\"><span class=\"glyphicon glyphicon-cog\"></span> Manage Employees </a>

          <a href=\"report.php\" class=\"list-group-item\"><span class=\"glyphicon glyphicon-list-alt\"></span> Report</a>";
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
            <h3 class="panel-title">Buy Items</h3>
          </div><!--panel heading-->

          <div class="panel-body" id="dash"><!--panel body-->

          <!--search div-->
        <div id="sells" class="row col-md-12 col-lg-12">

       <form action="sale.php" method="post" autocomplete="off">

          <div id="search" class="input-group col-lg-6" >
          <input type="text" name="search_name" placeholder="Search Here" id="item" class="form-control input-sm">

          <div class="input-group-btn">
            <input class="btn btn-default bt-sm" type="submit" name="search" value="search">

          </div>

        </div>
        <br>


            <input class="btn btn-default bt-sm" type="submit" name="toReceipts" value="Receipts" style="float: right;">
        </form>

        <!--show search items-->

<?php


  if (isset($_POST['toReceipts'])) {
     ?>
      <script type="text/javascript">
        location.replace('receipts.php?rnO=1');
      </script>
      <?php
  }

        /////////////////When click on search/////////////////

    if (isset($_POST['search'])) {

    $search_name = $_POST['search_name'];

    if ($search_name !="") {


    /////////select from db additems//////////////
    $select = mysql_query("SELECT * FROM additems WHERE itemname LIKE '%$search_name%'");

      $rows=mysql_num_rows($select);

    if ($rows !==0) {

        if ($rows>1) {
          echo '<h3 class="text-danger">'. $rows. ' Items Found:</h3>';
        } else {
         echo '<h3 class="text-danger">'. $rows. ' Item Found:</h3>';
        }


      while ($fetch = mysql_fetch_assoc($select)) {

        $id=$fetch['id'];
        $itemname=$fetch['itemname'];
        $itemprice=$fetch['itemprice'];
        $qtyft=$fetch['itemqty'];

        /////////////////if Found display item name, price and qty left/////////////////////////

        ?>

            <div class="col-md-2 col-lg-2">
              <form  action="sale.php?<?php echo $fetch['id']; ?>" method="post">
              <br>
                <div style="width: 120px; background-color: #f1f1f1; border-radius: 5px; border:1px solid #333;">

                  <h4 class="text-info"><?php echo $fetch['itemname']?></h4>
                  <h4 class="text-danger">&#8373; <?php echo $fetch['itemprice']?></h4>
                  <h4 class="text-danger">Qty Left: <?php echo $fetch['itemqty']?></h4>



                  <input type="text" name="quantity" class="form-control" value="0">

                  <input type="hidden" name="id" class="form-control" value="<?php echo $fetch['id']; ?>">

                  <input type="hidden" name="hidden_name" class="form-control" value="<?php echo $fetch['itemname']; ?>">

                  <input type="hidden" name="hidden_price" class="form-control" value="<?php echo $fetch['itemprice']; ?>">

                  <input type="hidden" name="gtotal" class="form-control" value="<?php echo $fetch['itemprice']; ?>">

                  <input type="submit" name="add_to_cart" style="margin-top: 5px;" class="btn btn-success" value="ADD">

                </div>
              </form>
              </div>


          <?php

      }


    }


    /////////////////////When no item found////////////////

    if ($rows===0) {
      echo "<p style=\"font-size:20px; text-align:center;\">No Item Found</p>";

    }



    }
 }

  ////////////////////////End of search///////////////////

?>
        </div><!--ends search div-->
        </div><!--panel body-->
        </div><!--end panel div-->

        <!--Order List-->
      <div class="row">
      <div class="panel panel-default"><!--panel div-->
      <div class="panel-heading">
      <h3 class="panel-title">Order List</h3>
      </div>

      <div class="panel-body table-responsive">


      <?php

          //////////////////ADD TO CART///////////////////

          if (isset($_POST['add_to_cart'])) {

        $cart_id = $_POST['id'];
        $cart_name = $_POST['hidden_name'];
        $cart_price = $_POST['hidden_price'];
        $cart_qty = $_POST['quantity'];
        $amount = $cart_price * $cart_qty;

        if (!empty($cart_qty)) {

            $select_add = mysql_query("SELECT * FROM additems WHERE id='$cart_id' LIMIT 1");

            $getqty = mysql_fetch_assoc($select_add);

          $qty_add_lft = $getqty['itemqty'];

          if ($qty_add_lft<=0) {

            ?>
            <h4 class="text-danger h3 "> <span class="glyphicon glyphicon-warning-sign"> Item Quantity is Zero!!!</span></h4>

            <?php
          }else{


              $select_exist = mysql_query("SELECT * FROM sellitem WHERE itemname='$cart_name'");
              $num_exist = mysql_num_rows($select_exist);

                if ($num_exist===0) {

                 if ( $_POST['quantity'] > $qty_add_lft) {

              ?>
                      <h4 class="text-danger h3 "> <span class="glyphicon glyphicon-repeat">Entered quantity is more than quantity left!!!</span></h4>
              <?php
                   }else{

                  /////////////Insert into item temporal db///////
            $insertitem=mysql_query("INSERT INTO sellitem (itemid, itemname, item_price, quantity, total_amount)  VALUES ('$cart_id', '$cart_name', '$cart_price','$cart_qty','$amount')");

              }

                   } else {

                  ?>
            <h4 class="text-danger h3 "> <span class="glyphicon glyphicon-repeat"> Item already exist!!!</span></h4>
            <?php

                }//////////////Ends item already exist//////

          }


        } else {
          ?>
            <h4 class="text-danger h3 "> <span class="glyphicon glyphicon-warning-sign"> Please enter a quantity to buy</span></h4>
            <?php

          }///////////ends qty empty/////////

  } ///////End isset on add to cart/////////




 echo @$tab;

       ?>
      <!--Total amount and buy btn-->
       <form action="#" method="post">
          <div class="input-group" id="FillCustomer">

              <div id="inputsCustomer">

                 <input type="text" name="Cname" placeholder="Customer Name" id="item" class="form-control input-sm">


                <input type="text" name="Caddress" placeholder="Customer Address" id="item" class="form-control input-sm">

                <input type="text" name="Cmobile" placeholder="Customer Mobile" id="item" class="form-control input-sm">

                 <input type="submit" name="buyandprint" value="BUY" class="btn btn-default" id="buy_total">

                 <input type="button" name="cancel" value="CANCEL" class="btn btn-default" id="cancel" onclick="cancelBut()" >
              </div>

          </div>
      <table class="table table-bordered">


        <tr>
          <th >Item Name</th>
          <th >Quantity</th>
          <th >Item Price</th>
          <th >Total</th>
          <th >Action</th>
        </tr>

           <?php

           $gtotal="";
              $select_sell_list = mysql_query("SELECT * FROM sellitem ");

             $num_rows = mysql_num_rows($select_sell_list);
              while ($culn = mysql_fetch_assoc($select_sell_list)) {

                $gtotal += $culn['total_amount'];
                $amount = $culn['total_amount'];
                $itID = $culn['id'];

                if ($gtotal=="") {
                    $gtotal="";
                  } elseif (strpos($gtotal, '.')) {
                      $gtotal=$gtotal;
                  } else {
                      $gtotal="$gtotal.00";
                  }

                ?>


                <tr>
                  <td><?php echo $culn['itemname'] ; ?> </td>
                  <td><?php echo $culn['quantity'] ; ?> </td>
                  <td><?php echo "&#8373; ".$culn['item_price']."" ; ?> </td>
                  <td><?php echo "&#8373; $amount"  ; ?> </td>


                  <td>
                  <?php echo " <input type=\"submit\" name=\"deletesell$itID\" class=\"btn btn-danger\" value=\"Delete\">
                  </td>"; ?>
                </tr>

                <?php

                          ////////////When click on delet///////
                            if (isset($_POST["deletesell$itID"])) {

                                $delet_sell_row = mysql_query("DELETE FROM sellitem WHERE id = '$itID'");
                                if ($delet_sell_row===TRUE) {

                                   ?>
                                    <script>
                                      location.replace("sale.php");
                                    </script>
                                  <?php

                                } else {

                                  ?>
                                    <script>
                                      alert("Could Not delete, Try again!");
                                    </script>
                                  <?php
                                }


                            }
              }


             ?>

         </table>

      </form>

       <table class="table table-bordered" style="width: 60%">
          <tr class="danger">
              <th class="h3">Total Price</th>
              <th class="h3">Action</th>
          </tr>

        <tr>
          <td class="h3">GH&#8373; <?php echo $gtotal ?> </td>

          <td>
             <input type="submit" name="buy" value="BUY" class="btn btn-primary" onclick="document.getElementById('FillCustomer').style.display='block' " >
          </td>
        </tr>
      </table>


<!--Ends Total amount and buy btn-->



      </div>
      </div><!--panel div-->
      </div>

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


   <?php include 'footer.php'; ?>

       <script type="text/javascript">

          function cancelBut() {
          document.getElementById('FillCustomer').style.display="none";

        }




    </script>

    <!--Link of Javascript-->
  <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


</body>
</html>
