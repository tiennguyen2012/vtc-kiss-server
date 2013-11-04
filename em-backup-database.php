<?php
include "/home/account.php";
$date = date('Y-m-d');
$folderBackup = "/home/backup/em.traveldreams.vn";
$pathOfData = "/home/web/data";

$enviroments = array('dev', 'test', 'staging', 'live');

foreach($enviroments as $item) {
	// Create folder for stucture
	createBackupStructure($date, $folderBackup);

	// Backup Database
	dumpSQL($item.".em.traveldreams.vn", 
		$item.".em.traveldreams.vn_".$date, 
		$folderBackup."/".$date.'/database');

	// Backup Data
	zipData($pathOfData.'/'.$item.'.em.traveldreams.vn', 
		$folderBackup."/".$date."/data/".$item.'.em.traveldreams.vn_'. $date.".zip");	
}

/**
* Create structure for backup
*/
function createBackupStructure($name, $path) {
	if(!is_dir($path.'/'.$name)) {
		mkdir($path.'/'.$name);

		// Create folder database
		mkdir($path.'/'.$name.'/database');
		// Create folder data
		mkdir($path.'/'.$name.'/data');
	}
}

/**
* Zip data
*/
function zipData($path, $direction) {
	exec("zip -r ".$direction." ".$path);
}

/**
* DumpSQL
*/
function dumpSQL($databaseName, $newDatabaseName, $path) {
	global $database_username;
	global $database_password;
	exec("mysqldump -h localhost -u ".$database_username." -p".$database_username." ".
		$databaseName." > ".$path."/".$newDatabaseName.".sql");
}