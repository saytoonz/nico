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



  $myTop=$_GET['NsromapaLSlesfrstdatefrony'];



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


        $selectname = mysql_query("SELECT * FROM users WHERE user_id='$myTop'");
          $getname = mysql_fetch_assoc($selectname);
          $fullname = $getname['fullname'];
            
  
 ?>




<!DOCTYPE html>
<html lang="en">
<body>
  <!--small Section div-->
  <section id="breadcrumb">
    <div class="container"><!--Section container-->
      <div class="row"><!--Section row-->
        <ol class="breadcrumb">
          <li class="active"><?php echo "$fullname"; ?> Sales for Today</li>
        </ol>
      </div><!--ens Section row-->
    </div><!--ends Section container-->
  </section>
  <!--ends small Section div-->


  <!--main nav-->
  <section id="main">
    <div class="container"><!--main container-->
      <div c0lass="row"><!--main row-->
        <div class="col-lg-3 col-md-3" ><!--main col1-->
          
        <!--Left panel for Add,Manage etc-->
        <div class="list-group ">
          <a href="home.php" class="list-group-item  main-color-bg"> Home</a>

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

          <a href=\"report.php\" class=\"list-group-item active\"><span class=\"glyphicon glyphicon-list-alt\"></span> Report</a>";
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
          <ul class="pager">
              <li class="previous"><a href="sale_report.php"><span class="glyphicon glyphicon-chevron-left"> Previous Page</span></a></li>
          </ul>
            <h3 class="panel-title">Sales for Today</h3>



          </div><!--panel heading-->

          <div class="panel-body" id="dash"><!--panel body-->
            
          <!--search div-->
        <div id="sells" class="row col-md-12 col-lg-12">

         
   <?php 

        if ($myTop=='alSalFrThStAnFrDntdatefrtdatnntanyodadateaprt') {
          
          $gradtotal="";
        $sale_total="";
        $systemdate = date("Y-m-d");

          $select_sale_all = mysql_query("SELECT * FROM sale WHERE dateSold = '$systemdate'");

        while ($list_all = mysql_fetch_assoc($select_sale_all )) {
          
          $gradtotal+=$list_all['grandtotal'];
          $sale_total = number_format($gradtotal, 2);

        }


            echo " 

            <div class=\"table-responsive\">
          <table class=\"table table-hover table-bordered \">
            
              <tr>
                <td style=\"font-weight:bolder;\">Total Amount for Today:</td>
                <td style=\"font-size: 25px; color: #ff0000; text-shadow: 1px 1px #000;\">GH&#8373; $sale_total</td>

                
              </tr>
              <tr class=\"danger\">
  
                <th>Staff Name</th>
                <th>Amount</th>
                <th>Date</th>
              </tr>
            </thead>

            ";
    
        $datesold="";
        $gradtotal="";
        $systemdate = date("Y-m-d");

    $select_sale_all = mysql_query("SELECT * FROM sale WHERE dateSold = '$systemdate' ORDER BY id DESC");

        while ($list_all = mysql_fetch_assoc($select_sale_all )) {
          
          $gradtotal+=$list_all['totalamount'];
          $sale_total = number_format($gradtotal, 2);

          $id_all = $list_all['id'];
          $itemname_all = $list_all['itemname'];
          $itemprice_all = $list_all['itemprice'];
          $itemqty_all = $list_all['itemqty'];
          $total_amount_all = $list_all['grandtotal'];
          $staffname_all = $list_all['staffname'];
          $qtyleft_all = $list_all['qtyleft'];
          $itemdate_all = $list_all['itemdate'];
          $datesold = $list_all['dateSold'];

          $selectname = mysql_query("SELECT * FROM users WHERE user_id='$staffname_all'");
          $getname = mysql_fetch_assoc($selectname);
          $stfname = $getname['fullname'];

      //////////////Html table for view all sales////

        echo "

            <tbody>

              <tr class=\"active\">
      
                <td> $stfname</td>
                <td> ".number_format($total_amount_all, 2)."</td>
                <td> $itemdate_all</td>
              </tr>
            </tbody>

            ";

            
          
        }
      

  
        echo "    
        </table>
        </div>

    ";
  

        } else {

        $gradtotal="";
        $sale_total="";
        $systemdate = date("Y-m-d");

          $select_sale_all = mysql_query("SELECT * FROM sale  WHERE staffname = '$myTop' AND dateSold = '$systemdate'");

        while ($list_all = mysql_fetch_assoc($select_sale_all )) {
          
          $gradtotal+=$list_all['grandtotal'];
          $sale_total = number_format($gradtotal, 2);
          $datesold = $list_all['dateSold'];
       


        }




          //if ($systemdate==$datesold) {
   
            echo " 

            <div class=\"table-responsive\">
          <table class=\"table table-hover table-bordered \">
            
              <tr>
                <td style=\"font-weight:bolder;\">Total Amount for $fullname:</td>
                <td style=\"font-size: 25px; color: #ff0000; text-shadow: 1px 1px #000;\">GH&#8373; $sale_total</td>

                
              </tr>
              <tr class=\"danger\">
  
                <th>Staff Name</th>
                <th>Amount</th>
                <th>Date</th>
              </tr>
            </thead>

            ";
    

        $gradtotal="";
        $systemdate = date("Y-m-d");

    $select_sale_all = mysql_query("SELECT * FROM sale  WHERE staffname = '$myTop' AND dateSold = '$systemdate' ORDER BY id DESC");

        while ($list_all = mysql_fetch_assoc($select_sale_all )) {
          
          $gradtotal+=$list_all['totalamount'];
          $sale_total = number_format($gradtotal, 2);

          $id_all = $list_all['id'];
          $itemname_all = $list_all['itemname'];
          $itemprice_all = $list_all['itemprice'];
          $itemqty_all = $list_all['itemqty'];
          $total_amount_all = $list_all['grandtotal'];
          $staffname_all = $list_all['staffname'];
          $qtyleft_all = $list_all['qtyleft'];
          $itemdate_all = $list_all['itemdate'];

      //////////////Html table for view all sales////

        echo "

            <tbody>

              <tr class=\"active\">
      
                <td> $staffname_all</td>
                <td> ".number_format($total_amount_all, 2)."</td>
                <td> $itemdate_all</td>
              </tr>
            </tbody>

            ";
          
        }
      

  
        echo "    
        </table>
        </div>

    ";

       
       
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

