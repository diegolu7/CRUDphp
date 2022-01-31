<?php

session_start();
include("../config/bd.php");

  if(!isset($_SESSION['usuario'])){
    header("Location:../index.php");

  }else{
      if($_SESSION['usuario']=="ok"){
          $nombreUsuario = $_SESSION['nombreUsuario'];
                           
      }

  }



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Admin</title>
   <link rel="stylesheet" href="/css/bootstrap.min.css">

</head>
<body>

<?php $url = "http://".$_SERVER['HTTP_HOST']."/proyect1.local"?>
  
<nav class="navbar navbar-expand navbar-light bg-light">
    <div class="nav navbar-nav">
        <a class="nav-item nav-link active" href="#">Admin <span class="sr-only"></span></a>
        <a class="nav-item nav-link" href="<?php $url;?>/administrador/inicio.php">Inicio</a>
        <a class="nav-item nav-link" href="<?php $url;?>/administrador/seccion/productos.php">Libros</a>
        <a class="nav-item nav-link" href="<?php echo $url; ?>">Ir a Sitio</a>
        <a class="nav-item nav-link" href="<?php $url;?>/administrador/seccion/cerrar.php">Cerrar</a>



    </div>
</nav>
<div class="container">
  <br>
  <div class="row">
    