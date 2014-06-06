<div id="network_message"></div>

<fieldset>
  <legend>MAC Changer - <a href="#" onclick="restore_mac()">Restore original MAC of selected interface</a></legend>

  <table>
    <tr>
      <td>Interface:</td>
      <td>
        <select name="iface"><?php exec("iwconfig 2>&1 | grep 'IEE' | awk '{print $1}'", $interfaces);foreach($interfaces as $interface){echo "<option value='".substr($interface, -1)."'>$interface</option>";}?></select> <a href="#" onclick="get_mac(); return false;">Refresh</a>
      </td>
    </tr>
    <tr>
      <td>
        Current MAC:
      </td>
      <td>
        <input type="text" name="current_mac" readonly>
      </td>
    </tr>
    <tr>
      <td>
        New MAC:
      </td>
      <td>
        <input type="text" name="new_mac">
      </td>
    </tr>
  </table>
  <input id="new_mac" type="submit" value="Set new MAC"> <input id="random_mac" type="submit" value="Generate random MAC">

<br /><br />
<small>Note: Changing your MAC addresses may disconnect you from the WiFi Pineapple. </small>
</fieldset>

<br /><br />

<fieldset>
  <legend>Miscellaneous</legend>

  <a href="#" onclick="reset_wireless(); return false;">Reset Wireless Configuration</a> - completely resets Wireless Configuration to factory defaults and restarts wireless.
</fieldset>

<script type="text/javascript">
  get_mac();
  $("[name=iface]").change(get_mac);

  $("#new_mac").click(function(){
    var mac = $("[name=new_mac]").val();
    var iface = $("[name=iface]").val(); 
    $("#network_message").html("<center><img height='30' src='/includes/img/throbber.gif'><br /><font color='lime'>Changing MAC, please wait.</font></center><br />");
    $.get('/components/system/network/functions.php?change_mac='+iface+'&mac='+mac, function(data){
      $("#network_message").html("<center><font color='lime'>MAC was changed to: "+data.toUpperCase()+"</font></center><br />");
      get_mac();
    });
  });

  $("#random_mac").click(function(){
    var iface = $("[name=iface]").val();
    $("#network_message").html("<center><img height='30' src='/includes/img/throbber.gif'><br /><font color='lime'>Changing MAC, please wait.</font></center><br />");
    $.get('/components/system/network/functions.php?change_mac='+iface, function(data){
      $("#network_message").html("<center><font color='lime'>MAC was changed to: "+data.toUpperCase()+"</font></center><br />");
      get_mac();
    });
  });

  function get_mac(){
    var iface = $("[name=iface]").val();
    $.get("/components/system/network/functions.php?get_mac="+iface, function(data){
      $("[name=current_mac]").prop("value", data);
    });
  }

  function restore_mac(){
    var iface = $("[name=iface]").val();
    $("#network_message").html("<center><img height='30' src='/includes/img/throbber.gif'><br /><font color='lime'>Restoring MAC, please wait.</font></center><br />");
    $.get("/components/system/network/functions.php?restore_mac="+iface, function(data){
      $("#network_message").html("<center><font color='lime'>MAC was restored.</font></center><br />");
      get_mac();
    });
  }

  function reset_wireless(){
    if(confirm("Are you sure you want to reset all wireless settings to factory defaults?")){
      $.get("/components/system/network/functions.php?reset_config", function(data){
        popup(data);
      });     
    }
  }

</script>