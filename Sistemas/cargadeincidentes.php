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
	<link rel="stylesheet" type="text/css" href="estilocarga.css">
	<link rel="stylesheet" href="jquery/1/jquery-ui.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="jquery/1/jquery-ui.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
		<script>
	$(document).ready(function(){
    $("#slctestado").change(function(){
        if ($("#slctestado").val() == '3') {
			$("#txtaDerivacion").show(1300);
		    $("#resoderi").show(1300);
		    $("#slctResoDer").show(1300);
		}
		else{
			$("#txtaDerivacion").hide(1000);
		    $("#resoderi").hide(1000);
		    $("#slctResoDer").hide(1000);
		}
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
						showConfirmButton: true,
						showCancelButton: false,
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
		<div id="titulo" style="margin-top:20px; margin-bottom:20px;">
			<h1>CARGA DE INCIDENTES</h1>
		</div>
		<div  id="principal" class="container-fluid" >
						<form method="POST" action="guardarincidente.php" >
							<!--<label>NUMERO DE TICKET: <input type="text" name="numero_ticket" placeholder="NÚMERO DE TICKET" required></label>-->
							<div class="form-group row" style="margin: 10px; padding:10px;">
							<label class="col-form-label col-xl col-lg">FECHA INICIO:</label>
							<input class="form-control col-xl col-lg" type="text" name="fecha_inicio" id="txtfechainicio" required>
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<label class="col-form-label col-xl col-lg">USUARIO:</label>
							<select name="usuario" required class="derecha form-control col-xl col-lg">
								<option value="" selected disabled="usuario">-SELECCIONE UNA-</option>
							<?php
							include("conexion.php");
							$consulta= "SELECT * FROM usuarios ORDER BY NOMBRE ASC";
							$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
							?>
							<?php foreach ($ejecutar as $opciones): ?> 
								<option value="<?php echo $opciones['NOMBRE']?>"><?php echo $opciones['NOMBRE']?></option>
							<?php endforeach ?>
							</select>
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<label class="col-form-label col-xl col-lg">PRIORIDAD: </label>
							<select name="prioridad" class="form-control col-xl col-lg" required>
								<option value="" selected disabled="prioridad">-SELECCIONE UNA-</option>
								<?php
								include("conexion.php");
								$consulta= "SELECT * FROM prioridad";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_PRIORIDAD']?>"><?php echo $opciones['PRIORIDAD']?></option>
								<?php endforeach ?>
							</select>
		                    </div>	
							
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<div class="form-group row" style="margin: 10px; padding:10px;">
							<textarea name="descripcion" style="margin-left: 40px;" class="form-control col" placeholder="DESCRIPCIÓN" style="text-transform:uppercase" rows="3" required></textarea>
							</div>
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<div class="row" style="margin: 10px; padding:10px;">
							<label class="col-form-label col-xl">NÚMERO DE EQUIPO: </label>
							<input type="text" name="numero" style="text-transform:uppercase" placeholder="NÚMERO DE EQUIPO" class="form-control col-xl derecha">
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<label class="col-form-label col-xl">TIPIFICACIÓN: </label>
							<select name="tipificacion" class="form-control col-xl" required>
								<option value="" selected disabled="tipificacion">-SELECCIONE UNA-</option>
								<?php
								include("conexion.php");
								$consulta= "SELECT * FROM tipificacion WHERE ID_TIPIFICACION >= 20";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_TIPIFICACION']?>"><?php echo $opciones['TIPIFICACION']?></option>
								<?php endforeach ?>
							</select>
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<label class="col-form-label col-xl">ESTADO INCIDENTE: </label>
							<select id="slctestado" name="estado" required class="form-control col-xl derecha" >
								<option value="" selected disabled="estado">-SELECCIONE UNA-</option>
								<?php
								include("conexion.php");
								$consulta= "SELECT * FROM estado";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_ESTADO']?>"><?php echo $opciones['ESTADO']?></option>
								<?php endforeach ?>
							</select>
							</div>
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<div class="row" style="margin: 10px; padding:10px;">
							<label class="col-form-label col-xl">FECHA SOLUCIÓN: </label>
							<input type="text" name="fecha_solucion" id="txtfechafin" class="form-control col-xl derecha">
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<label class="col-form-label col-xl">ADJUNTAR ARCHIVOS: </label>
							<input type="file" name="imagen" class="form-control col-xl archivo" >
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<label class="col-form-label col-xl" id="resoderi" style="display: none;">RESOLUTOR DERIVADO: </label>
							<select name="derivado" id="slctResoDer" style="display: none;" class="form-control col-xl derecha">
								<option selected disabled="">-SELECCIONE UNA-</option>
								<?php
								include("conexion.php");
								$consulta= "SELECT * FROM resolutor ORDER BY RESOLUTOR ASC";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_RESOLUTOR']?>"><?php echo $opciones['RESOLUTOR']?></option>
								<?php endforeach ?>
							</select>
							</div>
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<div class="row" style="margin: 10px; padding:10px;">
							<textarea name="motivo" style="margin-left: 40px; display: none;" id="txtaDerivacion" class="form-control col" placeholder="MOTIVO DE DERIVACIÓN" style="text-transform:uppercase" rows="3"></textarea>
							</div>
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<div class="row justify-content-end" style="margin: 10px; padding:10px;">
							<input type="submit" value="GUARDAR" name="g1" class="col-2 button">
							</div>
							
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