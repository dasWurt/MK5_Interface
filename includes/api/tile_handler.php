<?php
include('/pineapple/includes/api/tile_functions.php');
//Action handler
if (isset($_GET['action'])) {
  switch ($_GET['action']) {
    case 'get_tiles': 
    get_tiles();
    break;
    case 'get_hidden_tiles': 
    get_hidden_tiles();
    break;
    case 'hide_tile': 
    hide_tile();
    break;
    case 'unhide_tile': 
    unhide_tile();
    break;
  }
}


function hide_tile(){
  $name = htmlspecialchars($_GET['tile']);
  $db = new SQLite3("/etc/pineapple/mk5.db");
  $db->query("INSERT INTO infusions_hidden (name) VALUES ('".$name."');");
  $db->close();
}

function unhide_tile(){
  $name = htmlspecialchars($_GET['tile']);
  $db = new SQLite3("/etc/pineapple/mk5.db");
  $db->query("DELETE FROM infusions_hidden WHERE name='".$name."'");
  $db->close();
}

function get_tiles(){

  $tiles = array();
  $hidden = array();
  $count = 0;


  $db = new SQLite3("/etc/pineapple/mk5.db");
  $db->query("create table if not exists infusions_hidden (ID INT PRIMARY KEY, name TEXT);");
  $result = $db->query("SELECT * FROM infusions_hidden");
  while($row = $result->fetchArray(SQLITE3_ASSOC) ){
    array_push($hidden, $row['name']);
  }
  $db->close();


  $system_dir = opendir('/pineapple/components/system/');
  $infusion_dir = opendir('/pineapple/components/infusions/');


  //Get any system tiles
  while(false !== ($tile = readdir($system_dir))){
    if(file_exists('/pineapple/components/system/'.$tile.'/handler.php') && !in_array($tile, $hidden)){
      $tile_data = array('id' => $count, 'name' => $tile, 'type' => "system");
      array_push($tiles, $tile_data);
      $count++;
    }
  }

  //Get any infusion tiles
  while(false !== ($tile = readdir($infusion_dir))){
    if(file_exists('/pineapple/components/infusions/'.$tile.'/handler.php') && !in_array($tile, $hidden)){
      $tile_data = array('id' => $count, 'name' => $tile, 'type' => "infusions");
      array_push($tiles, $tile_data);
      $count++;
    }
  }

  if(!empty($tiles)){
    echo json_encode($tiles);
  }else{
    echo "none";
  }

}

function get_hidden_tiles(){

  $tiles = array();
  $hidden = array();

  $db = new SQLite3("/etc/pineapple/mk5.db");
  $db->query("create table if not exists infusions_hidden (ID INT PRIMARY KEY, name TEXT);");
  $result = $db->query("SELECT * FROM infusions_hidden");
  while($row = $result->fetchArray(SQLITE3_ASSOC) ){
    array_push($hidden, $row['name']);
  }
  $db->close();

  $system_dir = opendir('/pineapple/components/system/');
  $infusion_dir = opendir('/pineapple/components/infusions/');

  //Get any system tiles
  while(false !== ($tile = readdir($system_dir))){
    if(file_exists('/pineapple/components/system/'.$tile.'/handler.php') && in_array($tile, $hidden)){
      array_push($tiles, $tile);
    }
  }

  //Get any infusion tiles
  while(false !== ($tile = readdir($infusion_dir))){
    if(file_exists('/pineapple/components/infusions/'.$tile.'/handler.php') && in_array($tile, $hidden)){
      array_push($tiles, $tile);
    }
  }

  if(!empty($tiles)){
    echo json_encode($tiles);
  }else{
    echo "none";
  }

}

?>