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

$table_info_file = $argv[1];
$table_info_dir = $argv[2];

$tables = json_decode(file_get_contents($table_info_file), 1);
$creates = array();

foreach($tables as $table_name => $pkey_list){
	if(is_file($table_info_dir."/".$table_name.".json")){
		$creates_columns = array();
		$table_columns = json_decode(file_get_contents($table_info_dir."/".$table_name.".json"), 1);
		// sort column by ordinal_position
		$table_columns_sorted = array();
		$table_columns_size = sizeof($table_columns);
		foreach($table_columns as $column){
			$table_columns_sorted[$column['ordinal_position']] = $column;
		}
		for($i = 1; $i <= $table_columns_size; $i++){
			$column = $table_columns_sorted[$i]['column_name'];
			$column .= " ".$table_columns_sorted[$i]['data_type'];
			$column .= $table_columns_sorted[$i]['character_maximum_length'] == "" ? "" : "(".$table_columns_sorted[$i]['character_maximum_length'].")" ;
			$column .= $table_columns_sorted[$i]['column_default'] == "" ? "" : " DEFAULT ".$table_columns_sorted[$i]['column_default'] ;
			$column .= $table_columns_sorted[$i]['is_nullable'] == "YES" ? "" : " NOT NULL" ;
			$creates_columns[] = $column;
		}
		if(!empty($pkey_list)){
//			print_r($pkey_list);
			$pkey_name_list = array();
			foreach($pkey_list as $key_info){
				$pkey_name_list[] = $key_info['attname'];
			}
			$creates_columns[] = "CONSTRAINT ".$table_name."_pkey PRIMARY KEY (".implode(", ", $pkey_name_list).")";
		}
		$creates[$table_name] = "CREATE TABLE ".$table_name." (";
		$creates[$table_name] .= implode(", \n", $creates_columns);
		$creates[$table_name] .= ") WITH (OIDS=FALSE);";
//		echo $creates[$table_name];
	}
	if(isset($argv[3])){
		file_put_contents($argv[3], implode("\n", $creates));
	}else{
		foreach($creates as $table){
			echo $table."\n";
		}
	}
}

?>