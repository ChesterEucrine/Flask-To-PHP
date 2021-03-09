<?php
require_once 'includes/appFunctions.php';

$functions = new App;

if (isset($_POST['submit']) {
	if (!is_correct_password($_POST['password'])) {
		echo "Unauthorized: incorrect password";
	} else if (isset($_FILES['file']) {
	# check if the post request has the file part
		echo "file no part";
	} else if () {

	}
} else {
	
}	
