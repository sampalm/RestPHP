<?php 

    class Database {
        private $conn;

        private $psql_host = "localhost";
        private $psql_database = "restapi";
        private $psql_user = "postgres";
        private $psql_pass = "123456";

        private $mysql_host = 'localhost';
        private $mysql_db_name = 'restapi';
        private $mysql_user = 'root';
        private $mysql_pass = '123456';
 

        function connection() {
            $this->conn = null;
            
            try {
                $this->conn = new PDO("pgsql:host={$this->psql_host};port=5432;dbname={$this->psql_database}", $this->psql_user, $this->psql_pass, [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_CASE => PDO::CASE_NATURAL
                ]);
            } catch(PDOException $e){
                echo 'Connection error: '. $e->getMessage();
            }

            return $this->conn;
        }

        function connectionMYSQL() {
            $this->conn = null;
            
            try {
                $this->conn = new PDO("mysql:host={$this->mysql_host};dbname={$this->mysql_db_name}", $this->mysql_user, $this->mysql_pass, [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_CASE => PDO::CASE_NATURAL
                ]);
            } catch(PDOException $e){
                echo 'Connection error: '. $e->getMessage();
            }

            return $this->conn;
        }


    }