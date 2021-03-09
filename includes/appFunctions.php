<?php

class App {
	private $PASSWORD_FILE = "PASSWORD_HASH_DO_NOT_COMMIT";

	public function change_password($newPassword) {
		$file = fopen($PASSWORD_FILE, "w");
		$update = hash("sha256", $newPassword);
		fwrite($file, $update);
		fclose($file);
		return 0;
	}

	public function is_correct_password($password) {
		if (!file_exists($PASSWORD_FILE)) {
			echo "Advisor password not set.";
			return false;
		} else {
			$file = fopen($PASSWORD_FILE, "r");
			$correctPasswordHash = fread($file);
			return password_verify($password, $correctPasswordHash);
		}
	}

	public function has_filetype($filename, $filetype) {
		$temp = explode($filename, '.');
		if (str_contains($filename, '.') && (end($temp) == $filetype)) {
			return true;
		}
		return false;
	}
}
