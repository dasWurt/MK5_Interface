<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php
global $directory, $rel_dir;
?>
<script type='text/javascript' src='<?=$rel_dir?>includes/helpers.js'></script>
<style>@import url('<?=$rel_dir?>includes/styles.css')</style>

<ul id="tabs">
  <li><a id="installed">Pineapple Bar: Installed</a></li>
  <li><a id="available">Pineapple Bar: Available</a></li>
  <li><a id="create">Bartender: Create New Infusions</a></li>
  <li><a id="manage">Bartender: Manage Your Infusion</a></li>
</ul>
<div class="tabContainer" />

