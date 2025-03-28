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

<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
	<a id="vlv"  href="../reportes/tiporeporte.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
	<div class="btn-group col-2" role="group" >
			<button id="botonleft" type="button" class="btn btn-secondary" onclick="location.href='../consulta/consulta.php'" ><i style=" margin-bottom:10px;"class='bi bi-house-door'></i></button>
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
	<script type="text/javascript" src="jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="jquery/1/jquery-ui.js"></script>
	<!--BUSCADOR SELECT-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloallabm.css">
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



		<!--FORMULARIO QUE CONTIENE LAS ETIQQUETAS SELECT PARA FILTRAR Y GENERAR EL REPORTE DINAMICO, ESTE SE REFERENCIA A SI MISMO-->
	
		<form id="campos" method="POST" action="reporteequipo.php">
		
        <div class="form-group row" style="margin-top: 15px;">
		<!--SELECT DE REPARTICION-->
		<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">REPARTICION:</label>
		<select id='slcrepart' name='selectorrepart' class='form-control col-xl col-lg'>
		<option value="" selected disabled>-SELECCIONE UNA-</option>
                                    <?php
									//SE OBTIENE POR TABLA TODAS LAS REPARTICIONES A SELECCIONAR, EN VALUE SE CARGA EL ID DE LA REPARTICION
									include("../particular/conexion.php");
									$consulta= "SELECT * FROM reparticion";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_REPA']?>"><?php echo $opciones['REPA']?></option>
									<?php endforeach ?>
                          </select>
		      <!--SELECT DE AREA-->  
				<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">AREA:</label>
                <select name="slcarea" id="slcarea" class="form-control col-xl col-lg">
									<option value="" selected disabled>-SELECCIONE UNA-</option>
                                    <?php
									//SE OBTIENE POR TABLA TODAS LAS AREAS A SELECCIONAR
									include("../particular/conexion.php");
									$consulta= "SELECT * FROM area";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_AREA']?>"><?php echo $opciones['AREA']?></option>
									<?php endforeach ?>
								</select>
								<!--fUNCIONALIDAD PARA BUSCAR DENTRO DE LA LISTA-->
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
					<!--SELECT DE ESTADP-->
								<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">ESTADO:</label>
                <select name="slcestado" class="form-control col-xl col-lg">
									<option value="" selected disabled="tipop">-SELECCIONE UNA-</option>
                                    <?php
									//SE OBTIENE POR TABLA TODAS LOS ESTADOS A SELECCIONAR
									include("../particular/conexion.php");
									$consulta= "SELECT * FROM estado_ws";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_ESTADOWS']?>"><?php echo $opciones['ESTADO']?></option>
									<?php endforeach ?>
								</select>
				
					
				</div>

			    <!-- SELECT DE SISTEMAS OPERATIVOS-->
                <div class="form-group row">
				<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">SIST. OP:</label>
                <select name="so" class="form-control col-xl col-lg">
									<option value="" selected disabled="tipop">-SELECCIONE UNA-</option>
									<?php 
									//SE OBTIENE POR TABLA TODAS LOS S.O A SELECCIONAR
									include("conexion.php");
									$consulta= "SELECT * FROM so";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_SO']?>"><?php echo $opciones['SIST_OP']?></option>
									<?php endforeach ?>
								</select>
				<!--SELECT DE MICROP´ROCESADOR-->
				<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">MICROPROCESADOR:</label>
                <select name="micro" id="micro" class="form-control col-xl col-lg">
									<option value="" selected disabled="marca">-SELECCIONE UNA-</option>
									<?php
									//SE OBTIENE POR TABLA TODOS LOS MICROPROCESADORES A SELECCIONAR
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
		//CONJUNTO DE IF PARA MOSTRAR EN PANTALLA QUE FILTROS SE ULTILIZARON
		//SE DETERMINA QUE SI ESTAN NULL O NO LOS POST RECIBIDOS, SI TIENEN VALOR SE LO BUSCA POR CONSULTA SQL Y SE OBTIENE 
		// EL NOMBRE DEL VALUE SELECCIONADO Y SE AGREGA LA ETIQUETA HTML AL DOCUMENTO
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

		
//SE DETECTA SI EL BOTON DEL FORMULARIO FUE PRESIONADO PARA CONFIRMAR QUE SE ENVIO EL FORMULARIO
if(isset($_POST['btn2']))
{	
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE REPARTICION Y SE PROCEDE A LA COSULTA SQL
	
	if(isset($_POST['selectorrepart']) & empty($_POST['slcarea']) & empty($_POST['slcestado']) & empty($_POST['so']) & empty($_POST['micro']))
	{
	$reparticion = $_POST['selectorrepart'];
	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS,e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
	inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
	WHERE a.ID_REPA = $reparticion and ws.SLOT=1
	ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
		
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE AREA Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['slcarea']) & empty($_POST['selectorrepart']) & empty($_POST['slcestado']) & empty($_POST['so']) & empty($_POST['micro']))
	{
	$area = $_POST['slcarea'];
	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS,e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
	inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
    WHERE i.ID_AREA = $area and ws.SLOT=1
	ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
		
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE ESTADO Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['slcestado']) & empty($_POST['selectorrepart']) & empty($_POST['slcarea']) & empty($_POST['so']) & empty($_POST['micro']))
	{
	$estado = $_POST['slcestado'];
	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS,e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
    inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
	WHERE i.ID_ESTADOWS = $estado and ws.SLOT=1
	ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
		
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE S.O. Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['so']) & empty($_POST['selectorrepart']) & empty($_POST['slcarea']) & empty($_POST['slcestado']) & empty($_POST['micro']))
	{
	$so = $_POST['so'];
	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
    inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
	WHERE s.ID_SO = $so and ws.SLOT=1
	ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
		
	}

	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE MICROPROCESADOR Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['micro']) & empty($_POST['selectorrepart']) & empty($_POST['slcarea']) & empty($_POST['slcestado']) & empty($_POST['so']))
	{
	$micro = $_POST['micro'];
	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
    inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS 
	WHERE m.ID_MICRO = $micro and ws.SLOT=1
	ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE S.O Y MICRO Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['so']) & isset($_POST['micro']) & empty($_POST['selectorrepart']) & empty($_POST['slcarea']) & empty($_POST['slcestado']))
	{
		$so = $_POST['so'];
		$micro = $_POST['micro'];
		$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		WHERE i.ID_SO = $so AND m.ID_MICRO = $micro and ws.SLOT=1
		ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
		   }
		   //SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE REPARTICION Y AREA Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & empty($_POST['slcestado']) & empty($_POST['so']) & empty($_POST['micro']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE a.ID_REPA = $reparticion and i.ID_AREA=$area and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE REPARTICION Y ESTADO Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['selectorrepart']) & isset($_POST['slcestado']) & empty($_POST['slcarea']) & empty($_POST['so']) & empty($_POST['micro']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $estado = $_POST['slcestado'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE a.ID_REPA = $reparticion and i.ID_ESTADOWS=$estado and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE REPARTICION Y S.O Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['selectorrepart']) & isset($_POST['so']) & empty($_POST['slcarea']) & empty($_POST['slcestado']) & empty($_POST['micro']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $so = $_POST['so'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE a.ID_REPA = $reparticion and i.ID_SO=$so and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE AREA Y S.O Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['slcarea']) & isset($_POST['so']) & empty($_POST['selectorrepart']) & empty($_POST['slcarea']) & empty($_POST['slcestado']) & empty($_POST['so']) & empty($_POST['micro']))
		   {
		$area = $_POST['slcarea'];
		   $so = $_POST['so'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE a.ID_AREA = $area and i.ID_SO=$so and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE ESTADO Y S.O Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['slcestado']) & isset($_POST['so']) & empty($_POST['selectorrepart']) & empty($_POST['slcarea']) & empty($_POST['micro']))
		   {
		   $estado = $_POST['slcestado'];
		   $so = $_POST['so'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE i.ID_ESTADOWS = $estado and i.ID_SO=$so and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE REPARTICION Y MICRO Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['selectorrepart']) & isset($_POST['micro']) & empty($_POST['slcarea']) & empty($_POST['slcestado']) & empty($_POST['so']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $micro = $_POST['micro'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE a.ID_REPA = $reparticion and m.ID_MICRO=$micro and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE AREA Y MICRO Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['slcarea']) & isset($_POST['micro']) & empty($_POST['selectorrepart']) & empty($_POST['slcestado']) & empty($_POST['so']))
		   {
		   $area = $_POST['slcarea'];
		   $micro = $_POST['micro'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE a.ID_AREA = $area and m.ID_MICRO=$micro and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}

	if(isset($_POST['slcestado']) & isset($_POST['micro']) & empty($_POST['selectorrepart']) & empty($_POST['slcarea']) & empty($_POST['so']))
		   {
			//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE ESTADO Y MICRO Y SE PROCEDE A LA COSULTA SQL
		   $estado = $_POST['slcestado'];
		   $micro = $_POST['micro'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE i.ID_ESTADOWS = $estado and m.ID_MICRO=$micro and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE AREA Y ESTADO Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['slcarea']) & isset($_POST['slcestado']) & empty($_POST['selectorrepart']) & empty($_POST['so']) & empty($_POST['micro']))
		   {
			$area = $_POST['slcarea'];
			$estado = $_POST['slcestado'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE i.ID_AREA=$area and i.ID_ESTADOWS=$estado and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}

	if(isset($_POST['so']) & isset($_POST['micro']) & empty($_POST['selectorrepart']) & empty($_POST['slcarea']) & empty($_POST['slcestado']))
		   {
		   //SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE MICRO Y SO Y SE PROCEDE A LA COSULTA SQL
		   $micro = $_POST['micro'];
		   $so = $_POST['so'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE i.ID_SO=$so and m.ID_MICRO=$micro and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE REPARTICION, MICRO Y S.O Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['selectorrepart']) & isset($_POST['so']) & isset($_POST['micro']) & empty($_POST['slcarea']) & empty($_POST['slcestado']) & empty($_POST['micro']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $micro = $_POST['micro'];
		   $so = $_POST['so'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE a.ID_REPA = $reparticion and i.ID_SO=$so and m.ID_MICRO=$micro and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE AREA, MICRO Y S.O Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['slcarea']) & isset($_POST['so']) & isset($_POST['micro']) & empty($_POST['selectorrepart']) & empty($_POST['slcestado']))
		   {
		   $area = $_POST['slcarea'];
		   $micro = $_POST['micro'];
		   $so = $_POST['so'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE i.ID_AREA=$area and i.ID_SO=$so and m.ID_MICRO=$micro and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE ESTADO, MICRO Y S.O Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['slcestado']) & isset($_POST['so']) & isset($_POST['micro']) & empty($_POST['selectorrepart']) & empty($_POST['slcarea']))
		   {
		   $estado = $_POST['slcestado'];
		   $micro = $_POST['micro'];
		   $so = $_POST['so'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE i.ID_ESTADOWS=$estado and i.ID_SO=$so and m.ID_MICRO=$micro and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE REPARTICION,AREA Y ESTADO Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['slcestado']) & empty($_POST['so']) & empty($_POST['micro']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $estado = $_POST['slcestado'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE a.ID_REPA = $reparticion and i.ID_AREA=$area and i.ID_ESTADOWS=$estado and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE REPARTICION, AREA Y S.O Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['so']) & empty($_POST['slcestado']) & empty($_POST['micro']))
	{
	$reparticion = $_POST['selectorrepart'];
	$area = $_POST['slcarea'];
	$so = $_POST['so'];
	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
	inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
	WHERE a.ID_REPA = $reparticion and i.ID_AREA=$area and i.ID_SO=$so and ws.SLOT=1
	ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE REPARTICION, AREA Y MICRO Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['micro']) & empty($_POST['slcestado']) & empty($_POST['so']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $micro = $_POST['micro'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE a.ID_REPA = $reparticion and i.ID_AREA=$area and m.ID_MICRO=$micro and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE REPARTICION, ESTADO Y S.O Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['selectorrepart']) & isset($_POST['slcestado']) & isset($_POST['so']) & empty($_POST['slcarea']) & empty($_POST['micro']))
	{
	$reparticion = $_POST['selectorrepart'];
	$estado = $_POST['slcestado'];
	$so = $_POST['so'];
	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
	inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
	WHERE a.ID_REPA = $reparticion and i.ID_ESTADOWS=$estado and i.ID_SO=$so and ws.SLOT=1
	ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE REPARTICION, ESTADO Y MICRO Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['selectorrepart']) & isset($_POST['slcestado']) & isset($_POST['micro']) & empty($_POST['slcarea']) & empty($_POST['so']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $estado = $_POST['slcestado'];
		   $micro = $_POST['micro'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE a.ID_REPA = $reparticion and i.ID_ESTADOWS=$estado and m.ID_MICRO=$micro and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE AREA, ESTADO Y S.O Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['slcarea']) & isset($_POST['slcestado']) & isset($_POST['so']) & empty($_POST['selectorrepart']) & empty($_POST['micro']))
	{
	$area = $_POST['slcarea'];
	$estado = $_POST['slcestado'];
	$so = $_POST['so'];
	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
	inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
	WHERE a.ID_AREA = $area and i.ID_ESTADOWS=$estado and i.ID_SO=$so and ws.SLOT=1
	ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE AREA, ESTADO Y MICRO Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['slcarea']) & isset($_POST['slcestado']) & isset($_POST['micro']) & empty($_POST['selectorrepart']) & empty($_POST['so']))
		   {
			$area = $_POST['slcarea'];
		   $estado = $_POST['slcestado'];
		   $micro = $_POST['micro'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE a.ID_AREA = $area and i.ID_ESTADOWS=$estado and m.ID_MICRO=$micro and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}

	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE REPARTICION, AREA Y ESTADO Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['slcestado']) & isset($_POST['so']) & empty($_POST['micro']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $estado = $_POST['slcestado'];
		   $so = $_POST['so'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE a.ID_REPA = $reparticion and i.ID_AREA=$area and i.ID_ESTADOWS=$estado and i.ID_SO=$so and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE REPARTICION, AREA, MICRO Y ESTADO Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['slcestado']) & isset($_POST['micro']) & empty($_POST['so']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $estado = $_POST['slcestado'];
		   $micro = $_POST['micro'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE a.ID_REPA = $reparticion and i.ID_AREA=$area and i.ID_ESTADOWS=$estado and m.ID_MICRO=$micro and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
		//SE DETECTA QUE SOLO SE SELECCIONO FILTRO DE REPARTICION, AREA, ESTADO, MICRO Y S.O Y SE PROCEDE A LA COSULTA SQL
	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['slcestado']) & isset($_POST['so']) & isset($_POST['micro']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $estado = $_POST['slcestado'];
		   $micro = $_POST['micro'];
		   $so = $_POST['so'];
		   $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
		   inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
		   WHERE a.ID_REPA = $reparticion and i.ID_AREA=$area and i.ID_ESTADOWS=$estado and i.ID_SO=$so and m.ID_MICRO=$micro and ws.SLOT=1
		   ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	}
	// else {
	// 	$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
    //     FROM inventario i 
    //     LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
    //     LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
    //     LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
    //     LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
    //     LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
    //     LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
    //     INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
    //     LEFT JOIN wsmem ws on i.ID_WS=ws.ID_WS 
    //     left join memoria me ON ws.ID_MEMORIA = me.ID_MEMORIA 
    //     left join tipomem t on ws.ID_TIPOMEM=t.ID_TIPOMEM
    //     inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
    //     where ws.SLOT=1
    //     ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	// }
	
	
}
//pOR DEFECTO SI NO SE SELECCIONO NINGUN FILTRO (PRIMERA VEZ QUE SE ENTRA A LA PAGINA O SE PRESIONA EL BOTON LIMPIAR ) SE REALIZA LA CONSULTA SQL SIN NINGUN FILTRO
else
{
$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, wt.TIPOWS, e.ESTADO, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, s.SIST_OP, m.MICRO, me.MEMORIA, t.TIPOMEM
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
inner join tipows wt on i.ID_TIPOWS=wt.ID_TIPOWS
where ws.SLOT=1
ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
	
}
   //SE GENERA LA CABECERA DE LA TABLA HTML CON LAS COLUMNAS CORRESPONDIENTRES      
				echo "<table width=100%>
						<thead>
							<tr>
							<th><p>N° GOBIERNO</p></th>
							<th><p>USUARIO</p></th>
							<th><p>TIPO</p></th>
                            <th><p>MICRO</p></th>
                            <th><p>MEMORIA</p></th>
                            <th><p>TIPO MEMORIA</p></th>
							<th><p>DISCO</p></th>
							<th class='cabecera'><p>TIPO DISCO</p></th>
							<th><p>S.O.</p></th>
                            <th><p>ESTADO</p></th>
							<th><p>REPARTICION</p></th>
							<th><p>ÁREA</p></th>
                            </tr>
						</thead>
					";
					$contador=0;
					//EL ARRAY OBTENIDO DE LA CONSULTA SQL SE CONSUME EN EL WHILE Y SE EXTRAEN TODAS LAS FILAS DE LA TABLA SQL OBTENIDA
					while($listar = mysqli_fetch_array($consultar))
	{						//EN EL CASO DE MEMORIA, TIPO DE MEMORIA, DISCO Y TIPO DE DISCO LOS VALORES SE MUESTRAN EN UNA SOLA COLUMNA 
										$nWS=$listar['ID_WS'];
										//la consulkta sql recupera todas las filas correspondientes a los slots de memorias del equipo
										$memoriaram=mysqli_query($datos_base, "SELECT w.ID_WS,w.ID_MEMORIA, m.MEMORIA, w.SLOT from wsmem w inner join memoria m on w.ID_MEMORIA=m.ID_MEMORIA where w.ID_WS=$nWS");
						                $ram1="";$ram2="";$ram3="";$ram4="";
										//se recuperan los valores de todas las filas
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
										//mismo funcionamiento que para las memorias
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
										//mismo funcionamiento que para las memorias 
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
										//mismo funcionamiento que para las memorias 
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


										//se visualizan los datos en html
		echo
		" 
			<tr>
				<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['TIPOWS']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['MICRO']."</h4></td>
				<td><h4 style='font-size:14px;' class='fila'>$ram1-$ram2-$ram3-$ram4</h4></td>
                <td><h4 style='font-size:14px;' class='fila'>$tram1-$tram2-$tram3-$tram4</h4></td>
				<td><h4 style='font-size:14px;' class='fila'>$disco1-$disco2-$disco3-$disco4</h4></td>
				<td><h4 style='font-size:14px;' class='fila'>$tdisco1-$tdisco2-$tdisco3-$tdisco4</h4></td>
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
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>