<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<div style='text-align: right'><a href='#' class="refresh" onclick='refresh_small("resources", "sys")'> </a></div>
<pre>
<?php
$cmd = "free -h";
exec ($cmd, $output);
foreach($output as $outputline) {
  echo ("$outputline\n");
}
$output = "";
?>
</pre>

<?php
if(trim(exec("mount | grep /sd | awk {'print $5'}")) == "vfat"){
  echo "<span style='color:red'>Your SD card is currently not in ext4. For best performance, open this infusion and navigate to \"USB Info\" to format the SD card.</span>";
}
?>