<?php 
session_start();
include('conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM area WHERE ID_AREA='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_AREA'],/*0*/
		$filas['AREA'],/*1*/
		$filas['ID_REPA'],/*2*/
        $filas['ACTIVO'],/*3*/
		$filas['OBSERVACION']/*4*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>MODIFICAR ÁREA</title>
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
			<a id="vlv"  href="abmarea.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
		</div>					
	</div>

	<section id="Inicio">
		<div id="titulo" style="margin:20px;">
			<h1>MODIFICAR ÁREA</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid">
                <?php 
                include("conexion.php");
                $sent= "SELECT REPA FROM reparticion WHERE ID_REPA = $consulta[2]";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $repa = $row['REPA'];
                ?>
                <form method="POST" action="guardarmodarea2.php">
                    <label>ID: </label>
                    <input type="text" class="id" name="id" value="<?php echo $consulta[0]?>">

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE DEL ÁREA: </label>&nbsp &nbsp
                        <input style="margin-top: 5px;text-transform:uppercase;" class="form-control col-form-label col-xl col-lg" type="text" name="area" value="<?php echo $consulta[1]?>">
                        
						<label id="lblForm"class="col-form-label col-xl col-lg">OBSERVACIONES:</label>
						<textarea class="form-control col-xl col-lg" name="obs" style="text-transform:uppercase" rows="3"><?php echo $consulta[4]?></textarea>
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                    <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:</label>
							<select name="estado" class="form-control col-xl col-lg" required>
                                    <option selected value="200"><?php echo $consulta[3]?></option>
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="INACTIVO">INACTIVO</option>
                                </select>
                    <label id="lblForm"class="col-form-label col-xl col-lg">REPARTICIÓN:</label>&nbsp &nbsp
                        <select name="repa" style="margin-top: 5px"class="form-control col-form-label col-xl col-lg">
                                        <option selected value="100"><?php echo $repa?></option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM reparticion";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_REPA'] ?>><?php echo $opciones['REPA']?></option>
                                        <?php endforeach?>
                                    </select>
				        </div>	
                    <div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
					<input style="width:20%"class="col-3 button" type="submit" value="MODIFICAR" class="button">
				</div>	
                </form>
	    </div>
	</section>
</body>
</html>