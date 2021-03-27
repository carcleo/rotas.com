<?php

namespace mvc\models;

use DateTime;

class ContactsModel extends Model {

        protected $table = "contacts";
        
        private $name;
        private $tel;
        private $email;
        private $subject;
        private $message;
        private $datetime;

        ///////////////SETTERS///////////////
        public function setName(string $name) : void {
            $this->name = $name;
        }

        public function setTel(?int $tel) : void {
            $this->tel = $tel;
        }

        public function setEmail(string $emal) : void {
            $this->email = $emal;
        }

        public function setSubject(string $subject) : void {
            $this->subject = $subject;
        }

        public function setMessage(string $message) : void {
            $this->message = $message;
        }

        public function setDatetime(DateTime $dateTime) : void {
            $this->dateTime = $dateTime;
        }

        ///////////////SETTERS///////////////
        public function getName() : string {
           return $this->name;
        }

        public function getTel() : ?int {
           return $this->tel;
        }

        public function getSubject() : string {
           return $this->subject;
        }

        public function getEmail() : string {
           return $this->email;
        }

        public function getMessage() : string {
           return $this->message;
        }

        public function getDatetime() : Datetime {
            return $this->datetime;
        }

        ///////////////METHODS///////////////
 
    }