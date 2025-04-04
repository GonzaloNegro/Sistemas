<?php 
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT CUIL, RESOLUTOR FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$pagina = 1;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Consulta de incidentes</title><meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<header class="header">
		<div class="container-fluid">
			<div class="btn-menu">
		<nav id="botonera" style="height: auto;">
			<ul class="nav">
				<li><label for="btn-menu" style="cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="60" fill="black" class="bi bi-list" viewBox="0 0 16 16">
				<path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
				</svg></label></li>
				</li>
				<li><a href="../carga/cargadeincidentes.php">CARGA</a>
                    <!--<ul id="sub">
                                        <li><a href="cargarapidaporusuario.php">-Carga rápida por usuario</a></li>
										<li><a href="#.php">-Carga rápida por tipificación</a></li>
                        </ul>-->
                 </li>
				<li><a href="consulta.php">CONSULTA </a></li>
				<li><a href="inventario.php">INVENTARIO </a>
					<ul id="sub">
									<li><a href="impresoras.php">-Impresoras</a></li>
									<li><a href="monitores.php">-Monitores</a></li>
						</ul>
				</li>
			</div>
			</div>
			</ul>
		</nav>
	</header>
	<input type="checkbox" id="btn-menu">
		<div class="container-menu" >
			<div class="cont-menu" style="padding: 10px">
			<nav >
					<div id="foto" style="margin-top: 21px; margin-bottom: 19px;"></div><br>			
					<h2 id="h2"><u>NOMBRE</u>: &nbsp<?php echo utf8_decode($row['RESOLUTOR']);?></h2>
					<h2 id="h2"><u>CUIL</u>: &nbsp &nbsp &nbsp &nbsp &nbsp<?php if ((isset($_SESSION['cuil'])) && ($_SESSION['cuil'] != "")){echo $_SESSION['cuil'];}?></h2><br>
					<h2 id="h2"><u>GESTIÓN: </u></h2>
					<a href="../abm/abm.php" class="color"><h2 id="h2">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp-ALTA/BAJA/MODIFICACIÓN</h2></a>
					<a href="../reportes/tiporeporte.php" class="color"><h2 id="h2">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp-REPORTES</h2></a>
					<a href="../particular/contraseña.php" class="color"><h2 id="h2">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp-CAMBIAR CONTRASEÑA</h2></a><br><br><br>
					<a href="../particular/salir.php"><h2 id="h2"><u>CERRAR SESIÓN</u></h2></a>
				</nav>
				<label for="btn-menu">✖️</label>
			</div>
		</div>
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
		<div id="titulo">
			<h1>CONSULTA DE INCIDENTES</h1>
		</div>
		
        <?php
		$cont = mysqli_query($datos_base, "SELECT count(*) as TOTAL FROM ticket t ");
		$conta = mysqli_fetch_array($cont);
		$total = $conta['TOTAL'];
		$incXPag = 30;
		$paginas =	ceil($total/$incXPag);
		$iniciar = ($_GET['pagina']-1)*$incXPag;
		if(!$_GET){
			header('Location:consulta.php?pagina=1');
			
		}
		if ($_GET['pagina']>$paginas || $_GET['pagina']<=0) {
			header('Location:consulta.php?pagina=1');
		}
		?>

		<!--Responsive pero cuando se achique puede salirse un boton hasta que llega al minimo y quedan todos en pila,
		se puede arreglar poniendo todos los botones sin espacio entremedio-->
		<div id="filtro" class="container-fluid" >
			<form method="POST" action="consulta.php">
				<div class="form-group row">
				<input type="text" style="margin-left: 10px; width: 30%; height: 50px; margin-top: 12px;" name="buscar"  placeholder="Buscar"  class="form-control largo col-xl-4 col-lg-4">
				<input type="submit" value="VER" name="btn2" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;">
				<input type="submit" value="LIMPIAR" name="btn1" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;">
				<label class="col-xl-1 col-lg-1" style="width: 13.7%;"></label>
				<input type="submit" value="VER PENDIENTES" id="pendientes" name="btn3" class="button1 col-xl-2 col-lg-2" style="margin-left: 10px; margin-right:10px; margin-top: 10px;" >
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
								<th width=350px><p>DESCRIPCIÓN</p></th>
								<th><p>PRIORIDAD</p></th>
								<th><p>ESTADO</p></th>
								<th><p>N° EQUIPO</p></th>
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
								$act = true;
								 $contador = 0;
							$consulta=mysqli_query($datos_base, "SELECT t.ID_TICKET, t.FECHA_INICIO, t.USUARIO, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, t.FECHA_SOLUCION, r.RESOLUTOR
							FROM ticket t 
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

									echo
									" 
										<tr>
										<td><h4 style='margin-top:12px;margin-bottom: 12px; font-size:16px;'>".$listar['ID_TICKET']."</h4 ></td>
										<td><h4 style='margin-top:12px;margin-bottom: 12px; font-size:16px;'>".$fecord."</h4 ></td>
										<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$listar['USUARIO']."</h4 ></td>
										<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$listar['DESCRIPCION']."</h4 ></td>
										<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$listar['PRIORIDAD']/*$res*/."</h4 ></td>
										<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$listar['ESTADO']/*$est*/."</h4 ></td>
										<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$listar['NRO_EQUIPO']."</h4 ></td>
										<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$fec."</h4 ></td>
										<td><h4 style='margin-top:12px; margin-bottom: 12px; font-size:16px;'>".$listar['RESOLUTOR']/*$nom*/."</h4 ></td>
										<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=modificacion.php?no=".$listar['ID_TICKET']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
											<path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
											<path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
										  </svg></a></td>
										</tr>
									";
									$contador = $contador + 1;
								}
							}
						/*ACA TERMINA EL BOTON DE PENDIENTES*/
		
							elseif(isset($_POST['btn2']))
							{
								$act=true;
								$doc = $_POST['buscar'];
								$contador = 0;
								$consulta=mysqli_query($datos_base, "SELECT t.ID_TICKET, t.FECHA_INICIO, t.USUARIO, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, t.FECHA_SOLUCION, r.RESOLUTOR
								FROM ticket t 
								LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
								LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
								LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR
								WHERE t.ID_TICKET LIKE '$doc' OR t.DESCRIPCION LIKE '%$doc%' OR t.USUARIO LIKE '%$doc%'
								OR t.FECHA_INICIO LIKE '%$doc%' OR p.PRIORIDAD LIKE '%$doc%'  OR e.ESTADO LIKE '%$doc%'
								OR t.NRO_EQUIPO LIKE '%$doc%'  OR t.FECHA_SOLUCION LIKE '%$doc%'  OR r.RESOLUTOR LIKE '%$doc%'
								ORDER BY t.FECHA_INICIO DESC, t.ID_TICKET DESC");
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

												echo
												"
													<tr>
													<td><h4 style='font-size:16px;'>".$listar['ID_TICKET']."</h4 ></td>
													<td><h4 style='font-size:16px;'>".$fecord."</h4 ></td>
													<td><h4 style='font-size:16px;'>".$listar['USUARIO']."</h4 ></td>
													<td><h4 style='font-size:16px;'>".$listar['DESCRIPCION']."</h4 ></td>
													<td><h4 style='font-size:16px;'>".$listar['PRIORIDAD']/*$res*/."</h4 ></td>
													<td><h4 style='font-size:16px;'>".$listar['ESTADO']/*$est*/."</h4 ></td>
													<td><h4 style='font-size:16px;'>".$listar['NRO_EQUIPO']."</h4 ></td>
													<td><h4 style='font-size:16px;'>".$fec."</h4 ></td>
													<td><h4 style='font-size:16px;'>".$listar['RESOLUTOR']/*$nom*/."</h4 ></td>
													<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalle.php?no=".$listar['ID_TICKET']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
													<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
													<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
												  </svg></a></td>
													</tr>
												"; 
												$contador = $contador + 1;
								} /*echo "</table>"*/;} 
							else 
							{

								
							$contador = 0;

							$ninci =strval($incXPag);
							$desde = strval($iniciar);
							$consulta=mysqli_query($datos_base, "SELECT t.ID_TICKET, t.FECHA_INICIO, t.USUARIO, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, t.FECHA_SOLUCION, r.RESOLUTOR
							FROM ticket t 
							LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
							LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
							LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR
							ORDER BY t.FECHA_INICIO DESC, t.ID_TICKET DESC limit $desde,$ninci");

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

									echo
									"
										<tr>
										<td><h4 style='font-size:16px;'>".$listar['ID_TICKET']."</h4></td>
										<td><h4 style='font-size:16px;'>".$fecord."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['USUARIO']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['DESCRIPCION']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['PRIORIDAD']/*$res*/."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['ESTADO']/*$est*/."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['NRO_EQUIPO']."</h4></td>
										<td><h4 style='font-size:16px;'>".$fec."</h4 ></td>
										<td><h4 style='font-size:16px;' >".$listar['RESOLUTOR']/*$nom*/."</h4></td>
										<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalle.php?no=".$listar['ID_TICKET']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
										<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
										<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
									  </svg></a></td>
										</tr>	
									"; 
									$contador = $contador + 1;
								}
							}
						echo "<div id=contador>
							<p>CANTIDAD DE TICKETS: $total </p> 
						</div>
				</table>";
			 ?> <!-- pongo variable total en vez de contador por que contador solo cuenta filas por pag-->
			
		</div>
		
	</section>
	<footer><div id="paginador" style="display: block;">
        <nav aria-label="Page navigation example" style="width: 200px;">
        <ul class="pagination">
        
        

        <li class='page-item <?php echo $_GET['pagina']<= 1 ? 'disabled' : '' ?>'><a class="page-link" href="<?php echo 'consulta.php?pagina='.$_GET['pagina']-1 ?>">Anterior</a></li>

        <?php for ($i=0; $i < $paginas; $i++) : ?>
			<li class="page-item <?php echo $_GET['pagina']==$i+1 ? 'active' : '' ?>">
                 <a class='page-link' href="consulta.php?pagina=<?php echo $i+1 ?>"><?php echo $i+1 ?></a>
                 
              </li>
		
		<?php endfor ?>
		<li class="page-item <?php echo $_GET['pagina']>=$paginas ? 'disabled' : '' ?>"><a class='page-link' href="<?php echo 'consulta.php?pagina='.$_GET['pagina']+1 ?>">Siguiente</a></li>
		
        </ul>
        </nav>
        </div></footer>
</body>
</html>