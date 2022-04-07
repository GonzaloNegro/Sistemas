<!--AGREGAR RESOLUTOR-->
<?php
include('conexion.php');

$resolutor = $_POST['nombre_resolutor'];
$cuil = $_POST['cuil'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$tipo = $_POST['tipo'];

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$sql = "SELECT RESOLUTOR, CUIL FROM resolutor WHERE RESOLUTOR = '$resolutor' OR CUIL='$cuil'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$res = $row['RESOLUTOR'];
$cui = $row['CUIL'];

$fecha = date('Y-m-d');

if($cuil == $cui)
{
    header("Location: agregarresolutor.php?no");
}
else if($resolutor == $res)
{
    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'RESOLUTOR', '$resolutor', '$fecha')");

    mysqli_query($datos_base, "INSERT INTO resolutor VALUES (DEFAULT, '$resolutor', '$tipo', '$cuil', '$correo', '$telefono', 1234)");
    header("Location: agregarresolutor.php?repeat");
}
else
{
    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'RESOLUTOR', '$resolutor', '$fecha')");
    
    mysqli_query($datos_base, "INSERT INTO resolutor VALUES (DEFAULT, '$resolutor', '$tipo', '$cuil', '$correo', '$telefono', 1234)"); 
header("Location: agregarresolutor.php?ok");
}
mysqli_close($datos_base);
?>


