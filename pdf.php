<?php 

require_once('includes/appFunctions.php');
require_once('vendor/autoload.php');

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    
    $flowChartName = $_POST['flowChartName'];
    $file = $_FILES['file'];

    $app = new App();
    $targetDir = "./uploads/";
    $fileName = "file";
    $newFileName = $_POST['flowChartName'];

    // Verify password
    if (!$app->is_correct_password($password))
	    die("Unauthorized: incorrect password");

    // Save file to upload folder
    $result = $app->saveFileAs($targetDir, $fileName, $newFileName, $_FILES);

    if ($result == 0) {
	// Convert PDF to png if file is a pdf
	    if ($result['isPDF'] == 0) {
		$fileDest = $result['fileDest']
		$pdf = new Spatie\PdfToImage\Pdf($fileDest);
		echo "Upload file: $newFileName (rename to $newFileName)";
		$pdf->saveImage($targetDir.$newFileName."png");
		// Delete pdf
		exec("rm $fileDest");
	}
    } else {
	    echo $result['error'];
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Submit PDF File</title>
</head>
<body>
    <div class="form-container">
    <form method="POST" ectype="file/something">
        <div>
            <label for="flowChartName">Flow Chart Name</label>
            <input type="text" name="flowChartName" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <input type="file" name="file" required>
        </div>
        <div>
            <button type="submit" name="submit">Submit</button>
        </div>
    </form>
    </div>
</body>
</html>
