<?php

include('/pineapple/includes/api/tile_functions.php');

if(isset($_GET['action'])){
  switch($_GET['action']){
   case "reset_mobile":
     echo reset_mobile();
   break;
  }
}


if(isset($_GET['ap_config'])){
  $SSID = $_POST['SSID'] = str_replace("'", '\'"\'"\'', $_POST['ssid']);
  $channel = $_POST['channel'];
  $key = str_replace("'", '\'"\'"\'', $_POST['password']);

  switch ($_POST['encryption']) {
    case 'WPA':
    $encryption = "psk+ccmp";
    break;
    case 'WPA2':
    $encryption = "psk2+ccmp";
    break;
    default:
    $encryption = "none";
    break;
  }
  
  if($encryption != "none" && strlen($key) < 8){
    echo "<center><font color='red'>Your password must be at least 8 characters long.</font></center>";
    exit();
  }

  exec("uci set wireless.@wifi-iface[0].mode='ap'");
  exec("uci set wireless.@wifi-iface[0].ssid='".$SSID."'");
  exec("uci set wireless.@wifi-iface[0].key='".$key."'");
  exec("uci set wireless.@wifi-iface[0].encryption='".$encryption."'");
  exec("uci set wireless.radio0.channel='".$channel."'");
  exec("uci commit wireless");

  echo "<center><font color='lime'>AP Configuration changed successfully.</font><br /><br />
  For these changes to take effect, you will need to restart the WiFi Pineapple's WiFI. 
  This will disconnect all clients connected wirelessly for a few seconds.<br /><br />
  <a href='#sys/network/restart_wireless/true/popup'>Restart Wireless</a></center><br /><br /><br />
  <small>Note: If you turned on encryption and set a password, <b>karma will not work properly</b>. While it does respond to probe requests, it requires a password to join.</small>";
}

if(isset($_GET['restart_wireless'])){
  echo "<center><font color='lime'>The WiFi Pineapple's wireless is currently restarting.</font><br /><br />
  If you are connected via the wireless connection, you will may need to re-connect.<br /><br />
  If you have set a password and are connected wirelessly, you will have to supply the wireless password in your device's network manager.
</center>";
exec("echo wifi | at now");
}

if(isset($_GET['mobile_config'])){

  foreach($_POST as $key => $value){
    if(trim($_POST[$key]) == ''){
      $_POST[$key] = " ";
    }
  }

  echo updateMobile($_POST['ifname'], 
    $_POST['ifname-custom'],
    $_POST['proto-custom'],
    $_POST['service-custom'],
    $_POST['device-custom'],
    $_POST['ppp_redial-custom'],
    $_POST['proto'], 
    $_POST['service'], 
    $_POST['device'], 
    $_POST['apn'], 
    $_POST['username'], 
    $_POST['password'], 
    $_POST['defaultroute'], 
    $_POST['ppp_redial'], 
    $_POST['peerdns'], 
    $_POST['dns'], 
    $_POST['keepalive'], 
    $_POST['pppd_options']);
}

if(isset($_GET['internet_ip'])){
  if(online()){
    echo  file_get_contents("http://wifipineapple.com/ip.php");
  }else{
    echo '<font color="red">Error Connecting</font>';
  }
}

if(isset($_GET['enable'])){
  $interface = $_GET['enable'];
  if($interface == "wlan0"){
    exec('wifi');
  }else{
    exec('ifconfig wlan1 up');
  }
}

if(isset($_GET['disable'])){
  $interface = $_GET['disable'];
  if($interface == "wlan0"){
    exec('killall hostapd && ifconfig wlan0 down');
  }else{
    exec('ifconfig wlan1 down');
  }
}

if(isset($_GET['update_route'])){

  $route = $_POST['route'];
  $iface = $_POST['iface'];
  exec("route del default");
  exec("route add default gw ".$route." ".$iface);
  exec("/etc/init.d/firewall restart");
  echo "<font color='lime'>Route changed successfully.</font>";
}

function updateMobile($ifname, 
  $ifname_custom,
  $proto_custom,
  $service_custom,
  $device_custom,
  $ppp_redial_custom,
  $proto, 
  $service, 
  $device, 
  $apn, 
  $username, 
  $password, 
  $defaultroute, 
  $ppp_redial, 
  $peerdns, 
  $dns, 
  $keepalive, 
  $pppd_options){

if($ifname == "custom") { $ifname=$ifname_custom; }
if($proto == "custom") { $proto=$proto_custom; }
if($service == "custom") { $service=$service_custom; }
if($device == "custom" ) { $device=$device_custom; }
if($ppp_redial == "custom" ) { $ppp_redial=$ppp_redial_custom; }


  exec("uci delete network.wan2");
  exec("uci set network.wan2=interface");
  exec("uci set network.wan2.ifname=\"$ifname\"");
  exec("uci set network.wan2.proto=\"$proto\"");
  exec("uci set network.wan2.service=\"$service\"");
  exec("uci set network.wan2.device=\"$device\"");
  exec("uci set network.wan2.apn=\"$apn\"");
  exec("uci set network.wan2.username=\"$username\"");
  exec("uci set network.wan2.password=\"$password\"");
  exec("uci set network.wan2.defaultroute=\"$defaultroute\"");
  exec("uci set network.wan2.ppp_redial=\"$ppp_redial\"");
  exec("uci set network.wan2.peerdns=\"$peerdns\"");
  exec("uci set network.wan2.dns=\"$dns\"");
  exec("uci set network.wan2.keepalive=\"$keepalive\"");
  exec("uci set network.wan2.pppd_options=\"$pppd_options\"");
  exec("uci commit network");
  return '<font color="lime" Success!</font> Updated Mobile WAN Configuration.';
  echo "Updated Mobile WAN Configuration.";
}

