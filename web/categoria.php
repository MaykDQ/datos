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
$table_to_user = "categoria";

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
    $errores[] = "Olvido digitar Categoria";
  } else {
    $categoria = ($_POST['inputCategoria']);
  }

if(empty($errores)){

  if(mysql_num_rows($result) == 0){
    try {
      DB::insert($table_to_user, array(
        'idCategoria'                => $id,
        'cate_nomb'                  => $categoria
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
/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Querys
| :::::::::::::::::::::::::::::::::::::::::::::
*/
  // Tabla Categoria Completa
$result_categoria    = DB::query("SELECT *
                                  FROM      {$table_to_user}
                                  ORDER BY  categoria.idCategoria DESC");

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
  <legend> Agregar Categoria <button id="showcont"class="btn " name="btnpedido"><i class='icon-plus'></i> </button></legend>
    <form id="fromadd"  class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
      <div class="control-group">
        <label class="control-label" for="inputId"># ID </label>
        <div class="controls">
        <input type="text" id="inputId" placeholder="Id" name="inputId" value="<?php if (isset($_POST['inputId'])) echo $_POST['inputId']; ?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="inputCategoria"> Categoria </label>
        <div class="controls">
        <input type="text" id="inputCategoria" placeholder="Categoria" name="inputCategoria" value="<?php if (isset($_POST['inputCategoria'])) echo $_POST['inputCategoria']; ?>">
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" name="btncategoria"><i class='icon '></i> Agregar Entrada</button>
        </div>
      </div>

    </form>


 <!--/*
| :::::::::::::::::::::::::::::::::::::::::::::
|  Tabla
| :::::::::::::::::::::::::::::::::::::::::::::
*/-->
<h2> Tabla Categorias </h2>
  <table class="table table-striped">
  <tr class="success" >
    <th># ID </th>
    <th> Categoria  </th>
    <th> </th>
  </tr>

<?php
    for ( $i = 0; $i <count($result_categoria); $i++) {
      echo "<tr>";
      echo "<td>";
      echo "{$result_categoria[$i][idCategoria]}";
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
    // print_r($result_categoria);
  echo "</pre>";
?>

    </div> <!-- /container -->

    <!-- Footer -->
    <?php include_once 'inc/footer.php'; ?>

  </body>
</html>
