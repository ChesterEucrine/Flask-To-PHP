<?php
	
	class Student {
		public $netid;
		public $first_name;
		public $last_name;
		public $flowchart;
		
		public function __construct($netid, $first_name, $last_name, $flowchart) {
			$this->netid = $netid;
			$this->first_name = $first_name;
			$this->last_name = $last_name;
			$this->flowchart = $flowchart;
		}
	}
	
	class Course_Req {
		public $course_no;
		public $course_prereq;
		public $course_coreq;
		
		public function __construct($course_no, $course_prereq, $course_coreq) {
			$course_req->course_no = $course_no;
			$course_req->course_prereq = $course_prereq;
			$course_req->course_coreq = $course_coreq;
		}
	}
	
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
		
		// Function to create student and course tables
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
		
		// add student to database
		public function addRowToStudent($student) {
			if ($this->isStudentTableCreated()) {
				$sql = "INSERT INTO student VALUES (
					$student->netid,
					$student->first_name,
					$student->last_name,
					$student->flowchart
				)";
				
				try {
					$result = $this->database->query($sql);
					echo "Student successfully added<br>";
				} catch (PDOException $e) {
					echo "Failed to add Student to table<br>";
					echo $sql."<br>".$e->getMessage();
				} 
			} else
				echo "Could not add student<br>
							err: student table not created<br>";
		}
		
		
		// add course requirements to database
		public function addRowToCourse_req($course_req) {
			if ($this->isCourse_reqTableCreated()) {
				$sql = "INSERT INTO course_req VALUES (
					$course_req->course_no,
					$course_req->course_prereq,
					$course_req->course_coreq
				)";
				
				try {
					$result = $this->database->query($sql);
					echo "Course Requirement successfully added<br>";
				} catch (PDOException $e) {
					echo "Failed to add Course Requirement to table<br>";
					echo $sql."<br>".$e->getMessage();
				} 
			} else
				echo "Could not add student<br>
							err: student table not created<br>";
		}
		
		// TODO
			// Functions Check if tables and database exists
		public function isCourse_reqTableCreated() {
			$sql = "DESC student";
			try {
				$this->database->query($sql);
				return true;
			} catch (PDOException $e) {
				return false;
			}
		}
		
		public function isStudentTableCreated() {
			$sql = "DESC course_req";
			try {
				$this->database->query($sql);
				return true;
			} catch (PDOException $e) {
				return false;
			}
		}
	}
	
	
?>
