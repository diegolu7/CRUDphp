<?php

//nos conectamos a la DB

$host="127.0.0.1";
$db="proyect1";
$usuario="root";
$contrasenia="";

try {
      $conexion=new PDO("mysql:host=$host;dbname=$db",$usuario,$contrasenia);
     // if($conexion){echo "Conectado... a sistema";}

    } catch (Exception $ex ) {
  echo $ex->getMessage();
}  

?>