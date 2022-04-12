<?php 
error_reporting(0);
session_start();
include('conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM modelo WHERE ID_MODELO='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_MODELO'],/*0*/
		$filas['MODELO'],/*1*/
        $filas['ID_TIPOP'],/*2*/
        $filas['ID_MARCA'],/*3*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>MODIFICAR MODELOS</title>
    <link rel="icon" href="imagenes/logoObrasPúblicas.png">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloagregar.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<div id="reporteEst" style="width: 97%; margin-left: 20px;">   
				<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
					<a id="vlv"  href="abmmodelos.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
				</div>					
		</div>
	<section id="Inicio">
    <div id="titulo" style="margin: 20px;">
			<h1>MODIFICAR MODELO</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid">
                       <!--  CONSULTA DE DATOS -->
                        <?php 
                        include("conexion.php");
                        $sent= "SELECT TIPO FROM tipop WHERE ID_TIPOP = $consulta[2]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $tp = $row['TIPO'];?>
                        <?php 
                        include("conexion.php");
                        $sent= "SELECT MARCA FROM marcas WHERE ID_MARCA = $consulta[3]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $ma = $row['MARCA'];?>
                        <!--  CONSULTA DE DATOS -->

                <form method="POST" action="guardarmodelo2.php">
				    <label>ID: </label>
                    <input type="text" class="id" name="id" value="<?php echo $consulta[0]?>">
                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">NOMBRE DEL MODELO: </label>
                        <input class="form-control col-xl col-lg" type="text" name="modelo" value="<?php echo $consulta[1]?>">
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">MARCA: </label>
                        <select name="marca" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                        <option selected value="100"><?php echo $ma?></option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM marcas";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                        <?php endforeach?>
                        </select>
                        <label id="lblForm" class="col-form-label col-xl col-lg">TIPO: </label>
                        <select name="tipo" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                        <option selected value="200"><?php echo $tp?></option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM tipop";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_TIPOP'] ?>><?php echo $opciones['TIPO']?></option>
                                        <?php endforeach?>
                        </select>
                    </div>
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                    <div class="row justify-content-end" style="margin: 10px; padding:10px;">
                        <input style="width: 20%;"class="col-3 button" type="submit" value="MODIFICAR" >
                    </div>
                </form>
	    </div>
	</section>
</body>
</html>