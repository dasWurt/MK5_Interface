<?php

//Check if logged in
include_once('/pineapple/includes/api/auth.php');

//Action handler
if (isset($_GET['action'])) {
  switch ($_GET['action']) {
    case 'get_status_bar': 
    	get_status_bar();
    	break;
  }
}

function get_status_bar(){
	echo exec('uptime');
}

?>
