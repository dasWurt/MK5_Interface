<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php

if(isset($_GET['kill']) && is_numeric($_GET['kill'])){
  exec("kill ".$_GET['kill']);
}

if(isset($_GET['format_sd'])){

  exec("echo '/pineapple/components/system/resources/includes/files/format_sd' | at now");
  echo "<center>The SD card is being formatted.<br />Please wait.</center><br /><br />";
  echo "<div id='format_status'><center><img src='/includes/img/throbber.gif'></center></div>";
  echo "<script type='text/javascript'>

  var interval = self.setInterval(function(){
    $.get('/components/system/resources/functions.php?format_status', function(data){
      if(data == 'completed'){
        $('#format_status').html('<center><font color=\"lime\">Format completed.<br />You can now close this window.<br /><br /><small>In case you have any issues, please re-boot the pineapple.</small></font></center>');
        self.clearInterval(interval);
      }
    });
  }, 500);


  </script>";

}

if(isset($_GET['update_fstab']) && isset($_POST['fstab'])){
  $handle = fopen('/etc/config/fstab', 'w');
  fwrite($handle, $_POST['fstab']);
  fclose($handle);
  echo "Fstab updated successfully";
}

if(isset($_GET['format_status'])){
  if(!file_exists("/tmp/sd_format.progress")){
      echo "completed";
  }
}

?>
