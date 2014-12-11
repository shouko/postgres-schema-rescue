<?php
if(!(isset($argv[1])&&isset($argv[2]))){
	echo "Missing Parameter: Please refer to README.md for usage\n";
	exit();
}
if(!(is_file($argv[1])&&file_exists($argv[2]))){
	// is_file only returns TRUE for file, while file_exists returns TRUE for directory too
	echo "File or directory designated does not exist.\n";
	exit();
}

$table_info_file = $arvg[1];
$table_info_dir = $arvg[2];

$tables = json_decode(file_get_contents($table_info_file));

foreach($tables as $table){
	
}

?>