<?php
include("../particular/conexion.php");

$usuario = $_GET['usuario'];

$consulta = "SELECT cel.*, m.*, lc.*
    FROM celular cel
    INNER JOIN (
        SELECT lc1.*
        FROM lineacelular lc1
        INNER JOIN (
            SELECT ID_CELULAR, MAX(ID_LINEACELULAR) AS ultima
            FROM lineacelular
            GROUP BY ID_CELULAR
        ) ult ON lc1.ID_CELULAR = ult.ID_CELULAR AND lc1.ID_LINEACELULAR = ult.ultima
    ) lc ON cel.ID_CELULAR = lc.ID_CELULAR
    INNER JOIN modelo m ON cel.ID_MODELO = m.ID_MODELO
    WHERE lc.ID_USUARIO = $usuario
    AND lc.ID_LINEA = 0";
$ejecutar = mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));

$options .= "<option selected disabled=''>-SELECCIONE UNA-</option>";
foreach ($ejecutar as $linea) {
    $options .= "<option value='" . $linea['ID_CELULAR'] . "'>".$linea['IMEI']." | ".$linea['MODELO']."</option>";
}

$consulta_nro = "SELECT lc.*
    FROM lineacelular lc
    INNER JOIN (
        SELECT ID_LINEA, MAX(ID_LINEACELULAR) AS ultima
        FROM lineacelular
        GROUP BY ID_LINEA
    ) ult ON lc.ID_LINEA = ult.ID_LINEA AND lc.ID_LINEACELULAR = ult.ultima
    WHERE lc.ID_USUARIO = $usuario";
$nro_lineas = mysqli_query($datos_base, $consulta_nro) or die(mysqli_error($datos_base));
$nrolineas_us=mysqli_num_rows($nro_lineas);
$nro_filas=mysqli_num_rows($ejecutar);
if ($nrolineas_us<2 && $nro_filas<2) {
    $options .= "<option value=''>SIN CELULAR ASIGNADO</option>";
}

echo $options;
?>