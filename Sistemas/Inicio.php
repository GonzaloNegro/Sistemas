<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Inicio</title><meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloinicio.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
	<header>
		<div id="titulo">
			<h2>SISTEMA DE INCIDENTES</h2>
		</div>
	</header>
	<section id="ingreso">
		<div id="sistemas">
			<h1>DIRECCIÓN DE SISTEMAS</h1>
		</div>
		<div id="ingresar">
			<form method="POST" action="validar.php">
				<h3>INICIAR SESIÓN</h3>
				<input type="text" name="cuil" placeholder="CUIL" required>
				<input type="password" name="clave" placeholder="CLAVE" required>
				<input type="submit" value="INGRESAR" class="button">
			</form>
			<?php
				if(isset($_GET['error'])){
					echo "<h4>CUIL O CONTRASEÑA INCORRECTA</h4>";
				}
			?>
		</div>
	</section>
	<footer>
			<div id="logo">
				<img src="imagenes/logoObrasPúblicas.png">
			</div>
			<div id="logogob">
				<img src="imagenes/logoGobierno.png">
			</div>
	</footer>
</body>
</html>