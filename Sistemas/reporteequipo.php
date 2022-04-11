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

<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
	                    <a id="vlv"  href="tiporeporte.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
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
											 #ind{ margin-bottom: 0px;}
											 #tablareporte{ margin-top: 20px;}
											 #campos{display:none;}
                                            }
                    </style>
		            <script>
                           function imprimir() {
            	             window.print();
                                      }
                    </script>
	<title>REPORTE INVENTARIO</title><meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="estiloallabm.css">
	<script type="text/javascript" src="jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="jquery/1/jquery-ui.js"></script>
	<!--BUSCADOR SELECT-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<!--FIN BUSCADOR SELECT-->
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
    <section id="inicio">
        <div id="reporteEst" style="width: 97%; margin-left: 20px;">   			
        
		<style type="text/css">
		#filtrosprin{
			margin-top: 100; height: auto; width: 100%; background-color: #dbe5e9; border-top: 1px solid #53AAE0; border-bottom: 1px solid #53AAE0

		}
        </style>

        <h1>REPORTE INVENTARIO</h1>
		<div id="filtrosprin">




	
		<form id="campos" method="POST" action="reporteequipo.php">
		
        <div class="form-group row" style="margin-top: 15px;">

		<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">REPARTICION:</label>
		<select id='slcrepart' name='selectorrepart' class='form-control col-xl col-lg'>
		<option value="" selected disabled>-SELECCIONE UNA-</option>
                                    <?php
									include("conexion.php");
									$consulta= "SELECT * FROM reparticion";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_REPA']?>"><?php echo $opciones['REPA']?></option>
									<?php endforeach ?>
                          </select>
		        
				<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">AREA:</label>
                <select name="slcarea" id="slcarea" class="col-xl col-lg" style="height: 20px;">
									<option value="" selected disabled>-SELECCIONE UNA-</option>
                                    <?php
									include("conexion.php");
									$consulta= "SELECT * FROM area";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_AREA']?>"><?php echo $opciones['AREA']?></option>
									<?php endforeach ?>
								</select>
								<script>
										$('#slcarea').select2();
								</script>
								<script>
										$(document).ready(function(){
											$('#slcarea').change(function(){
												buscador='b='+$('#buscador').val();
												$.ajax({
													type: 'post',
													url: 'Controladores/session.php',
													data: buscador,
													success: function(r){
														$('#tabla').load('Componentes/Tabla.php');
													}
												})
											})
										})
									</script>

								<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">ESTADO:</label>
                <select name="slcestado" class="form-control col-xl col-lg">
									<option value="" selected disabled="tipop">-SELECCIONE UNA-</option>
                                    <?php
									include("conexion.php");
									$consulta= "SELECT * FROM estado_ws";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_ESTADOWS']?>"><?php echo $opciones['ESTADO']?></option>
									<?php endforeach ?>
								</select>
				
					
				</div>


                <div class="form-group row">
				<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">SIST. OP:</label>
                <select name="so" class="form-control col-xl col-lg">
									<option value="" selected disabled="tipop">-SELECCIONE UNA-</option>
									<?php
									include("conexion.php");
									$consulta= "SELECT * FROM so";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_SO']?>"><?php echo $opciones['SIST_OP']?></option>
									<?php endforeach ?>
								</select>
				<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">MICROPROCESADOR:</label>
                <select name="micro" id="micro" class="form-control col-xl col-lg">
									<option value="" selected disabled="marca">-SELECCIONE UNA-</option>
									<?php
									include("conexion.php");
									$consulta= "SELECT ID_MICRO, MICRO from micro";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_MICRO']?>"><?php echo $opciones['MICRO']?></option>
									<?php endforeach ?>
								</select>

								<script>
										$('#micro').select2();
								</script>
								<script>
										$(document).ready(function(){
											$('#micro').change(function(){
												buscador='b='+$('#buscador').val();
												$.ajax({
													type: 'post',
													url: 'Controladores/session.php',
													data: buscador,
													success: function(r){
														$('#tabla').load('Componentes/Tabla.php');
													}
												})
											})
										})
									</script>
					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn2" value="BUSCAR"></input>

					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn1" value="LIMPIAR"></input>
				</div>
		</form>
		</div>
		<hr>

        <?php
        $fecha = date("Y-m-d");
		echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
		if (isset($_POST['selectorrepart'])) {
			$rep=$_POST['selectorrepart'];
			$consularea=mysqli_query($datos_base, "select a.REPA from reparticion a where a.ID_REPA=$rep");
			$consultit=mysqli_fetch_array($consularea);
            $tit=$consultit['REPA'];
			echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>REPARTICION: $tit</h4>";

		}
		if (isset($_POST['slcarea'])) {
			$area=$_POST['slcarea'];
			$consularea=mysqli_query($datos_base, "select a.AREA from area a where a.ID_AREA=$area");
			$consultit=mysqli_fetch_array($consularea);
            $tit=$consultit['AREA'];
			echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>AREA: $tit</h4>";

		}
		if (isset($_POST['slcestado'])) {
			$estado=$_POST['slcestado'];
			$consularea=mysqli_query($datos_base, "select a.ESTADO from estado_ws a where a.ID_ESTADOWS=$estado");
			$consultit=mysqli_fetch_array($consularea);
            $tit=$consultit['ESTADO'];
			echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>ESTADO: $tit</h4>";

		}
		if (isset($_POST['so'])) {
			$so=$_POST['so'];
			$consularea=mysqli_query($datos_base, "select a.SIST_OP from so a where a.ID_SO=$so");
			$consultit=mysqli_fetch_array($consularea);
            $tit=$consultit['SIST_OP'];
			echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>SISTEMA OPERATIVO: $tit</h4>";

		}
		if (isset($_POST['micro'])) {
			$micro=$_POST['micro'];
			$consularea=mysqli_query($datos_base, "select a.MICRO from micro a where a.ID_MICRO=$micro");
			$consultit=mysqli_fetch_array($consularea);
            $tit=$consultit['MICRO'];
			echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>TIPO: $tit</h4>";

		}

		

