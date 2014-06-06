<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php



?>
<h2>Tansfer Public Key to Remote Host</h2>
<center><div id='autossh_message'></div></center>

<fieldset>
<legend>Replace Authorized Key file on Remote Server with Local Public Key</legend>
  <form method="POST" action="/components/system/autossh/functions.php?action=keycopy" id="keycopy" onSubmit="$(this).AJAXifyForm(update_message); return false;">
    <table>
      <tr><td>Host:</td><td><input name='ak_host' type='text' placeholder='<?=$ak_host?>' value='<?=$ak_host?>'></td></tr>
      <tr><td>User:</td><td><input name='ak_user' type='text' placeholder='<?=$ak_user?>' value='<?=$ak_user?>'></td></tr>
      <tr><td>Password:</td><td><input name='ak_password' type='text' placeholder='<?=$ak_password?>' value='<?=$ak_password?>'></td></tr>
      <tr><td><input type='submit' name='submit' value='Replace Remote Authorized Keys File'></td></tr>
    </table>

  </form>
</fieldset>
