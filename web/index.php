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

?>
<!--/*
| ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
|  Cabecera HTML
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

    <h1>Bienvenido a la Tienda Don Pepito </h1>

  </div> <!-- /container -->

    <!-- Footer -->
    <?php include_once 'inc/footer.php'; ?>

  </body>
</html>
<?php

    } else {
        // not logged in, showing the login form
        include("views/login/not_logged_in.php");
    }
}
?>