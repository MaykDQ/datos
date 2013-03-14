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
  $table_to_user = "producto";

/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Validacion Formulario
| :::::::::::::::::::::::::::::::::::::::::::::
*/
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

/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Querys
| :::::::::::::::::::::::::::::::::::::::::::::
*/

  $result_producto      = DB::query("SELECT * FROM {$table_to_user}");

  $result_categoria     = DB::query("SELECT     categoria.cate_nomb
                                    FROM        categoria, producto
                                    WHERE       categoria.idCategoria = producto.categoria_idCategoria
                                    ORDER BY    producto.idProducto");

  $result_cbx_categoria = DB::query("SELECT     categoria.idCategoria, categoria.cate_nomb
                                    FROM        categoria
                                    ORDER BY    categoria.idCategoria");
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

<!--/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Tabla
| :::::::::::::::::::::::::::::::::::::::::::::
*/-->
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


<!--/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Fin del Codigo
| :::::::::::::::::::::::::::::::::::::::::::::
*/-->
<?php
  echo "<pre>";
    // print_r($result_producto);
  echo "</pre>";
?>

    </div> <!-- /container -->

    <!-- Footer -->
    <?php include_once 'inc/footer.php'; ?>

  </body>
</html>
