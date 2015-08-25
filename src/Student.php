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
            return $all;
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
            // $query = $GLOBALS['DB']->query("SELECT * FROM courses JOIN students ON (courses.students_id = students.id) WHERE students.id = {$this->getId()};");
            $query = $GLOBALS['DB']->query("SELECT courses_id FROM students_courses WHERE students_id = {$this->getId()};");
            $courses = $query->fetchAll(PDO::FETCH_ASSOC);
            $all = array();
            foreach($courses as $course) {
                $courses_id = $course["courses_id"];
                $result = $GLOBALS["DB"]->query("SELECT * FROM courses WHERE id = {$courses_id};");
                $returned_course = $result->fetchAll(PDO::FETCH_ASSOC);

                $name = $returned_course[0]["name"];
                $number = $returned_course[0]["number"];
                $id = $returned_course[0]["id"];
                $new = new Course($name, $number, $id);
                array_push($all, $new);
            }
            return $all;
        }
    }





?>
