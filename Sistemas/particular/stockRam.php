<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>MOVIMIENTOS</title>
	<link rel="icon" href="../imagenes/logoObrasPúblicas.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../estilos/estiloconsultadetalleinv.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
	<div id="reporteEst" style="width: 97%; margin-left: 20px;">   
		<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
			<a id="vlv"  href="stock.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
		</div>					
	</div>
    <div id="titulo" style="margin-top: 0px; margin-bottom: 30px;">
			<h1>STOCK MEMORIA RAM</h1>
		</div>
	</header>
	<section id="movimientos">
		<div id="grilla">
		<?php
				echo "<table>
						<thead>
							<tr>
                                <th><p class=g>MEMORIA</p></th>
								<th><p class=g>CANTIDAD</p></th>
							</tr>
						</thead>";

                        $equipo = $consulta[0];
                        $consultar=mysqli_query($datos_base, "SELECT m.ID_WS, m.FECHA, u.NOMBRE, a.AREA, e.ESTADO, ma.MARCA, s.SIST_OP, m.MASTERIZADA, m.MAC, m.RIP, m.IP, r.RED
                        FROM movimientos m 
                        LEFT JOIN usuarios AS u ON u.ID_USUARIO = m.ID_USUARIO
                        LEFT JOIN area AS a ON a.ID_AREA = m.ID_AREA
                        LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = m.ID_ESTADOWS
                        LEFT JOIN marcas AS ma ON ma.ID_MARCA = m.ID_MARCA
                        LEFT JOIN so AS s ON s.ID_SO = m.ID_SO
                        LEFT JOIN red AS r ON r.ID_RED = m.ID_RED
                        WHERE m.ID_WS = $equipo
                        ORDER BY m.FECHA ASC");
						while($listar = mysqli_fetch_array($consultar))
						{
						    echo" 
								<tr>

								</tr>";
						}
					echo "</table>";
			?>
		</div>
	</div>
	</section>
</body>
</html>