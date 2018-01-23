

<?php 
		  /////////When click Change/////////

      if (isset($_POST['change'])) {
        $query = mysql_query("SELECT * FROM users WHERE user_id='$login_user'");

        $fetch=mysql_fetch_assoc($query);

        $user_id=$fetch['user_id'];
        $password=$fetch['password'];
        $name=$fetch['fullname'];
        
        $old_password=md5($_POST['old_password']);
        $new_password=$_POST['new_password'];
        $new_password2=$_POST['new_password2'];

          if ( $old_password == $password) {

            if ($new_password !="" AND $new_password2!="") {
              
            
            if ($new_password == $new_password2) {
              
              $new_password = md5($new_password);
              
              $update=("UPDATE users SET password='$new_password' WHERE user_id='$login_user' ");

            $queryupdaate=mysql_query($update,$cn);

            if ($queryupdaate) {


        ////////////When database password is equal to entered password//////////////

          echo "

          <script>
          alert (\" Password Has Been Successfully Changed\");
          </script>

          ";
                    
        } else {
                                        ?>
              <script>
              alert("Error In Changing Password, Try Again!!!")
              </script>
            <?php
            }
                  

            } else {
              
              ?>
                <script>
                  alert("New Password Does Not Match!!!")
                </script>
              <?php
            }
            

          
            }else{
              ?>
              <script>
                alert("Enter New Password!!!")
              </script>
            <?php
            }

          } else {
            
            ?>
              <script>
                alert("Old Password Does Not Match!!!")
              </script>
            <?php
          }
  
      }///////Ends Change password////
 

      echo "

 <!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"utf-8\">
  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">

  <title>Nico Tee Agro Chemicals</title>

  <link rel=\"stylesheet\" type=\"text/css\" href=\"css/bootstrap.min.css\">
  <link rel=\"stylesheet\" type=\"text/css\" href=\"css/sale.css\">

  <link rel=\"stylesheet\" type=\"text/css\" href=\"css/home.css\">
  <link rel=\"icon\" href=\"images/logo2.png\" sizes=\"16x16\" type=\"image/png\">


  <style type=\"text/css\">
      
      #addStaff input[type=\"number\"]{
        -moz-appearance:textfield;
      }
  </style>
 <body onload=\"getTime();\"><!--onload body for time to count-->";?>



    <div class="menu_bar">

      <!--For File-->
      <div class="dropdown create" id="file">
        <span class="dropdown-toggle" data-toggle="dropdown">
          <span style="margin-left: 5px; cursor: pointer;" class="File">File</span>
        </span>
          <ul class="dropdown-menu" aria-labelledby="file">
            <li id="menu_list"><a data-toggle="modal" data-target="#addStockheda">New Stock </a></li>
            <hr style="margin-top: 2px;margin-bottom: 2px; border-top: 1px solid #646464;">

            <li id="menu_list" onclick="window.open(document.location.href)"><a>Open in New Tab</a></li>
            <li id="menu_list" onclick="window.close()"><a>Close this Tab</a></li>
            <hr style="margin-top: 2px;margin-bottom: 2px; border-top: 1px solid #646464;">

            <li id="menu_list" onclick="window.open(document.location.href,'','_blank','directories=yes,fullscreen=yes,location=yes,menubar=yes,resizable=yes,status=yes,titlebar=yes,scrollbars=yes')"><a>Open in New Window</a></li>
            <li id="menu_list" onclick="window.close()"><a>Close this Window</a></li>
            <hr style="margin-top: 2px;margin-bottom: 2px; border-top: 1px solid #646464;">

            <li id="menu_list" onclick="location.replace('logout.php');"><a>RelogIn</a></li>
            <li id="menu_list" onclick="location.replace('logout.php');"><a>Log Out</a></li>
        
          </ul>

      </div>
      <!--Ends File-->




      <!--For  Edit-->
      <div class="dropdown create" id="edit">
        <span class="dropdown-toggle" data-toggle="dropdown">
          <span style="margin-left: 5px;cursor: pointer;" class="Edit">Edit</span>
        </span>
          <ul class="dropdown-menu" aria-labelledby="edit">
            
            <li id="menu_list" style="cursor: pointer;"><a data-toggle="modal" data-target="#changePassword">Change Password</a></li>
            <hr style="margin-top: 2px;margin-bottom: 2px; border-top: 1px solid #646464;">
            <li id="menu_list"><a href="backup.php" target="_blanks">Upload to Cloud (Backup)</a></li>
           <!--  <li id="menu_list"><a>Edit</a></li>
            <li id="menu_list"><a>Edit</a></li> -->
          </ul>

      </div>
      <!--Ends Edit-->



      <!--For  View-->
      <div class="dropdown create" id="view">
        <span class="dropdown-toggle" data-toggle="dropdown">
           <span  style="margin-left: 5px;cursor: pointer;" class="View">View</span>
        </span>
          <ul class="dropdown-menu" aria-labelledby="view">
            <li id="menu_list" onclick="location.reload();"><a>Reload</a></li>
            <li id="menu_list" onclick="location.reload();"><a>Refresh Page</a></li>
            
          </ul>

      </div>
      <!--Ends View-->


        <!--For  Help-->
      <div class="dropdown create" id="help">
        <span class="dropdown-toggle" data-toggle="dropdown">
             <span  style="margin-left: 5px;cursor: pointer;" class="Help">Help</span>
        </span>
          <ul class="dropdown-menu" aria-labelledby="help">
            <li id="menu_list"><a onclick="alert('Please there isn\'t any update yet\nContanct Nsromapa for personal update!')">Check Updates</a></li>
            <li id="menu_list"><a href="http://www.nsromapa.ga/includes/terms.php?termsandconditionforallourproducts=dATaBaseDevwlopmentAndDataBaseDevlopmetOnlyHere" target="_blank">Terms and Conditions</a></li>
            <hr style="margin-top: 2px;margin-bottom: 2px; border-top: 1px solid #646464;">

            <li id="menu_list"><a href="http://www.nsromapa.ga/includes/contact_us.php?ContacustHome=Emsdsdbsdbsnbdndfddbxvcaisdsland&hhhsChsd//8765433hhsdatuslive" target="_blank">Contact Us</a></li>

          </ul>

      </div>

      <!--Ends Help-->



        <!--For  About-->
      <div class="dropdown create" id="history">
        <span class="dropdown-toggle" data-toggle="dropdown">
            <span  style="margin-left: 5px;cursor: pointer;" class="History">About</span> 
        </span>
          <ul class="dropdown-menu" aria-labelledby="history">
            <li id="menu_list"><a href="http://www.nsromapa.ga/includes/projects.php?NsoNsroMapaProjectsforbothproducs=Managementonlyforall" target="_blank">Our Sales Management</a></li>
            <li id="menu_list"><a href="http://www.nsromapa.ga/includes/projects.php?NsoNsroMapaProjectsforbothproducs=Managementonlyforall" target="_blank" target="_blank">Our Shop Management</a></li>
            <li id="menu_list"><a href="http://www.nsromapa.ga/includes/projects.php?NsoNsroMapaProjectsforbothproducs=Managementonlyforall" target="_blank" target="_blank">Our School Management</a></li>
            <li id="menu_list"><a href="http://www.nsromapa.ga/includes/projects.php?NsoNsroMapaProjectsforbothproducs=Managementonlyforall" target="_blank" target="_blank">Our Students Portal</a></li>
            
            <hr style="margin-top: 2px;margin-bottom: 2px; border-top: 1px solid #646464;">
            <li id="menu_list"><a href="http://www.nsromapa.ga" target="_blank">Our Website</a></li>
          </ul>

      </div>
      <!--Ends About-->
      
    </div>




