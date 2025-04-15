<?php
session_start();
error_reporting(0);
include('../particular/conexion.php');
if(!isset($_SESSION['cuil']))
    {
        header('Location: ../particular/Inicio.php');
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>AGREGAR CELULAR</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
			function ok(){
				swal(  {title: "Celular cargado correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='./celulares.php';
						}
						}
						);
			}
			</script>
<script type="text/javascript">
			function no(){
				swal(  {title: "El celular ya está registrado",
						icon: "error",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='./celulares.php';
						}
						}
						);
			}
			</script>
	<div id="reporteEst">
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="./celulares.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
    </div>
	<section id="Inicio">
		<div id="titulo" style="margin:20px;">
			<h1>AGREGAR CELULAR</h1>
		</div>
		<div id="principalr" style="width: 97%" class="container-fluid" data-aos="zoom-in">
						<form method="POST" action="agregados.php">

                        <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm"class="col-form-label col-xl col-lg">IMEI:</label>
							<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="imei" placeholder="IMEI" required>
							<label id="lblForm"class="col-form-label col-xl col-lg">USUARIO:</label>
								<select name="usuario" id="usuario" style="text-transform:uppercase" onchange="cargarLineas()" class="form-control col-xl col-lg" required>
								<option selected disabled="">-SELECCIONE UNA-</option>
								<?php
								include("../particular/conexion.php");
								$consulta= "SELECT * FROM usuarios WHERE ID_ESTADOUSUARIO = 1 ORDER BY NOMBRE ASC";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?>
									<option value="<?php echo $opciones['ID_USUARIO']?>"><?php echo $opciones['NOMBRE']?></option>
								<?php endforeach ?>
								</select>
                        </div>

						<div  class="form-group row" style="margin: 10px; padding:10px;">
<!-- 							<div id="divlineas" class="col-xl col-lg">
								<label id="lblForm"class="col-form-label col-xl col-lg">ASIGNADO A LINEA:</label>
								<div class="col-xl col-lg" >
									<input type="checkbox" class="chkLinea" name="checklinea" id="checklinea">
								</div>
							</div> -->

							<!-- <div id="lineasusuario" class="col-xl col-lg"> -->
							<label id="lblForm"class="col-form-label col-xl col-lg">LINEA:</label>
							<select name="linea" id="lineas" style="text-transform:uppercase" class="form-control col-xl col-lg" required><option value="" selected disabled>- SELECCIONE UNA OPCIÓN -</option></select>
							<!-- </div> -->
						</div>

						<!-- <option selected disabled="">-SELECCIONE UNA-</option>
							<?php
							// include("../particular/conexion.php");
							// $consulta= "SELECT * FROM linea l INNER JOIN lineacelular c on c.ID_LINEA=l.ID_LINEA where c.ID_USUARIO=2 AND C.ID_CELULAR=0";
							// $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
							// ?>
							<?php ## foreach ($ejecutar as $opciones): ?>
							 <option value="<?php ##echo $opciones['ID_LINEA']?>"><?php ##echo $opciones['NRO']?></option>
							<?php ## endforeach ?>
							 -->

                        <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:</label>
                            <select name="estado" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                            <option selected disabled="">-SELECCIONE UNA-</option>
                            <?php
                            include("../particular/conexion.php");
                            $consulta= "SELECT * FROM estado_ws ORDER BY ESTADO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?>
                                <option value="<?php echo $opciones['ID_ESTADOWS']?>"><?php echo $opciones['ESTADO']?></option>
                            <?php endforeach ?>
                            </select>

                            <label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR:</label>
                            <select name="proveedor" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                            <option selected disabled="">-SELECCIONE UNA-</option>
                            <?php
                            include("../particular/conexion.php");
                            $consulta= "SELECT * FROM proveedor WHERE ID_PROVEEDOR BETWEEN 34 AND 35 ORDER BY PROVEEDOR ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?>
                                <option value="<?php echo $opciones['ID_PROVEEDOR']?>"><?php echo $opciones['PROVEEDOR']?></option>
                            <?php endforeach ?>
                            </select>
                        </div>

						<div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">MODELO:</label>
                            <select name="modelo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                            <option selected disabled="">-SELECCIONE UNA-</option>
                            <?php
                            include("../particular/conexion.php");
                            $consulta= "SELECT m.MODELO, ma.MARCA, ID_MODELO
                            FROM modelo m
                            LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
							WHERE m.ID_TIPOP BETWEEN 17 AND 18
                            ORDER BY m.MODELO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?>
                                <option value="<?php echo $opciones['ID_MODELO']?>"><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                            <?php endforeach ?>
                            </select>

                            <label id="lblForm"class="col-form-label col-xl col-lg">PROCEDENCIA:</label>
                            <select name="procedencia" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                            <option selected disabled="">-SELECCIONE UNA-</option>
                            <?php
                            include("../particular/conexion.php");
                            $consulta= "SELECT * FROM procedencia WHERE ID_PROCEDENCIA = 3 OR ID_PROCEDENCIA = 6 ORDER BY PROCEDENCIA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?>
                                <option value="<?php echo $opciones['ID_PROCEDENCIA']?>"><?php echo $opciones['PROCEDENCIA']?></option>
                            <?php endforeach ?>
                            </select>
						</div>

						<div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓN:</label>
                            <textarea class="form-control col-xl col-lg" name="obs" placeholder="OBSERVACIÓN" style="text-transform:uppercase" rows="3" ></textarea>
						</div>
						<?php 
								if ($row['ID_PERFIL'] != 5) {
								echo '<div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
								<input style="width:20%" class="col-3 button" type="submit" name="agregarCelular" value="GUARDAR" class="button">
							</div>';
								}
							?>
						
					</form>
					<?php
				if(isset($_GET['ok'])){
					?>
					<script>ok();</script>
					<?php
				}
				if(isset($_GET['repeat'])){
					?>
					<script>repeat();</script>
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
	<script>
/* 	$(document).ready(function(){
    $("#usuario").change(function(){
		$("#checklinea").prop('checked', false);
		$("#lineasusuario").hide(0);
        $("#divlineas").show(1300);
    });

	$("#checklinea").change(function(){
        $("#lineasusuario").show(1300);
    });
    }); */
	function cargarLineas() {
        var usuario = document.getElementById("usuario").value;
		// alert(usuario)
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "obtener_lineas.php?usuario=" + usuario, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("lineas").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }
</script>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>