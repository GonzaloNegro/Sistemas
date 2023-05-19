<?php 
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
?>
<!DOCTYPE html>
<html>
<head>
	<title>AGREGAR PLACA DE VIDEO</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoObrasPúblicas.png">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<style>
			body{
				background-color: #edf0f5;
			}
	</style>
</head>
<body>
    <div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="abmplacav.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
        <section id="Inicio">
		<div id="titulo" style="margin: 20px;">
			<h1>AGREGAR PLACA DE VIDEO</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
            <form method="POST" action="guardarmodplacav.php">
            <div class="form-group row" style="margin: 10px; padding:10px;">
                <label id="lblForm"class="col-form-label col-xl col-lg">MEMORIA:</label>
                <select name="memoria" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                        <option selected disabled="memoria">-SELECCIONE UNA-</option>
                        <?php
                        include("../particular/conexion.php");

                        $consulta= "SELECT * FROM memoria ORDER BY MEMORIA ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                            <option value="<?php echo $opciones['ID_MEMORIA']?>"><?php echo $opciones['MEMORIA']?></option>						
                    <?php endforeach ?>
                </select>

                <label id="lblForm"class="col-form-label col-xl col-lg">MODELO:</label>
                <select name="modelo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                        <option selected disabled="modelo">-SELECCIONE UNA-</option>
                        <?php
                        include("../particular/conexion.php");

                        $consulta= "SELECT * FROM modelo WHERE ID_TIPOP = 15 ORDER BY MODELO ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                            <option value="<?php echo $opciones['ID_MODELO']?>"><?php echo $opciones['MODELO']?></option>						
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group row" style="margin: 10px; padding:10px;">
                <label id="lblForm"class="col-form-label col-xl col-lg">TIPO MEMORIA:</label>
                <select name="tipo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                        <option selected disabled="tipo">-SELECCIONE UNA-</option>
                        <?php
                        include("../particular/conexion.php");

                        $consulta= "SELECT * FROM tipomem ORDER BY TIPOMEM ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                            <option value="<?php echo $opciones['ID_TIPOMEM']?>"><?php echo $opciones['TIPOMEM']?></option>						
                    <?php endforeach ?>
                </select>
            </div>

            <div class="row justify-content-end" style="margin: 10px; padding:10px;">
                <input style="width: 20%;"class="col-3 button" type="submit" value="GUARDAR" >
            </div>
        </form>
		</div>
	</section>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>