<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM movimientos WHERE ID_WS='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_WS'],/*0*/
        $filas['ID_USUARIO'],/*2*/
        $filas['ID_AREA'],/*3*/
        $filas['ID_ESTADOWS'],/*4*/
        $filas['ID_MARCA'],/*5*/
        $filas['ID_SO'],/*6*/
        $filas['MASTERIZADA'],/*7*/
        $filas['MAC'],/*8*/
        $filas['RIP'],/*9*/
        $filas['IP'],/*10*/
        $filas['ID_RED']/*11*/
	];
}

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
			<a id="vlv"  href="inventario.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
		</div>					
	</div>
    <div id="titulo" style="margin-top: 0px; margin-bottom: 30px;">
                <?php
                $sql = "SELECT SERIEG FROM inventario WHERE ID_WS='$consulta[0]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $serg = $row['SERIEG'];
                ?>
			<h1>MOVIMIENTOS EQUIPO <?php echo $serg?></h1>
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
                                <th><p class=g>MARCA</p></th>
                                <th><p class=g>S.O.</p></th>
                                <th><p class=g>MASTER</p></th>
                                <th><p class=g>MAC</p></th>
                                <th><p class=g>RIP</p></th>
                                <th><p class=g>IP</p></th>
                                <th><p class=g>RED</p></th>
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
                            $fecord = date("d-m-Y", strtotime($listar['FECHA']));
							
							$colornom = "#000000";
                            $colorare = "#000000";
                            $colorest = "#000000";
                            $colormar = "#000000";
							$colorsis = "#000000";
                            $colormas = "#000000";
                            $colormac = "#000000";
							$colorrip = "#000000";
                            $colorip = "#000000";
                            $colorred = "#000000";

						    echo" 
								<tr>
                                    <td><h4 style='font-size:12px;'>".$fecord."</h4></td>


									<td><h4 style='font-size:12px;'><font color=".colorear($nom, $listar['NOMBRE'], $colornom)."'>".$listar['NOMBRE']."</font></h4></td>

									<td><h4 style='font-size:12px;'><font color=".colorear($are, $listar['AREA'], $colorare)."'>".$listar['AREA']."</font></h4></td>

									<td><h4 style='font-size:12px;'><font color=".colorear($est, $listar['ESTADO'], $colorest)."'>".$listar['ESTADO']."</font></h4></td>

									<td><h4 style='font-size:12px;'><font color=".colorear($mar, $listar['MARCA'], $colormar)."'>".$listar['MARCA']."</font></h4></td>

									<td><h4 style='font-size:12px;'><font color=".colorear($sis, $listar['SIST_OP'], $colorsis)."'>".$listar['SIST_OP']."</font></h4></td>

									<td><h4 style='font-size:12px;'><font color=".colorear($mas, $listar['MASTERIZADA'], $colormas)."'>".$listar['MASTERIZADA']."</font></h4></td>

									<td><h4 style='font-size:12px;'><font color=".colorear($mac, $listar['MAC'], $colormac)."'>".$listar['MAC']."</font></h4></td>

									<td><h4 style='font-size:12px;'><font color=".colorear($rip, $listar['RIP'], $colorrip)."'>".$listar['RIP']."</font></h4></td>

									<td><h4 style='font-size:12px;'><font color=".colorear($ip, $listar['IP'], $colorip)."'>".$listar['IP']."</font></h4></td>

									<td><h4 style='font-size:12px;'><font color=".colorear($red, $listar['RED'], $colorred)."'>".$listar['RED']."</font></h4></td>
								</tr>";

							$nom = $listar['NOMBRE'];
							$are = $listar['AREA'];
							$est = $listar['ESTADO'];
							$mar = $listar['MARCA'];
							$sis = $listar['SIST_OP'];
							$mas = $listar['MASTERIZADA'];
							$mac = $listar['MAC'];
							$rip = $listar['RIP'];
							$ip = $listar['IP'];
							$red = $listar['RED'];
						}
					echo "</table>";
			?>
		</div>
	</div>
	</section>
</body>
</html>