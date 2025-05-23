<?php 
error_reporting(0);
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
	<title>CAMBIOS AGREGADOS</title><meta charset="utf-8">
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
    <section id="inicio">
		 <div id="reporteEst">   
            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                <a id="vlv"  href="../consulta/consulta.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
            </div>					
         </div>

        <h1>CAMBIOS AGREGADOS</h1>  
        <?php
				echo "<table width=100%>
						<thead>
							<tr>
                                <th><p style='text-align:left;margin-left:5px;'>ABM AFECTADO</p></th>
                                <th><p style='text-align:left;margin-left:5px;'>TIPO</p></th>
								<th><p style='text-align:left;margin-left:5px;'>CONTENIDO</p></th>
								<th><p style='text-align:left;margin-left:5px;'>CONTENIDO ANTERIOR</p></th>
                                <th><p>FECHA</p></th>
                                <th><p>HORA</p></th>
                                <th><p style='text-align:left;margin-left:5px;'>RESOLUTOR</p></th>
							</tr>
						</thead>
					";
					function mostrarValor($valor) {
						return (
							$valor === null ||
							$valor === '' ||
							strtolower($valor) === 'null' ||
							strtolower($valor) === 'undefined' ||
							$valor === '00:00:00'
						) ? '-' : $valor;
					}
					

						$consulta=mysqli_query($datos_base, "SELECT a.ABM, a.TIPO, a.CONTENIDO, a.FECHA, a.HORA, r.RESOLUTOR
						FROM agregado a
						LEFT JOIN resolutor r ON r.ID_RESOLUTOR = a.ID_RESOLUTOR
						ORDER BY a.FECHA DESC, a.HORA DESC
						");
						while($listar = mysqli_fetch_array($consulta)) 
						{
						$fecha = date("d-m-Y", strtotime($listar['FECHA']));
						echo
						" 
						<tr>
						<td><h4 style='font-size:14px;text-align:left;margin-left:5px;'>".mostrarValor($listar['ABM'])."</h4 ></td>
                        <td><h4 style='font-size:14px;text-align:left;margin-left:5px;font-weight: bold;'>".mostrarValor($listar['TIPO'])."</h4 ></td>
                        <td><h4 style='font-size:14px;text-align:left;margin-left:5px;'>".mostrarValor($listar['CONTENIDO'])."</h4 ></td>
                        <td><h4 style='font-size:14px;text-align:left;margin-left:5px;'>".mostrarValor($listar['CONTENIDO_MODIFICADO'])."</h4 ></td>
						<td><h4 style='font-size:14px;'>".mostrarValor($fecha)."</h4 ></td>
						<td><h4 style='font-size:14px;'>".mostrarValor($listar['HORA'])."</h4 ></td>
						<td><h4 style='font-size:14px;text-align:left;margin-left:5px;font-weight: bold;'>".mostrarValor($listar['RESOLUTOR'])."</h4></td>
						";
						}
			?>
    </section>
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>