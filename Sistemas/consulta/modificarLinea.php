<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['num']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM linea WHERE ID_LINEA='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_LINEA'],/*0*/
		$filas['NRO'],/*1*/
        $filas['ID_ESTADOWS'],/*2*/
        $filas['ID_PLAN'],/*3*/
        $filas['DESCUENTO'],/*4*/
        $filas['FECHADESCUENTO'],/*5*/
        $filas['ID_NOMBREPLAN'],/*6*/
        $filas['ID_ROAMING'],/*7*/
	];
}
$idLinea= $consulta[0];
$idEstado = $consulta[2];
$idPlan = $consulta[3];
$descuento = $consulta[4];
$fechaDescuento = $consulta[5];
$idNombrePlan = $consulta[6];
$idRoaming = $consulta[7];
?>
<!DOCTYPE html>
<html>
<head>
	<title>MODIFICAR LINEA</title><meta charset="utf-8">
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
            <a id="vlv"  href="./MontosLineas.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
		<div id="titulo">
			<h1>MODIFICAR LINEA</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
				<?php 
                include("../particular/conexion.php");
                $sent= "SELECT ESTADO FROM estado_ws WHERE ID_ESTADOWS = $idEstado";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $estado = $row['ESTADO'];

				$sent= "SELECT n.NOMBREPLAN, p.PLAN, l.ID_LINEA, pr.PROVEEDOR
				FROM linea l
				INNER JOIN nombreplan n ON n.ID_NOMBREPLAN = l.ID_NOMBREPLAN
				INNER JOIN plan p ON p.ID_PLAN = n.ID_PLAN
				inner join proveedor pr on pr.ID_PROVEEDOR=n.ID_PROVEEDOR
				WHERE l.ID_LINEA = $idLinea";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $nombrePlan = $row['NOMBREPLAN'];
                $plan = $row['PLAN'];
				$prove = $row['PROVEEDOR'];

				$sent= "SELECT ROAMING FROM roaming WHERE ID_ROAMING = $idRoaming";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $roaming = $row['ROAMING'];

				$sent= "SELECT ID_USUARIO, ID_MOVILINEA, EXTRAS, OBSERVACION FROM movilinea WHERE ID_LINEA = $consulta[0] ORDER BY ID_MOVILINEA DESC";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $extras = $row['EXTRAS'];
                $observaciones = $row['OBSERVACION'];
                $idUsuario = $row['ID_USUARIO'];

				$sent= "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = $idUsuario";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $usuario = $row['NOMBRE'];
                ?>
			<form method="POST" action="modificados.php">
			<!-- <form method="POST" action="modificarLinea.php"> -->
				<div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">ID:</label>
                    <input type="text" class="id" name="id" value="<?php echo $idLinea?>" style="background-color:transparent;" readonly>
                </div>
				
				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">NÚMERO:</label>
					<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="number" name="nro" id="cardnumber" value="<?php echo $consulta[1]?>" required readonly>
				</div>

				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">USUARIO:</label>
						<select name="usuario" id="usuario" style="text-transform:uppercase" onchange="cargarCelulares(this.value)" class="form-control col-xl col-lg" required>
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

				<div class="form-group row">
