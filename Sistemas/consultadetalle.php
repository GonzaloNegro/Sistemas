<?php 
error_reporting(0);
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
		$filas['ID_WS'],/*5*/
		$filas['FECHA_SOLUCION'],/*6*/
		$filas['ID_RESOLUTOR'],/*7*/
		$filas['ID_TIPIFICACION'],/*8*/
		$filas['ID_USUARIO'],/*9*/
		$filas['HORA']/*10*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>DETALLES DEL INCIDENTE</title><meta charset="utf-8">
	<link rel="icon" href="imagenes/logoObrasPúblicas.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="estiloconsultadetalle.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
			function modificar(){	
				swal(  {title: "Se ha modificado su incidente correctamente",
						icon: "success",
						buttons: true,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='consulta.php';
						}
						}
						);
			}	
			</script>
			<script type="text/javascript">
			function solucionar(){
				swal(  {title: "Se ha solucionado su incidente correctamente",
						icon: "success",
						buttons: true,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='consulta.php';
						}
						}
						);
			}	
			</script>
			<script type="text/javascript">
			function anular(){
				swal(  {title: "Se ha anulado su incidente correctamente",
						icon: "success",
						buttons: true,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='consulta.php';
						}
						}
						);
			}	
			</script>
	<header>
		<div class="form-group row justify-content-between" style="margin-top: 0px; margin-left: 10px; margin-right: 10px; padding:10px;">
		<a id="vlv"  href="consulta.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
			<button id="pr" class="btn btn-success" style="width: 50px; border-radius: 10px; height: 45px;" onClick="imprimir()"><i class='bi bi-printer'></i></button>
		</div>
		
		<style type="text/css" media="print">
          @media print {
          
          #pr {display:none;}
		  #vlv {display:none;}
          }
         </style>
	  	<script>
          function imprimir() {
            	window.print();
          }
        </script>
		<div id="titulo" style="margin-top: 0px; margin-bottom: 30px;">
			<h1>DETALLES DEL INCIDENTE N°<?php echo $consulta[0]?></h1>
		</div>
	</header>
	<section id="ingreso">
		<div id="ingresar" class="container-fluid" style="margin-top: 50px;">
			<?php 
            include("conexion.php");
            $sent= "SELECT ESTADO FROM estado WHERE ID_ESTADO = $consulta[4]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $est = $row['ESTADO'];
			?>
			<?php 
            include("conexion.php");
            $sent= "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = $consulta[7]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $nom = $row['RESOLUTOR'];
			?>
			<?php 
            include("conexion.php");
            $sent= "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = $consulta[9]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $usu = $row['NOMBRE'];
			?>
			<?php 
           	include("conexion.php");
            $sent= "SELECT SERIEG FROM inventario WHERE ID_WS = $consulta[5]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $nro = $row['SERIEG'];
			?>
			<?php
			$des = $consulta[3];
		/*FECHAS*/
		$fecin = date("d-m-Y", strtotime($consulta[1]));
		?>
			<?php $guardar = $consulta[0]?>
			<div class="form-group row" style="margin: 5px; padding:10px;">
				<h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FECHA INICIO:</u> <?php echo $fecin ?></h4> 
				<h4 id="lblForm"class="col-form-label col-xl col-lg"><u>USUARIO:</u> <?php echo $usu?></h4>
				<h4 id="lblForm"class="col-form-label col-xl col-lg"><u>ESTADO:</u> <?php echo $est ?></h4>
			</div>

            <div class="form-group row" style="margin: 5px; padding:10px;">
				<h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FECHA DE SOLUCION:</u> <?php 
				
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
				?>
				<h4 id="lblForm"class="col-form-label col-xl col-lg"><u>RESOLUTOR:</u> <?php echo $nom?></h4>
				<h4 id="lblForm"class="col-form-label col-xl col-lg"><u>NRO EQUIPO:</u> <?php echo $nro?></h4>
			</div>

			<div class="form-group row" style="margin: 5px; padding:10px;">
				<h4 id="lblForm"class="col-form-label col-xl col-lg"><u>TIPIFICACIÓN:</u>
				<?php include("conexion.php");
					$sent= "SELECT TIPIFICACION FROM tipificacion WHERE ID_TIPIFICACION = $consulta[8]";
					$resultado = $datos_base->query($sent);
					$row = $resultado->fetch_assoc();
					$original = $row['TIPIFICACION'];
					echo $original?></h4>
				</h4>
				<h4 id="lblForm"class="col-form-label col-xl col-lg"><u>HORA:</u> <?php echo $consulta[10]?></h4>
			</div>

			<div class="form-group row" style="margin: 5px; padding:10px;">
            	<h4 id="lblForm"class="col-form-label col-xl col-lg"><u>DESCRIPCIÓN:</u> <?php echo $consulta[3]?></h4>
			</div>
	<!-- 		<div class="form-group row" style="margin-bottom: 20px;">
           		<h4 class="col-xl col-lg"><u>IMAGEN:</u>&nbsp &nbsp &nbsp<img src="data:image/jpg;base64,<?php echo base64_encode($consulta[9]);?>" alt=""></h4>
			</div> -->
        </div>
	</section>
	<section id="movimientos">
		<div id="grilla">
			<h2>MOVIMIENTOS DEL TICKET</h2>
		<?php
				echo "<table width=100%>
						<thead>
							<tr>
								<th><p>FECHA</p></th>
								<th><p>RESOLUTOR</p></th>
								<th><p>ESTADO</p></th>
								<th><p>MOTIVO</p></th>
							</tr>
						</thead>";

						$sql = mysqli_query($datos_base, "SELECT * from fecha_ticket WHERE ID_TICKET = '$guardar'");
						while($listar2 = mysqli_fetch_array($sql)){
							$resa = $listar2['ID_FECHA'];

						$consulta=mysqli_query($datos_base, "SELECT * from fecha WHERE ID_FECHA = '$resa'");
						while($listar = mysqli_fetch_array($consulta))
						{
							$opcion = $listar['ID_ESTADO'];
								include("conexion.php");
								$sent= "SELECT ESTADO FROM estado WHERE ID_ESTADO = $opcion";
								$resultado = $datos_base->query($sent);
								$row = $resultado->fetch_assoc();
								$est = $row['ESTADO'];
								?>
								<?php 
								$opcion = $listar['ID_RESOLUTOR'];
								include("conexion.php");
								$sent= "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = $opcion";
								$resultado = $datos_base->query($sent);
								$row = $resultado->fetch_assoc();
								$nom = $row['RESOLUTOR'];

								$fecord = date("d-m-Y", strtotime($listar['FECHA_HORA']));
							echo "
								<tr>
									<td><h5>".$fecord."</h5></td>
									<td><h5>".$nom."</h5></td>
									<td><h5>".$est."</h5></td>
									<td><h5>".$listar['MOTIVO']."</h5></td>
								</tr>";
						}}
					echo "</table>";
			?>
		</div>
	</div>
	</section>
</body>
</html>