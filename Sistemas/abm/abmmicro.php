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
	<title>ABM MICRO</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
				swal(  {title: "Micro modificado correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmmicro.php';
						}
						}
						);
			}	
			</script>
<script type="text/javascript">
			function repeat(){
				swal(  {title: "Micro modificado correctamente. Verifique el nombre de la marca, ya que existe este nombre registrado previamente!",
						icon: "info",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmmicro.php';
						}
						}
						);
			}	
			</script>
<script type="text/javascript">
			function no(){
				swal(  {title: "El micro de la marca ingresada ya está registrado",
						icon: "error",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmmicro.php';
						}
						}
						);
			}	
			</script>
    <section id="inicio">
		 <div id="reporteEst">   
            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                <a id="vlv"  href="abm.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
                <a id="agr" href="agregarmicro.php" class="btn btn-success" type="button">+</a>
            </div>					
         </div>

        <h1>ABM MICRO</h1>
		<div id="filtro" class="container-fluid">
			<form method="POST" action="abmmicro.php">
				<div>
					<input type="text" style="text-transform:uppercase;" name="buscar"  placeholder="Buscar" class="form-control largo">
				</div>        
				<div>
					<input class="btn btn-success" type="submit" name="btn2" value="BUSCAR"></input>
					<input class="btn btn-danger"  type="submit" name="btn1" value="LIMPIAR"></input>
				</div>
			</form>
		</div>
        <?php
				echo "<table class='table_id tablaLineas' id='tabla_lineas'>
						<thead>
							<tr>
								<th><p style='text-align:left;padding:5px;'>MICRO</p></th>
								<th><p style='text-align:left;padding:5px;'>MARCA</p></th>
								<th><p>MODIFICAR</p></th>
							</tr>
						</thead>
					";
					if(isset($_POST['btn2']))
					{
						$doc = $_POST['buscar'];
						$consultar=mysqli_query($datos_base, "SELECT m.ID_MICRO, m.MICRO, ma.MARCA
                        FROM micro m 
                        LEFT JOIN marcas AS ma ON ma.ID_MARCA = m.ID_MARCA
						WHERE m.MICRO LIKE '%$doc%' OR ma.MARCA LIKE '%$doc%'
                        ORDER BY m.MICRO ASC");
							while($listar = mysqli_fetch_array($consultar))
								{

										echo
										" 
											<tr>
												<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['MICRO']."</h4></td>
												<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['MARCA']."</h4></td>
												<td class='text-center text-nowrap'><a href=modmicro.php?no=".$listar['ID_MICRO']."><i style='color: #198754' class='fa-solid fa-pen-to-square fa-2xl'></i></a></td>
										</tr>";
						}
					}
					
					else
					{
						$consultar=mysqli_query($datos_base, "SELECT m.ID_MICRO, m.MICRO, ma.MARCA
                        FROM micro m 
                        LEFT JOIN marcas AS ma ON ma.ID_MARCA = m.ID_MARCA
                        ORDER BY m.MICRO ASC");
							while($listar = mysqli_fetch_array($consultar))
								{

										echo
										" 
											<tr>
												<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['MICRO']."</h4></td>
												<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['MARCA']."</h4></td>
												<td class='text-center text-nowrap'><a href=modmicro.php?no=".$listar['ID_MICRO']."><i style='color: #198754' class='fa-solid fa-pen-to-square fa-2xl'></i></a></td>
										</tr>";
						}
					}
					echo "</table>";
					?>
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
    </section>
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>