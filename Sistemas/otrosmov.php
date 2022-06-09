<?php 
error_reporting(0);
session_start();
include('conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM movimientosperi WHERE ID_PERI='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_MOVIMIENTO'],/*0*/
        $filas['FECHA'],/*1*/
        $filas['ID_PERI'],/*2*/
        $filas['ID_AREA'],/*3*/
        $filas['ID_USUARIO'],/*4*/
        $filas['ID_ESTADOWS'],/*5*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>MOVIMIENTOS</title>
	<link rel="icon" href="imagenes/logoObrasPúblicas.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="estiloconsultadetalleinv.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
	<div id="reporteEst" style="width: 97%; margin-left: 20px;">   
		<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
			<a id="vlv"  href="otrosp.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
		</div>					
	</div>
    <div id="titulo" style="margin-top: 0px; margin-bottom: 30px;">
                <?php
                $sql = "SELECT m.MODELO, p.ID_PERI
                FROM modelo m
                LEFT JOIN periferico p ON p.ID_MODELO = m.ID_MODELO
                WHERE p.ID_PERI='$consulta[2]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $serg = $row['MODELO'];
                ?>
			<h1>MOVIMIENTOS PERIFERICO <?php echo $serg?></h1>
		</div>
	</header>
	<section id="movimientos">
		<div id="grilla">
		<?php
		    function colorear($v1, $v2, $v3){
                if($v1 != $v2){
                    $v3 = "#258900";
                }else{
                    $v3 = "#000000";
                }
                return $v3;
            }
				echo "<table width=100%>
						<thead>
							<tr>
                                <th><p class=g>FECHA</p></th>
								<th><p class=g>USUARIO</p></th>
								<th><p class=g>ÁREA</p></th>
								<th><p class=g>ESTADO</p></th>
							</tr>
						</thead>";
                        $equipo = $consulta[2];
                        $consultar=mysqli_query($datos_base, "SELECT m.ID_PERI, m.FECHA, u.NOMBRE, a.AREA, e.ESTADO
                        FROM movimientosperi m
                        LEFT JOIN usuarios AS u ON u.ID_USUARIO = m.ID_USUARIO
                        LEFT JOIN area AS a ON a.ID_AREA = m.ID_AREA
                        LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = m.ID_ESTADOWS
                        WHERE m.ID_PERI = $equipo
                        ORDER BY m.FECHA ASC");
						while($listar = mysqli_fetch_array($consultar))
						{
                            $fecord = date("d-m-Y", strtotime($listar['FECHA']));
							
							$colornom = "#000000";
                            $colorare = "#000000";
                            $colorest = "#000000";

						    echo" 
								<tr>
                                    <td><h4 style='font-size:12px;text-align: center;'>".$fecord."</h4></td>

									<td><h4 style='font-size:12px;text-align: center;'><font color=".colorear($nom, $listar['NOMBRE'], $colornom)."'>".$listar['NOMBRE']."</font></h4></td>

									<td><h4 style='font-size:12px;text-align: center;'><font color=".colorear($are, $listar['AREA'], $colorare)."'>".$listar['AREA']."</font></h4></td>

									<td><h4 style='font-size:12px;text-align: center;'><font color=".colorear($est, $listar['ESTADO'], $colorest)."'>".$listar['ESTADO']."</font></h4></td>

								</tr>";

							$nom = $listar['NOMBRE'];
							$are = $listar['AREA'];
							$est = $listar['ESTADO'];
						}
					echo "</table>";
			?>
		</div>
	</div>
	</section>
</body>
</html>