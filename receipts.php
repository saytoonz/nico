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


         /////////////////Delete sell item btn////////

      ////////////When click on delet///////
              if (isset($_POST['deletesell'])) {

                $selectonlyid = mysql_query("SELECT * FROM sellitem");
                $fetchid = mysql_fetch_assoc($selectonlyid);

                $id = $fetchid['id'];
                $itemid = $fetchid['itemid'];
                $itemname = $fetchid['itemname'];
                $total = $fetchid['total_amount'];

                $delet_sell_row = mysql_query("DELETE FROM sellitem WHERE itemid = '$itemid' ");
                if ($delet_sell_row===TRUE) {

                  ?>
                    <script>
                      alert("Item has successfully removed")
                    </script>
                  <?php

                } else {

                  ?>
                    <script>
                      alert("Could Not delet, Try again!!!")
                    </script>
                  <?php
                }

              }

         /////////////Ends delete sell btn//////////////


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

      $staff_name = $fetch_frm_staff['fullname'];



        $insert_sale =("INSERT INTO sale (itemname, itemprice, itemqty, totalamount, staffname, grandtotal, itemdate, qtyleft) VALUES('$item_name_sell', '$item_price_sell','$item_qty_sell','$item_total_sell', '$staff_name', '$gtotal' ,'$item_date_sell','$qty_left')");

        mysql_query($insert_sale)or die("no insert ".mysql_error());

        mysql_query("UPDATE additems SET itemqty = '$qty_left' WHERE id='$item_id_sell'");







      $qquery = mysql_query("SELECT max(id) FROM sale");
      $getQuery = mysql_fetch_assoc($qquery);
      $lastid = mysql_result($qquery, 0);


              $select_sell_list = mysql_query("SELECT * FROM sellitem");
             $num_rows = mysql_num_rows($select_sell_list);
              while ($culn = mysql_fetch_assoc($select_sell_list)) {


                $quantity = $culn['quantity'];
                $itemname = $culn['itemname'];
                $amount = $culn['total_amount'];

                mysql_query("INSERT INTO receiptitems VALUES('', '$lastid','$itemname','$quantity', '$amount')");

            }

      ?>
      <script type="text/javascript">
        location.replace('receipts.php?rnO=FrmSaeRec<?php echo $lastid; ?>');
      </script>
      <?php
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
          <li class="active">Receipts</li>
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
            <h3 class="panel-title">Search Receipt</h3>
          </div><!--panel heading-->

          <div class="panel-body" id="dash"><!--panel body-->

          <!--search div-->
        <div id="sells" class="row col-md-12 col-lg-12">

       <form action="#" method="post" autocomplete="off">

        <div id="search" class="input-group col-lg-6" >
          <input type="text" name="search_name" placeholder="Enter Receipt Number" id="item" class="form-control input-sm">

          <div class="input-group-btn">
            <input class="btn btn-default bt-sm" type="submit" name="search" value="search">

          </div>

        </div>
        </form>




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



        <?php
        if (isset($_POST['search'])) {

            $search_Rec = $_POST['search_name'];


              if ($search_Rec !="") {
                     ?>
                <script type="text/javascript">
                  location.replace('receipts.php?rnO=SpecRecWtNmb<?php echo $search_Rec; ?>');
                </script>
                  <?php
              }


         }

          ?>




