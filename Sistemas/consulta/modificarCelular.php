<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['num']);
$id_celular=$_GET['num'];
function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	// $sentencia =  "SELECT * FROM celular WHERE ID_CELULAR='".$no_tic."'";
	$sentencia =  "SELECT c.ID_CELULAR, c.IMEI, c.ID_USUARIO, c.ID_ESTADOWS, c.ID_PROVEEDOR, c.ID_MODELO, c.ID_PROCEDENCIA, lc.ID_LINEA, l.NRO 
	FROM celular c 
	left join lineacelular lc on c.ID_CELULAR=lc.ID_CELULAR 
	left join linea l on lc.ID_LINEA=l.ID_LINEA 
	WHERE c.ID_CELULAR='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_CELULAR'],/*0*/
		$filas['IMEI'],/*1*/
        $filas['ID_USUARIO'],/*2*/
        $filas['ID_ESTADOWS'],/*3*/
        $filas['ID_PROVEEDOR'],/*4*/
        $filas['ID_MODELO'],/*5*/
        $filas['ID_PROCEDENCIA'],/*6*/
		$filas['ID_LINEA'],/*7*/
		$filas['NRO']/*8*/
	];
}
$imei = $consulta[1];
$idUsuario = $consulta[2];
$idEstado = $consulta[3];
$idProveedor = $consulta[4];
$idModelo = $consulta[5];
$idProcendencia = $consulta[6];
$idLinea = $consulta[7];
$nrocelular = $consulta[8];

?>
<!DOCTYPE html>
<html>
<head>
	<title>MODIFICAR CELULAR</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<main>
	<div id="reporteEst">
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="./celulares.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
    </div>
	<section id="Inicio">
		<div id="titulo">
			<h1>MODIFICAR CELULAR</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
		<?php
			$sent= "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = $idUsuario";
			$resultado = $datos_base->query($sent);
			$row = $resultado->fetch_assoc();
			$usuario = $row['NOMBRE'];

			$sent= "SELECT ESTADO FROM estado_ws WHERE ID_ESTADOWS = $idEstado";
			$resultado = $datos_base->query($sent);
			$row = $resultado->fetch_assoc();
			$estado = $row['ESTADO'];

			$sent= "SELECT PROVEEDOR FROM proveedor WHERE ID_PROVEEDOR = $idProveedor";
			$resultado = $datos_base->query($sent);
			$row = $resultado->fetch_assoc();
			$proveedor = $row['PROVEEDOR'];

			$sent= "SELECT PROCEDENCIA FROM procedencia WHERE ID_PROCEDENCIA = $idProcendencia";
			$resultado = $datos_base->query($sent);
			$row = $resultado->fetch_assoc();
			$procedencia = $row['PROCEDENCIA'];

			$sent= "SELECT m.MODELO, ma.MARCA FROM modelo m LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA WHERE m.ID_MODELO = $idModelo";
			$resultado = $datos_base->query($sent);
			$row = $resultado->fetch_assoc();
			$modelo = $row['MODELO'];
			$marca = $row['MARCA'];

			$sent= "SELECT ID_MOVICEL, OBSERVACION FROM movicelular WHERE ID_CELULAR = $consulta[0] ORDER BY ID_MOVICEL DESC";
			$resultado = $datos_base->query($sent);
			$row = $resultado->fetch_assoc();
			$observaciones = $row['OBSERVACION'];
		?>
					<form method="POST" action="agregados.php">
						<div class="form-group row">
							<label id="lblForm"class="col-form-label col-xl col-lg">ID: </label>
							<input type="text" class="id" name="id" value="<?php echo $consulta[0]?>" style="background-color:transparent;" readonly>
						</div>
						
                        <div class="form-group row">
							<label id="lblForm"class="col-form-label col-xl col-lg">IMEI:</label>
							<input style="margin-top: 5px; text-transform:uppercase;cursor: default;" class="form-control col-form-label col-xl col-lg" type="text" name="imei" placeholder="IMEI" value="<?php echo $imei?>" required readonly>
						</div>
						<div class="form-group row">
							<label id="lblForm"class="col-form-label col-xl col-lg">USUARIO:</label>
								<select name="usuario" id="usuario" style="text-transform:uppercase" onchange="cargarLineas(this.value)" class="form-control col-xl col-lg" required>
								<option selected value="100"><?php echo $usuario;?></option>
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

						<div  class="form-group row">
