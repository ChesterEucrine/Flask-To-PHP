<?php
require_once "include/DatabaseHelper.php";
// Receive password and username from post request

$DB_NAME = 'ecs_degreeaudit'; # database name
$HOST = 'oitdb521d.utdallas.edu'; # 127.0.0.1 also works as host
if (isset($_POST['uInput']) && isset($_POST['pInput'])) {
	$uInput = $_POST['uInput'];
	$pInput = $_POST['pInput'];
	
	// Initialize variable in class
	$helper = new DatabaseHelper($HOST, $uInput, $pInput, $DB_NAME);
	// connect to database
	$helper->setupDatabaseFromExisting();
	// TODo
	// 	Receive Data from $_POST and insert or update post
} else {
	echo "User info not given";
}
