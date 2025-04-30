<?php 
session_start();
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
	<title>ABM ÁREA</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloallabm.css">
</head>
<body>
<script type="text/javascript">
			function ok(){
				swal(  {title: "Área modificada correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmarea.php';
						}
						}
						);
			}	
			</script>
<script type="text/javascript">
			function no(){
				swal(  {title: "La área ingresada ya está registrada",
						icon: "error",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmarea.php';
						}
						}
						);
			}	
			</script>
    <section id="inicio">
		<div id="reporteEst">   
            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                <a id="vlv"  href="abm.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
                <a id="agr" href="agregararea.php" class="btn btn-success" type="button">+</a>
            </div>					
        </div>

        <h1>ABM ÁREA</h1>
		<div id="filtro" class="container-fluid">
			<form method="POST" action="abmarea.php">
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
								<th><p style='font-size:16px;text-align:left;padding:5px;'>ÁREA</p></th>
								<th><p style='font-size:16px;text-align:left;padding:5px;'>REPARTICIÓN</p></th>
								<th><p style='font-size:16px;text-align:left;padding:5px;'>ESTADO</p></th>";
								if ($row['ID_PERFIL'] != 5) {
									echo"<th><p>MODIFICAR</p></th>
									</tr>";
								}
                                
						echo"</thead>
					";
					if(isset($_POST['btn2']))
							{
								$doc = $_POST['buscar'];
								$consulta=mysqli_query($datos_base, "SELECT a.ID_AREA, a.AREA, r.REPA, e.ESTADO
								FROM area a
								LEFT JOIN reparticion AS r ON r.ID_REPA= a.ID_REPA
								LEFT JOIN estado_usuario AS e ON e.ID_ESTADOUSUARIO = a.ID_ESTADOUSUARIO
								WHERE a.AREA LIKE '%$doc%' OR r.REPA LIKE '%$doc%' OR e.ESTADO LIKE '$doc'
								ORDER BY r.REPA ASC, a.AREA ASC");
								while($listar = mysqli_fetch_array($consulta))
								{

									echo
									" 
										<tr>
										<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['AREA']."</h4 ></td>
										<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['REPA']."</h4 ></td>
										<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['ESTADO']."</h4 ></td>";
										if ($row['ID_PERFIL'] != 5) {
											echo"<td class='text-center text-nowrap'><a href=modarea.php?no=".$listar['ID_AREA']."><i style='color: #198754' class='fa-solid fa-pen-to-square fa-2xl'></i></a></td>
										</tr>
									";}
								} 
							}
							else{
							$consulta=mysqli_query($datos_base, "SELECT a.ID_AREA, a.AREA, r.REPA, e.ESTADO
							FROM area a
							LEFT JOIN reparticion AS r ON r.ID_REPA= a.ID_REPA
							LEFT JOIN estado_usuario AS e ON e.ID_ESTADOUSUARIO = a.ID_ESTADOUSUARIO
                            ORDER BY r.REPA ASC, a.AREA ASC
							");
								while($listar = mysqli_fetch_array($consulta)) 
								{
									echo
									" 
										<tr>
										<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['AREA']."</h4 ></td>
										<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['REPA']."</h4 ></td>
										<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['ESTADO']."</h4 ></td>";
										if ($row['ID_PERFIL'] != 5) {
											echo"<td class='text-center text-nowrap'><a href=modarea.php?no=".$listar['ID_AREA']."><i style='color: #198754' class='fa-solid fa-pen-to-square fa-2xl'></i></a></td>
											</tr>
										";
										}
										
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