<?php
  include('crud.remote.php');
  include('crud.php');

  $table_to_user = "Persona";

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

  //$query = "SELECT idPersona FROM persona WHERE  idPersona = '$id'";
  //$result = mysql_query($query);

  if(mysql_num_rows($result) == 0){
    //  $query = "INSERT INTO persona
    //     ( idPersona, pers_nomb, pers_apel, pers_tele, empl_dire, TipoPersona_idTipoPersona )
    //      VALUES ('$id','$nombre','$apellidos','$telefono','$direccion','$tipo')";
    // $result = mysql_query($query);
    $db = new Database();
    $db->connect();
    $db->select($table_to_user);
    $r = $db->insert('persona',array( "$id","$nombre","$apellido","$telefono","$direccion","$tipo" ));

    if($r){
      $success = "El empleado ha quedado registrado en la base de datos";
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

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title> Persona | Datos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="ico/favicon.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#"> Datos</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="index.php"> Todo </a></li>
              <li class="active"><a href="personas.php"> Personas </a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

<?php
 if ( isset($success)) {
?>
    <div class="alert alert-success">
<?php
   echo "{$success}";
?>
    </div>
<?php
}
?>

<?php
 if ( isset($errors)) {
?>
    <div class="alert alert-error">
<?php
   echo "{$errors}";
   echo "<ul>";
    foreach($errores as $mensaje){
      echo "<li>".$mensaje."</li>";
    }
    echo "</ul>";
?>

    </div>
<?php
}
?>

<!-- ::::::::::::::::::::::::::::::: -->
  <legend> Agregar Persona </legend>
    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
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
        <input type="text" id="inputTipo" placeholder="Tipo" name="inputTipo" value="<?php if (isset($_POST['inputTipo'])) echo $_POST['inputTipo']; ?>">
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnpersona"><i class='icon-plus icon-white'></i> Agregar Entrada</button>
        </div>
      </div>
    </form>
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
  $db = new Database();
  $db->connect();
  $db->select($table_to_user);
  $result_personas = $db->getResult();
    for ( $i = 0; $i <count($result_personas); $i++) {
      echo "<tr>";
      echo "<td>";
      echo "{$result_personas[$i][idPersona]}";
      echo "</td>";
      echo "<td>";
      echo "{$result_personas[$i][pers_nomb]} \n";
      echo "</td>";
      echo "<td>";
      echo "{$result_personas[$i][pers_apel]} \n";
      echo "</td>";
      echo "<td>";
      echo "{$result_personas[$i][pers_tele]} \n";
      echo "</td>";
      echo "<td>";
      echo "{$result_personas[$i][empl_dire]} \n";
      echo "</td>";
      echo "<td>";
      echo "{$result_personas[$i][TipoPersona_idTipoPersona]} \n";
      echo "</td>";
      echo "<td>";
      echo "<a class='btn btn-mini' href='#'><i class='icon-trash'></i> Borrar</a>";
      echo "</td>";
      echo "</tr>";
    }
?>
  </table>

<?php
  echo "<pre>";
    print_r($result_personas);
    // print_r( $_POST['inputId'] );
  echo "</pre>";
?>


    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>

  </body>
</html>
