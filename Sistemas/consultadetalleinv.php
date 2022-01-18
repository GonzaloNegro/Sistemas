<?php 
session_start();
include('conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM inventario WHERE ID_WS='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_WS'],/*0*/
		$filas['ID_AREA'],/*1*/
		$filas['SERIALN'],/*2*/
        $filas['SERIEG'],/*3*/
        $filas['ID_MARCA'],/*4*/
		$filas['MOTHERBOARD'],/*5*/
		$filas['ID_SO'],/*6*/
		$filas['MICRO'],/*7*/
		$filas['ID_ESTADOWS'],/*8*/
        $filas['OBSERVACION'],/*9*/
		$filas['ID_PROVEEDOR'],/*10*/
        $filas['FACTURA'],/*11*/
		$filas['MASTERIZADA'],/*12*/
        $filas['MAC'],/*13*/
        $filas['ID_RED'],/*14*/
		$filas['ID_TIPOWS'],/*15*/
        $filas['ID_USUARIO'],/*16*/
		$filas['GARANTIA']/*17*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloconsultadetalleinv.css">
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
    <div id="titulo">
			<h1>DETALLES DEL EQUIPO</h1>
		</div>
        <div class="form-group row justify-content-end" style="margin-top: 0px; margin-left: 10px; margin-right: 10px; padding:10px;">
	      
          <button id="pr" class="btn btn-success" style="width: 50px; border-radius: 10px; height: 45px;" onClick="imprimir()"><i class='bi bi-printer'></i></button>
		</div>
		
		<style type="text/css" media="print">
          @media print {
          
          #pr {display:none;}
		  #vlv {display:none;}
          }
         </style>
	  	<script>
          function imprimir() {
            	window.print();
          }
        </script>
	</header>
	<section id="ingreso">
            <div id="detalles">
            <?php
                /*/////////////////////NOMBRE//////////////////////*/
                $sql = "SELECT u.NOMBRE FROM inventario i LEFT JOIN usuarios u ON i.ID_USUARIO = u.ID_USUARIO WHERE i.ID_USUARIO='$consulta[16]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $nom = $row['NOMBRE'];
                /*/////////////////////AREA//////////////////////*/
                $sql = "SELECT a.AREA FROM inventario i INNER JOIN area a ON a.ID_AREA = i.ID_AREA WHERE i.ID_AREA='$consulta[1]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $are = $row['AREA'];
                /*/////////////////////ESTADO//////////////////////*/
                $sql = "SELECT e.ESTADO FROM inventario i INNER JOIN estado_ws e ON e.ID_ESTADOWS = i.ID_ESTADOWS WHERE i.ID_ESTADOWS='$consulta[8]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $est = $row['ESTADO'];
                /*/////////////////////TIPO//////////////////////*/
                $sql = "SELECT t.TIPOWS FROM inventario i LEFT JOIN tipows t ON t.ID_TIPOWS = i.ID_TIPOWS WHERE i.ID_TIPOWS='$consulta[15]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $tip = $row['TIPOWS'];
                /*/////////////////////MARCA//////////////////////*/
                $sql = "SELECT m.MARCA FROM inventario i INNER JOIN marcas m ON m.ID_MARCA = i.ID_MARCA WHERE i.ID_MARCA='$consulta[4]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $mar = $row['MARCA'];
                 /*/////////////////////SO//////////////////////*/
                 $sql = "SELECT s.SIST_OP FROM inventario i INNER JOIN so s ON s.ID_SO = i.ID_SO WHERE i.ID_SO='$consulta[6]'";
                 $resultado = $datos_base->query($sql);
                 $row = $resultado->fetch_assoc();
                 $so = $row['SIST_OP'];
             ?>
            <h4><u>USUARIO RESPONSABLE:</u>&nbsp &nbsp &nbsp<?php echo $nom ?></h4>
            <h4><u>ÁREA DE UBICACIÓN:</u>&nbsp &nbsp &nbsp<?php echo $are?></h4>
            <hr style='display: block; height: 3px;'>
            <h4><u>EQUIPO:</u>&nbsp &nbsp &nbsp<?php echo $consulta[3]?></h4>
            <h4><u>ESTADO DEL EQUIPO:</u>&nbsp &nbsp &nbsp<?php echo $est?></h4>
            <h4><u>TIPO DE EQUIPO:</u>&nbsp &nbsp &nbsp<?php echo $tip?></h4>
            <h4><u>MARCA:</u>&nbsp &nbsp &nbsp<?php echo $mar?></h4>
            <hr style='display: block; height: 3px;'>
            <h4><u>SISTEMA OPERATIVO:</u>&nbsp &nbsp &nbsp<?php echo $so?></h4>
            <h4><u>PLACA MADRE:</u>&nbsp &nbsp &nbsp<?php echo $consulta[5]?></h4>
            <h4><u>PROCESADOR:</u>&nbsp &nbsp &nbsp<?php echo $consulta[7]?></h4>
            <h4><u>SERIALN:</u>&nbsp &nbsp &nbsp<?php echo $consulta[2]?></h4>
            <h4><u>MASTERIZACIÓN:</u>&nbsp &nbsp &nbsp<?php echo $consulta[12]?></h4>
            <h4><u>RED:</u>&nbsp &nbsp &nbsp<?php echo $consulta[14]?></h4>
            <h4><u>NRO MAC:</u>&nbsp &nbsp &nbsp<?php echo $consulta[13]?></h4>
            <hr style='display: block; height: 3px;'>
            <h4><u>PROVEEDOR:</u>&nbsp &nbsp &nbsp<?php echo $consulta[10]?></h4>
            <h4><u>FACTURA:</u>&nbsp &nbsp &nbsp<?php echo $consulta[11]?></h4>
            <h4><u>GARANTIA:</u>&nbsp &nbsp &nbsp<?php echo $consulta[17]?></h4>
            <hr style='display: block; height: 3px;'>
            <h4><u>OBSERVACIÓN:</u>&nbsp &nbsp &nbsp<?php echo $consulta[9]?></h4><br>
            </div>
            <div id="volver">
			    <a id="vlv" href="inventario.php" class="btn btn-primary">VOLVER</a>
		    </div><br>
	</section>
</body>
</html>