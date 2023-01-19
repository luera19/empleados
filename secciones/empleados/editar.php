<?php
include("../../config/bd.php");
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);


    $primerNombre = $registro["primerNombre"];
    $segundoNombre = $registro["segundoNombre"];
    $primerApellido = $registro["primerApellido"];
    $segundoApellido = $registro["segundoApellido"];

    $foto = $registro["foto"];
    $cv = $registro["cv"];

    $idpuesto = $registro["idpuesto"];
    $fechadeingreso = $registro["fechadeingreso"];

    $sentencia = $conexion->prepare("SELECT * FROM `tbl_puestos`");
    $sentencia->execute();
    $lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}
if ($_POST) {
    //Actualización de información
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $primerNombre = (isset($_POST["primerNombre"]) ? $_POST["primerNombre"] : "");
    $segundoNombre = (isset($_POST["segundoNombre"]) ? $_POST["segundoNombre"] : "");
    $primerApellido = (isset($_POST["primerApellido"]) ? $_POST["primerApellido"] : "");
    $segundoApellido = (isset($_POST["segundoApellido"]) ? $_POST["segundoApellido"] : "");
    
    $idpuesto = (isset($_POST["idpuesto"]) ? $_POST["idpuesto"] : "");
    $fechadeingreso = (isset($_POST["fechadeingreso"]) ? $_POST["fechadeingreso"] : "");
    //Sentencia SQL
    $sentencia = $conexion->prepare("
    UPDATE tbl_empleados 
    SET 
        primerNombre=:primerNombre,
        segundoNombre=:segundoNombre,
        primerApellido=:primerApellido,
        segundoApellido=:segundoApellido,
        idpuesto=:idpuesto,
        fechadeingreso=:fechadeingreso
    WHERE id=:id
    ");

    $sentencia->bindParam(":primerNombre", $primerNombre);
    $sentencia->bindParam(":segundoNombre", $segundoNombre);
    $sentencia->bindParam(":primerApellido", $primerApellido);
    $sentencia->bindParam(":segundoApellido", $segundoApellido);
    $sentencia->bindParam(":idpuesto", $idpuesto);
    $sentencia->bindParam(":fechadeingreso", $fechadeingreso);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    //Validación de Foto para actualización
    $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");
    //Creamos variable fecha (para que el archivo de imagen y cv haya diferencia por fecha)
    $fecha_ = new DateTime();
    $nombreArchivo_foto = ($foto != '') ? $fecha_->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
    $tmp_foto = $_FILES["foto"]['tmp_name'];

    //Si se envía foto
    if ($tmp_foto != '') {
        //hacemos copia de foto en ubicación
        move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto);
        //Busca foto anterior
        $sentencia = $conexion->prepare("SELECT foto FROM `tbl_empleados` WHERE id=:id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
        //Si la encontramos
        if (isset($registro_recuperado["foto"]) && $registro_recuperado["foto"] != "") {
            //Se borra con unlink
            if (file_exists("./" . $registro_recuperado["foto"])) {
                unlink("./" . $registro_recuperado["foto"]);
            }
        }
        //Actualiza con foto nueva
        $sentencia = $conexion->prepare("UPDATE tbl_empleados SET foto=:foto WHERE id=:id");
        $sentencia->bindParam(":foto", $nombreArchivo_foto);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }

    //Validación de CV para actualización (Mismo proceso que en foto)
    $cv = (isset($_FILES["cv"]['name']) ? $_FILES["cv"]['name'] : "");
    $nombreArchivo_cv = ($cv != '') ? $fecha_->getTimestamp() . "_" . $_FILES["cv"]['name'] : "";
    $tmp_cv = $_FILES["cv"]['tmp_name'];
    //Si se envia un CV
    if ($tmp_cv != '') {
        move_uploaded_file($tmp_cv, "./" . $nombreArchivo_cv);

        //Buscar el archivo relacionado con el empleado
        $sentencia = $conexion->prepare("SELECT cv FROM `tbl_empleados` WHERE id=:id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
        //Si lo encontramos
        if (isset($registro_recuperado["cv"]) && $registro_recuperado["cv"] != "") {
            //Se borra el archivo con unlink
            if (file_exists("./" . $registro_recuperado["cv"])) {
                unlink("./" . $registro_recuperado["cv"]);
            }
        }
        //Actualiza CV con nuevo archivo
        $sentencia = $conexion->prepare("UPDATE tbl_empleados SET cv=:cv WHERE id=:id");
        $sentencia->bindParam(":cv", $nombreArchivo_cv);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }
    //Redireccionamiento
    $mensaje = "Registro Actualizado";
    header("Location:index.php?mensaje=".$mensaje);
}

?>

<!--Incluyendo el header-->
<?php include("../../templates/header.php"); ?>

<br />
<div class="card">
    <div class="card-header">
        Datos del empleado
    </div>
    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data">
            <!--ID-->
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input type="text" value="<?= $txtID; ?>" class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
            </div>
            <!--Primer Nombre-->
            <div class="mb-3">
                <label for="primerNombre" class="form-label">Primer nombre</label>
                <input type="text" value="<?= $primerNombre; ?>" class="form-control" name="primerNombre" id="primerNombre" aria-describedby="helpId" placeholder="Primer nombre">
            </div>
            <!--Segundo Nombre-->
            <div class="mb-3">
                <label for="segundoNombre" class="form-label">Segundo nombre</label>
                <input type="text" value="<?= $segundoNombre; ?>" class="form-control" name="segundoNombre" id="segundoNombre" aria-describedby="helpId" placeholder="Segundo nombre">
            </div>
            <!--Primer Apellido-->
            <div class="mb-3">
                <label for="primerApellido" class="form-label">Primer apellido</label>
                <input type="text" value="<?= $primerApellido; ?>" class="form-control" name="primerApellido" id="primerApellido" aria-describedby="helpId" placeholder="Primer apellido">
            </div>
            <!--Segundo Apellido-->
            <div class="mb-3">
                <label for="segundoApellido" class="form-label">Segundo apellido</label>
                <input type="text" value="<?= $segundoApellido; ?>" class="form-control" name="segundoApellido" id="segundoApellido" aria-describedby="helpId" placeholder="Segundo apellido">
            </div>
            <!--Foto-->
            <div class="mb-3">
                <label for="" class="form-label">Foto:</label>
                <br />
                <img width="100" src="<?= $foto; ?>" class="rounded" alt="" />
                <br /> <br />
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">
            </div>
            <!--CV-->    
            <div class="mb-3">
                <label for="cv" class="form-label">CV(PDF):</label>
                <br />
                <a href="<?= $cv; ?>"><?= $cv; ?></a>
                <input type="file" class="form-control" name="cv" id="cv" placeholder="CV" aria-describedby="fileHelpId">
            </div>
            <!--Puestos-->
            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puesto:</label>
                <!--Seleccionando puestos-->
                <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                    <?php foreach ($lista_tbl_puestos as $registro) { ?>
                        <option <?= ($idpuesto == $registro['id']) ? "selected" : ""; ?> value="<?= $registro['id'] ?>">
                            <?= $registro['nombredelpuesto'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <!--Fecha Ingreso-->                
            <div class="mb-3">
                <label for="fechadeingreso" class="form-label">Fecha de ingreso:</label>
                <input value="<?= $fechadeingreso; ?>" type="date" class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="Fecha de ingreso">
            </div>
            <!--Buttons-->            
            <button type="submit" class="btn btn-success">Actualizar registro</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<!--Incluyendo el footer-->
<?php include("../../templates/footer.php"); ?>