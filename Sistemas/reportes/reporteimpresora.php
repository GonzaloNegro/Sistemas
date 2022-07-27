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
	                    <a id="vlv"  href="../reportes/tiporeporte.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
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
	<title>REPORTE IMPRESORAS</title><meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloallabm.css">
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

        <h1>REPORTE IMPRESORAS</h1>
		<div id="filtrosprin">




	
		<form id="campos" method="POST" action="reporteimpresora.php">
		
        <div class="form-group row" style="margin-top: 15px;">

		<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">REPARTICION:</label>
		<select id='slcrepart' name='selectorrepart' class='form-control col-xl col-lg'>
		<option value="" selected disabled>-SELECCIONE UNA-</option>
                                    <?php
									include("../particular/conexion.php");
									$consulta= "SELECT * FROM reparticion";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_REPA']?>"><?php echo $opciones['REPA']?></option>
									<?php endforeach ?>
                          </select>
		        
				<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">AREA:</label>
                <select name="slcarea" id="slcarea" class="form-control col-xl col-lg">
									<option value="" selected disabled>-SELECCIONE UNA-</option>
                                    <?php
									include("../particular/conexion.php");
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
									<option value="" selected disabled>-SELECCIONE UNA-</option>
                                    <?php
									include("../particular/conexion.php");
									$consulta= "SELECT * FROM estado_ws";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_ESTADOWS']?>"><?php echo $opciones['ESTADO']?></option>
									<?php endforeach ?>
								</select>
				
					
				</div>


                <div class="form-group row">
				<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">TIPO IMPRESORA:</label>
                <select name="tipop" class="form-control col-xl col-lg">
									<option value="" selected disabled>-SELECCIONE UNA-</option>
									<?php
									include("../particular/conexion.php");
									$consulta= "SELECT * FROM tipop";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_TIPOP']?>"><?php echo $opciones['TIPO']?></option>
									<?php endforeach ?>
								</select>
				<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">MARCA:</label>
                <select name="marca" class="form-control col-xl col-lg">
									<option value="" selected disabled="marca">-SELECCIONE UNA-</option>
									<?php
									include("../particular/conexion.php");
									$consulta= "SELECT DISTINCT m.MARCA, m.ID_MARCA FROM marcas m join periferico p on p.ID_MARCA=m.ID_MARCA WHERE p.TIPOP like '%IMPRESORA%'";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_MARCA']?>"><?php echo $opciones['MARCA']?></option>
									<?php endforeach ?>
								</select>
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
		if (isset($_POST['tipop'])) {
			$tipo=$_POST['tipop'];
			$consularea=mysqli_query($datos_base, "select a.TIPO from tipop a where a.ID_TIPOP=$tipo");
			$consultit=mysqli_fetch_array($consularea);
            $tit=$consultit['TIPO'];
			echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>TIPO: $tit</h4>";

		}
		if (isset($_POST['marca'])) {
			$marca=$_POST['marca'];
			$consularea=mysqli_query($datos_base, "select a.MARCA from marcas a where a.ID_MARCA=$marca");
			$consultit=mysqli_fetch_array($consularea);
            $tit=$consultit['MARCA'];
			echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>TIPO: $tit</h4>";

		}

		

