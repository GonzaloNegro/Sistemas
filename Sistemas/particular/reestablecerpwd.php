<?php
include('../particular/conexion.php');
$cuil = $_POST['cuil'];
$nueva = "1234";

$resultados = mysqli_query($datos_base, "SELECT * FROM resolutor WHERE CUIL = '$cuil'");
if($consulta = mysqli_fetch_array($resultados)){
    mysqli_query($datos_base, "UPDATE resolutor SET CONTRASEÑA = '$nueva' WHERE CUIL = '$cuil'");
    header("Location: olvidecontraseña.php?ok");
    mysqli_close($datos_base);
} else {
    header("Location: olvidecontraseña.php?error");
    mysqli_close($datos_base);
}
?>