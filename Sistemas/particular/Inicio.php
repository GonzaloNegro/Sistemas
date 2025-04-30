<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Inicio</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
			</div>
		</header>
		<section class="ingreso">
			<div class="sistemas">
				<div>
					<h1>Sistema Integral de Gestión, Soporte y Mantenimiento</h1>
					<h2>Dirección de Sistemas</h2>
			</div>

			<div class="ingresar">
				<form method="POST" action="validar.php">
					<h3>Iniciar Sesión</h3>
					<input type="number" name="cuil" placeholder="Cuil" oninput="if(this.value.length > 11) this.value = this.value.slice(0, 11)">
					<input type="password" name="clave" placeholder="Calve" required>
					<input type="submit" value="Ingresar" class="btn btn-success button">
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
		</div>
	</section>
	<footer>
			<div class="logo">
				<img src="../imagenes/logoInfraestructura.png">
			</div>
			<div class="logogob">
				<img src="../imagenes/cba-logo.png">
			</div>
	</footer>
	<script>
	window.onload = function() {
		const loader = document.getElementById('loader');
		loader.style.display = 'none';
		};
	</script>

	<script>
		window.onload = function() {
			setTimeout(() => {
				const loader = document.getElementById('loader');
				loader.style.opacity = '0';
				loader.style.transition = 'opacity 0.3s ease';
				setTimeout(() => loader.style.display = 'none', 300);
			}, 1500); // Espera 1 segundo completo
		};
	</script>

</body>
	<div id="loader">
		<div class="loader-content">
			<div class="loader-spinner"></div>
			<p class="loader-text">Cargando...</p>
		</div>
	</div>

</html>