<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM marcas WHERE ID_MARCA='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_MARCA'],/*0*/
		$filas['MARCA'],/*1*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>MODIFICAR MARCA</title>
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
	<div id="reporteEst" style="width: 97%; margin-left: 20px;">   
		<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
			<a id="vlv"  href="abmmarcas.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
		</div>					
	</div>

	<section id="Inicio">
		<div id="titulo" style="margin:20px;">
			<h1>MODIFICAR MARCA</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid">
            <form method="POST" action="guardarmodmarca2.php">
					<label id="lblForm"class="col-form-label col-xl col-lg">ID:</label>
					<input type="text" class="id" name="id" value="<?php echo $consulta[0]?>">
                    <!--//////////////////////////////////AREA//////////////////////////////////////-->
				<div class="form-group row" style="margin: 10px; padding:10px;">
                	<label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE DE LA MARCA: </label>
                	<input style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" type="text" name="marca" value="<?php echo $consulta[1]?>">
				</div>
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
				<div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
					<input style="width:20%"class="col-3 button" type="submit" value="MODIFICAR" class="button">
				</div>	
            </form>
	    </div>
	</section>
</body>
</html>