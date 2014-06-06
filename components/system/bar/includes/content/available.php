<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<div id='bar_available'>
Loading, please wait. This can take a while, depending on your internet connection.
</div>

<script type="text/javascript">
$.get('/components/system/bar/functions.php?action=getInfusionList', function(data){
  $('#bar_available').html(data);
});
</script>
