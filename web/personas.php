<?php
/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Inicio y Autenticacion
| :::::::::::::::::::::::::::::::::::::::::::::
*/
include_once('libs/init.php');

function autoload($class)
{
    require('classes/' . $class . '.class.php');
}

// automatically loads all needed classes, when they are needed
spl_autoload_register("autoload");
//create a database connection
$db    = new Database();
// start this baby and give it the database connection
$login = new Login($db);
// base structure
if ($login->displayRegisterPage()) {
        include("views/login/register.php");
} else {
    // are we logged in ?
    if ($login->isUserLoggedIn()) {
        include("views/login/logged_in.php");
        // further stuff here
    } else {
        // not logged in, showing the login form
//        include("views/login/not_logged_in.php");
        header( 'Location: index.php' ) ;
//        header( "index.php" );
    }
}
  // Selecciona Tabla
  $table_to_user = "persona";

/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Validacion Formulario
| :::::::::::::::::::::::::::::::::::::::::::::
*/
if(isset($_POST['btnpersona'])){

  if(!is_numeric($_POST['inputId'])){
    $errores[] = "ID debe ser un dato numérico";
  } else {
    $id = ($_POST['inputId']);
  }

 if(empty($_POST['inputNombre'])){
    $errores[] = "Olvido digitar Nombre";
  } else {
    $nombre = ($_POST['inputNombre']);
  }

  if(empty($_POST['inputApellido'])){
    $errores[] = "Olvido digitar Apellido";
  } else {
    $apellido = ($_POST['inputApellido']);
  }

  if(!is_numeric($_POST['inputTelefono'])){
    $errores[] = " Verifique el numero Telefonico ";
    } else {
    $telefono = ($_POST['inputTelefono']);
  }

  if(empty($_POST['inputDireccion'])){
    $errores[] = " Olvido digitar la Direccion ";
  } else {
    $direccion = ($_POST['inputDireccion']);
  }

  if(!is_numeric($_POST['inputTipo'])){
    $errores[] = " Olvido digitar el Tipo ";
  } else {
    $tipo = ($_POST['inputTipo']);
  }


if(empty($errores)){

  if(mysql_num_rows($result) == 0){

    try {
      DB::insert($table_to_user, array(
        'idPersona'                   => $id,
        'pers_nomb'                   => $nombre,
        'pers_apel'                   => $apellido,
        'pers_tele'                   => $telefono,
        'pers_dire'                   => $direccion,
        'TipoPersona_idTipoPersona'   => $tipo
      ));
    } catch(MeekroDBException $e) {
        $count = $e->getMessage();
    }

    if( !isset($count) ){
      $success = "El empleado ha quedado registrado en la base de datos";
    } else {
      $errors = "<h4>Error del sistema, no ha sido posible registrarlo en la BD</h4>".mysql_error();

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

  $result           = DB::query("SELECT * FROM {$table_to_user}");

  $result_tipo      = DB::query("SELECT       tipopersona.tipo_pers
                                  FROM        persona, tipopersona
                                  WHERE       persona.TipoPersona_idTipoPersona = tipopersona.idTipoPersona
                                  ORDER BY    persona.idPersona");

  $result_cbx_tio   = DB::query("SELECT       tipopersona.idTipoPersona, tipopersona.tipo_pers
                                  FROM        tipopersona
                                  ORDER BY    tipopersona.idTipoPersona");
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


<!--/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Mensajes de Formulario
| :::::::::::::::::::::::::::::::::::::::::::::
*/-->
<?php
 if ( isset($success)) {
    echo '<div class="alert alert-success">"{$success}"</div>';
  }
 if ( isset($errors)) {
    echo '<div class="alert alert-error">';
    echo "{$errors}";
    echo "<ul>";
      foreach($errores as $mensaje){
        echo "<li>".$mensaje."</li>";
      }
    echo "</ul>";
    echo "</div>";
  }
?>

<!--/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Formulario
| :::::::::::::::::::::::::::::::::::::::::::::
*/-->
  <legend> Agregar Persona <button id="showcont"class="btn " name="btnpedido"><i class='icon-plus'></i> </button></legend>

    <form id="fromadd" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

      <div class="control-group">
        <label class="control-label" for="inputId"># ID </label>
        <div class="controls">
        <input type="text" id="inputId" placeholder="Id" name="inputId" value="<?php if (isset($_POST['inputId'])) echo $_POST['inputId']; ?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputNombre"> Nombre </label>
        <div class="controls">
        <input type="text" id="inputNombre" placeholder="Nombre" name="inputNombre" value="<?php if (isset($_POST['inputNombre'])) echo $_POST['inputNombre']; ?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputApellido"> Apellido </label>
        <div class="controls">
        <input type="text" id="inputApellido" placeholder="Apellido" name="inputApellido" value="<?php if (isset($_POST['inputApellido'])) echo $_POST['inputApellido']; ?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputTelefono"> Telefono </label>
        <div class="controls">
        <input type="text" id="inputTelefono" placeholder="Telefono" name="inputTelefono" value="<?php if (isset($_POST['inputTelefono'])) echo $_POST['inputTelefono']; ?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputDireccion"> Direccion </label>
        <div class="controls">
        <input type="text" id="inputDireccion" placeholder="Direccion" name="inputDireccion" value="<?php if (isset($_POST['inputDireccion'])) echo $_POST['inputDireccion']; ?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputTipo"> Tipo </label>
        <div class="controls">
          <select id='inputTipo'  name='inputTipo' >
            <?php
              foreach($result_cbx_tio as $key=>$value) {
                echo "<option value=\"{$value['idTipoPersona']}\"> {$value['tipo_pers']} </option>";
              }
            ?>
          </select>
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnpersona"><i class='icon icon-white'></i> Agregar Entrada</button>
        </div>
      </div>
    </form>


<!--/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Tabla
| :::::::::::::::::::::::::::::::::::::::::::::
*/-->
<h2> Tabla Personas </h2>
  <table class="table table-striped">
  <tr class="success" >
    <th># ID </th>
    <th> Nombre  </th>
    <th> Apellido </th>
    <th> Telefono </th>
    <th> Direccion </th>
    <th> Tipo </th>
    <th> </th>
  </tr>
<?php

    for ( $i = 0; $i <count($result); $i++) {
      echo "<tr>";
      echo "<td>";
      echo "{$result[$i][idPersona]}";
      echo "</td>";
      echo "<td>";
      echo "{$result[$i][pers_nomb]} \n";
      echo "</td>";
      echo "<td>";
      echo "{$result[$i][pers_apel]} \n";
      echo "</td>";
      echo "<td>";
      echo "{$result[$i][pers_tele]} \n";
      echo "</td>";
      echo "<td>";
      echo "{$result[$i][pers_dire]} \n";
      echo "</td>";
      echo "<td>";
      echo "{$result_tipo[$i][tipo_pers]} \n";
      echo "</td>";
      echo "<td>";
      echo "<a class='btn btn-mini' href='#'><i class='icon-edit'></i> </a>";
      echo "<a class='btn btn-mini' href='#'><i class='icon-trash'></i></a>";
      echo "</td>";
      echo "</tr>";
    }
?>
  </table>


<!--/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Fin del Codigo
| :::::::::::::::::::::::::::::::::::::::::::::
*/-->
<?php
  echo "<pre>";
    // print_r($result_detalle);
  echo "</pre>";
?>

    </div> <!-- /container -->

    <!-- Footer -->
    <?php include_once 'inc/footer.php'; ?>

  </body>
</html>
