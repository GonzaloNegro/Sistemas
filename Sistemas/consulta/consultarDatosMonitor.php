<?php
session_start();
error_reporting(0);
include('../particular/conexion.php');

if (!isset($_SESSION['cuil'])) {
    header('Location: ../index.php');
    exit();
}

$idPeri = $_POST['idPeri'];

function valorPorDefecto($valor) {
    return !empty($valor) ? $valor : '-';
}

function generarBloqueHTML($etiqueta, $valor) {
    return "
        <div style='width:100%;display:flex;justify-content:space-between;align-items: flex-start;'>
            <label>$etiqueta:</label><label>$valor</label>
        </div>";
}

function obtenerValor($conexion, $query, $campo) {
    $res = mysqli_fetch_assoc(mysqli_query($conexion, $query));
    return $res[$campo] ?? '-';
}

function obtenerMarcaModelo($conexion, $idModelo, $idMarca) {
    $query = "
        SELECT ma.MARCA, mo.MODELO 
        FROM modelo mo 
        JOIN marcas ma ON ma.ID_MARCA = '$idMarca'
        WHERE mo.ID_MODELO = '$idModelo'
    ";
    return mysqli_fetch_assoc(mysqli_query($conexion, $query));
}

    $result = mysqli_query($datos_base, "
        SELECT p.*, u.ID_AREA, u.ID_USUARIO 
        FROM periferico p 
        LEFT JOIN equipo_periferico ep ON p.ID_PERI = ep.ID_PERI
        LEFT JOIN inventario i ON ep.ID_WS = i.ID_WS
        LEFT JOIN wsusuario ws ON i.ID_WS = ws.ID_WS
        LEFT JOIN usuarios u ON ws.ID_USUARIO = u.ID_USUARIO
        WHERE p.ID_PERI = '$idPeri'
    ");

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_array($result);

        $usuario      = obtenerValor($datos_base, "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO='{$data['ID_USUARIO']}'", 'NOMBRE');
        $area         = obtenerValor($datos_base, "SELECT a.AREA FROM area a JOIN usuarios u ON a.ID_AREA = u.ID_AREA WHERE u.ID_AREA='{$data['ID_AREA']}'", 'AREA');
        $reparticion  = obtenerValor($datos_base, "SELECT r.REPA FROM area a LEFT JOIN reparticion r ON r.ID_REPA = a.ID_REPA WHERE a.ID_AREA='{$data['ID_AREA']}'", 'REPA');
        $estadoWs     = obtenerValor($datos_base, "SELECT ESTADO FROM estado_ws WHERE ID_ESTADOWS='{$data['ID_ESTADOWS']}'", 'ESTADO');
        $tipoP        = obtenerValor($datos_base, "SELECT TIPO FROM tipop WHERE ID_TIPOP='{$data['ID_TIPOP']}'", 'TIPO');
        $procedencia  = obtenerValor($datos_base, "SELECT PROCEDENCIA FROM procedencia WHERE ID_PROCEDENCIA='{$data['ID_PROCEDENCIA']}'", 'PROCEDENCIA');
        $proveedor    = obtenerValor($datos_base, "SELECT PROVEEDOR FROM proveedor WHERE ID_PROVEEDOR='{$data['ID_PROVEEDOR']}'", 'PROVEEDOR');
        $marcaModelo  = obtenerMarcaModelo($datos_base, $data['ID_MODELO'], $data['ID_MARCA']);

        $bloques = [
            ['Monitor', valorPorDefecto($marcaModelo['MODELO'] ?? '')],
            ['Marca', valorPorDefecto($marcaModelo['MARCA'] ?? '')],
            ['N° Serie Gob', valorPorDefecto($data['SERIEG'])],
            ['N° Serie', valorPorDefecto($data['SERIE'])],
            ['Procedencia', valorPorDefecto($procedencia)],
            ['Tipo Monitor', valorPorDefecto($tipoP)],
            ['Estado', valorPorDefecto($estadoWs)],
            ['__SEPARADOR__'], // para agregar línea horizontal
            ['Usuario Responsable', valorPorDefecto($usuario)],
            ['Área', valorPorDefecto($area)],
            ['Repartición', valorPorDefecto($reparticion)],
            ['Proveedor', valorPorDefecto($proveedor)],
            ['N° Factura', valorPorDefecto($data['FACTURA'])],
            ['Garantía', valorPorDefecto($data['GARANTIA'])],
            ['Observación', valorPorDefecto($data['OBSERVACION'])]
        ];

        foreach ($bloques as $bloque) {
            if ($bloque[0] === '__SEPARADOR__') {
                echo "<hr style='display: block; height: 3px;'>";
            } else {
                echo generarBloqueHTML($bloque[0], $bloque[1]);
            }
        }
    }

    $result = mysqli_query($datos_base, "
        SELECT m.FECHA, u.NOMBRE, a.AREA, e.ESTADO 
        FROM movimientosperi m 
        LEFT JOIN usuarios u ON u.ID_USUARIO = m.ID_USUARIO 
        LEFT JOIN area a ON a.ID_AREA = m.ID_AREA 
        LEFT JOIN estado_ws e ON e.ID_ESTADOWS = m.ID_ESTADOWS 
        WHERE m.ID_PERI = '$idPeri' 
        ORDER BY m.FECHA ASC
    ");

    if (mysqli_num_rows($result) > 0) {
        echo "<hr style='display: block; height: 3px;'>
        <div id='grilla'>
            <h2 style='color:#53AAE0;font-size: 20px;font-weight: bold;'>MOVIMIENTOS</h2>
            <table width='100%'>
                <thead>
                    <tr>
                        <th><p class='g'>FECHA</p></th>
                        <th><p class='g' style='text-align:left;margin-left:5px;'>USUARIO</p></th>
                        <th><p class='g' style='text-align:left;margin-left:5px;'>ÁREA</p></th>
                        <th><p class='g'>ESTADO</p></th>
                    </tr>
                </thead>";

        while ($row = mysqli_fetch_array($result)) {
            $fecha = date("d-m-Y", strtotime($row['FECHA']));
            echo "
                <tr>
                    <td style='min-width:100px;'><h4 style='font-size:16px;text-align: center;'>$fecha</h4></td>
                    <td style='min-width:150px;'><h4 style='font-size:16px;text-align: left;margin-left:5px;'>{$row['NOMBRE']}</h4></td>
                    <td style='min-width:150px;'><h4 style='font-size:16px;text-align: left;margin-left:5px;'>{$row['AREA']}</h4></td>
                    <td><h4 style='font-size:16px;text-align: center;'>{$row['ESTADO']}</h4></td>
                </tr>";
        }

        echo "</table></div>";
    }
?>
