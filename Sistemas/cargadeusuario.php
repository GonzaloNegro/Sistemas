<?php
include('conexion.php');

$nombre = $_POST['nombre_usuario'];
$cuil = $_POST['cuil'];
$area = $_POST['area'];
$piso = $_POST['piso'];
$int = $_POST['interno'];
$tel = $_POST['telefono_personal'];
$correo = $_POST['correo'];
$correop = $_POST['correo_personal'];


mysqli_query($datos_base, "INSERT INTO usuarios VALUES (DEFAULT, '$nombre', '$cuil', DEFAULT, '$area', '$piso', '$int', '$correo', '$correop', '$tel')"); 
mysqli_close($datos_base);
header("Location: agregarusuario.php?ok");
?>