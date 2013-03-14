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
  $table_to_user = "pedido";

/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Validacion Formulario
| :::::::::::::::::::::::::::::::::::::::::::::
*/
if(isset($_POST['btnpedido'])){

  if(!is_numeric($_POST['inputId'])){
    $errores[] = "ID debe ser un dato numérico";
  } else {
    $id = ($_POST['inputId']);
  }

  if( !is_numeric($_POST['inputCant'])){
    $errores[] = "Cant Debe ser un dato numerico";
  } else {
    $cantpedido = ($_POST['inputCant']);
  }

  if( empty($_POST['inputProduto']) ){
    $errores[] = " Error en el Producto ";
    } else {
    $productopedido = ($_POST['inputProduto']);
  }

  if( empty($_POST['inputCliente'])){
    $errores[] = " Olvido digitar la Direccion ";
  } else {
    $clientepedido = ($_POST['inputCliente']);
  }

if(empty($errores)){

  if(mysql_num_rows($result) == 0){

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
    }

    if( !isset($count) ){
      $success = "El empleado ha quedado registrado en la base de datos";
    } else {
      $errors = "<h4>Error del sistema, no ha sido posible registrarlo en la BD</h4>".mysql_error().$count;

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

$result_producto    = DB::query("SELECT *
                                  FROM      {$table_to_user}
                                  ORDER BY  pedido.idPedido DESC");

$result_nomb        = DB::query("SELECT     persona.pers_nomb, persona.pers_apel
                                  FROM      pedido, persona
                                  WHERE     pedido.Personas_idPersona =  persona.idPersona
                                  ORDER BY  pedido.idPedido");

$result_detalle     = DB::query("SELECT     producto.prod_nomb
                                  FROM      producto, pedido
                                  WHERE     producto.idProducto =  pedido.idProducto
                                  ORDER BY  pedido.idPedido");

$resul_cbx_producto =  DB::query("SELECT    producto.idProducto, producto.prod_nomb
                                  FROM      producto
                                  ORDER BY  producto.idProducto");

$resul_cbx_cliente  =  DB::query("SELECT    persona.idPersona, persona.pers_nomb, persona.pers_apel
                                  FROM      persona
                                  ORDER BY  persona.idPersona");
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


<!--/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Tabla
| :::::::::::::::::::::::::::::::::::::::::::::
*/-->
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
