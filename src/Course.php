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

        }

        static function getAll() {

        }

        static function deleteAll() {

        }
    }





?>
