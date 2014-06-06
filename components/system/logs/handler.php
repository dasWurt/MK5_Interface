<?php
#########################
#    User Variables     #
#   Please edit these   #
#########################
$name = 'Logs';  #Name of tile
$updatable = 'true';  #Should this tile auto-refresh
$version = '1.3';


#########################
#     Handler Code      #
# No need to edit below #
#########################

#Set up handler functions and data
include('/pineapple/includes/api/tile_functions.php');
$directory = realpath(dirname(__FILE__)).'/';
$rel_dir = str_replace('/pineapple', '', $directory);
include('/pineapple/includes/api/handler_helper.php');

?>  