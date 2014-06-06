<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<p id='dmsg_top' align="right"><a href="#dmsg_bottom">Jump to bottom</a></p>
<h2>Dmesg Output:</h2>
<?php
exec("dmesg", $dmesg);
foreach($dmesg as $line){
  echo str_replace(" ", "&nbsp;", $line)."<br />";
}
?>
<p id='dmsg_bottom' align="right"><a href="#dmsg_top">Jump to top</a></p>
