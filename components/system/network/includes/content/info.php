<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php
$directory = realpath(dirname(__FILE__)).'/../../';
$rel_dir = str_replace('/pineapple', '', $directory);
?>
<div align="center" id="network_info_message"></div>
<h2>Network Info</h2>

<fieldset>
  <legend>Route - <a href="#sys/network/restart_dns/true/notify">Restart DNS</a></legend>
  <?php
  exec('route', $route);
  echo '<pre>';
  foreach($route as $line){
    echo $line."\n";
  }
  echo '</pre>';
  ?>
  <?php
  $select = "<select name='iface'>";
  exec("ifconfig | grep Link | awk '{print $1}' | grep -v lo", $interfaces);
  foreach($interfaces as $interface){
    $select .= "<option value='$interface'>$interface</option>";
  }
  $select .= "</select>";
  ?>
  <form method="POST" action="<?=$rel_dir?>functions.php?update_route" onSubmit="$(this).AJAXifyForm(update_default_route); return false;">
  Default route: <input type="text" name="route" value="172.16.42.42"><?=$select?><input type="submit" value="Update Route">
  </form>
</fieldset>

<br /><br />

<fieldset>
  <legend>Ifconfig</legend>
  <?php
  exec('ifconfig -a', $ifconfig);
  echo '<pre>';
  foreach($ifconfig as $line){
    echo $line."\n";
  }
  echo '</pre>';
  ?>
</fieldset>

<script type="text/javascript">
  function update_default_route(data){
    selectTabContent('info');
    $('#network_info_message').html(data);
  }
</script>