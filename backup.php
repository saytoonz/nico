<?php 
  include_once 'connect_db.php';
  include_once 'session.php';
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


function __backup_mysql_database($params)
{
    $mtables = array(); $contents = "-- Database: `".$params['db_to_backup']."` --\n";
    
    $mysqli = new mysqli($params['db_host'], $params['db_uname'], $params['db_password'], $params['db_to_backup']);
    if ($mysqli->connect_error) {
        die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
    }
    
    $results = $mysqli->query("SHOW TABLES");
    
    while($row = $results->fetch_array()){
        if (!in_array($row[0], $params['db_exclude_tables'])){
            $mtables[] = $row[0];
        }
    }

    foreach($mtables as $table){
        $contents .= "-- Table `".$table."` --\n";
        
        $results = $mysqli->query("SHOW CREATE TABLE ".$table);
        while($row = $results->fetch_array()){
            $contents .= $row[1].";\n\n";
        }

        $results = $mysqli->query("SELECT * FROM ".$table);
        $row_count = $results->num_rows;
        $fields = $results->fetch_fields();
        $fields_count = count($fields);
        
        $insert_head = "INSERT INTO `".$table."` (";
        for($i=0; $i < $fields_count; $i++){
            $insert_head  .= "`".$fields[$i]->name."`";
                if($i < $fields_count-1){
                        $insert_head  .= ', ';
                    }
        }
        $insert_head .=  ")";
        $insert_head .= " VALUES\n";        
                
        if($row_count>0){
            $r = 0;
            while($row = $results->fetch_array()){
                if(($r % 400)  == 0){
                    $contents .= $insert_head;
                }
                $contents .= "(";
                for($i=0; $i < $fields_count; $i++){
                    $row_content =  str_replace("\n","\\n",$mysqli->real_escape_string($row[$i]));
                    
                    switch($fields[$i]->type){
                        case 8: case 3:
                            $contents .=  $row_content;
                            break;
                        default:
                            $contents .= "'". $row_content ."'";
                    }
                    if($i < $fields_count-1){
                            $contents  .= ', ';
                        }
                }
                if(($r+1) == $row_count || ($r % 400) == 399){
                    $contents .= ");\n\n";
                }else{
                    $contents .= "),\n";
                }
                $r++;
            }
        }
    }
    
    if (!is_dir ( $params['db_backup_path'] )) {
            mkdir ( $params['db_backup_path'], 0777, true );
     }
    
    $backup_file_name = "bkups/NicoTee.sql";
         
    $fp = fopen($backup_file_name ,'w+');
    if (($result = fwrite($fp, $contents))) {
        echo "<center><span style=\"font-family: Lucida Fax; font-size: 35px; width: 100%;\">Database Compiled Successfully</span></center><br><br>
        <img src=\"images/PDSF.gif\" width=\"100%\">
        ";
    }
    fclose($fp);
}




$para = array(
    'db_host'=> 'localhost',  //mysql host
    'db_uname' => 'root',  //user
    'db_password' => '', //pass
    'db_to_backup' => 'shopnico', //database name
    'db_backup_path' => '/home/my_wordpress/', //where to backup
    'db_exclude_tables' => array('wp_comments','wp_w3tc_cdn_queue') //tables to exclude
);
__backup_mysql_database($para);








        $date=date("jS F, Y");
        $seconds=date("s");
$QQ = mysql_query("SELECT * FROM onlineUPdate WHERE id='1'");
    if (mysql_num_rows($QQ)!==0) {
    $fet=mysql_fetch_assoc($QQ);
    $dated=$fet['dated'];
        if ($date!=$dated) {
            mysql_query("UPDATE onlineUPdate SET seconds='$seconds' WHERE id='1'");
        }
    }else {
        mysql_query("INSERT INTO onlineUPdate(seconds)VALUES($seconds')");
    }






$QQ = mysql_query("SELECT * FROM onlineUPdate WHERE id='1'");
    $fet=mysql_fetch_assoc($QQ);
    $id=$fet['id'];
    $dated=$fet['dated'];
    $sec=$fet['seconds'];
    $newSec=$sec+15;
    if ($date!=$dated) {
        require_once "send-email-php/phpmailer/phpmailer.php";
                $mail = new PHPMailer;

                $mail->isSMTP();                            // Set mailer to use SMTP
                $mail->Host = 'mail.smtp2go.com';             // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                     // Enable SMTP authentication
                $mail->Username = 'Nsromap';          // SMTP username
                $mail->Password = '@@05Nsro'; // SMTP password
                $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 2525;                          // TCP port to connect to

                $mail->setFrom('RASSAY31@gmail.com', 'Saysay');
                $mail->addReplyTo('RASSAY31@gmail.com', 'SayRolex');
                $mail->addAddress('nsromapa05@gmail.com');   // Add a recipient

                $mail->isHTML(true);  // Set email format to HTML

                $bodyContent = '<h1>Nico Tee Agro Chemicals</h1>';
                $bodyContent .= '<p>Sql back up on <b>'.date("js F, Y").'</b></p>';

                $mail->Subject = 'Email from Localhost by NicoTee';
                $mail->Body    = $bodyContent;
                $mail->AddAttachment("bkups/NicoTee.sql");

                if(!$mail->send()) {
                    echo"<center><span style=\"font-family: Lucida Fax; font-size: 35px; width: 100%; color: #ff000e;\">
                        Backup Unsuccessful...\nPlease check Your Internet Connection and retry..<br>If backup keeps failing, Contact Nsromapa!<br><button onclick=\"window.close();\">OK</button></span></center>";
                   
                } else {

                     echo"<center><span style=\"font-family: Lucida Fax; font-size: 35px; width: 100%; \">
                             Backup nsuccessful...<button onclick=\"window.close();\">OK</button></span></center>";
                       mysql_query("UPDATE onlineUPdate SET dated='$date',seconds='$seconds' WHERE id='1'");
                }
                       
    } else {
        ?>
      <script type="text/javascript">
          alert("Backup for Today is already done...");
         window.close();
       </script>
    <?php
    }
    
?>
