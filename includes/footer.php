<?php
$containing_dir = realpath(dirname(get_included_files()[1]));
if(substr($containing_dir, 0, 10) == "/pineapple" || substr($containing_dir, 0, 13) == "/sd/infusions"){
  $previous_content = ob_get_clean();
  require_once('/pineapple/includes/api/auth.php');
  echo $previous_content;
}
?>