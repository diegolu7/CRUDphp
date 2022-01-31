<?php include("../template/cabecera.php"); 
session_start()?>
 

<?php 
//verifico que el form es enviado
//print_r($_POST);
//print_r($_FILES);

//if ternario
//$txtID=(isset($_POST['name']))?cumple:nocumple;
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";

//verificamos que exista isset el nombre del a imagen
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

//echo $txtID."<br/>";
//echo $txtNombre."<br/>";
//echo $txtImagen."<br/>";

//echo $accion."<br/>";

//conectamos a la DB
include("../config/bd.php");

//canalizamos acciones
switch($accion){
  case "Agregar":
    $sentenciaSQL= $conexion->prepare("INSERT INTO libros (nombre, imagen) VALUES (:nombre, :imagen);");
    $sentenciaSQL->bindParam(':nombre',$txtNombre);

    //guardar imagenes en IMG
    $fecha = new DateTime();
    $nombreArchivo = ($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
    //imagen temporal
    $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

    //validamos si el tmpimg tiene algo
    if($tmpImagen!=""){
          move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
    }


    $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
    $sentenciaSQL->execute();
    header("Location:productos.php");

    break;

  case "Editar":
   // echo "Presiono boton editar";
    $sentenciaSQL=$conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
    $sentenciaSQL->bindParam(':nombre',$txtNombre);
    $sentenciaSQL->bindParam(':id',$txtID);
    $sentenciaSQL->execute();

    if($txtImagen!=""){
          $fecha = new DateTime();
          $nombreArchivo = ($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
          $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

          move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

          /*1° borramos el dato */
          $sentenciaSQL=$conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
          $sentenciaSQL->bindParam(':id',$txtID);
          $sentenciaSQL->execute();
          $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

          if(isset($libro['imagen']) && ($libro["imagen"]!="imagen.jpg") ){

              if(file_exists("../../img/".$libro["imagen"])){
                /*si existe la borro*/
                    unlink("../../img/".$libro["imagen"]);

              }
          }
          
          /*2° actualizamos con el nuevo nombre */
          $sentenciaSQL=$conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
          $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
          $sentenciaSQL->bindParam(':id',$txtID);
          $sentenciaSQL->execute();}
          header("Location:productos.php");
          break;

  case "Cancelar":
   // echo "Presiono boton cancelar";
        header("Location:productos.php");
    break;

  case "Seleccionar":
    //echo "Presiono boton Seleccionar";
    $sentenciaSQL=$conexion->prepare("SELECT * FROM libros WHERE id=:id");
    $sentenciaSQL->bindParam(':id',$txtID);
    $sentenciaSQL->execute();
    $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

    $txtNombre = $libro['nombre'];
    $txtImagen = $libro['imagen'];



    break;

  case "Borrar":

    $sentenciaSQL=$conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
    $sentenciaSQL->bindParam(':id',$txtID);
    $sentenciaSQL->execute();
    $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

    if(isset($libro['imagen']) && ($libro["imagen"]!="imagen.jpg") ){

        if(file_exists("../../img/".$libro["imagen"])){
          /*si existe la borro*/
              unlink("../../img/".$libro["imagen"]);

        }
    }



    
    //echo "Presiono boton Borrar";
    $sentenciaSQL=$conexion->prepare("DELETE FROM libros WHERE id=:id");
    $sentenciaSQL->bindParam(':id',$txtID);
    $sentenciaSQL->execute();

    header("Location:productos.php");
    break;

}
//armo tabla de recuperacion para mostrar DB
$sentenciaSQL=$conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

 
?>

<div class="col-md-5" >

  <div class="card">
    <div class="card-header">
      <b>Datos de Libro</b>
    </div>

    <div class="card-body">

      <form method="POST" enctype="multipart/form-data">

          <div class = "form-group">
            <label for="exampleInputEmail1"><b>ID:</b></label>
            <input  type="text"  class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID" required readonly>
          </div>

          <div class = "form-group">
            <label for="exampleInputEmail1"><b>Nombre:</b></label>
            <input type="text" class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre Libro" required>
          </div>


          <div class = "form-group">
            <label for="exampleInputEmail1"><b>Imagen:</b></label>

            <?php echo $txtImagen; ?>

            <br>

            <?php
            if($txtImagen=!""){?>

<center>  
            <img class="img-thumbnail rounded" src="../../img/<?php echo $libro['imagen']; ?>" width="150" alt="">
   
</center>

              <?php } ?>
            
            <input  type="file" class="form-control" name="txtImagen" id="txtImagen">
          </div>

          <div class="btn-group mt-3 " role="group" aria-label="">
            <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":"";?> value="Agregar" class="h6 btn btn-success">Agregar</button>
            <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"enabled":"";?> value="Editar" class="h6 btn btn-warning">Editar</button>
            <button type="submit" name="accion"   value="Cancelar" class="h6 btn btn-info">Cancelar</button>
          </div>

        </form>
    </div>
      
  </div>

  
  
</div>





<div class="col-md-7">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Imagen</th>
        <th>Acciones</th>

      </tr>
    </thead>
    <tbody>
    <?php
     foreach($listaLibros as $libro){ 
    ?>
      <tr>
        <td> <?php echo $libro['id']; ?> </td>
        <td> <?php echo $libro['nombre']; ?> </td>
        <td> 
          
            <img src="../../img/<?php echo $libro['imagen']; ?>" width="80" alt="Portada Libro">

            
       </td>
        
        <td>
          
            <!--Seleccionar | Borrar -->
        
            <form method="post">

                <input type="hidden" name="txtID" value="<?php echo $libro['id']; ?> ">

                <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">

                <input type="submit" name="accion" value="Borrar" class="btn btn-danger">

              </form>

        </td>

      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>


<?php include("../template/pie.php"); ?>
