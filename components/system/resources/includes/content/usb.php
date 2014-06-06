<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php
$directory = realpath(dirname(__FILE__)).'/../../';
$rel_dir = str_replace('/pineapple', '', $directory);
?>


<div style='text-align: center; color: lime;' id='usb_message'/>
<h2>Format SD:</h2>
This section allows your to partition and format your SD card automatically.<br />
Proceed with caution as this will delete ALL data off the SD card.<br />
Please remove any device you may have plugged into the USB port before proceeding<br /><br />

<a href="#sys/resources/format_sd/true/popup" onClick="return confirm('Are you sure? All data on the SD card will be erased!');">Format SD Card - (Experimental)</a>


<br /><br />
<div style='text-align: center; color: lime;' id='usb_message'/>
<h2>Attached USB devices:</h2>
<?php
$exec = exec("lsusb", $return);
foreach ($return as $line) {
echo("$line <br />");
}
?>

<br />
<h2>Fstab Configuration:</h2>
<form method='POST' action='<?=$rel_dir?>functions.php?update_fstab' id='fstab' onSubmit='$(this).AJAXifyForm(update_fstab); return false;'>
  <textarea name='fstab' rows='20' style='min-width:100%; background-color:black; color:white; border-style:dashed;'><?=file_get_contents("/etc/config/fstab")?></textarea>
  <br><center><input type='submit' value='Update Fstab'>
</form>
