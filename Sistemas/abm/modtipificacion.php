<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM tipificacion WHERE ID_TIPIFICACION='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_TIPIFICACION'],/*0*/
		$filas['TIPIFICACION'],/*1*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
<title>MODIFICAR TIPIFICACIÓN</title>
<link rel="icon" href="../imagenes/logoObrasPúblicas.png">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
	<div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="abmtipificacion.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
    <div id="titulo">
			<h1>MODIFICAR TIPIFICACIÓN</h1>
		</div>
		<div id="principal">
			<form method="POST" action="guardarmodtipificacion2.php">
				<label>ID: </label>
				<input type="text" class="id" name="id" value="<?php echo $consulta[0]?>" readonly>
				<div class="form--info">
					<input style="text-transform:uppercase;" class="form-control"  type="text" name="tip" value="<?php echo $consulta[1]?>">
				</div>	
				<div class="form--info--btn">
					<input class="btn btn-success" type="submit" value="MODIFICAR" >
				</div>
			</form>
	    </div>
	</section>
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>