<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";
    require_once "src/Student.php";

    $server = "mysql:host=localhost;dbname=university_registrar_test";
    $username = "root";
    $password = "root";
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase {

        protected function tearDown() {
            Course::deleteAll();
            Student::deleteAll();
        }

        function test_save() {
            $name = "Western Civ";
            $number = "HST 101";
            $test_course = new Course($name, $number);

            $test_course->save();
            $result = Course::getAll();

            $this->assertEquals($test_course, $result[0]);
        }

        function test_getAll() {
            $name = "Western Civ";
            $number = "HST 101";
            $test_course = new Course($name, $number);
            $test_course->save();

            $name2 = "Remedial Math";
            $number2 = "MTH 64";
            $test_course2 = new Course($name2, $number2);
            $test_course2->save();

            $result = Course::getAll();

            $this->assertEquals([$test_course, $test_course2], $result);
        }

        function test_deleteAll() {
            $name = "Western Civ";
            $number = "HST 101";
            $test_course = new Course($name, $number);
            $test_course->save();

            $name2 = "Remedial Math";
            $number2 = "MTH 64";
            $test_course2 = new Course($name2, $number2);
            $test_course2->save();

            Course::deleteAll();
            $result = Course::getAll();

            $this->assertEquals([], $result);
        }

        function test_update(){
            $name = "Western Civ";
            $number = "HST 101";
            $test_course = new Course($name, $number);
            $test_course->save();

            $new_name = "Eastern Meds";
            $test_course->update($new_name);

            $this->assertEquals("Eastern Meds", $test_course->getName());
        }

    }
?>
