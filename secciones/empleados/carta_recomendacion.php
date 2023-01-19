<?php
include("../../config/bd.php");

if(isset( $_GET['txtID'] )){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare("SELECT *,(SELECT nombredelpuesto 
    FROM tbl_puestos 
    WHERE tbl_puestos.id=tbl_empleados.idpuesto limit 1) as puesto FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

    $primerNombre = $registro["primerNombre"];
    $segundoNombre = $registro["segundoNombre"];
    $primerApellido = $registro["primerApellido"];
    $segundoApellido = $registro["segundoApellido"];

    $nombreCompleto=$primerNombre." ".$segundoNombre." ". $primerApellido." ".$segundoApellido;

    $foto = $registro["foto"];
    $cv = $registro["cv"];
    $idpuesto = $registro["idpuesto"];
    $puesto = $registro['puesto'];

    $fechadeingreso = $registro["fechadeingreso"];

    $fechaInicio= new DateTime($fechadeingreso);
    $fechaFin=new DateTime(date('Y-m-d'));
    $diferencia=date_diff($fechaInicio,$fechaFin);
    ob_start();
}

?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Carta de recomendación</title>
        </head>
        <body>
            
            <h1>Carta de Recomendación Laboral</h1>
            <br/><br/>
            San Salvador, El Salvador en fecha: <strong> <?= date('d M Y'); ?></strong>
            <br/><br/>
            A QUIEN CORRESPONDA:
            <br/><br/>
            Reciba un cordial y respetuoso saludo. 
            <br/><br/>
            A través de estas líneas, deseo hacer de su conocimiento que Sr(a) 
            <strong><?= $nombreCompleto;?></strong>, 
            quien laboró en mi organización durante 
            <strong> <?= $diferencia->y;?> año(s) </strong>
            es un ciudadano con una conducta intachable. Ha demostrado ser un gran trabajador, 
            comprometido, responsable y fiel cumplidor de sus tareas.
            Siempre ha manifestado preocupación por mejorar, capacitarse y actualizar sus conocimientos.
            <br/><br/>
            Durante estos años se ha desempeñado como:<strong><?= $puesto; ?> </strong>
            Es por ello le sugiero considere esta recomendación, con la confianza de que estará siempre a la altura de sus compromisos y responsabilidades.
            <br/><br/>
            Sin más nada a que referirme y, esperando que esta misiva sea tomada en cuenta, dejo mi número de contacto para cualquier información de interés.
            <br/><br/><br/><br/><br/><br/><br/><br/>
            ____________________________<br/>
            Atentamente,
            <br/>
            Ms.c. Luis Ramírez
        </body>
    </html>

<?php 
    $HTML=ob_get_clean();
    require_once("../../lib/autoload.inc.php");
    use Dompdf\Dompdf;
    $dompdf= new Dompdf();
    
    $opciones=$dompdf->getOptions();
    $opciones->set(array("isRemoteEnabled"=>true));
    $dompdf->setOptions($opciones);
    $dompdf->loadHTML($HTML);
    $dompdf->setPaper('letter');
    $dompdf->render();
    $dompdf->stream("archivo.pdf", array("Attachment"=>false));
?>
