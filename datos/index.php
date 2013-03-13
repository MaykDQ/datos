<?php
/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Coneccion Base Datos
| :::::::::::::::::::::::::::::::::::::::::::::
*/
  include_once('libs/db_init.php');

  // Selecciona Tabla
  $table_to_user = "tipopersona";

/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Validacion Formulario
| :::::::::::::::::::::::::::::::::::::::::::::
*/
if(isset($_POST['btncategoria'])){

  if(!is_numeric($_POST['inputId'])){
    $errores[] = "ID debe ser un dato numérico";
  } else {
    $id = ($_POST['inputId']);
  }

 if(empty($_POST['inputCategoria'])){
    $errores[] = "Olvido digitar Tipo Persona";
  } else {
    $categoria = ($_POST['inputCategoria']);
  }



if(empty($errores)){

  if(mysql_num_rows($result) == 0){

    try {
      DB::insert($table_to_user, array(
        'idTipoPersona'                => $id,
        'tipo_pers'               => $categoria
      ));
    } catch(MeekroDBException $e) {
        $count = $e->getMessage();
    }

    if( !isset($count) ){
      $success = "El Tipo de Persona ha quedado registrado en la base de datos";
      // exit();
    } else {
      $errors = "<h4>Error del sistema, no ha sido posible registrarlo en la BD</h4>".mysql_error();
        // exit();
    }

  } else {
    echo "<h1>Error del sistema</h1>";
    echo "El usuario ya ha sido registrado, por favor verifique sus datos";
  }


} else {

  $errors = "<h3>Error!</h3>".
  "<p>Se presentaron los siguientes errores al diligenciar el fomulario:</p>";


}
 mysql_close();
}
/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Querys
| :::::::::::::::::::::::::::::::::::::::::::::
*/

$result_tipopersona    = DB::query("SELECT *
                                    FROM      {$table_to_user}
                                    ORDER BY  tipopersona.idTipoPersona DESC");
?>

<!--/*
| ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
|  Babecera HTML
| ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
*/-->
<!DOCTYPE html>
<html lang="en">
  <!-- Header -->
  <?php include_once 'inc/header.php'; ?>

  <body>
  <!-- Menu -->
  <?php include_once 'inc/menu.php'; ?>

  <div class="container">



  </div> <!-- /container -->

    <!-- Footer -->
    <?php include_once 'inc/footer.php'; ?>

  </body>
</html>
