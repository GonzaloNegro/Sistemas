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
	<title>ABM EQUIPOS</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloallabm.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
    <section id="inicio">
		 <div id="reporteEst">   
            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                <a id="vlv"  href="abm.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
                <a id="agr" href="agregarequipo.php" class="btn btn-success" type="button">+</a>
            </div>					
        </div>

        <h1>ABM EQUIPOS</h1>
		<div id="filtro" class="container-fluid">
			<form method="POST" action="abmequipos.php">
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
								<th><p>N° WS</p></th>
								<th><p>USUARIO</p></th>
								<th><p>ÁREA</p></th>
								<th><p>REPARTICIÓN</p></th>
								<th><p>MOTHERBOARD</p></th>
                                <th><p>S.O.</p></th>
                                <th><p>MICRO</p></th>
                                <th><p>ESTADO</p></th>";
								if ($row['ID_PERFIL'] != 5) {
								echo"<th><p>MODIFICAR</p></th>
							</tr>";
								}
								echo"
						</thead>
					";
					if(isset($_POST['btn2']))
					{
						$doc = $_POST['buscar'];
						$consultar=mysqli_query($datos_base, "SELECT DISTINCT i.ID_WS, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, p.PLACAM, s.SIST_OP, m.MICRO, e.ESTADO
                        FROM inventario i 
                        LEFT JOIN wsusuario AS w ON w.ID_WS = i.ID_WS
                        LEFT JOIN usuarios AS u ON u.ID_USUARIO = w.ID_USUARIO
						LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = i.ID_ESTADOWS
						LEFT JOIN placamws AS pl ON pl.ID_WS = i.ID_WS
						LEFT JOIN placam AS p ON p.ID_PLACAM = pl.ID_PLACAM
						LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
						LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
                        INNER JOIN area AS a ON a.ID_AREA = i.ID_AREA 
                        LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA  
                        INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
						WHERE a.AREA LIKE '%$doc%' OR r.REPA LIKE '%$doc%' OR u.NOMBRE LIKE '%$doc%' OR i.SERIEG LIKE '%$doc%' OR p.PLACAM LIKE '%$doc%' OR s.SIST_OP LIKE '%$doc%' OR m.MICRO LIKE '%$doc%'
                        ORDER BY u.NOMBRE ASC, i.SERIEG ASC");
									while($listar = mysqli_fetch_array($consultar))
									{
										echo
										" 
											<tr>
												<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['REPA']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['PLACAM']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['SIST_OP']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['MICRO']."</h4></td>";
												if ($row['ID_PERFIL'] != 5) {
												echo"
												<td class='text-center text-nowrap'><a class='btn btn-info' style=' color:white;' href=modequipo.php?no=".$listar['ID_WS']." class=mod>Editar</a></td>
												";}
												echo"
											</tr>";
						}
					}
					else
					{
						$consultar=mysqli_query($datos_base, "SELECT DISTINCT  i.ID_WS, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, p.PLACAM, s.SIST_OP, m.MICRO, e.ESTADO
                        FROM inventario i 
                        LEFT JOIN wsusuario AS w ON w.ID_WS = i.ID_WS
                        LEFT JOIN usuarios AS u ON u.ID_USUARIO = w.ID_USUARIO
                        LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = i.ID_ESTADOWS
						LEFT JOIN placamws AS pl ON pl.ID_WS = i.ID_WS
						LEFT JOIN placam AS p ON p.ID_PLACAM = pl.ID_PLACAM
						LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
						LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
                        INNER JOIN area AS a ON a.ID_AREA = i.ID_AREA 
                        LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA 
                        INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
                        ORDER BY u.NOMBRE ASC, i.SERIEG ASC");
									while($listar = mysqli_fetch_array($consultar))
									{
										echo
										" 
											<tr>
												<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['REPA']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['PLACAM']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['SIST_OP']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['MICRO']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['ESTADO']."</h4></td>";
												if ($row['ID_PERFIL'] != 5) {
												echo"
												<td class='text-center text-nowrap'><a class='btn btn-info' style=' color:white;' href=modequipo.php?no=".$listar['ID_WS']." class=mod>Editar</a></td>
												";}
												echo"
											</tr>";}
					}
					echo "</table>";
					?>
    </section>
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>