<?php 
session_start();
include('conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT CUIL, RESOLUTOR FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Inventario</title><meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloreporte.css">
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
        <section id="reporte">
        <?php
        $seleccion=$_POST['tiporeporteinvent'];
		$tipodisp = $_POST['radioinv'];
        ?>
        <div id="mostrar_reporte" style="width: 97%; margin-left: 20px; display: block;">
			
		            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
	                    <a id="vlv"  href="reporteperifericos.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
                        <button id="pr" class="btn btn-success" style="width: 50px; border-radius: 10px;" onClick="imprimir()"><i class='bi bi-printer'></i></button>
		            </div>
		            <style type="text/css" media="print">
                              @media print {
                                             #vlv {display:none;}
                                             #pr {display:none;}
		                                     #pr2 {display:none;}
											 #titulo{ margin-top: 50px;}
											 #ind{ margin-top: 20px;}
											 #tablareporte{ margin-top: 20px;}
                                            }
                    </style>
		            <script>
                           function imprimir() {
            	             window.print();
                                      }
                    </script>

			        <?php
					if($seleccion=='AREA' && $tipodisp == 'impresora'){
                        $conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p
			            where p.TIPOP='IMPRESORA'");
			            $total = mysqli_fetch_array($conttotal);
						$fecha = date("d-m-y");
						echo "
						<h1 id='titulo'>REPORTE DE IMPRESORAS POR AREA</h1>
                        <hr style='display: block;'>
				        <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL EQUIPOS: ".$total['TOTAL']."</h4>
						<h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
						<table id='tablareporte' class='table table-striped table-hover' width=97%>
						<thead>
						<tr style='background-color: #00519C'>
						<th class='cabecera'><p>AREA</p></th>
						<th class='cabecera'><p>TOTAL</p></th>
						</tr>
						</thead>";
						$consultar=mysqli_query($datos_base, "SELECT a.AREA, count(*) as TOTAL from periferico p left join area a on p.ID_AREA=a.ID_AREA
						where p.TIPOP='IMPRESORA' group by a.AREA");
									while($listar = mysqli_fetch_array($consultar))
									{
										if ($listar['AREA']== 0) {
											$nombre = 'SIN AREA';
										}
										else {
											$nombre = $listar['AREA'];
										}
				
													echo
													"
														<tr>
														<td><h4 style='text-align: left;	'>".$nombre."</h4></td>
														<td><h4 style='text-align: center;	'>".$listar['TOTAL']."</h4></td>
														</tr>	
													"; 
												
									}
					}
                    if ($seleccion=='ESTADO' && $tipodisp == 'impresora') {
                        $conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p
			            where p.TIPOP='IMPRESORA'");
			            $total = mysqli_fetch_array($conttotal);
						$fecha = date("d-m-y");
						echo "
						<h1 id='titulo'>REPORTE DE IMPRESORAS POR ESTADO</h1>
                        <hr style='display: block;'>
				        <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL EQUIPOS: ".$total['TOTAL']."</h4>
						<h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
						<table id='tablareporte' class='table table-striped table-hover' width=97%>
						<thead>
						<tr style='background-color: #00519C'>
						<th class='cabecera'><p>ESTADO</p></th>
						<th class='cabecera'><p>TOTAL</p></th>
						</tr>
						</thead>";
						$consultar=mysqli_query($datos_base, "SELECT e.ESTADO, count(*) as TOTAL from periferico p left join estado_ws e on p.ID_ESTADOWS=e.ID_ESTADOWS
						where p.TIPOP='IMPRESORA' group by e.ESTADO");
									while($listar = mysqli_fetch_array($consultar))
									{
										if ($listar['ESTADO']== 0) {
											$nombre = 'SIN ESTADO';
										}
										else {
											$nombre = $listar['ESTADO'];
										}
				
													echo
													"
														<tr>
														<td><h4 style='text-align: left;	'>".$nombre."</h4></td>
														<td><h4 style='text-align: center;	'>".$listar['TOTAL']."</h4></td>
														</tr>	
													"; 
												
									}
                    }
					if ($seleccion=='PROVEEDOR' && $tipodisp == 'impresora')
					{
						$conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p
			            where p.TIPOP='IMPRESORA'");
			            $total = mysqli_fetch_array($conttotal);
						$fecha = date("d-m-y");
						echo "
						<h1 id='titulo'>REPORTE DE IMPRESORAS POR PROVEEDOR</h1>
                        <hr style='display: block;'>
				        <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL EQUIPOS: ".$total['TOTAL']."</h4>
						<h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
						<table id='tablareporte' class='table table-striped table-hover' width=97%>
						<thead>
						<tr style='background-color: #00519C'>
						<th class='cabecera'><p>PROVEEDOR</p></th>
						<th class='cabecera'><p>TOTAL</p></th>
						</tr>
						</thead>";
						$consultar=mysqli_query($datos_base, "SELECT e.PROVEEDOR, count(*) as TOTAL from periferico p left join proveedor e on p.ID_PROVEEDOR=e.ID_PROVEEDOR
						where p.TIPOP='IMPRESORA' group by e.proveedor");
									while($listar = mysqli_fetch_array($consultar))
									{
										if ($listar['PROVEEDOR']== 0) {
											$nombre = 'SIN PROVEEDOR';
										}
										else {
											$nombre = $listar['PROVEEDOR'];
										}
				
													echo
													"
														<tr>
														<td><h4 style='text-align: left;	'>".$nombre."</h4></td>
														<td><h4 style='text-align: center;	'>".$listar['TOTAL']."</h4></td>
														</tr>	
													"; 
												
									}
								}


				    if($seleccion=='AREA' && $tipodisp == 'monitor'){
						$conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p
		     			where p.TIPOP='MONITOR'");
						$total = mysqli_fetch_array($conttotal);
						$fecha = date("d-m-y");
						echo "
						<h1 id='titulo'>REPORTE DE MONITORES POR AREA</h1>
						<hr style='display: block;'>
						<h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL EQUIPOS: ".$total['TOTAL']."</h4>
						<h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
						<table id='tablareporte' class='table table-striped table-hover' width=97%>
						    <thead>
								<tr style='background-color: #00519C'>
								<th class='cabecera'><p>AREA</p></th>
								<th class='cabecera'><p>TOTAL</p></th>
								</tr>
							</thead>";
									$consultar=mysqli_query($datos_base, "SELECT a.AREA, count(*) as TOTAL from periferico p left join area a on p.ID_AREA=a.ID_AREA
									where p.TIPOP='MONITOR' group by a.AREA");
												while($listar = mysqli_fetch_array($consultar))
												{
													if ($listar['AREA']== 0) {
														$nombre = 'SIN AREA';
													}
													else {
														$nombre = $listar['AREA'];
													}
							
																echo
																"
																	<tr>
																	<td><h4 style='text-align: left;	'>".$nombre."</h4></td>
																	<td><h4 style='text-align: center;	'>".$listar['TOTAL']."</h4></td>
																	</tr>	
																"; 
															
												}
								}
								if ($seleccion=='ESTADO' && $tipodisp == 'monitor')
								{
									$conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p
									where p.TIPOP='MONITOR'");
									$total = mysqli_fetch_array($conttotal);
									$fecha = date("d-m-y");
										echo "
											<h1 id='titulo'>REPORTE DE MONITORES POR ESTADO</h1>
											<hr style='display: block;'>
											<h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL EQUIPOS: ".$total['TOTAL']."</h4>
											<h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
											<table id='tablareporte' class='table table-striped table-hover' width=97%>
											<thead>
											<tr style='background-color: #00519C'>
											<th class='cabecera'><p>ESTADO</p></th>
											<th class='cabecera'><p>TOTAL</p></th>
											</tr>
											</thead>";
											$consultar=mysqli_query($datos_base, "SELECT e.ESTADO, count(*) as TOTAL from periferico p left join estado_ws e on p.ID_ESTADOWS=e.ID_ESTADOWS
											where p.TIPOP='MONITOR' group by e.ESTADO");
														while($listar = mysqli_fetch_array($consultar))
														{
															if ($listar['ESTADO']== 0) {
																$nombre = 'SIN ESTADO';
															}
															else {
																$nombre = $listar['ESTADO'];
															}
										
																		echo
																		"
																			<tr>
																			<td><h4 style='text-align: left;	'>".$nombre."</h4></td>
																			<td><h4 style='text-align: center;	'>".$listar['TOTAL']."</h4></td>
																			</tr>	
																		"; 
																		
														}
													}


					if ($seleccion=='PROVEEDOR' && $tipodisp == 'monitor')
					{
						$conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p
						where p.TIPOP='MONITOR'");
					    $total = mysqli_fetch_array($conttotal);
						$fecha = date("d-m-y");
							echo "
								<h1 id='titulo'>REPORTE DE MONITORES POR PROVEEDOR</h1>
								<hr style='display: block;'>
								<h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL EQUIPOS: ".$total['TOTAL']."</h4>
								<h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
								<table id='tablareporte' class='table table-striped table-hover' width=97%>
								<thead>
								<tr style='background-color: #00519C'>
								<th class='cabecera'><p>PROVEEDOR</p></th>
								<th class='cabecera'><p>TOTAL</p></th>
								</tr>
								</thead>";
								$consultar=mysqli_query($datos_base, "SELECT e.PROVEEDOR, count(*) as TOTAL from periferico p left join proveedor e on p.ID_PROVEEDOR=e.ID_PROVEEDOR
								where p.TIPOP='MONITOR' group by e.proveedor");
											while($listar = mysqli_fetch_array($consultar))
											{
												if ($listar['PROVEEDOR']== 0) {
													$nombre = 'SIN PROVEEDOR';
												}
												else {
													$nombre = $listar['PROVEEDOR'];
												}
							
															echo
															"
																<tr>
																<td><h4 style='text-align: left;	'>".$nombre."</h4></td>
																<td><h4 style='text-align: center;	'>".$listar['TOTAL']."</h4></td>
																</tr>	
															"; 
															
											}
										}
								


									echo "
					</table>";
					?>
        </section>
</body>
</html>