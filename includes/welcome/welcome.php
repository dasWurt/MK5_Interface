<?php
include("/pineapple/includes/api/tile_functions.php");

if(isset($_GET['finish_setup'])){
  if(file_exists('/pineapple/includes/welcome/license_accepted')){
    exec('rm -rf /www/pineapple/');
    exec('mkdir -p /pineapple/components/infusions');

    exec('/etc/init.d/blink disable && /etc/init.d/blink stop');
    exec('/etc/init.d/sshd enable && /etc/init.d/sshd start');
    exec('/etc/init.d/dip_handler enable');
    exec('/etc/init.d/pineapple enable && /etc/init.d/pineapple start');
    exec('/etc/init.d/sysntpd enable && /etc/init.d/sysntpd start');

    exec('uci add system led');
    exec('uci set system.@led[-1].name="ethernet"');
    exec('uci set system.@led[-1].sysfs="mk5:amber:lan"');
    exec('uci set system.@led[-1].trigger="netdev"');
    exec('uci set system.@led[-1].dev="eth0"');
    exec('uci set system.@led[-1].mode="link tx rx"');
    exec('uci commit system');

    exec('uci add system led');
    exec('uci set system.@led[-1].name="wlan0"');
    exec('uci set system.@led[-1].sysfs="mk5:blue:wlan0"');
    exec('uci set system.@led[-1].trigger="netdev"');
    exec('uci set system.@led[-1].dev="wlan0"');
    exec('uci set system.@led[-1].mode="link tx rx"');
    exec('uci commit system');

    exec('uci add system led');
    exec('uci set system.@led[-1].name="wlan1"');
    exec('uci set system.@led[-1].sysfs="mk5:red:wlan1"');
    exec('uci set system.@led[-1].trigger="netdev"');
    exec('uci set system.@led[-1].dev="wlan1"');
    exec('uci set system.@led[-1].mode="link tx rx"');
    exec('uci commit system');

    exec('wifi detect > /etc/config/wireless');
    exec('wifi');
    exec('pineapple led reset');
    exec('rm -rf /pineapple/includes/welcome');
  }
}
?>

<html>
<head>
  <title>Setup</title><script src="/includes/js/jquery.min.js"></script>
  <meta http-equiv="cache-control" content="max-age=0" />
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="expires" content="0" />
  <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
  <meta http-equiv="pragma" content="no-cache" />
  <?php if(isset($_GET['password'])) echo'<meta name="viewport" content="width=device-width, initial-scale=1.0">';?>
</head>
<body bgcolor="black" text="white" link="lime" alink="lime" vlink="lime">
  <center><br /><br /><br />
    <img src="/includes/img/mk5_logo.gif">
    <?php
    if(!(isset($_GET['password']) || isset($_GET['finish']))){
      ?>

      <pre>
        Welcome to your WiFi Pineapple.
        Find support, infusions, news and forums at <a href="http://wifipineapple.com" target="_blank">WiFiPineapple.com</a>.

        <?php
        if(file_exists('/etc/pineapple/init')){ ?>
        Please refresh this page once you see the blinking LED pattern on your pineapple.
      </pre>
      <?php }else { ?>
      <a href="?password"><h2>Continue</h2></a>
    </pre>
    <?php } ?>


    <?php }

    if(isset($_GET['password'])){ ?>

    <pre>
      First, let's change your password:
      <p>
        <table>
          <form action="?finish" method="POST">
            <tr><td>New Password </td><td><input name='password' type='password' tabindex='1'></td></tr>
            <tr><td>Retype Password </td><td><input name='password2' type='password' tabindex='2'></td></tr>
            <tr><td><input name="eula" type="checkbox" tabindex='3'></td><td>I accept the <a href="/components/system/info/includes/content/eula.txt" target="_blank">EULA</a></td></tr>
            <tr><td><input name="sw_license" type="checkbox" tabindex='4'></td><td>I accept the <a href="/components/system/info/includes/content/software_license.txt" target="_blank">Software License</a></td></tr>
            <tr><td></td><td><input type='submit' value='Set Password' tabindex='5'></td></tr>
          </form>
          <table>
          </p>

        </pre>
        <?php
      }


      if(isset($_GET['finish'])){
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        if(trim($password) != "" && $password == $password2 && ($_POST['eula'] && $_POST['sw_license'])){

    #Passwords match - keep going
          exec("touch /pineapple/includes/welcome/license_accepted");
          exec('date -s "2014-01-01 00:00:00"');
          change_password("pineapplesareyummy", $password);
          echo "<pre>";
          echo "Password set successfully";
          echo "<p>The system is now completing the setup, please wait.\nIf you are connected over WiFi, please make sure to reconnect as you will be disconnected.</p>";
          if(trim(exec("mount | grep /sd | awk {'print $5'}")) == "vfat"){
            echo "For <font color='red'>best performance</font> you are advised to <b>format the Micro SD card ext4</b>. To do so click <b>Resouces</b> then <b>USB Info</b> then <b><u>Format SD Card</u/></b>.";            
          }
          echo "<div id='finish'></div>";

          echo "
          <script type='text/javascript'>


            $.get('/?finish_setup');

            setTimeout(function() {
              var interval = setInterval(function() {
                $.get('/', function(data) {
                  if(data != ''){
                    clearInterval(interval);
                    $('#finish').html('<h2><a href=\'/\'>Continue</a></h2>');
                  }
                });
}, 1500);
}, 5000);

</script>


";

}else{

  echo "<pre>The passwords did not match or you didn't accept the licenses. Please <a href='/'>try again</a></pre>";
}

}


?>
</center>
</body></html>