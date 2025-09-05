<?php
include("../particular/conexion.php");

$usuario = $_GET['usuario'];

$consulta = "SELECT c.ID_LINEA, l.NRO FROM linea l
INNER JOIN lineacelular c ON c.ID_LINEA = l.ID_LINEA
INNER JOIN (
    SELECT ID_LINEA, MAX(ID_LINEACELULAR) AS ultima
    FROM lineacelular
    GROUP BY ID_LINEA
) t ON t.ID_LINEA = c.ID_LINEA AND t.ultima = c.ID_LINEACELULAR
WHERE c.ID_USUARIO = $usuario
  AND c.ID_CELULAR = 0;";
$ejecutar = mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));

$options .= "<option selected disabled=''>-SELECCIONE UNA-</option>";
foreach ($ejecutar as $linea) {
    $options .= "<option value='" . $linea['ID_LINEA'] . "'>" . $linea['NRO'] . "</option>";
}

$consulta_nro = "SELECT *
FROM (
    SELECT lc.ID_LINEA
    FROM lineacelular lc
    INNER JOIN (
        SELECT ID_LINEA, MAX(ID_LINEACELULAR) AS ultima
        FROM lineacelular
        GROUP BY ID_LINEA
    ) t ON lc.ID_LINEA = t.ID_LINEA AND lc.ID_LINEACELULAR = t.ultima
    WHERE lc.ID_USUARIO = $usuario
) AS actuales;";
$nro_lineas = mysqli_query($datos_base, $consulta_nro) or die(mysqli_error($datos_base));
$nrolineas_us=mysqli_num_rows($nro_lineas);
$nro_filas=mysqli_num_rows($ejecutar);
if ($nrolineas_us<2 && $nro_filas<2) {
    $options .= "<option value='0'>SIN LINEA ASIGNADA</option>";
}

echo $options;
?>