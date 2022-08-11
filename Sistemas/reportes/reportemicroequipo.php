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
<!DOCTYPE html>
<html>
<head>
	<title>Inventario</title><meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloreporte.css">
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
					<a id="vlv"  onClick="volver()" class="btn btn-primary ">VOLVER</a>	
					<script>
                           function volver() {
							window.history.back();
                                      }
                    </script>
                        <div class="btn-group col-2" role="group" >
                              <button id="botonleft" type="button" class="btn btn-secondary" onclick="location.href='../consulta/consulta.php'" ><i style=" margin-bottom:10px;"class='bi bi-house-door'></i></button>
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
					    $micro = $_GET['Micro'];
						$reparticion=$_GET['Repa'];

                        if ($reparticion==0) {
						$contPC=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario i LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	                    LEFT JOIN micro AS mi ON mi.ID_MICRO = mw.ID_MICRO where mi.ID_MICRO =$micro AND i.ID_TIPOWS=1");
						$totalPC = mysqli_fetch_array($contPC);
						$contNB=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario i LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	                    LEFT JOIN micro AS mi ON mi.ID_MICRO = mw.ID_MICRO where mi.ID_MICRO =$micro AND i.ID_TIPOWS=2");
						$totalNB = mysqli_fetch_array($contNB);
						
						$conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario i LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	                    LEFT JOIN micro AS mi ON mi.ID_MICRO = mw.ID_MICRO where mi.ID_MICRO =$micro");
			            $total = mysqli_fetch_array($conttotal);
						$fecha = date("Y-m-d");
						//$consularea=mysqli_query($datos_base, "select a.SIST_OP from so a where a.ID_SO=$so");
						$contit= mysqli_query($datos_base, "SELECT MICRO from micro where ID_MICRO=$micro");
						$consultit=mysqli_fetch_array($contit);
						echo "
						<h1 id='titulo'>REPORTE DE EQUIPOS POR MP:".$consultit['MICRO']."</h1>
                        <hr style='display: block; margin-top:60px;'>
						<h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE PC DE ESCRITORIO: ".$totalPC['TOTAL']."</h4>
						<h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE NOTEBOOKS: ".$totalNB['TOTAL']."</h4>
				        <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL EQUIPOS: ".$total['TOTAL']."</h4>
						<h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
						<table id='tablareporte' width=97%>
						<thead style='border-bottom: solid 5px #073256 !important;'>
						<tr>
						<th class='cabecera'><p>N°WS</p></th>
						<th class='cabecera'><p>USUARIO</p></th>
						<th class='cabecera'><p>SO</p></th>
						<th><p class=g>MEMORIA</p></th>
						<th><p class=g>TIPO MEMORIA</p></th>
						<th><p class=g>DISCO</p></th>
						<th><p class=g>TIPO DISCO</p></th>
                        <th class='cabecera'><p>ESTADO</p></th>
                        <th class='cabecera'><p>AREA</p></th>
						<th class='cabecera'><p>REPARTICION</p></th>
						<!--<th id='cabeceraacc' class='cabecera' width=65px><p>ACCIÓN</p></th>-->
						</tr>
						</thead>";
						$consultar=mysqli_query($datos_base, "select i.SERIEG as N°WS, i.ID_WS, u.NOMBRE, mi.MICRO, s.SIST_OP, e.ESTADO, a.AREA, r.REPA 
						from inventario i left join usuarios u on i.ID_USUARIO=u.ID_USUARIO 
						LEFT JOIN estado_ws e on i.ID_ESTADOWS=E.ID_ESTADOWS
                        left join area a on i.ID_AREA=a.ID_AREA 
						left join so s on i.ID_SO=s.ID_SO LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA 
						LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	                    LEFT JOIN micro AS mi ON mi.ID_MICRO = mw.ID_MICRO
						where mi.ID_MICRO = $micro");
									while($listar = mysqli_fetch_array($consultar))
									{

										$nWS=$listar['ID_WS'];
										$memoriaram=mysqli_query($datos_base, "SELECT w.ID_WS,w.ID_MEMORIA, m.MEMORIA, w.SLOT from wsmem w inner join memoria m on w.ID_MEMORIA=m.ID_MEMORIA where w.ID_WS=$nWS");
						                $ram1="";$ram2="";$ram3="";$ram4="";
										while($memram= mysqli_fetch_array($memoriaram)){
											if ($memram['SLOT']==1) {
												$ram1=$memram['MEMORIA'];
											}
											if ($memram['SLOT']==2) {
												$ram2=$memram['MEMORIA'];
											}
											if ($memram['SLOT']==3) {
												$ram3=$memram['MEMORIA'];
											}
											if ($memram['SLOT']==4) {
												$ram4=$memram['MEMORIA'];
											}

										}
										$tiporam=mysqli_query($datos_base, "SELECT w.ID_WS, w.SLOT, t.TIPOMEM from wsmem w inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM where w.ID_WS=$nWS");
						                $tram1="";$tram2="";$tram3="";$tram4="";
										while($tmemram= mysqli_fetch_array($tiporam)){
											if ($tmemram['SLOT']==1) {
												$tram1=$tmemram['TIPOMEM'];
											}
											if ($tmemram['SLOT']==2) {
												$tram2=$tmemram['TIPOMEM'];
											}
											if ($tmemram['SLOT']==3) {
												$tram3=$tmemram['TIPOMEM'];
											}
											if ($tmemram['SLOT']==4) {
												$tram4=$tmemram['TIPOMEM'];
											}

										}

										$discos=mysqli_query($datos_base, "select d.NUMERO, t.DISCO from discows d inner join disco t on d.ID_DISCO=t.ID_DISCO where d.ID_WS=$nWS");
						                $disco1="";$disco2="";
										while($disc= mysqli_fetch_array($discos)){
											if ($disc['NUMERO']==1) {
												$disco1=$disc['DISCO'];
											}
											if ($disc['NUMERO']==2) {
												$disco2=$disc['DISCO'];
											}
											if ($disc['NUMERO']==3) {
												$disco3=$disc['DISCO'];
											}
											if ($disc['NUMERO']==4) {
												$disco4=$disc['DISCO'];
											}

										}

										$tdiscos=mysqli_query($datos_base, "select d.ID_WS, d.ID_DISCO, d.NUMERO, t.TIPOD from discows d inner join tipodisco t on d.ID_TIPOD=t.ID_TIPOD where d.ID_WS=$nWS");
						                $tdisco1="";$tdisco2="";
										while($tdisc= mysqli_fetch_array($tdiscos)){
											if ($tdisc['NUMERO']==1) {
												$tdisco1=$tdisc['TIPOD'];
											}
											if ($tdisc['NUMERO']==2) {
												$tdisco2=$tdisc['TIPOD'];
											}
											if ($tdisc['NUMERO']==3) {
												$tdisco3=$tdisc['TIPOD'];
											}
											if ($tdisc['NUMERO']==4) {
												$tdisco4=$tdisc['TIPOD'];
											}

										}	
									
										echo
													"
														<tr style='border-bottom: solid 1px #073256;'>
														<td><h4 class='filas' style='text-align: left; '>".$listar['N°WS']."</h4></td>
														<td><h4 class='filas' style='text-align: center; '>".$listar['NOMBRE']."</h4></td>
														<td><h4 class='filas' style='text-align: left; '>".$listar['SIST_OP']."</h4></td>
														<td><h4 style='font-size:14px;' class='fila'>$ram1-$ram2-$ram3-$ram4</h4></td>
														<td><h4 style='font-size:14px;' class='fila'>$tram1-$tram2-$tram3-$tram4</h4></td>
														<td><h4 style='font-size:14px;' class='fila'>$disco1-$disco2-$disco3-$disco4</h4></td>
														<td><h4 style='font-size:14px;' class='fila'>$tdisco1-$tdisco2-$tdisco3-$tdisco4</h4></td>
                                                        <td><h4 class='filas' style='text-align: center; '>".$listar['ESTADO']."</h4></td>
                                                        <td><h4 class='filas' style='text-align: center; '>".$listar['AREA']."</h4></td>
														<td><h4 class='filas' style='text-align: center; '>".$listar['REPA']."</h4></td>
														<!--<td class='text-center text-nowrap' id='accion'><a class='btn btn-sm btn-outline-primary' href=../consulta/consultadetalleinv.php?no=".$listar['N°WS']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
													<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
													<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
												  </svg></a></td>-->
														</tr>	
													"; 
				
													
												
									}echo "
					</table>";
								}
					

                    
					else {
						$contPC=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario i LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	                    LEFT JOIN micro AS mi ON mi.ID_MICRO = mw.ID_MICRO  left join area a on i.ID_AREA=a.ID_AREA left join reparticion r on
						a.ID_REPA=r.ID_REPA where mi.ID_MICRO =$micro AND i.ID_TIPOWS=1");
						$totalPC = mysqli_fetch_array($contPC);
						$contNB=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario i LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	                    LEFT JOIN micro AS mi ON mi.ID_MICRO = mw.ID_MICRO  left join area a on i.ID_AREA=a.ID_AREA left join reparticion r on
						a.ID_REPA=r.ID_REPA where mi.ID_MICRO = $micro and a.ID_REPA=$reparticion AND i.ID_TIPOWS=2");
						$totalNB = mysqli_fetch_array($contNB);

						$conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario i LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	                    LEFT JOIN micro AS mi ON mi.ID_MICRO = mw.ID_MICRO  left join area a on i.ID_AREA=a.ID_AREA left join reparticion r on
						a.ID_REPA=r.ID_REPA where mi.ID_MICRO =$micro and a.ID_REPA=$reparticion");
			            $total = mysqli_fetch_array($conttotal);
						$fecha = date("Y-m-d");
						//$consularea=mysqli_query($datos_base, "select a.SIST_OP from so a where a.ID_SO=$so");
						$consultit=$micro;
						$consultrepa=mysqli_query($datos_base, "select r.REPA from reparticion r where r.ID_REPA=$reparticion");
						$repa= mysqli_fetch_array($consultrepa);
						echo "
						<h1 id='titulo'>REPORTE DE EQUIPOS POR MP:".$consultit."</h1>
                        <hr style='display: block; margin-top:60px;'>
						<h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>REPARTICION: ".$repa['REPA']."</h4>
				        <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE PC DE ESCRITORIO: ".$totalPC['TOTAL']."</h4>
						<h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE NOTEBOOKS: ".$totalNB['TOTAL']."</h4>
						<h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL EQUIPOS: ".$total['TOTAL']."</h4>
						<h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
						<table id='tablareporte' width=97%>
						<thead style='border-bottom: solid 5px #073256 !important;'>
						<tr>
						<th class='cabecera'><p>N°WS</p></th>
						<th class='cabecera'><p>USUARIO</p></th>
						<th class='cabecera'><p>SO</p></th>
						<th><p class=g>MEMORIA</p></th>
						<th><p class=g>TIPO MEMORIA</p></th>
						<th><p class=g>DISCO</p></th>
						<th><p class=g>TIPO DISCO</p></th>
                        <th class='cabecera'><p>ESTADO</p></th>
                        <th class='cabecera'><p>AREA</p></th>
						<!--<th id='cabeceraacc' class='cabecera' width=65px><p>ACCIÓN</p></th>-->
						</tr>
						</thead>";
						$consultar=mysqli_query($datos_base, "select i.SERIEG as N°WS, i.ID_WS, u.NOMBRE, mi.MICRO, s.SIST_OP, e.ESTADO, a.AREA, r.REPA 
						from inventario i left join usuarios u on i.ID_USUARIO=u.ID_USUARIO 
						LEFT JOIN estado_ws e on i.ID_ESTADOWS=E.ID_ESTADOWS
                        left join area a on i.ID_AREA=a.ID_AREA 
						left join so s on i.ID_SO=s.ID_SO LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA 
						LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	                    LEFT JOIN micro AS mi ON mi.ID_MICRO = mw.ID_MICRO
						where mi.ID_MICRO = $micro and r.ID_REPA=$reparticion");
									while($listar = mysqli_fetch_array($consultar))
									{
										$nWS=$listar['ID_WS'];
										$memoriaram=mysqli_query($datos_base, "SELECT w.ID_WS,w.ID_MEMORIA, m.MEMORIA, w.SLOT from wsmem w inner join memoria m on w.ID_MEMORIA=m.ID_MEMORIA where w.ID_WS=$nWS");
						                $ram1="";$ram2="";$ram3="";$ram4="";
										while($memram= mysqli_fetch_array($memoriaram)){
											if ($memram['SLOT']==1) {
												$ram1=$memram['MEMORIA'];
											}
											if ($memram['SLOT']==2) {
												$ram2=$memram['MEMORIA'];
											}
											if ($memram['SLOT']==3) {
												$ram3=$memram['MEMORIA'];
											}
											if ($memram['SLOT']==4) {
												$ram4=$memram['MEMORIA'];
											}

										}
										$tiporam=mysqli_query($datos_base, "SELECT w.ID_WS, w.SLOT, t.TIPOMEM from wsmem w inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM where w.ID_WS=$nWS");
						                $tram1="";$tram2="";$tram3="";$tram4="";
										while($tmemram= mysqli_fetch_array($tiporam)){
											if ($tmemram['SLOT']==1) {
												$tram1=$tmemram['TIPOMEM'];
											}
											if ($tmemram['SLOT']==2) {
												$tram2=$tmemram['TIPOMEM'];
											}
											if ($tmemram['SLOT']==3) {
												$tram3=$tmemram['TIPOMEM'];
											}
											if ($tmemram['SLOT']==4) {
												$tram4=$tmemram['TIPOMEM'];
											}

										}

										$discos=mysqli_query($datos_base, "select d.NUMERO, t.DISCO from discows d inner join disco t on d.ID_DISCO=t.ID_DISCO where d.ID_WS=$nWS");
						                $disco1="";$disco2="";
										while($disc= mysqli_fetch_array($discos)){
											if ($disc['NUMERO']==1) {
												$disco1=$disc['DISCO'];
											}
											if ($disc['NUMERO']==2) {
												$disco2=$disc['DISCO'];
											}
											if ($disc['NUMERO']==3) {
												$disco3=$disc['DISCO'];
											}
											if ($disc['NUMERO']==4) {
												$disco4=$disc['DISCO'];
											}

										}

										$tdiscos=mysqli_query($datos_base, "select d.ID_WS, d.ID_DISCO, d.NUMERO, t.TIPOD from discows d inner join tipodisco t on d.ID_TIPOD=t.ID_TIPOD where d.ID_WS=$nWS");
						                $tdisco1="";$tdisco2="";
										while($tdisc= mysqli_fetch_array($tdiscos)){
											if ($tdisc['NUMERO']==1) {
												$tdisco1=$tdisc['TIPOD'];
											}
											if ($tdisc['NUMERO']==2) {
												$tdisco2=$tdisc['TIPOD'];
											}
											if ($tdisc['NUMERO']==3) {
												$tdisco3=$tdisc['TIPOD'];
											}
											if ($tdisc['NUMERO']==4) {
												$tdisco4=$tdisc['TIPOD'];
											}

										}	
										
										echo
													"
														<tr style='border-bottom: solid 1px #073256;'>
														<td><h4 class='filas' style='text-align: left; '>".$listar['N°WS']."</h4></td>
														<td><h4 class='filas' style='text-align: center; '>".$listar['NOMBRE']."</h4></td>
														<td><h4 class='filas' style='text-align: left; '>".$listar['SIST_OP']."</h4></td>
														<td><h4 style='font-size:14px;' class='fila'>$ram1-$ram2-$ram3-$ram4</h4></td>
														<td><h4 style='font-size:14px;' class='fila'>$tram1-$tram2-$tram3-$tram4</h4></td>
														<td><h4 style='font-size:14px;' class='fila'>$disco1-$disco2-$disco3-$disco4</h4></td>
														<td><h4 style='font-size:14px;' class='fila'>$tdisco1-$tdisco2-$tdisco3-$tdisco4</h4></td>
                                                        <td><h4 class='filas' style='text-align: center; '>".$listar['ESTADO']."</h4></td>
                                                        <td><h4 class='filas' style='text-align: center; '>".$listar['AREA']."</h4></td>
														<!--<td class='text-center text-nowrap' id='accion'><a class='btn btn-sm btn-outline-primary' href=../consulta/consultadetalleinv.php?no=".$listar['N°WS']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
													<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
													<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
												  </svg></a></td>-->
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