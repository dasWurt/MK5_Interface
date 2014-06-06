<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<div style='text-align: center; color: lime' id='cache_message' />

<h2>Current Disk Usage: </h2>
<pre>
<?php
$cmd = "df -h";
exec ($cmd, $output);
foreach($output as $outputline) {
  echo ("$outputline\n");
}
$output = "";
?>
</pre>

<br />
<h2>Current Memory Usage: </h2>
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

<h2>Drop Caches</h2>
<p><a href='#sys/resources/cache/drop/dropCaches'>Drop Page Cache</a> - only use if you know what you are doing.</p>