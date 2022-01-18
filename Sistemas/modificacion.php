<?php 
session_start();
include('conexion.php');

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
		$filas['NRO_EQUIPO'],/*5*/
		$filas['FECHA_SOLUCION'],/*6*/
		$filas['ID_RESOLUTOR']/*7*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estilomodificacion.css">
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
<header>
	<div class="container">
		<div id="titulo">
			<h1>MODIFICAR INCIDENTE N°: <?php echo $consulta[0] ?></h1>
		</div>
	</header>
	<section id="ingreso">
		<div id="ingresar">
		<?php $opcion = $consulta[4];
			switch ($opcion) 
			{
				case 0:
					$est = "SIN ESTADO";
					break;
				case 1:
					$est = "SUSPENDIDOO";
					break;
				case 2:
					$est = "SOLUCIONADO";
					break;
				case 3:
					$est = "DERIVADO";
					break;
				case 4:
					$est = "EN PROCESO";
					break;
				case 5:
					$est = "ANULADO";
					break;
			}	
			$opcion = $consulta[7];
			switch ($opcion) 
			{		
				case 1:
					$nom = "APOYO TÉCNICO - FINANZAS";
					break;
				case 2:
					$nom = "CLAUDIA VILLEGAS";
					break;
				case 3:
					$nom = "EDUARDO CICARDINI";
					break;
				case 4:
					$nom = "ENRIQUE BARRANCO";
					break;
				case 5:
					$nom = "GABRIEL RENELLA";
					break;
				case 6:
					$nom = "GONZALO NEGRO";
					break;
				case 7:
					$nom = "JULIO DIAZ";
					break;
				case 8:
					$nom = "MACRO SEGURIDAD";
					break;
				case 9:
					$nom = "MACROX";
					break;
				case 10:
					$nom = "MARIA JUAREZ";
					break;
				case 11:
					$nom = "MESA DE AYUDA";
					break;
				case 12:
					$nom = "OPERACIONES SSIT";
					break;
				case 13:
					$nom = "PAMELA TUSSETTO";
					break;
				case 14:
					$nom = "PROVEEDOR EXTERNO";
					break;
				case 15:
					$nom = "RODRIGO CESTAFE";
					break;
				case 16:
					$nom = "SOPORTE INTERNO";
					break;
				case 17:
					$nom = "SOPORTE POP";
					break;
				case 18:
					$nom = "SOPORTE TÉCNICO";
					break;
				case 19:
					$nom = "YANINA RE";
					break;					
		}

		$des = $consulta[3];
		$usu = $consulta[2];
		$nro = $consulta[5];

		/*FECHAS*/
		$fecin = date("d-m-Y", strtotime($consulta[1]));

		/*$fecha = "0000-00-00";
		if($consulta[6] == $fecha)
		{
		$consulta[6] = "-";
		$fecfin = $consulta[6];
		}
		else{
			$fecfin = date("d/m/Y", strtotime($consulta[6]));
		}
		*/
		?>
	
			<h3 id="h3">DATOS DEL INCIDENTE</h3><br>
			<?php $guardar = $consulta[0]?>
			<div class="form-group row">
			<h4 id="h4"><u>FECHA INICIO:</u> <?php echo $fecin ?>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</h4>
			<h4 id="h4"><u>USUARIO:</u> <?php echo $usu?>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</h4>
			<h4 id="h4"><u>DESCRIPCIÓN:</u> <?php echo $consulta[3] ?>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</h4>
			<h4 id="h4"><u>ESTADO:</u> <?php echo $est ?>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</h4>
	        </div>
			<h4 id="h4"><u>NRO EQUIPO:</u> <?php echo $consulta[5] ?>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</h4>
			<h4 id="h4"><u>FECHA DE SOLUCION:</u> <?php 
			
			$fecha = "0000-00-00";
			if($consulta[6] == $fecha)
			{
				echo "-";
			}
			else
			{
				$fecfin = date("d-m-Y", strtotime($consulta[6]));
				echo $fecfin;
			}
			?></h4>
			<h4 id="h4"><u>RESOLUTOR:</u> <?php echo $nom?></h4><br><br><br><br>

				<a id="vlv" href="consulta.php" class="btn btn-primary">VOLVER</a>

		</div>
		<div id="modif" class="container-fluid">
			<form method="POST" action="guardarmodificacion.php">
			<h3 id="h3" style="margin-bottom: 20px;">MODIFICAR DATOS DEL INCIDENTE NRO: <input type="text" name="id_inc" class="id"  value="<?php echo $consulta[0]?>"></h3>
				<!--/////////////////////////////////////FECHA INICIO///////////////////////////////////////////-->
				<!--/////////////////////////////////////FECHA INICIO///////////////////////////////////////////-->			
				<div class="form-group row" style="margin-right: 17px;">
					<label class="col-form-label col-xl col-lg">FECHA INICIO: </label>
					<input type="date" class="form-control col-xl col-lg" name="fecha_inicio" value="<?php echo $consulta[1]?>">
				    <!--/////////////////////////////////////USUARIO///////////////////////////////////////////-->
				    <!--/////////////////////////////////////USUARIO///////////////////////////////////////////-->
				    <label class="col-form-label col-xl col-lg">USUARIO:</label>
				    <select class="form-control col-xl col-lg"   name="usuario">
									<option selected value="<?php echo $consulta[2]?>"><?php echo $consulta[2]?></option>
									<?php
									include("conexion.php");
									$consulta= "SELECT * FROM usuarios ORDER BY NOMBRE ASC";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
										<option value="<?php echo $opciones['NOMBRE']?>"><?php echo $opciones['NOMBRE']?></option>
									<?php endforeach ?>
					</select>
				</div>
				<br>
				<!--/////////////////////////////////////DESCRIPCION///////////////////////////////////////////-->
				<!--/////////////////////////////////////DESCRIPCION///////////////////////////////////////////-->				
				<div class="form-group row" style="margin-right: 17px;">
					<label class="col-form-label col-xl col-lg">DESCRIPCIÓN: <textarea class="form-control col-xl col-lg" name="descripcion" style="text-transform:uppercase"><?php echo $des?></textarea></label>
				    
				</div>
					<br>
				<!--/////////////////////////////////////FECHA SOLUCION///////////////////////////////////////////-->
				<!--/////////////////////////////////////FECHA SOLUCION///////////////////////////////////////////-->
				<div class="form-group row" style="margin-right: 17px;">
					<label class="col-form-label col-xl col-lg">FECHA SOLUCIÓN: </label>
				    <input class="form-control col-xl col-lg" type="date" name="fecha_solucion" value="<?php echo $fecfin?>">
				    <!--/////////////////////////////////////ESTADO///////////////////////////////////////////-->
				    <!--/////////////////////////////////////ESTADO///////////////////////////////////////////-->
				    <label class="col-form-label col-xl col-lg">ESTADO: </label>
				    <select name="estado" class="form-control col-xl col-lg">
									<option selected value ="50"><?php echo $est?></option>
									<?php
									include("conexion.php");
									$consulta= "SELECT * FROM estado ORDER BY ESTADO ASC";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
										<option value="<?php echo $opciones['ID_ESTADO']?>"><?php echo $opciones['ESTADO']?></option>
									<?php endforeach ?>
								</select>
			    </div>				
								<br>
				<!--/////////////////////////////////////RESOLUTOR///////////////////////////////////////////-->
				<!--/////////////////////////////////////RESOLUTOR///////////////////////////////////////////-->
				<div class="form-group row" style="margin-right: 17px;">
				<?php $default_res = $consulta[7];?>
				<label class="col-form-label col-xl col-lg">RESOLUTOR: 

							<!--<option value='<?php/* echo $default_res*/?>' selected='selected'></*?php echo $nom*/?></option>-->

							<!--<option value="-1"><?php/* echo $nom*/?></option>
							<option value="1">APOYO TECNICO MINISTERIO DE FINANZAS</option>
							<option value="2">CLAUDIA VILLEGAS</option>
							<option value="3">EDUARDO CICARDINI</option>
							<option value="4">ENRIQUE BARRANCO </option>
							<option value="5">GABRIEL RENNELLA</option>
							<option value="6">GONZALO NEGRO</option>
							<option value="7">JULIO DIAZ</option>
							<option value="8">MARIA JUAREZ</option>-->
				</label>
				<select name="resolutor" class="form-control col-xl col-lg">
								<option selected value="100"><?php echo $nom?></option>
								<?php
								include("conexion.php");
								$consulta= "SELECT * FROM resolutor ORDER BY RESOLUTOR ASC";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?> 
								<option value= <?php echo $opciones['ID_RESOLUTOR'] ?>><?php echo $opciones['RESOLUTOR']?></option>
								<?php endforeach?>
							</select>
				<!--/////////////////////////////////////NRO EQUIPO///////////////////////////////////////////-->
				<!--/////////////////////////////////////NRO EQUIPO///////////////////////////////////////////-->				
				<label class="col-form-label col-xl col-lg">NRO EQUIPO: </label>
				<input class="form-control col-xl col-lg" type="text" name="nro_equipo" style="text-transform:uppercase" value="<?php echo $nro?>"><br><br>
				</div>
				<!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
				<!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
				<div class="form-group row">
				<label class="col-form-label col-xl col-lg">MOTIVO: <textarea class="form-control col-xl col-lg" name="motivo" style="text-transform:uppercase" placeholder="MOTIVO DERIVACIÓN/SOLUCIÓN/ANULACIÓN DE INCIDENTE"></textarea></label>
				<br>
				</div>
				<!--////////////////////////////////////////////////////////////////////////////////-->
				<!--////////////////////////////////////////////////////////////////////////////////-->
				<div class="form-group row">
				<input id="input" type="submit" value="MODIFICAR" name="btnmod" class="col button1">
				<input id="input" type="submit" value="SOLUCIONAR" name="btnsol" class="col button2">
				<input id="input" type="submit" value="ANULAR INCIDENTE" name="btnan" class="col button3">
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
	</div>
	</section>
	<section id="movimientos">
		<div id="grilla">
			<h2>MOVIMIENTOS DEL TICKET</h2>
			<?php

				/*$sql = "SELECT * from fecha_ticket WHERE ID_TICKET = '$guardar'";

				$resultado = $datos_base->query($sql);
				$row = $resultado->fetch_assoc();
				$res = $row['ID_FECHA'];*/

				echo "<table width=100%>
						<thead>
							<tr>
								<th><p>FECHA</p></th>
								<th><p>MOTIVO</p></th>
								<th><p>RESOLUTOR</p></th>
								<th><p>ESTADO</p></th>
							</tr>
						</thead>";


						$sql = mysqli_query($datos_base, "SELECT * from fecha_ticket WHERE ID_TICKET = '$guardar'");
						while($listar2 = mysqli_fetch_array($sql)){
							$resa = $listar2['ID_FECHA'];


						$consulta=mysqli_query($datos_base, "SELECT * from fecha WHERE ID_FECHA = '$resa'");
						while($listar = mysqli_fetch_array($consulta))
						{
							$opcion = $listar['ID_ESTADO'];
												switch ($opcion) {
												case 0:
												$est = "SIN ESTADO";
												break;
												case 1:
												$est = "SUSPENDIDOO";
												break;
												case 2:
												$est = "SOLUCIONADO";
												break;
												case 3:
												$est = "DERIVADO";
												break;
												case 4:
												$est = "EN PROCESO";
												break;
												case 5:
												$est = "ANULADO";
												break;
											}

							$opcion = $listar['ID_RESOLUTOR'];
											switch ($opcion) {
											case 0:
											$nom = "SIN RESOLUTOR";
											break;					
											case 1:
											$nom = "APOYO TÉCNICO - FINANZAS";
											break;
											case 2:
											$nom = "CLAUDIA VILLEGAS";
											break;
											case 3:
											$nom = "EDUARDO CICARDINI";
											break;
											case 4:
											$nom = "ENRIQUE BARRANCO";
											break;
											case 5:
											$nom = "GABRIEL RENELLA";
											break;
											case 6:
											$nom = "GONZALO NEGRO";
											break;
											case 7:
											$nom = "JULIO DIAZ";
											break;
											case 8:
											$nom = "MACRO SEGURIDAD";
											break;
											case 9:
											$nom = "MACROX";
											break;
											case 10:
											$nom = "MARIA JUAREZ";
											break;
											case 11:
											$nom = "MESA DE AYUDA";
											break;
											case 12:
											$nom = "OPERACIONES SSIT";
											break;
											case 13:
											$nom = "PAMELA TUSSETTO";
											break;
											case 14:
											$nom = "PROVEEDOR EXTERNO";
											break;
											case 15:
											$nom = "RODRIGO CESTAFE";
											break;
											case 16:
											$nom = "SOPORTE INTERNO";
											break;
											case 17:
											$nom = "SOPORTE POP";
											break;
											case 18:
											$nom = "SOPORTE TÉCNICO";
											break;
											case 19:
											$nom = "YANINA RE";
											break;		
											case 20:
											$nom = "GUSTAVO ELKIN";
											break;			
											case 21:
											$nom = "GASTON NIEVAS";
											break;							
										}	


								$fecord = date("d-m-Y", strtotime($listar['FECHA_HORA']));

							echo "
								<tr>
									<td><h5>".$fecord."</h5></td>
									<td><h5>".$listar['MOTIVO']."</h5></td>
									<td><h5>".$nom."</h5></td>
									<td><h5>".$est."</h5></td>
								</tr>";
						}}
					echo "</table>";
			?>
		</div>
	</section>
</body>
</html>