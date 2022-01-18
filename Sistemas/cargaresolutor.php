<!--AGREGAR RESOLUTOR-->
<?php
include('conexion.php');

$resolutor = $_POST['nombre_resolutor'];
$cuil = $_POST['cuil'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];

mysqli_query($datos_base, "INSERT INTO resolutor VALUES (DEFAULT, '$resolutor', DEFAULT, '$cuil', '$correo', '$telefono')");
mysqli_close($datos_base);
header("Location: agregarresolutor.php?ok");
?>