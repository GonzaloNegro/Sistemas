<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Inicio</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloinicio.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
			function no(){
				Swal.fire({
					icon: "error",
					title: "Contraseña o Usuario incorrecto",
                    confirmButtonColor: '#3085d6',
					});
								}	
			</script>

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
				<input type="number" name="cuil" placeholder="CUIL" required max="99999999999" oninput="if(this.value.length > 11) this.value = this.value.slice(0, 11)">
				<input type="password" name="clave" placeholder="CLAVE" required>
				<input type="submit" value="INGRESAR" class="button">
			</form>
			<div id="resetpwd">
			<a href="olvidecontraseña.php" class="enlaces">olvide mi contraseña</a>
			</div>
			<?php
				// if(isset($_GET['error'])){
				// 	echo "<h4>CUIL O CONTRASEÑA INCORRECTA</h4>";
				// }
				if(isset($_GET['error'])){
					?>
					<script>no();</script>
					<?php			
				}
			?>
		</div>
	</section>
	<footer>
			<div id="logo">
				<img src="../imagenes/logoInfraestructura.png">
			</div>
			<div id="logogob">
				<img src="../imagenes/cba-logo.png">
			</div>
	</footer>
</body>
</html>