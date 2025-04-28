<?php
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) {
    header('Location: ../index.php');
    exit();
}

function valorPorDefecto($valor) {
    return (isset($valor) && trim($valor) !== "") 
        ? $valor 
        : "-";
}

function generarBloqueHTML($label, $valor) {
    return "
        <div style='width:100%;display:flex;justify-content:space-between;align-items: flex-start;'>
            <label style='color:black;'>$label:</label>
            <label style='color:black;'>$valor</label>
        </div>";
}

function obtenerValor($conexion, $query, $campo) {
    $res = mysqli_fetch_assoc(mysqli_query($conexion, $query));
    return isset($res[$campo]) ? $res[$campo] : "-";
}


$idPeri = $_POST['idPeri'];

// Obtener datos del periférico (una sola vez)
$consultaPeri = mysqli_query($datos_base, "SELECT * FROM periferico WHERE ID_PERI = '$idPeri'");
if ($consulta = mysqli_fetch_assoc($consultaPeri)) {
    // Obtener valores de tablas relacionadas
    $tipoperi    = obtenerValor($datos_base, "SELECT TIPO FROM tipop WHERE ID_TIPOP = {$consulta['ID_TIPOP']}", 'TIPO');
    $marca       = obtenerValor($datos_base, "SELECT MARCA FROM marcas WHERE ID_MARCA = {$consulta['ID_MARCA']}", 'MARCA');
    $procedencia = obtenerValor($datos_base, "SELECT PROCEDENCIA FROM procedencia WHERE ID_PROCEDENCIA = {$consulta['ID_PROCEDENCIA']}", 'PROCEDENCIA');
    $proveedor   = obtenerValor($datos_base, "SELECT PROVEEDOR FROM proveedor WHERE ID_PROVEEDOR = {$consulta['ID_PROVEEDOR']}", 'PROVEEDOR');
    $estadoWs    = obtenerValor($datos_base, "SELECT ESTADO FROM estado_ws WHERE ID_ESTADOWS = {$consulta['ID_ESTADOWS']}", 'ESTADO');
    $modelo      = obtenerValor($datos_base, "SELECT MODELO FROM modelo WHERE ID_MODELO = {$consulta['ID_MODELO']}", 'MODELO');

    $color = 'blue';
    if ($estadoWs === 'EN USO') {
        $color = 'green';
    } elseif ($estadoWs === 'BAJA') {
        $color = 'red';
    }

    $estadoFormateado = "<span style='color: $color;'>$estadoWs</span>";

    $campos = [
        "Tipo Periférico" => valorPorDefecto($consulta['TIPOP']) . ' - ' . $tipoperi,
        "Marca y Modelo" => $marca . ' - ' . $modelo,
        "Estado" => $estadoFormateado,
        "Serie Gobierno" => valorPorDefecto($consulta['SERIEG']),
        "Serie" => valorPorDefecto($consulta['SERIE']),
        "Procedencia" => $procedencia,
        "MAC" => valorPorDefecto($consulta['MAC']),
        "IP" => valorPorDefecto($consulta['IP']),
        "Reserva IP" => valorPorDefecto($consulta['RIP']),
        "Proveedor" => $proveedor,
        "Factura" => valorPorDefecto($consulta['FACTURA']),
        "Garantía" => valorPorDefecto($consulta['GARANTIA']),
        "Observación" => valorPorDefecto($consulta['OBSERVACION'])
    ];

    foreach ($campos as $label => $valor) {
        echo generarBloqueHTML($label, $valor);
    }

    echo '<hr style="display: block; height: 3px;">';
}
?>

<div id="grilla">
    <h2 style="color:#00519C;font-size: 20px;font-weight: bold;">MOVIMIENTOS</h2>
    <table width="auto">
        <thead>
            <tr>
                <th><p style="font-size:15px;">FECHA</p></th>
                <th><p style="font-size:15px;text-align:left;margin-left:3px;">ÁREA</p></th>
                <th><p style="font-size:15px;text-align:left;margin-left:3px;">USUARIO</p></th>
                <th><p style="font-size:15px;text-align:left;margin-left:3px;">ESTADO</p></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $consultaMovs = mysqli_query($datos_base, "SELECT * FROM movimientosperi WHERE ID_PERI = '$idPeri'");
            while ($mov = mysqli_fetch_assoc($consultaMovs)) {
                $fecha = valorPorDefecto(date("d-m-Y", strtotime($mov['FECHA'])));
                $area  = obtenerValor($datos_base, "SELECT AREA FROM area WHERE ID_AREA = {$mov['ID_AREA']}", "ÁREA");
                $usu = obtenerValor($datos_base, "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = {$mov['ID_USUARIO']}", 'NOMBRE');
                $estado = obtenerValor($datos_base, "SELECT ESTADO FROM estado_ws WHERE ID_ESTADOWS = {$mov['ID_ESTADOWS']}", 'ESTADO');
                
                $color = 'blue';
                if ($estado === 'EN USO') {
                    $color = 'green';
                } elseif ($estado === 'BAJA') {
                    $color = 'red';
                }

                echo "
                <tr>
                    <td><h4 style='font-size:15px;padding:3px;min-width:100px;'>$fecha</h4></td>
                    <td><h4 style='font-size:15px;padding:3px;text-align:left;margin-left:3px;'>$area</h4></td>
                    <td><h4 style='font-size:15px;padding:3px;text-align:left;margin-left:3px;'>$usu</h4></td>
                    <td><h4 style='font-size:15px;padding:3px;text-align:left;margin-left:3px;color:".$color."'>$estado</h4></td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
