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
    <h2>EQUIPO ACTUAL</h2>
		<div id="grilla">
		<?php
				echo "<table class=g1 width=100%>
						<thead class=g1>
							<tr>
								<th><p class=a>USUARIO</p></th>
								<th><p class=a>PLACA MADRE</p></th>
								<th><p class=a>MICRO</p></th>
                                <th><p class=a>PLACAS VIDEO</p></th>
                                <th><p class=a>MEMORIAS</p></th>
                                <th><p class=a>TIPO MEMORIAS</p></th>
                                <th><p class=a>DISCOS</p></th>
                                <th><p class=a>TIPO DISCOS</p></th>
							</tr>
						</thead>";
                        $equipo = $consulta[0];
                        $consultar=mysqli_query($datos_base, "SELECT i.ID_WS, u.NOMBRE
                        FROM inventario i 
                        LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
                        WHERE i.ID_WS = $equipo");
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
                                    <td><h4 style='font-size:12px;'>".$listar['NOMBRE']."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$placam."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$micro."</h4></td>
                                    <td><h4 style='font-size:12px;'>".'asd'."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$mem1.' - '.$mem2.' - '.$mem3.' - '.$mem4."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$tmem1.' - '.$tmem2.' - '.$tmem3.' - '.$tmem4."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$disc1.' - '.$disc2.' - '.$disc3.' - '.$disc4."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$tdisc1.' - '.$tdisc2.' - '.$tdisc3.' - '.$tdisc4."</h4></td>
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
								<th><p class=a>USUARIO</p></th>
								<th><p class=a>PLACA MADRE</p></th>
								<th><p class=a>MICRO</p></th>
                                <th><p class=a>PLACAS VIDEO</p></th>
                                <th><p class=a>MEMORIAS</p></th>
                                <th><p class=a>TIPO MEMORIAS</p></th>
                                <th><p class=a>DISCOS</p></th>
                                <th><p class=a>TIPO DISCOS</p></th>
							</tr>
						</thead>";
                        $equipo = $consulta[0];
                        $consultar=mysqli_query($datos_base, "SELECT m.ID_WS, u.NOMBRE, p.PLACAM, mi.MICRO
                        FROM mejoras m 
                        LEFT JOIN inventario AS i ON i.ID_WS = m.ID_WS
                        LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
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
                            WHERE ID_WS = '$equipo'";
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
                            WHERE ID_WS = '$equipo'";
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
                            WHERE ID_WS = '$equipo'";
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
                            WHERE ID_WS = '$equipo'";
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
                            $sent= "SELECT d.DISCO
                            FROM discows dw 
                            LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO
                            LEFT JOIN mejoras AS me ON me.ID_WS = dw.ID_WS
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 1
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $disc1 = $row['DISCO'];

                            $sent= "SELECT d.DISCO
                            FROM discows dw 
                            LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 2
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $disc2 = $row['DISCO'];

                            $sent= "SELECT d.DISCO
                            FROM discows dw 
                            LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 3
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $disc3 = $row['DISCO'];

                            $sent= "SELECT d.DISCO
                            FROM discows dw 
                            LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 4
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $disc4 = $row['DISCO'];


                            /* TIPO DISCO */
                            $sent= "SELECT t.TIPOD
                            FROM discows dw 
                            LEFT JOIN tipodisco t ON t.ID_TIPOD = dw.ID_TIPOD 
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 1
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $tdisc1 = $row['TIPOD'];

                            $sent= "SELECT t.TIPOD
                            FROM discows dw 
                            LEFT JOIN tipodisco t ON t.ID_TIPOD = dw.ID_TIPOD 
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 2
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $tdisc2 = $row['TIPOD'];

                            $sent= "SELECT t.TIPOD
                            FROM discows dw 
                            LEFT JOIN tipodisco t ON t.ID_TIPOD = dw.ID_TIPOD 
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 3
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $tdisc3 = $row['TIPOD'];

                            $sent= "SELECT t.TIPOD
                            FROM discows dw 
                            LEFT JOIN tipodisco t ON t.ID_TIPOD = dw.ID_TIPOD 
                            WHERE dw.ID_WS = $equipo AND dw.NUMERO = 4
                            LIMIT 1";
                            $resultado = $datos_base->query($sent);
                            $row = $resultado->fetch_assoc();
                            $tdisc4 = $row['TIPOD'];

						    echo" 
								<tr>
                                    <td><h4 style='font-size:12px;'>".$listar['NOMBRE']."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$listar['PLACAM']."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$listar['MICRO']."</h4></td>
                                    <td><h4 style='font-size:12px;'>".'asd'."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$mem1.' - '.$mem2.' - '.$mem3.' - '.$mem4."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$tmem1.' - '.$tmem2.' - '.$tmem3.' - '.$tmem4."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$disc1.' - '.$disc2.' - '.$disc3.' - '.$disc4."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$tdisc1.' - '.$tdisc2.' - '.$tdisc3.' - '.$tdisc4."</h4></td>
								</tr>";
						}
					echo "</table>";
			?>
		</div>
        <div id="grillamov">
        <h2>MOVIMIENTOS</h2>
		<?php
				echo "<table width=100%>
						<thead>
							<tr>
                                <th><p class=g>FECHA</p></th>
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
                        $consultar=mysqli_query($datos_base, "SELECT m.ID_WS, m.FECHA, p.PLACAM, mi.MICRO
                        FROM mejoras m
                        LEFT JOIN placam AS p ON p.ID_PLACAM = m.ID_PLACAM
                        LEFT JOIN micro AS mi ON mi.ID_MICRO = m.ID_MICRO
                        WHERE m.ID_WS = $equipo
                        ORDER BY m.FECHA ASC");
						while($listar = mysqli_fetch_array($consultar))
						{
                            $f = $listar['FECHA'];

                            /* MEMORIAS */
                            $sqli = "SELECT w.ID_MEMORIA, m.MEMORIA, w.ID_WS, me.FECHA
                            FROM mejoras me
                            LEFT JOIN wsmem AS w ON w.ID_WS = me.ID_WS
                            LEFT JOIN memoria AS m ON m.ID_MEMORIA = w.ID_MEMORIA
                            WHERE me.ID_WS = '$equipo' AND w.SLOT = 1 AND me.FECHA = '$f'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem1 = $row2['MEMORIA'];

                            $sqli = "SELECT w.ID_MEMORIA, m.MEMORIA, w.ID_WS, me.FECHA
                            FROM mejoras me
                            LEFT JOIN wsmem AS w ON w.ID_WS = me.ID_WS
                            LEFT JOIN memoria AS m ON m.ID_MEMORIA = w.ID_MEMORIA
                            WHERE me.ID_WS = '$equipo' AND w.SLOT = 2 AND me.FECHA = '$f'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem2 = $row2['MEMORIA'];

                            $sqli = "SELECT w.ID_MEMORIA, m.MEMORIA, w.ID_WS, me.FECHA
                            FROM mejoras me
                            LEFT JOIN wsmem AS w ON w.ID_WS = me.ID_WS
                            LEFT JOIN memoria AS m ON m.ID_MEMORIA = w.ID_MEMORIA
                            WHERE me.ID_WS = '$equipo' AND w.SLOT = 3 AND me.FECHA = '$f'";
							$resultado2 = $datos_base->query($sqli);
							$row2 = $resultado2->fetch_assoc();
							$mem3 = $row2['MEMORIA'];

                            $sqli = "SELECT w.ID_MEMORIA, m.MEMORIA, w.ID_WS, me.FECHA
                            FROM mejoras me
                            LEFT JOIN wsmem AS w ON w.ID_WS = me.ID_WS
                            LEFT JOIN memoria AS m ON m.ID_MEMORIA = w.ID_MEMORIA
                            WHERE me.ID_WS = '$equipo' AND w.SLOT = 4 AND me.FECHA = '$f'";
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

                            $fecord = date("d-m-Y", strtotime($listar['FECHA']));
						    echo" 
								<tr>
                                    <td><h4 style='font-size:12px;'>".$fecord."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$listar['PLACAM']."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$listar['MICRO']."</h4></td>
                                    <td><h4 style='font-size:12px;'>".'asd'."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$mem1.' - '.$mem2.' - '.$mem3.' - '.$mem4."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$tmem1.' - '.$tmem2.' - '.$tmem3.' - '.$tmem4."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$disc1.' - '.$disc2.' - '.$disc3.' - '.$disc4."</h4></td>
                                    <td><h4 style='font-size:12px;'>".$tdisc1.' - '.$tdisc2.' - '.$tdisc3.' - '.$tdisc4."</h4></td>
								</tr>";
						}
					echo "</table>";
			?>
		</div>
	</div>
	</section>
</body>
</html>