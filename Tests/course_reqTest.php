<?php

require_once "includes/DatabaseHelper.php";

class Course_ReqTest extends PHPUnit\Framework\TestCase {
	public function testConstructor() {
		$expCourse_no = "CS3340";
		$expCourse_prereq = "2 CS2305 CS1337";
		$expCourse_coreq = "0";

		$course = new Course_Req("CS3340", "2 CS2305 CS1337", "0");

		// Asser Values
		$this->assertEquals($expCourse_no, $couse->course_no);
		$this->assertEquals($expCourse_prereq, $course->course_prereq);
		$this->assertEquals($expCourse_coreq, $course->course_coreq);
	}
}
