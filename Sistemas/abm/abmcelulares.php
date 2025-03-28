<?php
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil']))
    {
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();

if($row['ID_PERFIL'] == 3 OR $row['ID_PERFIL'] == 4){
    header("location: ../consulta/consulta.php");
}else{
   /*  header("location: abmtipificacion.php"); */
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>ABM CELULARES</title><meta charset="utf-8">
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
				swal(  {title: "Celular modificada correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmcelulares.php';
						}
						}
						);
			}	
			</script>
<script type="text/javascript">
			function no(){
				swal(  {title: "El celular ingresado ya está registrado",
						icon: "error",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmcelulares.php';
						}
						}
						);
			}	
			</script>
    <section id="inicio">
        <div id="reporteEst">   
            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                <a id="vlv"  href="abm.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
                <a id="agr" href="agregarCelular.php" class="btn btn-success" type="button">+</a>
            </div>					
         </div>

        <h1>ABM CELULARES</h1>
		<div id="filtro" class="container-fluid">
			<form method="POST" action="abmcelulares.php">
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
								<th><p style='text-align:left; margin-left: 10px;'>MODELO</p></th>
								<th><p style='text-align:left; margin-left: 10px;'>MARCA</p></th>
								<th><p style='text-align:left; margin-left: 10px;'>USUARIO</p></th>
								<th><p style='text-align:left; margin-left: 10px;'>PROCEDENCIA</p></th>
								<th><p style='text-align:left; margin-left: 10px;'>PROVEEDOR</p></th>
								<th><p style='text-align:left; margin-left: 10px;'>IMEI</p></th>
								<th><p style='text-align:left; margin-left: 10px;'>ESTADO</p></th>";
                                if ($row['ID_PERFIL'] != 5) {
									echo"<th><p>MODIFICAR</p></th>
									</tr>";
								}
                                
						echo"</thead>
					";
								if(isset($_POST['btn2']))
								{
									$doc = $_POST['buscar'];
									$consulta=mysqli_query($datos_base, "SELECT c.ID_CELULAR, c.IMEI, u.NOMBRE, e.ESTADO, mo.MODELO, ma.MARCA, pr.PROVEEDOR, p.PROCEDENCIA
									FROM celular c
									LEFT JOIN estado_ws e ON e.ID_ESTADOWS = c.ID_ESTADOWS
									LEFT JOIN modelo mo ON mo.ID_MODELO = c.ID_MODELO
									LEFT JOIN marcas ma ON ma.ID_MARCA = mo.ID_MARCA
									LEFT JOIN usuarios u ON u.ID_USUARIO = c.ID_USUARIO
									LEFT JOIN procedencia p ON p.ID_PROCEDENCIA = c.ID_PROCEDENCIA
									LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = c.ID_PROVEEDOR
									WHERE mo.MODELO LIKE '%$doc%' OR ma.MARCA LIKE '%$doc%' OR u.NOMBRE LIKE '%$doc%' OR c.IMEI LIKE '%$doc%' OR e.ESTADO LIKE '%$doc%' OR pr.PROVEEDOR LIKE '%$doc%' OR p.PROCEDENCIA LIKE '%$doc%'
									ORDER BY u.NOMBRE ASC
									");
										while($listar = mysqli_fetch_array($consulta)) 
										{
											echo
											" 
												<tr>
												<td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$listar['MODELO']."</h4 ></td>
												<td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$listar['MARCA']."</h4 ></td>
												<td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$listar['NOMBRE']."</h4 ></td>
												<td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$listar['PROCEDENCIA']."</h4 ></td>
												<td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$listar['PROVEEDOR']."</h4 ></td>
												<td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$listar['IMEI']."</h4 ></td>
												<td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$listar['ESTADO']."</h4 ></td>";
												if ($row['ID_PERFIL'] != 5) {
													echo"<td class='text-center text-nowrap'><a class='btn btn-info' style=' color:white;' href=modtipificacion.php?no=".$listar['ID_CELULAR']." class=mod>Editar</a></td>
													</tr>
												";
												}
												
										}
								}
	
								else{
									$consulta=mysqli_query($datos_base, "SELECT c.ID_CELULAR, c.IMEI, u.NOMBRE, e.ESTADO, mo.MODELO, ma.MARCA, pr.PROVEEDOR, p.PROCEDENCIA
									FROM celular c
									LEFT JOIN estado_ws e ON e.ID_ESTADOWS = c.ID_ESTADOWS
									LEFT JOIN modelo mo ON mo.ID_MODELO = c.ID_MODELO
									LEFT JOIN marcas ma ON ma.ID_MARCA = mo.ID_MARCA
									LEFT JOIN usuarios u ON u.ID_USUARIO = c.ID_USUARIO
									LEFT JOIN procedencia p ON p.ID_PROCEDENCIA = c.ID_PROCEDENCIA
									LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = c.ID_PROVEEDOR
									ORDER BY u.NOMBRE ASC
									");
										while($listar = mysqli_fetch_array($consulta)) 
										{
											echo
											" 
												<tr>
													<td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$listar['MODELO']."</h4 ></td>
													<td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$listar['MARCA']."</h4 ></td>
													<td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$listar['NOMBRE']."</h4 ></td>
													<td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$listar['PROCEDENCIA']."</h4 ></td>
													<td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$listar['PROVEEDOR']."</h4 ></td>
													<td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$listar['IMEI']."</h4 ></td>
													<td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$listar['ESTADO']."</h4 ></td>";
													if ($row['ID_PERFIL'] != 5) {
													echo"<td class='text-center text-nowrap'><a class='btn btn-info' style=' color:white;' href=modtipificacion.php?no=".$listar['ID_CELULAR']." class=mod>Editar</a></td>
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