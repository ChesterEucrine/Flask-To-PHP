<?php 

// Use get Variable to print image
$image = '';
if (isset($_GET['fileName'])) {
	$image = "UPLOAD_FOLDER/".$_GET['fileName'].".png";
	echo "
		<!DOCTYPE html>
		<html>
		<head>
			<title>Uploads</title>
		</head>
		<body>
			<h1>Uploaded File</h1>
			<img src='$image' alt='Uploaded File'>
		</body>
		</html>
	";
} else {
	echo "
		<!DOCTYPE html>
		<html>
		<head>
			<title>Uploads</title>
		</head>
		<body>
			<h1>Get Image</h1>
			<form method='GET'>
				<label for='fileName'>File Name</label>
				<input type='text' name='fileName'>
				<button type='submit'>Submit</button>
			</form>
		</body>
		</html>
	";
}	
?>
