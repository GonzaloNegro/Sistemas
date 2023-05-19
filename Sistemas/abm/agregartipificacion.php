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
	<div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="abmtipificacion.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>	
	<section id="Inicio">
		<div id="titulo">
			<h1>AGREGAR TIPIFICACIÓN</h1>
		</div>
		<div id="principal">
			<form method="POST" action="guardarmodtipificacion.php">
				<div class="form--info">
					<input style="text-transform:uppercase;" class="form-control" type="text" name="tip" placeholder="NOMBRE DE TIPIFICACIÓN" required>
				</div>	
				<div class="form--info--btn">
					<input class="btn btn-success" type="submit" value="GUARDAR">
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
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>