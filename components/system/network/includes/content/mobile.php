<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php
$ifname = exec("uci show network.wan2.ifname | sed 's/^.*=//'");
$proto = exec("uci show network.wan2.proto | sed 's/^.*=//'");
$service = exec("uci show network.wan2.service | sed 's/^.*=//'");
$device = exec("uci show network.wan2.device | sed 's/^.*=//'");
$apn = exec("uci show network.wan2.apn | sed 's/^.*=//'");
$username = exec("uci show network.wan2.username | sed 's/^.*=//'");
$password = exec("uci show network.wan2.password | sed 's/^.*=//'");
$defaultroute = exec("uci show network.wan2.defaultroute | sed 's/^.*=//'");
$ppp_redial = exec("uci show network.wan2.ppp_redial | sed 's/^.*=//'");
$peerdns = exec("uci show network.wan2.peerdns | sed 's/^.*=//'");
$dns = exec("uci show network.wan2.dns | sed 's/^.*=//'");
$keepalive = exec("uci show network.wan2.keepalive | sed 's/^.*=//'");
$pppd_options = exec("uci show network.wan2.pppd_options | sed 's/^.*=//'");
?>

<h2>Mobile Configuration</h2>
<center><div id='network_message'></div></center>
<fieldset>
  <legend>Mobile Broadband Configuration - <a href='#sys/network/mobile_redial/redial/update_message'>Redial</a></legend>
  <form id='mobile_config' method='POST' action='/components/system/network/functions.php?mobile_config' onSubmit='$(this).AJAXifyForm(update_message); return false;'>
    <table cellspacing="5" cellpassing="5">
      <tr><td>Interface Name:</td><td>
	<select name="ifname">
	<option value="ppp0">ppp0</option>
	<option value="custom">custom</option>
	</select> 
	</td><td><input type="text" name="ifname-custom" value="<?=$ifname?>"/>
      </td></tr>
      <tr><td>Protocol:</td><td>
	<select name="proto">
	<option value="3g">3g</option>
	<option value="custom">custom</option>
	</select>
	</td><td><input type="text" name="proto-custom" value="<?=$proto?>"/>
      </td></tr>
      <tr><td>Service:</td><td><select name="service">
	<option value="cdma">cdma</option>
	<option value="evdo">evdo</option>
	<option value="umts">umts</option>
	<option value="umts_only">umts_only</option>
	<option value="gprs_only">gprs_only</option>
	<option value="custom">custom</option>
	</select>
	</td><td><input type="text" name="service-custom" value="<?=$service?>"/>
      </td></tr>
      <tr><td>Device:</td><td>
	<select name="device">
	<option value="/dev/ttyUSB0">/dev/ttyUSB0</option>
	<option value="/dev/ttyUSB1">/dev/ttyUSB1</option>
	<option value="/dev/ttyUSB2">/dev/ttyUSB2</option>
	<option value="custom">custom</option>
	</select>
	</td><td><input type="text" name="device-custom" value="<?=$device?>"/>
      </td></tr>
      <tr><td>APN:</td><td><input type="text" name="apn" value="<?=$apn?>"/></td><td></td></tr> 
      <tr><td>Username:</td><td><input type="text" name="username" value="<?=$username?>"/></td><td></td></tr> 
      <tr><td>Password:</td><td><input type="text" name="password" value="<?=$password?>"/></td><td></td></tr> 
      <tr><td>Default Route:</td><td>
	<select name="defaultroute">
	<option value="1">yes</option>
	<option value="0">no</option>
	</select>
      </td><td></td></tr> 
      <tr><td>ppp redial:</td><td>
	<select name="ppp_redial">
	<option value="persist">persist</option>
	<option value="custom">custom</option>
	</select>
	</td><td><input type="text" name="ppp_redial-custom" value="<?=$ppp_redial?>"/>
      </td></tr>
      <tr><td>Peer DNS:</td><td>
	<select name="peerdns">
	<option value="1">yes</option>
	<option value="0">no</option>
	</select>
      </td><td></td></tr>
      <tr><td>DNS:</td><td><input type="text" name="dns" value="<?=$dns?>"/></td></tr>
      <tr><td>Keepalive:</td><td>
	<select name="keepalive">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="custom">custom</option>
	</select>
	</td><td><input type="text" name="keepalive-custom" value="<?=$keepalive?>"/>
      </td></tr>
      <tr><td>pppd options:</td><td><input type="text" name="pppd_options" value="<?=$pppd_options?>"/></td><td></td></tr>
      <tr><td></td><td><input type="submit"/></td><td></td></tr>
    </table>
  </form>
</fieldset>
<br /><br />
<fieldset>
  <legend>Help</legend>
  For known configuration visit <a href="http://wifipineapple.com/modems">http://wifipineapple.com/modems</a>
</fieldset>
<br /><br />
<fieldset>
  <legend>Current Configuration</legend>
  <pre><?php echo shell_exec("uci show network.wan2"); ?></pre>
  <a href="#sys/network/action/reset_mobile/popup">Reset Mobile Configuration</a>
</fieldset>
