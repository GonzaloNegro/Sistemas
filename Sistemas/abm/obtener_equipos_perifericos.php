<?php
// Desactivar errores visibles (para no romper JSON)
ini_set('display_errors', 0);
error_reporting(0);

header('Content-Type: application/json; charset=utf-8');

include('../particular/conexion.php'); // Define $datos_base

if (!isset($datos_base) || !$datos_base) {
    echo json_encode(['error' => 'No se pudo conectar a la base de datos.', 'datos' => []]);
    exit;
}

$id_usuario = $_GET['id_usuario'] ?? null;

if (!$id_usuario || !is_numeric($id_usuario)) {
    echo json_encode(['error' => 'ID de usuario no válido.', 'datos' => []]);
    exit;
}

// 🔴 CORREGIDO: Ahora incluimos SERIEG con alias 'serie_equipo'
$sql = "
    SELECT 
        inv.ID_WS AS id_equipo,
        inv.SERIEG AS serie_equipo,     -- ← AQUÍ está el cambio clave
        ep.ID_PERI AS id_periferico
    FROM wsusuario wu
    INNER JOIN inventario inv ON wu.ID_WS = inv.ID_WS
    LEFT JOIN equipo_periferico ep ON inv.ID_WS = ep.ID_WS
    LEFT JOIN periferico p ON ep.ID_PERI = p.ID_PERI
    WHERE wu.ID_USUARIO = ? 
      AND inv.ID_ESTADOWS = 1
      AND (p.ID_ESTADOWS = 1 OR p.ID_ESTADOWS IS NULL)
    ORDER BY inv.ID_WS, ep.ID_PERI
";

if ($stmt = mysqli_prepare($datos_base, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $id_usuario);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        
        $resultados = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $resultados[] = $row;
        }
        mysqli_stmt_close($stmt);

        // Agrupar por ID_WS, pero usar SERIEG como nombre
        $datos = [];
        foreach ($resultados as $fila) {
            $id_equipo = $fila['id_equipo'];
            $serie_equipo = trim($fila['serie_equipo']) ?: "Equipo $id_equipo"; // Por si está vacío
            $id_periferico = $fila['id_periferico'];

            if (!isset($datos[$id_equipo])) {
                $datos[$id_equipo] = [
                    'serie_equipo' => $serie_equipo,
                    'perifericos' => []
                ];
            }

            if ($id_periferico !== null && $id_periferico !== '') {
                $datos[$id_equipo]['perifericos'][] = (int)$id_periferico;
            }
        }

        $datos = array_values($datos);

        echo json_encode(['datos' => $datos]);

    } else {
        echo json_encode(['error' => 'Error al ejecutar la consulta.', 'datos' => []]);
    }
} else {
    echo json_encode(['error' => 'Error en la preparación de la consulta.', 'datos' => []]);
}
?>