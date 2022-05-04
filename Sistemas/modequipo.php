<?php 
error_reporting(0);
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
        $filas['ID_SO'],/*5*/
        $filas['ID_ESTADOWS'],/*6*/
        $filas['OBSERVACION'],/*7*/
        $filas['ID_PROVEEDOR'],/*8*/
        $filas['FACTURA'],/*9*/
        $filas['MASTERIZADA'],/*10*/
        $filas['MAC'],/*11*/
        $filas['RIP'],/*12*/
        $filas['IP'],/*13*/
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
<title>MODIFICAR EQUIPO</title>
<link rel="icon" href="imagenes/logoObrasPúblicas.png">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloagregar.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript" src="jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="jquery/1/jquery-ui.js"></script>
  

  <script>
	$(document).ready(function(){
    $("#slcusu").change(function(){
        
		if ($("#slcusu").val() == '277') {
			$("#slcarea").prop('disabled', false);
		}
		if ($("#slcusu").val() != '277') {
			$("#slcarea").prop('disabled', true);
		}
    });
    });
</script>
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<div id="reporteEst" style="width: 97%; margin-left: 20px;">   
				<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
					<a id="vlv"  href="abmequipos.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
				</div>					
		</div>
	<section id="Inicio">
    <div id="titulo" style="margin: 20px;">
			<h1>MODIFICAR EQUIPO</h1>
		</div>
        <div id="principalu" style="width: 97%" class="container-fluid">
                <?php 
                    include("conexion.php");
                    $sent= "SELECT RED FROM red WHERE ID_RED = $consulta[14]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $red = $row['RED'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT SIST_OP FROM so WHERE ID_SO = $consulta[5]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $so = $row['SIST_OP'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT ESTADO FROM estado_ws WHERE ID_ESTADOWS = $consulta[6]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $est = $row['ESTADO'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT PROVEEDOR FROM proveedor WHERE ID_PROVEEDOR = $consulta[8]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $pro = $row['PROVEEDOR'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT TIPOWS FROM tipows WHERE ID_TIPOWS = $consulta[15]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tip = $row['TIPOWS'];
                ?>  
                <?php 
                    include("conexion.php");
                    $sent= "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = $consulta[16]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $usu = $row['NOMBRE'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT MARCA FROM marcas WHERE ID_MARCA = $consulta[4]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $mar = $row['MARCA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT AREA FROM area WHERE ID_AREA = $consulta[1]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $area = $row['AREA'];
                ?>

                






                        <!-- MEMORIAS -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->
                <?php 
                    include("conexion.php");
                    $sent= "SELECT m.MEMORIA FROM wsmem w LEFT JOIN memoria m ON m.ID_MEMORIA = w.ID_MEMORIA WHERE w.ID_WS = $consulta[0] AND w.SLOT = 1";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $mem1 = $row['MEMORIA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT t.TIPOMEM FROM wsmem w LEFT JOIN tipomem t ON t.ID_TIPOMEM = w.ID_TIPOMEM WHERE w.ID_WS = $consulta[0] AND w.SLOT = 1";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tmem1 = $row['TIPOMEM'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT p.PROVEEDOR FROM wsmem w LEFT JOIN proveedor p ON p.ID_PROVEEDOR = w.ID_PROVEEDOR WHERE w.ID_WS = $consulta[0] AND w.SLOT = 1";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $prov1 = $row['PROVEEDOR'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT m.MARCA FROM wsmem w LEFT JOIN marcas m ON m.ID_MARCA = w.ID_MARCA WHERE w.ID_WS = $consulta[0] AND w.SLOT = 1";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $marc1 = $row['MARCA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FACTURA FROM wsmem WHERE ID_WS = $consulta[0] AND SLOT = 1";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $fact1 = $row['FACTURA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FECHA FROM wsmem WHERE ID_WS = $consulta[0] AND SLOT = 1";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $fec1 = $row['FECHA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT GARANTIA FROM wsmem WHERE ID_WS = $consulta[0] AND SLOT = 1";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $gar1 = $row['GARANTIA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT v.FRECUENCIA_RAM 
                    FROM wsmem w
                    LEFT JOIN velocidad v ON v.ID_FRECUENCIA = w.ID_FRECUENCIA
                    WHERE w.ID_WS = $consulta[0] AND SLOT = 1";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvel1 = $row['FRECUENCIA_RAM'];
                ?>



                <?php 
                    include("conexion.php");
                    $sent= "SELECT m.MEMORIA FROM wsmem w LEFT JOIN memoria m ON m.ID_MEMORIA = w.ID_MEMORIA WHERE w.ID_WS = $consulta[0] AND w.SLOT = 2";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $mem2 = $row['MEMORIA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT t.TIPOMEM FROM wsmem w LEFT JOIN tipomem t ON t.ID_TIPOMEM = w.ID_TIPOMEM WHERE w.ID_WS = $consulta[0] AND w.SLOT = 2";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tmem2 = $row['TIPOMEM'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT p.PROVEEDOR FROM wsmem w LEFT JOIN proveedor p ON p.ID_PROVEEDOR = w.ID_PROVEEDOR WHERE w.ID_WS = $consulta[0] AND w.SLOT = 2";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $prov2 = $row['PROVEEDOR'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT m.MARCA FROM wsmem w LEFT JOIN marcas m ON m.ID_MARCA = w.ID_MARCA WHERE w.ID_WS = $consulta[0] AND w.SLOT = 2";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $marc2 = $row['MARCA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FACTURA FROM wsmem WHERE ID_WS = $consulta[0] AND SLOT = 2";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $fact2 = $row['FACTURA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FECHA FROM wsmem WHERE ID_WS = $consulta[0] AND SLOT = 2";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $fec2 = $row['FECHA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT GARANTIA FROM wsmem WHERE ID_WS = $consulta[0] AND SLOT = 2";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $gar2 = $row['GARANTIA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT v.FRECUENCIA_RAM 
                    FROM wsmem w
                    LEFT JOIN velocidad v ON v.ID_FRECUENCIA = w.ID_FRECUENCIA
                    WHERE w.ID_WS = $consulta[0] AND SLOT = 2";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvel2 = $row['FRECUENCIA_RAM'];
                ?>


                <?php 
                    include("conexion.php");
                    $sent= "SELECT m.MEMORIA FROM wsmem w LEFT JOIN memoria m ON m.ID_MEMORIA = w.ID_MEMORIA WHERE w.ID_WS = $consulta[0] AND w.SLOT = 3";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $mem3 = $row['MEMORIA'];
                ?>
                 <?php 
                    include("conexion.php");
                    $sent= "SELECT t.TIPOMEM FROM wsmem w LEFT JOIN tipomem t ON t.ID_TIPOMEM = w.ID_TIPOMEM WHERE w.ID_WS = $consulta[0] AND w.SLOT = 3";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tmem3 = $row['TIPOMEM'];
                ?>
                                <?php 
                    include("conexion.php");
                    $sent= "SELECT p.PROVEEDOR FROM wsmem w LEFT JOIN proveedor p ON p.ID_PROVEEDOR = w.ID_PROVEEDOR WHERE w.ID_WS = $consulta[0] AND w.SLOT = 3";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $prov3 = $row['PROVEEDOR'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT m.MARCA FROM wsmem w LEFT JOIN marcas m ON m.ID_MARCA = w.ID_MARCA WHERE w.ID_WS = $consulta[0] AND w.SLOT = 3";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $marc3 = $row['MARCA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FACTURA FROM wsmem WHERE ID_WS = $consulta[0] AND SLOT = 3";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $fact3 = $row['FACTURA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FECHA FROM wsmem WHERE ID_WS = $consulta[0] AND SLOT = 3";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $fec3 = $row['FECHA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT GARANTIA FROM wsmem WHERE ID_WS = $consulta[0] AND SLOT = 3";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $gar3 = $row['GARANTIA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT v.FRECUENCIA_RAM 
                    FROM wsmem w
                    LEFT JOIN velocidad v ON v.ID_FRECUENCIA = w.ID_FRECUENCIA
                    WHERE w.ID_WS = $consulta[0] AND SLOT = 3";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvel3 = $row['FRECUENCIA_RAM'];
                ?>


                <?php 
                    include("conexion.php");
                    $sent= "SELECT m.MEMORIA FROM wsmem w LEFT JOIN memoria m ON m.ID_MEMORIA = w.ID_MEMORIA WHERE w.ID_WS = $consulta[0] AND w.SLOT = 4";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $mem4 = $row['MEMORIA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT t.TIPOMEM FROM wsmem w LEFT JOIN tipomem t ON t.ID_TIPOMEM = w.ID_TIPOMEM WHERE w.ID_WS = $consulta[0] AND w.SLOT = 4";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tmem4 = $row['TIPOMEM'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT p.PROVEEDOR FROM wsmem w LEFT JOIN proveedor p ON p.ID_PROVEEDOR = w.ID_PROVEEDOR WHERE w.ID_WS = $consulta[0] AND w.SLOT = 4";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $prov4 = $row['PROVEEDOR'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT m.MARCA FROM wsmem w LEFT JOIN marcas m ON m.ID_MARCA = w.ID_MARCA WHERE w.ID_WS = $consulta[0] AND w.SLOT = 4";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $marc4 = $row['MARCA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FACTURA FROM wsmem WHERE ID_WS = $consulta[0] AND SLOT = 4";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $fact4 = $row['FACTURA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FECHA FROM wsmem WHERE ID_WS = $consulta[0] AND SLOT = 4";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $fec4 = $row['FECHA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT GARANTIA FROM wsmem WHERE ID_WS = $consulta[0] AND SLOT = 4";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $gar4 = $row['GARANTIA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT v.FRECUENCIA_RAM 
                    FROM wsmem w
                    LEFT JOIN velocidad v ON v.ID_FRECUENCIA = w.ID_FRECUENCIA
                    WHERE w.ID_WS = $consulta[0] AND SLOT = 4";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvel4 = $row['FRECUENCIA_RAM'];
                ?>















                         <!-- DISCOS -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->

                <?php 
                    include("conexion.php");
                    $sent= "SELECT d.DISCO FROM discows dw LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 1";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $disc1 = $row['DISCO'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT t.TIPOD FROM discows dw LEFT JOIN tipodisco t ON t.ID_TIPOD = dw.ID_TIPOD WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 1";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tdisc1 = $row['TIPOD'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT p.PROVEEDOR FROM discows dw LEFT JOIN proveedor p ON p.ID_PROVEEDOR = dw.ID_PROVEEDOR WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 1";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dprov1 = $row['PROVEEDOR'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT m.MODELO, ma.MARCA
                    FROM discows dw 
                    LEFT JOIN modelo m ON m.ID_MODELO = dw.ID_MODELO
                    LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                    WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 1";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dmod1 = $row['MODELO']." - ".$row['MARCA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT ma.MARCA FROM marcas ma 
                    LEFT JOIN modelo m ON m.ID_MARCA = ma.ID_MARCA 
                    LEFT JOIN discows dw ON dw.ID_MODELO = m.ID_MODELO
                    WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 1";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dmarc1 = $row['MARCA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FACTURA FROM discows WHERE ID_WS = $consulta[0] AND NUMERO = 1";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $dfact1 = $row['FACTURA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FECHA FROM discows WHERE ID_WS = $consulta[0] AND NUMERO = 1";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $dfec1 = $row['FECHA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT GARANTIA FROM discows WHERE ID_WS = $consulta[0] AND NUMERO = 1";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $dgar1 = $row['GARANTIA'];
                ?>


                 <?php 
                    include("conexion.php");
                    $sent= "SELECT d.DISCO FROM discows dw LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 2";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $disc2 = $row['DISCO'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT t.TIPOD FROM discows dw LEFT JOIN tipodisco t ON t.ID_TIPOD = dw.ID_TIPOD WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 2";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tdisc2 = $row['TIPOD'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT p.PROVEEDOR FROM discows dw LEFT JOIN proveedor p ON p.ID_PROVEEDOR = dw.ID_PROVEEDOR WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 2";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dprov2 = $row['PROVEEDOR'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT m.MODELO, ma.MARCA
                    FROM discows dw 
                    LEFT JOIN modelo m ON m.ID_MODELO = dw.ID_MODELO
                    LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                    WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 2";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dmod2 = $row['MODELO']." - ".$row['MARCA'];
                ?>
                 <?php 
                    include("conexion.php");
                    $sent= "SELECT ma.MARCA FROM marcas ma 
                    LEFT JOIN modelo m ON m.ID_MARCA = ma.ID_MARCA 
                    LEFT JOIN discows dw ON dw.ID_MODELO = m.ID_MODELO
                    WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 2";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dmarc2 = $row['MARCA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FACTURA FROM discows WHERE ID_WS = $consulta[0] AND NUMERO = 2";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $dfact2 = $row['FACTURA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FECHA FROM discows WHERE ID_WS = $consulta[0] AND NUMERO = 2";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $dfec2 = $row['FECHA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT GARANTIA FROM discows WHERE ID_WS = $consulta[0] AND NUMERO = 2";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $dgar2 = $row['GARANTIA'];
                ?>


                <?php 
                    include("conexion.php");
                    $sent= "SELECT d.DISCO FROM discows dw LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 3";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $disc3 = $row['DISCO'];
                ?>
                <?php
                    include("conexion.php");
                    $sent= "SELECT t.TIPOD FROM discows dw LEFT JOIN tipodisco t ON t.ID_TIPOD = dw.ID_TIPOD WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 3";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tdisc3 = $row['TIPOD'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT p.PROVEEDOR FROM discows dw LEFT JOIN proveedor p ON p.ID_PROVEEDOR = dw.ID_PROVEEDOR WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 3";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dprov3 = $row['PROVEEDOR'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT m.MODELO, ma.MARCA
                    FROM discows dw 
                    LEFT JOIN modelo m ON m.ID_MODELO = dw.ID_MODELO
                    LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                    WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 3";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dmod3 = $row['MODELO']." - ".$row['MARCA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT ma.MARCA FROM marcas ma 
                    LEFT JOIN modelo m ON m.ID_MARCA = ma.ID_MARCA 
                    LEFT JOIN discows dw ON dw.ID_MODELO = m.ID_MODELO
                    WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 3";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dmarc3 = $row['MARCA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FACTURA FROM discows WHERE ID_WS = $consulta[0] AND NUMERO = 3";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $dfact3 = $row['FACTURA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FECHA FROM discows WHERE ID_WS = $consulta[0] AND NUMERO = 3";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $dfec3 = $row['FECHA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT GARANTIA FROM discows WHERE ID_WS = $consulta[0] AND NUMERO = 3";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $dgar3 = $row['GARANTIA'];
                ?>



                <?php 
                    include("conexion.php");
                    $sent= "SELECT d.DISCO FROM discows dw LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 4";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $disc4 = $row['DISCO'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT t.TIPOD FROM discows dw LEFT JOIN tipodisco t ON t.ID_TIPOD = dw.ID_TIPOD WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 4";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tdisc4 = $row['TIPOD'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT p.PROVEEDOR FROM discows dw LEFT JOIN proveedor p ON p.ID_PROVEEDOR = dw.ID_PROVEEDOR WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 4";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dprov4 = $row['PROVEEDOR'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT m.MODELO, ma.MARCA
                    FROM discows dw 
                    LEFT JOIN modelo m ON m.ID_MODELO = dw.ID_MODELO
                    LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                    WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 4";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dmod4 = $row['MODELO']." - ".$row['MARCA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT ma.MARCA FROM marcas ma 
                    LEFT JOIN modelo m ON m.ID_MARCA = ma.ID_MARCA 
                    LEFT JOIN discows dw ON dw.ID_MODELO = m.ID_MODELO
                    WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 4";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dmarc4 = $row['MARCA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FACTURA FROM discows WHERE ID_WS = $consulta[0] AND NUMERO = 4";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $dfact4 = $row['FACTURA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT FECHA FROM discows WHERE ID_WS = $consulta[0] AND NUMERO = 4";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $dfec4 = $row['FECHA'];
                ?>
                <?php 
                    include("conexion.php");
                    $sentencia = "SELECT GARANTIA FROM discows WHERE ID_WS = $consulta[0] AND NUMERO = 4";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $dgar4 = $row['GARANTIA'];
                ?>



                        <!-- PLACA MADRE -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->
                <?php
                    include("conexion.php");
                    $sentencia = "SELECT p.PLACAM, m.MARCA
                    FROM inventario i 
                    LEFT JOIN placamws pw ON pw.ID_WS = i.ID_WS
                    LEFT JOIN placam p ON p.ID_PLACAM = pw.ID_PLACAM
                    LEFT JOIN marcas m ON m.ID_MARCA = p.ID_MARCA
                    WHERE i.ID_WS = '$consulta[0]'";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $placam = $row['PLACAM'].' - '.$row['MARCA'];
                    ?>
                    <?php
                    include("conexion.php");
                    $sentencia = "SELECT pr.PROVEEDOR 
                    FROM inventario i 
                    LEFT JOIN placamws pw ON pw.ID_WS = i.ID_WS
                    LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = pw.ID_PROVEEDOR 
                    WHERE i.ID_WS = '$consulta[0]'";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $placamprov = $row['PROVEEDOR'];
                    ?>
                    <?php
                    include("conexion.php");
                    $sentencia = "SELECT pw.FACTURA 
                    FROM inventario i 
                    LEFT JOIN placamws pw ON pw.ID_WS = i.ID_WS
                    WHERE i.ID_WS = '$consulta[0]'";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $placamfact = $row['FACTURA'];
                    ?>
                    <?php
                    include("conexion.php");
                    $sentencia = "SELECT pw.FECHA 
                    FROM inventario i 
                    LEFT JOIN placamws pw ON pw.ID_WS = i.ID_WS
                    WHERE i.ID_WS = '$consulta[0]'";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $placamfecha = $row['FECHA'];
                    ?>
                    <?php
                    include("conexion.php");
                    $sentencia = "SELECT pw.GARANTIA 
                    FROM inventario i 
                    LEFT JOIN placamws pw ON pw.ID_WS = i.ID_WS
                    WHERE i.ID_WS = '$consulta[0]'";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $placamgar = $row['GARANTIA'];
                  ?>
                    <?php
                    include("conexion.php");
                    $sentencia = "SELECT pw.NSERIE 
                    FROM inventario i 
                    LEFT JOIN placamws pw ON pw.ID_WS = i.ID_WS
                    WHERE i.ID_WS = '$consulta[0]'";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $planro = $row['NSERIE'];
                  ?>






                        <!-- MICRO -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT m.MICRO, ma.MARCA
                    FROM inventario i 
                    LEFT JOIN microws mws ON mws.ID_WS = i.ID_WS
                    LEFT JOIN micro m ON m.ID_MICRO= mws.ID_MICRO
                    LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                    WHERE i.ID_WS='$consulta[0]'";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $micro = $row['MICRO'].' - '.$row['MARCA'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT p.PROVEEDOR 
                    FROM inventario i 
                    LEFT JOIN microws mws ON mws.ID_WS = i.ID_WS
                    LEFT JOIN proveedor p ON p.ID_PROVEEDOR= mws.ID_PROVEEDOR
                    WHERE i.ID_WS='$consulta[0]'";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $microprov = $row['PROVEEDOR'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT mws.FACTURA 
                    FROM inventario i 
                    LEFT JOIN microws mws ON mws.ID_WS = i.ID_WS
                    WHERE i.ID_WS='$consulta[0]'";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $microfac = $row['FACTURA'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT mws.FECHA 
                    FROM inventario i 
                    LEFT JOIN microws mws ON mws.ID_WS = i.ID_WS
                    WHERE i.ID_WS='$consulta[0]'";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $microfec = $row['FECHA'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT mws.GARANTIA 
                    FROM inventario i 
                    LEFT JOIN microws mws ON mws.ID_WS = i.ID_WS
                    WHERE i.ID_WS='$consulta[0]'";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $microgar = $row['GARANTIA'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT mws.NSERIE 
                    FROM inventario i 
                    LEFT JOIN microws mws ON mws.ID_WS = i.ID_WS
                    WHERE i.ID_WS='$consulta[0]'";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $micnro = $row['NSERIE'];
                  ?>





                        <!-- PLACA VIDEO -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT m.MODELO 
                    FROM inventario i 
                    LEFT JOIN pvideows pws ON pws.ID_WS = i.ID_WS
                    LEFT JOIN pvideo p ON p.ID_PVIDEO= pws.ID_PVIDEO
                    LEFT JOIN modelo m ON m.ID_MODELO = p.ID_MODELO
                    WHERE i.ID_WS='$consulta[0]' AND pws.SLOT = 1";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvmem = $row['MODELO'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT pws.NSERIE 
                    FROM inventario i 
                    LEFT JOIN pvideows pws ON pws.ID_WS = i.ID_WS
                    WHERE i.ID_WS='$consulta[0]' AND pws.SLOT = 1";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvnserie = $row['NSERIE'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT p.PROVEEDOR 
                    FROM inventario i 
                    LEFT JOIN pvideows pws ON pws.ID_WS = i.ID_WS
                    LEFT JOIN proveedor p ON p.ID_PROVEEDOR = pws.ID_PROVEEDOR
                    WHERE i.ID_WS='$consulta[0]' AND pws.SLOT = 1";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvprov = $row['PROVEEDOR'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT pws.FACTURA 
                    FROM inventario i 
                    LEFT JOIN pvideows pws ON pws.ID_WS = i.ID_WS
                    WHERE i.ID_WS='$consulta[0]' AND pws.SLOT = 1";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvfact = $row['FACTURA'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT pws.FECHA 
                    FROM inventario i 
                    LEFT JOIN pvideows pws ON pws.ID_WS = i.ID_WS
                    WHERE i.ID_WS='$consulta[0]' AND pws.SLOT = 1";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvfec = $row['FECHA'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT pws.GARANTIA 
                    FROM inventario i 
                    LEFT JOIN pvideows pws ON pws.ID_WS = i.ID_WS
                    WHERE i.ID_WS='$consulta[0]' AND pws.SLOT = 1";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvgar = $row['GARANTIA'];
                  ?>



                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT m.MODELO 
                    FROM inventario i 
                    LEFT JOIN pvideows pws ON pws.ID_WS = i.ID_WS
                    LEFT JOIN pvideo p ON p.ID_PVIDEO= pws.ID_PVIDEO
                    LEFT JOIN modelo m ON m.ID_MODELO = p.ID_MODELO
                    WHERE i.ID_WS='$consulta[0]' AND pws.SLOT = 2";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvmem1 = $row['MODELO'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT pws.NSERIE 
                    FROM inventario i 
                    LEFT JOIN pvideows pws ON pws.ID_WS = i.ID_WS
                    WHERE i.ID_WS='$consulta[0]' AND pws.SLOT = 2";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvnserie1 = $row['NSERIE'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT p.PROVEEDOR 
                    FROM inventario i 
                    LEFT JOIN pvideows pws ON pws.ID_WS = i.ID_WS
                    LEFT JOIN proveedor p ON p.ID_PROVEEDOR = pws.ID_PROVEEDOR
                    WHERE i.ID_WS='$consulta[0]' AND pws.SLOT = 2";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvprov1 = $row['PROVEEDOR'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT pws.FACTURA 
                    FROM inventario i 
                    LEFT JOIN pvideows pws ON pws.ID_WS = i.ID_WS
                    WHERE i.ID_WS='$consulta[0]' AND pws.SLOT = 2";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvfact1 = $row['FACTURA'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT pws.FECHA 
                    FROM inventario i 
                    LEFT JOIN pvideows pws ON pws.ID_WS = i.ID_WS
                    WHERE i.ID_WS='$consulta[0]' AND pws.SLOT = 2";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvfec1 = $row['FECHA'];
                  ?>
                  <?php
                    include("conexion.php");
                    $sentencia = "SELECT pws.GARANTIA 
                    FROM inventario i 
                    LEFT JOIN pvideows pws ON pws.ID_WS = i.ID_WS
                    WHERE i.ID_WS='$consulta[0]' AND pws.SLOT = 2";
                    $resultado = $datos_base->query($sentencia);
                    $row = $resultado->fetch_assoc();
                    $pvgar1 = $row['GARANTIA'];
                  ?>
                  






                <form method="POST" action="guardarmodequipo2.php">
                     <label>ID: </label>
                    <input type="text" class="id" name="id" value="<?php echo $consulta[0]?>">

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">N° GOBIERNO: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="serieg" value="<?php echo $consulta[3]?>">
                        <label id="lblForm"class="col-form-label col-xl col-lg">N° SERIE: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="serialn" value="<?php echo $consulta[2]?>">
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">MAC: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="mac" value="<?php echo $consulta[11]?>">
                        <label id="lblForm"class="col-form-label col-xl col-lg">OBSERVACIÓN: </label>
                        <textarea style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" name="obs" rows="3"><?php echo $consulta[7]?></textarea>
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">IP: </label>
                        <input style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" type="text" name="ip" value="<?php echo $consulta[13]?>">
                        <label id="lblForm"class="col-form-label col-xl col-lg">FACTURA: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="fac" value="<?php echo $consulta[9]?>">
                    </div>


                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="gar" value="<?php echo $consulta[17]?>">
                        <label id="lblForm"class="col-form-label col-xl col-lg">MASTERIZACIÓN: </label>
                        <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="masterizacion">
                        <option selected value="100"><?php echo $consulta[10]?></option>
                        <option value="SI">SI</option>
                            <option value ="NO">NO</option>
                        </select>
                    </div>


                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">RIP: </label>
                        <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="reserva">
                        <option selected value="200"><?php echo $consulta[12]?></option>
                            <option value ="NO">NO</option>
                            <option value="SI">SI</option>
                        </select>
                        <label id="lblForm"class="col-form-label col-xl col-lg">RED: </label>
                        <select style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="red">
                                        <option selected value="300"><?php echo $red?></option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM red";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_RED'] ?>><?php echo $opciones['RED']?></option>
                                        <?php endforeach?>
                                    </select>
                    </div>


                    <div class="form-group row" style="margin: 10px; padding:10px;">

                    <label id="lblForm"class="col-form-label col-xl col-lg">SISTEMA OPERATIVO: </label>
                        <select style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="so">
                                    <option selected value="500"><?php echo $so?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM so";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_SO'] ?>><?php echo $opciones['SIST_OP']?></option>
                                    <?php endforeach?>
                                </select>      
                        <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO: </label>
                        <select style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="est">
                                        <option selected value="700"><?php echo $est?></option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM estado_ws";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_ESTADOWS'] ?>><?php echo $opciones['ESTADO']?></option>
                                        <?php endforeach?>
                                    </select>
                    </div>


                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR: </label>
                        <select style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="prov">
                                        <option selected value="800"><?php echo $pro?></option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM proveedor";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                        <?php endforeach?>
                                    </select>
                        <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DE EQUIPO: </label>
                        <select style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="tippc">
                                        <option selected value="900"><?php echo $tip?></option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM tipows";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_TIPOWS'] ?>><?php echo $opciones['TIPOWS']?></option>
                                        <?php endforeach?>
                                    </select>
                    </div>


                    <div class="form-group row" style="margin: 10px; padding:10px;">            
                        <label id="lblForm"class="col-form-label col-xl col-lg">USUARIO: </label>
                        <select id="slcusu" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="usu">
                                        <option selected value="1000"><?php echo $usu?></option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM usuarios";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_USUARIO'] ?>><?php echo $opciones['NOMBRE']?></option>
                                        <?php endforeach?>
                                    </select>
                        <label id="lblArea" style="font-size:24px;"class="col-form-label col-xl col-lg">AREA: </label>
                        <select id="slcarea" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="marca" disabled>
                        <!-- falta verificar bien eñ value-->
                                        <option selected value="1100"><?php echo $area?></option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM area";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_AREA'] ?>><?php echo $opciones['AREA']?></option>
                                        <?php endforeach?>
                                    </select>
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">            
                        
                        <label id="lblForm"class="col-form-label col-xl col-lg">MARCA: </label>
                        <select style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" name="marca">
                                        <option selected value="1100"><?php echo $mar?></option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM marcas";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                        <?php endforeach?>
                                    </select>
                    </div>




<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingpm">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsepm" aria-expanded="false" aria-controls="flush-collapsepm">
      <u>PLACA MADRE</u>
      </button>
    </h2>
    <div id="flush-collapsepm" class="accordion-collapse collapse" aria-labelledby="flush-headingpm" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PLACA:</label> 
							    <select name="placam" style="text-transform:uppercase" class="form-control col-xl col-lg">
                      <option selected value="2000"><?php echo $placam?></option>
                      <?php
                      include("conexion.php");
                      $consulta= "SELECT p.ID_PLACAM, p.PLACAM, m.MARCA
                      FROM placam p
                      INNER JOIN marcas m ON m.ID_MARCA = p.ID_MARCA
                      ORDER BY PLACAM ASC";
                      $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?> 
                      <option value= <?php echo $opciones['ID_PLACAM'] ?>><?php echo $opciones['PLACAM'].' - '.$opciones['MARCA']?></option>
                      <?php endforeach?>
                  </select>
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="placamprov" style="text-transform:uppercase" class="form-control col-xl col-lg">
                      <option selected value="2001"><?php echo $placamprov?></option>
                      <?php
                      include("conexion.php");
                      $consulta= "SELECT * FROM proveedor";
                      $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?> 
                      <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                      <?php endforeach?>
                  </select>
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="placamfact" value="<?php echo $placamfact?>">
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="placamfecha" value="<?php echo $placamfecha?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="placamgar" value="<?php echo $placamgar?>">
              <label id="lblForm"class="col-form-label col-xl col-lg">N°SERIE:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="planro" value="<?php echo $planro?>">
        </div>
      </div>
    </div>
  </div>















<!-- <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">MICROPROCESADOR</h1> -->

<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingmi">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsemi" aria-expanded="false" aria-controls="flush-collapsepmi">
      <u>MICROPROCESADOR</u>
      </button>
    </h2>
    <div id="flush-collapsemi" class="accordion-collapse collapse" aria-labelledby="flush-headingmi" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MICRO:</label> 
							    <select name="micro" style="text-transform:uppercase" class="form-control col-xl col-lg">
                    <option selected value="2100"><?php echo $micro?></option>
                    <?php
                    include("conexion.php");
                    $consulta= "SELECT m.ID_MICRO, m.MICRO, ma.MARCA 
                    FROM micro m
                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                    ORDER BY MICRO ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones):?> 
                    <option value= <?php echo $opciones['ID_MICRO'] ?>><?php echo $opciones['MICRO'].' - '.$opciones['MARCA']?></option>
                    <?php endforeach?>
                  </select>
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="microprov" style="text-transform:uppercase" class="form-control col-xl col-lg">
                    <option selected value="2101"><?php echo $microprov?></option>
                    <?php
                    include("conexion.php");
                    $consulta= "SELECT * FROM proveedor";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                    <?php endforeach?>
                  </select>
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="microfac" value="<?php echo $microfac?>">
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="microfec" value="<?php echo $microfec?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="microgar" value="<?php echo $microgar?>">
              <label id="lblForm"class="col-form-label col-xl col-lg">N°SERIE:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="micnro" value="<?php echo $micnro?>">
        </div>
      </div>
    </div>
  </div> 









<!-- <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">PLACA DE VIDEO</h1> -->

<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingpl">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsepl" aria-expanded="false" aria-controls="flush-collapsepl">
      <u>1°&nbspPLACA DE VIDEO</u>
      </button>
    </h2>
    <div id="flush-collapsepl" class="accordion-collapse collapse" aria-labelledby="flush-headingpl" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">N° SERIE:</label> 
            <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="pvnserie">
                <label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
                <input type="date" class="form-control col-xl col-lg" name="pvfec">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="pvfact">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="pvgar">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PLACA:</label> 
							    <select name="pvmem" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="2200"><?php echo $pvmem?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM memoria";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="pvprov" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="2201"><?php echo $pvprov?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM proveedor";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingpl1">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsepl1" aria-expanded="false" aria-controls="flush-collapsepl1">
      <u>2°&nbspPLACA DE VIDEO</u>
      </button>
    </h2>
    <div id="flush-collapsepl1" class="accordion-collapse collapse" aria-labelledby="flush-headingpl1" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">N° SERIE:</label> 
          <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="pvnserie1">
          <label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="pvfec1">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
          <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="pvfact1">
					<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
          <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="pvgar1">
      </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PLACA:</label> 
							    <select name="pvmem1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="2300"><?php echo $pvmem1?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM memoria";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="pvprov1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="2301"><?php echo $pvprov1?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM proveedor";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
      </div>
        </div>
      </div>
    </div>
  </div>
</div>













<!-- <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">MEMORIAS</h1> -->

<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading1">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse1" aria-expanded="false" aria-controls="flush-collapse1">
      <u>1°&nbspMEMORIA</u>
      </button>
    </h2>
    <div id="flush-collapse1" class="accordion-collapse collapse" aria-labelledby="flush-heading1" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
				  <select name="mem1" style="text-transform:uppercase" class="form-control col-xl col-lg">
            <option selected value="1200"><?php echo $mem1?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM memoria";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
					<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
          <select name="tmem1" style="text-transform:uppercase" class="form-control col-xl col-lg">
              <option selected value="1201"><?php echo $tmem1?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipomem";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
     </div>
     <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="prov1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1202"><?php echo $prov1?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM proveedor";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="fact1" value="<?php echo $fact1?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MARCA:</label> 
							    <select name="marc1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1203"><?php echo $marc1?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM marcas";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="fec1" value="<?php echo $fec1?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar1" value="<?php echo $gar1?>">
              <label id="lblForm" class="col-form-label col-xl col-lg">VELOCIDAD:</label> 
							    <select name="pvel1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                    <option selected value="1204"><?php echo $pvel1?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM velocidad";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_FRECUENCIA'] ?>><?php echo $opciones['FRECUENCIA_RAM']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading2">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse2" aria-expanded="false" aria-controls="flush-collapse2">
      <u>2°&nbspMEMORIA</u>
      </button>
    </h2>
    <div id="flush-collapse2" class="accordion-collapse collapse" aria-labelledby="flush-heading2" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                <option selected value="1300"><?php echo $mem2?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM memoria";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tmem2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1301"><?php echo $tmem2?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipomem";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="prov2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1302"><?php echo $prov2?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM proveedor";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="fact2" value="<?php echo $fact2?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MARCA:</label> 
							    <select name="marc2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1303"><?php echo $marc2?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM marcas";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="fec2" value="<?php echo $fec2?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar2" value="<?php echo $gar2?>">
              <label id="lblForm" class="col-form-label col-xl col-lg">VELOCIDAD:</label> 
							    <select name="pvel2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="1304"><?php echo $pvel2?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM velocidad";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_FRECUENCIA'] ?>><?php echo $opciones['FRECUENCIA_RAM']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading3">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse3" aria-expanded="false" aria-controls="flush-collapse3">
      <u>3°&nbspMEMORIA</u>
      </button>
    </h2>
    <div id="flush-collapse3" class="accordion-collapse collapse" aria-labelledby="flush-heading3" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                <option selected value="1400"><?php echo $mem3?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM memoria";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tmem3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1401"><?php echo $tmem3?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipomem";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="prov3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1402"><?php echo $prov3?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM proveedor";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="fact3" value="<?php echo $fact3?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MARCA:</label> 
							    <select name="marc3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1403"><?php echo $marc3?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM marcas";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="fec3" value="<?php echo $fec3?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar3" value="<?php echo $gar3?>">
              <label id="lblForm" class="col-form-label col-xl col-lg">VELOCIDAD:</label> 
							    <select name="pvel3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="1404"><?php echo $pvel3?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM velocidad";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_FRECUENCIA'] ?>><?php echo $opciones['FRECUENCIA_RAM']?></option>
                                    <?php endforeach?>
                                </select>
        </div> 
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading4">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse4" aria-expanded="false" aria-controls="flush-collapse4">
      <u>4°&nbspMEMORIA</u>
      </button>
    </h2>
    <div id="flush-collapse4" class="accordion-collapse collapse" aria-labelledby="flush-heading4" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                <option selected value="1500"><?php echo $mem4?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM memoria";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tmem4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1501"><?php echo $tmem4?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipomem";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="prov4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1502"><?php echo $prov4?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM proveedor";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="fact4" value="<?php echo $fact4?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MARCA:</label> 
							    <select name="marc4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1503"><?php echo $marc4?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM marcas";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="fec4" value="<?php echo $fec4?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar4" value="<?php echo $gar4?>">
              <label id="lblForm" class="col-form-label col-xl col-lg">VELOCIDAD:</label> 
							    <select name="pvel4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="1504"><?php echo $pvel4?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM velocidad";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_FRECUENCIA'] ?>><?php echo $opciones['FRECUENCIA_RAM']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
      </div>
    </div>
  </div>
</div>








                        

<!-- <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">DISCOS</h1> -->

<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
      <u>1°&nbspDISCO</u>
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 1:</label>
                            <select name="disc1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1600"><?php echo $disc1?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM disco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DISCO 1:</label>
                            <select name="tdisc1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1601"><?php echo $tdisc1?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipodisco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="dprov1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1602"><?php echo $dprov1?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM proveedor";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="dfact1" value="<?php echo $dfact1?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MODELO:</label> 
							    <select name="dmod1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1603"><?php echo $dmod1?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA 
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
                                <label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="dfec1" value="<?php echo $dfec1?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="dgar1" value="<?php echo $dgar1?>">
        </div> 
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
      <u>2°&nbspDISCO</u>
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 2:</label>
                            <select name="disc2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1700"><?php echo $disc2?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM disco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DISCO 2:</label>
                            <select name="tdisc2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1701"><?php echo $tdisc2?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipodisco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="dprov2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1702"><?php echo $dprov2?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM proveedor";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="dfact2" value="<?php echo $dfact2?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MODELO:</label> 
							    <select name="dmod2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1703"><?php echo $dmod2?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA 
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
                                <label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="dfec2" value="<?php echo $dfec2?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="dgar2" value="<?php echo $dgar2?>">
        </div> 
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
      <u>3°&nbspDISCO</u>
      </button>
    </h2>
    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 3:</label>
                            <select name="disc3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1800"><?php echo $disc3?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM disco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DISCO 3:</label>
                            <select name="tdisc3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1801"><?php echo $tdisc4?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipodisco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="dprov3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1802"><?php echo $dprov3?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM proveedor";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="dfact3" value="<?php echo $dfact3?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MODELO:</label> 
							    <select name="dmod3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1803"><?php echo $dmod3?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA 
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
                                <label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="dfec3" value="<?php echo $dfec3?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="dgar3" value="<?php echo $dgar3?>">
        </div> 
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
      <u>4°&nbspDISCO</u>
      </button>
    </h2>
    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
			<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 4:</label>
                            <select name="disc4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1900"><?php echo $disc4?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM disco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DISCO 4:</label>
                            <select name="tdisc4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                            <option selected value="1901"><?php echo $tdisc4?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipodisco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="dprov4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option selected value="1902"><?php echo $dprov4?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM proveedor";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="dfact4" value="<?php echo $dfact4?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MODELO:</label> 
							    <select name="dmod4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option selected value="1903"><?php echo $dmod4?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA 
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
                                <label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="dfec4" value="<?php echo $dfec4?>">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="dgar4" value="<?php echo $dgar4?>">
        </div> 
      </div>
    </div>
  </div>
</div>

                    <div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
					    <input style="width:20%"class="col-3 button" type="submit" value="MODIFICAR" class="button">
				    </div>
                </form>
	    </div>
	</section>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>