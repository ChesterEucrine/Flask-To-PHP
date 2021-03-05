<?php

require_once "DatabaseHelper.php";

	class studentTest extends PHPUnit\Framework\TestCase {
		public function testConstructor() {
			$expectedNetid = "12";
			$expectedFullName = "Test";
			$expectedLastName = "Name";
			$expectedFlowChart = json_encode(array("text"=>"example", "array"=>array("sub"=>"example2")));

			$flowchart = json_encode(array("text"=>"example", "array"=>array("sub"=>"example2")));
			$student = new Student("12", "Test", "Name", $flowchart);
			// Assert Values
			$this->assertEquals($expectedNetid, $student->netid);
			$this->assertEquals($expectedFullName, $student->full_name);
			$this->assertEquals($expectedLastName, $student->last_name);
			$this->assertEquals($expectedFlowChart, $student->flowchart);
	}
