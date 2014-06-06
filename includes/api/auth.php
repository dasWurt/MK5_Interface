<?php

check_login();

function check_login(){
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if(isset($_GET['logout'])){
    unset($_SESSION['logged_in']);
    exec("rm /tmp/sess_*");
    header("Location: /");
  }
  if(!isset($_SESSION['logged_in'])){
    include('/pineapple/includes/api/login.php');
    exit();
  }
}

?>