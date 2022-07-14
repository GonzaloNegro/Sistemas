<?php 
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();

$cu = $row['CUIL'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>CONSULTA</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoObrasPúblicas.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<header class="p-3 mb-3 border-bottom altura">
    <div class="container-fluid">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none"><div id="foto"></div>
          <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use> </svg>-->
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
		<li><a href="../carga/cargadeincidentes.php" class="nav-link px-2 link-secondary link destacado" 
			>NUEVO INCIDENTE</a>
 				<ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
					<li><a class="dropdown-item" href="../carga/cargarapidaporusuario.php">CARGA RÁPIDA POR USUARIO</a></li>
	 				<li><hr class="dropdown-divider"></li>
                	<li><a class="dropdown-item" href="../carga/cargarapidaportipificacion.php">CARGA RÁPIDA POR TIPIFICACIÓN</a></li>
                </ul>
			</li>
			<li><a href="consulta.php" class="nav-link px-2 link-dark link" style="border-left: 5px solid #53AAE0;">CONSULTA</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="consulta.php">CONSULTA DE INCIDENTES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="consultausuario.php">CONSULTA DE USUARIOS</a></li>
					<li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="consultaaltas.php">CONSULTA PARA ALTAS</a></li>
                </ul>
            </li>
            <li><a href="inventario.php" class="nav-link px-2 link-dark link">INVENTARIO</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="inventario.php">EQUIPOS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="impresoras.php">IMPRESORAS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="monitores.php">MONITORES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="otrosp.php">OTROS PERIFÉRICOS</a></li>
                </ul>
            </li>
            <li><a href="../abm/abm.php" class="nav-link px-2 link-dark link">ABM</a></li>
            <li><a href="../reportes/tiporeporte.php" class="nav-link px-2 link-dark link">REPORTES</a></li>
			<?php if($row['ID_RESOLUTOR'] == 6//GONZALO
					/*OR $row['ID_RESOLUTOR'] == 2 //CLAUDIA*/
					OR $row['ID_RESOLUTOR'] == 10 //EUGENIA
					OR $row['ID_RESOLUTOR'] == 15 //RODRIGO
					OR $row['ID_RESOLUTOR'] == 20 //GUSTAVO
					){
                        echo'
						<li><a href="../particular/estadisticas.php" class="nav-link px-2 link-dark link">ESTADISTICAS</a></li>
						<li><a href="../particular/stock.php" class="nav-link px-2 link-dark link">STOCK</a></li>
                    ';
					} ?>
			<li><a href="../calen/calen.php" class="nav-link px-2 link-dark link"><i class="bi bi-calendar3"></i></a>
			<li class="ubicacion link"><a href="../particular/bienvenida.php"><i class="bi bi-info-circle"></i></a></li>
        </ul>
		<div class="notif" id="notif">
			<i class="bi bi-bell" id="cant">
			<?php
			$cant="SELECT count(*) as cantidad FROM ticket WHERE ID_ESTADO = 4;";
			$result = $datos_base->query($cant);
			$rowa = $result->fetch_assoc();
			$cantidad = $rowa['cantidad'];

			/* $fechaActual = date('m'); */
			if($cantidad > 0){
				echo $cantidad;
			}
			?></i>
			<script type="text/javascript">
				var valor = "<?php echo $cantidad; ?>";
				console.log(valor);
			</script>
		</div>
        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false"><h5><i class="bi bi-person rounded-circle"></i><?php echo utf8_decode($row['RESOLUTOR']);?></h5></a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
		  <?php if($row['ID_RESOLUTOR'] == 6)
		  { echo '
		  	<li><a class="dropdown-item" href="../particular/agregados.php">CAMBIOS AGREGADOS</a></li>
            <li><hr class="dropdown-divider"></li>';}?>
            <li><a class="dropdown-item" href="../particular/contraseña.php">CAMBIAR CONTRASEÑA</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../particular/salir.php">CERRAR SESIÓN</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
		<style>
			#h2{
	              text-align: left;	
	              font-family: TrasandinaBook;
	              font-size: 16px;
	              color: #edf0f5;
	              margin-left: 10px;
	              margin-top: 5px;;
               
				}
        </style>
	<section id="consulta">
		<div id="titulo" data-aos="zoom-in">
			<h1>CONSULTA DE INCIDENTES</h1>
		</div>
		<!--Responsive pero cuando se achique puede salirse un boton hasta que llega al minimo y quedan todos en pila,
		se puede arreglar poniendo todos los botones sin espacio entremedio-->
		<div id="filtro" class="container-fluid">
			<form method="POST" action="consulta.php">
				<div class="form-group row">
					<input id="vlva1" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px; width: 48%;" type="submit" name="btn3" value="PENDIENTES"></input>

					<input id="vlva1" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px; width: 48%;" type="submit" name="pm" value="MIS PENDIENTES"></input>
				</div>
				<div>
					<?php
					/* if(isset($_POST['btn1']) OR isset($_POST['btn2'])) */
					if(empty($_POST['btn3']))
					{ if(empty($_POST['pm'])){?>
					<input type="text" style="margin-left: 10px; width: 30%; height: 40px; margin-top: 12px; 	box-sizing: border-box; box-sizing: border-box; border-radius: 10px; text-transform:uppercase;" name="buscar"  placeholder="Buscar" >
					<?php
					}}
					?>
					<label for="fecha1" style="color:#1c7cd5;"><u>DESDE:</u></label>
					<input type="date" name="fecha1" id="fecha1" style="margin-left: 10px; width: 12%; height: 40px; margin-top: 12px;box-sizing: border-box; border-radius: 10px;	display: inline-block;">
					<label for="fecha2" style="color:#1c7cd5;"><u>HASTA:</u></label>
					<input type="date" name="fecha2" id="fecha2" style="margin-left: 10px; width: 12%; height: 40px; margin-top: 12px;box-sizing: border-box; border-radius: 10px;	display: inline-block;">
					<?php
					if(empty($_POST['btn3']))
					{ if(empty($_POST['pm'])){?>
					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn2" value="BUSCAR"></input>
					<?php
					}}
					?>
					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn1" value="LIMPIAR"></input>
				</div>
			</form>
		</div>
		<div id="mostrar_incidentes">
			<?php
				echo "<table width=100%>
						<thead>
							<tr>
								<th><p>N° INCIDENTE</p></th>
								<th width=125px><p>FECHA INICIO</p></th>
								<th><p>USUARIO</p></th>
								<th width=450px><p>DESCRIPCIÓN</p></th>
								<th><p>ESTADO</p></th>
								<th><p>FECHA DE SOLUCIÓN</p></th>
								<th><p>RESOLUTOR</p></th>
								<th width=65px><p>ACCIÓN</p></th>
							</tr>
						</thead>
					";
							/*ACA EMPIEZA EL BOTON DE PENDIENTES*/

							if(isset($_POST['btn3']))
							{
								/*$doc = $_POST['buscar'];*/
							/* 	 $contador = 0; */
							$consulta=mysqli_query($datos_base, "SELECT t.ID_TICKET, t.FECHA_INICIO, u.NOMBRE, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, t.FECHA_SOLUCION, r.RESOLUTOR
							FROM ticket t 
							LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO
							LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
							LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
							LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR
							 WHERE t.ID_ESTADO IN (3, 4) ORDER BY t.FECHA_INICIO DESC, t.ID_TICKET DESC");
								while($listar = mysqli_fetch_array($consulta)) 
								{
									/*$originalDate = "2017-03-08";
									$newDate = date("d/m/Y", strtotime($originalDate));*/

									$fecord = date("d-m-Y", strtotime($listar['FECHA_INICIO']));

									$fecha = "0000-00-00";
									if($listar['FECHA_SOLUCION'] == $fecha)
									{
										$fec = date("d-m-Y", strtotime($listar['FECHA_SOLUCION']));
										$fec = "-";
										/*$fec = "-";*/
									}
									else{
										$fec = date("d-m-Y", strtotime($listar['FECHA_SOLUCION']));
									}

									/* if($listar['ESTADO'] == 'DERIVADO'){
										$estado = 'EN PROCESO';
									}else{
										$estado = $listar['ESTADO'];
									} */

									echo
									" 
										<tr>
										<td><h4 style='margin-top:12px;margin-bottom: 12px; font-size:16px;'>".$listar['ID_TICKET']."</h4 ></td>
										<td><h4 style='margin-top:12px;margin-bottom: 12px; font-size:16px;'>".$fecord."</h4 ></td>
										<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$listar['NOMBRE']."</h4 ></td>
										<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$listar['DESCRIPCION']."</h4 ></td>
										<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$listar['ESTADO']/*$est*/."</h4 ></td>
										<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$fec."</h4 ></td>
										<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$listar['RESOLUTOR']/*$nom*/."</h4 ></td>
										<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=modificacion.php?no=".$listar['ID_TICKET']." target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
											<path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
											<path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
										  </svg></a></td>
										</tr>
									";
								/* 	$contador = $contador + 1; */
								} 	
							}
						/*ACA TERMINA EL BOTON DE PENDIENTES*/
						/* COMIENZAN MIS PENDIENTES */
						elseif(isset($_POST['pm']))
						{
						/*$doc = $_POST['buscar'];*/
					/* 	$contador = 0; */
						$consulta=mysqli_query($datos_base, "SELECT t.ID_TICKET, t.FECHA_INICIO, u.NOMBRE, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, t.FECHA_SOLUCION, r.RESOLUTOR
						FROM ticket t 
						LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO
						LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
						LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
						LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR
							WHERE t.ID_ESTADO IN (3, 4) AND r.CUIL = $cu ORDER BY t.FECHA_INICIO DESC, t.ID_TICKET DESC");
							while($listar = mysqli_fetch_array($consulta)) 
							{
								/*$originalDate = "2017-03-08";
								$newDate = date("d/m/Y", strtotime($originalDate));*/

								$fecord = date("d-m-Y", strtotime($listar['FECHA_INICIO']));

								$fecha = "0000-00-00";
								if($listar['FECHA_SOLUCION'] == $fecha)
								{
									$fec = date("d-m-Y", strtotime($listar['FECHA_SOLUCION']));
									$fec = "-";
									/*$fec = "-";*/
								}
								else{
									$fec = date("d-m-Y", strtotime($listar['FECHA_SOLUCION']));
								}

								/* if($listar['ESTADO'] == 'DERIVADO'){
									$estado = 'EN PROCESO';
								}else{
									$estado = $listar['ESTADO'];
								} */

								echo
								" 
									<tr>
									<td><h4 style='margin-top:12px;margin-bottom: 12px; font-size:16px;'>".$listar['ID_TICKET']."</h4 ></td>
									<td><h4 style='margin-top:12px;margin-bottom: 12px; font-size:16px;'>".$fecord."</h4 ></td>
									<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$listar['NOMBRE']."</h4 ></td>
									<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$listar['DESCRIPCION']."</h4 ></td>
									<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$listar['ESTADO']/*$est*/."</h4 ></td>
									<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$fec."</h4 ></td>
									<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$listar['RESOLUTOR']/*$nom*/."</h4 ></td>
									<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=modificacion.php?no=".$listar['ID_TICKET']." target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
										<path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
										<path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
									  </svg></a></td>
									</tr>
								";
							/* 	$contador = $contador + 1; */
							} 	
						}
						

/* ----------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------- */

								/* ACA ARRANCAN LAS BUSQUEDAS DE NICO */
								elseif(isset($_POST['btn2']))
								{

                                    if(isset($_POST['buscar']) AND $_POST['fecha1']=="" AND $_POST['fecha2']==""){
	
										$doc = $_POST['buscar'];
															/* 	$contador = 0; */
																$consulta=mysqli_query($datos_base, "SELECT t.ID_TICKET, t.FECHA_INICIO, u.NOMBRE, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, t.FECHA_SOLUCION, r.RESOLUTOR
																FROM ticket t 
																LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO
																LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
																LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
																LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR
																WHERE (t.ID_TICKET LIKE '$doc' OR t.DESCRIPCION LIKE '%$doc%' OR u.NOMBRE LIKE '%$doc%'
																OR t.FECHA_INICIO LIKE '%$doc%' OR p.PRIORIDAD LIKE '%$doc%'  OR e.ESTADO LIKE '%$doc%'
																OR t.NRO_EQUIPO LIKE '%$doc%'  OR t.FECHA_SOLUCION LIKE '%$doc%'  OR r.RESOLUTOR LIKE '%$doc%')
																ORDER BY t.FECHA_INICIO DESC, t.ID_TICKET DESC");
																while($listar = mysqli_fetch_array($consulta))
																{
																	$fecord = date("d-m-Y", strtotime($listar['FECHA_INICIO']));
																				
																	$fecha = "0000-00-00";
																	if($listar['FECHA_SOLUCION'] == $fecha)		
																	{
																		$fec = date("d-m-Y", strtotime($listar['FECHA_SOLUCION']));
																		$fec = "-";
							
																			}
																				else{
																					$fec = date("d-m-Y", strtotime($listar['FECHA_SOLUCION']));
																				}
							
																				echo
																				"
																					<tr>
																					<td><h4 style='font-size:16px;'>".$listar['ID_TICKET']."</h4 ></td>
																					<td><h4 style='font-size:16px;'>".$fecord."</h4 ></td>
																					<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4 ></td>
																					<td><h4 style='font-size:16px;'>".$listar['DESCRIPCION']."</h4 ></td>
																					<td><h4 style='font-size:16px;'>".$listar['ESTADO']."</h4 ></td>
																					<td><h4 style='font-size:16px;'>".$fec."</h4 ></td>
																					<td><h4 style='font-size:16px;'>".$listar['RESOLUTOR']."</h4 ></td>
																					<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalle.php?no=".$listar['ID_TICKET']." target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
																					<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
																					<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
																				  </svg></a></td>
																				  </tr>
																				"; 
																			/* 	$contador = $contador + 1; */
																};
							
									}


									if($_POST['buscar']!="" AND isset($_POST['fecha1']) AND isset($_POST['fecha2'])){		
										$doc = $_POST['buscar'];
										$fecha1 = date("Y-m-d", strtotime($_POST['fecha1']));
										$fecha2 = date("Y-m-d", strtotime($_POST['fecha2']));
									/* 	$contador = 0; */
										$consulta=mysqli_query($datos_base, "SELECT t.ID_TICKET, t.FECHA_INICIO, u.NOMBRE, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, t.FECHA_SOLUCION, r.RESOLUTOR
										FROM ticket t 
										LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO
										LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
										LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
										LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR
										WHERE (t.ID_TICKET LIKE '$doc' OR t.DESCRIPCION LIKE '%$doc%' OR u.NOMBRE LIKE '%$doc%'
										OR t.FECHA_INICIO LIKE '%$doc%' OR p.PRIORIDAD LIKE '%$doc%'  OR e.ESTADO LIKE '%$doc%'
										OR t.NRO_EQUIPO LIKE '%$doc%'  OR t.FECHA_SOLUCION LIKE '%$doc%'  OR r.RESOLUTOR LIKE '%$doc%')
										and t.FECHA_INICIO BETWEEN '$fecha1' AND '$fecha2'
										ORDER BY t.FECHA_INICIO DESC, t.ID_TICKET DESC");
										while($listar = mysqli_fetch_array($consulta))
										{
											$fecord = date("d-m-Y", strtotime($listar['FECHA_INICIO']));
														
											$fecha = "0000-00-00";
											if($listar['FECHA_SOLUCION'] == $fecha)		
											{
												$fec = date("d-m-Y", strtotime($listar['FECHA_SOLUCION']));
												$fec = "-";
	
													}
														else{
															$fec = date("d-m-Y", strtotime($listar['FECHA_SOLUCION']));
														}
		
														echo
														"
															<tr>
															<td><h4 style='font-size:16px;'>".$listar['ID_TICKET']."</h4 ></td>
															<td><h4 style='font-size:16px;'>".$fecord."</h4 ></td>
															<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4 ></td>
															<td><h4 style='font-size:16px;'>".$listar['DESCRIPCION']."</h4 ></td>
															<td><h4 style='font-size:16px;'>".$listar['ESTADO']."</h4 ></td>
															<td><h4 style='font-size:16px;'>".$fec."</h4 ></td>
															<td><h4 style='font-size:16px;'>".$listar['RESOLUTOR']."</h4 ></td>
															<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalle.php?no=".$listar['ID_TICKET']." target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
															<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
															<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
														  </svg></a></td>
														  </tr>
														"; 
													/* 	$contador = $contador + 1; */
										} ;}  
			
			
			
	                                   if(empty($_POST['buscar']) AND $_POST['fecha1']!="" AND $_POST['fecha2']!=""){

										$fecha1 = date("Y-m-d", strtotime($_POST['fecha1']));
										$fecha2 = date("Y-m-d", strtotime($_POST['fecha2']));
									/* 	$contador = 0; */
										$consulta=mysqli_query($datos_base, "SELECT t.ID_TICKET, t.FECHA_INICIO, u.NOMBRE, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, t.FECHA_SOLUCION, r.RESOLUTOR
										FROM ticket t 
										LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO
										LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
										LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
										LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR
										WHERE t.FECHA_INICIO BETWEEN '$fecha1' AND '$fecha2'
										ORDER BY t.FECHA_INICIO DESC, t.ID_TICKET DESC");
										while($listar = mysqli_fetch_array($consulta))
										{
											$fecord = date("d-m-Y", strtotime($listar['FECHA_INICIO']));
														
											$fecha = "0000-00-00";
											if($listar['FECHA_SOLUCION'] == $fecha)		
											{
												$fec = date("d-m-Y", strtotime($listar['FECHA_SOLUCION']));
												$fec = "-";
	
													}
														else{
															$fec = date("d-m-Y", strtotime($listar['FECHA_SOLUCION']));
														}
	
														echo
														"
															<tr>
															<td><h4 style='font-size:16px;'>".$listar['ID_TICKET']."</h4 ></td>
															<td><h4 style='font-size:16px;'>".$fecord."</h4 ></td>
															<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4 ></td>
															<td><h4 style='font-size:16px;'>".$listar['DESCRIPCION']."</h4 ></td>
															<td><h4 style='font-size:16px;'>".$listar['ESTADO']."</h4 ></td>
															<td><h4 style='font-size:16px;'>".$fec."</h4 ></td>
															<td><h4 style='font-size:16px;'>".$listar['RESOLUTOR']."</h4 ></td>
															<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalle.php?no=".$listar['ID_TICKET']." target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
															<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
															<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
														  </svg></a></td>
														  </tr>
														"; 
													/* 	$contador = $contador + 1; */
										};
	
	
			}}


								else{
								/* 	$contador = 0; */
							$consulta=mysqli_query($datos_base, "SELECT t.ID_TICKET, t.FECHA_INICIO, u.NOMBRE, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, t.FECHA_SOLUCION, r.RESOLUTOR
							FROM ticket t
							LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO 
							LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
							LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
							LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR
							ORDER BY t.FECHA_INICIO DESC, t.ID_TICKET DESC
							LIMIT 320, 80");

								while($listar = mysqli_fetch_array($consulta)) 			
								{
									$fecord = date("d-m-Y", strtotime($listar['FECHA_INICIO']));

									$fecha = "0000-00-00";
									if($listar['FECHA_SOLUCION'] == $fecha)
									{
										$fec = date("d-m-Y", strtotime($listar['FECHA_SOLUCION']));
										$fec = "-";
										/*$fec = "-";*/
									}
									else{
										$fec = date("d-m-Y", strtotime($listar['FECHA_SOLUCION']));
									}

									/* if($listar['ESTADO'] == 'DERIVADO'){
										$estado = 'EN PROCESO';
									}else{
										$estado = $listar['ESTADO'];
									} */

									echo
									"										
										<tr>

										<td><h4 style='font-size:16px;'>".$listar['ID_TICKET']."</h4></td>
										<td><h4 style='font-size:16px;'>".$fecord."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['DESCRIPCION']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['ESTADO']/*$est*/."</h4></td>
										<td><h4 style='font-size:16px;'>".$fec."</h4 ></td>
										<td><h4 style='font-size:16px;' >".$listar['RESOLUTOR']/*$nom*/."</h4></td>
										<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalle.php?no=".$listar['ID_TICKET']." target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
										<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
										<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
									  </svg></a></td>
										</tr>	</a>
									"; 
									/* $contador = $contador + 1; */
								}
							}

							
						echo "<div id=contador>";
						if(isset($_POST['buscar'])){
								$filtro = $_POST['buscar'];
								if($filtro != ""){
									$filtro = strtoupper($filtro);
									echo "<p>FILTRADO POR: $filtro</p>";
								}
							}
						echo"
					
						</div>
				</table>";
			 ?>
			<div class="container">
			 	<div class="row">
					<nav aria-label="Page navigation example" class="pagination-lg">
						<ul class="pagination">
							<li class="page-item"><a class="page-link" href="consulta.php"><<</a></li>
							<li class="page-item"><a class="page-link" href="consulta.php">1</a></li>
							<li class="page-item"><a class="page-link" href="consulta2.php">2</a></li>
							<li class="page-item"><a class="page-link" href="consulta3.php">3</a></li>
							<li class="page-item"><a class="page-link" href="consulta4.php">4</a></li>
							<li class="page-item"><a class="page-link" href="consulta5.php">5</a></li>
							<li class="page-item"><a class="page-link" href="consulta5.php">>></a></li>
						</ul>
					</nav>
			 	</div>
			</div>
		</div>
		
	</section>
	<footer></footer>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
  		AOS.init();
	</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="../js/script.js"></script>
</body>
</html>