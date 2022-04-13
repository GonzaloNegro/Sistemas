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
	<title>CAMBIOS AGREGADOS</title><meta charset="utf-8">
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
                <a id="vlv"  href="consulta.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
            </div>					
         </div>

        <h1>CAMBIOS AGREGADOS</h1>  
        <?php
				echo "<table width=100%>
						<thead>
							<tr>
                                <th><p>ABM</p></th>
								<th><p>CONTENIDO</p></th>
                                <th><p>FECHA</p></th>
							</tr>
						</thead>
					";
						$consulta=mysqli_query($datos_base, "SELECT LUGAR, AGREGADO, FECHA
						FROM agregado
						ORDER BY FECHA DESC
						");
						while($listar = mysqli_fetch_array($consulta)) 
						{
						$fecha = date("d-m-Y", strtotime($listar['FECHA']));
						echo
						" 
						<tr>
                        <td><h4 style='font-size:16px;'>".$listar['LUGAR']."</h4 ></td>
						<td><h4 style='font-size:16px;'>".$listar['AGREGADO']."</h4 ></td>
						<td><h4 style='font-size:16px;'>".$fecha."</h4 ></td>
						";
						}
			?>
    </section>
</body>
</html>