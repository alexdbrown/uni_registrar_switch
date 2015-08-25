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

    }





?>
