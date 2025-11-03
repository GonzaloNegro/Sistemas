<?php
	session_start();
    include('../particular/conexion.php');
    if(!isset($_SESSION['cuil'])) 
        {       
            header('Location: ../index.php'); 
            exit();
        };

        $equipoAnteriorID = $_GET['equipoAnteriorID'] ?? null;
        $equipoAnteriorTexto = $_GET['equipoAnteriorTexto'] ?? null;
        $tipoEquipoTexto = $_GET['tipoEquipoTexto'] ?? null;
        
        // Si hay equipo anterior, mostrarlo como opción seleccionada
        if ($equipoAnteriorID == 0) {
            echo "<option selected value='0'>SIN ASIGNAR</option>";
        }
        elseif ($equipoAnteriorID && $equipoAnteriorTexto) {
            $textoLimpio = htmlspecialchars($equipoAnteriorTexto);
            $idLimpio = htmlspecialchars($equipoAnteriorID);
            echo "<option selected value='$idLimpio'>$textoLimpio</option>";
        }

        
        // Consultar equipos disponibles
        $consulta = "
            SELECT u.NOMBRE, i.SERIEG, ws.ID_WS, i.ID_TIPOWS
                    FROM inventario i
                    LEFT JOIN wsusuario ws 
                        ON i.ID_WS = ws.ID_WS
                        AND ws.ID_WSUSU = (
                            SELECT MAX(wsu.ID_WSUSU)
                            FROM wsusuario wsu
                            WHERE wsu.ID_WS = i.ID_WS
                        )
                        INNER JOIN usuarios u ON u.ID_USUARIO = ws.ID_USUARIO
                        INNER JOIN area a ON u.ID_AREA=a.ID_AREA
                        INNER JOIN reparticion r ON r.ID_REPA=a.ID_REPA
                    WHERE u.ID_ESTADOUSUARIO = 1 
                    AND ws.ID_ESTADOWS = 1
                    AND ws.ID_WS <> 0 
            AND ws.ID_USUARIO <> 277
            AND ws.ID_USUARIO <> 310
            ORDER BY u.NOMBRE ASC
        ";
        
        $ejecutar = mysqli_query($datos_base, $consulta);
        
        if (!$ejecutar) {
            http_response_code(500);
            echo "<option value=''>Error al consultar</option>";
            exit;
        }
        
        foreach ($ejecutar as $opciones) {
            $id_ws = $opciones['ID_WS'];
            $nombre = htmlspecialchars($opciones['NOMBRE']);
            $serieg = htmlspecialchars($opciones['SERIEG']);
            $tipoEquipo = ($opciones['ID_TIPOWS'] == 1) ? "(PC)" : "(NOTEBOOK)";
        
            // Evitar duplicar la opción del equipo actual
            if ($equipoAnteriorID && $id_ws == $equipoAnteriorID) {
                continue;
            }
        
            echo "<option value='$id_ws'>$nombre - $tipoEquipo - $serieg</option>";
        }
?>