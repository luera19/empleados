<?php
    $host ="localhost";
    $dbname = "app";
    $usuario = "root";
    $password = "";
    try{
        $conexion = new PDO ("mysql:host=$host;dbname=$dbname", $usuario, $password);
        if($conexion){
            //echo ("Conexión Exitosa...");
        }
    } catch (Exception $error){
        echo $error-> getMessage();
    }
?>
