<?php
include ("../../config/bd.php");

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("DELETE FROM tbl_puestos WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $mensaje = "Registro eliminado";
    header("Location:index.php?mensaje=".$mensaje);
}

$sentencia = $conexion -> prepare ("SELECT * FROM `tbl_puestos`");
$sentencia -> execute();
$lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

//print_r($lista_tbl_puestos);
?>

<!--Incluyendo el header-->
<?php include ("../../templates/header.php"); ?>

<?php if(isset($_GET['mensaje'])){ ?>

    <script>
        Swal.fire({
        icon: 'success',
        title: "<?php echo $_GET['mensaje']; ?>",
    })
    </script>

<?php } ?>


<br/>

<!--bs5-card-head-foot-->
<div class="card">
    <div class="card-header">
        <!--bs5-button-a-->
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar Puesto</a>
    </div>
    
    <div class="card-body">
        <!--bs5-table-default-->
        <div class="table-responsive-sm">
            <table class="table table-default" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre del Puesto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php foreach ($lista_tbl_puestos as $registro) { ?>
                        <tr class="">
                            <td><?= $registro['id']; ?></td>
                            <td><?= $registro['nombredelpuesto']; ?></td>

                            <td>
                                <a  class="btn btn-info" href="editar.php?txtID=<?= $registro['id'];?>" role="button">Editar</a>
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
<?php include ("../../templates/footer.php"); ?>