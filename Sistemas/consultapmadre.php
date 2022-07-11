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
	<title>ABM PLACA MADRE</title><meta charset="utf-8">
	<link rel="icon" href="imagenes/logoObrasPúblicas.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="estiloallabm.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
    <section id="inicio">
        <div id="reporteEst" style="width: 97%; margin-left: 20px;">   
            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                <a id="vlv"  href="consultaaltas.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
                <a id="agr"  href="abmplacamadre.php" class="col-3 btn btn-primary " type="button">ABM PLACA MADRE</a>
            </div>					
         </div>

        <h1>CONSULTA PLACA MADRE</h1>
		<form method="POST" action="consultapmadre.php">
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
								<th><p>PLACA MADRE</p></th>
								<th><p>MARCA</p></th>
							</tr>
						</thead>
					";
					if(isset($_POST['btn2']))
					{
						$doc = $_POST['buscar'];
						$consultar=mysqli_query($datos_base, "SELECT pl.ID_PLACAM, pl.PLACAM, ma.MARCA
                        FROM placam pl
                        LEFT JOIN marcas AS ma ON ma.ID_MARCA = pl.ID_MARCA
						WHERE pl.PLACAM LIKE '%$doc%' OR ma.MARCA LIKE '%$doc%'
                        ORDER BY pl.PLACAM ASC");
									while($listar = mysqli_fetch_array($consultar))
									{
										echo
										" 
											<tr>
												<td><h4 style='font-size:16px;'>".$listar['PLACAM']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
											</tr>";
						}
					}
					
					else
					{
						$consultar=mysqli_query($datos_base, "SELECT pl.ID_PLACAM, pl.PLACAM, ma.MARCA
                        FROM placam pl
                        LEFT JOIN marcas AS ma ON ma.ID_MARCA = pl.ID_MARCA
                        ORDER BY pl.PLACAM ASC");
									while($listar = mysqli_fetch_array($consultar))
									{
										echo
										" 
											<tr>
												<td><h4 style='font-size:16px;'>".$listar['PLACAM']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
											</tr>";
						}
					}
					echo "</table>";
					?>
    </section>
</body>
</html>