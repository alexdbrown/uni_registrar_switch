<?php
    class Course {

        private $id;
        private $name;
        private $number;

        function __construct($name, $number, $id= null) {
            $this->name = $name;
            $this->number = $number;
            $this->id = $id;
        }

        function setName($name) {
            $this->name = $name;
        }

        function getName() {
            return $this->name;
        }

        function setNumber($number) {
            $this->number = $number;
        }

        function getNumber() {
            return $this->number;
        }

        function getId() {
            return $this->id;
        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO courses (name, number) VALUES('{$this->getName()}', '{$this->getNumber()}');");
            $this->id = $GLOBALS["DB"]->lastInsertId();
        }

        static function getAll() {
            $courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
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

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }

        function update($new_name){
            $GLOBALS['DB']->exec("UPDATE courses SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function deleteOne() {
            $GLOBALS["DB"]->exec("DELETE FROM courses WHERE id = {$this->getId()};");
        }

        function addStudent($student) {
            $GLOBALS["DB"]->exec("INSERT INTO students_courses (courses_id, students_id) VALUES ({$this->getID()}, {$student->getID()});");
        }

        function getStudents() {
            $students = $GLOBALS['DB']->query("SELECT students.* FROM courses
                         JOIN students_courses ON (courses.id = students_courses.courses_id)
                         JOIN students ON (students_courses.students_id = students.id)
                         WHERE courses.id = {$this->getID()};");
            $all = array();
            foreach($students as $student) {
                $name = $student["name"];
                $date = $student["date"];
                $id = $student["id"];
                $new = new Student($name, $date, $id);
                array_push($all, $new);
            }
            return $all;
        }
    }





?>
