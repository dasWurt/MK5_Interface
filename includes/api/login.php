<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$file = explode("\n", file_get_contents('/etc/shadow'));
$string = explode(':', $file[0]);
$string =  explode('$', $string[1]);
$salt =  '$1$'.$string[2].'$';
$password = $string[3];



$submitted_pass =  crypt($_POST["password"], $salt);
$actual_pass = $salt.$password;


if(isset($_POST['login'])){
  if($submitted_pass == $actual_pass && $_POST['username'] == "root"){

    $_SESSION['logged_in'] = true;
    header('Location: /');

  }else{

    $message = "<font color='red'>Invalid username / password</font>";

  }
}

?>

<html>

<head>
        <title>WiFi Pineapple - Login</title>
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
        <link rel="stylesheet" type="text/css" href="includes/css/styles.php" />
        <script src="includes/js/jquery.min.js"></script>
        <noscript><meta http-equiv="refresh" content="0;url=index.php?noJS" /></noscript>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="background-color:black; color: white;">
  <center>
<div style="background-color: black; position: absolute; margin: auto; top: 50%; left: 50%; width: 256px; height: 356; margin-left: -128px; margin-top: -178px;">
    <img src="/includes/img/mk5_logo.gif"><br /><br />
<?=$message?>
    <form action="" method="POST">
      <table>
        <tr><td>Username:</td><td><input type="text" name="username" value="root"></td></tr>
        <tr><td>Password:</td><td><input type="password" name="password"></td></tr>
      </table>
      <input type="submit" name="login" value="Log In">
    </form>
</div>
  </center>

</body>



</html>
<?php exit(); ?>