if(isset($_POST['btn2']))
{
	
	if(isset($_POST['selectorrepart']))
	{
		
	$reparticion = $_POST['selectorrepart'];
	$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO			
	FROM periferico p 
	LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
	INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
	INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
	inner join reparticion r on a.ID_REPA=r.ID_REPA
	left join modelo mo on p.ID_MODELO=mo.ID_MODELO
	WHERE a.ID_REPA = $reparticion
	and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
		
	}

	if(isset($_POST['slcarea']))
	{
	$area = $_POST['slcarea'];
	$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO			
	FROM periferico p 
	LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
	INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
	INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
	inner join reparticion r on a.ID_REPA=r.ID_REPA
	left join modelo mo on p.ID_MODELO=mo.ID_MODELO
	WHERE p.ID_AREA = $area
	and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
		
	}

	if(isset($_POST['slcestado']))
	{
	$estado = $_POST['slcestado'];
	$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO
	FROM periferico p	LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
	INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
	INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
	inner join reparticion r on a.ID_REPA=r.ID_REPA
	left join modelo mo on p.ID_MODELO=mo.ID_MODELO
	WHERE p.ID_ESTADOWS = $estado
	and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
		
	}

	if(isset($_POST['tipop']))
	{
	$tipop = $_POST['tipop'];
	$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO			
	FROM periferico p 
	LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
	INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
	INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
	inner join reparticion r on a.ID_REPA=r.ID_REPA
	left join modelo mo on p.ID_MODELO=mo.ID_MODELO
	WHERE p.ID_TIPOP = $tipop
	and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
		
	}


	if(isset($_POST['marca']))
	{
	$marca = $_POST['marca'];
	$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO			
	FROM periferico p 
	LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
	INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
	INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
	inner join reparticion r on a.ID_REPA=r.ID_REPA
	left join modelo mo on p.ID_MODELO=mo.ID_MODELO
	WHERE p.ID_MARCA = $marca
	and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}
	if(isset($_POST['tipop']) AND isset($_POST['marca']))
	{
		$tipop = $_POST['tipop'];
		$marca = $_POST['marca'];
		$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO		
           FROM periferico p 
           LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
           LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
           INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
           INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
           WHERE p.ID_TIPOP = $tipop AND p.ID_MARCA = $marca
           and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
		   }
	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO			
		   FROM periferico p 
		   LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
		   INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
		   INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
		   WHERE a.ID_REPA = $reparticion and p.ID_AREA=$area
		   and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['slcestado']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $estado = $_POST['slcestado'];
		   $consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO		
		   FROM periferico p 
		   LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
		   INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
		   INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
		   WHERE a.ID_REPA = $reparticion and p.ID_ESTADOWS=$estado
		   and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}

	if(isset($_POST['slcarea']) & isset($_POST['slcestado']))
		   {
		$area = $_POST['slcarea'];
		   $estado = $_POST['slcestado'];
		   $consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO		
		   FROM periferico p 
		   LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
		   INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
		   INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
		   WHERE a.ID_AREA = $area and p.ID_ESTADOWS=$estado
		   and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['tipop']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $tipo = $_POST['tipop'];
		   $consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO			
		   FROM periferico p 
		   LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
		   INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
		   INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
		   WHERE a.ID_REPA = $reparticion and p.ID_TIPOP=$tipo
		   and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['marca']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $marca = $_POST['marca'];
		   $consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO			
		   FROM periferico p 
		   LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
		   INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
		   INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
		   WHERE a.ID_REPA = $reparticion and p.ID_MARCA=$marca
		   and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['slcestado']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $estado = $_POST['slcestado'];
		   $consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO			
		   FROM periferico p 
		   LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
		   INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
		   INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
		   WHERE a.ID_REPA = $reparticion and p.ID_AREA=$area and p.ID_ESTADOWS=$estado
		   and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}

	if(isset($_POST['tipop']) & isset($_POST['marca']) & isset($_POST['slcestado']))
	{
		$estado = $_POST['slcestado'];
		$tipop = $_POST['tipop'];
		$marca = $_POST['marca'];
		$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO		
           FROM periferico p 
           LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
           LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
           INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
           INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
           WHERE p.ID_TIPOP = $tipop AND p.ID_MARCA = $marca and p.ID_ESTADOWS=$estado
           and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
		   }

	if(isset($_POST['tipop']) & isset($_POST['marca']) & isset($_POST['slcarea']))
	{
		$area = $_POST['slcarea'];
		$tipop = $_POST['tipop'];
		$marca = $_POST['marca'];
		$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO		
           FROM periferico p 
           LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
           LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
           INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
           INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
           WHERE p.ID_TIPOP = $tipop AND p.ID_MARCA = $marca and a.ID_AREA = $area
           and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
		   }


	if(isset($_POST['tipop']) & isset($_POST['marca']) & isset($_POST['selectorrepart']))
	{
		$reparticion = $_POST['selectorrepart'];
		$tipop = $_POST['tipop'];
		$marca = $_POST['marca'];
		$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO		
           FROM periferico p 
           LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
           LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
           INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
           INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
           WHERE p.ID_TIPOP = $tipop AND p.ID_MARCA = $marca and a.ID_REPA = $reparticion
           and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
		   }

	

	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['tipop']))
	{
	$reparticion = $_POST['selectorrepart'];
	$area = $_POST['slcarea'];
	$tipo = $_POST['tipop'];
	$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO			
	FROM periferico p 
	LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
	INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
	INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
	inner join reparticion r on a.ID_REPA=r.ID_REPA
	left join modelo mo on p.ID_MODELO=mo.ID_MODELO
	WHERE a.ID_REPA = $reparticion and p.ID_AREA=$area and p.ID_TIPOP=$tipo
	and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['slcestado']) & isset($_POST['tipop']))
	{
	$reparticion = $_POST['selectorrepart'];
	$estado = $_POST['slcestado'];
	$tipo = $_POST['tipop'];
	$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO			
	FROM periferico p 
	LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
	INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
	INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
	inner join reparticion r on a.ID_REPA=r.ID_REPA
	left join modelo mo on p.ID_MODELO=mo.ID_MODELO
	WHERE a.ID_REPA = $reparticion and p.ID_ESTADOWS=$estado and p.ID_TIPOP=$tipo
	and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['marca']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $marca = $_POST['marca'];
		   $consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO
		   FROM periferico p 
		   LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
		   INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
		   INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
		   WHERE a.ID_REPA = $reparticion and p.ID_AREA=$area and p.ID_MARCA=$marca
		   and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['slcestado']) & isset($_POST['marca']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $estado = $_POST['slcestado'];
		   $marca = $_POST['marca'];
		   $consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO
		   FROM periferico p 
		   LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
		   INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
		   INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
		   WHERE a.ID_REPA = $reparticion and p.ID_ESTADOWS=$estado and p.ID_MARCA=$marca
		   and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}

	if(isset($_POST['slcarea']) & isset($_POST['slcestado']) & isset($_POST['tipop']))
	{
		$area = $_POST['slcarea'];
	$estado = $_POST['slcestado'];
	$tipo = $_POST['tipop'];
	$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO			
	FROM periferico p 
	LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
	INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
	INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
	inner join reparticion r on a.ID_REPA=r.ID_REPA
	left join modelo mo on p.ID_MODELO=mo.ID_MODELO
	WHERE a.ID_AREA = $area and p.ID_ESTADOWS=$estado and p.ID_TIPOP=$tipo
	and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}


	if(isset($_POST['slcarea']) & isset($_POST['slcestado']) & isset($_POST['marca']))
	{
		$area = $_POST['slcarea'];
	$estado = $_POST['slcestado'];
	$marca = $_POST['marca'];
	$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO			
	FROM periferico p 
	LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
	INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
	INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
	inner join reparticion r on a.ID_REPA=r.ID_REPA
	left join modelo mo on p.ID_MODELO=mo.ID_MODELO
	WHERE a.ID_AREA = $area and p.ID_ESTADOWS=$estado and p.ID_MARCA=$marca
	and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}


	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['slcestado']) & isset($_POST['tipop']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $estado = $_POST['slcestado'];
		   $tipo = $_POST['tipop'];
		   $consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO
		   FROM periferico p 
		   LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
		   INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
		   INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
		   WHERE a.ID_REPA = $reparticion and p.ID_AREA=$area and p.ID_ESTADOWS=$estado and p.ID_TIPOP=$tipo
		   and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}

	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['slcestado']) & isset($_POST['marca']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $estado = $_POST['slcestado'];
		   $marca = $_POST['marca'];
		   $consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO		
		   FROM periferico p 
		   LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
		   INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
		   INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
		   WHERE a.ID_REPA = $reparticion and p.ID_AREA=$area and p.ID_ESTADOWS=$estado and p.ID_MARCA=$marca
		   and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}
	if(isset($_POST['selectorrepart']) & isset($_POST['slcarea']) & isset($_POST['slcestado']) & isset($_POST['tipop']) & isset($_POST['marca']))
		   {
		   $reparticion = $_POST['selectorrepart'];
		   $area = $_POST['slcarea'];
		   $estado = $_POST['slcestado'];
		   $tipo = $_POST['tipop'];
		   $marca = $_POST['marca'];
		   $consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO			
		   FROM periferico p 
		   LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
		   LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
		   INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
		   INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
		   inner join reparticion r on a.ID_REPA=r.ID_REPA
		   left join modelo mo on p.ID_MODELO=mo.ID_MODELO
		   WHERE a.ID_REPA = $reparticion and p.ID_AREA=$area and p.ID_ESTADOWS=$estado and p.ID_TIPOP=$tipo and p.ID_MARCA=$marca
		   and p.TIPOP LIKE '%IMPRESORA%' ORDER BY u.NOMBRE ASC");
	}
	// else {
	// 	echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
	// 	$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO		
    //     FROM periferico p 
    //     LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
    //     LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
    //     INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
    //     INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
    //     inner join reparticion r on a.ID_REPA=r.ID_REPA
    //     left join modelo mo on p.ID_MODELO=mo.ID_MODELO
    //     WHERE p.TIPOP LIKE '%IMPRESORA%'
    //     ORDER BY u.NOMBRE ASC");
	// }
	
	
}
else
	{
	$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO		
	FROM periferico p 
	LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
	LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
	INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
	INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
	inner join reparticion r on a.ID_REPA=r.ID_REPA
	left join modelo mo on p.ID_MODELO=mo.ID_MODELO
	WHERE p.TIPOP LIKE '%IMPRESORA%'
	ORDER BY u.NOMBRE ASC");
		
	}
        
				echo "<table width=100%>
						<thead>
							<tr>
								<th><p>IMPRESORA</p></th>
                                <th><p>MARCA</p></th>
								<th><p>TIPO</p></th>
								<th><p>USUARIO</p></th>
								<th><p>REPARTICION</p></th>
								<th><p>ÁREA</p></th>
                                <th><p>N° GOBIERNO</p></th>
							</tr>
						</thead>
					";
					$contador=0;
					while($listar = mysqli_fetch_array($consultar))
	{
		echo
		" 
			<tr>
				<td><h4 style='font-size:16px;'>".$listar['MODELO']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['TIPO']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['REPA']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
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
						echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>CANTIDAD DE IMPRESORAS : $contador</h4>
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