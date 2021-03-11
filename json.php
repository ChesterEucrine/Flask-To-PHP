<?php

require_once('includes/appFunctions.php');

$json_folder = "./JSON_FOLDER/";

if (isset($_POST['submit'])) {
    $password = $_POST['password'];

    $app = new App();

    // Verify Password
    if (!$app->is_correct_password($password))
	    die("Incorrect Advisor Password");

    $filePath = $json_folder.$_POST['fileName'].".json";

    $file = fopen($filePath, 'w') or die("Could Not open JSON file");

    fwrite($file, $_POST['body']); 
    echo "ok";
}

if (isset($_GET['fileName'])) {
    $fileDest = $json_folder.$_GET['fileName'];
    if (file_exists($filesDest)) {
	$file = fopen($fileDest, 'r');
	echo fread($file, filesize($fileDest));
    } else {
	echo "[]";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Submit JSON Information</title>
</head>
<body>
    <div class="form-container"> 
    <form method="POST" enctype="multipart/form-data">
        <div>
            <label for="fileName">File Name</label>
            <input type="text" name="fileName" required>
        </div> 
        <div>
            <label for="body">Body</label>
            <input type="text" name="body" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </div>
        <!--div>
            <input type="file" name="file" required>
        </div-->
        <div>
            <button type="submit" name="submit">Submit</button>
        </div>
    </form>
    </div>
</body>
</html>
