<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php
global $directory, $rel_dir;
?>
<script type='text/javascript' src='<?=$rel_dir?>includes/helpers.js'></script>
<style>@import url('<?=$rel_dir?>includes/styles.css')</style>

<ul id="tabs">
  <li><a id="syslog">Syslog</a></li>
  <li><a id="dmesg">Dmesg</a></li>
  <li><a id="custom">Custom</a></li>
</ul>
<div class="tabContainer" />