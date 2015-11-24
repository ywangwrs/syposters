<?php
session_start();

// clean up variables
$username = $password = '';

if(isset($_POST['sub'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  try {
    $m=new MongoClient("mongodb://${username}:${password}@localhost/dbottawa");
    $_SESSION['login'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    header("LOCATION:locations.php");
    die();
  }
  catch(Exception $e) {
    echo "User '$username' doesn't exist or password is incorrect.";
  }
}

echo "<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
   <head>
     <meta http-equiv='content-type' content='text/html;charset=utf-8' />
     <title>Login</title>
     <style type='text.css'>
       @import common.css;
     </style>
   </head>
<body>
  <form name='input' action='{$_SERVER['PHP_SELF']}' method='post'>
    User Name:<br> 
    <label for='username'></label><input type='text' value='$username' id='username' name='username' /><br>
    Password:<br>
    <label for='password'></label><input type='password' value='$password' id='password' name='password' /><br>
    <input type='submit' value='Login' name='sub' />
  </form>
  <script type='text/javascript' src='common.js'></script>
</body>
</html>";

