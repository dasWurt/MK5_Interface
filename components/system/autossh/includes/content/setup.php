<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php

$host = exec("uci show autossh.@autossh[0].ssh | awk '{print $7}'");
$port = exec("uci show autossh.@autossh[0].ssh | awk '{print $6}' | sed 's/:/ /g' | awk '{print $1}'");
$listen = exec("uci show autossh.@autossh[0].ssh | awk '{print $6}' | sed 's/:/ /g' | awk '{print $3}'");

$key = '';
exec('cat /root/.ssh/id_rsa.pub', $result);
foreach($result as $line){
  $key .= $line."\n";
}

$knownhost_file = '';
exec('cat /root/.ssh/known_hosts', $knownhost_result);
foreach($knownhost_result as $knownhost_line){
  $knownhost_file .= $knownhost_line."\n";
}


?>
<h2>AutoSSH Setup</h2>
<center><div id='autossh_message'></div></center>
<fieldset>
  <legend>Settings</legend>

  <form method="POST" action="/components/system/autossh/functions.php?action=edit" id="autossh" onSubmit="$(this).AJAXifyForm(update_message); return false;">
    <table>
      <tr><td>Host:</td><td><input name='host' type='text' placeholder='<?=$host?>' value='<?=$host?>'></td></tr>
      <tr><td>Port:</td><td><input name='port' type='text' placeholder='<?=$port?>' value='<?=$port?>'></td></tr>
      <tr><td>Listen Port:</td><td><input name='listen' type='text' placeholder='<?=$listen?>' value='<?=$listen?>'></td></tr>
      <tr><td><input type='submit' name='submit' value='Save'></td></tr>
    </table>

  </form>
</fieldset>

<br /><br />

<fieldset>
<legend>Public Key - <a href='#sys/autossh/action/generate/refresh_setup'>Generate</a></legend>
<textarea style='width:60%;' rows='10' readonly='readonly'><?=$key?></textarea>
</fieldset>



