<?php 
session_start();
include('conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: Inicio.php'); 
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
	<link rel="icon" href="imagenes/logoObrasPúblicas.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="estiloallabm.css">
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
        <div id="reporteEst" style="width: 97%; margin-left: 20px;">   
            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                <a id="vlv"  href="abm.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
                <a id="agr"  href="agregarusuario.php" class="col-3 btn btn-primary " type="button">AGREGAR USUARIO</a>
            </div>					
         </div>

        <h1>ABM USUARIO</h1>
		<form method="POST" action="abmusuario.php">
				<div class="form-group row">
					<input type="text" style="margin-left: 10px; width: 75%; height: 40px; margin-top: 12px; 	box-sizing: border-box; border-radius: 10px; text-transform:uppercase;" name="buscar"  placeholder="Buscar"  class="form-control largo col-xl-4 col-lg-4">

					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn2" value="BUSCAR"></input>

					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn1" value="LIMPIAR"></input>
				</div>
		</form>
        
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
							<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=modusuario.php?no=".$listar['ID_USUARIO']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
							<path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
							<path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
							</svg></a></td>
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
							<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=modusuario.php?no=".$listar['ID_USUARIO']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
							<path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
							<path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
							</svg></a></td>
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
</body>
</html>