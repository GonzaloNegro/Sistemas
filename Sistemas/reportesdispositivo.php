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

        <?php 
		if ($tipodisp=='scanner') {
			header("Location:reportesdispositivoext.php?seleccion=$seleccion&tipo=$tipodisp");
		}
		if ($tipodisp=='otros') {
			header("Location:reportesdispositivoext.php?seleccion=$seleccion&tipo=$tipodisp");
		}
		// if ($tipodisp=='impresora') {
		// 	header("Location:reporteprinter.php?opc=$seleccion&repart=0&imp=0");
		// }
		?>
        <div id="mostrar_reporte" style="width: 97%; margin-left: 20px; display: block;">
			
		            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
	                    <a id="vlv"  href="reporteperifericos.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
						<div class="btn-group col-2" role="group" >
                              <button id="botonleft" type="button" class="btn btn-secondary" onclick="location.href='consulta.php'" ><i style=" margin-bottom:10px;"class='bi bi-house-door'></i></button>
                              <button id="botonright" type="button" class="btn btn-success" onClick="imprimir()" ><i class='bi bi-printer'></i></button>
                        </div>
		            </div>
		            <style type="text/css" media="print">
                              @media print {
                                             #vlv, #accion, .cabe {display:none;}
                                             #pr, #botonleft, #botonright {display:none;}
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

					if ($tipodisp == 'impresora') {
					if($seleccion=='AREA'){
                        $conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p
			            where p.TIPOP='IMPRESORA'");
			            $total = mysqli_fetch_array($conttotal);
						$fecha = date("Y-m-d");
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
						<th class='cabecera'><p class='cabe' style='width: 80px;' >ACCION</p></th>
						</tr>
						</thead>";
						$consultar=mysqli_query($datos_base, "SELECT a.AREA, p.ID_AREA, count(*) as TOTAL from periferico p left join area a on p.ID_AREA=a.ID_AREA
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
														<td class='text-center text-nowrap' style='width: 80px;' id='accion'><a class='btn btn-sm btn-outline-primary' href='detalleareaperif.php?Area=".$listar['ID_AREA']."&Tipo=$tipodisp' class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
													<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
													<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
												  </svg></a></td>
												  </tr>	
													"; 
												
									}
					}
                    if ($seleccion=='ESTADO' && $tipodisp == 'impresora') {
                        $conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p
			            where p.TIPOP='IMPRESORA'");
			            $total = mysqli_fetch_array($conttotal);
						$fecha = date("Y-m-d");
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
						<th class='cabe'><p class='cabecera' style='width: 80px;' >ACCION</p></th>
						</tr>
						</thead>";
						$consultar=mysqli_query($datos_base, "SELECT e.ESTADO, p.ID_ESTADOWS, count(*) as TOTAL from periferico p left join estado_ws e on p.ID_ESTADOWS=e.ID_ESTADOWS
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
														<td class='text-center text-nowrap' id='accion' style='width: 80px;'><a class='btn btn-sm btn-outline-primary' href='detalleestadoperif.php?Estado=".$listar['ID_ESTADOWS']."&Tipo=$tipodisp' class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
													<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
													<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
												  </svg></a></td>
												  </tr>	
													"; 
												
									}
                    }
					if ($seleccion=='PROVEEDOR' && $tipodisp == 'impresora')
					{
						$conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p
			            where p.TIPOP='IMPRESORA'");
			            $total = mysqli_fetch_array($conttotal);
						$fecha = date("Y-m-d");
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
						<th class='cabe'><p class='cabecera' style='width: 80px;' >ACCION</p></th>
						</tr>
						</thead>";
						$consultar=mysqli_query($datos_base, "SELECT e.PROVEEDOR, p.ID_PROVEEDOR, count(*) as TOTAL from periferico p left join proveedor e on p.ID_PROVEEDOR=e.ID_PROVEEDOR
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
														<td class='text-center text-nowrap' id='accion' style='width: 80px;'><a class='btn btn-sm btn-outline-primary' href='detalleproveedorperif.php?Proveedor=".$listar['ID_PROVEEDOR']."&Tipo=$tipodisp' class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
													<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
													<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
												  </svg></a></td>
												  </tr>	
													"; 
												
									}
								}}

                    if ($tipodisp == 'monitor') {
						
				    if($seleccion=='AREA'){
						$conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p
		     			where p.TIPOP='MONITOR'");
						$total = mysqli_fetch_array($conttotal);
						$fecha = date("Y-m-d");
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
								<th class='cabe'><p class='cabecera'>ACCION</p></th>
								</tr>
							</thead>";
									$consultar=mysqli_query($datos_base, "SELECT a.AREA, p.ID_AREA, count(*) as TOTAL from periferico p left join area a on p.ID_AREA=a.ID_AREA
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
																	<td class='text-center text-nowrap' id='accion' style='width: 80px;'><a class='btn btn-sm btn-outline-primary' href='detalleareaperif.php?Area=".$listar['ID_AREA']."&Tipo=$tipodisp' class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
													<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
													<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
												  </svg></a></td>
												  </tr>	
																"; 
															
												}
								}
								if ($seleccion=='ESTADO')
								{
									$conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p
									where p.TIPOP='MONITOR'");
									$total = mysqli_fetch_array($conttotal);
									$fecha = date("Y-m-d");
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
											<th class='cabe'><p class='cabecera' style='width: 80px;' >ACCION</p></th>
											</tr>
											</thead>";
											$consultar=mysqli_query($datos_base, "SELECT e.ESTADO, p.ID_ESTADOWS, count(*) as TOTAL from periferico p left join estado_ws e on p.ID_ESTADOWS=e.ID_ESTADOWS
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
																			<td class='text-center text-nowrap' id='accion' style='width: 80px;'><a class='btn btn-sm btn-outline-primary' href='detalleestadoperif.php?Estado=".$listar['ID_ESTADOWS']."&Tipo=$tipodisp' class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
													<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
													<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
												  </svg></a></td>
																			</tr>	
																		"; 
																		
														}
													}


					if ($seleccion=='PROVEEDOR')
					{
						$conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p
						where p.TIPOP='MONITOR'");
					    $total = mysqli_fetch_array($conttotal);
						$fecha = date("Y-m-d");
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
								<th class='cabe'><p class='cabecera' style='width: 80px;' >ACCION</p></th>
								</tr>
								</thead>";
								$consultar=mysqli_query($datos_base, "SELECT e.PROVEEDOR, p.ID_PROVEEDOR, count(*) as TOTAL from periferico p left join proveedor e on p.ID_PROVEEDOR=e.ID_PROVEEDOR
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
																<td class='text-center text-nowrap' id='accion' style='width: 80px;'><a class='btn btn-sm btn-outline-primary' href='detalleproveedorperif.php?Proveedor=".$listar['ID_PROVEEDOR']."&Tipo=$tipodisp' class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
													<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
													<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
												  </svg></a></td>
												  </tr>	
															"; 
															
											}
										}}

					echo "
					</table>";
					?>
        </section>
</body>
</html>