<!-- 					<div id="divCelulares" class="col-xl col-lg" style="display:none">
					<label id="lblForm"class="col-form-label col-xl col-lg">ASIGNANDO A CELULAR:</label>
					<div class="col-xl col-lg" >
						<input type="checkbox" class="chkLinea" id="checkCelular">
					</div>
					</div> -->

					<!-- <div id="celularesusuario" style="display:none" class="col-xl col-lg"> -->
						<label id="lblForm"class="col-form-label col-xl col-lg">CELULAR:</label>
						<select name="celular" id="celulares" style="text-transform:uppercase" class="form-control col-xl col-lg"><option value="" selected disabled>- SELECCIONE UNA OPCIÓN -</option></select>
					<!-- </div> -->
				</div>
				
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
				</div>
					
				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">ROAMING:</label>
					<select name="roaming" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
					<option selected value="400"><?php echo $roaming;?></option>
					<?php
					include("../particular/conexion.php");
					$consulta= "SELECT * FROM roaming ORDER BY ROAMING";
					$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
					?>
					<?php foreach ($ejecutar as $opciones): ?> 
					<option value="<?php echo $opciones['ID_ROAMING']?>"><?php echo $opciones['ROAMING']?></option>
					<?php endforeach ?>
					</select>
				</div>
				
				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">DESCUENTO:</label>
					<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="number" name="descuento" step="0.01" placeholder="10,00" required value="<?php echo $descuento?>">
				</div>
					
				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">FECHA DESCUENTO:</label>
					<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="date" name="fechaDescuento" value="<?php echo $fechaDescuento?>">
				</div>

				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE PLAN:</label>
					<select name="nombrePlan" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
					<option selected value="300"><?php echo $nombrePlan." - ".$plan." - ".$prove;?></option>
					<?php
					include("../particular/conexion.php");
					$consulta= "SELECT n.NOMBREPLAN, p.PLAN, n.ID_NOMBREPLAN, pr.PROVEEDOR
					FROM nombreplan n
					INNER JOIN plan p ON p.ID_PLAN = n.ID_PLAN
					inner join proveedor pr on n.ID_PROVEEDOR=pr.ID_PROVEEDOR
					ORDER BY n.nombreplan";
					$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
					?>
					<?php foreach ($ejecutar as $opciones): ?> 
					<option value= <?php echo $opciones['ID_NOMBREPLAN'] ?>><?php echo $opciones['NOMBREPLAN'].' - '.$opciones['PLAN'].' - '.$opciones['PROVEEDOR']?></option>
					<?php endforeach ?>
					</select>
				</div>  


				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">EXTRAS:<span style="color:red;">*</span></label>
					<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="number" name="extras" step="0.01" placeholder="1500,00" value="<?php echo $extras?>" required>
				</div>  
				
				<div class="form-group row">
					<label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓN:</label> 
					<textarea class="form-control col-xl col-lg" name="obs" placeholder="OBSERVACIÓN" style="text-transform:uppercase" rows="3" ><?php echo $observaciones;?></textarea>
				</div> 

				<div class="form-group row justify-content-end">
					<input style="width:20%"class="btn btn-success" type="submit" name="modificarLinea" value="MODIFICAR" class="button">
				</div>	
				<p style="color:red;text-align:left;font-size:14px;">* Al ingresar los extras de Personal, al precio que sale en la factura agregar el iva y con Claro se ingresa tal cual figura</p>
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
		$("#checkCelular").prop('checked', false);
		$("#celularesusuario").hide(0);
        $("#divCelulares").show(1300);
    });

	$("#checkCelular").change(function(){
        $("#celularesusuario").show(1300);
    });
    }); */
	// function cargarLineas() {
    //     var usuario = document.getElementById("usuario").value;
	// 	// alert(usuario)
    //     var xhr = new XMLHttpRequest();
    //     xhr.open("GET", "obtener_celulares.php?usuario=" + usuario, true);
    //     xhr.onreadystatechange = function () {
    //         if (xhr.readyState === 4 && xhr.status === 200) {
    //             document.getElementById("celulares").innerHTML = xhr.responseText;
    //         }
    //     };
    //     xhr.send();
    // }
</script>
<!--FUNCIONALIDAD EN JQUERY QUE PETICIONA A consultarDatosLinea.php los detalles de la linea-->
<script>
    function cargarCelulares(id_usuario, idlinea) {
        
        var parametros = {
            "idUsuario": id_usuario,
			"idLinea": idlinea
        };
        //LA VARIABLE BUSCAR UTILIZA EL ID usuario Y LA ENVIA AL consultarcelulares disponibles///
        $.ajax({
            data: parametros,
            url: "../consulta/consultarCelularesDisponibles.php",
            type: "POST",
            //TRAE DE FORMA ASINCRONA, CONSUME EL SERVIDOR DE NOVEDADES Y MUESTRA EN EL DIV MOSTRAR_MENSAJE TODAS LAS NOVEDADES RELACIONADAS////
            beforesend: function() {
                $("#celulares").html("Mensaje antes de Enviar");
            },

            success: function(mensaje) {
                $("#celulares").html(mensaje);
            }
        });
    };
    
    </script> 
	<script>cargarCelulares(<?php echo $idUsuario;?>,<?php echo $idLinea;?>);</script>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>