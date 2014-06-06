<fieldset>
  <legend>Access Point Configuration</legend>

  <form id="ap_config" method="POST" action="/components/system/network/functions.php?ap_config" onSubmit="$(this).AJAXifyForm(popup); return false;">
    <table>
      <tr><td>SSID:</td><td><input type="text" name="ssid" value="<?=str_replace('"', '&quot;', trim(exec("uci get wireless.@wifi-iface[0].ssid")))?>"></td></tr>
      <tr><td>Channel:</td><td><select name="channel" ><? for($i=1; $i<= 14; $i++){echo "<option value='$i'>$i</option>";} ?></select></td></tr>
      <tr><td>Encryption:</td><td><select name="encryption"><option value="None">None</option><option value="WPA">WPA</option><option value="WPA2">WPA2</option></select></td></tr>
      <tr><td>Password:</td><td><input type="password" name="password"></td></tr>
    </table>
    <input type="submit" value="Save Configuration">
  </form>

</fieldset>

<br /><br />

<!-- <fieldset>
  <legend>Information</legend>

</fieldset> -->

<script type="text/javascript">
  <?php 
  $encryption = trim(exec("uci get wireless.@wifi-iface[0].encryption"));
  if($encryption == "psk2+ccmp"){
    echo "var encryption='WPA2';";
  }elseif($encryption == "psk+ccmp"){
    echo "var encryption='WPA';";
  }else{
    echo "var encryption='None';";
  }
  echo "var channel=".trim(exec("uci get wireless.radio0.channel")).";"; 
  ?>

  $('option[value="'+encryption+'"]').prop('selected', 'true');
  $('option[value="'+channel+'"]').prop('selected', 'true');

</script>