if(isset($_GET['mobile_redial'])){
  echo mobileRedial();
}

function reset_mobile(){
  exec("uci set network.wan2=' '");
  exec("uci set network.wan2.ifname=' '");
  exec("uci set network.wan2.proto=' '");
  exec("uci set network.wan2.service=' '");
  exec("uci set network.wan2.device=' '");
  exec("uci set network.wan2.apn=' '");
  exec("uci set network.wan2.username=' '");
  exec("uci set network.wan2.password=' '");
  exec("uci set network.wan2.defaultroute=' '");
  exec("uci set network.wan2.ppp_redial=' '");
  exec("uci set network.wan2.peerdns=' '");
  exec("uci set network.wan2.dns=' '");
  exec("uci set network.wan2.keepalive=' '");
  exec("uci set network.wan2.pppd_options=' '");
  exec("uci commit network");
return '<font color="lime">Mobile Broadband Configuration Reset</font>';
}

function mobileRedial(){
  exec("echo 1 > /tmp/mobileRedial");
  return '<font color="lime">Redialing.</font>';
}

if(isset($_GET['restart_dns'])){
  exec("/etc/init.d/dnsmasq restart");
  echo "<font color='lime'>DNS Restarted</font>";
}

if(isset($_GET['scan'])){

  $iface = (is_numeric($_GET['scan'])) ? "wlan".$_GET['scan'] : "wlan1";

  $station_list = array();
  exec("ifconfig $iface up");
  exec("iw $iface scan", $scan);
  $scan = preg_split("/^BSS /m", implode("\n", $scan));
  unset($scan[0]);

  foreach($scan as $ap){
    $ap = explode("\n", $ap);
    $address = substr($ap[0], 0, 17);
    $station_list[$address] = array();
    foreach ($ap as $line) {
      $line = trim($line);
      if(strpos($line, "SSID:") >= -1){
        $station_list[$address]['ESSID'] = substr($line, 6);
      }elseif(strpos($line, "DS Parameter set:") >= -1){
        $station_list[$address]['channel'] = substr($line, 26);
        if($station_list[$address]['channel'] == trim(exec("iw dev wlan0 info | grep channel | awk '{print \$2}'"))){
          $station_list[$address]['channel_collision'] = true;
        }
      }elseif(strpos($line, "signal:") >= -1){
        $station_list[$address]['signal'] = substr($line, 8);
        $quality = 2*(substr($line, 8, -4)+100);
        if($quality >= 100) $quality = 100;
        if($quality <= 0) $quality = 0;
        $station_list[$address]['quality'] = $quality."%";
      }elseif(strpos($line, "Privacy") >= -1){
        if(!is_array($station_list[$address]['security'])){
          $station_list[$address]['security'] = array();
        }
        $station_list[$address]['security']['WEP'] = true;
      }elseif(strpos($line, "RSN:") >= -1){
        unset($station_list[$address]['security']['WEP']);
        $security = "WPA2";
        $station_list[$address]['security'][$security] = array();
      }elseif(strpos($line, "WPA:") >= -1){
        unset($station_list[$address]['security']['WEP']);
        $security = "WPA";
        $station_list[$address]['security'][$security] = array();
      }elseif(strpos($line, "Pairwise ciphers") >= -1){
        if(strpos($line, "CCMP") !== false){
          $station_list[$address]['security'][$security]["ccmp"] = true;
        }
        if(strpos($line, "TKIP") !== false){
          $station_list[$address]['security'][$security]["tkip"] = true;
        }
      }
    }
  }
  echo json_encode($station_list);
}

