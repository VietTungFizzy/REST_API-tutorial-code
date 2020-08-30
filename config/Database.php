<?php
    class Database {
        //DB params
        private $host = 'localhost';
        private $db_name = 'rest_api_test';
        private $username = 'root';
        private $password = '';
        private $conn;


        // connect to database in mysql through PDO
        //
        // @Param:
        // 
        // @return: PDO
        public function connect() {
            $this->connect = null;

            try {
               $this->connect = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->username, $this->password);
               $this->connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo 'Connecting error: '. $e->getMessage();
            }

            return $this->connect;
        }
    }
?>