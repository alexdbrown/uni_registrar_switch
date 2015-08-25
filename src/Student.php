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
        }

        static function getAll() {

        }

        static function deleteAll() {

        }

    }





?>
