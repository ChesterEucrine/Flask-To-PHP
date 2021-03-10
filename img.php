<?php 

// Use get Variable to print image
$image = '';
if (isset($_GET['fileName']))
	$image = "UPLOAD_FOLDER/".$_GET['fileName'];

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
?>
