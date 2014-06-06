<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<center><div id='config_message'></div></center>
<fieldset>
  <legend>Crontab</legend>
  <form method='POST' action='/components/system/configuration/functions.php?update_cron' onSubmit='$(this).AJAXifyForm(update_message); return false;'>
    <textarea name='cron' style='width: 100%; height: 20em'><?=file_get_contents('/etc/crontabs/root')?></textarea>
    <br />
    <center><input type='submit' value='Update Crontab'/></center>
  </form>
</fieldset>

<br /><br />

<fieldset>
  <legend>Crontab Help</legend>
<pre>
Cronjob Configuration.

  * * * * * command to be executed
  - - - - -
  | | | | |
  | | | | +- - - - day of week (0 - 6) (Sunday=0)
  | | | +- - - - - month (1 - 12)
  | | +- - - - - - day of month (1 - 31)
  | +- - - - - - - hour (0 - 23)
  +- - - - - - - - minute (0 - 59)
  
  Examples:
  
  Run myscript.sh at 2:30 AM every day
  30 2 * * * /root/myscript.sh
  
  Run myscript.sh every 15 minutes
  */15 * * * * /root/myscript.sh
</pre>
</fieldset>