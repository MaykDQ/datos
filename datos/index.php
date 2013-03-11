<?php
  include('crud.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title> Todo | Datos </title>
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
          <a class="brand" href="index.php"> Datos</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="index.php"> Todo </a></li>
              <li><a href="categoria.php"> Categoria </a></li>
              <li><a href="pedido.php"> Pedido </a></li>
              <li><a href="personas.php"> Persona </a></li>
              <li><a href="producto.php"> Producto </a></li>
              <li><a href="tipopersona.php"> Tipo Persona </a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

<div class="container">
<!-- ::::::::::::::::::::::::::::::: -->

<h2> Tipo Empleado</h2>
  <table class="table table-striped">
  <tr class="success" >
    <th>#</th>
    <th> Rol </th>
    <th> </th>
  </tr>
<?php
  $db = new Database();
  $db->connect();
  $db->select('tipopersona');
  $result_tipo = $db->getResult();
    for ( $i = 0; $i <count($result_tipo); $i++) {
      echo "<tr>";
      echo "<td>";
      echo "{$result_tipo[$i][idTipoPersona]}";
      echo "</td>";
      echo "<td>";
      echo "{$result_tipo[$i][tipo_pers]} \n";
      echo "</td>";
      echo "<td>";
      echo "<a class='btn btn-mini' href='#'><i class='icon-trash'></i> Borrar</a>";
      echo "</td>";
      echo "</tr>";
    }

?>
  </table>
  <legend> Agragar Tipo de Empleado </legend>
    <form class="form-horizontal">
      <div class="control-group">
        <label class="control-label" for="inputRol">Rol</label>
        <div class="controls">
        <input type="text" id="inputRol" placeholder="Rol">
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary"><i class='icon-plus icon-white'></i> Agregar Entrada</button>
        </div>
      </div>
    </form>

<?php
  echo "<pre>";
    print_r($result_tipo);
  echo "</pre>";
?>

<!-- ::::::::::::::::::::::::::::::: -->
<h2> Personas </h2>
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
  $db->select('persona');
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
  <legend> Agregar Personas </legend>
    <form class="form-horizontal">
      <div class="control-group">
        <label class="control-label" for="inputId"># ID </label>
        <div class="controls">
        <input type="text" id="inputId" placeholder="Id">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputNombre"> Nombre </label>
        <div class="controls">
        <input type="text" id="inputNombre" placeholder="Nombre">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputApellido"> Apellido </label>
        <div class="controls">
        <input type="text" id="inputApellido" placeholder="Apellido">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputTelefono"> Telefono </label>
        <div class="controls">
        <input type="text" id="inputTelefono" placeholder="Telefono">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputDireccion"> Direccion </label>
        <div class="controls">
        <input type="text" id="inputDireccion" placeholder="Direccion">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputTipo"> Tipo </label>
        <div class="controls">
        <input type="text" id="inputTipo" placeholder="Tipo">
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary"><i class='icon-plus icon-white'></i> Agregar Entrada</button>
        </div>
      </div>
    </form>
<?php
  echo "<pre>";
    print_r($result_personas);
  echo "</pre>";
?>

<!-- ::::::::::::::::::::::::::::::: -->
<h2> Categoria </h2>
  <table class="table table-striped">
  <tr class="success" >
    <th>#</th>
    <th> Rol </th>
    <th> </th>
  </tr>
<?php
  $db = new Database();
  $db->connect();
  $db->select('categoria');
  $result_categoria = $db->getResult();
    for ( $i = 0; $i <count($result_categoria); $i++) {
      echo "<tr>";
      echo "<td>";
      echo "{$result_categoria[$i][idCategoria]}";
      echo "</td>";
      echo "<td>";
      echo "{$result_categoria[$i][cate_nomb]} \n";
      echo "</td>";
      echo "<td>";
      echo "<a class='btn btn-mini' href='#'><i class='icon-trash'></i> Borrar</a>";
      echo "</td>";
      echo "</tr>";
    }

?>
  </table>
  <legend> Agragar Categoria </legend>
    <form class="form-horizontal">
      <div class="control-group">
        <label class="control-label" for="inputCategoria"> Categoria </label>
        <div class="controls">
        <input type="text" id="inputCategoria" placeholder="Categoria">
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary"><i class='icon-plus icon-white'></i> Agregar Entrada</button>
        </div>
      </div>
    </form>

<?php
  echo "<pre>";
    print_r($result_categoria);
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
