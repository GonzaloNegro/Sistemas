<?php
include('conexion.php');
$cuil = $_POST['cuil'];
$nueva = $_POST['nuevaclave'];
$vieja = $_POST['vieja'];

$resultados = mysqli_query($datos_base, "SELECT * FROM resolutor WHERE CUIL = '$cuil' and CONTRASEÑA = '$vieja'");
if($consulta = mysqli_fetch_array($resultados)){
    mysqli_query($datos_base, "UPDATE resolutor SET CONTRASEÑA = '$nueva' WHERE CUIL = '$cuil'");
    header("Location: contraseña.php?ok");
    mysqli_close($datos_base);
} else {
    header("Location: contraseña.php?error");
    mysqli_close($datos_base);
}
?>