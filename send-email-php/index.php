<!DOCTYPE html>
<html>
<head>
    <title>phpmailer</title>
</head>
<body>
    <form action="send_email.php" method="post" enctype="multipart/form-data">
    <label>Name</label>
    <input name="name" type="text" required/><br><br>
    <label>Email Id</label> <br>
    <input type="text" name="email" required/>
    <label>Attachment</label> <br>
    <input type="file" name="file" required/><br>
    <input name="submit" type="submit" id="submit" class="submit" value="Submit" />
</form>
</body>
</html>