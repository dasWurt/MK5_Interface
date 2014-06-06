<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php

exec('touch /root/.ssh/authorized_keys');



?>
<h2>Authorized Keys</h2>
<center><div id='autossh_message'></div></center>

<fieldset>
<legend>Authorized Keys on Localhost</legend>

  <form method='POST' action='/components/system/autossh/functions.php?action=authorizedkeys' id='authorizedkeys' onSubmit='$(this).AJAXifyForm(update_message); return false;'>
    <textarea name='authorizedkeys' style='width: 100%; height: 12em'><?=file_get_contents('/root/.ssh/authorized_keys')?></textarea>
    <input type='submit' value='Update Authorized Keys'/>
  </form>
</fieldset>

