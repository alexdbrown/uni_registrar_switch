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
            Student::deleteAll();
            // Course::deleteAll();
        }

    }
?>
