<?php
  include('crud.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bootstrap, from Twitter</title>
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
              <li class="active"><a href="#"> Todo </a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">



<?php

include('includes/validar_correo.php');
include('includes/conexion.php');


if(isset($_POST['btnregistro'])){

  if(!is_numeric($_POST['txt_ide'])){
    $errores[] = "Identificación debe ser un dato numérico";
  } else {
    $identificacion = ($_POST['txt_ide']);
  }

 if(empty($_POST['txt_ape'])){
    $errores[] = "Olvido digitar apellidos";
  } else {
    $apellidos = ($_POST['txt_ape']);
  }

  if(empty($_POST['txt_nom'])){
    $errores[] = "Olvido digitar nombres";
  } else {
    $nombres = ($_POST['txt_nom']);
  }


   if(!is_numeric($_POST['txt_sub'])){
    $errores[] = "Sueldo básico debe ser un dato numérico";
    } else {
    $sueldo = ($_POST['txt_sub']);
  }

  if(!check_email($_POST['txt_ema'])){
    $errores[] = "El correo electrónico no se ha escrito correctamente";
  } else {
    $email = ($_POST['txt_ema']);
  }

  $fechanaci =  ($_POST['txt_fen']);
    $direccion =  ($_POST['txt_dir']);
  $telefono =   ($_POST['txt_tel']);
  $sexo =     ($_POST['rad_sex']);

if(empty($errores)){

  $query = "SELECT EMP_IDE FROM empleados WHERE  EMP_IDE = '$identificacion'";
  $result = mysql_query($query);
  if(mysql_num_rows($result) == 0){
     $query = "INSERT INTO empleados
  (EMP_IDE,EMP_NOM,EMP_APE,EMP_SUB,EMP_FEN,EMP_SEX,EMP_EMA,EMP_DIR,EMP_TEL)
  VALUES ('$identificacion','$nombres','$apellidos',$sueldo,'$fechanaci','$sexo','$email','$direccion','$telefono')";
    $result = mysql_query($query);

    if($result){
    echo "El empleado ha quedado registrado en la base de datos";

    exit();
  } else {
    echo "<h2>Error del sistema, no ha sido posible registrarlo en la BD</h2>".mysql_error();

      exit();

  }

  } else {

    echo "<h1>Error del sistema</h1>";
    echo "El usuario ya ha sido registrado, por favor verifique sus datos";

  }


} else {

  echo "<h1>Error!</h1>";
  echo "<p>Se presentaron los siguientes errores al diligenciar el fomulario:</p>";
  foreach($errores as $mensaje){
  echo "".$mensaje."<br>"  ;

  }

}
 mysql_close();
}
?>


<h2 align="center">Registro de Empleados </h2>
<p align="center">Los campos marcados con "*" son obligatorios

</p>
<form name="formu" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" >
  <table width="499" border="0"  align="center">
    <tr>
      <td>Identificacion:</td>
      <td>
        <input name="txt_ide" type="text" id="txt_ide" value="<?php if (isset($_POST['txt_ide'])) echo $_POST['txt_ide']; ?>" size="30" maxlength="30"/>
      *</td>
    </tr>
    <tr>
      <td width="161">Apellidos:</td>
      <td width="328"><input name="txt_nom" type="text" id="txt_nom" value="<?php if (isset($_POST['txt_nom'])) echo $_POST['txt_nom']; ?>" size="30" maxlength="30"/>
      *</td>
    </tr>
    <tr>
      <td>Nombres:</td>
      <td><input name="txt_ape" type="text" id="txt_ape" value="<?php if (isset($_POST['txt_ape'])) echo $_POST['txt_ape']; ?>" size="30" maxlength="30"/>
       * </td>
    </tr>

    <tr>
      <td>Sueldo B&aacute;sico: </td>
      <td><input name="txt_sub" type="text" id="txt_sub" value="<?php if (isset($_POST['txt_sub'])) echo $_POST['txt_sub']; ?>" size="30" maxlength="30"/></td>
    </tr>
    <tr>
      <td>Fecha de Nacimiento: </td>
      <td><input name="txt_fen" type="text" id="txt_fen" value="<?php if (isset($_POST['txt_fen'])) echo $_POST['txt_fen']; ?>" size="30" maxlength="30"/>
        (aaaa-mm-dd)*</td>
    </tr>
    <tr>
      <td>Sexo:</td>
      <td><input type="radio" value="F" <?php if(!isset($_POST['enviado']) || $_POST['sexo']=="F") echo "checked=\"checked\""; ?> name="rad_sex" />
        F
        <input type="radio" value="M" name="rad_sex" <?php echo ($_POST['sexo']=="M")? "checked=\"checked\"": ""; ?> />
        M</td>
    </tr>
    <tr>
      <td>Correo Electr&oacute;nico: </td>
      <td><input name="txt_ema" type="text" id="txt_ema" value="<?php if (isset($_POST['txt_ema'])) echo $_POST['txt_ema']; ?>" size="50" maxlength="50" />
        *</td>
    </tr>

    <tr>
      <td>Direcci&oacute;n:</td>
      <td><input name="txt_dir" type="text" id="txt_dir" value="<?php if (isset($_POST['txt_dir'])) echo $_POST['txt_dir']; ?>" size="40" maxlength="40" /></td>
    </tr>
    <tr>
      <td>Tel&eacute;fono:</td>
      <td><input name="txt_tel" type="text" id="txt_tel" value="<?php if (isset($_POST['txt_tel'])) echo $_POST['txt_tel']; ?>" size="15" maxlength="15" /></td>
    </tr>


    <tr>
      <td><div align="center">
        <input type="hidden" name="enviado" value="TRUE" />
        <input type="submit" name = "btnregistro" value="Registrar" class="btn btn-primary" />
      </div></td>
      <td><div align="center">
        <input type="reset" name="submit2" value="Cancelar" class="btn btn-primary" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
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
