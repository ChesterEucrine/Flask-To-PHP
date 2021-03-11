<?php

class App {
	private $PASSWORD_FILE = "PASSWORD_HASH_DO_NOT_COMMIT";

	public function change_password($newPassword) {
		$file = fopen($this->PASSWORD_FILE, "w");
		$update = hash("sha256", $newPassword);
		fwrite($file, $update);
		fclose($file);
		return 0;
	}

	public function is_correct_password($password) {
		if (!file_exists($this->PASSWORD_FILE)) {
			echo "Advisor password not set.";
			return false;
		} else {
			$file = fopen($this->PASSWORD_FILE, "r");
			$correctPasswordHash = fread($file, filesize($this->PASSWORD_FILE));
			return password_verify($password, $correctPasswordHash);
		}
	}

	// Function to validate file type
	// Redundant for saving files since $_FILES array
	// contains file type
	public function has_filetype($filename, $filetype) {
		$temp = explode($filename, '.');
		if (str_contains($filename, '.') && (end($temp) == $filetype)) {
			return true;
		}
		return false;
	}


	// Function to save file from form as a given fileName
	// Can also decide targetDirectory to save file
	// Returns an array with
	// 	result : 0, 1, 2, 3, 4, 5
	// 	error : message
	// 	fileDest : if successful, path to file using given $targetDir
	public function saveFileAs($targetDir, $fileName, $newFileName, $files) {
		$fName = $files[$fileName]['name'];
		$fileType = $files[$fileName]['type'];
		$fileSize = $files[$fileName]['size'];
		$fileTmpName = $files[$fileName]['tmp_name'];
		$fileError = $files[$fileName]['error'];

		// Check file extension
		$fileExt = explode('.', $fName);
		$fileActualExt = strtolower(end($fileExt));

		// Allowed File Formats
		$allowed = array('png', 'pdf');

		// output array
		$ouput = array();
		if (in_array($fileActualExt, $allowed)) {
			if ($fileError === 0) {
				// File Size Limit
				if ($fileSize <= 20000000) {
					$newFileName = $newFileName.".".$fileActualExt;
					if (preg_match('/^[\/\w\-. ]+$/', $fName)) {
						$fileDest = $targetDir.$newFileName;
						if (move_uploaded_file($fileTmpName, $fileDest)) {
							$output['result'] = 0;
							$output['fileDest'] = $fileDest;
							$output['isPDF'] = -1;
							if ($fileActualExt == 'pdf')
								$output['isPDF'] = 0;
						} else {
							$output['error'] = 'could not move and rename temporary file version to upload directory';
							$output['result'] = 1;
						}
					} else {
						$output['error'] = 'Invalid File Name';
						$output['result'] = 2;
					}
				} else {	
					$output['error'] = 'File is greater than 20Mb';
					$output['result'] = 3;
				}
			} else {
				$output['error'] = 'Error while uploading file';
				$output['result'] = 4;
			}
		} else {
			$output['error'] = 'File extension not allowed: Only pdf or png';
			$output['result'] = 5;
		}
		return $output;
	}
}
