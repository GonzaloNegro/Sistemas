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
	<title>AGREGAR USUARIO</title><meta charset="utf-8">
	<link rel="icon" href="imagenes/logoObrasPúblicas.png">
	<link rel="stylesheet" type="text/css" href="estiloagregar.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<style>
			body{
				background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
			function done(){
				swal(  {title: "Usuario cargado correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmusuario.php';
						}
						}
						);
			}	
			</script>
<script type="text/javascript">
			function repeat(){
				swal(  {title: "Usuario cargado correctamente. Verifique el nombre del usuario, ya que existe este nombre registrado previamente!",
						icon: "info",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmusuario.php';
						}
						}
						);
			}	
			</script>
<script type="text/javascript">
			function no(){
				swal(  {title: "Usuario o cuil ya registrados",
						icon: "error",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='agregarusuario.php';
						}
						}
						);
			}	
			</script>
	<div id="reporteEst" style="width: 97%; margin-left: 20px;">   
				<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
					<a id="vlv"  href="abmusuario.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
				</div>					
		</div>
		
        <section id="Inicio">
		<div id="titulo" style="margin: 20px;">
			<h1>AGREGAR USUARIO</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
						<form method="POST" action="guardarmodusuario.php">
                            <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm" class="col-form-label col-xl col-lg">USUARIO:</label>
                            <input class="form-control col-xl col-lg" style="text-transform:uppercase;" type="text" name="nombre_usuario" placeholder="APELLIDO Y NOMBRE" required>
							<label id="lblForm"class="col-form-label col-xl col-lg">CUIL:</label>
                            <input class="form-control col-xl col-lg" type="text" name="cuil" placeholder="CUIL" required>
                            </div>
                            <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">ÁREA:</label>
                            <select name="area" class="form-control col-xl col-lg" required>
							<option selected disabled="area">-SELECCIONE UNA-</option>
							<?php
							include("conexion.php");

							$consulta= "SELECT * FROM area";
							$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
							?>
							<?php foreach ($ejecutar as $opciones): ?> 
								<option value="<?php echo $opciones['ID_AREA']?>"><?php echo $opciones['AREA']?></option>						
							<?php endforeach ?>
							</select>


							<label id="lblForm"class="col-form-label col-xl col-lg">PISO:</label>
                            <select name="piso" class="form-control col-xl col-lg">
								<option selected disabled="piso">-SELECCIONE UNA-</option>
								<option value="PB">PB</option>
								<option value="P1">P1</option>
								<option value="P2">P2</option>
							</select>
                            </div>
                            <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">INTERNO:</label>
                            <input class="form-control col-xl col-lg" type="text" name="interno" placeholder="INTERNO" class="corto">
							<label id="lblForm"class="col-form-label col-xl col-lg">TELEFONO PERSONAL:</label>
                            <input class="form-control col-xl col-lg" type="text" name="telefono_personal" placeholder="TELEFONO PERSONAL">
                            </div>
                            <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">CORREO:</label>
                            <input class="form-control col-xl col-lg" type="text" name="correo" maxlength="75" placeholder="CORREO" class="achicar">
							<label id="lblForm"class="col-form-label col-xl col-lg">CORREO PERSONAL:</label>
                            <input class="form-control col-xl col-lg" type="text" maxlength="75" name="correo_personal" placeholder="CORREO PERSONAL" class="achicar">
							</div>
							<div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">TURNO:</label>
							<select name="turno" class="form-control col-xl col-lg" required>
							<option selected disabled>-SELECCIONE UNA-</option>
							<?php
							include("conexion.php");

							$consulta= "SELECT * FROM turnos";
							$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
							?>
							<?php foreach ($ejecutar as $opciones): ?> 
								<option value="<?php echo $opciones['ID_TURNO']?>"><?php echo $opciones['TURNO']?></option>						
							<?php endforeach ?>
							</select>
							<label id="lblForm"class="col-form-label col-xl col-lg">ACTIVO:</label>
							<select name="activo" class="form-control col-xl col-lg" required>
								<option selected disabled>-SELECCIONE UNA-</option>
								<option value="ACTIVO">ACTIVO</option>
								<option value="INACTIVO">INACTIVO</option>
							</select>
							</div>
							<div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">OBSERVACIÓN:</label>
							<textarea class="form-control col-xl col-lg" name="obs" placeholder="OBSERVACIÓN" style="text-transform:uppercase" rows="3"></textarea>
							</div>
                            <div class="row justify-content-end" style="margin: 10px; padding:10px;">
                            <input style="width: 20%;"class="col-3 button" type="submit" value="GUARDAR" >
                            </div>
					</form>
					<?php
				if(isset($_GET['ok'])){
					?>
					<script>done();</script>
					<?php			
				}
				if(isset($_GET['repeat'])){
					?>
					<script>repeat();</script>
					<?php			
				}
				if(isset($_GET['no'])){
					?>
					<script>no();</script>
					<?php			
				}
			?>
		</div>
	</section>
	<footer></footer>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>