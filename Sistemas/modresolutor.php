<?php 
error_reporting(0);
session_start();
include('conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM resolutor WHERE ID_RESOLUTOR='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_RESOLUTOR'],/*0*/
		$filas['RESOLUTOR'],/*1*/
		$filas['ID_TIPO_RESOLUTOR'],/*2*/
        $filas['CUIL'],/*3*/
        $filas['CORREO'],/*4*/
        $filas['TELEFONO'],/*5*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>MODIFICAR RESOLUTOR</title>
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
					<a id="vlv"  href="abmresolutor.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
				</div>					
		</div>
	<section id="Inicio">
    <div id="titulo" style="margin: 20px;">
			<h1>MODIFICAR RESOLUTOR</h1>
		</div>
        <?php 
                        include("conexion.php");
                        $sent= "SELECT TIPO_RESOLUTOR FROM tipo_resolutor WHERE ID_TIPO_RESOLUTOR = $consulta[2]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $tr = $row['TIPO_RESOLUTOR'];?>
		<div id="principalu" style="width: 97%" class="container-fluid">
                <form method="POST" action="guardarmodresolutor2.php">
                    <label>ID: </label>&nbsp &nbsp 
                    <input type="text" class="id" name="id" value="<?php echo $consulta[0]?>">

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">NOMBRE: </label>
                        <input class="form-control col-xl col-lg" style="text-transform:uppercase;" type="text" name="nom" value="<?php echo $consulta[1]?>">
                        <label id="lblForm" class="col-form-label col-xl col-lg">CUIL: </label>
                        <input class="form-control col-xl col-lg" type="text" name="cuil" value="<?php echo $consulta[3]?>">
                   </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">CORREO: </label>
                        <input class="form-control col-xl col-lg" type="text" name="cor" value="<?php echo $consulta[4]?>">
                        <label id="lblForm" class="col-form-label col-xl col-lg">TELEFONO: </label>
                        <input class="form-control col-xl col-lg" type="text" name="tel" value="<?php echo $consulta[5]?>">
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">TIPO DE RESOLUTOR:</label>
                        <select name="tipo" class="form-control col-xl col-lg">
                                        <option selected value="100"><?php echo $tr?></option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM tipo_resolutor";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_TIPO_RESOLUTOR'] ?>><?php echo $opciones['TIPO_RESOLUTOR']?></option>
                                        <?php endforeach?>
                        </select>
                    </div>
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                    <div class="row justify-content-end" style="margin: 10px; padding:10px;">
                        <input style="width: 20%;"class="col-3 button" type="submit" value="MODIFICAR">
                    </div>
                </form>
	    </div>
	</section>
</body>
</html>