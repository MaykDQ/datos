<?php

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', '_datos');

// hace la conexion
$dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) OR die ('No se pudo conectar con el servidor: ' . mysql_error() );
// selecciona la BD
@mysql_select_db (DB_NAME) OR die ('Imposible seleccionar la BD: ' . mysql_error() );
