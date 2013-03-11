<?php
    include_once('libs/meekrodb.php');
    DB::$user = 'root';
    DB::$password = '';
    DB::$dbName = '_datos';

  $table_to_user = "producto";

if(isset($_POST['btnproducto'])){

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

  if(empty($_POST['inputDescripcion'])){
    $errores[] = "Olvido digitar Apellido";
  } else {
    $descripcion = ($_POST['inputDescripcion']);
  }

  if(!is_numeric($_POST['inputCompra'])){
    $errores[] = " Verifique el numero Telefonico ";
    } else {
    $precioCompra = ($_POST['inputCompra']);
  }

  if(empty($_POST['inputVenta'])){
    $errores[] = " Olvido digitar la Direccion ";
  } else {
    $precioVenta = ($_POST['inputVenta']);
  }

  if( empty($_POST['inputRuta'])){
    $errores[] = " Olvido digitar el Tipo ";
  } else {
    $rutaImg = ($_POST['inputRuta']);
  }

  if(!is_numeric($_POST['inputCategoria'])){
    $errores[] = " Olvido digitar el Tipo ";
  } else {
    $categoria = ($_POST['inputCategoria']);
  }

if(empty($errores)){

  if(mysql_num_rows($result) == 0){

    DB::$error_handler = false;
    DB::$throw_exception_on_error = true;

    try {
      DB::insert($table_to_user, array(
        'idProducto'                  => $id,
        'prod_nomb'                   => $nombre,
        'prod_desc'                   => $descripcion,
        'prod_prec_comp'              => $precioCompra,
        'prod_prec_vent'              => $precioVenta,
        'prod_ruta_imag'              => $rutaImg,
        'categoria_idCategoria'       => $categoria
      ));
    } catch(MeekroDBException $e) {
        $count = $e->getMessage();
        DB::$error_handler = 'meekrodb_error_handler';
        DB::$throw_exception_on_error = false;
    }

    if( !isset($count) ){
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

  $result_producto      = DB::query("SELECT * FROM {$table_to_user}");

  $result_categoria     = DB::query("SELECT     categoria.cate_nomb
                                    FROM        categoria, producto
                                    WHERE       categoria.idCategoria = producto.categoria_idCategoria
                                    ORDER BY    producto.idProducto");

  $result_cbx_categoria = DB::query("SELECT     categoria.idCategoria, categoria.cate_nomb
                                    FROM        categoria
                                    ORDER BY    categoria.idCategoria");
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
              <li><a href="pedido.php"> Pedido </a></li>
              <li ><a href="personas.php"> Persona </a></li>
              <li class="active"><a href="producto.php"> Producto </a></li>
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
  <legend> Agregar Producto <button id="showcont"class="btn " name="btnpedido"><i class='icon-plus'></i> </button></legend>
    <form id="fromadd" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
      <div class="control-group">
        <label class="control-label" for="inputId"># ID </label>
        <div class="controls">
        <input type="text" id="inputId" placeholder="Id" name="inputId" value="<?php if (isset($_POST['inputId'])) echo $_POST['inputId']; ?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputNombre"> Nombre Producto</label>
        <div class="controls">
        <input type="text" id="inputNombre" placeholder="Nombre Producto" name="inputNombre" value="<?php if (isset($_POST['inputNombre'])) echo $_POST['inputNombre']; ?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputDescripcion"> Descripcion </label>
        <div class="controls">
        <input type="text" id="inputDescripcion" placeholder="Descripcion" name="inputDescripcion" value="<?php if (isset($_POST['inputDescripcion'])) echo $_POST['inputDescripcion']; ?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputCompra"> Precio Compra </label>
        <div class="controls">
        <input type="text" id="inputCompra" placeholder="Precio Compra" name="inputCompra" value="<?php if (isset($_POST['inputCompra'])) echo $_POST['inputCompra']; ?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputVenta"> Precio Venta </label>
        <div class="controls">
        <input type="text" id="inputVenta" placeholder="Precio Venta" name="inputVenta" value="<?php if (isset($_POST['inputVenta'])) echo $_POST['inputVenta']; ?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputRuta"> Ruta Imagen </label>
        <div class="controls">
        <input type="text" id="inputRuta" placeholder="Ruta Imagen" name="inputRuta" value="<?php if (isset($_POST['inputRuta'])) echo $_POST['inputRuta']; ?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputCategoria"> Producto </label>
        <div class="controls">
          <select id='inputCategoria'  name='inputCategoria' >
            <?php
              foreach($result_cbx_categoria as $key=>$value) {
                echo "<option value=\"{$value['idCategoria']}\"> {$value['cate_nomb']} </option>";
              }
            ?>
          </select>
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btnproducto"><i class=''></i> Agregar Entrada</button>
        </div>
      </div>
    </form>
<h2> Tabla Producto </h2>
  <table class="table table-striped">
  <tr class="success" >
    <th># ID </th>
    <th> Nombre Producto  </th>
    <th> Descripcion </th>
    <th> Precio Compra </th>
    <th> Precio Venta </th>
    <th> Ruta Img </th>
    <th> Categoria </th>
    <th> </th>
  </tr>
<?php
    for ( $i = 0; $i <count($result_producto); $i++) {
      echo "<tr>";
      echo "<td>";
      echo "{$result_producto[$i][idProducto]}";
      echo "</td>";
      echo "<td>";
      echo "{$result_producto[$i][prod_nomb]} \n";
      echo "</td>";
      echo "<td>";
      echo "{$result_producto[$i][prod_desc]} \n";
      echo "</td>";
      echo "<td>";
      echo "{$result_producto[$i][prod_prec_comp]} \n";
      echo "</td>";
      echo "<td>";
      echo "{$result_producto[$i][prod_prec_vent]} \n";
      echo "</td>";
      echo "<td>";
      echo "{$result_producto[$i][prod_ruta_imag]} \n";
      echo "</td>";
      echo "<td>";
      echo "{$result_categoria[$i][cate_nomb]} \n";
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
    // print_r($result_producto);
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
