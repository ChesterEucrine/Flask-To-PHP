<?php


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
    <title>Submit JSON Information</title>
</head>
<body>
    <div class="form-container">
    <form method="POST" ectype="file/something">
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
