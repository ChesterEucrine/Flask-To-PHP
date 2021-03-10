<?php

function saveFileAs($targetDir, $fileName, $newFileName, $files) {
    $fileType = $files[$fileName]['type'];
    $fileSize = $files[$fileName]['size'];
    $fileTmpName = $files[$fileName]['tmp_name'];
    $fileError = $files[$fileName]['error'];

    // Check file extension
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    // Allowed File Formats
    $allowed = $array('jpg', 'jpeg', 'png', 'pdf');

    if in_array($fileActualExt, $allowed) {
      if ($fileError === 0) {
        // File Size Limit
        if ($fileSize <= 20000) {
          $newFileName = $newFileName.".".$fileActualExt;
          $fileDest = $targetDir.$newFileName;
          if (move_uploaded_file($fileTmpName, $target_file)) {
            return 0;
          } else {
            return 4;
          }
        } else {
          return 3;
        }
      } else {
        return 2;
      }
    } else {
      return 1;
    }
}

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $flowChartName = $_POST['flowChartName'];
    $file = $_FILES['file'];

    // Save file to upload folder
    // After checking if it is safe

    // convert file from pdf to image if it not an image
    // delete pdf
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
