<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<center><div id='config_message'></div></center>
<fieldset>
  <legend>Spoofhost Editor</legend>
  <form method='POST' action='/components/system/configuration/functions.php?update_spoofhost' onSubmit='$(this).AJAXifyForm(update_message); return false;'>
    <textarea name='spoofhost' style='width: 100%; height: 20em'><?=file_get_contents('/etc/pineapple/spoofhost')?></textarea>
    <br />
    <center><input type='submit' value='Update Spoofhost'/></center>
  </form>
</fieldset>

<br /><br />

<fieldset>
  <legend>Index.php Editor (Phishing)</legend>
  <form method='POST' action='/components/system/configuration/functions.php?update_index' onSubmit='$(this).AJAXifyForm(update_message); return false;'>
    <textarea name='page' style='width: 100%; height: 20em'><?=file_get_contents('/www/index.php')?></textarea>
    <br />
    <center><input type='submit' value='Update Page'/></center>
  </form>
</fieldset>