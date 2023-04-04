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
	<title>AGREGAR MONITOR</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoObrasPúblicas.png">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
			function ok(){
				swal(  {title: "Monitor cargado correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmmonitores.php';
						}
						}
						);
			}	
			</script>

<script type="text/javascript">
			function no(){
				swal(  {title: "El monitor ingresado ya está registrado",
						icon: "error",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='agregarmonitor.php';
						}
						}
						);
			}	
			</script>
		<div id="reporteEst" style="width: 97%; margin-left: 20px;">
				<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
					<a id="vlv"  href="abmmonitores.php" class="col-3 btn btn-primary "  type="button"  value="VOLVER">VOLVER</a>
				</div>					
		</div>
	<section id="Inicio">
		<div id="titulo" style="margin:20px;">
			<h1>AGREGAR MONITOR</h1>
		</div>
		<div id="principale" style="width: auto" class="container-fluid" data-aos="zoom-in">
						<form method="POST" action="guardarmodmonitor.php">

                        <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">TIPO MONITOR:</label>
                            <select name="tipop" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipop WHERE ID_TIPOP = 7 OR ID_TIPOP = 8 ORDER BY TIPO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOP'] ?>><?php echo $opciones['TIPO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm" class="col-form-label col-xl col-lg">N° GOBIERNO:</label> 
							<input class="form-control col-xl col-lg" placeholder="DEL MONITOR" style="text-transform:uppercase;" name="serieg" required>
                        </div>

                        <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">N° SERIE:</label> 
							<input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="serie" required>
                            <label id="lblForm"class="col-form-label col-xl col-lg">USUARIO:</label>
                                <select name="usu" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM usuarios ORDER BY NOMBRE ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_USUARIO'] ?>><?php echo $opciones['NOMBRE']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>    

                        <div class="form-group row" style="margin: 10px; padding:10px;"> 
                                <label id="lblForm"class="col-form-label col-xl col-lg">MODELO:</label>
                            <select name="mod" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                                    INNER JOIN tipop t ON t.ID_TIPOP = m.ID_TIPOP
                                    WHERE (m.ID_TIPOP = 7 OR m.ID_TIPOP = 8) ORDER BY MODELO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
                                <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:</label>
                            <select name="est" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM estado_ws ORDER BY ESTADO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_ESTADOWS'] ?>><?php echo $opciones['ESTADO']?></option>
                                    <?php endforeach?>
                                </select>
                        </div> 

                        <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">FACTURA:</label> 
							<input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="fac" placeholder="N° Factura">
                            <label id="lblForm" class="col-form-label col-xl col-lg">GARANTIA:</label> 
							<input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar" placeholder ="TIEMPO DE GARANTIA">
                        </div>


                        <div class="form-group row" style="margin: 10px; padding:10px;">

							<label id="lblForm"class="col-form-label col-xl col-lg" required>PROVEEDOR:</label>
                            <select name="prov" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓN:</label> 
                            <textarea class="form-control col-xl col-lg" name="obs" placeholder="Observación" style="text-transform:uppercase" rows="3"></textarea>
                        </div>

                        <div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
							<input style="width: 20%;"class="col-3 button" type="submit" value="GUARDAR MONITOR" class="button">
                        </div>    
					</form>
                    <?php
				if(isset($_GET['ok'])){
					?>
					<script>ok();</script>
					<?php			
				}
				if(isset($_GET['no'])){
					?>
					<script>no();</script>
					<?php			
				}
			?>
		</div>
	</section>
	<footer></footer>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>