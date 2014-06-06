<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>

<?php
if(isset($_GET['check_upgrade'])){
  if(online()){
    $current_version = trim(file_get_contents("/etc/pineapple/pineapple_version"));
    $online_data = explode("|", file_get_contents("http://wifipineapple.com/?downloads&current_version"));
    $online_version = trim($online_data[0]);
    $online_md5 = trim($online_data[1]);
    if(version_compare($online_version, $current_version, ">")){
      echo $online_version;
    }elseif(version_compare($online_version, $current_version, "==") && $current_version != "1.0.0"){
      echo "1";
    }else{
      echo "0";
    }
  }else{
    echo "-1";
  }
}

if(isset($_GET['load_changelog'])){
  if(online()){
    $current_changelog = file_get_contents("http://wifipineapple.com/?downloads&current_changelog");
    echo $current_changelog;
  }else{
    echo "-1";
  }
}

if(isset($_GET['download_upgrade'])){
  $online_data = explode("|", file_get_contents("http://wifipineapple.com/?downloads&current_version"));
  $size = $online_data[2];
  $md5 = $online_data[1];

  echo "<center>";
  echo "Downloading Firmware";
  echo "<div id='firmware_percent'></div>";
  echo "<script type='text/javascript'>
  var download_interval = setInterval(function(){
    $.ajaxSetup({async:false});
    $.get('/components/system/info/functions.php?download_status&size=".$size."&md5=".$md5."', function(data){
      $('#firmware_percent').html(data);
    });
    $.ajaxSetup({async:true});
  }, 500);</script>";
echo "</center>";

exec("echo 'bash /pineapple/components/system/info/includes/files/downloader' | at now");
}

if(isset($_GET['download_status']) && isset($_GET['size']) && isset($_GET['md5'])){

  $current = @round(filesize('/tmp/upgrade.bin')/1024, 0);
  $size = $_GET['size']/1024;
  $percentage = round(($current/$size)*100, 1);
  $html .= "<br /><br />[ ";
  for($i = 0; $i <= $percentage/2; $i++){
    if($i != 0) $html .= "|";
  }
  for($i = 0; $i <= (100-$percentage)/2; $i++){
    $html .= "&nbsp;";
  }
  $html .= "]<br />";
  $html .= "$percentage %";

  if(!file_exists('/tmp/downloading_upgrade')){
    echo "<script type='text/javascript'>clearInterval(download_interval);";
    if(md5_file('/tmp/upgrade.bin') == $_GET['md5']){
      echo "popup('<center>MD5 Matches. Performing upgrade. <br /><br /><img style=\"height: 5em; width: 5em;\" src=\"/includes/img/throbber.gif\"><br /><br />Please wait. This can take a while.</center>');";
      echo "
        setInterval(function(){
          $.get('/components/system/info/functions.php?install_status', function(data){
            if(data.trim() == 'complete'){
              window.location = '/';
            }
          });
        }, 500);
      ";
      exec('echo "bash /pineapple/components/system/info/includes/files/installer" | at now');
    }else{
      echo "popup('<center><font color=\"red\">MD5 missmatch. Please try again.</font></center>');";
    }
    echo "</script>";
  }
  echo $html;
}

if(isset($_GET['install_status'])){
  if(!file_exists('/tmp/installing_upgrade')){
    echo "complete";
    exit();
  }else{
    echo "incomplete";
  }
}

?>