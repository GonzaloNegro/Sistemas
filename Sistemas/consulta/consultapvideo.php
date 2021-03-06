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
	<title>CONSULTA PLACA DE VIDEO</title><meta charset="utf-8">
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
				<a id="agr"  href="abmplacav.php" class="col-3 btn btn-primary " type="button">ABM PLACA VIDEO</a>
            </div>					
         </div>

        <h1>CONSULTA PLACA DE VIDEO</h1>
		<form method="POST" action="consultapvideo.php">
				<div class="form-group row">
					<input type="text" style="margin-left: 10px; width: 75%; height: 40px; margin-top: 12px; 	box-sizing: border-box; border-radius: 10px; text-transform:uppercase;" name="buscar"  placeholder="Buscar"  class="form-control largo col-xl-4 col-lg-4">

					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn2" value="BUSCAR"></input>

					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn1" value="LIMPIAR"></input>
				</div>
		</form>
        <hr style='display: block;'>
        <?php
				echo "<table width=100%>
						<thead>
							<tr>
								<th><p>PLACA</p></th>
								<th><p>MEMORIA</p></th>
                                <th><p>TIPO DE MEMORIA</p></th>
							</tr>
						</thead>
					";
					if(isset($_POST['btn2']))
					{
						$doc = $_POST['buscar'];
						$consultar=mysqli_query($datos_base, "SELECT pv.ID_PVIDEO, m.MEMORIA, mo.MODELO, t.TIPOMEM
                        FROM pvideo pv 
                        LEFT JOIN memoria AS m ON m.ID_MEMORIA = pv.ID_MEMORIA
                        LEFT JOIN tipomem AS t ON t.ID_TIPOMEM = pv.ID_TIPOMEM 
						LEFT JOIN modelo AS mo ON mo.ID_MODELO = pv.ID_MODELO
						WHERE m.MEMORIA LIKE '%$doc%' OR mo.MODELO LIKE '%$doc%' OR t.TIPOMEM LIKE '%$doc%'
                        ORDER BY mo.MODELO ASC");
							while($listar = mysqli_fetch_array($consultar))
								{

										echo
										" 
											<tr>
												<td><h4 style='font-size:16px;'>".$listar['MODELO']."</h4></td>
												<td><h4 style='font-size:16px;'>".$listar['MEMORIA']."</h4></td>
                                                <td><h4 style='font-size:16px;'>".$listar['TIPOMEM']."</h4></td>
										    </tr>";
						}
					}
					
					else
					{
						$consultar=mysqli_query($datos_base, "SELECT pv.ID_PVIDEO, m.MEMORIA, mo.MODELO, t.TIPOMEM
                        FROM pvideo pv 
                        LEFT JOIN memoria AS m ON m.ID_MEMORIA = pv.ID_MEMORIA
                        LEFT JOIN tipomem AS t ON t.ID_TIPOMEM = pv.ID_TIPOMEM
						LEFT JOIN modelo AS mo ON mo.ID_MODELO = pv.ID_MODELO
                        ORDER BY mo.MODELO ASC");
							while($listar = mysqli_fetch_array($consultar))
								{

										echo
										" 
											<tr>
                                                <td><h4 style='font-size:16px;'>".$listar['MODELO']."</h4></td>
                                                <td><h4 style='font-size:16px;'>".$listar['MEMORIA']."</h4></td>
                                                <td><h4 style='font-size:16px;'>".$listar['TIPOMEM']."</h4></td>
										    </tr>";
						}
					}
					echo "</table>";
					?>
    </section>
</body>
</html>