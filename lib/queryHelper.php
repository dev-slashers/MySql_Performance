<?php
/**
 * Class QueryHelper
 * Bind Param Accept:
 * i - integer
 * d - double
 * s - string
 * b - BLOB
 */
class QueryHelper {

        private $conn;
        private  $lastID ;

        function __construct()
        {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "test";

            // Create connection
            $this->conn = new mysqli($servername, $username, $password, $dbname);
        }


        /**
         * @return string
         */
        public function getTime() {
            $micro_date = microtime();
            $date_array = explode(" ",$micro_date);
            $date = date("H:i:s",$date_array[1]);
            return $date.":". $date_array[0];
        }

        /**
         * @return last ID to database
         */
        public function getLastID() {
            if(!isset($this->lastID)) {
                $query = $this->conn->query("SELECT id FROM `prova` ORDER BY `prova`.`id` DESC LIMIT 1");
                $this->lastID = $query->fetch_assoc()["id"];
            }
            return $this->lastID;
        }


        /**
         * @param int $length
         * @return string
         * Return random string
         */
        private function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }


        /**
         * @param $defaultName
         * @param $defaultSurname
         * @return float|int
         */
        public function updateDatabase($defaultName, $defaultSurname) {
            $stmt = $this->conn->prepare("UPDATE prova SET  name = ? , surname = ? where id = ?");
            for($i = 1; $i <= $this->getLastID(); $i++) {
                $stmt->bind_param("ssi", $defaultName, $defaultSurname, $i);
                $stmt->execute();
            }
        }


        /**
         * @param $defaultName
         * @param $defaultSurname
         */
        public function updateDatabase_UsingMultiQuery($defaultName, $defaultSurname) {
            $query = "";
            for($i = 1; $i <= $this->getLastID(); $i++) $query .= "UPDATE prova SET  name = ".$defaultName." , surname = ".$defaultSurname." where id = ".$i.";";
            if($query != "") mysqli_multi_query($this->conn, $query);
        }



        /**
         * @param $number_colum
         * @return float Time Execution
         */
        public function seedDatabase($number_colum) {
            $stmt =  $this->conn->prepare("INSERT INTO prova (name, surname) VALUES (?, ?)");
            for($i = 1; $i <= $number_colum;$i++) {
                $firstname = $this->generateRandomString(10);
                $lastname = $this->generateRandomString(10);
                $stmt->bind_param( "ss",$firstname, $lastname);
                $stmt->execute();
                if($i === $number_colum) $this->lastID = $stmt->insert_id;
            }
        }


        /**
         * Truncate Database
         */
        public function truncateDatabase() {
            $this->conn->query("TRUNCATE prova;");
        }
    }