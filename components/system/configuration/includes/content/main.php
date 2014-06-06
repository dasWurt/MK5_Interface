<?php include('/pineapple/includes/api/tile_functions.php'); ?>

<center><div id='config_message'></div></center>
<fieldset>
  <legend>Time Zone Settings</legend>
  Current timezone: <span id='config_tz'><?=exec("date +%Z%z")?></span><br /><br />
  <form id='config_change_time' method='POST' action='/components/system/configuration/functions.php?change_tz' onSubmit='$(this).AJAXifyForm(update_tz); return false;'>
    New Time Zone:
    <select name="time" id="time">
      <option value="12">(GMT -12:00) Eniwetok, Kwajalein</option>
      <option value="11">(GMT -11:00) Midway Island, Samoa</option>
      <option value="10">(GMT -10:00) Hawaii</option>
      <option value="9">(GMT -9:00) Alaska</option>
      <option value="8">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
      <option value="7">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
      <option value="6">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
      <option value="5">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
      <option value="4">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
      <option value="3">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
      <option value="2">(GMT -2:00) Mid-Atlantic</option>
      <option value="1">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
      <option value="0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
      <option value="-1">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
      <option value="-2">(GMT +2:00) Kaliningrad, South Africa</option>
      <option value="-3">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
      <option value="-4">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
      <option value="-5">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
      <option value="-6">(GMT +6:00) Almaty, Dhaka, Colombo</option>
      <option value="-7">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
      <option value="-8">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
      <option value="-9">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
      <option value="-10">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
      <option value="-11">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
      <option value="-12">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
    </select>
    <br />
    or custom Zone:<input type="text" name="custom_zone"><br />
    <input type='submit' name='change_time' value='Change Time Zone'>
  </form>
</fieldset>

<br /><br />

<fieldset>
  <legend>Change Root Password</legend>
  <form id='config_change_password' method='POST' action='/components/system/configuration/functions.php?change_password' onSubmit='$(this).AJAXifyForm(update_message); return false;'>
    <table>
      <tr><td>Old Password:</td><td><input type='password' name='old_password' placeholder='********'/></td></tr>
      <tr><td>New Password:</td><td><input type='password' name='password' placeholder='********'/></td></tr>
      <tr><td>Repeat Password:</td><td><input type='password' name='repeat' placeholder='********'/></td></tr> 
      <tr><td><input type='submit' name='change_password' value='Change Password'></td></tr>
    </table>
  </form>
</fieldset>