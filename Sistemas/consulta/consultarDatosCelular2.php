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
    $resultados=mysqli_query($datos_base, "SELECT lc.ID_LINEA, m.ID_MOVICEL, m.ID_CELULAR, c.IMEI, e.ESTADO, u.NOMBRE, pr.PROVEEDOR, mo.MODELO, p.PROCEDENCIA, ma.MARCA, m.FECHA
    FROM lineacelular lc 
    LEFT JOIN celular c ON c.ID_CELULAR = lc.ID_CELULAR 
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
        echo "
        <thead>
            <tr>
                <th><p style='text-align:right;margin-right: 5px;padding: 15px;'>FECHA</p></th>
                <th><p style='text-align:right;margin-right: 5px;padding: 15px;'>IMEI</p></th>
                <th><p style='text-align:right;margin-left: 5px;padding: 15px;'>USUARIO</p></th>
                <th><p style='text-align:left;margin-left: 5px;padding: 15px;'>PROCEDENCIA</p></th>
                <th><p style='text-align:left; margin-left: 5px;padding: 15px;'>PROVEEDOR</p></th>
                <th><p style='text-align:left; margin-left: 5px;padding: 15px;'>MODELO</p></th>
                <th><p style='text-align:left; margin-left: 5px;padding: 15px;'>ESTADO</p></th>
            </tr>
        </thead>
        <tbody>";
        while($consulta = mysqli_fetch_array($resultados))
          {
            //CARGO EN  LISTA EL CONTENIDO DE LA LISTA DE DETALLES A PARTIR DEL RESULTADO DE LA BUSQUEDA
            //CALCULO DE INTERVALO ENTRE FECHAS DE INICIO Y DE SOLUCION, SI ALGUNA DE ESTAS ESTA EN NULL NO MUESTRA 
            //UTILIZA LA API CARBON
            $fec = date("d-m-Y", strtotime($consulta['FECHA']));
            $idLinea=$consulta['ID_LINEA'];
            $imei=$consulta['IMEI'];
            $usuario=$consulta['NOMBRE'];
            $procedencia=$consulta['PROCEDENCIA'];
            $proveedor=$consulta['PROVEEDOR'];
            $modelo=$consulta['MODELO'];
            $marca=$consulta['MARCA'];
            $estado=$consulta['ESTADO'];

            echo"
            <tr>
            <td><h4 style='text-align: right;margin-right:5px;'>".$fec."</h4 ></td>
            <td><h4 style='text-align: right;margin-right:5px;'>".$imei."</h4 ></td>
            <td><h4 style='text-align: left;margin-left:5px;'>".$usuario."</h4 ></td>
            <td><h4 style='text-align: left;margin-left:5px;'>".$procedencia."</h4 ></td>
            <td><h4 style='text-align: left;margin-left:5px;'>".$proveedor."</h4></td>
            <td><h4 style='text-align: left;margin-left:5px;'>".$marca." ".$modelo."</h4 ></td>
            <td><h4 style='text-align: left;margin-left:5px;'>".$estado."</h4 ></td>
            </tr>
        </tbody>";
          }
        }
        else {
            echo "";
        }

?>