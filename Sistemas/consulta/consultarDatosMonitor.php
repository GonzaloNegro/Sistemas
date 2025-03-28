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
    $idPeri = $_POST['idPeri'];
    $tipoConsulta = $_POST['tipoConsulta'];

    if ($tipoConsulta == 'Info') {

        $resultados=mysqli_query($datos_base, "SELECT * FROM periferico WHERE ID_PERI = '$idPeri'");
        $num_rows= mysqli_num_rows($resultados);
        if ($num_rows>0) {
            while($consulta = mysqli_fetch_array($resultados))
            {
                //CARGO EN  LISTA EL CONTENIDO DE LA LISTA DE DETALLES A PARTIR DEL RESULTADO DE LA BUSQUEDA
                //CALCULO DE INTERVALO ENTRE FECHAS DE INICIO Y DE SOLUCION, SI ALGUNA DE ESTAS ESTA EN NULL NO MUESTRA 
                //UTILIZA LA API CARBON
                $idPeri=$consulta['ID_PERI'];
                $idTipop=$consulta['ID_TIPOP'];
                $serieG=$consulta['SERIEG'];
                $idMarca=$consulta['ID_MARCA'];
                $serie=$consulta['SERIE'];
                $idProcedencia=$consulta['ID_PROCEDENCIA'];
                $observacion=$consulta['OBSERVACION'];
                $tipop=$consulta['TIPOP'];
                $mac=$consulta['MAC'];
                $rip=$consulta['RIP'];
                $ip=$consulta['IP'];
                $idProveedor=$consulta['ID_PROVEEDOR'];
                $factura=$consulta['FACTURA'];
                $idArea=$consulta['ID_AREA'];
                $idUsuario=$consulta['ID_USUARIO'];
                $garantia=$consulta['GRANTIA'];
                $idEstadoWs=$consulta['ID_ESTADOWS'];
                $idModelo=$consulta['ID_MODELO'];

            /*/////////////////////NOMBRE//////////////////////*/
            $sql = "SELECT u.NOMBRE FROM periferico p LEFT JOIN usuarios u ON u.ID_USUARIO = p.ID_USUARIO WHERE p.ID_USUARIO='$idUsuario'";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $usuario = $row['NOMBRE'];
            /*/////////////////////AREA//////////////////////*/
            $sql = "SELECT a.AREA FROM periferico p LEFT JOIN area a ON a.ID_AREA = p.ID_AREA WHERE p.ID_AREA='$idArea'";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $area = $row['AREA'];
            /*/////////////////////REPARTICION//////////////////////*/
            $sql = "SELECT r.REPA FROM area a 
            LEFT JOIN reparticion r ON r.ID_REPA = a.ID_REPA 
            WHERE a.ID_AREA='$idArea'";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $reparticion = $row['REPA'];
            /*/////////////////////ESTADO//////////////////////*/
            $sql = "SELECT e.ESTADO FROM periferico p INNER JOIN estado_ws e ON e.ID_ESTADOWS = p.ID_ESTADOWS WHERE p.ID_ESTADOWS='$idEstadoWs'";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $estadoWs = $row['ESTADO'];
            /*/////////////////////TIPO//////////////////////*/
            $sql = "SELECT t.TIPO FROM periferico p INNER JOIN tipop t ON t.ID_TIPOP = p.ID_TIPOP WHERE p.ID_TIPOP='$idTipop'";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $tipoP = $row['TIPO'];
            /*/////////////////////MARCA//////////////////////*/
            $sql = "SELECT ma.MARCA, mo.MODELO FROM periferico p 
            INNER JOIN marcas ma ON ma.ID_MARCA=p.ID_MARCA 
            INNER JOIN modelo mo ON mo.ID_MODELO=p.ID_MODELO 
            WHERE ma.ID_MARCA ='$idMarca' AND mo.ID_MODELO = '$idModelo'";
            $resultado = $datos_base->query($sql); 
            $row = $resultado->fetch_assoc();
            $marca = $row['MARCA'];
            $modelo = $row['MODELO'];
            /*/////////////////////PROCEDENCIA//////////////////////*/
            $sql = "SELECT pr.PROCEDENCIA FROM periferico p LEFT JOIN procedencia pr ON pr.ID_PROCEDENCIA = p.ID_PROCEDENCIA WHERE p.ID_PROCEDENCIA='$idProcedencia'";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $procedencia = $row['PROCEDENCIA'];
            /*/////////////////////PROVEEDOR//////////////////////*/
            $sql = "SELECT pr.PROVEEDOR FROM periferico p LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = p.ID_PROVEEDOR WHERE p.ID_PROVEEDOR='$proveedor'";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $prove = $row['PROVEEDOR'];
                
        echo'
            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label>Monitor:</label>
                <label>'.$modelo.'</label>
            </div>
            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label>Marca:</label>
                <label>'.$marca.'</label>
            </div>
            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label>N° Serie Gob:</label>
                <label>'.$serieG.'</label>
            </div>
            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label>N° Serie:</label>
                <label>'.$serie.'</label>
            </div>
            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label>Procedencia:</label>
                <label>'.$procedencia.'</label>
            </div>
            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label>Tipo Monitor:</label>
                <label>'.$tipoP.'</label>
            </div>
            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label>Estado:</label>
                <label>'.$estadoWs.'</label>
            </div>
                
            <hr style="display: block; height: 3px;">

            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label>Usuario Responsable:</label>
                <label>'.$usuario.'</label>
            </div>
            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label>Área:</label>
                <label>'.$area.'</label>
            </div>
            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label>Repartición:</label>
                <label>'.$reparticion.'</label>
            </div>

            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label>Poveedor:</label>
                <label>'.$proveedor.'</label>
            </div>
            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label>N° Factura:</label>
                <label>'.$factura.'</label>
            </div>
            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label>Garantia:</label>
                <label>'.$garantia.'</label>
            </div>
            <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
                <label>Observación:</label>
                <label>'.$observacion.'</label>
            </div>';
            }	
        }
        else {
            echo "";
        }
    }


    elseif ($tipoConsulta == 'Movimientos') {
        $resultados=mysqli_query($datos_base, "SELECT * FROM movimientosperi WHERE ID_PERI = '$idPeri'");
        $num_rows= mysqli_num_rows($resultados);
        if ($num_rows>0) {
            while($consulta = mysqli_fetch_array($resultados))
            {
                //CARGO EN  LISTA EL CONTENIDO DE LA LISTA DE DETALLES A PARTIR DEL RESULTADO DE LA BUSQUEDA
                //CALCULO DE INTERVALO ENTRE FECHAS DE INICIO Y DE SOLUCION, SI ALGUNA DE ESTAS ESTA EN NULL NO MUESTRA 
                //UTILIZA LA API CARBON
                $idPeri=$consulta['ID_MOVIMIENTO'];
                $idTipop=$consulta['FECHA'];
                $serieG=$consulta['ID_PERI'];
                $idMarca=$consulta['ID_AREA'];
                $serie=$consulta['ID_USUARIO'];
                $idProcedencia=$consulta['ID_ESTADOWS'];

            /*/////////////////////NOMBRE//////////////////////*/
            $sql = "SELECT m.MODELO, p.ID_PERI
            FROM modelo m
            LEFT JOIN periferico p ON p.ID_MODELO = m.ID_MODELO
            WHERE p.ID_PERI='$consulta[2]'";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $modelo = $row['MODELO'];

        ?>
<div id="grilla">
		<?php
		    function colorear($v1, $v2, $v3){
                if($v1 != $v2){
                    $v3 = "#258900";
                }else{
                    $v3 = "#000000";
                }
                return $v3;
            }
				echo "<table width=100%>
						<thead>
							<tr>
                                <th><p class=g>FECHA</p></th>
								<th><p class=g style='text-align:left;margin-left:5px;'>USUARIO</p></th>
								<th><p class=g style='text-align:left;margin-left:5px;'>ÁREA</p></th>
								<th><p class=g>ESTADO</p></th>
							</tr>
						</thead>";
                        $equipo = $consulta[2];
                        $consultar=mysqli_query($datos_base, "SELECT m.ID_PERI, m.FECHA, u.NOMBRE, a.AREA, e.ESTADO
                        FROM movimientosperi m
                        LEFT JOIN usuarios AS u ON u.ID_USUARIO = m.ID_USUARIO
                        LEFT JOIN area AS a ON a.ID_AREA = m.ID_AREA
                        LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = m.ID_ESTADOWS
                        WHERE m.ID_PERI = $equipo
                        ORDER BY m.FECHA ASC");
						while($listar = mysqli_fetch_array($consultar))
						{
                            $fecord = date("d-m-Y", strtotime($listar['FECHA']));
							
							$colornom = "#000000";
                            $colorare = "#000000";
                            $colorest = "#000000";

						    echo" 
								<tr>
                                    <td style='min-width:100px;'><h4 style='font-size:16px;text-align: center;'>".$fecord."</h4></td>

									<td style='min-width:150px;'><h4 style='font-size:16px;text-align: left;margin-left:5px;'><font color=".colorear($nom, $listar['NOMBRE'], $colornom)."'>".$listar['NOMBRE']."</font></h4></td>

									<td style='min-width:150px;'><h4 style='font-size:16px;text-align: left;margin-left:5px;'><font color=".colorear($are, $listar['AREA'], $colorare)."'>".$listar['AREA']."</font></h4></td>

									<td><h4 style='font-size:16px;text-align: center;'><font color=".colorear($est, $listar['ESTADO'], $colorest)."'>".$listar['ESTADO']."</font></h4></td>

								</tr>";

							$nom = $listar['NOMBRE'];
							$are = $listar['AREA'];
							$est = $listar['ESTADO'];
						}
					echo "</table>";
			?>
		</div>
        <?php ;}	
        }
        else {
            echo "";
        }
    }
?>