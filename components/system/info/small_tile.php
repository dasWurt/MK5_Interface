<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<div style='text-align: right'><a href='#' class="refresh" onclick='get_firmware_updates()'> </a></div>
Firmware Version: <?=file_get_contents('/etc/pineapple/pineapple_version')?><br /><br />

Refresh this tile to check for firmware upgrades.<br /><br />

<div id="info_updates"></div>


<script type="text/javascript">
  
  function get_firmware_updates(){
    $('#info_updates').html('<br /><br /><center><img style="height: 2em; width: 2em;" src="/includes/img/throbber.gif"></center>');
    $.get('/components/system/info/functions.php?check_upgrade', function(data){
      if(data == -1){
        $("#info_updates").html("<font color='red'>Error connecting.</font>");
      }else if(data == 0){
        $("#info_updates").html("No upgrade found.");
      }else if(data == 1){
        $("#info_updates").html("No upgrade found. Re-Flash available.");
      }else{
       $("#info_updates").html("Update "+$.trim(data)+" found. Please open the large tile to upgrade.");
     }
    });
  }

</script>