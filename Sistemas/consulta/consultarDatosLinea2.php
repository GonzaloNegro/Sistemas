<?php
	session_start();
    include('../particular/conexion.php');
    if(!isset($_SESSION['cuil'])) 
        {       
            header('Location: ../index.php'); 
            exit();
        };


        //SERVIDOR QUE MUESTRA UNA TABLA CON LAS NOVEDADES DE UN CASO DETERMINADO
    $id_linea = $_POST['idLinea'];
    $resultados=mysqli_query($datos_base, "SELECT l.NRO, u.NOMBRE, p.PLAN, pr.PROVEEDOR, r.ROAMING, l.DESCUENTO, n.NOMBREPLAN, l.FECHADESCUENTO, m.MONTO, m.EXTRAS, m.MONTOTOTAL, e.ESTADO, m.FECHA, m.OBSERVACION
    from movilinea m 
    left join linea l on l.ID_LINEA=m.ID_LINEA 
    left join usuarios u on u.ID_USUARIO=m.ID_USUARIO 
    left join nombreplan n on n.ID_NOMBREPLAN=l.ID_NOMBREPLAN 
    left join plan p on p.ID_PLAN = n.ID_PLAN 
    left join proveedor pr on pr.ID_PROVEEDOR=n.ID_PROVEEDOR 
    left join roaming r on r.ID_ROAMING=l.ID_ROAMING 
    left join estado_ws e on e.ID_ESTADOWS=l.ID_ESTADOWS 
    where l.ID_LINEA = $id_linea
    ORDER BY m.FECHA DESC");
    $num_rows= mysqli_num_rows($resultados);
    // echo"<h1>".$celular."</h1>";
    if ($num_rows>0) {
        echo "
        <thead>
            <tr>
                <th><p style='text-align:center; padding: 15px;'>FECHA</p></th>
                <th><p style='text-align:left;padding: 15px;'>USUARIO</p></th>
                <th><p style='text-align:left;margin-left: 5px;padding: 15px;'>PLAN</p></th>
                <th><p style='text-align:left; margin-left: 5px;padding: 15px;'>ROAMING</p></th>
                <th><p style='text-align:left; margin-left: 5px;padding: 15px;'>ESTADO</p></th>
                <th><p style='text-align:right;margin-right: 5px;padding: 15px;'>MONTO</p></th>
                <th><p style='text-align:right;margin-right: 5px;padding: 15px;'>DESCUENTO</p></th>
                <th><p style='text-align:center;padding: 15px;'>FECHA DESCUENTO</p></th>
                <th><p style='text-align:right;margin-right: 5px;padding: 15px;'>EXTRAS</p></th>
                <th><p style='text-align:right; margin-right: 5px;padding: 15px;'>MONTO TOTAL</p></th>
                <th><p style='text-align:right; margin-right: 5px;padding: 15px;'>OBSERVACIÓN</p></th>
            </tr>
        </thead>
        <tbody>";
        while($consulta = mysqli_fetch_array($resultados))
          {
            $fecha = "0000-00-00";
            if($consulta['FECHADESCUENTO'] == $fecha)
            {
                $fecdes = date("d-m-Y", strtotime($consulta['FECHADESCUENTO']));
                $fecdes = "-";
                /*$fec = "-";*/
            }
            else{
                $fecdes = date("d-m-Y", strtotime($consulta['FECHADESCUENTO']));
            }

            if($consulta['FECHA'] == $fecha)
            {
                $fec = date("d-m-Y", strtotime($consulta['FECHA']));
                $fec = "-";
                /*$fec = "-";*/
            }
            else{
                $fec = date("d-m-Y", strtotime($consulta['FECHA']));
            }
            //CARGO EN  LISTA EL CONTENIDO DE LA LISTA DE DETALLES A PARTIR DEL RESULTADO DE LA BUSQUEDA
            //CALCULO DE INTERVALO ENTRE FECHAS DE INICIO Y DE SOLUCION, SI ALGUNA DE ESTAS ESTA EN NULL NO MUESTRA 
            //UTILIZA LA API CARBON
            $numero=$consulta['NRO'];
            $nombre=$consulta['NOMBRE'];
            $plan=$consulta['PLAN'];
            $nombrePlan=$consulta['NOMBREPLAN'];
            $proveedor=$consulta['PROVEEDOR'];
            $roaming=$consulta['ROAMING'];
            $monto=$consulta['MONTO'];
            $extras=$consulta['EXTRAS'];
            $montoTotal=$consulta['MONTOTOTAL'];
            $descuento=$consulta['DESCUENTO'];
            $estado=$consulta['ESTADO'];
            $observacion=$consulta['OBSERVACION'];
            // $nombreplan=$consulta['NOMBREPLAN'];
            // $modelo=$consulta['MODELO'];
            // $marca=$consulta['MARCA'];
            // $estado=$consulta['ESTADO'];

            $color = 'blue';
            if ($estado === 'EN USO') {
                $color = 'green';
            } elseif ($estado === 'BAJA') {
                $color = 'red';
            }
            
            echo"
            <tr>
            <td><h4 style='text-align: center;width:85px;'>".$fec."</h4 ></td>
            <td><h4 style='text-align: left;padding: 5px;'>".$nombre."</h4 ></td>
            <td><h4 style='text-align: left;padding: 5px;'>".$nombrePlan." ".$plan."</h4 ></td>
            <td><h4 style='text-align: left;margin-left:5px;'>".$roaming."</h4 ></td>
            <td><h4 style='text-align: left;margin-left:5px;color:".$color."'>".$estado."</h4 ></td>
            <td><h4 style='text-align: right;margin-right:5px;'>$".$monto."</h4 ></td>
            <td><h4 style='text-align: right;margin-right:5px;'>".$descuento."%</h4 ></td>
            <td><h4 style='text-align: center;'>".$fecdes."</h4 ></td>
            <td><h4 style='text-align: right;margin-right:5px;'>$".$extras."</h4 ></td>
            <td><h4 style='text-align: right;margin-right:5px;color:green;font-weight:bold;font-size:16px;'>$".$montoTotal."</h4 ></td>
            <td><h4 style='text-align: right;margin-right:5px;'>".$observacion."</h4 ></td>
            </tr>
        </tbody>";
          }	
        }
        else {
            echo "";
        }

?>