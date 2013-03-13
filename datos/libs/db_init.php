<?php
	include_once('meekrodb.php');
	DB::$user = 'root';
	DB::$password = '';
	DB::$dbName = '_datos';

	DB::$error_handler = false;
   DB::$throw_exception_on_error = true;

   $current_timestamp = date("Y-m-d H:i:s");

?>