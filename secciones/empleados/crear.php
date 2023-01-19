<?php
include("../../config/bd.php");

if ($_POST) {

  $primerNombre = (isset($_POST["primerNombre"]) ? $_POST["primerNombre"] : "");
  $segundoNombre = (isset($_POST["segundoMombre"]) ? $_POST["segundoNombre"] : "");
  $primerApellido = (isset($_POST["primerApellido"]) ? $_POST["primerApellido"] : "");
  $segundoApellido = (isset($_POST["segundoApellido"]) ? $_POST["segundoApellido"] : "");

  $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");
  $cv = (isset($_FILES["cv"]['name']) ? $_FILES["cv"]['name'] : "");

  $idpuesto = (isset($_POST["idpuesto"]) ? $_POST["idpuesto"] : "");
  $fechadeingreso = (isset($_POST["fechadeingreso"]) ? $_POST["fechadeingreso"] : "");

  //Realizando el INSERT
  //INSERT INTO `tbl_empleados` 
  //(`id`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `foto`, `cv`, `idpuesto`, `fechadeingreso`) 
  //VALUES (NULL, 'Luis', 'Eduardo', 'Ramirez', 'Martinez', 'foto.jpg', 'cv.pdf', '1', '2023-01-17');
  $sentencia = $conexion->prepare("INSERT INTO 
  `tbl_empleados` (`id`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `foto`, `cv`, `idpuesto`, `fechadeingreso`) 
  VALUES (NULL,:primerNombre,:segundoNombre,:primerApellido,:segundoApellido,:foto,:cv,:idpuesto,:fechadeingreso);");

  //Reemplazando los datos en la BD
  $sentencia->bindParam(":primerNombre", $primerNombre);
  $sentencia->bindParam(":segundoNombre", $segundoNombre);
  $sentencia->bindParam(":primerApellido", $primerApellido);
  $sentencia->bindParam(":segundoApellido", $segundoApellido);

  //Adjuntando la foto
  $fecha_ = new DateTime();
  $nombreArchivo_foto = ($foto != '') ? $fecha_->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
  $tmp_foto = $_FILES["foto"]['tmp_name'];
  //Validación y Adjuntar Foto
  if ($tmp_foto != '') {
    move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto);
  }
  $sentencia->bindParam(":foto", $nombreArchivo_foto);

  //Validando y Adjuntando CV
  $nombreArchivo_cv = ($cv != '') ? $fecha_->getTimestamp() . "_" . $_FILES["cv"]['name'] : "";
  $tmp_cv = $_FILES["cv"]['tmp_name'];
  if ($tmp_cv != '') {
    move_uploaded_file($tmp_cv, "./" . $nombreArchivo_cv);
  }

  $sentencia->bindParam(":cv", $nombreArchivo_cv);
  $sentencia->bindParam(":idpuesto", $idpuesto);
  $sentencia->bindParam(":fechadeingreso", $fechadeingreso);

  //Ejecute las instrucciones
  $sentencia->execute();
  $mensaje = "Registro Agregado";
  header("Location:index.php?mensaje=".$mensaje);
}

$sentencia = $conexion->prepare("SELECT * FROM `tbl_puestos`");
$sentencia->execute();
$lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>


<!--Incluyendo el header-->
<?php include("../../templates/header.php"); ?>

<br />
<!--bs5-card-head-foot-->
<div class="card">
  <div class="card-header">
    Datos de Empleado
  </div>

  <div class="card-body">
    <!--form:post-->
    <!--enctype permite adjuntar archivos-->
    <form action="" method="post" enctype="multipart/form-data">

      <!--bs5-form-input-->
      <div class="mb-3">
        <label for="primerNombre" class="form-label">Primer Nombre</label>
        <input type="text" class="form-control" name="primerNombre" id="primerNombre" aria-describedby="helpId" placeholder="Primer Nombre">
      </div>

      <div class="mb-3">
        <label for="segundoNombre" class="form-label">Segundo Nombre</label>
        <input type="text" class="form-control" name="segundoNombre" id="segundoNombre" aria-describedby="helpId" placeholder="Segundo Nombre">
      </div>

      <div class="mb-3">
        <label for="primerApellido" class="form-label">Primer Apellido</label>
        <input type="text" class="form-control" name="primerApellido" id="primerApellido" aria-describedby="helpId" placeholder="Primer Apellido">
      </div>

      <div class="mb-3">
        <label for="segundoApellido" class="form-label">Segundo Apellido</label>
        <input type="text" class="form-control" name="segundoApellido" id="segundoApellido" aria-describedby="helpId" placeholder="Segundo Apellido">
      </div>

      <div class="mb-3">
        <label for="foto" class="form-label">Foto</label>
        <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">
      </div>

      <!--bs5-form-file-->
      <div class="mb-3">
        <label for="cv" class="form-label">CV(PDF)</label>
        <input type="file" class="form-control" name="cv" id="cv" placeholder="CV" aria-describedby="fileHelpId">
      </div>

      <!--bs5-form-select-custom-->
      <div class="mb-3">
        <label for="idpuesto" class="form-label">Puesto:</label>
        <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
          
          <?php foreach ($lista_tbl_puestos as $registro) { ?>
            <option value="<?= $registro['id'] ?>">
              <?= $registro['nombredelpuesto'] ?>
            </option>
          <?php }?>

        </select>
      </div>

      <!--bs5-form-email-->
      <div class="mb-3">
        <label for="fechadeingreso" class="form-label">Fecha de ingreso:</label>
        <input type="date" class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="abc@mail.com">
      </div>


      <!--bs5-button-default-->
      <button type="submit" class="btn btn-primary">Agregar registro</button>
      <!--bs5-button-a-->
      <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>

    </form>
  </div>
</div>

<!--Incluyendo el footer-->
<?php include("../../templates/footer.php"); ?>