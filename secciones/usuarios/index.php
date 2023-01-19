<?php
include("../../config/bd.php");

if(isset( $_GET['txtID'] )){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare("DELETE FROM tbl_usuarios WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    
    $mensaje = "Registro eliminado";
    header("Location:index.php?mensaje=".$mensaje);
}

$sentencia = $conexion->prepare("SELECT * FROM `tbl_usuarios`");
$sentencia->execute();
$lista_tbl_usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>


<!--Incluyendo el header-->
<?php include("../../templates/header.php"); ?>
<br />

<!--bs5-card-head-foot-->
<div class="card">
    <div class="card-header">
        <!--bs5-button-a-->
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar Usuarios</a>
    </div>

    <div class="card-body">
        <!--bs5-table-default-->
        <div class="table-responsive-sm">
            <table class="table table-default" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre del usuario</th>
                        <th scope="col">Contraseña</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lista_tbl_usuarios as $registro) { ?>

                        <tr class="">
                            <td scope="row"><?= $registro['id']; ?></td>
                            <td><?= $registro['usuario']; ?> </td>
                            <td>****</td>
                            <td><?= $registro['correo']; ?></td>
                            <td>
                                <a class="btn btn-info" href="editar.php?txtID=<?= $registro['id']; ?>" role="button">Editar</a>
                                |
                                <a  class="btn btn-danger" href="javascript:borrar(<?= $registro['id']; ?>);" role="button">Eliminar</a>

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