<?php 
error_reporting(0);
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
    <h2>EQUIPO ACTUAL</h2>
		<div id="grilla">
		<?php
				echo "<table class=g1 width=100%>
						<thead class=g1>
							<tr>
								<th><p class=a>PLACA MADRE</p></th>
								<th><p class=a>MICRO</p></th>
                                <th><p class=a>PLACAS VIDEO</p></th>
                                <th><p class=a>MEMORIAS</p></th>
                                <th><p class=a>DISCOS</p></th>
							</tr>
						</thead>";
                        $equipo = $consulta[0];
                        $consultar=mysqli_query($datos_base, "SELECT ID_WS
                        FROM inventario
                        WHERE ID_WS = $equipo");
						while($listar = mysqli_fetch_array($consultar))
						{
                            /* PLACA MADRE */
                            $sentencia = "SELECT p.PLACAM
                            FROM inventario i 
                            LEFT JOIN placamws pw ON pw.ID_WS = i.ID_WS
                            LEFT JOIN placam p ON p.ID_PLACAM = pw.ID_PLACAM
                            WHERE i.ID_WS = '$equipo'";
                            $resultado = $datos_base->query($sentencia);
                            $row = $resultado->fetch_assoc();
                            $placam = $row['PLACAM'];


                            /* DISCO */
                            $sentencia = "SELECT m.MICRO
                            FROM inventario i 
                            LEFT JOIN microws mws ON mws.ID_WS = i.ID_WS
                            LEFT JOIN micro m ON m.ID_MICRO= mws.ID_MICRO
                            WHERE i.ID_WS='$equipo'";
                            $resultado = $datos_base->query($sentencia);
                            $row = $resultado->fetch_assoc();
                            $micro = $row['MICRO'];



                            /* MEMORIAS */
                            $sqli = "SELECT w.ID_MEMORIA, m.MEMORIA, w.ID_WS 
                            FROM wsmem w
                            LEFT JOIN memoria AS m ON m.ID_MEMORIA = w.ID_MEMORIA
                            WHERE w.ID_WS = '$equipo' AND w.SLOT = 1";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem1 = $row2['MEMORIA'];

                            $sqli = "SELECT w.ID_MEMORIA, m.MEMORIA, w.ID_WS 
                            FROM wsmem w
                            LEFT JOIN memoria AS m ON m.ID_MEMORIA = w.ID_MEMORIA
                            WHERE w.ID_WS = '$equipo' AND w.SLOT = 2";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem2 = $row2['MEMORIA'];

                            $sqli = "SELECT w.ID_MEMORIA, m.MEMORIA, w.ID_WS 
                            FROM wsmem w
                            LEFT JOIN memoria AS m ON m.ID_MEMORIA = w.ID_MEMORIA
                            WHERE w.ID_WS = '$equipo' AND w.SLOT = 3";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem3 = $row2['MEMORIA'];

                            $sqli = "SELECT w.ID_MEMORIA, m.MEMORIA, w.ID_WS 
                            FROM wsmem w
                            LEFT JOIN memoria AS m ON m.ID_MEMORIA = w.ID_MEMORIA
                            WHERE w.ID_WS = '$equipo' AND w.SLOT = 4";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem4 = $row2['MEMORIA'];


                            /* TIPO MEMORIAS */
                            $sent= "SELECT t.TIPOMEM FROM wsmem w 
                            LEFT JOIN tipomem t ON t.ID_TIPOMEM = w.ID_TIPOMEM 
                            WHERE w.ID_WS = $equipo AND w.SLOT = 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $tmem1 = $row['TIPOMEM'];

                            $sent= "SELECT t.TIPOMEM FROM wsmem w 
                            LEFT JOIN tipomem t ON t.ID_TIPOMEM = w.ID_TIPOMEM 
                            WHERE w.ID_WS = $equipo AND w.SLOT = 2";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $tmem2 = $row['TIPOMEM'];

                            $sent= "SELECT t.TIPOMEM FROM wsmem w 
                            LEFT JOIN tipomem t ON t.ID_TIPOMEM = w.ID_TIPOMEM 
                            WHERE w.ID_WS = $equipo AND w.SLOT = 3";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $tmem3 = $row['TIPOMEM'];

                            $sent= "SELECT t.TIPOMEM FROM wsmem w 
                            LEFT JOIN tipomem t ON t.ID_TIPOMEM = w.ID_TIPOMEM 
                            WHERE w.ID_WS = $equipo AND w.SLOT = 4";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $tmem4 = $row['TIPOMEM'];


                            /* DISCOS */
                            $sent= "SELECT d.DISCO FROM discows dw 
                            LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO 
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $disc1 = $row['DISCO'];

                            $sent= "SELECT d.DISCO FROM discows dw 
                            LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO 
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 2";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $disc2 = $row['DISCO'];

                            $sent= "SELECT d.DISCO FROM discows dw 
                            LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO 
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 3";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $disc3 = $row['DISCO'];

                            $sent= "SELECT d.DISCO FROM discows dw 
                            LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO 
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 4";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $disc4 = $row['DISCO'];


                            /* TIPO DISCO */
                            $sent= "SELECT t.TIPOD FROM discows dw 
                            LEFT JOIN tipodisco t ON t.ID_TIPOD = dw.ID_TIPOD 
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $tdisc1 = $row['TIPOD'];

                            $sent= "SELECT t.TIPOD FROM discows dw 
                            LEFT JOIN tipodisco t ON t.ID_TIPOD = dw.ID_TIPOD 
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 2";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $tdisc2 = $row['TIPOD'];

                            $sent= "SELECT t.TIPOD FROM discows dw 
                            LEFT JOIN tipodisco t ON t.ID_TIPOD = dw.ID_TIPOD 
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 3";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $tdisc3 = $row['TIPOD'];

                            $sent= "SELECT t.TIPOD FROM discows dw 
                            LEFT JOIN tipodisco t ON t.ID_TIPOD = dw.ID_TIPOD 
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 4";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $tdisc4 = $row['TIPOD'];

						    echo" 
								<tr>
                                    <td><h4 style='font-size:12px; text-align: center;'>".$placam."</h4></td>
                                    <td><h4 style='font-size:12px; text-align: center;'>".$micro."</h4></td>
                                    <td><h4 style='font-size:12px; text-align: center;'>".'asd'."</h4></td>
                                    <td><h4 style='font-size:12px; text-align: center;'>".$mem1.' - '.$tmem1.' <br> '.$mem2.' - '.$tmem2.' <br> '.$mem3.' - '.$tmem3.' <br> '.$mem4.' - '.$tmem4."</h4></td>
                                    <td><h4 style='font-size:12px; text-align: center;'>".$disc1.' - '.$tdisc1.' <br> '.$disc2.' - '.$tdisc2.' <br> '.$disc3.' - '.$tdisc3.' <br> '.$disc4.' - '.$tdisc4."</h4></td>
								</tr>";
						}
					echo "</table>";
			?>
        </div>
        <div id="grillaini">
        <h2>EQUIPO INICIAL</h2>
		<?php
				echo "<table class=g1 width=100%>
						<thead class=g1>
							<tr>
								<th><p class=a>PLACA MADRE</p></th>
								<th><p class=a>MICRO</p></th>
                                <th><p class=a>PLACAS VIDEO</p></th>
                                <th><p class=a>MEMORIAS</p></th>
                                <th><p class=a>DISCOS</p></th>
							</tr>
						</thead>";
                        $equipo = $consulta[0];
                        $consultar=mysqli_query($datos_base, "SELECT m.ID_WS, p.PLACAM, mi.MICRO
                        FROM mejoras m 
                        LEFT JOIN inventario AS i ON i.ID_WS = m.ID_WS
                        LEFT JOIN placam AS p ON p.ID_PLACAM = m.ID_PLACAM
                        LEFT JOIN micro AS mi ON mi.ID_MICRO = m.ID_MICRO
                        WHERE m.ID_WS = $equipo
                        LIMIT 1");
						while($listar = mysqli_fetch_array($consultar))
						{

                            /* MEMORIAS */
                            $sqli = "SELECT MEMORIA1
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$m1 = $row2['MEMORIA1'];


                            $sqli = "SELECT MEMORIA
                            FROM memoria
                            WHERE ID_MEMORIA = '$m1'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem1 = $row2['MEMORIA'];


                            $sqli = "SELECT MEMORIA2
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$m2 = $row2['MEMORIA2'];

                            $sqli = "SELECT MEMORIA
                            FROM memoria
                            WHERE ID_MEMORIA = '$m2'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem2 = $row2['MEMORIA'];

                            $sqli = "SELECT MEMORIA3
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$m3 = $row2['MEMORIA3'];

                            $sqli = "SELECT MEMORIA
                            FROM memoria
                            WHERE ID_MEMORIA = '$m3'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem3 = $row2['MEMORIA'];

                            $sqli = "SELECT MEMORIA4
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$m4 = $row2['MEMORIA4'];

                            $sqli = "SELECT MEMORIA
                            FROM memoria
                            WHERE ID_MEMORIA = '$m4'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem4 = $row2['MEMORIA'];


                            /* TIPO MEMORIAS */
                            $sent= "SELECT TIPOMEM1
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $t1 = $row['TIPOMEM1'];

                            $sqli = "SELECT TIPOMEM
                            FROM tipomem
                            WHERE ID_TIPOMEM = '$t1'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tmem1 = $row2['TIPOMEM'];


                            $sent= "SELECT TIPOMEM2
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $t2 = $row['TIPOMEM2'];

                            $sqli = "SELECT TIPOMEM
                            FROM tipomem
                            WHERE ID_TIPOMEM = '$t2'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tmem2 = $row2['TIPOMEM'];


                            $sent= "SELECT TIPOMEM3
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $t3 = $row['TIPOMEM3'];

                            $sqli = "SELECT TIPOMEM
                            FROM tipomem
                            WHERE ID_TIPOMEM = '$t3'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tmem3 = $row2['TIPOMEM'];


                            $sent= "SELECT TIPOMEM4
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $t4 = $row['TIPOMEM4'];

                            $sqli = "SELECT TIPOMEM
                            FROM tipomem
                            WHERE ID_TIPOMEM = '$t4'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tmem4 = $row2['TIPOMEM'];


                            /* DISCOS */
                            $sent= "SELECT DISCO1
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $d1 = $row['DISCO1'];

                            $sqli = "SELECT DISCO
                            FROM disco
                            WHERE ID_DISCO = '$d1'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$disc1 = $row2['DISCO'];


                            $sent= "SELECT DISCO2
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $d2 = $row['DISCO2'];

                            $sqli = "SELECT DISCO
                            FROM disco
                            WHERE ID_DISCO = '$d2'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$disc2 = $row2['DISCO'];


                            $sent= "SELECT DISCO3
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $d3 = $row['DISCO3'];

                            $sqli = "SELECT DISCO
                            FROM disco
                            WHERE ID_DISCO = '$d3'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$disc3 = $row2['DISCO'];


                            $sent= "SELECT DISCO4
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $d4 = $row['DISCO4'];

                            $sqli = "SELECT DISCO
                            FROM disco
                            WHERE ID_DISCO = '$d4'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$disc4 = $row2['DISCO'];



                            /* TIPO DISCO */
                            $sent= "SELECT TIPOD1
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $td1 = $row['TIPOD1'];

                            $sqli = "SELECT TIPOD
                            FROM tipodisco
                            WHERE ID_TIPOD = '$td1'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tdisc1 = $row2['TIPOD'];


                            $sent= "SELECT TIPOD2
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $td2 = $row['TIPOD2'];

                            $sqli = "SELECT TIPOD
                            FROM tipodisco
                            WHERE ID_TIPOD = '$td2'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tdisc2 = $row2['TIPOD'];


                            $sent= "SELECT TIPOD3
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $td3 = $row['TIPOD3'];

                            $sqli = "SELECT TIPOD
                            FROM tipodisco
                            WHERE ID_TIPOD = '$td3'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tdisc3 = $row2['TIPOD'];


                            $sent= "SELECT TIPOD4
                            FROM mejoras
                            WHERE ID_WS = '$equipo'
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $td4 = $row['TIPOD4'];

                            $sqli = "SELECT TIPOD
                            FROM tipodisco
                            WHERE ID_TIPOD = '$td4'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tdisc4 = $row2['TIPOD'];

						    echo" 
								<tr>
                                    <td><h4 style='font-size:12px; text-align: center;'>".$listar['PLACAM']."</h4></td>
                                    <td><h4 style='font-size:12px; text-align: center;'>".$listar['MICRO']."</h4></td>
                                    <td><h4 style='font-size:12px; text-align: center;'>".'asd'."</h4></td>
                                    <td><h4 style='font-size:12px; text-align: center;'>".$mem1.' - '.$tmem1.' <br> '.$mem2.' - '.$tmem2.' <br> '.$mem3.' - '.$tmem3.' <br> '.$mem4.' - '.$tmem4."</h4></td>
                                    <td><h4 style='font-size:12px; text-align: center;'>".$disc1.' - '.$tdisc1.' <br> '.$disc2.' - '.$tdisc2.' <br> '.$disc3.' - '.$tdisc3.' <br> '.$disc4.' - '.$tdisc4."</h4></td>
								</tr>";
						}
					echo "</table>";
			?>
		</div>
        <div id="grillamov">
        <h2>MOVIMIENTOS</h2>
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
								<th><p class=g>PLACA MADRE</p></th>
								<th><p class=g>MICRO</p></th>
                                <th><p class=g>PLACAS VIDEO</p></th>
                                <th><p class=g>MEMORIAS</p></th>
                                <th><p class=g>DISCOS</p></th>
							</tr>
						</thead>";
                        $equipo = $consulta[0];
                        $consultar=mysqli_query($datos_base, "SELECT m.ID_WS, m.FECHA, p.PLACAM, mi.MICRO, m.MEMORIA1, m.TIPOMEM1, m.FRECUENCIA1, m.MEMORIA2, m.TIPOMEM2, m.FRECUENCIA2, m.MEMORIA3, m.TIPOMEM3, m.FRECUENCIA3, m.MEMORIA4, m.TIPOMEM4, m.FRECUENCIA4, DISCO1, TIPOD1, DISCO2, TIPOD2, DISCO3, TIPOD3, DISCO4, TIPOD4
                        FROM mejoras m
                        LEFT JOIN placam AS p ON p.ID_PLACAM = m.ID_PLACAM
                        LEFT JOIN micro AS mi ON mi.ID_MICRO = m.ID_MICRO
                        WHERE m.ID_WS = $equipo
                        ORDER BY m.FECHA ASC");
						while($listar = mysqli_fetch_array($consultar))
						{
                            $f = $listar['FECHA'];

                            /* MEMORIAS */
                            $sqli = "SELECT MEMORIA
                            FROM memoria
                            WHERE ID_MEMORIA = '$listar[MEMORIA1]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem1 = $row2['MEMORIA'];

                            $sqli = "SELECT MEMORIA
                            FROM memoria
                            WHERE ID_MEMORIA = '$listar[MEMORIA2]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem2 = $row2['MEMORIA'];

                            $sqli = "SELECT MEMORIA
                            FROM memoria
                            WHERE ID_MEMORIA = '$listar[MEMORIA3]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem3 = $row2['MEMORIA'];

                            $sqli = "SELECT MEMORIA
                            FROM memoria
                            WHERE ID_MEMORIA = '$listar[MEMORIA4]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem4 = $row2['MEMORIA'];


                            /* TIPO MEMORIAS */
                            $sqli = "SELECT TIPOMEM
                            FROM tipomem
                            WHERE ID_TIPOMEM = '$listar[TIPOMEM1]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tmem1 = $row2['TIPOMEM'];

                            $sqli = "SELECT TIPOMEM
                            FROM tipomem
                            WHERE ID_TIPOMEM = '$listar[TIPOMEM2]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tmem2 = $row2['TIPOMEM'];

                            $sqli = "SELECT TIPOMEM
                            FROM tipomem
                            WHERE ID_TIPOMEM = '$listar[TIPOMEM3]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tmem3 = $row2['TIPOMEM'];

                            $sqli = "SELECT TIPOMEM
                            FROM tipomem
                            WHERE ID_TIPOMEM = '$listar[TIPOMEM4]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tmem4 = $row2['TIPOMEM'];


                            /* DISCOS */
                            $sqli = "SELECT DISCO
                            FROM disco
                            WHERE ID_DISCO = '$listar[DISCO1]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$disc1 = $row2['DISCO'];

                            $sqli = "SELECT DISCO
                            FROM disco
                            WHERE ID_DISCO = '$listar[DISCO2]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$disc2 = $row2['DISCO'];

                            $sqli = "SELECT DISCO
                            FROM disco
                            WHERE ID_DISCO = '$listar[DISCO3]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$disc3 = $row2['DISCO'];

                            $sqli = "SELECT DISCO
                            FROM disco
                            WHERE ID_DISCO = '$listar[DISCO4]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$disc4 = $row2['DISCO'];


                            /* TIPO DISCO */
                            $sqli = "SELECT TIPOD
                            FROM tipodisco
                            WHERE ID_TIPOD = '$listar[TIPOD1]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tdisc1 = $row2['TIPOD'];

                            $sqli = "SELECT TIPOD
                            FROM tipodisco
                            WHERE ID_TIPOD = '$listar[TIPOD1]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tdisc2 = $row2['TIPOD'];

                            $sqli = "SELECT TIPOD
                            FROM tipodisco
                            WHERE ID_TIPOD = '$listar[TIPOD3]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tdisc3 = $row2['TIPOD'];

                            $sqli = "SELECT TIPOD
                            FROM tipodisco
                            WHERE ID_TIPOD = '$listar[TIPOD4]'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$tdisc4 = $row2['TIPOD'];




                            
                            $colorp = "#000000";
                            $colormi = "#000000";
                            $colorme = "#000000";
                            $colord = "#000000";


                            $fecord = date("d-m-Y", strtotime($f));
						    echo" 
								<tr>
                                    <td><h4 style='font-size:12px; text-align: center;'>".$fecord."</h4></td>

                                    <td><h4 style='font-size:12px; text-align: center; color:".colorear($pm, $listar['PLACAM'], $colorp)."'>".$listar['PLACAM']."</h4></td>

                                    <td><h4 style='font-size:12px; text-align: center;color:".colorear($m, $listar['MICRO'], $colormi)."'>".$listar['MICRO']."</h4></td>

                                    <td><h4 style='font-size:12px; text-align: center;'>".'-'."</h4></td>




                                    <td><h4 style='font-size:12px; text-align: center;color:'>
                                    <font color=".colorear($mee1, $mem1, $colorme).">".$mem1.'</font> - 
                                    <font color="'.colorear($tmee1, $tmem1, $colorme).'">'.$tmem1.'</font> <br> 

                                    <font color="'.colorear($mee2, $mem2, $colorme).'">'.$mem2.'</font> - 
                                    <font color="'.colorear($tmee2, $tmem2, $colorme).'">'.$tmem2.'</font> <br> 

                                    <font color="'.colorear($mee3, $mem3, $colorme).'">'.$mem3.'</font> - 
                                    <font color="'.colorear($tmee3, $tmem3, $colorme).'">'.$tmem3.'</font> <br> 

                                    <font color="'.colorear($mee4, $mem4, $colorme).'">'.$mem4.'</font> - 
                                    <font color="'.colorear($tmee3, $tmem3, $colorme).'">'.$tmem4."</font></h4></td>



                                    <td><h4 style='font-size:12px; text-align: center;color:'>
                                    <font color=".colorear($d1, $disc1, $colord).">".$disc1.'</font> - 
                                    <font color="'.colorear($td1, $tdisc1, $colord).'">'.$tdisc1.'</font> <br> 

                                    <font color="'.colorear($d2, $disc2, $colord).'">'.$disc2.'</font> - 
                                    <font color="'.colorear($td2, $tdisc2, $colord).'">'.$tdisc2.'</font> <br> 

                                    <font color="'.colorear($d3, $disc3, $colord).'">'.$disc3.'</font> - 
                                    <font color="'.colorear($td3, $tdisc3, $colord).'">'.$tdisc3.'</font> <br> 

                                    <font color="'.colorear($d4, $disc4, $colord).'">'.$disc4.'</font> - 
                                    <font color="'.colorear($td4, $tdisc4, $colord).'">'.$tdisc4."</font></h4></td>
								</tr>";

                                $pm = $listar['PLACAM'];
                                $m = $listar['MICRO'];
                                $mee1 = $mem1;
                                $mee2 = $mem2;
                                $mee3 = $mem3;
                                $mee4 = $mem4;
                                $tmee1 = $tmem1;
                                $tmee2 = $tmem2;
                                $tmee3 = $tmem3;
                                $tmee4 = $tmem4;

                                $d1 = $disc1;
                                $d2 = $disc2;
                                $d3 = $disc3;
                                $d4 = $disc4;
                                $td1 = $tdisc1;
                                $td2 = $tdisc2;
                                $td3 = $tdisc3;
                                $td4 = $tdisc4;
						}
					echo "</table>";
			?>
		</div>
	</div>
	</section>
</body>
</html>