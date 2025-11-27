<?php 
ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');
error_reporting(E_ALL);
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
        if (!isset($_POST['selectorrepart'])){$_POST['selectorrepart'] = '';}
        if (!isset($_POST['slcarea'])){$_POST['slcarea'] = '';}
        if (!isset($_POST["slcestado"])){$_POST["slcestado"] = '';}
        if (!isset($_POST['tipop'])){$_POST['tipop'] = '';}
        if (!isset($_POST["marca"])){$_POST["marca"] = '';}
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
	<title>REPORTE IMPRESORAS</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<!--BUSCADOR SELECT-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloallabm.css">
	<!--FIN BUSCADOR SELECT-->
    <!--Estilo bootstrap para select2-->
	<link rel="stylesheet" href="/path/to/select2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
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




		<!--DIV DE SECCION DE FILTROS, UNA VEZ SE SELECCIONAN SE PRESIONA EL BOTON BTN2 Y SE ENVIA EL FORMULARIO A SI MISMO Y SE PROCEDE A LA BUSQUEDA-->
		<form id="campos" method="POST" action="reporteimpresora.php">
		
        <div class="form-group row" style="margin-top: 15px;">

		<label id="lblForm"class="col-form-label col-xl col-lg" style="color: black;">REPARTICION:</label>
		<select id='slcrepart' name='selectorrepart' class='form-control col-xl col-lg'>
		<!--PARA ESTE SELECT Y EL RESTO LAS OPCIONES SON EXTRAIDAS DIRECTAMENTE D ELA BASE DE DATOS-->
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
                <select id="slcarea" name="slcarea" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT a.ID_AREA, a.AREA, r.REPA FROM area a inner join reparticion r on a.ID_REPA=r.ID_REPA ORDER BY AREA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_AREA']?>"><?php echo $opciones['AREA']?> - <?php echo $opciones['REPA']?></option>
                                <?php endforeach ?>
                        </select>
								
                    <!--BUSCADOR-->
						<!--Agregar {theme: 'bootstrap4',} dentro de select-->
						<script>
							$('#slcarea').select2({theme: 'bootstrap4',});
						</script>
                        <!--BUSCADOR-->
                        <script>
							$(document).ready(function(){
								$('#slcarea').on('select2:open', function () {
                                        const input = document.querySelector('.select2-container--open .select2-search__field');
                                        if (input) input.focus();
                                    });
								$('#slcarea').change(function(){
									buscador='b='+$('#slcarea').val();
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
                        <!--///////////////////////////////////////////////////////////-->

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
									$consulta= "SELECT * FROM tipop WHERE ID_TIPOP in (1,2,3,4,10,13)";
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
									$consulta= "SELECT DISTINCT m.MARCA, m.ID_MARCA FROM marcas m left join modelo mo on m.ID_MARCA=mo.ID_MARCA left join periferico p on p.ID_MODELO=mo.ID_MODELO WHERE p.TIPOP like '%IMPRESORA%'";
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
		<!--FIN FORMULARIO-->
		</div>
		<hr>

        <?php
        $fecha = date("Y-m-d");
		#CONDICIONALES QUE AGREGAN CODIGO HTML PARA MOSTRAR LAS OPCIONES SELECCIONADAS
		echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
		if (!empty($_POST['selectorrepart'])) {
			$rep=$_POST['selectorrepart'];
			$consularea=mysqli_query($datos_base, "select a.REPA from reparticion a where a.ID_REPA=$rep");
			$consultit=mysqli_fetch_array($consularea);
            $tit=$consultit['REPA'];
			echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>REPARTICION: $tit</h4>";

		}
		if (!empty($_POST['slcarea'])) {
			$area=$_POST['slcarea'];
			$consularea=mysqli_query($datos_base, "select a.AREA from area a where a.ID_AREA=$area");
			$consultit=mysqli_fetch_array($consularea);
            $tit=$consultit['AREA'];
			echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>AREA: $tit</h4>";

		}
		if (!empty($_POST['slcestado'])) {
			$estado=$_POST['slcestado'];
			$consularea=mysqli_query($datos_base, "select a.ESTADO from estado_ws a where a.ID_ESTADOWS=$estado");
			$consultit=mysqli_fetch_array($consularea);
            $tit=$consultit['ESTADO'];
			echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>ESTADO: $tit</h4>";

		}
		if (!empty($_POST['tipop'])) {
			$tipo=$_POST['tipop'];
			$consularea=mysqli_query($datos_base, "select a.TIPO from tipop a where a.ID_TIPOP=$tipo");
			$consultit=mysqli_fetch_array($consularea);
            $tit=$consultit['TIPO'];
			echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>TIPO: $tit</h4>";

		}
		if (!empty($_POST['marca'])) {
			$marca=$_POST['marca'];
			$consularea=mysqli_query($datos_base, "select a.MARCA from marcas a where a.ID_MARCA=$marca");
			$consultit=mysqli_fetch_array($consularea);
            $tit=$consultit['MARCA'];
			echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>TIPO: $tit</h4>";

		}



$where = " WHERE p.TIPOP = 'IMPRESORA' ";		

	#CADA CONSULTA SQL FILTRA DE ACUERDO A LAS OPCIONES SELECCIONADAS

	#REPARTICION
	if(!empty($_POST['selectorrepart']))
	{
	$reparticion = intval($_POST['selectorrepart']);
	$where.= " AND a.ID_REPA = $reparticion ";
	}
	#AREA
	if(!empty($_POST['slcarea']))
	{
	$area =intval( $_POST['slcarea']);
	$where.= " AND a.ID_AREA = $area ";
	}
	#ESTADO
	if(!empty($_POST['slcestado']))
	{
	$estado = intval($_POST['slcestado']);
	$where.= " AND p.ID_ESTADOWS = $estado ";
	}
	#TIPO PERIFERICO
	if(!empty($_POST['tipop']))
	{
	$tipop = intval($_POST['tipop']);
	$where.= " AND p.ID_TIPOP = $tipop ";
	}

	#MARCA
	if(!empty($_POST['marca']))
	{
	$marca = intval($_POST['marca']);
	$where.= " AND mo.ID_MARCA = $marca ";
	}

	// $where.=" AND ep.ID_EQUIPO_PERIFERICO=(select max(epp.ID_EQUIPO_PERIFERICO) from equipo_periferico epp where epp.ID_PERI=p.ID_PERI) ";
	$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, r.REPA, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA, mo.MODELO		
	FROM periferico p
	LEFT JOIN modelo mo  ON mo.ID_MODELO = p.ID_MODELO
	LEFT JOIN marcas m   ON m.ID_MARCA   = mo.ID_MARCA
	LEFT JOIN estado_ws e ON e.ID_ESTADOWS = p.ID_ESTADOWS
	LEFT JOIN tipop t    ON t.ID_TIPOP   = p.ID_TIPOP
	LEFT JOIN (
		SELECT ep1.*
		FROM equipo_periferico ep1
		INNER JOIN (
			SELECT ID_PERI, MAX(ID_EQUIPO_PERIFERICO) AS max_ep
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
			FROM wsusuario
			GROUP BY ID_WS
		) uw ON uw.ID_WS = w1.ID_WS AND uw.max_wsusu = w1.ID_WSUSU
	) ws ON i.ID_WS = ws.ID_WS

	LEFT JOIN usuarios u  ON ws.ID_USUARIO = u.ID_USUARIO
	LEFT JOIN area a      ON a.ID_AREA = u.ID_AREA
	LEFT JOIN reparticion r ON a.ID_REPA = r.ID_REPA
	$where
	ORDER BY u.NOMBRE ASC");
		
	
        
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
	#CICLO WHILE PARA EXTRAER TODAS LAS FILAS RESULTADOS DEL ARRAY
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
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>