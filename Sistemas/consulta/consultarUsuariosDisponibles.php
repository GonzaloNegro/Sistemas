<?php
include("../particular/conexion.php");

$consulta = "SELECT ID_USUARIO, NOMBRE FROM usuarios WHERE ID_ESTADOUSUARIO = 1 ORDER BY NOMBRE ASC";
$resultado = mysqli_query($datos_base, $consulta);

echo "<option value='' selected disabled>- SELECCIONE -</option>";
while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<option value='" . $fila['ID_USUARIO'] . "'>" . strtoupper($fila['NOMBRE']) . "</option>";
}
?>
