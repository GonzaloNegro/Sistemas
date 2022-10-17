<?php 
session_start();
include('conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();

$cu = $row['CUIL'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>STOCK</title>
	<meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoObrasPúblicas.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
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
		<li><a href="../carga/cargadeincidentes.php" class="nav-link px-2 link-secondary link destacado" 
			>NUEVO INCIDENTE</a>
 				<ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
					<li><a class="dropdown-item" href="../carga/cargarapidaporusuario.php">CARGA RÁPIDA POR USUARIO</a></li>
<!-- 				<li><hr class="dropdown-divider"></li>
                	<li><a class="dropdown-item" href="cargarapidaportipificacion.php">CARGA RÁPIDA POR TIPIFICACIÓN</a></li> -->
                </ul>
			</li>
            <li><a href="../consulta/consulta.php" class="nav-link px-2 link-dark link" style="border-left: 5px solid #53AAE0;">CONSULTA</a>
			<ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="../consultaconsulta.php">CONSULTA DE INCIDENTES</a></li>
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
						<li><a href="../particular/estadisticas.php" class="nav-link px-2 link-dark link">ESTADISTICAS</a></li>
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
		  	<li><a class="dropdown-item" href="agregados.php">CAMBIOS AGREGADOS</a></li>
            <li><hr class="dropdown-divider"></li>';}?>
            <li><a class="dropdown-item" href="contraseña.php">CAMBIAR CONTRASEÑA</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="salir.php">CERRAR SESIÓN</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
		<style>
			#h2{
	              text-align: left;	
	              font-family: TrasandinaBook;
	              font-size: 16px;
	              color: #edf0f5;
	              margin-left: 10px;
	              margin-top: 5px;;
               
				}
        </style>
	<section id="consulta">
		<div id="titulo" data-aos="zoom-in">
			<h1>STOCK</h1>
		</div>

	<!-- //////////////////////////////// -->


	<?php                 
 		$totpc=mysqli_query($datos_base, "SELECT COUNT(ID_WS) as TOTAL FROM inventario where ID_ESTADOWS = 3 AND ID_TIPOWS = 1");
		$totalpc = mysqli_fetch_array($totpc);

		$totnt=mysqli_query($datos_base, "SELECT COUNT(ID_WS) as TOTAL FROM inventario where ID_ESTADOWS = 3 AND ID_TIPOWS = 2");
		$totalnt = mysqli_fetch_array($totnt);

		$totmon=mysqli_query($datos_base, "SELECT COUNT(ID_PERI) as TOTAL FROM periferico where ID_ESTADOWS = 3 AND (ID_TIPOP = 7 OR ID_TIPOP = 8)");
		$totalmon = mysqli_fetch_array($totmon);

		$totimp=mysqli_query($datos_base, "SELECT COUNT(ID_PERI) as TOTAL FROM periferico where ID_ESTADOWS = 3 AND (ID_TIPOP = 1 OR ID_TIPOP = 2 OR ID_TIPOP = 3 OR ID_TIPOP = 4 OR ID_TIPOP = 10 or 13)");
		$totalimp = mysqli_fetch_array($totimp);


		/* TECLADO */
		$teclado=mysqli_query($datos_base, "SELECT CANTIDAD as TOTAL FROM stock WHERE ID_STOCK = 1");
		$totteclado = mysqli_fetch_array($teclado);
		/* FUENTE */
		$fuente=mysqli_query($datos_base, "SELECT CANTIDAD as TOTAL FROM stock WHERE ID_STOCK = 2");
		$totalfuente = mysqli_fetch_array($fuente);
		/* TONER */
		$toner=mysqli_query($datos_base, "SELECT CANTIDAD as TOTAL FROM stock WHERE ID_STOCK = 3");
		$totaltoner = mysqli_fetch_array($toner);
		/* HDMI */
		$hdmi=mysqli_query($datos_base, "SELECT CANTIDAD as TOTAL FROM stock WHERE ID_STOCK = 4");
		$totalhdmi = mysqli_fetch_array($hdmi);
		/* VGA */
		$vga =mysqli_query($datos_base, "SELECT CANTIDAD as TOTAL FROM stock WHERE ID_STOCK = 5");
		$totalvga = mysqli_fetch_array($vga);
		/* DVI */
		$dvi=mysqli_query($datos_base, "SELECT CANTIDAD as TOTAL FROM stock WHERE ID_STOCK = 6");
		$totaldvi = mysqli_fetch_array($dvi);
		/* USB IMPRESORA */
		$usbi=mysqli_query($datos_base, "SELECT CANTIDAD as TOTAL FROM stock WHERE ID_STOCK = 7");
		$totalusbi = mysqli_fetch_array($usbi);
		/* DVI/HDMI */
		$dh =mysqli_query($datos_base, "SELECT CANTIDAD as TOTAL FROM stock WHERE ID_STOCK = 8");
		$totaldh = mysqli_fetch_array($dh);
		/* DVI/VGA */
		$dv=mysqli_query($datos_base, "SELECT CANTIDAD as TOTAL FROM stock WHERE ID_STOCK = 9");
		$totaldv = mysqli_fetch_array($dv);
		/* HDMI/VGA */
		$hv=mysqli_query($datos_base, "SELECT CANTIDAD as TOTAL FROM stock WHERE ID_STOCK = 10");
		$totalhv = mysqli_fetch_array($hv);
	?>

		<div class="contenedor">

			<div>
				<div class="tits">
					<h1>EQUIPOS</h1>
				</div>
				<div class="info">
					<div class="card" style="width: 15rem;">
						<img src="../imagenes/gabinete.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">EQUIPOS</p>
						</div>
						<div class="card-body">
							<p class="btns-nro" id="valequip"><?php echo "".$totalpc['TOTAL'].""; ?></p>
						</div>
						<div class="card-conf">
							<button class="conf">DETALLES</button>
						</div>
					</div>

					<div class="card" style="width: 15rem;">
						<img src="../imagenes/notebook.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">NOTEBOOKS</p>
						</div>
						<div class="card-body">
							<p class="btns-nro" id="valnot"><?php echo "".$totalnt['TOTAL'].""; ?></p>
						</div>
						<div class="card-conf">
							<button class="conf">DETALLES</button>
						</div>
					</div>

					<div class="card" style="width: 15rem;">
						<img src="../imagenes/monitor.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">MONITORES</p>
						</div>
						<div class="card-body">
							<p class="btns-nro" id="valimp"><?php echo "".$totalmon['TOTAL'].""; ?></p>
						</div>
						<div class="card-conf">
							<button class="conf">DETALLES</button>
						</div>
					</div>
					<div class="card" style="width: 15rem;">
						<img src="../imagenes/impresora.jpeg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">IMPRESORAS</p>
						</div>
						<div class="card-body">
							<p class="btns-nro" id="valmon"><?php echo "".$totalimp['TOTAL'].""; ?></p>
						</div>
						<div class="card-conf">
							<button class="conf">DETALLES</button>
						</div>
					</div>
			</div>
			</div>


		<!-- ------------------------- -->

			<div >
<!-- 				<div class="tits">
					<h1>MEMORIA</h1>
				</div> -->
				<div class="info">
					<div class="card" style="width: 15rem;">
					<img src="../imagenes/ram.jpg" class="card-img-top" alt="...">
					<div class="card-body">
						<p class="card-text">MEMORIA RAM</p>
					</div>

					<div class="card-conf">
					<a href="stockRam.php"><button class="conf">DETALLES</button></a>
					</div>
				</div>

				<div class="card" style="width: 15rem;">
					<img src="../imagenes/discoduro.jpg" class="card-img-top" alt="...">
					<div class="card-body">
						<p class="card-text">DISCO DURO</p>
					</div>

					<div class="card-conf">
						<button class="conf">DETALLES</button>
					</div>
				</div>

				<div class="card" style="width: 15rem;">
					<img src="../imagenes/fuente.jpg" class="card-img-top" alt="...">
					<div class="card-body">
						<p class="card-text">FUENTE</p>
					</div>
					<div class="card-body">
						<form action="controlStock.php" method="POST" name="form1"> 
							<!-- <p class="btns-nro" id="valtec"><?php echo "".$totalfuente['TOTAL']."" ?></p> -->
							<input type="number" class="inp" name="valorfuente" value="<?php echo $totalfuente['TOTAL']?>" >
					<!-- <button class="btns-men" id="resfue">-</button>
						<p class="btns-nro" id="valfue">0</p>
						<button class="btns-mas" id="sumfue">+</button> -->
					</div>
					<div class="card-conf">
							<button type="submit" class="conf" name="btnfuente">GUARDAR</button> 
							</form> 
					</div>
				</div>


				<div class="card" style="width: 15rem;">
					<img src="../imagenes/teclado.jpg" class="card-img-top" alt="...">
					<div class="card-body">
						<p class="card-text">TECLADOS</p>
					</div>						
					<div class="card-body">
						<form action="controlStock.php" method="POST" name="form1"> 
						<input type="number" class="inp" name="valorteclado" value="<?php echo $totteclado['TOTAL']?>">
					</div>
					<div class="card-conf">
						<button type="submit" class="conf" name="btnteclado">GUARDAR</button> 
						</form> 
					</div>
				</div>	
			</div>
			


			<!-- /////////////////////////////// -->
			<div >
				<div class="tits">
					<h1>CABLES</h1>
				</div>
				<div class="info">
					<div class="card" style="width: 15rem;">
						<img src="../imagenes/hdmi.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">HDMI</p>
						</div>
						<div class="card-body">
							<form action="controlStock.php" method="POST" name="form1"> 
								<input type="number" class="inp" name="valorhdmi" value="<?php echo $totalhdmi['TOTAL']?>" >
						</div>
						<div class="card-conf">
								<button type="submit" class="conf" name="btnhdmi">GUARDAR</button> 
							</form> 
						</div>
					</div>

					<div class="card" style="width: 15rem;">
						<img src="../imagenes/vga.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">VGA</p>
						</div>
						<div class="card-body">
							<form action="controlStock.php" method="POST" name="form1"> 
								<input type="number" class="inp" name="valorvga" value="<?php echo $totalvga['TOTAL']?>" >
						</div>
						<div class="card-conf">
								<button type="submit" class="conf" name="btnvga">GUARDAR</button> 
							</form> 
						</div>
					</div>

					<div class="card" style="width: 15rem;">
						<img src="../imagenes/dvi.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">DVI</p>
						</div>
						<div class="card-body">
							<form action="controlStock.php" method="POST" name="form1"> 
								<input type="number" class="inp" name="valordvi" value="<?php echo $totaldvi['TOTAL']?>" >
						</div>
						<div class="card-conf">
								<button type="submit" class="conf" name="btndvi">GUARDAR</button> 
							</form> 
						</div>
					</div>

					<div class="card" style="width: 15rem;">
						<img src="../imagenes/usbimp.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">USB IMPRESORA</p>
						</div>
						<div class="card-body">
							<form action="controlStock.php" method="POST" name="form1"> 
								<input type="number" class="inp" name="valorusbi" value="<?php echo $totalusbi['TOTAL']?>" >
						</div>
						<div class="card-conf">
								<button type="submit" class="conf" name="btnusbi">GUARDAR</button> 
							</form> 
						</div>
					</div>
				</div>
			</div>

			<!-- //////////////////////// -->
			<div >
				<div class="tits">
					<h1>ADAPTADORES</h1>
				</div>
				<div class="info">
					<div class="card" style="width: 15rem;">
						<img src="../imagenes/dvihdmi.jpeg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">DVI/HDMI</p>
						</div>
						<div class="card-body">
							<form action="controlStock.php" method="POST" name="form1"> 
								<input type="number" class="inp" name="valordh" value="<?php echo $totaldh['TOTAL']?>" >
						</div>
						<div class="card-conf">
								<button type="submit" class="conf" name="btndh">GUARDAR</button> 
							</form> 
						</div>
					</div>

					<div class="card" style="width: 15rem;">
						<img src="../imagenes/dvivga.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">DVI/VGA</p>
						</div>
						<div class="card-body">
							<form action="controlStock.php" method="POST" name="form1"> 
								<input type="number" class="inp" name="valordv" value="<?php echo $totaldv['TOTAL']?>" >
						</div>
						<div class="card-conf">
								<button type="submit" class="conf" name="btndv">GUARDAR</button> 
							</form> 
						</div>
					</div>

					<div class="card" style="width: 15rem;">
						<img src="../imagenes/hdmivga.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">HDMI/VGA</p>
						</div>
						<div class="card-body">
							<form action="controlStock.php" method="POST" name="form1"> 
								<input type="number" class="inp" name="valorhv" value="<?php echo $totalhv['TOTAL']?>" >
						</div>
						<div class="card-conf">
								<button type="submit" class="conf" name="btnhv">GUARDAR</button> 
							</form> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<footer>
		<div class="footer">
			<div class="container-fluid">
				<div class="row">
					<img src="../imagenes/logoGobierno.png" class="img-fluid">
				</div>
			</div>
		</div>
	</footer>
<!-- 	<script src="../js/stock.js"></script> -->
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
  		AOS.init();
	</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="../js/script.js"></script>
</body>
</html>