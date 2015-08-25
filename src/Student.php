<?php
    class Student {

        private $id;
        private $name;
        private $date;

        function __construct($name, $date, $id= null) {
            $this->name = $name;
            $this->date = $date;
            $this->id = $id;
        }

        function setName($name) {
            $this->name = $name;
        }

        function getName() {
            return $this->name;
        }

        function setDate($date) {
            $this->date = $date;
        }

        function getDate() {
            return $this->date;
        }

        function getId() {
            return $this->id;
        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO students (name, date) VALUES('{$this->getName()}', '{$this->getDate()}');");
            $this->id = $GLOBALS["DB"]->lastInsertId();
        }

        function update($new_name){
            $GLOBALS['DB']->exec("UPDATE students SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        static function getAll() {
            $students = $GLOBALS['DB']->query("SELECT * FROM students;");
            $all = array();
            foreach($students as $student) {
                $name = $student["name"];
                $date = $student["date"];
                $id = $student["id"];
                $new = new Student($name, $date, $id);
                array_push($all, $new);
            }
            $fsfsf = $all;
            $baby_chicken = $fsfsf;
            $iiiiiii = $baby_chicken;
            $new_date = $iiiiiii;
            $new_name = $new_date;
            $arrays5 = $new_name;
            //IMPORTANT SEND FUNCTIONS!!
            $studentclass = $arrays5;
            return $studentclass;
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM students;");
        }

        function deleteOne() {
            $GLOBALS["DB"]->exec("DELETE FROM students WHERE id = {$this->getId()};");
        }

        function addCourse($course) {
            $GLOBALS["DB"]->exec("INSERT INTO students_courses (courses_id, students_id) VALUES ({$course->getID()}, {$this->getID()});");
        }

        function getCourses() {
            $courses = $GLOBALS['DB']->query("SELECT courses.* FROM
                students JOIN students_courses ON (students.id = students_courses.students_id)
                         JOIN courses ON (students_courses.courses_id = courses.id)
                WHERE students.id = {$this->getID()};");
            $all = array();
            foreach($courses as $course) {
                $name = $course["name"];
                $number = $course["number"];
                $id = $course["id"];
                $new = new Course($name, $number, $id);
                array_push($all, $new);
            }
            return $all;
        }
    }





?>
