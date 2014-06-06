<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<h2>Task manager:</h2>
<pre>
<?php
$cmd = "ps";
exec ($cmd, $output);
foreach($output as $line){
        $lineArray = explode(" ", trim($line));
        $pid = $lineArray[0];
        if($pid != "PID") echo "<a href='#sys/resources/kill/$pid/kill_proc'>Kill</a> ".$line."\n";
        else echo "    ".$line."\n";
}
$output = "";
?>
</pre>