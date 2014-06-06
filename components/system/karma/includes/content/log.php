<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<h2>Karma Log</h2>

<fieldset>
  <legend>Karma Log Filters</legend>
  <input name="filter_type" id="karma_filter" type="radio" value="Probe Request from"> Probe Requests | <input name="filter_type" id="karma_filter" type="radio" value="association"> Associations | <input name="filter_type" id="karma_filter" type="radio" value="" checked> All | <input name="dupes" id="karma_filter" name="" type="checkbox"> Remove Duplicates | SSID: <input name="ssid_filter" id="karma_filter" type="text"> | MAC: <input name="mac_filter" id="karma_filter" type="text"> | <b><a href="JAVASCRIPT:apply_filters()">APPLY FILTERS</a> | <b><a href="JAVASCRIPT:clear_filters()">CLEAR FILTERS</a></b>
</fieldset>

<br /><br />

<fieldset>
  <legend>Karma Log - <a href="JAVASCRIPT:refresh_log();">Refresh Log</a> - <a href='#sys/karma/action/clear_log/refresh_log'>Clear Log</a></legend>
  <div id='karma_log'>Loading data, please wait.</div>
</fieldset>

<script type="text/javascript">
  var karma_log = [];
  setTimeout(function(){
    refresh_log();
  }, 0);

  function apply_filters(){
    var filter_array = [];
    filter_array.push($("[name=ssid_filter]").val());
    filter_array.push($("[name=mac_filter]").val().toLowerCase());
    filter_array.push($('input[name=filter_type]:checked').val());
    var duplicates = $("[id=karma_filter][name=dupes]").prop('checked');
    filter_log(karma_log, filter_array, duplicates);
  }

  function clear_filters(){
    $("[id=karma_filter][value=]").prop('checked', true);
    $("[name=ssid_filter]").val("");
    $("[name=mac_filter]").val("");
    $("[id=karma_filter][name=dupes]").prop('checked', false);
    refresh_log();
  }

</script>