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
	<link rel="stylesheet" type="text/css" href="estiloconsultadetalle.css">
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
	<div class="form-group row justify-content-end" style="margin-top: 0px; margin-left: 10px; margin-right: 10px; padding:10px;">
	      
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
			<?php $guardar = $consulta[0]?><br>
			<div class="form-group row" style="margin-bottom: 20px;">
			<h4 class="col-xl col-lg"><u>FECHA INICIO:</u> <?php echo $fecin ?>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</h4> 
			<h4 class="col-xl col-lg"><u>USUARIO:</u> <?php echo $usu?>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</h4>
			<h4 class="col-xl col-lg"><u>ESTADO:</u> <?php echo $est ?>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</h4>
			</div>
            <div class="form-group row" style="margin-bottom: 20px;">
			<h4 class="col-xl col-lg"><u>FECHA DE SOLUCION:</u> <?php 
			
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
			?>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
			<h4 class="col-xl col-lg"><u>RESOLUTOR:</u> <?php echo $nom?></h4>
			<h4 class="col-xl col-lg"><u>NRO EQUIPO:</u> <?php echo $consulta[5]?> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</h4>
			</div>
			<div class="form-group row" style="margin-bottom: 20px;">
            <h4 class="col-xl col-lg"><u>DESCRIPCIÓN:</u> <?php echo $consulta[3]?></h4><br><br>
			</div>
        </div><br><br>
	</section>
	<section id="movimientos">
		<div id="grilla">
			<h2>MOVIMIENTOS</h2>
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
			?><br><br><br>
		</div>
        <div id="volver">
			<a id="vlv" href="consulta.php" class="btn btn-primary">VOLVER</a>
		
		</div>
	</div>
	</section>
</body>
</html>