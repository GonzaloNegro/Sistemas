<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT CUIL, RESOLUTOR FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();


$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM stockdisco WHERE ID_STOCKDISCO='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_STOCKDISCO'],/*0*/
		$filas['ID_TIPOD'],/*1*/
        $filas['ID_DISCO'],/*2*/
        $filas['CANTIDAD']/*3*/
	];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>MODIFICAR DISCO</title>
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
	<div id="reporteEst" style="width: 97%; margin-left: 20px;">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="./stockdisco.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
        </div>					
	</div>
    <section id="Inicio">
		<div id="titulo" style="margin: 20px;">
			<h1>MODIFICAR DISCO</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
        <?php
            $sent= "SELECT TIPOD FROM tipodisco WHERE ID_TIPOD = $consulta[1]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $tipo = $row['TIPOD'];

            $sent= "SELECT DISCO FROM disco WHERE ID_DISCO = $consulta[2]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $cap = $row['DISCO'];

            $sent= "SELECT CANTIDAD FROM stockdisco WHERE ID_STOCKDISCO = $consulta[0]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $cant = $row['CANTIDAD'];
            ?>
            <form method="POST" action="./guardarmodstockdisco.php">
                <label>ID: </label>
                <input type="text" class="id" name="id" value="<?php echo $consulta[0]?>">
                <div class="form-group row" style="margin: 10px; padding:10px;">
                    <label id="lblForm"class="col-form-label col-xl col-lg">CAPACIDAD:</label>
                    <select name="cap" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                        <option selected value="100"><?php echo $cap?></option>
						<?php
						$consulta= "SELECT * FROM disco ORDER BY DISCO ASC";
						$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
						?>
						<?php foreach ($ejecutar as $opciones): ?> 
							<option value="<?php echo $opciones['ID_DISCO']?>"><?php echo $opciones['DISCO']?></option>						
						<?php endforeach ?>
                	</select>
					<label id="lblForm" class="col-form-label col-xl col-lg">CANTIDAD:</label> 
					<input type="number" min="0" class="form-control col-xl col-lg" name="cant" value="<?php echo $cant;?>">
                </div>

                <div class="form-group row" style="margin: 10px; padding:10px;">
                    <label id="lblForm"class="col-form-label col-xl col-lg">TIPO MEMORIA:</label>
                    <select name="tipo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                        <option selected value="200"><?php echo $tipo?></option>
                        <?php
                        $consulta= "SELECT * FROM tipodisco ORDER BY TIPOD ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                        <option value="<?php echo $opciones['ID_TIPOD']?>"><?php echo $opciones['TIPOD']?></option>						
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="row justify-content-end" style="margin: 10px; padding:10px;">
                    <input style="width: 20%;"class="col-3 button" type="submit" value="GUARDAR" >
                </div>
            </form>
		</div>
	</section>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>