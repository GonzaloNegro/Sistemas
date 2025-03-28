<?php
include("../particular/conexion.php");

$usuario = $_GET['usuario'];

$consulta = "SELECT * FROM linea l INNER JOIN lineacelular c ON c.ID_LINEA=l.ID_LINEA WHERE c.ID_USUARIO=$usuario AND c.ID_CELULAR=0";
$ejecutar = mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));

$options .= "<option selected disabled=''>-SELECCIONE UNA-</option>";
foreach ($ejecutar as $linea) {
    $options .= "<option value='" . $linea['ID_LINEA'] . "'>" . $linea['NRO'] . "</option>";
}

$consulta_nro = "SELECT * FROM lineacelular WHERE ID_USUARIO=$usuario";
$nro_lineas = mysqli_query($datos_base, $consulta_nro) or die(mysqli_error($datos_base));
$nrolineas_us=mysqli_num_rows($nro_lineas);
$nro_filas=mysqli_num_rows($ejecutar);
if ($nrolineas_us<2 && $nro_filas<2) {
    $options .= "<option value=''>SIN LINEA ASIGNADA</option>";
}

echo $options;
?>