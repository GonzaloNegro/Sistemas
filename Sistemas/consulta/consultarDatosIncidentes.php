<?php
session_start();
include('../particular/conexion.php');

if(!isset($_SESSION['cuil'])) {       
    header('Location: ../index.php'); 
    exit();
}

function valorOporDefecto($valor) {
    return (isset($valor) && trim($valor) !== "") ? $valor : "-";
}

function generarBloqueHTML($label, $valor) {
    return '
    <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
        <label style="color:black;">' . $label . ':</label>
        <label style="color:black;">' . valorOporDefecto($valor) . '</label>
    </div>';
}

$idTicket = $_POST['idTicket'];
$resultados = mysqli_query($datos_base, "SELECT * FROM ticket WHERE ID_TICKET = '$idTicket'");
$num_rows = mysqli_num_rows($resultados);

if ($num_rows > 0) {
    while ($consulta = mysqli_fetch_array($resultados)) {
        $fechaInicio = date("d-m-Y", strtotime($consulta['FECHA_INICIO']));
        $hora = $consulta['HORA'];
        $desc = $consulta['DESCRIPCION'];
        $idEstado = $consulta['ID_ESTADO'];
        $idResolutor = $consulta['ID_RESOLUTOR'];
        $idUsuario = $consulta['ID_USUARIO'];
        $idWs = $consulta['ID_WS'];
        $fechaSolucion = date("d-m-Y", strtotime($consulta['FECHA_SOLUCION']));

        // Obtener estado
        $estado = "-";
        $sent = "SELECT ESTADO FROM estado WHERE ID_ESTADO = $idEstado";
        $resultado = $datos_base->query($sent);
        if ($row = $resultado->fetch_assoc()) {
            $estado = $row['ESTADO'];
        }

        // Obtener estado
        $ws = "-";
        $sent = "SELECT SERIEG FROM inventario WHERE ID_WS = $idWs";
        $resultado = $datos_base->query($sent);
        if ($row = $resultado->fetch_assoc()) {
            $ws = $row['SERIEG'];
        }

        // Obtener resolutor
        $resolutor = "-";
        $sent = "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = $idResolutor";
        $resultado = $datos_base->query($sent);
        if ($row = $resultado->fetch_assoc()) {
            $resolutor = $row['RESOLUTOR'];
        }

        // Obtener usuario
        $usuario = "-";
        $sent = "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = $idUsuario";
        $resultado = $datos_base->query($sent);
        if ($row = $resultado->fetch_assoc()) {
            $usuario = $row['NOMBRE'];
        }

        // Obtener área y repartición
        $area = "-";
        $reparticion = "-";
        $sent = "SELECT a.AREA, r.REPA FROM area a
            INNER JOIN usuarios u ON u.ID_AREA = a.ID_AREA
            INNER JOIN reparticion r ON r.ID_REPA = a.ID_REPA
            WHERE u.ID_USUARIO = $idUsuario";
        $resultado = $datos_base->query($sent);
        if ($row = $resultado->fetch_assoc()) {
            $area = $row['AREA'];
            $reparticion = $row['REPA'];
        }

        // Mostrar datos del ticket
        $camposTicket = [
            "N° Incidente" => '#'.$idTicket,
            "Fecha Inicio" => $fechaInicio,
            "Hora Creación" => $hora,
            "Usuario" => $usuario,
            "Área" => $area,
            "Repartición" => $reparticion,
            "Equipo" => $ws,
            "Descripción" => $desc,
            "Estado" => "<span style='color:green;'>$estado</span>",
            "Fecha Solución" => $fechaSolucion,
            "Resolutor" => $resolutor
        ];

        foreach ($camposTicket as $label => $valor) {
            echo generarBloqueHTML($label, $valor);
        }

        echo '<hr style="display: block; height: 3px;">';
    }
}
?>

<div id="grilla">
    <h2 style="color:#00519C;font-size: 20px;font-weight: bold;">MOVIMIENTOS</h2>
    <?php
    echo "<table width=auto>
        <thead>
            <tr>
                <th><p style='font-size:15px;'>FECHA</p></th>
                <th><p style='font-size:15px;'>HORA</p></th>
                <th><p style='font-size:15px;text-align:left;margin-left:3px;'>RESOLUTOR</p></th>
                <th><p style='font-size:15px;text-align:left;margin-left:3px;'>ESTADO</p></th>
                <th><p style='font-size:15px;text-align:left;margin-left:3px;'>MOTIVO</p></th>
            </tr>
        </thead>";

    $sql = mysqli_query($datos_base, "SELECT * from fecha_ticket WHERE ID_TICKET = '$idTicket'");
    while ($listar2 = mysqli_fetch_array($sql)) {
        $idFecha = $listar2['ID_FECHA'];
        $consulta = mysqli_query($datos_base, "SELECT * from fecha WHERE ID_FECHA = '$idFecha'");

        while ($listar = mysqli_fetch_array($consulta)) {
            $fecord = date("d-m-Y", strtotime($listar['FECHA_HORA']));
            $hora = $listar['HORA'];
            $motivo = strtoupper($listar['MOTIVO']);

            // Obtener estado
            $estado = "-";
            $idEstado = $listar['ID_ESTADO'];
            $sent = "SELECT ESTADO FROM estado WHERE ID_ESTADO = $idEstado";
            $resultado = $datos_base->query($sent);
            if ($row = $resultado->fetch_assoc()) {
                $estado = $row['ESTADO'];
            }

            // Obtener resolutor
            $resolutor = "-";
            $idResolutor = $listar['ID_RESOLUTOR'];
            $sent = "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = $idResolutor";
            $resultado = $datos_base->query($sent);
            if ($row = $resultado->fetch_assoc()) {
                $resolutor = $row['RESOLUTOR'];
            }

            echo "
                <tr>
                    <td><h4 style='font-size:15px;padding:3px;min-width:100px;'>$fecord</h4></td>
                    <td><h4 style='font-size:15px;padding:3px;'>$hora</h4></td>
                    <td><h4 style='font-size:15px;padding:3px;text-align:left;margin-left:3px;'>$resolutor</h4></td>
                    <td><h4 style='font-size:15px;padding:3px;text-align:left;margin-left:3px;'>$estado</h4></td>
                    <td><h4 style='font-size:15px;padding:3px;text-transform:uppercase;text-align:left;margin-left:3px;'>$motivo</h4></td>
                </tr>";
        }
    }

    echo "</table>";
    ?>
</div>
