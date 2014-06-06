<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<div style='text-align: right'><a href='#' class="refresh" onclick='refresh_network()'> </a></div> 

Wlan0 <?= wlan0_status() == true ? '<font color="lime">Enabled</font>.&nbsp; | <a href="#sys/network/disable/wlan0/refresh_network">Disable</a>' : '<font color="red">Disabled</font>. | <a href="#sys/network/enable/wlan0/refresh_network">Enable</a>';  ?><br />
Wlan1 <?= wlan1_status() == true ? '<font color="lime">Enabled</font>.&nbsp; | <a href="#sys/network/disable/wlan1/refresh_network">Disable</a>' : '<font color="red">Disabled</font>. | <a href="#sys/network/enable/wlan1/refresh_network">Enable</a>';  ?><br /> <br />

<div id='internet_ip'>Internet IP: <a href='JAVASCRIPT: display_internet()'>Show</a></div><br />

LAN: <?=get_lan()?><br />
Wlan1: <?=get_wlan1()?><br />
Mobile: <?=get_mobile()?><br />


<script type="text/javascript">

function refresh_network(){
  refresh_small('network', 'sys');
}

function display_internet(){
  $('#internet_ip').html('Internet IP: Loading..');
  $.get('/components/system/network/functions.php?internet_ip', function(data){
    $('#internet_ip').html("Internet IP: "+data);
  });
}

</script>


<?php

function wlan0_status(){
  $state = exec("ifconfig wlan0 | grep UP | awk '{print $1}'");
  if($state == "UP"){
    return true;
  }
  return false;
}

function wlan1_status(){
  $state = exec("ifconfig wlan1 | grep UP | awk '{print $1}'");
  if($state == "UP"){
    return true;
  }
  return false;
}

function get_lan(){
  $ip = trim(exec("ifconfig br-lan | grep 'inet' | cut -d: -f2 | awk '{ print $1 }'"));
  if(empty($ip)){
    return 'N/A';
  }else{
    return $ip;
  } 
}

function get_wlan1(){
  $ip = trim(exec("ifconfig wlan1 | grep 'inet' | cut -d: -f2 | awk '{ print $1 }'"));
  if(empty($ip)){
    return 'N/A';
  }else{
    return $ip;
  } 
}

function get_mobile(){
  $ip = trim(exec("ifconfig 3g-wan2 | grep 'inet' | cut -d: -f2 | awk '{ print $1 }'"));
  if(empty($ip)){
    return 'N/A';
  }else{
    return $ip;
  } 
}
?>