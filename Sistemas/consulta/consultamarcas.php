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
	<title>CONSULTA MARCAS</title><meta charset="utf-8">
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
                <a id="vlv"  href="consultaaltas.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
                <?php if($row['ID_PERFIL'] == 1 || $row['ID_PERFIL'] == 2) 
				{ echo'<a id="agr" href="../abm/abmmarcas.php" class="btn btn-success" type="button">+</a>';
				}
				?>
            </div>					
        </div>

        <h1>CONSULTA MARCAS</h1>
		<div id="filtro" class="container-fluid">
			<form method="POST" action="consultamarcas.php">
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
                                <th><p>MARCA</p></th>
							</tr>
						</thead>
					";        
						if(isset($_POST['btn2']))
						{
							$doc = $_POST['buscar'];
							$consultar=mysqli_query($datos_base, "SELECT * FROM marcas
							WHERE MARCA LIKE '%$doc%'
							ORDER BY MARCA ASC");
								while($listar = mysqli_fetch_array($consultar))
								{
									echo
									" 
										<tr>
										    <td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
										</tr>
									";
								}
						}
						else{
							$consultar=mysqli_query($datos_base, "SELECT * FROM marcas 
							ORDER BY MARCA ASC");
								while($listar = mysqli_fetch_array($consultar))
								{
									echo
									" 
										<tr>
										    <td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
										</tr>
									";
								}  
						}
						echo "</table>";
							?>
    </section>
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>