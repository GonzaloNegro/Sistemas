<!--AGREGAR TIPIFICACIÓN-->
<?php
include('conexion.php');

$tipificacion = $_POST['tipificacion'];

mysqli_query($datos_base, "INSERT INTO tipificacion VALUES (DEFAULT, '$tipificacion')");
mysqli_close($datos_base);
header("Location: agregartipificacion.php?ok");
?>