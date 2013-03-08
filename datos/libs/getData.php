<?php
   include_once '../core/class.ManageDatabase.php';
   $init = new ManageDatabase();
   
   $table_name = "wp_users";
   $data = $init->getData( $table_name );
   
   
   print_r($data);
?>
