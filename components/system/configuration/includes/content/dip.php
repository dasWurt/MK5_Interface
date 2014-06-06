<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<center><div id='config_message'></div></center>
<fieldset>
  <legend>DIP Switch Configuration</legend>
  <form method='POST' action='/components/system/configuration/functions.php' onSubmit='$(this).AJAXifyForm(update_dips); return false;' >
    <table>
      <tr><th>DIP2 </th><th>DIP3 </th><th>DIP4 </th></tr>
      <?php

      $db = new SQLite3('/etc/pineapple/mk5.db');

      $result = $db->query('SELECT * FROM dips');

      while( $row = $result->fetchArray()){

        $row['command'] = htmlspecialchars($row['command']);
        if(!($row['dip1'] == 0 && $row['dip2'] == 0 && $row['dip3'] == 1)){
          echo "<tr><td>".$row['dip1']."</td><td>".$row['dip2']."</td><td>".$row['dip3']."</td><td><input style='width: 60em;' type='text' name='".$row['dip1']."-".$row['dip2']."-".$row['dip3']."' value=\"".$row['command']."\"></td></tr>";
        }
      }

      ?>
      <tr><td></td><td></td><td></td><td align='right'><input type='submit' name='dip' value='Save DIP Configuration'></td></tr>
    </table>
  </form>
</fieldset>

<br /><br />

<fieldset>
  <legend>Help</legend>
  <table>
    <tr>
      <td><img src="/components/system/configuration/files/dip_switches.png"></td>
      <td>
        Commands may be executed at boot-up automatically with the configuration of User Switches 2, 3 and 4. In the table above DIPS 2-4 are defined as either UP (1) or DOWN (0). Multiple commands can be executed together with standard bash syntax (separated by semicolon). <br /><br />
        For example: <i>ifconfig wlan1 up; airmon-ng start wlan1; airodump-ng --write /sd/airodump.pcap --output-format pcap mon0; # Log raw 802.11 frames to packet capture file on SD card.</i><br /><br />
        Switches 1 and 5 are reserved for system functions. DIP switches can be found on the side of the device and are read from left to right. Switches 1 (far left) and 5 (far right) must be in the UP (1) position for normal operation. For more information on Boot Modes and DIP switch configuration please refer to the user guide.
      </td>
    </tr>
  </table>
</fieldset>
