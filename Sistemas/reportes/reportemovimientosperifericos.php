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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<!--BUSCADOR SELECT-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<!--FIN BUSCADOR SELECT-->
	<link rel="stylesheet" type="text/css" href="../estilos/estiloreporte.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>

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
					<script>
				function limpiar_formulario(form){
					form.submit();}
			</script>
</head>


    

<body>
<style>
    #h2 {
        text-align: left;
        font-family: TrasandinaBook;
        font-size: 16px;
        color: #edf0f5;
        margin-left: 10px;
        margin-top: 5px;

    }
	</style>
    <section id="inicio">
	<div id="reporteEst" style="width: 97%; margin-left: 20px;">   			
        
		<style type="text/css">
		#filtrosprin{
			margin-top: 100; height: auto; width: 100%; background-color: #dbe5e9; border-top: 1px solid #53AAE0; border-bottom: 1px solid #53AAE0

		}
        </style>

        <h1>REPORTE MOVIMIENTOS IMPRESORAS/PERIFÉRICOS</h1>
		<div id="filtrosprin">




	<!--FORMULARIO DONDE SE UBICAN LOS FILTROS-->
		<form id="campos" method="POST" action="reportemovimientosperifericos.php">
		
        <div class="form-group row" style="margin-top: 15px; margin-right:10px;">

		<label id='lblForm' style='font-size:18px; margin-top: 2px; margin-bottom: 2px; width: 90px;'
                        class='col-form-label col-xl col-lg'>TIPO DE MOVIMIENTO:</label>
						
                        <select id='slcTipo' name='slcTipo' class='form-control col-xl col-lg' style='width:250px' required>
                          <option value='' selected disabled>-TODOS-</option>
                          <option value='1'>AREA</option>
                          <option value='2'>USUARIO</option>
                          <option value='3'>ESTADO</option>
                          </select>
		        
                          <!-- <label style='font-size: 18px;' id='lblForm'class='col-form-label col-xl col-lg'>PERIODO:</label> -->
                 <label style='font-size: 18px;' id='lblForm'class='col-form-label col-xl col-lg'>DESDE:</label>
                     <input class='col-xl col-lg form-control' style='margin-top: 10px;' type='date' name='fecha_desde' id='txtfechadesdeA' >
                 
                 <label style='font-size: 18px;' id='lblForm'class='col-form-label col-xl col-lg'>HASTA:</label>
                     <input class='col-xl col-lg form-control' style='margin-top: 10px;' type='date' name='fecha_hasta' id='txtfechahastaA' >
				</div>


                <div class="form-group row justify-content-end" style="margin-right:10px;">
				
					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit"  name="btn2" value="BUSCAR"></input>

					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px; margin-right: 10px;" type="button" onClick="limpiar_formulario(this.form)" name="btn1" value="LIMPIAR"></input>
				</div>
		</form>
		</div>
		<hr>
	<title>MOVIMIENTOS IMPRESORAS/PERIFÉRICOS</title><meta charset="utf-8">
		
		
        
		

        <?php
	#SE DETECTA SI SE ENVIO UN FORMULARIO
		if(isset($_POST['btn2'])){
			#SE TOMA TIPO Y PERIODO DE FECHAS POR METODO POST
			$mov=$_POST['slcTipo'];
            $fechadesde=$_POST['fecha_desde'];
            $fechahasta=$_POST['fecha_hasta'];

			$fecha = date("Y-m-d");
			#CONDICIONALES PARA ARMAR CABECERA
            echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
            if ($mov==1) {
                echo"<h4 class='indicadores' style='margin-bottom: 10px;'>TIPO MOVIMIENTO: AREA</h2>";
            }
            if ($mov==2) {
                echo"<h4 class='indicadores' style='margin-bottom: 10px;'>TIPO MOVIMIENTO: USUARIO</h2>";
            }
            if ($mov==3) {
                echo"<h4 class='indicadores' style='margin-bottom: 10px;'>TIPO MOVIMIENTO: ESTADO</h2>";
            }
			#CONDICIONALES PARA REALIZAR CONSULTAS SQL CON FILTROS SELECCIONADOS
			#PERIODO DE TIEMPO
            if ($fechadesde==""||$fechahasta=="") {
				if ($mov==1) {
				
				#AREA
				// $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m
				// inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
				// 		INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
				// 		INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP
				// 		where 
				// 		m.ID_AREA != ( select AVG(mv.ID_AREA) from movimientosperi mv
				// 			where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO) ORDER BY M.ID_MOVIMIENTO DESC");
				$consultarMovimientos=mysqli_query($datos_base, "WITH ws_area AS (
					SELECT
						w1.ID_WS,
						u.ID_USUARIO,
						u.NOMBRE,
						a.ID_AREA,
						a.AREA
					FROM wsusuario w1
					JOIN (
						SELECT ID_WS, MAX(ID_WSUSU) AS max_wsusu
						FROM wsusuario
						GROUP BY ID_WS
					) ult ON ult.ID_WS = w1.ID_WS AND ult.max_wsusu = w1.ID_WSUSU
					JOIN usuarios u ON u.ID_USUARIO = w1.ID_USUARIO
					JOIN area     a ON a.ID_AREA    = u.ID_AREA
					),
					ep_enriq AS (
					SELECT
						ep.ID_EQUIPO_PERIFERICO,
						ep.ID_PERI,
						ep.ID_WS,               -- puede ser 0 → sin equipo
						wa.ID_AREA,             -- NULL si no hay usuario/área para ese WS
						wa.AREA,
						wa.NOMBRE,
						p.TIPOP,
						e.ESTADO,
						ep.FECHA_ASIGNACION
					FROM equipo_periferico ep
					LEFT JOIN ws_area wa ON wa.ID_WS = ep.ID_WS  -- unimos directo al EP 
					INNER JOIN periferico p ON p.ID_PERI=ep.ID_PERI
					INNER JOIN estado_ws e ON ep.ID_ESTADOWS=e.ID_ESTADOWS
					where ep.ID_PERI!=0
					)
					SELECT *
					FROM (
					SELECT
						ee.ID_EQUIPO_PERIFERICO,
						ee.ID_PERI,
						ee.ID_WS, /* si ID_WS=0, forzar NULLs o S/A */
                          CASE WHEN ee.ID_WS = 0 THEN 'S/A' ELSE ee.ID_AREA  END AS ID_AREA,
                          CASE WHEN ee.ID_WS = 0 THEN 'S/A' ELSE ee.AREA     END AS AREA,
                          CASE WHEN ee.ID_WS = 0 THEN 'S/A' ELSE ee.NOMBRE   END AS NOMBRE,
						ee.TIPOP,
						ee.ESTADO,
						ee.FECHA_ASIGNACION,
						LAG(ee.ID_AREA) OVER (
							PARTITION BY ee.ID_PERI
							ORDER BY ee.ID_EQUIPO_PERIFERICO
						) AS PREV_ID_AREA
					FROM ep_enriq ee
					) x
					-- NOT <=> es comparación NULL-safe en MySQL
					WHERE NOT (x.PREV_ID_AREA <=> x.ID_AREA)
					AND x.PREV_ID_AREA IS NOT NULL            -- exige “fila anterior” existente
					ORDER BY x.ID_EQUIPO_PERIFERICO DESC;");
				}
				if ($mov==2) {
				// #USUARIO
				// $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m
				// inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
				// 		INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
				// 		INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP
				// 		where 
				// 		m.ID_USUARIO != ( select AVG(mv.ID_USUARIO) from movimientosperi mv
				// 			where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO) ORDER BY M.ID_MOVIMIENTO DESC");
				$consultarMovimientos=mysqli_query($datos_base, "WITH ws_user AS (
				SELECT
					w1.ID_WS,
					u.ID_USUARIO,
					u.NOMBRE,
					a.ID_AREA,
					a.AREA
				FROM wsusuario w1
				JOIN (
					SELECT ID_WS, MAX(ID_WSUSU) AS max_wsusu
					FROM wsusuario
					GROUP BY ID_WS
				) ult ON ult.ID_WS = w1.ID_WS AND ult.max_wsusu = w1.ID_WSUSU
				JOIN usuarios u ON u.ID_USUARIO = w1.ID_USUARIO
				JOIN area     a ON a.ID_AREA    = u.ID_AREA
				),
				ep_enriq AS (
				SELECT
					ep.ID_EQUIPO_PERIFERICO,
					ep.ID_PERI,
					ep.ID_WS,
					wa.ID_USUARIO,
					wa.NOMBRE,
					wa.ID_AREA,
					wa.AREA,
					p.TIPOP,
					e.ESTADO,
					ep.FECHA_ASIGNACION
				FROM equipo_periferico ep
				LEFT JOIN ws_user wa ON wa.ID_WS = ep.ID_WS
				INNER JOIN periferico p ON p.ID_PERI = ep.ID_PERI
				INNER JOIN estado_ws e ON ep.ID_ESTADOWS = e.ID_ESTADOWS
				WHERE ep.ID_PERI <> 0
				)
				SELECT *
				FROM (
				SELECT
					ee.ID_EQUIPO_PERIFERICO,
					ee.ID_PERI,
					ee.ID_WS,
					CASE WHEN ee.ID_WS = 0 THEN 'S/A' ELSE ee.ID_USUARIO END AS ID_USUARIO,
					CASE WHEN ee.ID_WS = 0 THEN 'S/A' ELSE ee.NOMBRE      END AS NOMBRE,
                    CASE WHEN ee.AREA = 0 THEN 'S/A' ELSE ee.AREA      END AS AREA,
					ee.TIPOP,
					ee.ESTADO,
					ee.FECHA_ASIGNACION,
					LAG(ee.ID_USUARIO) OVER (
						PARTITION BY ee.ID_PERI
						ORDER BY ee.ID_EQUIPO_PERIFERICO
					) AS PREV_ID_USUARIO
				FROM ep_enriq ee
				) x
				WHERE NOT (x.PREV_ID_USUARIO <=> x.ID_USUARIO)  -- cambio de usuario (NULL-safe)
				AND x.PREV_ID_USUARIO IS NOT NULL
				ORDER BY x.ID_EQUIPO_PERIFERICO DESC;");
				}
				if ($mov==3) {
					#ESTADO
				// $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m
				// inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
				// 		INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
				// 		INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP
				// 		where 
				// 		m.ID_ESTADOWS != ( select AVG(mv.ID_ESTADOWS) from movimientosperi mv
				// 			where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO) ORDER BY M.ID_MOVIMIENTO DESC");
				$consultarMovimientos=mysqli_query($datos_base, "WITH ws_user AS (
					SELECT
						w1.ID_WS,
						u.ID_USUARIO,
						u.NOMBRE,
						a.ID_AREA,
						a.AREA
					FROM wsusuario w1
					JOIN (
						SELECT ID_WS, MAX(ID_WSUSU) AS max_wsusu
						FROM wsusuario
						GROUP BY ID_WS
					) ult ON ult.ID_WS = w1.ID_WS AND ult.max_wsusu = w1.ID_WSUSU
					JOIN usuarios u ON u.ID_USUARIO = w1.ID_USUARIO
					JOIN area     a ON a.ID_AREA    = u.ID_AREA
					),
					ep_marked AS (
					SELECT
						ep.ID_EQUIPO_PERIFERICO,
						ep.ID_PERI,
						ep.ID_WS,
						ep.ID_ESTADOWS,
						e.ESTADO,
						p.TIPOP,
						ep.FECHA_ASIGNACION,
						MAX(ep.ID_EQUIPO_PERIFERICO) OVER (PARTITION BY ep.ID_PERI) AS LAST_EP
					FROM equipo_periferico ep
					JOIN periferico p ON p.ID_PERI = ep.ID_PERI
					JOIN estado_ws e  ON e.ID_ESTADOWS = ep.ID_ESTADOWS
					WHERE ep.ID_PERI <> 0
					),
					-- quitar transiciones intermedias: ID_WS=0 y estado=3 (STOCK) si NO es la última fila del periférico
					ep_clean AS (
					SELECT *
					FROM ep_marked
					WHERE NOT (ID_WS = 0 AND ID_ESTADOWS = 3 AND ID_EQUIPO_PERIFERICO < LAST_EP)
					),
					ep_enriq AS (
					SELECT
						ec.ID_EQUIPO_PERIFERICO,
						ec.ID_PERI,
						ec.ID_WS,
						ec.ID_ESTADOWS,
						ec.ESTADO,
						ec.TIPOP,
						ec.FECHA_ASIGNACION,
						-- si ID_WS=0, dejamos NULLs (sin asignar)
						CASE WHEN ec.ID_WS = 0 THEN 'S/A' ELSE wu.ID_USUARIO END AS ID_USUARIO,
						CASE WHEN ec.ID_WS = 0 THEN 'S/A' ELSE wu.NOMBRE     END AS NOMBRE,
						CASE WHEN ec.ID_WS = 0 THEN 'S/A' ELSE wu.ID_AREA     END AS ID_AREA,
						CASE WHEN ec.ID_WS = 0 THEN 'S/A' ELSE wu.AREA        END AS AREA
					FROM ep_clean ec
					LEFT JOIN ws_user wu
							ON wu.ID_WS = ec.ID_WS
					)
					-- si querés TODAS las filas limpias con usuario/área, hacé SELECT * FROM ep_enriq ORDER BY ID_EQUIPO_PERIFERICO;
					-- si querés SOLO los cambios (estado / usuario / área), usá el bloque de abajo:
					SELECT *
					FROM (
					SELECT
						ee.*,
						LAG(ee.ID_USUARIO)  OVER (PARTITION BY ee.ID_PERI ORDER BY ee.ID_EQUIPO_PERIFERICO) AS PREV_ID_USUARIO
					FROM ep_enriq ee
					) x
					WHERE
					-- dejá uno o varios según lo que quieras detectar
					NOT (x.PREV_ID_USUARIO <=> x.ID_USUARIO) -- cambio de usuario
					ORDER BY x.ID_EQUIPO_PERIFERICO DESC;");
				}
			}
			else {
				#NO SE SELECCIONO PERIODO

				echo"
                    <h4 class='indicadores' style='margin-bottom: 10px;'>PERIODO</h2>
				    <h4 class='indicadores' style='margin-bottom: 10px;'>DESDE: $fechadesde</h2>
				    <h4 class='indicadores' style='margin-bottom: 10px;'>HASTA: $fechahasta </h2>";

				if ($mov==1) {
					#AREA
				// $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m
				// inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
				// 		INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
				// 		INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP
				// 		where 
				// 		m.ID_AREA != ( select AVG(mv.ID_AREA) from movimientosperi mv
				// 			where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO)
				// 			and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'
				// 			 ORDER BY M.ID_MOVIMIENTO DESC");
				$consultarMovimientos=mysqli_query($datos_base, "WITH ws_area AS (
					SELECT
						w1.ID_WS,
						u.ID_USUARIO,
						u.NOMBRE,
						a.ID_AREA,
						a.AREA
					FROM wsusuario w1
					JOIN (
						SELECT ID_WS, MAX(ID_WSUSU) AS max_wsusu
						FROM wsusuario
						GROUP BY ID_WS
					) ult ON ult.ID_WS = w1.ID_WS AND ult.max_wsusu = w1.ID_WSUSU
					JOIN usuarios u ON u.ID_USUARIO = w1.ID_USUARIO
					JOIN area     a ON a.ID_AREA    = u.ID_AREA
					),
					ep_enriq AS (
					SELECT
						ep.ID_EQUIPO_PERIFERICO,
						ep.ID_PERI,
						ep.ID_WS,               -- puede ser 0 → sin equipo
						wa.ID_AREA,             -- NULL si no hay usuario/área para ese WS
						wa.AREA,
						wa.NOMBRE,
						p.TIPOP,
						e.ESTADO,
						ep.FECHA_ASIGNACION
					FROM equipo_periferico ep
					LEFT JOIN ws_area wa ON wa.ID_WS = ep.ID_WS  -- unimos directo al EP 
					INNER JOIN periferico p ON p.ID_PERI=ep.ID_PERI
					INNER JOIN estado_ws e ON ep.ID_ESTADOWS=e.ID_ESTADOWS
					where ep.ID_PERI!=0
					)
					SELECT *
					FROM (
					SELECT
						ee.ID_EQUIPO_PERIFERICO,
						ee.ID_PERI,
						ee.ID_WS, /* si ID_WS=0, forzar NULLs o S/A */
                          CASE WHEN ee.ID_WS = 0 THEN 'S/A' ELSE ee.ID_AREA  END AS ID_AREA,
                          CASE WHEN ee.ID_WS = 0 THEN 'S/A' ELSE ee.AREA     END AS AREA,
                          CASE WHEN ee.ID_WS = 0 THEN 'S/A' ELSE ee.NOMBRE   END AS NOMBRE,
						ee.TIPOP,
						ee.ESTADO,
						ee.FECHA_ASIGNACION,
						LAG(ee.ID_AREA) OVER (
							PARTITION BY ee.ID_PERI
							ORDER BY ee.ID_EQUIPO_PERIFERICO
						) AS PREV_ID_AREA
					FROM ep_enriq ee
					) x
					-- NOT <=> es comparación NULL-safe en MySQL
					WHERE NOT (x.PREV_ID_AREA <=> x.ID_AREA)
					AND x.PREV_ID_AREA IS NOT NULL            -- exige “fila anterior” existente
                    AND x.FECHA_ASIGNACION BETWEEN '$fechadesde' AND '$fechahasta'
					ORDER BY x.ID_EQUIPO_PERIFERICO DESC");
				}
				if ($mov==2) {
					#USUARIO
				// $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m
				// inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
				// 		INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
				// 		INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP
				// 		where 
				// 		m.ID_USUARIO != ( select AVG(mv.ID_USUARIO) from movimientosperi mv
				// 			where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO)
				// 			and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'
				// 			 ORDER BY M.ID_MOVIMIENTO DESC");
				$consultarMovimientos=mysqli_query($datos_base, "WITH ws_user AS (
				SELECT
					w1.ID_WS,
					u.ID_USUARIO,
					u.NOMBRE,
					a.ID_AREA,
					a.AREA
				FROM wsusuario w1
				JOIN (
					SELECT ID_WS, MAX(ID_WSUSU) AS max_wsusu
					FROM wsusuario
					GROUP BY ID_WS
				) ult ON ult.ID_WS = w1.ID_WS AND ult.max_wsusu = w1.ID_WSUSU
				JOIN usuarios u ON u.ID_USUARIO = w1.ID_USUARIO
				JOIN area     a ON a.ID_AREA    = u.ID_AREA
				),
				ep_enriq AS (
				SELECT
					ep.ID_EQUIPO_PERIFERICO,
					ep.ID_PERI,
					ep.ID_WS,
					wa.ID_USUARIO,
					wa.NOMBRE,
					wa.ID_AREA,
					wa.AREA,
					p.TIPOP,
					e.ESTADO,
					ep.FECHA_ASIGNACION
				FROM equipo_periferico ep
				LEFT JOIN ws_user wa ON wa.ID_WS = ep.ID_WS
				INNER JOIN periferico p ON p.ID_PERI = ep.ID_PERI
				INNER JOIN estado_ws e ON ep.ID_ESTADOWS = e.ID_ESTADOWS
				WHERE ep.ID_PERI <> 0
				)
				SELECT *
				FROM (
				SELECT
					ee.ID_EQUIPO_PERIFERICO,
					ee.ID_PERI,
					ee.ID_WS,
					CASE WHEN ee.ID_WS = 0 THEN 'S/A' ELSE ee.ID_USUARIO END AS ID_USUARIO,
					CASE WHEN ee.ID_WS = 0 THEN 'S/A' ELSE ee.NOMBRE      END AS NOMBRE,
                    CASE WHEN ee.AREA = 0 THEN 'S/A' ELSE ee.AREA      END AS AREA,
					ee.TIPOP,
					ee.ESTADO,
					ee.FECHA_ASIGNACION,
					LAG(ee.ID_USUARIO) OVER (
						PARTITION BY ee.ID_PERI
						ORDER BY ee.ID_EQUIPO_PERIFERICO
					) AS PREV_ID_USUARIO
				FROM ep_enriq ee
				) x
				WHERE NOT (x.PREV_ID_USUARIO <=> x.ID_USUARIO)  -- cambio de usuario (NULL-safe)
				AND x.PREV_ID_USUARIO IS NOT NULL
				AND x.FECHA_ASIGNACION BETWEEN '$fechadesde' AND '$fechahasta'
				ORDER BY x.ID_EQUIPO_PERIFERICO DESC;");
				}
				if ($mov==3) {
					#ESTADO
				// $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m
				// inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
				// 		INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
				// 		INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP
				// 		where 
				// 		m.ID_ESTADOWS != ( select AVG(mv.ID_ESTADOWS) from movimientosperi mv
				// 			where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO)
				// 			and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'
				// 			 ORDER BY M.ID_MOVIMIENTO DESC");
				$consultarMovimientos=mysqli_query($datos_base, "WITH ws_user AS (
					SELECT
						w1.ID_WS,
						u.ID_USUARIO,
						u.NOMBRE,
						a.ID_AREA,
						a.AREA
					FROM wsusuario w1
					JOIN (
						SELECT ID_WS, MAX(ID_WSUSU) AS max_wsusu
						FROM wsusuario
						GROUP BY ID_WS
					) ult ON ult.ID_WS = w1.ID_WS AND ult.max_wsusu = w1.ID_WSUSU
					JOIN usuarios u ON u.ID_USUARIO = w1.ID_USUARIO
					JOIN area     a ON a.ID_AREA    = u.ID_AREA
					),
					ep_marked AS (
					SELECT
						ep.ID_EQUIPO_PERIFERICO,
						ep.ID_PERI,
						ep.ID_WS,
						ep.ID_ESTADOWS,
						e.ESTADO,
						p.TIPOP,
						ep.FECHA_ASIGNACION,
						MAX(ep.ID_EQUIPO_PERIFERICO) OVER (PARTITION BY ep.ID_PERI) AS LAST_EP
					FROM equipo_periferico ep
					JOIN periferico p ON p.ID_PERI = ep.ID_PERI
					JOIN estado_ws e  ON e.ID_ESTADOWS = ep.ID_ESTADOWS
					WHERE ep.ID_PERI <> 0
					),
					-- quitar transiciones intermedias: ID_WS=0 y estado=3 (STOCK) si NO es la última fila del periférico
					ep_clean AS (
					SELECT *
					FROM ep_marked
					WHERE NOT (ID_WS = 0 AND ID_ESTADOWS = 3 AND ID_EQUIPO_PERIFERICO < LAST_EP)
					),
					ep_enriq AS (
					SELECT
						ec.ID_EQUIPO_PERIFERICO,
						ec.ID_PERI,
						ec.ID_WS,
						ec.ID_ESTADOWS,
						ec.ESTADO,
						ec.TIPOP,
						ec.FECHA_ASIGNACION,
						-- si ID_WS=0, dejamos NULLs (sin asignar)
						CASE WHEN ec.ID_WS = 0 THEN 'S/A' ELSE wu.ID_USUARIO END AS ID_USUARIO,
						CASE WHEN ec.ID_WS = 0 THEN 'S/A' ELSE wu.NOMBRE     END AS NOMBRE,
						CASE WHEN ec.ID_WS = 0 THEN 'S/A' ELSE wu.ID_AREA     END AS ID_AREA,
						CASE WHEN ec.ID_WS = 0 THEN 'S/A' ELSE wu.AREA        END AS AREA
					FROM ep_clean ec
					LEFT JOIN ws_user wu
							ON wu.ID_WS = ec.ID_WS
					)
					-- si querés TODAS las filas limpias con usuario/área, hacé SELECT * FROM ep_enriq ORDER BY ID_EQUIPO_PERIFERICO;
					-- si querés SOLO los cambios (estado / usuario / área), usá el bloque de abajo:
					SELECT *
					FROM (
					SELECT
						ee.*,
						LAG(ee.ID_USUARIO)  OVER (PARTITION BY ee.ID_PERI ORDER BY ee.ID_EQUIPO_PERIFERICO) AS PREV_ID_USUARIO
					FROM ep_enriq ee
					) x
					WHERE
					-- dejá uno o varios según lo que quieras detectar
					NOT (x.PREV_ID_USUARIO <=> x.ID_USUARIO) -- cambio de usuario
                    AND x.FECHA_ASIGNACION BETWEEN '$fechadesde' AND '$fechahasta'
					ORDER BY x.ID_EQUIPO_PERIFERICO DESC;");
				}
			}
		}
		#NO HAY FILTROS SELECCIONADOS
		else{
        $fecha = date("Y-m-d");
		echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
        
        // $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m 
        // inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
        // INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
        // INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP 
		// where m.ID_AREA != ( select AVG(mv.ID_AREA) from movimientosperi mv
		// 					where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO)
		// or m.ID_USUARIO != ( select AVG(mv.ID_USUARIO) from movimientosperi mv
		// 					where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO)
		// or m.ID_ESTADOWS != ( select AVG(mv.ID_ESTADOWS) from movimientosperi mv
		// 					where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO)
		// ORDER BY M.ID_MOVIMIENTO DESC");
        $consultarMovimientos=mysqli_query($datos_base, "WITH ws_user AS (
			/* Último usuario/área por equipo (WS) */
			SELECT
				w1.ID_WS,
				u.ID_USUARIO,
				u.NOMBRE,
				a.ID_AREA,
				a.AREA
			FROM wsusuario w1
			JOIN (
				SELECT ID_WS, MAX(ID_WSUSU) AS max_wsusu
				FROM wsusuario
				GROUP BY ID_WS
			) ult ON ult.ID_WS = w1.ID_WS AND ult.max_wsusu = w1.ID_WSUSU
			JOIN usuarios u ON u.ID_USUARIO = w1.ID_USUARIO
			JOIN area     a ON a.ID_AREA    = u.ID_AREA
			),
			ep_marked AS (
			/* Marcamos última fila por periférico */
			SELECT
				ep.ID_EQUIPO_PERIFERICO,
				ep.ID_PERI,
				ep.ID_WS,
				ep.ID_ESTADOWS,
				e.ESTADO,
				p.TIPOP,
				ep.FECHA_ASIGNACION,
				MAX(ep.ID_EQUIPO_PERIFERICO) OVER (PARTITION BY ep.ID_PERI) AS LAST_EP
			FROM equipo_periferico ep
			JOIN periferico p ON p.ID_PERI = ep.ID_PERI
			JOIN estado_ws  e ON e.ID_ESTADOWS = ep.ID_ESTADOWS
			WHERE ep.ID_PERI <> 0
			),
			/* Quitamos transiciones intermedias: WS=0 & estado=3 si NO es la última fila del periférico */
			ep_clean AS (
			SELECT *
			FROM ep_marked
			WHERE NOT (ID_WS = 0 AND ID_ESTADOWS = 3 AND ID_EQUIPO_PERIFERICO < LAST_EP)
			),
			/* Enriquecemos con usuario/área actuales del WS (NULL si WS=0) */
			ep_enriq AS (
			SELECT
				ec.ID_EQUIPO_PERIFERICO,
				ec.ID_PERI,
				ec.ID_WS,
				ec.ID_ESTADOWS,
				ec.ESTADO AS ESTADO_ACTUAL,
				ec.TIPOP,
				ec.FECHA_ASIGNACION,
				CASE WHEN ec.ID_WS = 0 THEN 'S/A' ELSE wu.ID_USUARIO END AS ID_USUARIO,
				CASE WHEN ec.ID_WS = 0 THEN 'S/A' ELSE wu.NOMBRE     END AS NOMBRE,
				CASE WHEN ec.ID_WS = 0 THEN 'S/A' ELSE wu.ID_AREA     END AS ID_AREA,
				CASE WHEN ec.ID_WS = 0 THEN 'S/A' ELSE wu.AREA        END AS AREA
			FROM ep_clean ec
			LEFT JOIN ws_user wu ON wu.ID_WS = ec.ID_WS
			)
			SELECT
				x.ID_EQUIPO_PERIFERICO,
				x.ID_PERI,
				x.ID_WS,
				x.TIPOP,
				x.FECHA_ASIGNACION,

				/* Estado (nuevo y anterior) */
				x.ID_ESTADOWS         AS ESTADO_NUEVO_ID,
				x.ESTADO_ACTUAL       AS ESTADO,
				x.PREV_ID_ESTADO      AS ESTADO_ANTERIOR_ID,
				x.PREV_ESTADO         AS ESTADO_ANTERIOR,

				/* Usuario (nuevo y anterior) */
				x.ID_USUARIO          AS USUARIO_NUEVO_ID,
				x.NOMBRE              AS NOMBRE,
				x.PREV_ID_USUARIO     AS USUARIO_ANTERIOR_ID,
				x.PREV_NOMBRE         AS USUARIO_ANTERIOR,

				/* Área (nueva y anterior) */
				x.ID_AREA             AS AREA_NUEVA_ID,
				x.AREA                AS AREA,
				x.PREV_ID_AREA        AS AREA_ANTERIOR_ID,
				x.PREV_AREA           AS AREA_ANTERIOR

			FROM (
			SELECT
				ee.*,
				LAG(ee.ID_ESTADOWS)  OVER (PARTITION BY ee.ID_PERI ORDER BY ee.ID_EQUIPO_PERIFERICO) AS PREV_ID_ESTADO,
				LAG(ee.ESTADO_ACTUAL)OVER (PARTITION BY ee.ID_PERI ORDER BY ee.ID_EQUIPO_PERIFERICO) AS PREV_ESTADO,

				LAG(ee.ID_USUARIO)   OVER (PARTITION BY ee.ID_PERI ORDER BY ee.ID_EQUIPO_PERIFERICO) AS PREV_ID_USUARIO,
				LAG(ee.NOMBRE)       OVER (PARTITION BY ee.ID_PERI ORDER BY ee.ID_EQUIPO_PERIFERICO) AS PREV_NOMBRE,

				LAG(ee.ID_AREA)      OVER (PARTITION BY ee.ID_PERI ORDER BY ee.ID_EQUIPO_PERIFERICO) AS PREV_ID_AREA,
				LAG(ee.AREA)         OVER (PARTITION BY ee.ID_PERI ORDER BY ee.ID_EQUIPO_PERIFERICO) AS PREV_AREA
			FROM ep_enriq ee
			) x
			/* Mostrar filas donde cambió al menos uno: estado, usuario o área (comparación NULL-safe) */
			WHERE (NOT (x.PREV_ID_ESTADO  <=> x.ID_ESTADOWS))
			OR (NOT (x.PREV_ID_USUARIO <=> x.ID_USUARIO))
			OR (NOT (x.PREV_ID_AREA    <=> x.ID_AREA))
			ORDER BY x.ID_EQUIPO_PERIFERICO DESC;
			;
			");}?>
	<!--SE ARMA CABECERA DE TABLA-->
        <?php echo "<table width=100%>
        <thead>
            <tr>
                <!--<th><p>N° MOVIMIENTO</p></th>-->
                <th><p>FECHA</p></th>
                <th><p>ID PERIFERICO</p></th>
                <th><p>TIPO</p></th>
                <!--<th><p>SUBTIPO</p></th>-->
                <th><p>ÁREA</p></th>
                <th><p>USUARIO</p></th>
                <th><p>ESTADO</p></th>
            </tr>
        </thead>
        ";
        $contador=0;
        while($listar = mysqli_fetch_array($consultarMovimientos))
        #SE EXTRAEN TOODOS LOS RESULTADOS DE LA VARIABLE DE LA CONSULTA
				
	    {
		echo
		" 
			<tr>
				<!--<td><h4 style='font-size:16px;'>".$listar['ID_EQUIPO_PERIFERICO']."</h4></td>-->
				<td><h4 style='font-size:16px;'>".$listar['FECHA_ASIGNACION']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['ID_PERI']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['TIPOP']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
                <td><h4 style='font-size:16px;'>".$listar['ESTADO']."</h4></td>
                											
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
						echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>CANTIDAD DE MOVIMIENTOS : $contador</h4>
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



