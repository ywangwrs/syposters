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
<html>
  <head>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <META HTTP-EQUIV='CACHE-CONTROL' CONTENT='NO-CACHE'>
    <META HTTP-EQUIV='Pragma' CONTENT='no-cache'>
    <META HTTP-EQUIV='Expires' CONTENT='-1'>
    <title>Login</title>
    <link rel='stylesheet' type='text/css' href='/ottawa/styles/axedastyle.css'>
    <link href='/ottawa/styles/axeda.css' rel='stylesheet'>
    <link href='/ottawa/styles/desktop.css' rel='stylesheet' type='text/css'>
    <!--[if gt IE 8]>
    <link href='/ottawa/styles/tablet.css' rel='stylesheet' type='text/css' media='only screen and (min-width:800px) and (max-width:1024px)'>
    <link href='/ottawa/styles/phone.css' rel='stylesheet' type='text/css' media='only screen and (max-width:800px)'>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src='http://html5shiv.googlecode.com/svn/trunk/html5-rev31.js'></script>
    <link href='/ottawa/styles/legacy.css' rel='stylesheet'>
    <![endif]-->
    <link href='/ottawa/styles/client.css' rel='stylesheet'>
    <script src='/ottawa/styles/jquery-1.11.0.min.js'></script>
  </head>
<body>
  <form name='input' action='{$_SERVER['PHP_SELF']}' method='post'>
     <div id='LoginContainer'>
	<div id='LoginArea'>
	    <div style='padding-top:20px'>
                <div style='float:middle; line-height:36px'><font size=+2>Shen Yun Posters Database</font></div>
            </div>
            <div style='clear:both;position:relative;margin-top:20px;'>
                <input id='username' class='FormField' type='text' name='username' size='20' maxlength='50' on>
                <div id='LoginUsernameImg'><img src='/ottawa/styles/Icon_FieldUsername.png' width='43' height='36'></div>
            </div>
            <div style='clear:both;position:relative;margin-top:15px;'>
                <input id='password' class='FormField' type='password' name='password' size='20'>
                <div id='LoginPasswordImg'><img src='/ottawa/styles/Icon_FieldPassword.png' width='43' height='36'></div>
            </div>
            <div id='LoginBtnArea'>
        	<div style='float:right'><input name='sub' type='submit' value='LOG IN' class='LightButton'></div>
            </div>
	</div>
     </div>
  </form>
  <script type='text/javascript' src='common.js'></script>
</body>
</html>";
?>
