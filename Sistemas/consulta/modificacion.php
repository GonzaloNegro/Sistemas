<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM ticket WHERE ID_TICKET='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_TICKET'],/*0*/
		$filas['FECHA_INICIO'],/*1*/
		$filas['USUARIO'],/*2*/
		$filas['DESCRIPCION'],/*3*/
		$filas['ID_ESTADO'],/*4*/
		$filas['ID_WS'],/*5*/
		$filas['FECHA_SOLUCION'],/*6*/
		$filas['ID_RESOLUTOR'],/*7*/
		$filas['ID_TIPIFICACION'],/*8*/
		$filas['ID_USUARIO']/*9*/
	];
}

if($consulta[4] != 3 AND $consulta[4] != 4){
	header("location: consultadetalle.php?no=$consulta[0]");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>MODIFICAR INCIDENTE</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estilomodificacion.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
	<div id="reporteEst" style="width: 97%; margin-left: 20px;">   
		<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
			<a id="vlv"  href="./consulta.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
		</div>					
	</div>
	<section id="ingreso">
		<div id="titulo" style="margin:5px;">
			<h1>MODIFICAR INCIDENTE</h1>
		</div>
		<?php 
            include("../particular/conexion.php");
            $sent= "SELECT ESTADO FROM estado WHERE ID_ESTADO = $consulta[4]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $est = $row['ESTADO'];
			?>
			<?php 
            include("../particular/conexion.php");
            $sent= "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = $consulta[7]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $nom = $row['RESOLUTOR'];
			?>
			<?php 
            include("../particular/conexion.php");
            $sent= "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = $consulta[9]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $usu = $row['NOMBRE'];
			?>
		<?php
		$des = $consulta[3];
		/*FECHAS*/
		$fecin = date("d-m-Y", strtotime($consulta[1]));
		?>
		<?php $guardar = $consulta[0]?>			
		
		<div id="principal" class="container-fluid" data-aos="zoom-in">
			<form method="POST" action="guardarmodificacion.php">

				<div class="form-group row" >
					<label id="lblForm"class="col-form-label col-xl col-lg">INCIDENTE NRO:</label>
					<input type="text" name="id_inc" class="id" value="<?php echo $consulta[0]?>" style="background-color:transparent;" readonly>
				</div>
				<!--/////////////////////////////////////FECHA INICIO///////////////////////////////////////////-->
				<!--/////////////////////////////////////FECHA INICIO///////////////////////////////////////////-->			
				<div class="form-group row" >
					<label id="lblForm"class="col-form-label col-xl col-lg">FECHA INICIO: </label>
					<input type="date" class="form-control col-xl col-lg" name="fecha_inicio" value="<?php echo $consulta[1]?>">
				</div>
				<!--/////////////////////////////////////USUARIO///////////////////////////////////////////-->
				<!--/////////////////////////////////////USUARIO///////////////////////////////////////////-->
				<div class="form-group row" >
				    <label id="lblForm"class="col-form-label col-xl col-lg">USUARIO:</label>
				    <select class="form-control col-xl col-lg" style="text-transform:uppercase"  name="usuario">
					<option selected value="150"><?php echo $usu?></option>
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

				<!--/////////////////////////////////////FECHA SOLUCION///////////////////////////////////////////-->
				<!--/////////////////////////////////////FECHA SOLUCION///////////////////////////////////////////-->
				<div class="form-group row" >
				    <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO: </label>
				    <select name="estado" class="form-control col-xl col-lg" style="text-transform:uppercase">
					<option selected value ="50"><?php echo $est?></option>
					<?php
					include("../particular/conexion.php");
					$consulta= "SELECT * FROM estado WHERE ID_ESTADO = 1 OR ID_ESTADO = 3 OR ID_ESTADO = 4 ORDER BY ESTADO ASC";
					$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
					?>
					<?php foreach ($ejecutar as $opciones): ?> 
						<option value="<?php echo $opciones['ID_ESTADO']?>"><?php echo $opciones['ESTADO']?></option>
					<?php endforeach ?>
					</select>
				</div>

				<div class="form-group row" >
				<?php $default_res = $consulta[7];?>
					<label id="lblForm"class="col-form-label col-xl col-lg">RESOLUTOR: </label>
					<select name="resolutor" class="form-control col-xl col-lg" style="text-transform:uppercase">
					<option selected value="100"><?php echo $nom?></option>
					<?php
					include("../particular/conexion.php");
					$consulta= "SELECT * FROM resolutor ORDER BY RESOLUTOR ASC";
					$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
					?>
					<?php foreach ($ejecutar as $opciones): ?> 
					<option value= <?php echo $opciones['ID_RESOLUTOR'] ?>><?php echo $opciones['RESOLUTOR']?></option>
					<?php endforeach?>
					</select>
				</div>
				<!--/////////////////////////////////////DESCRIPCION///////////////////////////////////////////-->
				<!--/////////////////////////////////////DESCRIPCION///////////////////////////////////////////-->	
				<div class="form-group row" >
					<label id="lblForm"class="col-form-label col-xl col-lg">DESCRIPCIÓN:</label>	
					<textarea class="form-control col-xl col-lg" name="descripcion" style="text-transform:uppercase"><?php echo $des?></textarea>			    
				</div>
				<!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
				<!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
				<div class="form-group row" >
					<label id="lblForm"class="col-form-label col-xl col-lg">MOTIVO:</label>
					<textarea class="form-control col-xl col-lg" rows="3" name="motivo" style="text-transform:uppercase" placeholder="MOTIVO DERIVACIÓN/SOLUCIÓN/ANULACIÓN"></textarea>
				</div>
				<!--////////////////////////////////////////////////////////////////////////////////-->
				<!--////////////////////////////////////////////////////////////////////////////////-->
				<div class="botones-mod">
					<input id="input" type="submit" style="color:white;" value="MODIFICAR" name="btnmod" class="btn btn-info">
					<input id="input" type="submit" value="SOLUCIONAR" name="btnsol" class="btn btn-success">
					<input id="input" type="submit" value="ANULAR INCIDENTE" name="btnan" class="btn btn-danger">
				</div>
			</form>
			<?php
				if(isset($_GET['mod'])){
					
					/*echo "<h3>Incidente cargado</h3>";*/?>
					<script>modificar();</script>
					<?php		
				}
		
				if(isset($_GET['sol'])){
					/*echo "<h3>Incidente cargado</h3>";*/?>
					<script>solucionar();</script>
					<?php			
				}

				if(isset($_GET['an'])){
					/*echo "<h3>Incidente cargado</h3>";*/?>
					<script>anular();</script>
					<?php			
				}
			?>
		</div>
	</section>
	<section id="movimientos">
		<div id="grilla">
			<h2>MOVIMIENTOS DEL TICKET</h2>
			<?php
				echo "<table width=100%>
						<thead>
							<tr>
								<th><p style='font-size:14px;text-align: center;min-width:100px;'>FECHA</p></th>
								<th><p style='font-size:14px;text-align: center;'>HORA</p></th>
								<th><p style='font-size:14px;text-align: left;margin-left:5px;'>RESOLUTOR</p></th>
								<th><p style='font-size:14px;text-align: left;margin-left:5px;'>ESTADO</p></th>
								<th><p style='font-size:14px;text-align: left;margin-left:5px;'>MOTIVO</p></th>
							</tr>
						</thead>";

						$sql = mysqli_query($datos_base, "SELECT * from fecha_ticket WHERE ID_TICKET = '$guardar'");
						while($listar2 = mysqli_fetch_array($sql)){
							$resa = $listar2['ID_FECHA'];


						$consulta=mysqli_query($datos_base, "SELECT * from fecha WHERE ID_FECHA = '$resa'");
						while($listar = mysqli_fetch_array($consulta))
						{
							$opcion = $listar['ID_ESTADO'];
								$sent= "SELECT ESTADO FROM estado WHERE ID_ESTADO = $opcion";
								$resultado = $datos_base->query($sent);
								$row = $resultado->fetch_assoc();
								$est = $row['ESTADO'];
								
								$opcion = $listar['ID_RESOLUTOR'];
								$sent= "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = $opcion";
								$resultado = $datos_base->query($sent);
								$row = $resultado->fetch_assoc();
								$nom = $row['RESOLUTOR'];

								$fecord = date("d-m-Y", strtotime($listar['FECHA_HORA']));

							echo "
								<tr>
									<td><h5 style='font-size:14px;text-align: center;'>".$fecord."</h5></td>
									<td><h5 style='font-size:14px;text-align: center;'>".$listar['HORA']."</h5></td>
									<td><h5 style='font-size:14px;text-align: left;margin-left:5px;'>".$nom."</h5></td>
									<td><h5 style='font-size:14px;text-align: left;margin-left:5px;'>".$est."</h5></td>
									<td><h5 style='font-size:14px;text-align: left;margin-left:5px;text-transform:uppercase;'>".$listar['MOTIVO']."</h5></td>
								</tr>";
						}}
					echo "</table>";
			?>
		</div>
	</section>
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>