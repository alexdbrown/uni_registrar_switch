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

    class StudentTest extends PHPUnit_Framework_TestCase {

        protected function tearDown() {
            Student::deleteAll();
            Course::deleteAll();
        }

        function test_save() {
            $name = "Chris";
            $date = "1111-11-11";
            $test_student = new Student($name, $date);

            $test_student->save();
            $result = Student::getAll();

            $this->assertEquals($test_student, $result[0]);
        }

        function test_getAll() {
            $name = "Chris";
            $date = "1111-11-11";
            $test_student = new Student($name, $date);
            $test_student->save();

            $name2 = "Dillon";
            $test_student2 = new Student($name2, $date);
            $test_student2->save();

            $result = Student::getAll();

            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function test_deleteAll() {
            $name = "Chris";
            $date = "1111-11-11";
            $test_student = new Student($name, $date);
            $test_student->save();

            $name2 = "Dillon";
            $test_student2 = new Student($name2, $date);
            $test_student2->save();

            Student::deleteAll();
            $result = Student::getAll();

            $this->assertEquals([], $result);
        }

        function test_update(){
            $name = "Chris";
            $date = "1111-11-11";
            $test_student = new Student($name, $date);
            $test_student->save();

            $new_name = "Chris the Jerk";
            $test_student->update($new_name);

            $this->assertEquals("Chris the Jerk", $test_student->getName());
        }

        function test_deleteOne() {
            $name = "Chris";
            $date = "1111-11-11";
            $test_student = new Student($name, $date);
            $test_student->save();

            $name2 = "Dillon";
            $test_student2 = new Student($name2, $date);
            $test_student2->save();

            $test_student->deleteOne();

            $this->assertEquals(Student::getAll(), [$test_student2]);
        }

        function test_addCourse() {
            $name = "Western Civ";
            $number = "HST 101";
            $test_course = new Course($name, $number);
            $test_course->save();


            // $name2 = "Remedial Math";
            // $number2 = "MTH 64";
            // $test_course2 = new Course($name2, $number2);
            // $test_course2->save();

            $name = "Chris";
            $date = "1111-11-11";
            $test_student = new Student($name, $date);
            $test_student->save();

            $test_student->addCourse($test_course);
            //$test_student->addCourse($test_course2);

            $this->assertEquals($test_student->getCourses(), [$test_course]);
        }

    }
?>
