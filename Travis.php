<?php
$server = proc_open(PHP_BINARY . " src/pocketmine/PocketMine.php --no-wizard", [
//$server = proc_open("./start.sh --no-wizard", [
	0 => ["pipe", "r"],
	1 => ["pipe", "w"],
	2 => ["pipe", "w"]
], $pipes);
if(!is_resource($server)){
	die('Failed to create process');
}
fwrite($pipes[0], "plugins\nclacore help\nstop\n\n");
fclose($pipes[0]);
while(!feof($pipes[1])){
	echo fgets($pipes[1]);
}
fclose($pipes[1]);
fclose($pipes[2]);
echo "\n\nReturn value: ". proc_close($server) ."\n";
if(count(glob("crashdumps/CrashDump*.log")) === 0){
	echo "No Errors Found in CLACore Plugin By CLADevs.";
	exit(0);
}else{
	echo "Please report the error in issue bar in our github CLADevs Plugin CLACore";
	exit(1);
}
