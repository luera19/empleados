<?php 
include ("../../config/bd.php");

if(isset( $_GET['txtID'] )){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare("SELECT * FROM tbl_puestos WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);
    $nombredelpuesto=$registro["nombredelpuesto"];
}
if($_POST){
    
        // Recolectamos los datos del método POST
        $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
        $nombredelpuesto=(isset($_POST["nombredelpuesto"])?$_POST["nombredelpuesto"]:"");

        // Preparar la insercción de los datos 
        $sentencia=$conexion->prepare("UPDATE tbl_puestos 
        SET nombredelpuesto=:nombredelpuesto 
        WHERE id=:id ");
        // Asignando los valores que vienen del método POST ( Los que vienen del formulario)
        $sentencia->bindParam(":nombredelpuesto",$nombredelpuesto);
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
        $mensaje = "Registro Actualizado";
        header("Location:index.php?mensaje=".$mensaje);
    }
?>

<!--Incluyendo el header-->
<?php include ("../../templates/header.php"); ?>
<br />
<!--bs5-card-head-foot-->

<div class="card">
    <div class="card-header">
        Puestos
    </div>
    <div class="card-body">
        <!--form:post-->
        <!--enctype permite adjuntar archivos-->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
            <label for="txtID" class="form-label">ID:</label>
            <!--ID-->
            <input type="text"
                value="<?= $txtID;?>"
                class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
            </div>   
            <!--Nombre del puesto-->
            <div class="mb-3">
              <label for="nombredelpuesto" class="form-label">Nombre del puesto:</label>
              <input type="text"
                value="<?= $nombredelpuesto;?>"
                class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="Nombre del puesto">
            </div>
            <!--button-->
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
</div>

<!--Incluyendo el footer-->
<?php include ("../../templates/footer.php"); ?>