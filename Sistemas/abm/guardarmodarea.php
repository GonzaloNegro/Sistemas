<?php
session_start();
include('../particular/conexion.php');
date_default_timezone_set('America/Argentina/Buenos_Aires'); // Configura la zona horaria de Argentina
$hora_actual = date("H:i:s"); // Formato de hora: HH:mm:ss

/*BUSCO EL RESOLUTOR PARA agregados*/
$cuil = $_SESSION['cuil'];

$sqli = "SELECT RESOLUTOR FROM resolutor WHERE CUIL = '$cuil'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$resolutorActivo = $row2['RESOLUTOR'];



$area = $_POST['area'];
$repa = $_POST['repa'];
$est = $_POST['estado'];
$obs = $_POST['obs'];

/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
$sqli = "SELECT * FROM area WHERE AREA = '$area' AND ID_REPA ='$repa'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$are = $row2['AREA'];
$rep = $row2['ID_REPA'];

$fecha = date('Y-m-d');

if($area == $are AND $repa == $rep){ 
    header("Location: agregararea.php?no");
}
else{

    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'ÁREA', '$area', '$fecha', '$hora_actual', '$resolutorActivo')");

    mysqli_query($datos_base, "INSERT INTO area VALUES (DEFAULT, '$area', '$repa', '$est', '$obs')");
    header("Location: agregararea.php?ok");
}
mysqli_close($datos_base);
?>