<?php
	class DatabaseHelper {
		// Login credentials
		private $host='oitdb521d.utdallas.edu';
		private $user='';
		private $pass='';
		private $dbname='ecs_degreeaudit';
	
		// How to query to database examples:
		// $this->result = $this->database->query(
		//				"SELECT * FROM students");
		// $this->result = $this->database->exec(
		//				"SELECT * FROM students");
		// Keeps one result at a time
		
		// Class variables
		private $database;
		private $result;
		//private $testPassword;
		//private $testUser;
		//private $error;
		
		/* Set up database using given user login credentials
		public function __construct($host, $user, $pass, $dbname) {
			$this->host = $host;
			$this->user = $user;
			$this->pass = $pass;
			$this->dbname = $dbname;
			
			$dsn =	'mysql:host='.$this->host.
							';dbname='.$this->dbname;
			try {	
				$options = array(
					PDO::ATTR_PERSISTENT=>true,
					PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
				
				$this->database = new PDO($dsn,
					$this->user,
					$this->pass, 
					$options);
				echo "Successfully Setup Database";
			} catch (PDOException $e) {
				echo "Unable to Setup Database connection using given
							login credentialsbr>$e->getMessage()";
			}
		}
		
		// Constructor for preset login credentials
		public function __construct() {
			$dsn =	'mysql:host='.$this->host.
							';dbname='.$this->dbname;
			try {
				$options = array(
					PDO::ATTR_PERSISTENT=>true,
					PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
				
				$this->database = new PDO($dsn,
					$this->user,
					$this->pass, 
					$options);
				echo "Successfully Setup Database using preset
							login credentials";
			} catch (PDOException $e) {
				echo "Unable to Setup Database connection using preset
							login credentialsbr>$e->getMessage()";
			}
		}
		
		// Constructor for preset $host and $dbname
		public function __construct($user, $pass) {
			$this->user = $user;
			$this->pass = $pass;
			
			$dsn =	'mysql:host='.$this->host.
							';dbname='.$this->dbname;
			try {
				$options = array(
					PDO::ATTR_PERSISTENT=>true,
					PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
				
				$this->database = new PDO($dsn,
					$this->user,
					$this->pass, 
					$options);
				echo "Successfully Setup Database using preset
							host and database name";
			} catch (PDOException $e) {
				echo "Unable to Setup Database connection using preset
							host and database namebr>$e->getMessage()";
			}
		}*/
		
		// Constructor for preset $host
		public function __construct($dbname, $user, $pass) {
			$this->user = $user;
			$this->pass = $pass;
			$this->dbname = $dbname;
			
			try {
				$dsn =	'mysql:host='.$this->host;
				$options = array(
					PDO::ATTR_PERSISTENT=>true,
					PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
				
				$this->database = new PDO($dsn,
					$this->user,
					$this->pass, 
					$options);
				$this->createDatabase();
			} catch (PDOException $e) {
				echo "Unable to Create Database $this->dbname
							<br>$e->getMessage()";
			}
		}
		
		// Create database using $this->dbname
		public function createDatabase() {
			try {
				$sql = 'CREATE DATABASE '.$this->dbname;
				// use exec() because no results are returned
				$this->database->exec($sql);
				echo "Database $this->dbname created successfully<br>";
			} catch(PDOException $e) {
				echo $sql."<br>".$e->getMessage();
			}
		}
		
		// Function to create student and course tables
		// TODO error checks
		public function createTable() {
			// student table:
			$sql = "CREATE TABLE `student` (
				`netid` VARCHAR(9) PRIMARY KEY,
				`first_name` VARCHAR(16) NOT NULL,
				`last_name` VARCHAR(16) NOT NULL,
				`flowchart` JSON DEFAULT NULL
			)";
			try {
				$this->result = $this->database->query($sql);
				echo "student Table Successfully Created<br>";
			} catch (PDOException $e) {
				echo $sql."<br>".$e->getMessage();
			}
			
			// course_req table:
			$sql = "CREATE TABLE `course_req` (
				`course_no` VARCHAR(9) PRIMARY KEY,
				`course_prereq` VARCHAR(64),
				`course_corq` VARCHAR(64)
			)";
			try {
				$this->result = $this->database->query($sql);
				echo "course_req Table Successfully Created<br>";
			} catch (PDOException $e) {
				echo $sql."<br>".$e->getMessage();
			}
		}
		
		// TODO
			// Functions Check if tables and database exist
	}
	
	
?>
