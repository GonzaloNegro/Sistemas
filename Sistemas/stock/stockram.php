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
?>
<!DOCTYPE html>
<html>
<head>
	<title>STOCK RAM</title>
	<link rel="icon" href="../imagenes/logoObrasPúblicas.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../estilos/estiloallabm.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
	function ok(){
		swal(  {title: "Memoria cargada correctamente",
				icon: "success",
				showConfirmButton: true,
				showCancelButton: false,
				});
	}	
	</script>
<script type="text/javascript">
	function no(){
		swal({title: "La memoria ya esta registrada",
				icon: "error",
				showConfirmButton: true,
				showCancelButton: false,
				});
	}	
</script>
<script type="text/javascript">
	function mod(){
		swal({title: "La memoria ha sido modificada",
				icon: "success",
				showConfirmButton: true,
				showCancelButton: false,
				});
	}	
</script>
	<div id="reporteEst" style="width: 97%; margin-left: 20px;">   
		<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
			<a id="vlv"  href="./stock.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
			<a id="agr"  href="./agregarRam.php" class="col-3 btn btn-primary " type="button">AGREGAR MEMORIA</a>
        </div>					
    </div>
    <div id="titulo" style="margin-top: 0px; margin-bottom: 30px;">
		<h1>STOCK MEMORIA RAM</h1>
	</div>
	</header>
	<section id="movimientos">
		<div id="grilla">
		<?php
				echo "<table>
						<thead>
							<tr>
                                <th><p class=g>MEMORIA</p></th>
								<th><p class=g>CAPACIDAD</p></th>
								<th><p class=g>VELOCIDAD</p></th>
								<th><p class=g>CANTIDAD</p></th>
								<th><p class=g>DETALLE</p></th>
							</tr>
						</thead>";
                        $consultar=mysqli_query($datos_base, "SELECT s.ID_STOCKRAM, t.TIPOMEM, m.MEMORIA, v.FRECUENCIA_RAM, s.CANTIDAD
                        FROM stockram s
                        LEFT JOIN tipomem AS t ON t.ID_TIPOMEM = s.ID_TIPOMEM
						LEFT JOIN memoria AS m ON m.ID_MEMORIA = s.ID_MEMORIA
						LEFT JOIN velocidad AS v ON v.ID_FRECUENCIA = s.ID_FRECUENCIA
                        ORDER BY t.TIPOMEM DESC");
						while($listar = mysqli_fetch_array($consultar))
						{
						    echo" 
								<tr>
									<td><h4 style='font-size:16px;'>".$listar['TIPOMEM']."</h4></td>
									<td><h4 style='font-size:16px;'>".$listar['MEMORIA']."</h4></td>
									<td><h4 style='font-size:16px;'>".$listar['FRECUENCIA_RAM']."</h4></td>
									<td><h4 style='font-size:16px;'>".$listar['CANTIDAD']."</h4></td>
									<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=modstockram.php?no=".$listar['ID_STOCKRAM']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
												<path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
												<path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
											</svg></a>
									</td>
								</tr>";
						}
					echo "</table>";
			?>
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
		if(isset($_GET['mod'])){
			?>
			<script>mod();</script>
			<?php			
		}
	?>
		</div>
	</section>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>