if(isset($_GET['connect'])){

  set_time_limit(60*10);

  $iface = (is_numeric($_GET['iface'])) ? $_GET['iface'] : "1";

  $ap = json_decode($_GET['connect']);

  $ap->ESSID = base64_decode(rawurldecode($ap->ESSID));
  $ap->ESSID = str_replace("'", "'\"'\"'", $ap->ESSID);
  $ssid = $ap->ESSID;

  $channel = $ap->channel;

  if($ap->key != null){
    $ap->key = base64_decode(rawurldecode($ap->key));
    $ap->key = str_replace("'", "'\"'\"'", $ap->key);
  }

  exec("wifi detect >> /etc/config/wireless");
  exec("ifconfig wlan".$iface." down");

  $counter = 0;
  while(true){
    $entry=trim(exec("uci get wireless.@wifi-iface[".$counter."].network 2>&1"));
    if($entry == "uci: Entry not found") break;
    if($entry == "wan") exec("uci set wireless.@wifi-iface[".$counter."].network='lan'");
    $counter++;
  }
  
  exec("uci set wireless.@wifi-iface[".$iface."].network=wan");
  exec("uci set wireless.@wifi-iface[".$iface."].mode=sta");
  exec("uci set wireless.@wifi-iface[".$iface."].ssid='".$ssid."'");
  exec("uci set wireless.@wifi-device[".$iface."].channel=\"".$channel."\"");

  if($ap->security == null){
    exec("uci delete wireless.@wifi-iface[".$iface."].key");
    exec("uci delete wireless.@wifi-iface[".$iface."].encryption");

  }elseif($ap->security->WPA != null && $ap->security->WPA2 != null){
    $mode = "mixed-psk";
    $cipher = "";
    if($ap->security->WPA2->ccmp != null){
      $cipher .= "+ccmp";
    }
    if($ap->security->WPA2->tkip != null){
      $cipher .= "+tkip";
    }
    exec("uci set wireless.@wifi-iface[".$iface."].key='".$ap->key."'");
    exec("uci set wireless.@wifi-iface[".$iface."].encryption=".$mode.$cipher);
  }elseif($ap->security->WPA2 != null){
    $mode = "psk2";
    $cipher = "";
    if($ap->security->WPA2->ccmp != null){
      $cipher .= "+ccmp";
    }
    if($ap->security->WPA2->tkip != null){
      $cipher .= "+tkip";
    }
    exec("uci set wireless.@wifi-iface[".$iface."].key='".$ap->key."'");
    exec("uci set wireless.@wifi-iface[".$iface."].encryption=".$mode.$cipher);
  }elseif($ap->security->WPA != null) {
    $mode = "psk";
    $cipher = "";
    if($ap->security->WPA->ccmp != null){
      $cipher .= "+ccmp";
    }
    if($ap->security->WPA->tkip != null){
      $cipher .= "+tkip";
    }
    exec("uci set wireless.@wifi-iface[".$iface."].key='".$ap->key."'");
    exec("uci set wireless.@wifi-iface[".$iface."].encryption=".$mode.$cipher);
  }elseif($ap->security->WEP){
   exec("uci set wireless.@wifi-iface[".$iface."].key='".$ap->key."'");
   exec("uci set wireless.@wifi-iface[".$iface."].encryption=wep");
 }
 exec("uci commit wireless");
 exec("wifi");
 echo "done";
}



if(isset($_GET['get_connection'])){
  $iface = (is_numeric($_GET['get_connection'])) ? "wlan".$_GET['get_connection'] : "wlan1";
  if(exec("iwconfig $iface | grep -ic 'Not-Associated'") == 0){
    exec("ifconfig $iface && iwconfig $iface", $info);
    echo "<pre>";
    foreach($info as $line){
      echo $line."\n";
    }
    echo "</pre>";
  }else{
    echo "not_associated";
  }
}

if(isset($_GET['disconnect'])){
  $iface = (is_numeric($_GET['disconnect'])) ? $_GET['disconnect'] : "1";
  exec("uci delete wireless.@wifi-iface[$iface].key");
  exec("uci delete wireless.@wifi-iface[$iface].encryption");
  exec("uci set wireless.@wifi-iface[$iface].mode=sta");
  exec("uci set wireless.@wifi-iface[$iface].network=lan");
  exec("uci set wireless.@wifi-iface[$iface].ssid=' '");
  exec("uci commit wireless");
  exec("wifi");
  exec("ifconfig wlan"+$iface+" down");
}

function generate_mac(){
  $octet_array = array();
  for($i=0; $i < 5; $i++){
    $octet = dechex(rand(0, 255));
    if(strlen($octet) < 2) $octet = "0".$octet;
    array_push($octet_array, $octet);
  }
  return "00:".implode(":", $octet_array);
}

function set_mac($interface, $mac=null){
  if(!is_numeric($interface)) return;
  if($mac === null) $mac = generate_mac();
  exec("uci set wireless.@wifi-iface[".$interface."].macaddr=".$mac.";uci commit wireless;wifi");
  return $mac;
}

if(isset($_GET['change_mac'])){
  $interface = $_GET['change_mac'];
  if(isset($_GET['mac'])){
    echo set_mac($interface, $_GET['mac']);
  }else{
    echo set_mac($interface);
  }
}

if(isset($_GET['get_mac'])){
  if(!is_numeric($_GET['get_mac'])) return;
  echo exec("ifconfig wlan".$_GET['get_mac']." | grep HWaddr | awk '{print \$5}'");
}

if(isset($_GET['restore_mac'])){
  if(!is_numeric($_GET['restore_mac'])) return;
  echo set_mac($_GET['restore_mac'], "");
}

if(isset($_GET['reset_config'])){
  echo "<center>The Wireless Configuration has been reset.<br /><br />The WiFi Pineapple is now restarting it's wireless interfaces for all changes to take effect.</center>";
  exec("echo 'wifi detect > /etc/config/wireless && wifi' | at now");
}
