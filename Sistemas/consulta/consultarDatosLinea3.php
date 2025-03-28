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
        <thead>
            <tr>
                <th><p style='text-align:right;margin-right: 5px;padding: 15px;'>FECHA</p></th>
                <th><p style='text-align:right;margin-right: 5px;padding: 15px;'>NÚMERO</p></th>
                <th><p style='text-align: left;margin-left:5px;min-width:180px;padding: 15px;'>USUARIO</p></th>
                <th><p style='text-align: left;margin-left:5px;min-width:180px;padding: 15px;'>MODELO</p></th>
                <th><p style='text-align:right;margin-right: 5px;padding: 15px;'>IMEI</p></th>
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
            </tr>
        </tbody>";
          }
        }
        else {
            echo "";
        }

?>