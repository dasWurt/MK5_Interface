<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>

<div style='text-align: right'><a href='#' class="refresh" onclick='get_bar_updates()'> </a></div>

Refresh this tile to check for system updates.<br /><br />

<div id="bar_updates"></div>


<script type="text/javascript">

  $.get('/components/system/bar/functions.php?start_linker');
  var linker = setInterval(function(){
    $.get('/components/system/bar/functions.php?linker_status', function(data){
      if(data == "completed"){
        clearInterval(linker);
      }
      if(data == "linked"){
        load_tiles();
        populate_hidden_tiles();
        popup("<center>WiFi Pineapple Bar Linker</center><br />The infusion linker has detected orphaned infusions stored on your SD card.<br /><br />It has automatically added them to the webinterface. You may now close this popup.");        
        clearInterval(linker);
      }
    });
  }, 5000);



  function get_bar_updates(){
    $('#bar_updates').html('<br /><br /><center><img style="height: 2em; width: 2em;" src="/includes/img/throbber.gif"></center>');
    $.get('/components/system/bar/functions.php?get_small_updates', function(data){
      if(data == ""){
        $('#bar_updates').html('No updates found');
      }else{
        $('#bar_updates').html(data);
      }
    })
  }

</script>