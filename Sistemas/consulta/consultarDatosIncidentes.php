<?php
	session_start();
    include('../particular/conexion.php');
    if(!isset($_SESSION['cuil'])) 
        {       
            header('Location: ../index.php'); 
            exit();
        };

        //SERVIDOR QUE MUESTRA UNA TABLA CON LAS NOVEDADES DE UN CASO DETERMINADO
    $idTicket = $_POST['idTicket'];
    $resultados=mysqli_query($datos_base, "SELECT * FROM ticket WHERE ID_TICKET = '$idTicket'");
    $num_rows= mysqli_num_rows($resultados);
    if ($num_rows>0) {
        while($consulta = mysqli_fetch_array($resultados))
          {
            $fechaInicio = date("d-m-Y", strtotime($consulta['FECHA_INICIO']));
            $usu = $consulta['USUARIO'];
            $desc = $consulta['DESCRIPCION'];
            $idEstado = $consulta['ID_ESTADO'];
            $idws = $consulta['ID_WS'];
            $fechaSolucion = date("d-m-Y", strtotime($consulta['FECHA_SOLUCION']));
            $idResolutor = $consulta['ID_RESOLUTOR'];
            $idTipificacion = $consulta['ID_TIPIFICACION'];
            $idUsuario = $consulta['ID_USUARIO'];
            $hora = $consulta['HORA'];


            $sent= "SELECT ESTADO FROM estado WHERE ID_ESTADO = $idEstado";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $estado = $row['ESTADO'];

            $sent= "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = $idResolutor";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $resolutor = $row['RESOLUTOR'];

            $sent= "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = $idUsuario";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $usuario = $row['NOMBRE'];

            $sent= "SELECT a.AREA, r.REPA FROM area a
            INNER JOIN usuarios u ON u.ID_AREA = a.ID_AREA
            INNER JOIN reparticion r ON r.ID_REPA = a.ID_REPA
            WHERE u.ID_USUARIO = $idUsuario";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $area = $row['AREA'];
            $reparticion = $row['REPA'];

        echo'
            
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label>N° Incidente:</label>
            <label>'.$idTicket.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label>Fecha Inicio:</label>
            <label>'.$fechaInicio.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label>Hora Creación:</label>
            <label>'.$hora.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label>Usuario:</label>
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
            <label>Descripción:</label>
            <label>'.$desc.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label>Estado:</label>
            <label style=color:green;>'.$estado.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label>Fecha Solución:</label>
            <label>'.$fechaSolucion.'</label>
        </div>
        <div style="width:100%;display:flex;justify-content:space-between;align-items: flex-start;">
            <label>Resolutor:</label>
            <label>'.$resolutor.'</label>
        </div>
        <hr style="display: block; height: 3px;">';
        }
          };?>

<div id="grilla">
			<h2 style="color:#53AAE0;font-size: 20px;font-weight: bold;">MOVIMIENTOS</h2>
		<?php
				echo "<table width=auto>
						<thead>
							<tr>
								<th><p style='font-size:15px;'>FECHA</p></th>
								<th><p style='font-size:15px;'>HORA</p></th>
								<th><p style='font-size:15px;text-align:left;margin-left:3px;'>RESOLUTOR</p></th>
								<th><p style='font-size:15px;text-align:left;margin-left:3px;'>ESTADO</p></th>
								<th><p style='font-size:15px;text-align:left;margin-left:3px;'>MOTIVO</p></th>
							</tr>
						</thead>";

						$sql = mysqli_query($datos_base, "SELECT * from fecha_ticket WHERE ID_TICKET = '$idTicket'");
						while($listar2 = mysqli_fetch_array($sql)){
							$resa = $listar2['ID_FECHA'];

						$consulta=mysqli_query($datos_base, "SELECT * from fecha WHERE ID_FECHA = '$resa'");
						while($listar = mysqli_fetch_array($consulta))
						{
							$opcion = $listar['ID_ESTADO'];
								include("../particular/conexion.php");
								$sent= "SELECT ESTADO FROM estado WHERE ID_ESTADO = $opcion";
								$resultado = $datos_base->query($sent);
								$row = $resultado->fetch_assoc();
								$est = $row['ESTADO'];
								?>
								<?php 
								$opcion = $listar['ID_RESOLUTOR'];
								include("../particular/conexion.php");
								$sent= "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = $opcion";
								$resultado = $datos_base->query($sent);
								$row = $resultado->fetch_assoc();
								$nom = $row['RESOLUTOR'];

								$fecord = date("d-m-Y", strtotime($listar['FECHA_HORA']));
							echo "
								<tr>
									<td><h4 style='font-size:15px;padding:3px;min-width:100px;'>".$fecord."</h4></td>
									<td><h4 style='font-size:15px;padding:3px;'>".$listar['HORA']."</h4></td>
									<td><h4 style='font-size:15px;padding:3px;text-align:left;margin-left:3px;'>".$nom."</h4></td>
									<td><h4 style='font-size:15px;padding:3px;text-align:left;margin-left:3px;'>".$est."</h4></td>
									<td><h4 style='font-size:15px;padding:3px;text-transform:uppercase;text-align:left;margin-left:3px;'>".$listar['MOTIVO']."</h4></td>
								</tr>";
						}}
					echo "</table>";
			?>
		</div>