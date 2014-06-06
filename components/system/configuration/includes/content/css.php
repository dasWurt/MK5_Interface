<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<center><div id='config_message'></div></center>
<fieldset>
  <legend>Web-interface CSS</legend>
  <form method='POST' action='/components/system/configuration/functions.php?update_css' onSubmit='$(this).AJAXifyForm(update_message); return false;'>
    <textarea name='css' style='width: 100%; height: 35em'><?=file_get_contents('/pineapple/includes/css/styles_main.css')?></textarea>
    <br />
    <center><input type='submit' value='Update CSS'/></center>
  </form>
</fieldset>