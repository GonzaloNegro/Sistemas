<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$consulta=mysqli_query($datos_base, "SELECT * FROM ticket ORDER BY FECHA_INICIO DESC, ID_TICKET DESC");
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ESTADISTICAS</title><meta charset="utf-8">
    <link rel="icon" href="../imagenes/logoObrasPúblicas.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="../js/./chart.min.js"></script>
    <link href="../estilos/estadisticas.css" rel="stylesheet" type="text/css" />
    <style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<header class="p-3 mb-3 border-bottom altura">
    <div class="container-fluid">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none"><div id="foto"></div>
          <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use> </svg>-->
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="../carga/cargadeincidentes.php" class="nav-link px-2 link-secondary link destacado" >NUEVO INCIDENTE</a>
 				<ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
					<li><a class="dropdown-item" href="../carga/cargarapidaporusuario.php">CARGA RÁPIDA POR USUARIO</a></li>
     				<li><hr class="dropdown-divider"></li>
                	<li><a class="dropdown-item" href="../carga/cargarapidaportipificacion.php">CARGA RÁPIDA POR TIPIFICACIÓN</a></li>
                </ul>
			</li>
            <li><a href="../consulta/consulta.php" class="nav-link px-2 link-dark link" style="border-left: 5px solid #53AAE0;">CONSULTA</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="../consulta/consulta.php">CONSULTA DE INCIDENTES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/consultausuario.php">CONSULTA DE USUARIOS</a></li>
					<li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/consultaaltas.php">CONSULTA PARA ALTAS</a></li>
                </ul>
            </li>
            <li><a href="../consulta/inventario.php" class="nav-link px-2 link-dark link">INVENTARIO</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="../consulta/inventario.php">EQUIPOS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/impresoras.php">IMPRESORAS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/monitores.php">MONITORES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/otrosp.php">OTROS PERIFÉRICOS</a></li>
                </ul>
            </li>
            <li><a href="../abm/abm.php" class="nav-link px-2 link-dark link">ABM</a></li>
            <li><a href="../reportes/tiporeporte.php" class="nav-link px-2 link-dark link">REPORTES</a></li>
            <?php if($row['ID_PERFIL'] == 1 OR $row['ID_PERFIL'] == 2){
                        echo'
						<li><a href="estadisticas.php" class="nav-link px-2 link-dark link" style="border-left: 5px solid #53AAE0;">ESTADISTICAS</a></li>
                    ';
					} ?>
			<li><a href="../particular/stock.php" class="nav-link px-2 link-dark link">STOCK</a></li>
			<li><a href="../calen/calen.php" class="nav-link px-2 link-dark link"><i class="bi bi-calendar3"></i></a></li>
			<li class="ubicacion link"><a href="../particular/bienvenida.php"><i class="bi bi-info-circle"></i></a></li>
			<li><a href="../Manual.pdf" class="ubicacion link"><i class="bi bi-journal"></i></a></li>
        </ul>
        <div class="notif" id="notif">
			<i class="bi bi-bell" id="cant">
			<?php
			$cant="SELECT count(*) as cantidad FROM ticket WHERE ID_ESTADO = 4;";
			$result = $datos_base->query($cant);
			$rowa = $result->fetch_assoc();
			$cantidad = $rowa['cantidad'];

			/* $fechaActual = date('m'); */
			if($cantidad > 0){
				echo $cantidad;
			}
			?></i>
			<script type="text/javascript">
				var valor = "<?php echo $cantidad; ?>";
				console.log(valor);
			</script>
		</div>
        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false"><h5><i class="bi bi-person rounded-circle"></i><?php echo utf8_decode($row['RESOLUTOR']);?></h5></a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
          <?php if($row['ID_RESOLUTOR'] == 6)
		  { echo '
		  	<li><a class="dropdown-item" href="../particular/agregados.php">CAMBIOS AGREGADOS</a></li>
            <li><hr class="dropdown-divider"></li>';}?>
            <li><a class="dropdown-item" href="../particular/contraseña.php">CAMBIAR CONTRASEÑA</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../particular/salir.php">CERRAR SESIÓN</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <section class="contenedor">
    <div class="grafico" style="width: 600px; height: 750px;">
            <h1><u>INCIDENTES POR RESOLUTOR</u></h1>
            <canvas id="MiGrafica" ></canvas>
    </div>
    <div class="grafico2" style="width: 600px; height: 750px;">
            <h1><u>INCIDENTES POR USUARIO</u></h1>
            <canvas id="MiGrafica4" ></canvas>
    </div>
  </section>

  <section class="contenedor1">
    <div class="grafico1" style="width: 600px; height: 750px;">
            <h1><u>INCIDENTES POR TIPIFICACIÓN</u></h1>
            <canvas id="MiGrafica2" ></canvas>
    </div>
    <div class="informacion1" style="width: 600px; height: 750px;">
        <h1><u>INCIDENTES POR ÁREA</u></h1>
        <canvas id="MiGrafica3" ></canvas>
    </div>
  </section>

  <section class="contenedor2">
    <div class="informacion" style="width: 600px; height: 750px;">
        <h1><u>INCIDENTES POR ESTADO</u></h1>
        <canvas id="MiGrafica1" ></canvas>
    </div>
  </section>


  


    <?php 
    include('../particular/conexion.php');

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 0, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res = $row6['RESOLUTOR'];
    $tot = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 1, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res1 = $row6['RESOLUTOR'];
    $tot1 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 2, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res2 = $row6['RESOLUTOR'];
    $tot2 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 3, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res3 = $row6['RESOLUTOR'];
    $tot3 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 4, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res4 = $row6['RESOLUTOR'];
    $tot4 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 5, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res5 = $row6['RESOLUTOR'];
    $tot5 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 6, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res6 = $row6['RESOLUTOR'];
    $tot6 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 7, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res7 = $row6['RESOLUTOR'];
    $tot7 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 8, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res8 = $row6['RESOLUTOR'];
    $tot8 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 9, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res9 = $row6['RESOLUTOR'];
    $tot9 = $row6['RecuentoFilas'];
    
    $sql6 = "SELECT count(*) as TOTAL FROM ticket";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $total = $row6['TOTAL'];

    $prom = round(($tot * 100)/$total,2);
    $prom1 = round(($tot1 * 100)/$total,2);
    $prom2 = round(($tot2 * 100)/$total,2);
    $prom3 = round(($tot3 * 100)/$total,2);
    $prom4 = round(($tot4 * 100)/$total,2);
    $prom5 = round(($tot5 * 100)/$total,2);
    $prom6 = round(($tot6 * 100)/$total,2);
    $prom7 = round(($tot7 * 100)/$total,2);
    $prom8 = round(($tot8 * 100)/$total,2);
    $prom9 = round(($tot9 * 100)/$total,2);







/* ESTADOS */

    $sql6 = "SELECT e.ESTADO, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO GROUP BY e.ESTADO HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 0, 1;";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est1 = $row6['ESTADO'];
    $etot1 = $row6['RecuentoFilas'];

    $sql6 = "SELECT e.ESTADO, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO GROUP BY e.ESTADO HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 1, 1;";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est2 = $row6['ESTADO'];
    $etot2 = $row6['RecuentoFilas'];

    $sql6 = "SELECT e.ESTADO, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO GROUP BY e.ESTADO HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 2, 1;";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est3 = $row6['ESTADO'];
    $etot3 = $row6['RecuentoFilas'];

    $sql6 = "SELECT e.ESTADO, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO GROUP BY e.ESTADO HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 3, 1;";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est4 = $row6['ESTADO'];
    $etot4 = $row6['RecuentoFilas'];

    $sql6 = "SELECT e.ESTADO, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO GROUP BY e.ESTADO HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 4, 1;";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est5 = $row6['ESTADO'];
    $etot5 = $row6['RecuentoFilas'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $etotal = $row6['TOTAL'];

    $eprom1 = round(($etot1 * 100)/$etotal,2);
    $eprom2 = round(($etot2 * 100)/$etotal,2);
    $eprom3 = round(($etot3 * 100)/$etotal,2);
    $eprom4 = round(($etot4 * 100)/$etotal,2);
    $eprom5 = round(($etot5 * 100)/$etotal,2);









/* TIPIFICACIONES */

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 0, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip1 = $row6['TIPIFICACION'];
    $ttip1 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 1, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip2 = $row6['TIPIFICACION'];
    $ttip2 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 2, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip3 = $row6['TIPIFICACION'];
    $ttip3 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 3, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip4 = $row6['TIPIFICACION'];
    $ttip4 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 4, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip5 = $row6['TIPIFICACION'];
    $ttip5 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 5, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip6 = $row6['TIPIFICACION'];
    $ttip6 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 6, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip7 = $row6['TIPIFICACION'];
    $ttip7 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 7, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip8 = $row6['TIPIFICACION'];
    $ttip8 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 8, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip9 = $row6['TIPIFICACION'];
    $ttip9 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 9, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip10 = $row6['TIPIFICACION'];
    $ttip10 = $row6['RecuentoFilas'];


    $sql6 = "SELECT count(*) as TOTAL FROM ticket";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $ttotal = $row6['TOTAL'];

    $tprom1 = round(($ttip1 * 100)/$ttotal,2);
    $tprom2 = round(($ttip2 * 100)/$ttotal,2);
    $tprom3 = round(($ttip3 * 100)/$ttotal,2);
    $tprom4 = round(($ttip4 * 100)/$ttotal,2);
    $tprom5 = round(($ttip5 * 100)/$ttotal,2);
    $tprom6 = round(($ttip6 * 100)/$ttotal,2);
    $tprom7 = round(($ttip7 * 100)/$ttotal,2);
    $tprom8 = round(($ttip8 * 100)/$ttotal,2);
    $tprom9 = round(($ttip9 * 100)/$ttotal,2);
    $tprom10 = round(($ttip10 * 100)/$ttotal,2);









/* AREAS*/

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 0, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are1 = $row6['AREA'];
    $tare1 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 1, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are2 = $row6['AREA'];
    $tare2 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 2, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are3 = $row6['AREA'];
    $tare3 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 3, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are4 = $row6['AREA'];
    $tare4 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 4, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are5 = $row6['AREA'];
    $tare5 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 5, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are6 = $row6['AREA'];
    $tare6 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 6, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are7 = $row6['AREA'];
    $tare7 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 7, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are8 = $row6['AREA'];
    $tare8 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 8, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are9 = $row6['AREA'];
    $tare9 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 9, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are10 = $row6['AREA'];
    $tare10 = $row6['RecuentoFilas'];


    $sql6 = "SELECT count(*) as TOTAL FROM ticket";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $atotal = $row6['TOTAL'];

    $aprom1 = round(($tare1 * 100)/$atotal,2);
    $aprom2 = round(($tare2 * 100)/$atotal,2);
    $aprom3 = round(($tare3 * 100)/$atotal,2);
    $aprom4 = round(($tare4 * 100)/$atotal,2);
    $aprom5 = round(($tare5 * 100)/$atotal,2);
    $aprom6 = round(($tare6 * 100)/$atotal,2);
    $aprom7 = round(($tare7 * 100)/$atotal,2);
    $aprom8 = round(($tare8 * 100)/$atotal,2);
    $aprom9 = round(($tare9 * 100)/$atotal,2);
    $aprom10 = round(($tare10 * 100)/$atotal,2);





/* USUARIOS */

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 0, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu1 = $row6['NOMBRE'];
    $tusu1 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 1, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu2 = $row6['NOMBRE'];
    $tusu2 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 2, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu3 = $row6['NOMBRE'];
    $tusu3 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 3, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu4 = $row6['NOMBRE'];
    $tusu4 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 4, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu5 = $row6['NOMBRE'];
    $tusu5 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 5, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu6 = $row6['NOMBRE'];
    $tusu6 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 6, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu7 = $row6['NOMBRE'];
    $tusu7 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 7, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu8 = $row6['NOMBRE'];
    $tusu8 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 8, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu9 = $row6['NOMBRE'];
    $tusu9 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 9, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu10 = $row6['NOMBRE'];
    $tusu10 = $row6['RecuentoFilas'];


    $sql6 = "SELECT count(*) as TOTAL FROM ticket";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $utotal = $row6['TOTAL'];

    $uprom1 = round(($tusu1 * 100)/$utotal,2);
    $uprom2 = round(($tusu2 * 100)/$utotal,2);
    $uprom3 = round(($tusu3 * 100)/$utotal,2);
    $uprom4 = round(($tusu4 * 100)/$utotal,2);
    $uprom5 = round(($tusu5 * 100)/$utotal,2);
    $uprom6 = round(($tusu6 * 100)/$utotal,2);
    $uprom7 = round(($tusu7 * 100)/$utotal,2);
    $uprom8 = round(($tusu8 * 100)/$utotal,2);
    $uprom9 = round(($tusu9 * 100)/$utotal,2);
    $uprom10 = round(($tusu10 * 100)/$utotal,2);

    ?>
    <footer>
		<div class="footer">
			<div class="container-fluid">
				<div class="row">
					<img src="imagenes/logoGobierno.png" class="img-fluid">
				</div>
			</div>
		</div>
	</footer>
</body>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
  		AOS.init();
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
    let miCanvas=document.getElementById("MiGrafica").getContext("2d");

    var chart = new Chart(miCanvas,{
        type: "doughnut",
        data:{
            labels:[
            "<?php echo "1- $res: CANTIDAD: $tot   ||   PORCENTAJE: $prom%";?>", 
            "<?php echo "2- $res1: CANTIDAD: $tot1   ||   PORCENTAJE: $prom1%";?>", 
            "<?php echo "3- $res2: CANTIDAD: $tot2   ||   PORCENTAJE: $prom2%";?>", 
            "<?php echo "4- $res3: CANTIDAD: $tot3   ||   PORCENTAJE: $prom3%";?>",
            "<?php echo "5- $res4: CANTIDAD: $tot4   ||   PORCENTAJE: $prom4%";?>", 
            "<?php echo "6- $res5: CANTIDAD: $tot5   ||   PORCENTAJE: $prom5%";?>", 
            "<?php echo "7- $res6: CANTIDAD: $tot6   ||   PORCENTAJE: $prom6%";?>",
            "<?php echo "8- $res7: CANTIDAD: $tot7   ||   PORCENTAJE: $prom7%";?>", 
            "<?php echo "9- $res8: CANTIDAD: $tot8   ||   PORCENTAJE: $prom8%";?>",
            "<?php echo "10- $res9: CANTIDAD: $tot9   ||   PORCENTAJE: $prom9%";?>",],

            datasets:[{
                label: "INCIDENTES POR RESOLUTOR",
                backgroundColor: [
                    "rgb(0, 197, 255)", 
                    "rgb(255, 0, 0)",
                    "rgb(103, 1, 1)",
                    "rgb(255, 0, 189)", 
                    "rgb(96, 2, 121)",
                    "rgb(0, 224, 255)",
                    "rgb(0, 97, 111)", 
                    "rgb(0, 255, 42)",
                    "rgb(0, 121, 20)",
                    "rgb(248, 255, 21)",],
                borderColor: "black",
                data:[
                    <?php echo $tot;?>, 
                    <?php echo $tot1 ;?>, 
                    <?php echo $tot2 ;?>, 
                    <?php echo $tot3 ;?>,
                    <?php echo $tot4 ;?>, 
                    <?php echo $tot5 ;?>,
                    <?php echo $tot6 ;?>, 
                    <?php echo $tot7 ;?>,
                    <?php echo $tot8 ;?>, 
                    <?php echo $tot9 ;?> ]
            }]
        }
    })
    </script>

<script>
    let miCanvas4=document.getElementById("MiGrafica4").getContext("2d");

    var chart = new Chart(miCanvas4,{
        type: "doughnut",
        data:{
            labels:[
            "<?php echo "1- $usu1: CANTIDAD: $tusu1   ||   PORCENTAJE: $uprom1%";?>", 
            "<?php echo "2- $usu2: CANTIDAD: $tusu2   ||   PORCENTAJE: $uprom2%";?>", 
            "<?php echo "3- $usu3: CANTIDAD: $tusu3   ||   PORCENTAJE: $uprom3%";?>", 
            "<?php echo "4- $usu4: CANTIDAD: $tusu4   ||   PORCENTAJE: $uprom4%";?>",
            "<?php echo "5- $usu5: CANTIDAD: $tusu5   ||   PORCENTAJE: $uprom5%";?>", 
            "<?php echo "6- $usu6: CANTIDAD: $tusu6   ||   PORCENTAJE: $uprom6%";?>", 
            "<?php echo "7- $usu7: CANTIDAD: $tusu7   ||   PORCENTAJE: $uprom7%";?>", 
            "<?php echo "8- $usu8: CANTIDAD: $tusu8   ||   PORCENTAJE: $uprom8%";?>",
            "<?php echo "9- $usu9: CANTIDAD: $tusu9   ||   PORCENTAJE: $uprom9%";?>",
            "<?php echo "10- $usu10: CANTIDAD: $tusu10   ||   PORCENTAJE: $uprom10%";?>",],

            datasets:[{
                label: "INCIDENTES POR ESTADO",
                backgroundColor: [
                    "rgb(0,197,255)", 
                    "rgb(255, 0, 0)",
                    "rgb(103, 1, 1)",
                    "rgb(255, 0, 189)", 
                    "rgb(96, 2, 121)",
                    "rgb(0, 224, 255)",
                    "rgb(0, 97, 111)", 
                    "rgb(0, 255, 42)",
                    "rgb(0, 121, 20)",
                    "rgb(232, 255, 0)"],
                borderColor: "black",
                data:[
                    <?php echo $tusu1;?>, 
                    <?php echo $tusu2 ;?>, 
                    <?php echo $tusu3 ;?>, 
                    <?php echo $tusu4 ;?>,
                    <?php echo $tusu5;?>, 
                    <?php echo $tusu6 ;?>, 
                    <?php echo $tusu7 ;?>, 
                    <?php echo $tusu8 ;?>,
                    <?php echo $tusu9 ;?>,
                    <?php echo $tusu10 ;?>]
            }]
        }
    })
    </script>

<script>
    let miCanvas2=document.getElementById("MiGrafica2").getContext("2d");

    var chart = new Chart(miCanvas2,{
        type: "doughnut",
        data:{
            labels:[
            "<?php echo "1- $tip1: CANTIDAD: $ttip1   ||   PORCENTAJE: $tprom1%";?>", 
            "<?php echo "2- $tip2: CANTIDAD: $ttip2   ||   PORCENTAJE: $tprom2%";?>", 
            "<?php echo "3- $tip3: CANTIDAD: $ttip3   ||   PORCENTAJE: $tprom3%";?>", 
            "<?php echo "4- $tip4: CANTIDAD: $ttip4   ||   PORCENTAJE: $tprom4%";?>",
            "<?php echo "5- $tip5: CANTIDAD: $ttip5   ||   PORCENTAJE: $tprom5%";?>", 
            "<?php echo "6- $tip6: CANTIDAD: $ttip6   ||   PORCENTAJE: $tprom6%";?>", 
            "<?php echo "7- $tip7: CANTIDAD: $ttip7   ||   PORCENTAJE: $tprom7%";?>", 
            "<?php echo "8- $tip8: CANTIDAD: $ttip8   ||   PORCENTAJE: $tprom8%";?>",
            "<?php echo "9- $tip9: CANTIDAD: $ttip9   ||   PORCENTAJE: $tprom9%";?>",
            "<?php echo "10- $tip10: CANTIDAD: $ttip10   ||   PORCENTAJE: $tprom10%";?>",],

            datasets:[{
                label: "INCIDENTES POR TIPIFICACIÓN",
                backgroundColor: [
                    "rgb(0,197,255)", 
                    "rgb(255, 0, 0)",
                    "rgb(103, 1, 1)",
                    "rgb(255, 0, 189)", 
                    "rgb(96, 2, 121)",
                    "rgb(0, 224, 255)",
                    "rgb(0, 97, 111)", 
                    "rgb(0, 255, 42)",
                    "rgb(0, 121, 20)",
                    "rgb(232, 255, 0)"],
                borderColor: "black",
                data:[
                    <?php echo $ttip1;?>, 
                    <?php echo $ttip2 ;?>, 
                    <?php echo $ttip3 ;?>, 
                    <?php echo $ttip4 ;?>,
                    <?php echo $ttip5;?>, 
                    <?php echo $ttip6 ;?>, 
                    <?php echo $ttip7 ;?>, 
                    <?php echo $ttip8 ;?>,
                    <?php echo $ttip9 ;?>,
                    <?php echo $ttip10 ;?>]
            }]
        }
    })
    </script>

<script>
    let miCanvas3=document.getElementById("MiGrafica3").getContext("2d");

    var chart = new Chart(miCanvas3,{
        type: "doughnut",
        data:{
            labels:[
            "<?php echo "1- $are1: CANTIDAD: $tare1   ||   PORCENTAJE: $aprom1%";?>", 
            "<?php echo "2- $are2: CANTIDAD: $tare2   ||   PORCENTAJE: $aprom2%";?>", 
            "<?php echo "3- $are3: CANTIDAD: $tare3   ||   PORCENTAJE: $aprom3%";?>", 
            "<?php echo "4- $are4: CANTIDAD: $tare4   ||   PORCENTAJE: $aprom4%";?>",
            "<?php echo "5- $are5: CANTIDAD: $tare5   ||   PORCENTAJE: $aprom5%";?>", 
            "<?php echo "6- $are6: CANTIDAD: $tare6   ||   PORCENTAJE: $aprom6%";?>", 
            "<?php echo "7- $are7: CANTIDAD: $tare7   ||   PORCENTAJE: $aprom7%";?>", 
            "<?php echo "8- $are8: CANTIDAD: $tare8   ||   PORCENTAJE: $aprom8%";?>",
            "<?php echo "9- $are9: CANTIDAD: $tare9   ||   PORCENTAJE: $aprom9%";?>",
            "<?php echo "10- $are10: CANTIDAD: $tare10   ||   PORCENTAJE: $aprom10%";?>",],

            datasets:[{
                label: "INCIDENTES POR ÁREA",
                backgroundColor: [
                    "rgb(0,197,255)", 
                    "rgb(255, 0, 0)",
                    "rgb(103, 1, 1)",
                    "rgb(255, 0, 189)", 
                    "rgb(96, 2, 121)",
                    "rgb(0, 224, 255)",
                    "rgb(0, 97, 111)", 
                    "rgb(0, 255, 42)",
                    "rgb(0, 121, 20)",
                    "rgb(232, 255, 0)"],
                borderColor: "black",
                data:[
                    <?php echo $tare1;?>, 
                    <?php echo $tare2 ;?>, 
                    <?php echo $tare3 ;?>, 
                    <?php echo $tare4 ;?>,
                    <?php echo $tare5;?>, 
                    <?php echo $tare6 ;?>, 
                    <?php echo $tare7 ;?>, 
                    <?php echo $tare8 ;?>,
                    <?php echo $tare9 ;?>,
                    <?php echo $tare10 ;?>]
            }]
        }
    })
    </script>

<script>
    let miCanvas1=document.getElementById("MiGrafica1").getContext("2d");

    var chart = new Chart(miCanvas1,{
        type: "doughnut",
        data:{
            labels:[
            "<?php echo "1- $est1: CANTIDAD: $etot1   ||   PORCENTAJE: $eprom1%";?>", 
            "<?php echo "2- $est2: CANTIDAD: $etot2   ||   PORCENTAJE: $eprom2%";?>", 
            "<?php echo "3- $est3: CANTIDAD: $etot3   ||   PORCENTAJE: $eprom3%";?>", 
            "<?php echo "4- $est4: CANTIDAD: $etot4   ||   PORCENTAJE: $eprom4%";?>",
            "<?php echo "5- $est5: CANTIDAD: $etot5   ||   PORCENTAJE: $eprom5%";?>",],

            datasets:[{
                label: "INCIDENTES POR USUARIO",
                backgroundColor:[
                    "rgb(0,197,255)", 
                    "rgb(255, 0, 0)",
                    "rgb(103, 1, 1)",
                    "rgb(255, 0, 189)", 
                    "rgb(96, 2, 121)",],
                borderColor: "black",
                data:[
                    <?php echo $etot1;?>,
                    <?php echo $etot2 ;?>,
                    <?php echo $etot3 ;?>,
                    <?php echo $etot4 ;?>,
                    <?php echo $etot5 ;?>]
            }]
        }
    })
    </script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="../js/script.js"></script>
</html>