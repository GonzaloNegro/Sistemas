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
    $resultados=mysqli_query($datos_base, "select lc.ID_CELULAR, l.NRO, u.NOMBRE, p.PLAN, pr.PROVEEDOR, r.ROAMING, l.DESCUENTO, n.NOMBREPLAN, l.FECHADESCUENTO, m.MONTO, m.EXTRAS, m.MONTOTOTAL, e.ESTADO
    from lineacelular lc 
    left join linea l on lc.ID_LINEA=l.ID_LINEA 
    left join movilinea m on m.ID_LINEA=l.ID_LINEA 
    left join usuarios u on lc.ID_USUARIO=u.ID_USUARIO 
    left join nombreplan n on n.ID_NOMBREPLAN=l.ID_NOMBREPLAN 
    left join plan p on p.ID_PLAN = n.ID_PLAN 
    left join proveedor pr on pr.ID_PROVEEDOR=n.ID_PROVEEDOR 
    left join roaming r on r.ID_ROAMING=l.ID_ROAMING 
    left join estado_ws e on e.ID_ESTADOWS=l.ID_ESTADOWS 
    where l.ID_LINEA=$id_linea
    ORDER BY m.ID_MOVILINEA DESC
    LIMIT 1");
    $num_rows= mysqli_num_rows($resultados);
    // echo"<h1>".$celular."</h1>";
    if ($num_rows>0) {
        
        while($consulta = mysqli_fetch_array($resultados))
          {
            $fecha = "0000-00-00";
            if($consulta['FECHADESCUENTO'] == $fecha)
            {
                $fec = date("d-m-Y", strtotime($consulta['FECHADESCUENTO']));
                $fec = "-";
                /*$fec = "-";*/
            }
            else{
                $fec = date("d-m-Y", strtotime($consulta['FECHADESCUENTO']));
            }
            //CARGO EN  LISTA EL CONTENIDO DE LA LISTA DE DETALLES A PARTIR DEL RESULTADO DE LA BUSQUEDA
            //CALCULO DE INTERVALO ENTRE FECHAS DE INICIO Y DE SOLUCION, SI ALGUNA DE ESTAS ESTA EN NULL NO MUESTRA 
            //UTILIZA LA API CARBON
            $numero=$consulta['NRO'];
            $idCelular=$consulta['ID_CELULAR'];
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
            
            echo'
            
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Número:</label>
            <label style="color:black;">'.$numero.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Usuario:</label>
            <label style="color:black;">'.$nombre.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Plan:</label>
            <label style="color:black;">'.$nombrePlan.' - '.$plan.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Proveedor:</label>
            <label style="color:black;">'.$proveedor.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Estado:</label>
            <label style="color:'.$color.';">'.$estado.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Roaming:</label>
            <label style="color:black;">'.$roaming.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Monto:</label>
            <label style="color:green;">$'.$monto.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Extras:</label>
            <label style="color:red;">$'.$extras.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Descuento:</label>
            <label style="color:black;">'.$descuento.'%</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;">Fecha Descuento:</label>
            <label style="color:black;">'.$fec.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;font-weight:bold;">Monto Total:</label>
            <label style="color:green;font-weight:bold;">$'.$montoTotal.'</label>
        </div>';
        if ($idCelular!=0 && $idCelular!=null) {
          echo'
          <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label style="color:black;font-weight:bold;">Asignado a celular:</label>
            <label style="color:black;font-weight:bold;">SI</label>
        </div>
                              
          ';
        }
        else{
          echo'
            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label style="color:black;font-weight:bold;">Asignado a celular:</label>
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
    <h2 style="color:#53AAE0;font-size: 20px;font-weight: bold;">MOVIMIENTOS LINEA</h2>
    <?php
        //SERVIDOR QUE MUESTRA UNA TABLA CON LAS NOVEDADES DE UN CASO DETERMINADO
        $id_linea = $_POST['idLinea'];
        $resultados=mysqli_query($datos_base, "SELECT lc.ID_LINEA, c.ID_CELULAR, c.IMEI, u.NOMBRE, mo.MODELO, ma.MARCA, lc.FECHA, l.NRO
        FROM lineacelular lc 
        LEFT JOIN linea l ON l.ID_LINEA = lc.ID_LINEA
        LEFT JOIN celular c ON c.ID_CELULAR = lc.ID_CELULAR 
        LEFT JOIN modelo mo ON mo.ID_MODELO = c.ID_MODELO
        LEFT JOIN marcas ma ON ma.ID_MARCA = mo.ID_MARCA
        LEFT JOIN usuarios u ON lc.ID_USUARIO=u.ID_USUARIO
        WHERE lc.ID_LINEA = $id_linea");
        $num_rows= mysqli_num_rows($resultados);
        // echo"<h1>".$celular."</h1>";
        if ($num_rows>0) {
            echo "
            <table width=auto>
            <thead>
                <tr>
                    <th><p style='text-align:center;'>FECHA</p></th>
                    <th><p style='text-align:right;margin-right:5px;'>NÚMERO</p></th>
                    <th><p style='text-align: left;min-width:180px;margin-left:5px;'>USUARIO</p></th>
                    <th><p style='text-align: left;min-width:180px;margin-left:5px;'>MODELO</p></th>
                    <th><p style='text-align:right;margin-right: 5px;'>IMEI</p></th>
                </tr>
            </thead>
            <tbody>";
            while($consulta = mysqli_fetch_array($resultados))
              {
                //CARGO EN  LISTA EL CONTENIDO DE LA LISTA DE DETALLES A PARTIR DEL RESULTADO DE LA BUSQUEDA
                //CALCULO DE INTERVALO ENTRE FECHAS DE INICIO Y DE SOLUCION, SI ALGUNA DE ESTAS ESTA EN NULL NO MUESTRA 
                //UTILIZA LA API CARBON
                $fec = date("d-m-Y", strtotime($consulta['FECHA']));
                $id_linea=$consulta['ID_LINEA'];
                $imei=$consulta['IMEI'];
                $usuario=$consulta['NOMBRE'];
                $modelo=$consulta['MODELO'];
                $marca=$consulta['MARCA'];
                $linea=$consulta['NRO'];
    
                if(isset($imei)){}else{
                    $imei = "SIN ASIGNAR";
                }
    
                if(isset($modelo)){}else{
                    $modelo = "SIN ASIGNAR";
                }
                
                echo"
                <tr>
                <td><h4 style='text-align: right;margin-right:5px;'>".$fec."</h4 ></td>
                <td><h4 style='text-align: right;margin-right:5px;'>".$linea."</h4 ></td>
                <td><h4 style='text-align: left;margin-left:5px;min-width:180px;'>".$usuario."</h4 ></td>
                <td><h4 style='text-align: left;margin-left:5px;min-width:180px;'>".$marca." ".$modelo."</h4 ></td>
                <td><h4 style='text-align: right;margin-right:5px;'>".$imei."</h4 ></td>
                </tr>";
            }
        }
    ?>
</div>