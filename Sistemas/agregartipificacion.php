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
	<title>Carga de incidentes</title><meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloagregartipificacion.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<header class="header" style="width: 100%">
<div class="container-fluid">
			<div class="btn-menu">
		<nav id="botonera" style="height: auto;">
			<ul class="nav">
				<li><label for="btn-menu" style="cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="60" fill="black" class="bi bi-list" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
</svg></label></li>
				</li>
				<li><a href="cargadeincidentes.php">CARGA</a>
                    <!--<ul id="sub">
                                        <li><a href="cargarapidaporusuario.php">-Carga rápida por usuario</a></li>
										<li><a href="#.php">-Carga rápida por tipificación</a></li>
                        </ul>-->
                 </li>
				<li><a href="consulta.php">CONSULTA </a></li>
				<li><a href="inventario.php">INVENTARIO </a>
					<ul id="sub">
									<li><a href="impresoras.php">-Impresoras</a></li>
									<li><a href="monitores.php">-Monitores</a></li>
						</ul>
				</li>
			</div>
			</div>
			</ul>
		</nav>
	</header>
	<input type="checkbox" id="btn-menu">
		<div class="container-menu" >
			<div class="cont-menu" style="padding: 10px">
			<nav >
					<div id="foto" style="margin-top: 21px; margin-bottom: 19px;"></div><br>			
					<h2 id="h2"><u>NOMBRE</u>: &nbsp<?php echo utf8_decode($row['RESOLUTOR']);?></h2>
					<h2 id="h2"><u>CUIL</u>: &nbsp &nbsp &nbsp &nbsp &nbsp<?php if ((isset($_SESSION['cuil'])) && ($_SESSION['cuil'] != "")){echo $_SESSION['cuil'];}?></h2><br>
					<h2 id="h2"><u>GESTIÓN: </u></h2>
					<a href="abm.php" class="color"><h2 id="h2">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp-ALTA/BAJA/MODIFICACIÓN</h2></a>
					<a href="tiporeporte.php" class="color"><h2 id="h2">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp-REPORTES</h2></a>
					<a href="contraseña.php" class="color"><h2 id="h2">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp-CAMBIAR CONTRASEÑA</h2></a><br><br><br>
					<a href="salir.php"><h2 id="h2"><u>CERRAR SESIÓN</u></h2></a>
				</nav>
				<label for="btn-menu">✖️</label>
			</div>
		</div>
		
	<section id="Inicio">
		<div id="titulo" style="margin:20px;">
			<h1>AGREGAR TIPIFICACIÓN</h1>
		</div>
		<div id="principal" style="width: auto" class="container-fluid">
						<form method="POST" action="cargatipificacion.php">
						<div class="form-group row" style="margin: 10px; padding:10px;">
						    <label style="font-size: 30px;" id="lblForm"class="col-form-label col-xl col-lg">NOMBRE DE LA TIPIFICACION:</label>
							<input style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" type="text" name="tipificacion" placeholder="NOMBRE DE LA TIPIFICACIÓN" required>
				        </div>	
						<div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
							<input style="width:20%"class="col-3 button" type="submit" value="GUARDAR TIPIFICACIÓN" class="button">
				        </div>	
					</form>
			<?php
				if(isset($_GET['ok'])){
					echo "<h3>Tipificación cargada</h3>";
				}
			?>
		</div>
	</section>
	<footer></footer>
</body>
</html>