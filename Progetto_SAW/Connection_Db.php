<?php
    class Connector_DB{
        private $_conn = null;

        public function __construct(){
            $connection = mysqli_connect("127.0.0.1", "root", "", "database_saw");               
            if (!$connection)
            {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
            $this->_conn = $connection;;
        }
        
        public function getConnection(){

            return $this->_conn;;
                    
        }
    }   
?> 