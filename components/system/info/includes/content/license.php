<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<center>
  <fieldset style='text-align: left; width: 60%'>
    <legend><h3>Software License</h3></legend>
    <textarea style='width: 100%; height: 15em;' readonly='readonly'><?=file_get_contents('software_license.txt')?></textarea>
  </fieldset>
  <br /><br />
  <fieldset style='text-align: left; width: 60%'>
    <legend><h3>End-user license agreement</h3></legend>
    <textarea style='width: 100%; min-height:15em' readonly='readonly'><?=file_get_contents('eula.txt')?></textarea>
  </fieldset>
</center>
