<!--AGREGAR AREA-->
<?php
include('conexion.php');

$area = $_POST['area'];

mysqli_query($datos_base, "INSERT INTO area VALUES (DEFAULT, '$area')");
mysqli_close($datos_base);
header("Location: agregararea.php?ok");
?>