<?php
  include_once 'connect_db.php';
 ?>

  <?php

    $FtaB = $_GET['rnO'];

      $rnO1 =substr($FtaB, 9);
      $rnO2 =substr($FtaB, 12);

 if (strpos($FtaB, "FrmSaeRec") !==false) {

        $delete_sell = mysql_query("TRUNCATE TABLE sellitem")or die("No delete ".mysql_error());


      ?>
      <script type="text/javascript">
        location.replace('receipts.php?rnO=SpecRecWtNmb<?php echo $rnO1; ?>');
      </script>
      <?php

 }elseif (strpos($FtaB, "SpecRecWtNmb") !==false) {




    $select_sale = mysql_query("SELECT * FROM sale WHERE id='$rnO2'");
  $check_sale = mysql_num_rows($select_sale);

  $get_sale = mysql_fetch_assoc($select_sale);

      $id = $get_sale['id'];
      $itemqty = $get_sale['itemqty'];
      $totalamount = $get_sale['totalamount'];
      $thatuserID = $get_sale['staffname'];
      $grandtotal = $get_sale['grandtotal'];
      $qtyleft = $get_sale['qtyleft'];
      $itemdate = $get_sale['itemdate'];
      $Cname = $get_sale['Cname'];
      $Caddress = $get_sale['Caddress'];
      $Cmobile = $get_sale['Cmobile'];

      if ($grandtotal=="") {
          $grandtotal="";
        } elseif (strpos($grandtotal, '.')) {
            $grandtotal=$grandtotal;
        } else {
            $grandtotal="$grandtotal.00";
        }

      $qq = mysql_query("SELECT fullname FROM users WHERE user_id='$thatuserID'");
        $ft = mysql_fetch_assoc($qq);
        $SoldBY = $ft['fullname'];




      $print_date = date("d-m-Y");

      if ($id <= 9) {
        $receipt_no = "000$id";
      }elseif ($id <=99) {
        $receipt_no = "00$id";
      }elseif ($id <=999) {
        $receipt_no = "0$id";
      }elseif ($id <=9999) {
        $receipt_no = "$id";
      }





        $items="";


      $itemListQuery = mysql_query("SELECT * FROM receiptitems  WHERE receiptNum = '$rnO2'");
      if (mysql_num_rows($itemListQuery)!==0) {
              while ($getItems = mysql_fetch_assoc($itemListQuery)) {

                $ItemName = $getItems['ItemName'];
                $Quantity = $getItems['Quantity'];
                $Price = $getItems['Price'];



                if ($Price=="") {
                    $Price="";
                  } elseif (strpos($Price, '.')) {
                      $Price=$Price;
                  } else {
                      $Price="$Price.00";
                  }


           $items.= "<table>
                        <tr width=\"100%\">
                          <td style=\"min-width: 100px;\">
                            $ItemName
                          </td>
                          <td style=\"min-width: 120px; text-align: center;\">
                            $Quantity &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style=\"min-width: 120px;\">
                            &#8373; $Price
                          </td>
                        </tr>
                      </table>";
        }

      }else{
        $items="";
      }

      $tab= "<div id=\"content$id\" class=\"col-lg-12 col-md-12\">

        <div class=\"invoice-box table-responsive\">
        <table cellpadding=\"0\" cellspacing=\"0\" class=\"table table-hover\">
            <tr class=\"top\">
                <td colspan=\"2\">
                    <table>
                        <tr>
                            <td class=\"title\">
                                <img src=\"images/Untitled-1.png\" style=\"width: 110px; margin-bottom: 0px;\">
                            </td>

                            <td>
                                Receipt No: $receipt_no<br>
                                Created: $print_date<br>
                                Due: &#8373; $grandtotal
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class=\"information\">
                <td colspan=\"2\">
                    <table>
                        <tr>
                            <td style=\"font-size:14px; font-family:times\">
                                <span style=\"font-size:18px; font-family:Lucida Fax; font-weight:bolder;\">
                                  Nico-Tee  Agro Chemical Shop
                                </span><br>
                                Loc: Goaso Manhyia - Main Station<br>
                                Brong Ahafo Region.<br>
                                Tel   : +233 244 413 386 / +233 246 218 819 / +233 506 654 566<br>
                                Email: mrnicks.1984@gmail.com / nicks.agro@gmail.com
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>

            <div style=\"float:right;\">
                         <tr class=\"CInformation\">
                <td colspan=\"2\">
                    <table >
                        <tr >

                                <span style=\"font-size:18px; font-family:Lucida Fax; font-weight:bolder;\">
                                  Customer's Information.
                                </span><br>

                                <tr>
                                  <td>Name:</td>
                                  <td>$Cname</td>
                                </tr>

                                 <tr>
                                  <td>Address:</td>
                                  <td>$Caddress</td>
                                </tr>

                                 <tr>
                                   <td>Mobile:</td>
                                  <td>$Cmobile</td>
                                </tr>






                        </tr>
                    </table>
                </td>
            </tr>
            </div>

            <tr class=\"heading\">

                <td colspan=\"2\">
                  <table>
                    <tr>
                      <td style=\"min-width: 100px;\">
                        Item Name
                      </td>
                      <td style=\"min-width: 120px; text-align: center;\">
                        Quantity &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      </td>
                      <td style=\"min-width: 120px;\">
                        Price
                      </td>
                    </tr>
                  </table>
                </td>

            </tr>

            <tr class=\"item\">
                  <td colspan=\"2\">
                    $items
                  </td>
            </tr>

            <tr class=\"total\">
                <td>Total Amount:</td>

                <td>
                    &#8373; $grandtotal
                </td>
            </tr>
            <tr>

            <tr class=\"total\">
                <td>
                  Sold By:
                </td>

                <td>
                   $SoldBY
                </td>
            </tr>
            <tr>
              <td><b style=\"font-weight:bolder;\">Signature:..............................................</</b></td>
              <td>
              <td></td>
            </tr>
        </table>
<span class=\"text-align=center h6\">Powered By Nsromapa</span><br>
<span class=\"text-align=center h6\">0559685442</span>

      <br /><br />
    </div>
    </div>

      <br><br>



        <button onclick=\"printDiv(content$id)\" class=\"preint_rcpt btn btn-primary pull-right\" id=\"cd$id\" >Print</button>
      <br><br>
    ";




  echo "$tab";




}else{


}
   ?>

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



   <?php include 'footer.php'; ?>


    <!--Link of Javascript-->
  <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
