<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php
$directory = realpath(dirname(__FILE__)).'/';
$rel_dir = str_replace('/pineapple', '', $directory);


if(isset($_GET['kill']) && is_numeric($_GET['kill'])){
  exec("kill ".$_GET['kill']);
}

if(isset($_GET['update_log']) && isset($_POST['log'])){
  $handle = fopen($directory.'custom', 'w');
  fwrite($handle, $_POST['log']);
  fclose($handle);
  echo "Log set successfully";
}

?>