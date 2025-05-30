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
        
        // Si hay equipo anterior, mostrarlo como opción seleccionada
        if ($equipoAnteriorID && $equipoAnteriorTexto) {
            $textoLimpio = htmlspecialchars($equipoAnteriorTexto);
            $idLimpio = htmlspecialchars($equipoAnteriorID);
            echo "<option selected value='$idLimpio'>$textoLimpio</option>";
        }
        
        // Consultar equipos disponibles
        $consulta = "
            SELECT u.NOMBRE, i.SERIEG, w.ID_WS
            FROM wsusuario w
            INNER JOIN usuarios u ON u.ID_USUARIO = w.ID_USUARIO
            INNER JOIN inventario i ON i.ID_WS = w.ID_WS
            WHERE u.ID_ESTADOUSUARIO = 1 
            AND w.ID_WS <> 0 
            AND w.ID_USUARIO <> 277
            AND i.ID_TIPOWS = 1
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
        
            // Evitar repetir el equipo anterior
            if ($id_ws == $equipoAnteriorID) continue;
        
            echo "<option value='$id_ws'>$nombre - $serieg</option>";
        }
        ?>