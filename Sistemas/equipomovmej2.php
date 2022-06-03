<?php 
/* error_reporting(0); */
session_start();
include('conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM mejoras WHERE ID_WS='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_WS'],/*0*/
        $filas['FECHA'],/*1*/
        $filas['ID_PLACAM'],/*2*/
        $filas['ID_MICRO'],/*3*/
        $filas['PVIDEO1'],/*4*/
        $filas['PVIDEO2'],/*5*/
        $filas['MEMORIA1'],/*6*/
        $filas['TIPOMEM1'],/*7*/
        $filas['FRECUENCIA1'],/*8*/
        $filas['MEMORIA2'],/*9*/
        $filas['TIPOMEM2'],/*10*/
        $filas['FRECUENCIA2'],/*11*/
        $filas['MEMORIA3'],/*12*/
        $filas['TIPOMEM3'],/*13*/
        $filas['FRECUENCIA3'],/*14*/
        $filas['MEMORIA4'],/*15*/
        $filas['TIPOMEM4'],/*16*/
        $filas['FRECUENCIA4'],/*17*/
        $filas['DISCO1'],/*18*/
        $filas['TIPOD1'],/*19*/
        $filas['DISCO2'],/*20*/
        $filas['TIPOD2'],/*21*/
        $filas['DISCO3'],/*22*/
        $filas['TIPOD3'],/*23*/
        $filas['DISCO4'],/*24*/
        $filas['TIPOD4']/*25*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>MEJORAS</title>
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
			<h1>MEJORAS EQUIPO <?php echo $serg?></h1>
		</div>
	</header>
	<section id="movimientos">
		<div id="grilla">
		<?php
				echo "<table width=100%>
						<thead>
							<tr>
                                <th><p class=g>FECHA</p></th>
								<th><p class=g>USUARIO</p></th>
								<th><p class=g>PLACA MADRE</p></th>
								<th><p class=g>MICRO</p></th>
                                <th><p class=g>PLACAS VIDEO</p></th>
                                <th><p class=g>MEMORIAS</p></th>
                                <th><p class=g>TIPO MEMORIAS</p></th>
                                <th><p class=g>DISCOS</p></th>
                                <th><p class=g>TIPO DISCOS</p></th>
							</tr>
						</thead>";
                        $equipo = $consulta[0];
                        $consultar=mysqli_query($datos_base, "SELECT m.ID_WS, m.FECHA, u.NOMBRE, p.PLACAM, mi.MICRO
                        FROM mejoras m 
                        LEFT JOIN inventario AS i ON i.ID_WS = m.ID_WS
                        LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
                        LEFT JOIN placam AS p ON p.ID_PLACAM = m.ID_PLACAM
                        LEFT JOIN micro AS mi ON mi.ID_MICRO = m.ID_MICRO
                        WHERE m.ID_WS = $equipo
                        ORDER BY m.FECHA ASC");
						while($listar = mysqli_fetch_array($consultar))
						{
                            $fecord = date("d-m-Y", strtotime($listar['FECHA']));
						    echo" 
								<tr>
                                    <td><h4 style='font-size:14px;'>".$fecord."</h4></td>
                                    <td><h4 style='font-size:14px;'>".$listar['NOMBRE']."</h4></td>
                                    <td><h4 style='font-size:14px;'>".$listar['PLACAM']."</h4></td>
                                    <td><h4 style='font-size:14px;'>".$listar['MICRO']."</h4></td>
								</tr>";
						}
					echo "</table>";
			?>
		</div>
	</div>
	</section>
</body>
</html>