<?php
include("../../config/bd.php");

if ($_POST) {

  // Recolectamos los datos del método POST
  $usuario = (isset($_POST["usuario"]) ? $_POST["usuario"] : "");
  $password = (isset($_POST["password"]) ? $_POST["password"] : "");
  $correo = (isset($_POST["correo"]) ? $_POST["correo"] : "");

  // Preparar la insercción de los datos 
  $sentencia = $conexion->prepare("INSERT INTO tbl_usuarios (id,usuario,password,correo)
   VALUES (NULL,:usuario,:password,:correo) ");
  // Asigna valores que tienen uso de :variable 
  $sentencia->bindParam(":usuario", $usuario);
  $sentencia->bindParam(":password", $password);
  $sentencia->bindParam(":correo", $correo);
  $sentencia->execute();
  $mensaje = "Registro Agregado";
  header("Location:index.php?mensaje=".$mensaje);
}

?>

<!--Incluyendo el header-->
<?php include("../../templates/header.php"); ?>

<br />
<!--bs5-card-head-foot-->

<div class="card">
  <div class="card-header">
    Datos del Usuario
  </div>
  <div class="card-body">
    <!--form:post-->
    <!--enctype permite adjuntar archivos-->
    <form action="" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="usuario" class="form-label">Nombre del usuario:</label>
        <input type="text" class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Nombre del usuario">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Escriba su contraseña">
      </div>

      <div class="mb-3">
        <label for="correo" class="form-label">Correo:</label>
        <input type="email" class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Correo del usuario">
      </div>

      <button type="submit" class="btn btn-success">Agregar</button>
      <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

    </form>


  </div>

</div>


<!--Incluyendo el footer-->
<?php include("../../templates/footer.php"); ?>