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
	<title>ABM USUARIO</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoObrasPúblicas.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
				swal(  {title: "Usuario modificado correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmusuario.php';
						}
						}
						);
			}	
			</script>
<script type="text/javascript">
			function no(){
				swal(  {title: "El usuario ingresado ya está registrado",
						icon: "error",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmusuario.php';
						}
						}
						);
			}	
			</script>
    <section id="inicio">
		 <div id="reporteEst">   
            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                <a id="vlv"  href="abm.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
                <a id="agr" href="agregarusuario.php" class="btn btn-success" type="button">+</a>
            </div>					
         </div>

        <h1>ABM USUARIO</h1>
		<div id="filtro" class="container-fluid">
			<form method="POST" action="abmusuario.php">
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
				echo "<table width=100%>
						<thead>
							<tr>
								<th><p>USUARIO</p></th>
                                <th><p>CUIL</p></th>
                                <th><p>ÁREA</p></th>
								<th><p>REPARTICIÓN</p></th>
                                <th><p>CORREO</p></th>
								<th><p>ESTADO</p></th>
                                <th><p>MODIFICAR</p></th>
							</tr>
						</thead>
					";
					if(isset($_POST['btn2']))
					{
						$doc = $_POST['buscar'];
						$consulta=mysqli_query($datos_base, "SELECT u.ID_USUARIO, u.NOMBRE, u.CUIL, a.AREA, u.CORREO, u.ACTIVO, r.REPA
						FROM usuarios u
						LEFT JOIN area a ON u.ID_AREA = a.ID_AREA
						LEFT JOIN reparticion r ON r.ID_REPA = a.ID_REPA
						WHERE u.NOMBRE LIKE '%$doc%' OR u.CUIL LIKE '%$doc%' OR a.AREA LIKE '%$doc%' OR u.CORREO LIKE '%$doc%' OR u.ACTIVO LIKE '$doc' OR r.REPA LIKE '%$doc%'
						ORDER BY u.NOMBRE ASC");
						while($listar = mysqli_fetch_array($consulta)) 
						{
						echo
							" 
							<tr>
							<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4 ></td>
							<td><h4 style='font-size:16px;'>".$listar['CUIL']."</h4 ></td>
							<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4 ></td>
							<td><h4 style='font-size:14px;'>".$listar['REPA']."</h4 ></td>
							<td><h4 style='font-size:14px;'>".$listar['CORREO']."</h4 ></td>
							<td><h4 style='font-size:16px;'>".$listar['ACTIVO']."</h4 ></td>
							<td class='text-center text-nowrap'><a class='btn btn-info' style=' color:white;' href=modusuario.php?no=".$listar['ID_USUARIO']." class=mod>Editar</a></td>
							</tr>";
						}
					}
					
					else
					{
						$consulta=mysqli_query($datos_base, "SELECT u.ID_USUARIO, u.NOMBRE, u.CUIL, a.AREA, CORREO, u.ACTIVO, r.REPA
						FROM usuarios u
                        LEFT JOIN area a ON  u.ID_AREA = a.ID_AREA
						LEFT JOIN reparticion r ON r.ID_REPA = a.ID_REPA
                        ORDER BY u.NOMBRE ASC");
						while($listar = mysqli_fetch_array($consulta)) 
						{
						echo
							" 
							<tr>
							<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4 ></td>
                            <td><h4 style='font-size:16px;'>".$listar['CUIL']."</h4 ></td>
                            <td><h4 style='font-size:16px;'>".$listar['AREA']."</h4 ></td>
							<td><h4 style='font-size:14px;'>".$listar['REPA']."</h4 ></td>
                            <td><h4 style='font-size:14px;'>".$listar['CORREO']."</h4 ></td>
							<td><h4 style='font-size:16px;'>".$listar['ACTIVO']."</h4 ></td>
							<td class='text-center text-nowrap'><a class='btn btn-info' style=' color:white;' href=modusuario.php?no=".$listar['ID_USUARIO']." class=mod>Editar</a></td>
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