<?php 
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
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
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
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
	<?php include('../layout/reportes.php'); ?>
		<style>
			#h2{
	              text-align: left;	
	              font-family: TrasandinaBook;
	              font-size: 16px;
	              color: #edf0f5;
	              margin-left: 10px;
	              margin-top: 5px;
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

		$totimp=mysqli_query($datos_base, "SELECT COUNT(p.ID_PERI) as TOTAL 
		FROM periferico p
		INNER JOIN equipo_periferico e ON p.ID_PERI = e.ID_PERI 
		WHERE p.ID_ESTADOWS = 3 AND e.ID_WS = 0 AND (p.ID_TIPOP = 1 OR p.ID_TIPOP = 2 OR p.ID_TIPOP = 3 OR p.ID_TIPOP = 4 OR p.ID_TIPOP = 10 or 13)");
		$totalimp = mysqli_fetch_array($totimp);


		/* MEMORIA */
		$memoria=mysqli_query($datos_base, "SELECT sum(CANTIDAD) as TOTAL FROM stockram");
		$totmemoria = mysqli_fetch_array($memoria);
		/* DISCO */
		$disco=mysqli_query($datos_base, "SELECT sum(CANTIDAD) as TOTAL FROM stockdisco");
		$totdisco = mysqli_fetch_array($disco);
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
		/* MOUSE */
		$mouse=mysqli_query($datos_base, "SELECT CANTIDAD as TOTAL FROM stock WHERE ID_STOCK = 11");
		$totalmous = mysqli_fetch_array($mouse);
		/* DISPLAY PORT/HDMI */
		$ph=mysqli_query($datos_base, "SELECT CANTIDAD as TOTAL FROM stock WHERE ID_STOCK = 12");
		$totalph = mysqli_fetch_array($ph);
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



		<!-- ------------------------- -->

		<div>
			<div class="info">
				<div class="card" style="width: 15rem;">
					<img src="../imagenes/ram.jpg" class="card-img-top" alt="...">
					<div class="card-body">
						<p class="card-text">MEMORIA RAM</p>
					</div>
					<div class="card-body">
						<p class="btns-nro" id="valimp"><?php echo "".$totmemoria['TOTAL'].""; ?></p>
					</div>
					<div class="card-conf">
					<a href="stockram.php"><button class="conf">DETALLES</button></a>
					</div>
				</div>

				<div class="card" style="width: 15rem;">
					<img src="../imagenes/discoduro.jpg" class="card-img-top" alt="...">
					<div class="card-body">
						<p class="card-text">DISCO DURO</p>
					</div>
					<div class="card-body">
						<p class="btns-nro" id="valimp"><?php echo "".$totdisco['TOTAL'].""; ?></p>
					</div>
					<div class="card-conf">
						<a href="stockdisco.php"><button class="conf">DETALLES</button></a>
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
							<input type="number" min="0" class="inp" name="valorfuente" value="<?php echo $totalfuente['TOTAL']?>" >
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
						<input type="number" min="0" class="inp" name="valorteclado" value="<?php echo $totteclado['TOTAL']?>">
					</div>
					<div class="card-conf">
						<button type="submit" class="conf" name="btnteclado">GUARDAR</button> 
						</form> 
					</div>
				</div>	
			</div>
			
		<div class="info">
			<div class="card" style="width: 15rem;">
				<img src="../imagenes/mouse.jpg" class="card-img-top" alt="...">
				<div class="card-body">
					<p class="card-text">MOUSE</p>
				</div>						
				<div class="card-body">
<!-- 					<form action="<?php echo htmlspecialchars($_SERVER["controlStock.php"])?>" method="POST"> -->
					<form action="controlStock.php" method="POST" name="form1"> 
					<input type="number" min="0" class="inp" name="valormouse" value="<?php echo $totalmous['TOTAL']?>">
				</div>
				<div class="card-conf">
					<button type="submit" class="conf" name="btnmouse">GUARDAR</button> 
<!-- 					<?php
							if(isset($_POST['btnmouse'])){
								$valormouse = $_POST['valormouse'];
								mysqli_query($datos_base, "UPDATE stock SET CANTIDAD = '$valormouse' WHERE ID_STOCK = 11"); 
							}	
						?> -->
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
								<input type="number" min="0" class="inp" name="valorhdmi" value="<?php echo $totalhdmi['TOTAL']?>" >
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
								<input type="number" min="0" class="inp" name="valorvga" value="<?php echo $totalvga['TOTAL']?>" >
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
								<input type="number" min="0" class="inp" name="valordvi" value="<?php echo $totaldvi['TOTAL']?>" >
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
								<input type="number" min="0" class="inp" name="valorusbi" value="<?php echo $totalusbi['TOTAL']?>" >
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
								<input type="number" min="0" class="inp" name="valordh" value="<?php echo $totaldh['TOTAL']?>" >
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
								<input type="number" min="0" class="inp" name="valordv" value="<?php echo $totaldv['TOTAL']?>" >
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
								<input type="number" min="0" class="inp" name="valorhv" value="<?php echo $totalhv['TOTAL']?>" >
						</div>
						<div class="card-conf">
								<button type="submit" class="conf" name="btnhv">GUARDAR</button> 
							</form> 
						</div>
					</div>

					<div class="card" style="width: 15rem;">
						<img src="../imagenes/displayhdmi.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">DISPLAY PORT/HDMI</p>
						</div>
						<div class="card-body">
							<form action="controlStock.php" method="POST" name="form1"> 
								<input type="number" min="0" class="inp" name="valorph" value="<?php echo $totalph['TOTAL']?>" >
						</div>
						<div class="card-conf">
								<button type="submit" class="conf" name="btnph">GUARDAR</button> 
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
					<img src="../imagenes/cba-logo.png" class="img-fluid">
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
	<script>
		const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
		const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
	</script>
	
</body>
</html>