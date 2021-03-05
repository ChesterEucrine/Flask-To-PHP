<?php
	
		
	class DatabaseHelper {
		// Login credentials
		private $host='';
		private $user='';
		private $pass='';
		private $dbname='';
	
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
		
		// Initialize Login credentials
		public function __construct($host="oitdb521d.utdallas.edu", $user, $pass, $dbname="ecs_degreeaudit") {
			$this->host = $host;
			$this->user = $user;
			$this->pass = $pass;
			$this->dbname = $dbname;
		}
		
		// Set up database using given user login credentials
		// Connect to an existing database;
		public function setupDatabaseFromExisting() {
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
		
		// Set up database using given user login credentials
		// Create a new database
		public function setupDatabaseNew() {
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
				$sql = 'CREATE DATABASE '.$this->dbname." DEFAULT CHARACTER SET 'utf8'";
				// use exec() because no results are returned
				$this->database->exec($sql);
				echo "Database $this->dbname created successfully<br>";
			} catch(PDOException $e) {
			  echo "Failed creating database: $this->dbname<br>";
				echo $sql."<br>".$e->getMessage();
			}
		}
	}
	
	
?>
