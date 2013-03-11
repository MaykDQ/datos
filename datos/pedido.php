<?php
  // include('crud.remote.php');
  // include('crud.php');

  include_once('libs/meekrodb.php');
  DB::$user = 'root';
  DB::$password = '';
  DB::$dbName = '_datos';

  $table_to_user = "pedido";

if(isset($_POST['btnpedido'])){

  if(!is_numeric($_POST['inputId'])){
    $errores[] = "ID debe ser un dato numérico";
  } else {
    $id = ($_POST['inputId']);
  }

  if(empty($_POST['inputCant'])){
    $errores[] = "Olvido digitar Apellido";
  } else {
    $cantpedido = ($_POST['inputCant']);
  }

  if( empty($_POST['inputProduto']) ){
    $errores[] = " Error en el Producto ";
    } else {
    $productopedido = ($_POST['inputProduto']);
  }

  if(empty($_POST['inputCliente'])){
    $errores[] = " Olvido digitar la Direccion ";
  } else {
    $clientepedido = ($_POST['inputCliente']);
  }


if(empty($errores)){

  if(mysql_num_rows($result) == 0){

    $current_timestamp = date("Y-m-d H:i:s");

    DB::$error_handler = false;
    DB::$throw_exception_on_error = true;

    try {
      DB::insert($table_to_user, array(
        'idPedido'                => $id,
        'pedi_fech'               => $current_timestamp,
        'pedi_cant'               => $cantpedido,
        'idProducto'              => $productopedido,
        'Personas_idPersona'      => $clientepedido
      ));
    } catch(MeekroDBException $e) {
        $count = $e->getMessage();
        DB::$error_handler = 'meekrodb_error_handler';
        DB::$throw_exception_on_error = false;
    }

    if( !isset($count) ){
      $success = "El empleado ha quedado registrado en la base de datos";
    } else {
      $errors = "<h4>Error del sistema, no ha sido posible registrarlo en la BD</h4>".mysql_error().$count;
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

  $result_producto    = DB::query("SELECT * FROM {$table_to_user}");

  $result_nomb        = DB::query("SELECT   persona.pers_nomb, persona.pers_apel
                                    FROM      pedido, persona
                                    WHERE     pedido.Personas_idPersona =  persona.idPersona
                                    ORDER BY  pedido.idPedido");

  $result_detalle     = DB::query("SELECT   pedido.idPedido, producto.prod_nomb, producto.idProducto
                                    FROM      producto, pedido
                                    WHERE     producto.idProducto =  pedido.idProducto
                                    ORDER BY  pedido.idPedido");

  $resul_cbx_producto =  DB::query("SELECT  producto.idProducto, producto.prod_nomb
                                    FROM    producto
                                    ORDER BY producto.idProducto");

  $resul_cbx_cliente  =  DB::query("SELECT   persona.idPersona, persona.pers_nomb, persona.pers_apel
                                    FROM    persona
                                    ORDER BY persona.idPersona");

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
    <link href="css/css.css" rel="stylesheet">

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
              <li ><a href="index.php"> Todo </a></li>
              <li><a href="categoria.php"> Categoria </a></li>
              <li class="active"><a href="pedido.php"> Pedido </a></li>
              <li ><a href="personas.php"> Persona </a></li>
              <li ><a href="producto.php"> Producto </a></li>
              <li><a href="tipopersona.php"> Tipo Persona </a></li>
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
  <legend> Agregar Pedido <button id="showcont"class="btn " name="btnpedido"><i class='icon-plus'></i> </button></legend>
    <form id="fromadd" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
      <div class="control-group">
        <label class="control-label" for="inputId"># ID </label>
        <div class="controls">
        <input type="text" id="inputId" placeholder="Id" name="inputId" value="<?php if (isset($_POST['inputId'])) echo $_POST['inputId']; ?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputCant"> Cant </label>
        <div class="controls">
        <input type="text" id="inputCant" placeholder="Cant" name="inputCant" value="<?php if (isset($_POST['inputCant'])) echo $_POST['inputCant']; ?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputProduto"> Producto </label>
        <div class="controls">
          <select id='inputProduto'  name='inputProduto' >
            <?php
              foreach($resul_cbx_producto as $key=>$value) {
                echo "<option value=\"{$value['idProducto']}\"> {$value['prod_nomb']} </option>";
              }
            ?>
          </select>
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputCliente"> Cliente </label>
        <div class="controls">
          <select id='inputCliente'  name='inputCliente' >
            <?php
              foreach($resul_cbx_cliente as $key=>$value) {
                echo "<option value=\"{$value['idPersona']}\"> {$value['pers_nomb']}  {$value['pers_apel']} </option>";
              }
            ?>
          </select>
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnpedido"><i class=' icon-white'></i> Agregar Entrada</button>
        </div>
      </div>
    </form>
<h2> Tabla Pedidos </h2>
  <table class="table table-striped">
  <tr class="success" >
    <th># ID </th>
    <th> Fecha Pedido  </th>
    <th> Cant </th>
    <th> Producto </th>
    <th> Cliente </th>
    <th> </th>
  </tr>
<?php


    for ( $i = 0; $i <count($result_producto); $i++) {
      echo "<tr>";
      echo "<td>";
      echo "{$result_producto[$i][idPedido]}";
      echo "</td>";
      echo "<td>";
      echo "{$result_producto[$i][pedi_fech]} ";
      echo "</td>";
      echo "<td>";
      echo "{$result_producto[$i][pedi_cant]} ";
      echo "</td>";

      echo "<td>";
      echo "{$result_detalle[$i][prod_nomb]}";
      echo "</td>";

      echo "<td>";
      echo "{$result_nomb[$i][pers_nomb]} {$result_nomb[$i][pers_apel]}";
      echo "</td>";

      echo "<td>";
      echo "<a class='btn btn-mini' href='#'><i class='icon-edit'></i> </a>";
      echo "<a class='btn btn-mini' href='#'><i class='icon-trash'></i> </a>";
      echo "</td>";
      echo "</tr>";
    }
?>
  </table>

<?php
  echo "<pre>";
    // print_r($resul_cbx_cliente);
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

    <script src="js/jquery.js"></script>
    <script src="js/js.js"></script>

  </body>
</html>
