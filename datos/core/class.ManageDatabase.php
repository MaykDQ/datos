<?php

   class ManageDatabase {
      
      public $link;
      
      function __construct() {
         include_once 'class.Database.php';
         $conn = new Database();
         $this->link = $conn->connect();
         return $this->link;
      }    
   
   
      function getData( $table_name, $id = null) {
         if( isset( $id ) ) {
            $query = $this->link->query( "SELECT * FROM '$table_name' WHERE id = '$id' ORDER BY ASC");
         } else {
            $query = $this->link->query( "SELECT * FROM '$table_name' ORDER BY ASC");
         }
         var_dump($query);
         $rowCount = $query->rowCount();
         
         if( $rowCount >=1 ) {
            $query->setFetchMode( PDO::FETCH_ASSOC );
            $result = $query->fetchAll();
         } else {
            $result = 0;
         }
         return $result;
      }
   
}
?>
