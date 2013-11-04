<?php
$date = date('y-m-d');
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
	exec("mysqldump -h localhost -u root -p  ".$databaseName.".sql > ".$path."/".$newDatabaseName.".sql");
}