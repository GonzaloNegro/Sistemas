<?php
	session_start();
    include('../particular/conexion.php');
    if(!isset($_SESSION['cuil'])) 
        {       
            header('Location: ../index.php'); 
            exit();
        };

    //SERVIDOR QUE MUESTRA UNA TABLA CON LAS NOVEDADES DE UN CASO DETERMINADO
    $id_celular = $_POST['idCelular'];
    $resultados=mysqli_query($datos_base, "SELECT lc.ID_LINEA, m.ID_MOVICEL, m.ID_CELULAR, c.IMEI, e.ESTADO, u.NOMBRE, pr.PROVEEDOR, mo.MODELO, p.PROCEDENCIA, ma.MARCA, l.NRO
    FROM lineacelular lc 
    LEFT JOIN celular c ON c.ID_CELULAR = lc.ID_CELULAR 
    LEFT JOIN linea l ON lc.ID_LINEA = l.ID_LINEA
    LEFT JOIN movicelular m ON m.ID_CELULAR=c.ID_CELULAR 
    LEFT JOIN modelo mo ON mo.ID_MODELO = c.ID_MODELO
    LEFT JOIN marcas ma ON ma.ID_MARCA = mo.ID_MARCA
    LEFT JOIN usuarios u ON lc.ID_USUARIO=u.ID_USUARIO
    LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR=c.ID_PROVEEDOR 
    LEFT JOIN procedencia p ON p.ID_PROCEDENCIA = c.ID_PROCEDENCIA
    LEFT JOIN estado_ws e ON e.ID_ESTADOWS=c.ID_ESTADOWS 
    WHERE c.ID_CELULAR = $id_celular
    ORDER BY m.ID_MOVICEL DESC
    LIMIT 1");
    $num_rows= mysqli_num_rows($resultados);
    // echo"<h1>".$celular."</h1>";
    if ($num_rows>0) {
        
        while($consulta = mysqli_fetch_array($resultados))
          {
            //CARGO EN  LISTA EL CONTENIDO DE LA LISTA DE DETALLES A PARTIR DEL RESULTADO DE LA BUSQUEDA
            //CALCULO DE INTERVALO ENTRE FECHAS DE INICIO Y DE SOLUCION, SI ALGUNA DE ESTAS ESTA EN NULL NO MUESTRA 
            //UTILIZA LA API CARBON
            $idLinea=$consulta['ID_LINEA'];
            $linea=$consulta['NRO'];
            $imei=$consulta['IMEI'];
            $usuario=$consulta['NOMBRE'];
            $procedencia=$consulta['PROCEDENCIA'];
            $proveedor=$consulta['PROVEEDOR'];
            $modelo=$consulta['MODELO'];
            $marca=$consulta['MARCA'];
            $estado=$consulta['ESTADO'];

            $color = 'blue';
            if ($estado === 'EN USO') {
                $color = 'green';
            } elseif ($estado === 'BAJA') {
                $color = 'red';
            }

            echo'
            
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label>IMEI:</label>
            <label>'.$imei.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label>Usuario:</label>
            <label>'.$usuario.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label>Roaming:</label>
            <label>'.$procedencia.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label>Proveedor:</label>
            <label>'.$proveedor.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label>Modelo:</label>
            <label>'.$marca.' - '.$modelo.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label>Estado:</label>
            <label style="color:'.$color.'">'.$estado.'</label>
        </div>
        ';
        if ($idLinea!=0 && $idLinea!=null) {
          echo'
          <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;font-weight:bold;">Asignado a linea:</label>
            <label style="color:black;font-weight:bold;">SI</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;font-weight:bold;">Linea Asignada:</label>
            <label style="color:black;font-weight:bold;">'.$linea.'</label>
        </div>
                              
          ';
        }
        else{
          echo'
            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label style="color:black;font-weight:bold;">Asignado a linea:</label>
                <label style="color:black;font-weight:bold;">NO</label>
            </div>                  
          ';}
          }	
        }
        else {
            echo "";
        }
?>

<hr style="display: block; height: 3px;">
<div id="grilla">
    <h2 style="color:#53AAE0;font-size: 20px;font-weight: bold;">MOVIMIENTOS</h2>
    <?php
    echo "<table width=auto>
        <thead>
            <tr>
                <th><p style='text-align:right;padding: 5px;'>FECHA</p></th>
                <th><p style='text-align:left;padding: 5px;'>USUARIO</p></th>
                <th><p style='text-align:left;padding: 5px;'>PROCEDENCIA</p></th>
                <th><p style='text-align:left;padding: 5px;'>PROVEEDOR</p></th>
                <th><p style='text-align:left;padding: 5px;'>ESTADO</p></th>
                <th><p style='text-align:right;padding: 5px;'>NÚMERO</p></th>
            </tr>
        </thead>";

            //SERVIDOR QUE MUESTRA UNA TABLA CON LAS NOVEDADES DE UN CASO DETERMINADO
        $id_celular = $_POST['idCelular'];
        $resultados=mysqli_query($datos_base, "SELECT lc.ID_LINEA, m.ID_MOVICEL, m.ID_CELULAR, e.ESTADO, u.NOMBRE, pr.PROVEEDOR, p.PROCEDENCIA, m.FECHA, l.NRO
        FROM lineacelular lc 
        LEFT JOIN celular c ON c.ID_CELULAR = lc.ID_CELULAR 
        LEFT JOIN linea l ON lc.ID_LINEA = l.ID_LINEA
        LEFT JOIN movicelular m ON m.ID_CELULAR=c.ID_CELULAR 
        LEFT JOIN usuarios u ON lc.ID_USUARIO=u.ID_USUARIO
        LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR=c.ID_PROVEEDOR 
        LEFT JOIN procedencia p ON p.ID_PROCEDENCIA = c.ID_PROCEDENCIA
        LEFT JOIN estado_ws e ON e.ID_ESTADOWS=c.ID_ESTADOWS 
        WHERE c.ID_CELULAR = $id_celular
        ORDER BY m.ID_MOVICEL DESC");
        $num_rows= mysqli_num_rows($resultados);
        // echo"<h1>".$celular."</h1>";
        if ($num_rows>0) {
        while($consulta = mysqli_fetch_array($resultados))
        {
        //CARGO EN  LISTA EL CONTENIDO DE LA LISTA DE DETALLES A PARTIR DEL RESULTADO DE LA BUSQUEDA
        //CALCULO DE INTERVALO ENTRE FECHAS DE INICIO Y DE SOLUCION, SI ALGUNA DE ESTAS ESTA EN NULL NO MUESTRA 
        //UTILIZA LA API CARBON
        $fec = date("d-m-Y", strtotime($consulta['FECHA']));
        $idLinea=$consulta['ID_LINEA'];
        $numero=$consulta['NRO'];
        $usuario=$consulta['NOMBRE'];
        $procedencia=$consulta['PROCEDENCIA'];
        $proveedor=$consulta['PROVEEDOR'];
        $estado=$consulta['ESTADO'];

        $color = 'blue';
        if ($estado === 'EN USO') {
            $color = 'green';
        } elseif ($estado === 'BAJA') {
            $color = 'red';
        }

        echo"
        <tr>
            <td><h4 style='text-align: right;padding: 5px;'>".$fec."</h4 ></td>
            <td><h4 style='text-align: left;padding: 5px;'>".$usuario."</h4 ></td>
            <td><h4 style='text-align: left;padding: 5px;'>".$procedencia."</h4 ></td>
            <td><h4 style='text-align: left;padding: 5px;'>".$proveedor."</h4></td>
            <td><h4 style='text-align: left;padding: 5px;color:".$color."'>".$estado."</h4 ></td>
            <td><h4 style='text-align: right;padding: 5px;'>".$numero."</h4 ></td>
        </tr>";
        }
    }
    echo "</table>";
    ?>
</div>