<!-- 							<div id="divlineas" class="col-xl col-lg">
								<label id="lblForm"class="col-form-label col-xl col-lg">ASIGNADO A LINEA:</label>
								<div class="col-xl col-lg" >
									<input type="checkbox" class="chkLinea" name="checklinea" id="checklinea">
								</div>
							</div> -->

							<!-- <div id="lineasusuario" class="col-xl col-lg"> -->
							<label id="lblForm"class="col-form-label col-xl col-lg">LINEA:</label>
							<select name="linea" id="lineas" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
							</select>
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

                        <div class="form-group row">
							<label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:</label>
                            <select name="estado" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
							<option selected value="200"><?php echo $estado;?></option>
							<?php
                            include("../particular/conexion.php");
                            $consulta= "SELECT * FROM estado_ws ORDER BY ESTADO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?>
                            <option value="<?php echo $opciones['ID_ESTADOWS']?>"><?php echo $opciones['ESTADO']?></option>
							<?php endforeach ?>
                            </select>
						<div class="form-group row">
							
						</div>
                            <label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR:</label>
                            <select name="proveedor" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
							<option selected value="300"><?php echo $proveedor;?></option>
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

						<div class="form-group row">
							<label id="lblForm"class="col-form-label col-xl col-lg">MODELO:</label>
                            <select name="modelo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
							<option selected value="400"><?php echo $marca." - ".$modelo;?></option>
                            <?php
                            include("../particular/conexion.php");
                            $consulta= "SELECT m.MODELO, ma.MARCA, m.ID_MODELO
                            FROM modelo m
                            LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
							WHERE m.ID_TIPOP = 18
                            ORDER BY m.MODELO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?>
                                <option value="<?php echo $opciones['ID_MODELO']?>"><?php echo $opciones['MARCA']." - ".$opciones['MODELO']?></option>
                            <?php endforeach ?>
                            </select>
						</div>

						<div class="form-group row">
                            <label id="lblForm"class="col-form-label col-xl col-lg">PROCEDENCIA:</label>
                            <select name="procedencia" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
							<option selected value="500"><?php echo $procedencia;?></option>
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

						<div class="form-group row">
							<label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓN:</label>
                            <textarea class="form-control col-xl col-lg" name="obs" placeholder="OBSERVACIÓN" style="text-transform:uppercase" rows="3" ><?php echo $observaciones;?></textarea>
						</div>

						<div class="form-group row justify-content-end">
							<input style="width:20%" class="btn btn-success" type="submit" name="modificarCelular" value="MODIFICAR" class="button">
						</div>
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
	</main>
	<footer>
		<div class="footer">
			<div class="container-fluid">
				<div class="row">
					<img src="../imagenes/cba-logo.png" class="img-fluid">
				</div>
			</div>
		</div>
    </footer>
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
	// function cargarLineas() {
    //     var usuario = document.getElementById("usuario").value;
	// 	// alert(usuario)
    //     var xhr = new XMLHttpRequest();
    //     xhr.open("GET", "obtener_lineas.php?usuario=" + usuario, true);
    //     xhr.onreadystatechange = function () {
    //         if (xhr.readyState === 4 && xhr.status === 200) {
    //             document.getElementById("lineas").innerHTML = xhr.responseText;
    //         }
    //     };
    //     xhr.send();
    // }
</script>
<!--FUNCIONALIDAD EN JQUERY QUE PETICIONA A consultarLineasDisponibles.php las lineas sin celular asignado-->
<script>
    function cargarLineas(id_usuario, idcelular) {
        
        var parametros = {
            "idUsuario": id_usuario,
			"idCelular": idcelular
        };
        //LA VARIABLE BUSCAR UTILIZA EL ID CASO Y LA ENVIA AL SERVIDOR DE NOVEDADES///
        $.ajax({
            data: parametros,
            url: "../consulta/consultarLineasDisponibles.php",
            type: "POST",
            //TRAE DE FORMA ASINCRONA, CONSUME EL SERVIDOR DE NOVEDADES Y MUESTRA EN EL DIV MOSTRAR_MENSAJE TODAS LAS NOVEDADES RELACIONADAS////
            beforesend: function() {
                $("#lineas").html("Mensaje antes de Enviar");
            },

            success: function(mensaje) {
                $("#lineas").html(mensaje);
            }
        });
    };
    
    </script> 
	<script>cargarLineas(<?php echo $idUsuario;?>,<?php echo $id_celular;?>);</script>    
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>