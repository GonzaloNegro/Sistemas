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
	<link rel="stylesheet" type="text/css" href="estilocargarapida.css">
	<link rel="stylesheet" href="jquery/1/jquery-ui.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="jquery/1/jquery-ui.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script>
		$(function (){
			$("#txtfechainicio").datepicker() ({
				dateformat: "yyyy-mm-dd"
			});
		});
	</script>
		<script>
		$(function (){
			$("#txtfechafin").datepicker() ({
				dateformat: "yyyy-mm-dd"
			});
		});
	</script>
	<style>
			body{
				background-color: #edf0f5;
			}
	</style>
</head>
<body>
	<script type="text/javascript">
			function done(){
				swal(  {title: "Se ha cargado su incidente correctamente",
						icon: "success",
						buttons: true,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='consulta.php';
						}
						}
						);
			}	
			</script>
	<header class="header">
		<div class="container">
			<div class="btn-menu">
		<nav id="botonera">
			<ul class="nav">
				<li><label for="btn-menu" style="cursor: pointer;"><img src="iconos/menu.png"></label></li>
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
									<li><a href="">-Submenu3</a></li>
						</ul>
				</li>
			</div>
			</div>
			</ul>
		</nav>
	</header>
	<input type="checkbox" id="btn-menu">
		<div class="container-menu">
			<div class="cont-menu">
				<nav>
					<div id="foto"></div>				
					<h2><u>Nombre</u>: &nbsp<?php echo utf8_decode($row['RESOLUTOR']);?></h2>
					<h2><u>Cuil</u>: &nbsp &nbsp &nbsp &nbsp &nbsp<?php if ((isset($_SESSION['cuil'])) && ($_SESSION['cuil'] != "")){echo $_SESSION['cuil'];}?></h2>
					<h2><u>Gestión: </u></h2>
					<a href="agregarusuario.php" class="color"><h2>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp-AGREGAR USUARIO</h2></a>
					<a href="agregarresolutor.php" class="color"><h2>&nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp-AGREGAR RESOLUTOR</h2></a>
					<a href="agregartipificacion.php" class="color"><h2>&nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp-AGREGAR TIPIFICACIÓN</h2></a>
					<a href="agregararea.php" class="color"><h2>&nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp-AGREGAR ÁREA</h2></a><br>
					<a href="contraseña.php"><h2><u>Cambiar contraseña</u></h2></a>
					<a href="salir.php"><h2><u>Cerrar Sesión</u></h2></a>
				</nav>
				<label for="btn-menu">✖️</label>
			</div>
		</div>
	<section id="Inicio">
		<div id="titulo">
			<h1>CARGA RÁPIDA POR USUARIO</h1>
		</div>
		<div id="principal">
						<form method="POST" action=".php">
                        <label>USUARIO:<select name="usuario" required class="derecha">
								<option value="">-SELECCIONE UNA-</option>
							<?php
							include("conexion.php");
							$consulta= "SELECT * FROM usuarios ORDER BY NOMBRE ASC";
							$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
							?>
							<?php foreach ($ejecutar as $opciones): ?> 
								<option value="<?php echo $opciones['NOMBRE']?>"><?php echo $opciones['NOMBRE']?></option>
							<?php endforeach ?>
							</select></label><br>
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
                            <!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
                            <label><u>INCIDENTE N°1:</u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                           		<select name="tipificacion1" required>
								<option value="">-TIPIFICACIÓN 1-</option>
								<?php
								include("conexion.php");
								$consulta= "SELECT * FROM tipificacion";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_TIPIFICACION']?>"><?php echo $opciones['TIPIFICACION']?></option>
								<?php endforeach ?>
							</select></label><!--INCIDENTE1-->&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                            <label><u>INCIDENTE N°2:</u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
                            	<select name="tipificacion2" required>
								<option value="">-TIPIFICACIÓN 2-</option>
								<?php
								include("conexion.php");
								$consulta= "SELECT * FROM tipificacion";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_TIPIFICACION']?>"><?php echo $opciones['TIPIFICACION']?></option>
								<?php endforeach ?>
							</select></label><!--INCIDENTE2--><br>&nbsp 
                           <textarea name="descripcion1" placeholder="DESCRIPCIÓN" rows="3" required></textarea><!--INCIDENTE1-->&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                           <textarea name="descripcion2" placeholder="DESCRIPCIÓN" rows="3" required></textarea><!--INCIDENTE2--><br><br><br><br><br><br>
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
                            <!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
                            <label><u>INCIDENTE N°3:</u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                            	<select name="tipificacion3" required>
								<option value="">-TIPIFICACIÓN 3-</option>
								<?php
								include("conexion.php");
								$consulta= "SELECT * FROM tipificacion";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_TIPIFICACION']?>"><?php echo $opciones['TIPIFICACION']?></option>
								<?php endforeach ?>
							</select></label><!--INCIDENTE3-->&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                            <label><u>INCIDENTE N°4:</u>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                            	<select name="tipificacion4" required>
								<option value="">-TIPIFICACIÓN 4-</option>
								<?php
								include("conexion.php");
								$consulta= "SELECT * FROM tipificacion";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_TIPIFICACION']?>"><?php echo $opciones['TIPIFICACION']?></option>
								<?php endforeach ?>
							</select></label><!--INCIDENTE4--><br>&nbsp 
                           <textarea name="descripcion3" placeholder="DESCRIPCIÓN" rows="3" required></textarea><!--INCIDENTE3-->&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                           <textarea name="descripcion4" placeholder="DESCRIPCIÓN" rows="3" required></textarea><!--INCIDENTE4--><br><br>
						   <input type="submit" value="GUARDAR" name="g1" class="button">
					</form>
				<?php
				if(isset($_GET['ok'])){
					/*echo "<h3>Incidente cargado</h3>";*/?>
					<script>done();</script>
					<?php			
				}
			?>
		</div>
	</section>
	<footer></footer>
</body>
</html>