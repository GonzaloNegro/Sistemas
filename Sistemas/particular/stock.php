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
	<title>STOCK</title><meta charset="utf-8">
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
						<li><a href="stock.php" class="nav-link px-2 link-dark link">STOCK</a></li>
                    ';
					} ?>
			<li><a href="../calen/calen.php" class="nav-link px-2 link-dark link"><i class="bi bi-calendar3"></i></a>
			<li class="ubicacion link"><a href="bienvenida.php"><i class="bi bi-info-circle"></i></a></li>
        </ul>
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



		$teclado=mysqli_query($datos_base, "SELECT CANTIDAD as TOTAL FROM stock WHERE ID_STOCK = 1");
		$totteclado = mysqli_fetch_array($teclado);

		$fuente=mysqli_query($datos_base, "SELECT CANTIDAD as TOTAL FROM stock WHERE ID_STOCK = 2");
		$totalfuente = mysqli_fetch_array($fuente);
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
						<p class="btns-nro" id="valmon"><?php echo "".$totalmon['TOTAL'].""; ?></p>
						</div>
							<div class="card-conf">
							<button class="conf">DETALLES</button>
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
								<!--  PASAR UNA VARIABLE DE PHP A JS -->
									<!-- var temp1 = <?=   json_encode($totteclado['TOTAL']) ?> -->
								

								<!-- PASAR DE PHP A JAVASCRIPT -->
									 <!-- $var_PHP = "<script> document.writeln(numerotec); -->
									<!-- echo $var_PHP; muestra el resultado  -->
						</div>
					<div class="card-conf">
							<button type="submit" class="conf" name="btnteclado">GUARDAR</button> 
							</form> 
				</div>
					</div>
			</div>
			</div>


		<!-- ------------------------- -->

			<div >
				<div class="tits">
					<h1>MEMORIA</h1>
				</div>
				<div class="info">
					<div class="card" style="width: 15rem;">
					<img src="../imagenes/ram.jpg" class="card-img-top" alt="...">
					<div class="card-body">
						<p class="card-text">MEMORIA RAM</p>
					</div>
					<div class="card-body">
						<button class="btns-men" id="resram">-</button>
						<p class="btns-nro" id="valram">0</p>
						<button class="btns-mas" id="sumram">+</button>
					</div>
					<div class="card-conf">
						<button class="conf">GUARDAR</button>
					</div>
				</div>

				<div class="card" style="width: 15rem;">
					<img src="../imagenes/discoduro.jpg" class="card-img-top" alt="...">
					<div class="card-body">
						<p class="card-text">DISCO DURO</p>
					</div>
					<div class="card-body">
						<button class="btns-men" id="resdis">-</button>
						<p class="btns-nro" id="valdis">0</p>
						<button class="btns-mas" id="sumdis">+</button>
					</div>
					<div class="card-conf">
						<button class="conf">GUARDAR</button>
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
					<img src="../imagenes/toner.jpg" class="card-img-top" alt="...">
					<div class="card-body">
						<p class="card-text">TONER</p>
					</div>
					<div class="card-body">
						<button class="btns-men" id="reston">-</button>
						<p class="btns-nro" id="valton">0</p>
						<button class="btns-mas" id="sumton">+</button>
					</div>
					<div class="card-conf">
						<button class="conf">GUARDAR</button>
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
							<button class="btns-men" id="reshdmi">-</button>
							<p class="btns-nro" id="valhdmi">0</p>
							<button class="btns-mas" id="sumhdmi">+</button>
						</div>
						<div class="card-conf">
							<button class="conf">GUARDAR</button>
						</div>
					</div>

					<div class="card" style="width: 15rem;">
						<img src="../imagenes/vga.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">VGA</p>
						</div>
						<div class="card-body">
							<button class="btns-men" id="resvga">-</button>
							<p class="btns-nro" id="valvga">0</p>
							<button class="btns-mas" id="sumvga">+</button>
						</div>
						<div class="card-conf">
							<button class="conf">GUARDAR</button>
						</div>
					</div>

					<div class="card" style="width: 15rem;">
						<img src="../imagenes/dvi.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">DVI</p>
						</div>
						<div class="card-body">
							<button class="btns-men" id="resdvi">-</button>
							<p class="btns-nro" id="valdvi">0</p>
							<button class="btns-mas" id="sumdvi">+</button>
						</div>
						<div class="card-conf">
							<button class="conf">GUARDAR</button>
						</div>
					</div>

					<div class="card" style="width: 15rem;">
						<img src="../imagenes/usbimp.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">USB IMPRESORA</p>
						</div>
						<div class="card-body">
							<button class="btns-men" id="resusbi">-</button>
							<p class="btns-nro" id="valusbi">0</p>
							<button class="btns-mas" id="sumusbi">+</button>
						</div>
						<div class="card-conf">
							<button class="conf">GUARDAR</button>
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
							<button class="btns-men" id="resdh">-</button>
							<p class="btns-nro" id="valdh">0</p>
							<button class="btns-mas" id="sumdh">+</button>
						</div>
						<div class="card-conf">
							<button class="conf">GUARDAR</button>
						</div>
					</div>

					<div class="card" style="width: 15rem;">
						<img src="../imagenes/dvivga.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">DVI/VGA</p>
						</div>
						<div class="card-body">
							<button class="btns-men" id="resdv">-</button>
							<p class="btns-nro" id="valdv">0</p>
							<button class="btns-mas" id="sumdv">+</button>
						</div>
						<div class="card-conf">
							<button class="conf">GUARDAR</button>
						</div>
					</div>

					<div class="card" style="width: 15rem;">
						<img src="../imagenes/hdmivga.jpg" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-text">HDMI/VGA</p>
						</div>
						<div class="card-body">
							<button class="btns-men" id="reshv">-</button>
							<p class="btns-nro" id="valhv">0</p>
							<button class="btns-mas" id="sumhv">+</button>
						</div>
						<div class="card-conf">
							<button class="conf">GUARDAR</button>
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
</body>
</html>