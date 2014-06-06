<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php
if(file_get_contents($directory.'custom') != ''){
  $file = file_get_contents($directory.'custom');
  echo "<b>Following '$file':</b>";
  exec('tail '.$file, $tail);
  echo "<pre>";
  foreach ($tail as $line) {
    echo $line."<br />";
  }
  echo "</pre>";
}else{
  echo 'No log file is being followed. To follow a custom logfile here, open the large tile.';
}

?>