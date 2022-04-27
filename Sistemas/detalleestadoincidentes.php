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
			h4{
				text-align: center;	
				font-family: TrasandinaBook;
				font-size: 20px;
				text-transform: uppercase;
			}
        </style>
        <section id="reporte">
        <div id="mostrar_reporte" style="width: 97%; margin-left: 20px; display: block;">
			
		            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
	                    <a id="vlv"  href="reporteincidentes.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
                        <div class="btn-group col-2" role="group" >
                              <button id="botonleft" type="button" class="btn btn-secondary" onclick="location.href='consulta.php'" ><i style=" margin-bottom:10px;"class='bi bi-house-door'></i></button>
                              <button id="botonright" type="button" class="btn btn-success" onClick="imprimir()" ><i class='bi bi-printer'></i></button>
                        </div>
		            </div>
		            <style type="text/css" media="print">
                              @media print {
                                             #vlv {display:none;}
                                             #pr, #botonleft, #botonright {display:none;}
		                                     #pr2 {display:none;}
											 #titulo{ margin-top: 50px;}
											 #ind{ margin-top: 20px;}
											 #tablareporte{ margin-top: 20px;}
											 #accion{ display:none;}
											 #cabeceraacc{ display:none;}
											 h4{font-size:15px;}
							  }
                    </style>
		            <script>
                           function imprimir() {
            	             window.print();
                                      }
                    </script>

			        <?php
					    $fechadesde=$_GET['desde'];
					    $fechahasta=$_GET['hasta'];
					    $estado = $_GET['Estado'];
						if ($estado==0) {
							$tit="S/A";
						}
						else {
							$consularea=mysqli_query($datos_base, "select a.ESTADO from estado a where a.ID_ESTADO=$estado");
						    $consultit=mysqli_fetch_array($consularea);
							$tit=$consultit['ESTADO'];
						}

                        $conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from ticket t where t.ID_ESTADO=$estado and t.FECHA_INICIO between '$fechadesde' and '$fechahasta'");
			            $total = mysqli_fetch_array($conttotal);
						$fecha = date("d-m-y");
						$date = date('Y-m-d');
						$consularea=mysqli_query($datos_base, "select a.ESTADO from estado a where a.ID_ESTADO=$estado");
						$consultit=mysqli_fetch_array($consularea);
						
						echo "
						<h1 id='titulo'>REPORTE DE INCIDENTES POR ESTADO:".$tit."</h1>
                        <hr style='display: block;'>
						<h4 class='indicadores'>PERIODO</h2>
		        		 <h4 class='indicadores'>DESDE: $fechadesde</h2>
				        <h4 class='indicadores'>HASTA: $fechahasta </h2>
						<h4 class='indicadores' >FECHA ACTUAL: ".$date."</h4>
				        <h4 id='ind' class='indicadores' style='margin-bottom: 20px;'>TOTAL INCIDENTES: ".$total['TOTAL']."</h4>
						
						<table id='tablareporte' width=97%>
						<thead style='border-bottom: solid 5px #073256 !important;'>
						<tr>
						        <th class='cabecera'><p>N° INCIDENTE</p></th>
								<th width=125px class='cabecera'><p>FECHA INICIO</p></th>
								<th class='cabecera'><p>USUARIO</p></th>
								<th width=350px class='cabecera'><p>DESCRIPCIÓN</p></th>
								<th class='cabecera'><p>PRIORIDAD</p></th>
								<th class='cabecera'><p>N° EQUIPO</p></th>
								<th class='cabecera'><p>FECHA DE SOLUCIÓN</p></th>
								<th class='cabecera'><p>RESOLUTOR</p></th>
								<!--<th class='cabecera' id='cabeceraacc' width=65px><p>ACCIÓN</p></th>-->
						</tr>
						</thead>";
						$consultar=mysqli_query($datos_base, "SELECT t.ID_TICKET, t.FECHA_INICIO, u.NOMBRE, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, t.FECHA_SOLUCION, r.RESOLUTOR
						FROM ticket t 
						LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
						LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
						LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR 
						left join usuarios u on t.ID_USUARIO=u.ID_USUARIO
						where t.ID_ESTADO=$estado and t.FECHA_INICIO between '$fechadesde' and '$fechahasta'
						ORDER BY t.FECHA_INICIO DESC, t.ID_TICKET DESC");
									while($listar = mysqli_fetch_array($consultar))
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
													<tr style='border-bottom: solid 1px #073256;'>
													<td><h4 style='font-size:16px;'>".$listar['ID_TICKET']."</h4></td>
													<td><h4 style='font-size:16px;'>".$fecord."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['DESCRIPCION']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['PRIORIDAD']/*$res*/."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['NRO_EQUIPO']."</h4></td>
													<td><h4 style='font-size:16px;'>".$fec."</h4 ></td>
													<td><h4 style='font-size:16px;' >".$listar['RESOLUTOR']/*$nom*/."</h4></td>
													<!--<td class='text-center text-nowrap' id='accion'><a class='btn btn-sm btn-outline-primary' href=consultadetalle.php?no=".$listar['ID_TICKET']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
													<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
													<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
												  </svg></a></td>-->
													</tr>
													"; 
				
													
												
									}
					

                    echo "
					</table>";
					?>
        </section>
		<!--<a></a>-->
</body>
</html>