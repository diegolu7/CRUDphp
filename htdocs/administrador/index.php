<?php

session_start();
if($_POST){
  if(($_POST['usuario']=="admin")&&($_POST['contrasenia']=="123456")) {

/*2:45 */
    //variables de sesion
    $_SESSION['usuario']="ok";
    $_SESSION['nombreUsuario']="admin";

     header('Location:inicio.php');

  }else{
    $mensaje="Usuario/Clave Incorrectos.";
  }
  }

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administrador</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <div class="row">

      <div class="col-md-4"></div>
      <div class="col-md-4">

        <div class="card">
          <div class="card-header ">
            Login Administrador
          </div>
          <div class="card-body">

            <form method="POST">
              <fieldset>
                <div class="form-group">
                  <label class="form-label mt-0">Usuario</label>
                  <input type="text" class="form-control" name="usuario" aria-describedby="emailHelp" placeholder="Ingrese su usuario" required>
                </div>
                <div class="form-group">
                  <label class="form-label mt-3">Contraseña</label>
                  <input type="password" class="form-control" name="contrasenia" placeholder="Escriba su contraseña"  required>
                </div>

                <?php if(isset($mensaje)){ ?>

                <div class="alert alert-dismissible alert-danger mt-3" role="alert">
                  <?php echo $mensaje; ?>
                </div>
                <?php } ?>
                <button type="submit" class="btn btn-primary mt-3">Entrar</button>
              </fieldset>
            </form>





          </div>
 
        </div>
        
      </div>
      
    </div>
  </div>
  
</body>
</html>