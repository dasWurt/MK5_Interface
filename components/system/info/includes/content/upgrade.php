<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>

<fieldset>
  <legend>Over the Air upgrade - <a href="JAVASCRIPT:check_upgrade()">Check for upgrade</a></legend>
  <div id="ota_div">Click the link above to check for available upgrades.</div>
</fieldset>

<br /><br />

<fieldset>
  <legend>Help</legend>
  <font color="red">Warning:</font><br /><br />
  Flashing a firmware upgrade will wipe all data on your pineapple. It will not wipe the SD card, but please make sure you have one inserted.<br /><br />
  Please also make sure that you have stopped all active services and infusions. To be sure, we recommend 
  to re-boot the WiFi Pineapple MKV before any upgrade to ensure extra proccesses have been halted properly.
  Additionally, you should only perform a flash on a stable power connection, the wall adapter is recommended. You should also only flash over ethernet.<br /><br />
  Finally, please give the flashing process some time. Interrupting it by pulling the power or closing the webinterface can result in a soft-brick.
  <!-- Do not flash the WiFi Pineapple MKV after midnight. It doesn't like that. -->
</fieldset>


<!--
<br /><br />
 <fieldset>
  <legend>Upgrading Manually</legend>
  <form action="/components/system/info/functions.php" method="POST" enctype="multipart/form-data" onsubmit="$(this).AJAXifyForm(popup); return false;">
    <table>
      <tr><td>Upgrade.bin: </td><td><input type="file" name="upgrade"></td></tr>
      <tr><td>MD5 Checksum: </td><td><input type="text" name="md5" placeholder="MD5"></td></tr>
      <tr><td><input type="submit" value="Perform Upgrade"></td></tr>
    </table>
  </form>
</fieldset> 
-->

<script type="text/javascript">

  function check_upgrade(){
    $("#ota_div").html("<div align='center'><img style='height: 2em; width: 2em;' src='/includes/img/throbber.gif'><br />Checking for upgrades...</div>");
    $.get("/components/system/info/functions.php?check_upgrade", function(data){
      if(data == -1){
        $("#ota_div").html("<font color='red'>Error connecting. Please check your WiFi Pineapple's internet connection.</font>");
      }else if(data == 0){
        $("#ota_div").html("No upgrade found.");
      }else if(data == 1){
        $("#ota_div").html("No update was found. Re-Flash the current version? <br /><a href='JAVASCRIPT: start_download()'>Re-Flash</a> or <a href='JAVASCRIPT: load_changelog()'>view changelog</a>.");
      }else{
       $("#ota_div").html("An update ("+$.trim(data)+") has been found. <br /><a href='JAVASCRIPT: start_download()'>Flash</a> or <a href='JAVASCRIPT: load_changelog()'>view changelog</a>.");
     }
   });
  }

  function start_download(){
    $("#ota_div").html("Flash in progress.");
    $.get("/components/system/info/functions.php?download_upgrade", function(data){
      popup(data);
    });
  }

  function load_changelog(){
    popup("<div align='center'><img style='height: 2em; width: 2em;' src='/includes/img/throbber.gif'><br />Loading Changelog</div>");
    $.get('/components/system/info/functions.php?load_changelog', function(data){
      if(data != -1){
        popup(data);
      }else{
        popup("<center><font color='red'>Error connecting.</font></center>");
      }
    });
  }

</script>