<?php
include("../../config/bd.php");

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    //Buscar el archivo relacionado con el empleado
    $sentencia = $conexion->prepare("SELECT foto,cv FROM `tbl_empleados` WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

    //Validación de foto
    if (isset($registro_recuperado["foto"]) && $registro_recuperado["foto"] != "") {
        if (file_exists("./" . $registro_recuperado["foto"])) {
            unlink("./" . $registro_recuperado["foto"]);
        }
    }

    //Validación de CV
    if (isset($registro_recuperado["cv"]) && $registro_recuperado["cv"] != "") {
        if (file_exists("./" . $registro_recuperado["cv"])) {
            unlink("./" . $registro_recuperado["cv"]);
        }
    }

    $sentencia = $conexion->prepare("DELETE FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);

    $sentencia->execute();
    $mensaje = "Registro eliminado";
    header("Location:index.php?mensaje=".$mensaje);
}

$sentencia = $conexion->prepare("SELECT *,
(SELECT nombredelpuesto 
FROM tbl_puestos 
WHERE tbl_puestos.id=tbl_empleados.idpuesto limit 1) as puesto
FROM `tbl_empleados`");
$sentencia->execute();
$lista_tbl_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<!--Incluyendo el header-->
<?php include("../../templates/header.php"); ?>

<br />
<div class="card">
    <div class="card-header">


        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">
            Agregar registro
        </a>

    </div>
    <div class="card-body">

        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Foto</th>
                        <th scope="col">CV</th>
                        <th scope="col">Puesto</th>
                        <th scope="col">Fecha de ingreso </th>
                        <th scope="col">Acciones </th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lista_tbl_empleados as $registro) { ?>

                        <tr class="">
                            <td><?= $registro['id']; ?></td>
                            <td scope="row">
                                <?= $registro['primerNombre']; ?>
                                <?= $registro['segundoNombre']; ?>
                                <?= $registro['primerApellido']; ?>
                                <?= $registro['segundoApellido']; ?>
                            </td>

                            <td>
                                <img width="50" 
                                    src="<?= $registro['foto']; ?>" 
                                    class="img-fluid rounded" alt="" />
                                
                            </td>

                            <td>
                                <a href="<?= $registro['cv']; ?>">
                                        <?= $registro['cv']; ?>
                                </a>
                            </td>

                            <td><?= $registro['puesto']; ?> </td>
                            <td><?= $registro['fechadeingreso']; ?> </td>

                            <td>
                                  <a href="carta_recomendacion.php?txtID=<?= $registro['id']; ?>" class="btn btn-primary" role="button">Carta</a>
                                | <a class="btn btn-info" href="editar.php?txtID=<?= $registro['id']; ?>" role="button">Editar</a>
                                | <a  class="btn btn-danger" href="javascript:borrar(<?= $registro['id']; ?>);" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>



    </div>

</div>

<!--Incluyendo el footer-->
<?php include("../../templates/footer.php"); ?>