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
	<title>ABM OTROS PERIFÉRICOS</title><meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
				swal(  {title: "Periférico modificado correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmotros.php';
						}
						}
						);
			}	
			</script>
<script type="text/javascript">
			function no(){
				swal(  {title: "El periférico ingresado ya está registrado",
						icon: "error",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmotros.php';
						}
						}
						);
			}	
			</script>
    <section id="inicio">
        <div id="reporteEst" style="width: 97%; margin-left: 20px;">   
            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                <a id="vlv"  href="abm.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
                <a id="agr"  href="agregarotrosperifericos.php" class="col-3 btn btn-primary " type="button">AGREGAR PERIFÉRICO</a>
            </div>					
         </div>

        <h1>ABM OTROS PERIFÉRICOS</h1>
		<form method="POST" action="abmotros.php">
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
								<th><p>MODELO</p></th>
								<th><p>USUARIO</p></th>
								<th><p>ÁREA</p></th>
                                <th><p>N° WS</p></th>
								<th><p>TIPO</p></th>
                                <th><p>MARCA</p></th>
								<th><p>MODIFICAR</p></th>
							</tr>
						</thead>
					";
					if(isset($_POST['btn2']))
					{
						$doc = $_POST['buscar'];
						$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA			
						FROM periferico p 
						LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
						LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
						LEFT JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
						LEFT JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
						WHERE ((p.ID_TIPOP = 9 OR p.ID_TIPOP = 6 OR p.ID_TIPOP = 5 OR p.ID_TIPOP = 11 OR p.ID_TIPOP = 12)
						AND (a.AREA LIKE '%$doc%' OR u.NOMBRE LIKE '%$doc%' OR p.SERIEG LIKE '%$doc%' OR p.NOMBREP LIKE '%$doc%' OR t.TIPO LIKE '%$doc%' OR m.MARCA LIKE '%$doc%'))
						ORDER BY p.NOMBREP ASC");
							while($listar = mysqli_fetch_array($consultar))
							{
								echo
								" 
									<tr>
										<td><h4 style='font-size:16px;'>".$listar['NOMBREP']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['TIPO']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
										<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=modotros.php?no=".$listar['ID_PERI']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
													<path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
													<path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
												</svg></a>
										</td>
									</tr>";
							}
					}
					else
					{
						$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA			
						FROM periferico p 
						LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
						LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
						LEFT JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
						LEFT JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
						WHERE p.ID_TIPOP = 9 OR p.ID_TIPOP = 6 OR p.ID_TIPOP = 5 OR p.ID_TIPOP = 11 OR p.ID_TIPOP = 12
						ORDER BY p.NOMBREP ASC");
							while($listar = mysqli_fetch_array($consultar))
							{
								echo
								" 
									<tr>
										<td><h4 style='font-size:16px;'>".$listar['NOMBREP']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['TIPO']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
										<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=modotros.php?no=".$listar['ID_PERI']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
													<path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
													<path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
												</svg></a>
										</td>
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