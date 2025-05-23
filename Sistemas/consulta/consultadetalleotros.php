<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT p.ID_PERI, p.ID_TIPOP, p.NOMBREP, p.SERIEG, p.ID_MARCA, p.SERIE, p.ID_PROCEDENCIA, p.OBSERVACION, p.TIPOP, p.MAC, p.RIP, p.IP, 
    p.ID_PROVEEDOR, p.FACTURA, u.ID_AREA, u.ID_USUARIO, p.GARANTIA, p.ID_ESTADOWS FROM periferico p LEFT JOIN equipo_periferico ep ON p.ID_PERI=ep.ID_PERI
    LEFT JOIN inventario i ON ep.ID_WS=i.ID_WS
    LEFT JOIN wsusuario ws ON i.ID_WS=ws.ID_WS
    LEFT JOIN usuarios u ON ws.ID_USUARIO=u.ID_USUARIO
    LEFT JOIN area AS a ON a.ID_AREA = u.ID_AREA WHERE p.ID_PERI='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_PERI'],/*0*/
		$filas['ID_TIPOP'],/*1*/
		$filas['NOMBREP'],/*2*/
        $filas['SERIEG'],/*3*/
        $filas['ID_MARCA'],/*4*/
        $filas['SERIE'],/*5*/
		$filas['ID_PROCEDENCIA'],/*6*/
		$filas['OBSERVACION'],/*7*/
		$filas['TIPOP'],/*8*/
		$filas['MAC'],/*9*/
        $filas['RIP'],/*10*/
		$filas['IP'],/*11*/
        $filas['ID_PROVEEDOR'],/*12*/
		$filas['FACTURA'],/*13*/
        $filas['ID_AREA'],/*14*/
        $filas['ID_USUARIO'],/*15*/
		$filas['GARANTIA'],/*16*/
        $filas['ID_ESTADOWS'],/*17*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>DETALLES DE OTROS PERIFÉRICOS</title>
    <link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsultadetalleimp.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<header>
		<style type="text/css" media="print">
            @media print {
                #pr {display:none;}
                #vlv {display:none;}
                }
        </style>
        <script>
            function imprimir()
                {
                    window.print();
                }
        </script>
        
        <div class="form-group row justify-content-between" style="margin-top: 0px; margin-left: 10px; margin-right: 10px; padding:10px;">
	        <a id="vlv"  href="otrosp.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
            <div class="btn-group col-3" role="group" >
                <button style="border: none;"><a id="botonleft" class="btn btn-secondary"<?php echo "href=otrosmov.php?no=".$consulta[0].""?>>MOVIMIENTOS</a></button>
                <button id="botonright" type="button" class="btn btn-success" onClick="imprimir()" ><i class='bi bi-printer'></i></button>
            </div>
		</div>
    </header>
	<section id="ingreso">
        <div id="titulo">
                <h1>DETALLES DEL PERIFÉRICO</h1>
        </div>
            <div id="detalles">
            <?php
                /*/////////////////////NOMBRE//////////////////////*/
                $sql = "SELECT u.NOMBRE FROM usuarios u WHERE u.ID_USUARIO='$consulta[15]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $nom = $row['NOMBRE'];
                /*/////////////////////AREA//////////////////////*/
                $sql = "SELECT a.AREA FROM periferico p LEFT JOIN equipo_periferico ep ON p.ID_PERI=ep.ID_PERI
                LEFT JOIN inventario i ON ep.ID_WS=i.ID_WS
                LEFT JOIN wsusuario ws ON i.ID_WS=ws.ID_WS
                LEFT JOIN usuarios u ON ws.ID_USUARIO=u.ID_USUARIO
                LEFT JOIN area AS a ON a.ID_AREA = u.ID_AREA WHERE u.ID_AREA='$consulta[14]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $are = $row['AREA'];
                /*/////////////////////ESTADO//////////////////////*/
                $sql = "SELECT e.ESTADO FROM periferico p INNER JOIN estado_ws e ON e.ID_ESTADOWS = p.ID_ESTADOWS WHERE p.ID_ESTADOWS='$consulta[17]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $est = $row['ESTADO'];
                /*/////////////////////TIPO//////////////////////*/
                $sql = "SELECT t.TIPO FROM periferico p INNER JOIN tipop t ON t.ID_TIPOP = p.ID_TIPOP WHERE p.ID_TIPOP='$consulta[1]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $tip = $row['TIPO'];
                /*/////////////////////MARCA//////////////////////*/
                $sql = "SELECT m.MARCA FROM periferico p INNER JOIN marcas m ON m.ID_MARCA = p.ID_MARCA WHERE p.ID_MARCA='$consulta[4]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $mar = $row['MARCA'];
                 /*/////////////////////PROCEDENCIA//////////////////////*/
                 $sql = "SELECT pr.PROCEDENCIA FROM periferico p LEFT JOIN procedencia pr ON pr.ID_PROCEDENCIA = p.ID_PROCEDENCIA WHERE p.ID_PROCEDENCIA='$consulta[6]'";
                 $resultado = $datos_base->query($sql);
                 $row = $resultado->fetch_assoc();
                 $proce = $row['PROCEDENCIA'];
                 /*/////////////////////PROVEEDOR//////////////////////*/
                 $sql = "SELECT pr.PROVEEDOR FROM periferico p LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = p.ID_PROVEEDOR WHERE p.ID_PROVEEDOR='$consulta[12]'";
                 $resultado = $datos_base->query($sql);
                 $row = $resultado->fetch_assoc();
                 $prove = $row['PROVEEDOR'];
             ?>
            <h4><u>USUARIO RESPONSABLE:</u>&nbsp &nbsp &nbsp<?php echo $nom ?></h4>
            <h4><u>ÁREA DE UBICACIÓN:</u>&nbsp &nbsp &nbsp<?php echo $are?></h4>
            <hr style='display: block; height: 3px;'>
            <h4><u>TIPO:</u>&nbsp &nbsp &nbsp<?php echo $tip?></h4>
            <h4><u>ESTADO:</u>&nbsp &nbsp &nbsp<?php echo $est?></h4>
            <h4><u>N° WS:</u>&nbsp &nbsp &nbsp<?php echo $consulta[3]?></h4>
            <h4><u>MARCA:</u>&nbsp &nbsp &nbsp<?php echo $mar?></h4>
            <h4><u>N° SERIE:</u>&nbsp &nbsp &nbsp<?php echo $consulta[5]?></h4>
            <h4><u>PROCEDENCIA:</u>&nbsp &nbsp &nbsp<?php echo $proce?></h4>
            <hr style='display: block; height: 3px;'>
            <h4><u>MAC:</u>&nbsp &nbsp &nbsp<?php echo $consulta[9]?></h4>
            <h4><u>RIP:</u>&nbsp &nbsp &nbsp<?php echo $consulta[10]?></h4>
            <h4><u>IP:</u>&nbsp &nbsp &nbsp<?php echo $consulta[11]?></h4>
            <hr style='display: block; height: 3px;'>
            <h4><u>PROVEEDOR:</u>&nbsp &nbsp &nbsp<?php echo $prove?></h4>
            <h4><u>N° FACTURA:</u>&nbsp &nbsp &nbsp<?php echo $consulta[13]?></h4>
            <h4><u>GARANTIA:</u>&nbsp &nbsp &nbsp<?php echo $consulta[16]?></h4>
            <hr style='display: block; height: 3px;'>
            <h4><u>OBSERVACIÓN:</u>&nbsp &nbsp &nbsp<?php echo $consulta[7]?></h4><br>
            </div>
	</section>
</body>
</html>