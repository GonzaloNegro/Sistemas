<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>CAMBIAR CONTRASEÑA</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estilocontraseña.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
			<script type="text/javascript">
			function done(){
				swal("Constraseña cambiada!", "Se ha actualizado tu contraseña!", "success");
			}	</script>
			<script>
			function error(){
				swal("Cuil o contraseña incorrecta!", "Por favor revise los datos ingresados!", "error");
			}	
			</script>
		<main>
			<section id="inicio"> 
				<div id="reporteEst">   
					<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
						<a id="vlv"  href="../consulta/consulta.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
					</div>					
				</div>
				<div id="titulo">
					<h1>CAMBIAR CONTRASEÑA</h1>
				</div>
				<div id="ingresar" class="container-fluid">
					<form method="POST" action="cambiar.php">
						<div class="form-group row" style="margin-top:10px; margin-left:5px; margin-right:5px;"><input class="form-control" type="text" name="cuil" placeholder="CUIL" required></div>
						<div class="form-group row" style="margin-top:10px; margin-left:5px; margin-right:5px;"><input class="form-control" type="password" name="vieja" placeholder="CLAVE ACTUAL" required></div>
						<div class="form-group row" style="margin-top:10px; margin-left:5px; margin-right:5px;"><input class="form-control" type="password" name="nuevaclave" placeholder="CLAVE NUEVA" required></div>
						<div style="margin-top:45px; margin-left:5px; margin-right:5px;"><input type="submit" class="btn btn-success" value="CAMBIAR" onclick="mostrar()"></div>
					</form>
					<?php
						if(isset($_GET['ok'])){
							/*echo "<h4>CONTRASEÑA CAMBIADA</h4>";*/?>
							<script>done();</script>
							<?php
						}
						if(isset($_GET['error'])){
							/*echo "<h4>CUIL O CONTRASEÑA INCORRECTA</h4>";*/?>
							<script>error();</script>
							<?php
						}
					?>
				</div>
				<div id="volver" style="margin-top: 40px; margin-right:480px;">
					<a href="../consulta/consulta.php"><h2><u>Volver</u></h2>
				</div>
			</section>
		</main>
	<footer>
		<div class="footer">
			<div class="container-fluid">
				<div class="row">
					<img src="../imagenes/cba-logo.png" class="img-fluid">
				</div>
			</div>
		</div>
	</footer>
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>