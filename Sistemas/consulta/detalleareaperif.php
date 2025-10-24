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
?>

<?php
    if (!isset($_GET['Area'])){$_GET['Area'] = '';}
    if (!isset($_GET["Reparticion"])){$_GET["Reparticion"] = '';}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Inventario</title><meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloreporte.css">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
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
						<a id="vlv"  href="../reportes/reporteperifericos.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
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
					    #SE RECIBE POR GET EL ID DE TIPO DE PERIFERICO Y EL ID DE AREA
					    $tipo = $_GET['Tipo'];
                        $area=$_GET['Area'];
						if ($_GET['Area']=='' || $_GET['Area']==null){
							$area=0;
						}
						#CONDICIONALES UTILIZADOS PARA GUARDAR EN VARIABLE EL NOMBRE DEL PERIFERICO Y SU URL PARA VER EL DETALLE, ESTE ACTUALMENTE NO SE USA Y ESTA COMENTADO
                        if ($tipo=='monitor') {
                            $perif='MONITORES';
							$url='consultadetallemon.php';
                        }
						if ($tipo=='scanner') {
                            $perif='SCANNERS';
							$url='consultadetallemon.php';

                        }
                        if ($tipo=='impresora') {
                            $perif='IMPRESORAS';
							$url='consultadetalleimp.php';
                        }
						#SE OBTIENE EL NOMBRE DEL AREA
                        if ($area==0 || $area=='' || $area==null) {
                            $tit='S/A';
                        }
                        else {
                            $consularea=mysqli_query($datos_base, "select a.AREA from area a where a.ID_AREA=$area");
						    $consultit=mysqli_fetch_array($consularea);
                            $tit=$consultit['AREA'];
                        }
						#CONDICIONAL PARA DETERMINAR TIPO DE PERIFERICOS
                        if ($tipo=='otros') {
						#CONSULTA SQL PARA OBTENER EL NUMERO DE PERFIFERICOS EXCLUYENDO A MONITORES, IMPRESORAWS Y SCANNERS
						$conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL
							FROM periferico p 
							LEFT JOIN tipop t ON t.ID_TIPOP = p.ID_TIPOP 
							LEFT JOIN ( 
								SELECT ep1.* 
								FROM equipo_periferico ep1 
								INNER JOIN ( SELECT ID_PERI, MAX(ID_EQUIPO_PERIFERICO) AS max_ep 
											FROM equipo_periferico 
											GROUP BY ID_PERI 
										) ult ON ult.ID_PERI = ep1.ID_PERI AND ult.max_ep = ep1.ID_EQUIPO_PERIFERICO 
							) ep ON ep.ID_PERI = p.ID_PERI 
							LEFT JOIN inventario i ON ep.ID_WS = i.ID_WS 
							LEFT JOIN ( 
								SELECT w1.* 
								FROM wsusuario w1 
								INNER JOIN ( 
									SELECT ID_WS, MAX(ID_WSUSU) AS max_wsusu 
									FROM wsusuario GROUP BY ID_WS 
								) uw ON uw.ID_WS = w1.ID_WS AND uw.max_wsusu = w1.ID_WSUSU 
							) ws ON i.ID_WS = ws.ID_WS 
							LEFT JOIN usuarios u ON ws.ID_USUARIO = u.ID_USUARIO 
							LEFT JOIN area a ON a.ID_AREA = u.ID_AREA 
							LEFT JOIN reparticion r ON a.ID_REPA = r.ID_REPA 
							WHERE p.TIPOP!='MONITOR' and p.TIPOP!='IMPRESORA' AND p.TIPOP!='SCANNER' and a.ID_AREA=$area");
			            $total = mysqli_fetch_array($conttotal);
						$fecha = date("Y-m-d");
						#SE OBTIENE EL UNMERO DE REPARTICION
						$consultrepa=mysqli_query($datos_base, "select r.REPA from area a inner join reparticion r on a.ID_REPA=r.ID_REPA where a.ID_AREA=$area");
						$reparticion= mysqli_fetch_array($consultrepa);
						
						#CODIGO HTML PARA VISUALIZAR DATOS Y AGREGAR LA CABECERA DE LA TABLA  
						echo "
						<h1 id='titulo'>REPORTE DE PERIFERICOS POR AREA: $tit</h1>
                        <hr style='display: block;'>
						<h4 id='ind' class='indicadores' >REPARTICION: ".$reparticion['REPA']."</h4>
				        <h4 id='ind' class='indicadores' >TOTAL PERIFERICOS: ".$total['TOTAL']."</h4>
						<h4 class='indicadores' style='margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
						<table id='tablareporte' width=97%>
						<thead style='border-bottom: solid 5px #073256 !important;>
						<tr>
								<th style='text-align:center; color: #f7fbfd'><p>DISPOSITIVO</p></th>
                                <th style='text-align:center; color: #f7fbfd'><p>MARCA</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>TIPO</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>USUARIO</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>ÁREA</p></th>
                                <th style='text-align:center; color: #f7fbfd'><p>N° OBLEA</p></th>
								<!--<th class='cabecera' id='cabeceraacc'><p>ACCIÓN</p></th>-->
							</tr>
						</thead>";
						$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO 
							FROM periferico p 
							LEFT JOIN tipop t ON t.ID_TIPOP = p.ID_TIPOP 
							LEFT JOIN ( 
								SELECT ep1.* 
								FROM equipo_periferico ep1 
								INNER JOIN ( SELECT ID_PERI, MAX(ID_EQUIPO_PERIFERICO) AS max_ep 
											FROM equipo_periferico 
											GROUP BY ID_PERI 
										) ult ON ult.ID_PERI = ep1.ID_PERI AND ult.max_ep = ep1.ID_EQUIPO_PERIFERICO 
							) ep ON ep.ID_PERI = p.ID_PERI 
							LEFT JOIN inventario i ON ep.ID_WS = i.ID_WS 
							LEFT JOIN ( 
								SELECT w1.* 
								FROM wsusuario w1 
								INNER JOIN ( 
									SELECT ID_WS, MAX(ID_WSUSU) AS max_wsusu 
									FROM wsusuario GROUP BY ID_WS 
								) uw ON uw.ID_WS = w1.ID_WS AND uw.max_wsusu = w1.ID_WSUSU 
							) ws ON i.ID_WS = ws.ID_WS 
							LEFT JOIN usuarios u ON ws.ID_USUARIO = u.ID_USUARIO 
							LEFT JOIN area a ON a.ID_AREA = u.ID_AREA 
							LEFT JOIN reparticion r ON a.ID_REPA = r.ID_REPA 
						left join modelo mo on p.ID_MODELO=mo.ID_MODELO
                        INNER JOIN marcas AS m ON m.ID_MARCA = mo.ID_MARCA 
							WHERE p.TIPOP!='MONITOR' and p.TIPOP!='IMPRESORA' AND p.TIPOP!='SCANNER' and u.ID_AREA=$area
                        ORDER BY u.NOMBRE ASC");
									while($listar = mysqli_fetch_array($consultar))
									{
										echo
													"
													<tr style='border-bottom: solid 1px #073256;'>
													<td><h4 style='font-size:16px;'>".$listar['MODELO']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['TIPO']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
													<!--<td class='text-center text-nowrap' id='accion'><a class='btn btn-sm btn-outline-primary' href=url?no=".$listar['ID_PERI']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
														<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
														<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/></svg></a></td>-->
													</tr>
													"; 
				}
					

                    echo "
					</table>";
						}
						#CODIGO PARA EL RESTO DE PERIFERICOS
					else {
						#CONSULTA SQL PARA OBTENER EL NRO DE PERIFERICOS DEL TIPO SELECCIONADO

						$conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL
							FROM periferico p 
							LEFT JOIN tipop t ON t.ID_TIPOP = p.ID_TIPOP 
							LEFT JOIN ( 
								SELECT ep1.* 
								FROM equipo_periferico ep1 
								INNER JOIN ( SELECT ID_PERI, MAX(ID_EQUIPO_PERIFERICO) AS max_ep 
											FROM equipo_periferico 
											GROUP BY ID_PERI 
										) ult ON ult.ID_PERI = ep1.ID_PERI AND ult.max_ep = ep1.ID_EQUIPO_PERIFERICO 
							) ep ON ep.ID_PERI = p.ID_PERI 
							LEFT JOIN inventario i ON ep.ID_WS = i.ID_WS 
							LEFT JOIN ( 
								SELECT w1.* 
								FROM wsusuario w1 
								INNER JOIN ( 
									SELECT ID_WS, MAX(ID_WSUSU) AS max_wsusu 
									FROM wsusuario GROUP BY ID_WS 
								) uw ON uw.ID_WS = w1.ID_WS AND uw.max_wsusu = w1.ID_WSUSU 
							) ws ON i.ID_WS = ws.ID_WS 
							LEFT JOIN usuarios u ON ws.ID_USUARIO = u.ID_USUARIO 
							LEFT JOIN area a ON a.ID_AREA = u.ID_AREA 
							LEFT JOIN reparticion r ON a.ID_REPA = r.ID_REPA 
							where p.TIPOP='$tipo' and u.ID_AREA=$area");
			            $total = mysqli_fetch_array($conttotal);
						$fecha = date("Y-m-d");
						#OBTIENE NOMBRE DFE REPARTICION
						$consultrepa=mysqli_query($datos_base, "select r.REPA from area a inner join reparticion r on a.ID_REPA=r.ID_REPA where a.ID_AREA=$area");
						$reparticion= mysqli_fetch_array($consultrepa);
						$repa=$reparticion['REPA'];
						if ($reparticion['REPA']==null || $reparticion['REPA']=="") {
							$repa="";
						}
						$nombreCol="N° WS";
						if ($tipo=='impresora') {
							$nombreCol="N° PR";
						}
						if ($tipo=='monitor') {
							$nombreCol="N° OBLEA";
						}
						#SE VISUALIZA EN HTML Y SE AGREGA LA CABECERA DE LA TABLA
						echo "
						<h1 id='titulo'>REPORTE DE $perif POR AREA: $tit</h1>
                        <hr style='display: block;'>
						<h4 id='ind' class='indicadores' >REPARTICION: ".$repa."</h4>
				        <h4 id='ind' class='indicadores' >TOTAL $perif: ".$total['TOTAL']."</h4>
						<h4 class='indicadores' style='margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
						<table id='tablareporte' width=97%>
						<thead style='border-bottom: solid 5px #073256 !important;'>
						<tr>
								<th style='text-align:center; color: #f7fbfd'><p>$perif</p></th>
                                <th style='text-align:center; color: #f7fbfd'><p>MARCA</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>TIPO</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>USUARIO</p></th>
								<th style='text-align:center; color: #f7fbfd'><p>ÁREA</p></th>
                                <th style='text-align:center; color: #f7fbfd'><p>$nombreCol</p></th>
								<!--<th class='cabecera' id='cabeceraacc'><p>ACCIÓN</p></th>-->
							</tr>
						</thead>";
						#COINSULTA SQL POARA OBTENER TODOS LOS PERIFERICOS DE EL AREA SELECCIONADA Y POR TIPO 
						$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO 
							FROM periferico p 
							LEFT JOIN tipop t ON t.ID_TIPOP = p.ID_TIPOP 
							LEFT JOIN ( 
								SELECT ep1.* 
								FROM equipo_periferico ep1 
								INNER JOIN ( SELECT ID_PERI, MAX(ID_EQUIPO_PERIFERICO) AS max_ep 
											FROM equipo_periferico 
											GROUP BY ID_PERI 
										) ult ON ult.ID_PERI = ep1.ID_PERI AND ult.max_ep = ep1.ID_EQUIPO_PERIFERICO 
							) ep ON ep.ID_PERI = p.ID_PERI 
							LEFT JOIN inventario i ON ep.ID_WS = i.ID_WS 
							LEFT JOIN ( 
								SELECT w1.* 
								FROM wsusuario w1 
								INNER JOIN ( 
									SELECT ID_WS, MAX(ID_WSUSU) AS max_wsusu 
									FROM wsusuario GROUP BY ID_WS 
								) uw ON uw.ID_WS = w1.ID_WS AND uw.max_wsusu = w1.ID_WSUSU 
							) ws ON i.ID_WS = ws.ID_WS 
							LEFT JOIN usuarios u ON ws.ID_USUARIO = u.ID_USUARIO 
							LEFT JOIN area a ON a.ID_AREA = u.ID_AREA 
							LEFT JOIN reparticion r ON a.ID_REPA = r.ID_REPA 
						left join modelo mo on p.ID_MODELO=mo.ID_MODELO
                        INNER JOIN marcas AS m ON m.ID_MARCA = mo.ID_MARCA 
                        WHERE p.TIPOP='$tipo' and u.ID_AREA=$area
                        ORDER BY u.NOMBRE ASC");
						#SE EXTRAEN TODOS LOS PERIFERICOS
									while($listar = mysqli_fetch_array($consultar))
									{
										echo
													"
													<tr style='border-bottom: solid 1px #073256;'>
													<td><h4 style='font-size:16px;'>".$listar['MODELO']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['TIPO']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
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