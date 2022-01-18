<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Cambiar contraseña</title><meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estilocontraseña.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
	<header>
		<div id="titulo" style="margin: 30px;">
			<h1>CAMBIAR CONTRASEÑA</h1>
		</div>
	</header>
	<section id="ingreso"> 
		<div id="ingresar" style="width: 350px; height: 320px;" class="container-fluid">
			<form method="POST" action="cambiar.php">
				<div class="form-group row" style="margin-top:10px; margin-left:5px; margin-right:5px;"><h3 style="padding:10px;">CAMBIAR CONTRASEÑA</h3></div>
				<div class="form-group row" style="margin-top:10px; margin-left:5px; margin-right:5px;"><input class="form-control" type="text" name="cuil" placeholder="CUIL" required></div>
				<div class="form-group row" style="margin-top:10px; margin-left:5px; margin-right:5px;"><input class="form-control" type="password" name="vieja" placeholder="CLAVE ACTUAL" required></div>
				<div class="form-group row" style="margin-top:10px; margin-left:5px; margin-right:5px;"><input class="form-control" type="password" name="nuevaclave" placeholder="CLAVE NUEVA" required></div>
				<div class="form-group row justify-content-center" style="margin-top:45px; margin-left:5px; margin-right:5px;"><input type="submit" class="col-6 button" value="CAMBIAR" onclick="mostrar()"></div>
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
            <a href="cargadeincidentes.php"><h2><u>Volver</u></h2>
        </div>
	</section>
</body>
</html>