if(isset($_POST['btn2']))
{
	
	if(isset($_POST['selectorrepart']))
	{
	$reparticion = $_POST['selectorrepart'];
	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
	FROM inventario i 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
	LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
	LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
	LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
	LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
	INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
	LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
	left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
	left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
	WHERE a.ID_REPA = $reparticion
	ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
		
	}

	if(isset($_POST['slcarea']))
	{
	$area = $_POST['slcarea'];
	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
	FROM inventario i 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
	LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
	LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
	LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
	LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
	INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
	LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
	left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
	left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
	WHERE i.ID_AREA = $area
	ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
		
	}

	if(isset($_POST['slcestado']))
	{
	$estado = $_POST['slcestado'];
	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
	FROM inventario i 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
	LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
	LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
	LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
	LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
	INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
	LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
	left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
	left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
	WHERE i.ID_ESTADOWS = $estado
	ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
		
	}

	if(isset($_POST['so']))
	{
	$so = $_POST['so'];
	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
	FROM inventario i 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
	LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
	LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
	LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
	LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
	INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
	LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
	left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
	left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
	WHERE s.ID_SO = $so
	ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
		
	}


	if(isset($_POST['micro']))
	{
	$micro = $_POST['micro'];
	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
	FROM inventario i 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
	LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
	LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
	LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
	LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
	INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
	LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
	left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
	left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
	WHERE m.ID_MICRO = $micro
	ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	if(isset($_POST['so']) AND isset($_POST['micro']))
	{
		$so = $_POST['so'];
		$micro = $_POST['micro'];
		$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
		FROM inventario i 
		LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
		LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
		LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
		LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
		LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
		LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
		INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
		LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
		left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
		left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
		WHERE i.ID_SO = $so AND m.ID_MICRO = $micro
		ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
		   }
	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
		   FROM inventario i 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
		   LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
		   LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
		   LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
		   LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
		   LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
		   INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
		   LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
		   left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
		   left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
		   WHERE a.ID_REPA = $reparticion and i.ID_AREA=$area
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['slcestado']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $estado = $_POST['slcestado'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
		   FROM inventario i 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
		   LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
		   LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
		   LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
		   LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
		   LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
		   INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
		   LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
		   left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
		   left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
		   WHERE a.ID_REPA = $reparticion and i.ID_ESTADOWS=$estado
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['so']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $so = $_POST['so'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
		   FROM inventario i 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
		   LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
		   LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
		   LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
		   LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
		   LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
		   INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
		   LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
		   left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
		   left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
		   WHERE a.ID_REPA = $reparticion and i.ID_SO=$so
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['micro']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $micro = $_POST['micro'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
		   FROM inventario i 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
		   LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
		   LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
		   LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
		   LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
		   LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
		   INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
		   LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
		   left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
		   left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
		   WHERE a.ID_REPA = $reparticion and m.ID_MICRO=$micro
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['slcestado']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $estado = $_POST['slcestado'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
		   FROM inventario i 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
		   LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
		   LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
		   LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
		   LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
		   LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
		   INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
		   LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
		   left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
		   left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
		   WHERE a.ID_REPA = $reparticion and i.ID_AREA=$area and i.ID_ESTADOWS=$estado
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['so']))
	{
	$reparticion = $_POST['selectorrepart'];
	$area = $_POST['slcarea'];
	$so = $_POST['so'];
	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
	FROM inventario i 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
	LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
	LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
	LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
	LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
	INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
	LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
	left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
	left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
	WHERE a.ID_REPA = $reparticion and i.ID_AREA=$area and i.ID_SO=$so
	ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['micro']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $micro = $_POST['micro'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
		   FROM inventario i 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
		   LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
		   LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
		   LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
		   LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
		   LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
		   INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
		   LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
		   left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
		   left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
		   WHERE a.ID_REPA = $reparticion and i.ID_AREA=$area and m.ID_MICRO=$micro
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}


	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['slcestado']) & isset($_POST['so']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $estado = $_POST['slcestado'];
		   $so = $_POST['so'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
		   FROM inventario i 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
		   LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
		   LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
		   LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
		   LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
		   LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
		   INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
		   LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
		   left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
		   left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
		   WHERE a.ID_REPA = $reparticion and i.ID_AREA=$area and i.ID_ESTADOWS=$estado and i.ID_SO=$so
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['slcestado']) & isset($_POST['micro']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $estado = $_POST['slcestado'];
		   $micro = $_POST['micro'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
		   FROM inventario i 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
		   LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
		   LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
		   LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
		   LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
		   LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
		   INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
		   LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
		   left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
		   left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
		   WHERE a.ID_REPA = $reparticion and i.ID_AREA=$area and i.ID_ESTADOWS=$estado and m.ID_MICRO=$micro
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['slcestado']) & isset($_POST['so']) & isset($_POST['micro']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $estado = $_POST['slcestado'];
		   $micro = $_POST['micro'];
		   $so = $_POST['so'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
		   FROM inventario i 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
		   LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
		   LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
		   LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
		   LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
		   LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
		   INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
		   LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
		   left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
		   left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
		   WHERE a.ID_REPA = $reparticion and i.ID_AREA=$area and i.ID_ESTADOWS=$estado and i.ID_SO=$so and m.ID_MICRO=$micro
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	
	
}
else
{
$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
FROM inventario i 
LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	
}
        
				echo "<table width=100%>
						<thead>
							<tr>
							<th><p>N° GOBIERNO</p></th>
							<th><p>USUARIO</p></th>
                            <th><p>MICRO</p></th>
                            <th><p>MEMORIA</p></th>
                            <th><p>TIPO MEMORIA</p></th>
							<th><p>S.O.</p></th>
                            <th><p>ESTADO</p></th>
							<th><p>REPARTICION</p></th>
							<th><p>ÁREA</p></th>
                            </tr>
						</thead>
					";
					$contador=0;
					while($listar = mysqli_fetch_array($consultar))
	{
		echo
		" 
			<tr>
				<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['MICRO']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['MEMORIA']."</h4></td>
                <td><h4 style='font-size:16px;'>".$listar['TIPOMEM']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['SIST_OP']."</h4></td>
                <td><h4 style='font-size:16px;'>".$listar['ESTADO']."</h4></td>
                <td><h4 style='font-size:16px;'>".$listar['REPA']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
			</tr>";
		$contador += 1;}

		echo "<div id=contador class='form-group row justify-content-between'>";
						// if(isset($_POST['buscar'])){
						// 		$filtro = $_POST['buscar'];
						// 		if($filtro != ""){
						// 			$filtro = strtoupper($filtro);
						// 			echo "<p>FILTRADO POR: $filtro</p>";
						// 		}
						// 	}
						echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>CANTIDAD DE EQUIPOS : $contador</h4>
						<hr>
						</div>
						</table>
						";

					?>
        		<?php
				if(isset($_GET['ok'])){
					?>
					<script>ok();</script>
					<?php			
				}
				if(isset($_GET['no'])){
					?>
					<script>no();</script>
					<?php			
				}
			?>
    </section>
</body>
</html>