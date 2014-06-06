<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php
echo "MK5 Karma ";
if (get_karma_status()) {
echo "<font color=\"lime\"><b>Enabled</b></font>.&nbsp; | <a href='#sys/karma/action/stop_karma/karma_reload_tile'><b>Stop</b></a><br />";
} else { echo "<font color=\"red\"><b>Disabled</b></font>. | <a href='#sys/karma/action/start_karma/karma_reload_tile'><b>Start</b></a><br />"; }

echo "Autostart ";
if (get_autostart_status()) {
echo "<font color=\"lime\"><b>Enabled</b></font>.&nbsp; | <a href='#sys/karma/action/stop_autostart/karma_reload_tile'><b>Disable</b></a><br />";
} else { echo "<font color=\"red\"><b>Disabled</b></font>. | <a href='#sys/karma/action/start_autostart/karma_reload_tile'><b>Enable</b></a><br />"; }



function get_karma_status(){
  if ( exec("hostapd_cli -p /var/run/hostapd-phy0 karma_get_state | tail -1") == "ENABLED" ){
    return true;
  }
  return false;
}

function get_autostart_status(){
  if(exec('ls /etc/rc.d/ | grep karma') == ''){
    return false;
  }else{
    return true;
  }
}


?>

<script type="text/javascript">

  var karma_log_refresh = 0;

  function karma_reload_tile(){
    refresh_small('karma', 'sys');
  }
</script>
