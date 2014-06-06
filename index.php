<?php

if(file_exists('/pineapple/includes/welcome/')){include('/pineapple/includes/welcome/welcome.php'); exit(0);}

if(isset($_GET['noJS'])){echo "You need to have JavaScript enabled to use the webinterface. <a href='/'>Refresh</a>";die();}
?>
<html>


<head>
	<title>WiFi Pineapple - Management</title>
  <meta http-equiv="cache-control" content="max-age=0" />
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="expires" content="0" />
  <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
  <meta http-equiv="pragma" content="no-cache" />
  <link rel="stylesheet" type="text/css" href="includes/css/styles.php" />
  <script src="includes/js/jquery.min.js"></script>
  <script src="includes/js/functions.js" type="text/javascript" ></script>
  <noscript><meta http-equiv="refresh" content="0;url=index.php?noJS" /></noscript>
  <link rel="shortcut icon" href="/includes/img/favicon.ico" type="image/x-icon">
  <link rel="icon" href="/includes/img/favicon.ico" type="image/x-icon">
</head>

<body onload="init()">
	<div class="statusBar"><div class="statusBar_content">Loading Interface</div><div class="logout"><a href="/?logout"><img src="/includes/img/exit.png"></a></div></div>
  <div class='popup'>
    <a id='close' href='JAVASCRIPT: close_popup()'>[X]</a>
    <div class='popup_content'></div>
  </div>
  <div class="tiles"><div class="tiles_wrapper"><div class="tile_expanded"></div></div></div>
  
  <div class="hidden_bar">
  </div>
</body>


</html>