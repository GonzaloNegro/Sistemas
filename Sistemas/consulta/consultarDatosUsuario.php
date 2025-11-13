<?php
	session_start();
    error_reporting(0);
    include('../particular/conexion.php');
    if(!isset($_SESSION['cuil'])) 
        {       
            header('Location: ../index.php'); 
            exit();
        };

        //SERVIDOR QUE MUESTRA UNA TABLA CON LAS NOVEDADES DE UN CASO DETERMINADO
    $id_usuario = $_POST['idUsuario'];
    $resultados=mysqli_query($datos_base, "SELECT u.ID_USUARIO, u.NOMBRE, u.CUIL, a.AREA, u.INTERNO, e.ESTADO, r.REPA, u.PISO, u.CORREO, u.CORREO_PERSONAL, u.TELEFONO_PERSONAL, u.OBSERVACION, t.TURNO
    FROM usuarios u
    LEFT JOIN area a ON  u.ID_AREA = a.ID_AREA
    LEFT JOIN reparticion r ON r.ID_REPA = a.ID_REPA
    LEFT JOIN turnos t ON t.ID_TURNO = u.ID_TURNO
    LEFT JOIN estado_usuario e ON e.ID_ESTADOUSUARIO = u.ID_ESTADOUSUARIO 
    WHERE u.ID_USUARIO = '$id_usuario'
    LIMIT 1");
    $num_rows= mysqli_num_rows($resultados);
    // echo"<h1>".$celular."</h1>";
    if ($num_rows>0) {
        
        while($consulta = mysqli_fetch_array($resultados))
          {

            //CARGO EN  LISTA EL CONTENIDO DE LA LISTA DE DETALLES A PARTIR DEL RESULTADO DE LA BUSQUEDA
            //CALCULO DE INTERVALO ENTRE FECHAS DE INICIO Y DE SOLUCION, SI ALGUNA DE ESTAS ESTA EN NULL NO MUESTRA 
            //UTILIZA LA API CARBON
            $idUsuario=$consulta['ID_USUARIO'];
            $nombre=$consulta['NOMBRE'];
            $cuil=$consulta['CUIL'];
            $area=$consulta['AREA'];
            $reparticion=$consulta['REPA'];
            $piso=$consulta['PISO'];
            $interno = !empty($consulta['INTERNO']) ? $consulta['INTERNO'] : "-";
            $correo = !empty($consulta['CORREO']) ? $consulta['CORREO'] : "-";
            $correoPersonal = !empty($consulta['CORREO_PERSONAL']) ? $consulta['CORREO_PERSONAL'] : "-";
            $telefonoPersonal = !empty($consulta['TELEFONO_PERSONAL']) ? $consulta['TELEFONO_PERSONAL'] : "-";
            $turno=$consulta['TURNO'];
            $activo=$consulta['ESTADO'];
            $observacion = !empty($consulta['OBSERVACION']) ? $consulta['OBSERVACION'] : "-";
            
            if($activo == 'ACTIVO'){
                $color = 'green';
            }else{
                $color = 'red';
            }

            $sql = "SELECT i.SERIEG
            FROM inventario i
            INNER JOIN (
                SELECT w1.ID_WS, w1.ID_USUARIO
                FROM wsusuario w1
                INNER JOIN (
                    SELECT ID_WS, MAX(ID_WSUSU) AS UltimoMov
                    FROM wsusuario
                    GROUP BY ID_WS
                ) w2 ON w1.ID_WS = w2.ID_WS AND w1.ID_WSUSU = w2.UltimoMov
            ) ult
                ON i.ID_WS = ult.ID_WS
            WHERE ult.ID_USUARIO = '$id_usuario'
            AND i.ID_ESTADOWS = 1
            AND i.ID_WS NOT IN (522, 523);
            ";


            $resultado = $datos_base->query($sql);

            $equipos = '';

            if ($resultado && $resultado->num_rows > 0) {
                $contador = 1;
                while ($row = $resultado->fetch_assoc()) {
                    // SERIEG en verde
                    $equipos .= "<div>{$contador}°: <span style='color:green;'>{$row['SERIEG']}</span></div>";
                    $contador++;
                }
            } else {
                // Mensaje en rojo si no hay equipos
                $equipos = "<div><span style='color:red;'>SIN EQUIPO ASIGNADO</span></div>";
            }


            echo'
        <div style="width:100%;display:flex;justify-content:space-between;align-items:flex-start;">
            <label style="color:black;">Equipo/s asignado/s:</label>
            <label style="color:black;">'.$equipos.'</label>
        </div>
            <hr style="display: block; height: 1px;">
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Usuario:</label>
            <label style="color:black;">'.$nombre.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Cuil:</label>
            <label style="color:black;">'.$cuil.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Área:</label>
            <label style="color:black;">'.$area.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Repartición:</label>
            <label style="color:black;">'.$reparticion.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Piso:</label>
            <label style="color:black;">'.$piso.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Interno:</label>
            <label style="color:black;">'.$interno.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Correo:</label>
            <label style="color:black;">'.$correo.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Correo Personal:</label>
            <label style="color:black;">'.$correoPersonal.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Teléfono Personal:</label>
            <label style="color:black;">'.$telefonoPersonal.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Turno:</label>
            <label style="color:black;">'.$turno.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Activo:</label>
            <label style="color:'.$color.';">'.$activo.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Observación:</label>
            <label style="color:black;">'.$observacion.'</label>
        </div>
          ';
        }
        }
        else {
            echo "";
        }
?>