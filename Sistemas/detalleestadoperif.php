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
	                    <a id="vlv"  href="reporteperifericos.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
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
					    
					    $tipo = $_GET['Tipo'];
                        $estado=$_GET['Estado'];
                        if ($tipo=='monitor') {
                            $perif='MONITORES';
							$url='consultadetallemon.php';

                        }
						if ($tipo=='scanner') {
                            $perif='SCANNERS';
							$url='consultadetallemon.php';

                        }
                        else {
                            $perif='IMPRESORAS';
							$url='consultadetalleimp.php';

                        }
                        if ($estado==0) {
                            $tit='S/A';
                        }
                        else {
                            $consulest=mysqli_query($datos_base, "select a.ESTADO from estado_ws a where a.ID_ESTADOWS=$estado");
						    $consultit=mysqli_fetch_array($consulest);
                            $tit=$consultit['ESTADO'];
                        }
						if ($tipo=='otros') {
                        $conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p WHERE p.TIPOP!='MONITOR' and p.TIPOP!='IMPRESORA' AND p.TIPOP!='SCANNER' and p.ID_ESTADOWS=$estado");
			            $total = mysqli_fetch_array($conttotal);
						$fecha = date("Y-m-d");
						
						
						echo "
						<h1 id='titulo'>REPORTE DE PERIFERICOS POR ESTADO: $tit</h1>
                        <hr style='display: block;'>
				        <h4 id='ind' class='indicadores' >TOTAL $perif: ".$total['TOTAL']."</h4>
						<h4 class='indicadores' style='margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
						<table id='tablareporte' class='table table-striped table-hover' width=97%>
						<thead>
						<tr style='background-color: #00519C'>
								<th style='text-align:center; color: #f7fbfd'><p>PERIFERICO</p></th>
                                <th style='text-align:center; color: #f7fbfd'><p>MARCA</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>USUARIO</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>N° WS</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>TIPO</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>ÁREA</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>REPARTICION</p></th>
								<!--<th class='cabecera' id='cabeceraacc'><p>ACCIÓN</p></th>-->
							</tr>
						</thead>";
						$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, R.REPA, mo.MODELO			
                        FROM periferico p 
                        LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
                        LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
                        INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
                        INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA
                        left join modelo mo on p.ID_MODELO=mo.ID_MODELO
						WHERE p.TIPOP!='MONITOR' and p.TIPOP!='IMPRESORA' AND p.TIPOP!='SCANNER' and p.ID_ESTADOWS=$estado
                        ORDER BY u.NOMBRE ASC");
									while($listar = mysqli_fetch_array($consultar))
									{
										echo
													"
													<tr>
													<td><h4 style='font-size:16px;'>".$listar['MODELO']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['TIPO']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['REPA']."</h4></td>
													<!--<td class='text-center text-nowrap' id='accion'><a class='btn btn-sm btn-outline-primary' href=$url?no=".$listar['ID_PERI']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
														<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
														<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/></svg></a></td>-->
													</tr>
													"; 
				
													
												
									}
					

                    echo "
					</table>";
					}
					else {
						
                        $conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='$tipo' and p.ID_ESTADOWS=$estado");
			            $total = mysqli_fetch_array($conttotal);
						$fecha = date("Y-m-d");
						
						
						echo "
						<h1 id='titulo'>REPORTE DE $perif POR ESTADO: $tit</h1>
                        <hr style='display: block;'>
				        <h4 id='ind' class='indicadores' >TOTAL $perif: ".$total['TOTAL']."</h4>
						<h4 class='indicadores' style='margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
						<table id='tablareporte' class='table table-striped table-hover' width=97%>
						<thead>
						<tr style='background-color: #00519C'>
								<th style='text-align:center; color: #f7fbfd'><p>$perif</p></th>
                                <th style='text-align:center; color: #f7fbfd'><p>MARCA</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>USUARIO</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>N° WS</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>TIPO</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>ÁREA</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>REPARTICION</p></th>
								<!--<th class='cabecera' id='cabeceraacc'><p>ACCIÓN</p></th>-->
							</tr>
						</thead>";
						$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, R.REPA, mo.MODELO			
                        FROM periferico p 
                        LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
                        LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
                        INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
                        INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA
                        left join modelo mo on p.ID_MODELO=mo.ID_MODELO
						WHERE p.TIPOP='$tipo' and p.ID_ESTADOWS=$estado
                        ORDER BY u.NOMBRE ASC");
									while($listar = mysqli_fetch_array($consultar))
									{
										echo
													"
													<tr>
													<td><h4 style='font-size:16px;'>".$listar['MODELO']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['TIPO']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['REPA']."</h4></td>
													<!--<td class='text-center text-nowrap' id='accion'><a class='btn btn-sm btn-outline-primary' href=$url?no=".$listar['ID_PERI']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
														<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
														<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/></svg></a></td>-->
													</tr>
													"; 
				
													
												
									}
					

                    echo "
					</table>";
					}
					?>
        </section>
</body>
</html>