<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<h2>Syslog Output:</h2>
<?php
exec("logread | grep -n \"\" | sort -r -n | sed 's/^[0-9]*://g'", $log);
foreach ($log as $line) {
  echo str_replace(" ", "&nbsp;", $line)."<br />";
}
?>