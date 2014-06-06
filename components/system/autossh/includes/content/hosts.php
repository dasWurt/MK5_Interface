<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php


$knownhost_file = '';
exec('cat /root/.ssh/known_hosts', $knownhost_result);
foreach($knownhost_result as $knownhost_line){
  $knownhost_file .= $knownhost_line."\n";
}


?>
<h2>Known Hosts</h2>
<center><div id='autossh_message'></div></center>

<fieldset>
<legend>Known Hosts on Localhost</legend>
  <form method="POST" action="/components/system/autossh/functions.php?action=knownhost_add" id="knownhost" onSubmit="$(this).AJAXifyForm(update_message); return false;">
    <table>
      <tr><td>User:</td><td><input name='knownhost_user' type='text' placeholder='<?=$knownhost_user?>' value='<?=$knownhost_user?>'></td></tr>
      <tr><td>Host:</td><td><input name='knownhost_host' type='text' placeholder='<?=$knownhost_host?>' value='<?=$knownhost_host?>'></td></tr>
      <tr><td><input type='submit' name='submit' value='Add'></td></tr>
    </table>

  </form>
</fieldset>
<br /><br />
<fieldset>
<legend>Known Host</legend>
<textarea style='width:60%;' rows='10' readonly='readonly'><?=$knownhost_file?></textarea>
</fieldset>
