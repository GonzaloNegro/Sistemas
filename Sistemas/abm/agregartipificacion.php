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
	<title>AGREGAR TIPIFICACIÓN</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoObrasPúblicas.png">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
			function ok(){
				swal(  {title: "Tipificacion cargada correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmtipificacion.php';
						}
						}
						);
			}	
			</script>
<script type="text/javascript">
			function no(){
				swal(  {title: "La tipificación ya está registrada",
						icon: "error",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='agregartipificacion.php';
						}
						}
						);
			}	
			</script>
	<div id="reporteEst" style="width: 97%; margin-left: 20px;">   
				<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
					<a id="vlv"  href="abmtipificacion.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
				</div>					
		</div>
		
	<section id="Inicio">
		<div id="titulo" style="margin:20px;">
			<h1>AGREGAR TIPIFICACIÓN</h1>
		</div>
		<div id="principal" style="width: auto" class="container-fluid" data-aos="zoom-in">
						<form method="POST" action="guardarmodtipificacion.php">
							<div class="form-group row" style="margin: 10px; padding:10px;">
								<label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE DE LA TIPIFICACIÓN:</label>
								<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="tip" placeholder="NOMBRE" required>
							</div>	
							<div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
								<input style="width:20%"class="col-3 button" type="submit" value="GUARDAR" class="button">
							</div>	
					</form>
					<?php

					//$tipi = "PRODUCTO NUEVO";

					//CORTAR ESPACIOS EN BLANCO:
					//$sinEspacios = preg_replace("/[[:space:]]/","",($tipi));
					//CALCULAR EL TAMAÑO
					//$tamaño = mb_strlen($sinEspacios);

					//ORDENAR ALFABÉTICAMENTE
					//$letras = (str_split($sinEspacios));
					//sort($letras, SORT_REGULAR);

					//var_dump($letras); NO DESCOMENTAR

					//$respuesta = implode($letras);
					//var_dump($respuesta); NO DESCOMENTAR
					
					//str_shuffle($tip); orden aleatorio
					//echo "Palabra sin espacios : ".$sinEspacios."<br>";
					//echo "Tamaño: ".$tamaño."<br>";
					//echo "Ordenado alfabeticamente: ".$respuesta;
					

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
		</div>
	</section>
	<footer></footer>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>