<center><div id="network_message"></div></center>

<fieldset>
  <legend>Join A Network</legend>
  <p>
    Interface: <select name="iface">
      <?php 
      exec("iwconfig 2>&1 | grep 'IEE' | awk '{print $1}'", $interfaces);
      foreach($interfaces as $interface){
        if($interface != "wlan0") echo "<option value='".substr($interface, -1)."'>$interface</option>";
      }
      ?>
    </select> <a href="JAVASCRIPT:load_ssid()">Scan</a>
    <div id="ssid_form"></div>
  </p>
  <div id="ap_info"></div><br />
</fieldset>

<br /><br />

<fieldset>
  <legend>Connection Information - <a href="JAVASCRIPT:check_connection()">Refresh</a> - <a href="JAVASCRIPT:disconnect()">Disconnect Selected Interface</a></legend>
    Interface: <select name="connected_iface">
      <?php 
      foreach($interfaces as $interface){
        if($interface != "wlan0") echo "<option value='".substr($interface, -1)."'>$interface</option>";
      }
      ?>
    </select>  
  <p>
    <div id="connection_information">Checking Connection..</div>
  </p>
</fieldset>


<script type="text/javascript">

  $("select[name='connected_iface']").change(function() {
    check_connection();
  });

  var networks;

  //setTimeout(load_ssid, 1000);
  setTimeout(check_connection, 1000);

  if(check_connection_interval != undefined){
    clearInterval(check_connection_interval);
  }
  var check_connection_interval = setInterval(check_connection, 10*1000);
  var check_disconnection_interval = undefined;

  function load_ssid(){
    var iface = $("select[name='iface'] option:selected").val();
    $("#ssid_form").html('Loading SSIDs..<br />');
    $("#ap_info").html("");
    $.get("/components/system/network/functions.php?scan="+iface, function(data){
      networks = jQuery.parseJSON(data);
      if(networks == ""){
        $("#ssid_form").html("No networks found.");
        $("#ap_info").html("");
      }else{
        $("#ssid_form").html("<select id='ssid_form_select' onChange='get_ap_info()'></select>");
        $.each(networks, function(key, value) {
          $("#ssid_form_select").append($("<option></option>").attr("value", key).text(networks[key]['ESSID']));
        });
        get_ap_info();
      }

    });
  }

  function get_ap_info(){
    var bssid = $('#ssid_form_select').find(":selected").val()
    var ap = networks[bssid];
    if(ap["security"] != undefined){
      var security;

      if(ap["security"]["WEP"] != undefined){
        security = "WEP";
      }else if(ap["security"]["WPA2"] != undefined){
        security = "WPA2";
      }else if(ap["security"]["WPA"] != undefined){
        security = "WPA";
      }

    }else{
      var security = "Open";
    }

    var key = "";
    if(security != "Open"){
      var key = "<tr><td>Key:</td><td><input type='password' id='psk'/></td><tr>";
    }

    var collision_text = ap['channel_collision'] ? "<font color='red'>Warning: Channel conflict between WiFi Pineapple and selected network.</font>" : "";


    var info = "<table><tr><td>BSSID:</td><td>"+bssid+"</td></tr><tr><td>SSID:</td><td>"+ap['ESSID']+"</td></tr><tr><td>Channel:</td><td>"+ap['channel']+" "+collision_text+"</td></tr><tr><td>Signal Strength:</td><td>"+ap['signal']+"</td></tr><tr><td>Quality:</td><td>"+ap['quality']+"</td></tr><tr><td>Security:</td><td>"+security+"</td></tr>"+key+"</table>";
    $("#ap_info").html(info+"<a href='JAVASCRIPT: connect()'>Connect to this network</a>");
  }

  function connect(){
    var bssid = $('#ssid_form_select').find(":selected").val();
    var iface = $("select[name='iface'] option:selected").val();
    var ap = networks[bssid];
    ap["ESSID"] = encodeURIComponent(btoa(ap["ESSID"]));
    ap["key"] = encodeURIComponent(btoa($("#psk").val()));
    $("#network_message").html("<img src='/includes/img/throbber.gif'><br /><font color='lime'>Connecting, please wait.</font><br /><br />")
    $.get('/components/system/network/functions.php?connect='+JSON.stringify(ap)+'&iface='+iface, function(data){
      if(data == "done"){
        $("#network_message").html("<font color='lime'>Connection initiated. See below for connection details.</font><br /><br />")
      }
    });
    if(check_connection_interval != undefined){
      clearInterval(check_connection_interval);
    }
    $("select[name='connected_iface']").val(iface);
    check_connection_interval = setInterval(check_connection, 5*1000);
  }

  function disconnect(){
    var iface = $("select[name='connected_iface'] option:selected").val();
    $("#network_message").html("<img src='/includes/img/throbber.gif'><br /><font color='lime'>Disconnecting, please wait.</font><br /><br />")
    $.get('/components/system/network/functions.php?disconnect='+iface);
    if(check_connection_interval != undefined){
      clearInterval(check_connection_interval);
    }
    check_disconnection_interval = setInterval(check_disconnection, 2.5*1000);
  }

  function check_disconnection(){
    var iface = $("select[name='connected_iface'] option:selected").val();
    $.get('/components/system/network/functions.php?get_connection='+iface, function(data){
      if(data == "not_associated"){
        $("#network_message").html("<font color='lime'>Disconnected.</font><br /><br />");
        clearInterval(check_disconnection_interval);
        if(check_connection_interval != undefined){
          clearInterval(check_connection_interval);
        }
        check_connection_interval = setInterval(check_connection, 5*1000);
        $("#connection_information").html("Not connected.");
      }
    });
  }

  function check_connection(){
    var iface = $("select[name='connected_iface'] option:selected").val();
    $.get('/components/system/network/functions.php?get_connection='+iface, function(data){
      if(data == "not_associated"){
        $("#connection_information").html("Not connected.");
      }else if(data == "<pre></pre>"){
        //Do nothing
      }else{
        if($("#network_message").text() == "Connecting, please wait."){
          $("#network_message").html("<font color='lime'>Connection Established. See below for connection details.</font><br /><br />");
        }
        clearInterval(check_connection_interval);
        $("#connection_information").html("<b>Connected.</b><br /><br />"+data);
      }
    });
  }
</script>