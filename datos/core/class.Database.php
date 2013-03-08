<?php

   include_once 'config.php';
   
   class Database {
      
      protected $db_conn;
      
      public $db_host = DB_HOST;
      public $db_user = DB_USER;
      public $db_pass = DB_PASS;      
      public $db_name = DB_NAME;
      
      function connect() {
         try {
            $this->db_conn = new PDO( "mysql:host = $this->db_host; dbname = $this->db_name", $this->db_user, $this->db_pass);
            return $this->db_conn;
         } catch ( PDOException $e ) {
            return $e->getMessage();
         }
      }

   }
?>