<?php

  echo "
  <!--For Nav Bar-->
  <div class=\"row\"><!--Nav Bar row-->
    <div class=\"col-lg-12 col-md-12\"><!--Nav Bar columns-->
    <nav class=\"navbar navbar-default\">
      <!--nav container-->
      <div class=\"container\">
        <div class=\"navbar-header\"><!--Navbar header-->
      <button type=\"button\" class=\"navbar-toggle\" data-target=\".navbar-collapse\" data-toggle=\"collapse\"> <!--button when collapse-->

          <!--Arrows to click-->
          <span class=\"sr-only\">Toggle Nav</span>
          <span class=\"icon-bar\"></span>
          <span class=\"icon-bar\"></span>
          <span class=\"icon-bar\"></span>
          <!--Ends Arrows to click-->
      </button><!--button coll.ends-->
          
        </div><!--Ends Navbar header-->

        <div id=\"navbar\" class=\"collapse navbar-collapse\"><!-- navbar-->

          <!--Listing your links-->
          <ul class=\"nav navbar-nav\">
            <li><a href=\"home.php\"> Dashboard</a></li>
            <li><a href=\"sale.php\"> Sale</a></li>
            
            <li><a href=\"available_stock.php\"> Available Stock</a></li>
          </ul><!--Ends Listing your links-->

          <ul class=\"nav navbar-nav navbar-right\">";///// your links at right/////

         
            $select = mysql_query("SELECT * FROM users WHERE user_id='$login_user'");
            $myFetch = mysql_fetch_assoc($select);
            
            $name = $myFetch['fullname'];

            echo "


            <li><a href=\"home.php?$name\">Welcome,$name</a></li>
            <li>
            <div class=\"dropdown create\"><!--dropdn at right-->
          <span class=\"dropdown-toggle\" data-toggle=\"dropdown\" id=\"dropdownmenu1\"><!--btn for drpdn-->
            <span class=\"glyphicon glyphicon-user\"> </span>
            <span  class=\"caret\" ></span>
          </span><!--btn for drpdn-->

          
          <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownmenu1\" id=\"small\">
            <li><a data-toggle=\"modal\" data-target=\"#changePassword\"><span class=\"glyphicon glyphicon-lock\"> Change Password</a></li>
            
            <li><a href=\"index.php\"><span class=\"glyphicon glyphicon-off\"> Logout</a></li>
            

          </ul>
          

        </div><!--ends dropdn at right-->


            </li>

          
            
          </ul><!--Ends Listing your links at right-->
          
        </div><!--ends collapse-->

      </div><!-- Ends nav container-->
    </nav><!-- Nav Tag-->

  </div><!--Ends Nav Bar columns-->
  </div><!--Ends Nav Bar row-->
  <!--Ends Nav Bar-->
  


  <!--header-->
  <div id=\"header\">
    <div class=\"container\"><!--header container-->
      <div class=\"row\"><!--header row-->
        <div class=\"col-lg-8 col-md-8 col-sm-8 col-xs-12\"><!--header col1-->
          
        <h2><small>Nico Tee Agro Chemicals</small> </h2>

        </div><!--ends header col1-->

        <div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-12\"><!--header col2-->
          
        <!--System Date and time-->

        <div id=\"Mydate\"><!--Date div-->
      <center>
          <div id=\"date\">
         
            System Date: ";
          
          $dated =  date("jS F, Y"); echo "$dated &ndash;"; 

          echo " 
           <span id=\"clock\"></span>
         
         </div>
    </center>
  </div>

  <div id=\"time\">";
    
    
  ?>
  <script>
    function getTime() {
      
      var now = new Date();
      var h = now.getHours();
      var m = now.getMinutes();
      var s = now.getSeconds();

      m = checkTime(m);
      s = checkTime(s);

      document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
      setTimeout("getTime()", 1000);
    }

    function checkTime(time) {
      
      if (time<=0) {

        time="0", + time;
      }
      return time;
    }
  </script>


  <?php

  		echo "  
    </div><!--Ends SYstem Date and time-->


        </div><!--ends header col2-->
      </div><!--endsheader row-->
    </div><!--ends header container-->
  </div><!--ends header-->

   <!--Change Password-->
	<!--modal div-->
	<div class=\"modal fade \"  id=\"changePassword\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"\">
		<!--modal dialog-->
		<div class=\"modal-dialog modal-sm\" role=\"document\">
			<div class=\"modal-content\">

				<form action=\"\" method=\"post\">
				<div class=\"modal-header\">
					 
				<button type=\"button\" id=\"\" class=\"close\" data-dismiss=\"modal\" aria-label=\"close\"><span aria-hidden=\"true\">&times;</span> </button>
				<h3 class=\"modal-title\" id=\"\">Change Password</h3>
				</div>
				<div class=\"modal-body\">
					
					<!-- Old Password-->
      			<div class=\"form-group\">
      				<label for=\"oldpass\">Old Password</label>
      				<input type=\"text\" name=\"old_password\" id=\"oldpassword\" class=\"form-control\" placeholder=\"Old assword\">
      			</div>
      			<!-- ends Old Password-->

      			<!-- New Password-->
      			<div class=\"form-group\">
      				<label for=\"new_password\">New Password</label>
      				<input type=\"password\" name=\"new_password\" id=\"new_password\" class=\"form-control\" placeholder=\"New Password\">
      			</div>
      			<!-- ends New Password-->

      			<!-- Repeat Password-->
      			<div class=\"form-group\">
      				<label for=\"new_password2\">Repeat Password</label>
      				<input type=\"password\" name=\"new_password2\" id=\"new_password2\" class=\"form-control\" placeholder=\"Repeat Password\">
      			</div>
      			<!-- ends Repeat Password-->

      			
				</div>
				<div class=\"modal-footer\">
					<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
					<input type=\"submit\" name=\"change\" class=\"btn btn-primary\" value=\"CHANGE\">
				</div>

				</form><!--Form ends-->
			</div>
		</div><!--modal dialog-->
		
	</div><!--ends modal div-->
	

 </body>
 </html>
 		";////////////////////Ends header echo/////////////
 ?>

