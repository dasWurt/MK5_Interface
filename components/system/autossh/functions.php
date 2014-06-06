<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php

if(isset($_GET['autossh'])){
  echo autossh($_GET['autossh']);
  echo $_GET['autossh'];
}

if(isset($_GET['action'])){
  if($_GET['action'] == "generate"){
    generate_key();
  }

  if($_GET['action'] == "edit"){
    echo edit_command($_POST['host'], $_POST['port'], $_POST['listen']);
  }
  if($_GET['action'] == "knownhost_add"){
    echo knownhost($_POST['knownhost_user'], $_POST['knownhost_host']);
  }
  if($_GET['action'] == "authorizedkeys"){
    echo authorizedkeys($_POST['authorizedkeys']);
  }
  if($_GET['action'] == "keycopy"){
    echo keycopy($_POST['ak_user'], $_POST['ak_host'], $_POST['ak_password']);
  }


}

function autossh($state){

  switch ($state) {
    case 'start':
    exec('/etc/init.d/autossh start');
    break;

    case 'stop':
    exec('/etc/init.d/autossh stop');
    break;

    case 'enable':
    exec('/etc/init.d/autossh enable');
    break;

    case 'disable':
    exec('/etc/init.d/autossh disable');
    break;
  }

}

function generate_key(){
  exec('ssh-keygen -N "" -f /root/.ssh/id_rsa');
  return "<font color='lime'>Key pair generated. Refresh Tab.</font>";
}

function edit_command($host, $port, $listen){
  exec('uci set autossh.@autossh[0].ssh="-i /etc/dropbear/id_rsa -N -T -R '.$port.':localhost:'.$listen.' '.$host.'"');
  exec('uci commit autossh');
  return "<font color='lime'>AutoSSH configuration updated.</font>";
}

function knownhost($knownhost_user, $knownhost_host){
  exec('/pineapple/components/system/autossh/includes/knownhost.sh '.$knownhost_user.' '.$knownhost_host);
  return "<font color='lime'>Known Host added. Refresh Tab.</font>";
}

function authorizedkeys($authorizedkeys){
  file_put_contents('/root/.ssh/authorized_keys', str_replace("\r", "", $authorizedkeys));
  return '<font color="lime">Authorized Keys updated. Refresh Tab.</font>';
}

function keycopy($ak_user, $ak_host, $ak_password){
  exec('/pineapple/components/system/autossh/includes/copykey.sh '.$ak_user.' '.$ak_host.' '.$ak_password);
  return '<font color="lime">Authorized Key replaced on Remote Host.</font>';
}
?>
