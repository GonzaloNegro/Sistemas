<?php 
/* error_reporting(0); */
session_start();
include('../particular/conexion.php');

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
		$filas['GARANTIA'],/*16*/
        $filas['ID_PROCEDENCIA']/*17*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>DETALLES DEL EQUIPO</title>
    <link rel="icon" href="../imagenes/logoInfraestructura.png">
	<meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../estilos/estiloconsultadetalleinv.css">
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
            <a id="vlv"  href="./inventario.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
            <div class="btn-group col-3" role="group">
                <button style="border: none;"><a id="botonleft" class="btn btn-secondary"<?php echo "href=../abm/modequipo.php?no=".$consulta[0].""?>>EDITAR</a></button>
                <button style="border: none;"><a id="botonleft" class="btn btn-secondary"<?php echo "href=equipomovmej.php?no=".$consulta[0].""?>>MOVIMIENTOS</a></button>
                <button style="border: none;"><a id="botonleft" class="btn btn-secondary"<?php echo "href=equipomovmej2.php?no=".$consulta[0].""?>>MEJORAS</a></button>
                <button id="botonright" type="button" class="btn btn-success" onClick="imprimir()" ><i class='bi bi-printer'></i></button>
            </div>
		</div>
    </header>
	<section id="ingreso">
        <div id="titulo">
                <h1>DETALLES DEL EQUIPO</h1>
        </div>
            <div id="detalles" class="container-fluid">
                <?php
                    /*/////////////////////NOMBRE//////////////////////*/
                    $sql = "SELECT u.NOMBRE FROM wsusuario w 
                    LEFT JOIN usuarios u ON u.ID_USUARIO = w.ID_USUARIO 
                    WHERE w.ID_WS='$consulta[0]' 
                    ORDER BY w.ID_WSUSU DESC
                    LIMIT 1;";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $nom = $row['NOMBRE'];
                    /*/////////////////////AREA//////////////////////*/
                    $sql = "SELECT a.AREA FROM inventario i INNER JOIN area a ON a.ID_AREA = i.ID_AREA WHERE i.ID_AREA='$consulta[1]'";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $are = $row['AREA'];
                    /*/////////////////////ESTADO//////////////////////*/
                    $sql = "SELECT e.ESTADO FROM inventario i INNER JOIN estado_ws e ON e.ID_ESTADOWS = i.ID_ESTADOWS WHERE i.ID_ESTADOWS='$consulta[6]'";
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
                    $sql = "SELECT s.SIST_OP FROM inventario i INNER JOIN so s ON s.ID_SO = i.ID_SO WHERE i.        ID_SO='$consulta[5]'";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $so = $row['SIST_OP'];
                    /*/////////////////////MICRO//////////////////////*/
                    $sql = "SELECT m.MICRO 
                    FROM inventario i 
                    LEFT JOIN microws mws ON mws.ID_WS = i.ID_WS
                    LEFT JOIN micro m ON m.ID_MICRO= mws.ID_MICRO
                    WHERE i.ID_WS='$consulta[0]'";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $micro = $row['MICRO'];
                    /*/////////////////////PLACA MADRE//////////////////////*/
                    $sql = "SELECT p.PLACAM, m.MARCA
                    FROM inventario i 
                    LEFT JOIN placamws pws ON pws.ID_WS = i.ID_WS
                    LEFT JOIN placam p ON p.ID_PLACAM = pws.ID_PLACAM
                    LEFT JOIN marcas m ON m.ID_MARCA = p.ID_MARCA
                    WHERE i.ID_WS='$consulta[0]'";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $placam = $row['PLACAM'];
                    $placammarca = $row['MARCA'];
                    /*/////////////////////RED//////////////////////*/
                    $sql = "SELECT r.RED 
                    FROM inventario i 
                    LEFT JOIN red r ON r.ID_RED = i.ID_RED
                    WHERE i.ID_WS='$consulta[0]'";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $red = $row['RED'];
                    /*/////////////////////PROVEEDOR//////////////////////*/
                    $sql = "SELECT p.PROVEEDOR
                    FROM inventario i 
                    LEFT JOIN proveedor p ON p.ID_PROVEEDOR = i.ID_PROVEEDOR
                    WHERE i.ID_WS='$consulta[0]'";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $prov = $row['PROVEEDOR'];





                    /*/////////////////////MEMORIA 1//////////////////////*/
                    $sql = "SELECT m.MEMORIA 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN memoria m ON m.ID_MEMORIA = ws.ID_MEMORIA
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 1";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $mem1 = $row['MEMORIA'];
                    /*/////////////////////TIPO MEMORIA 1//////////////////////*/
                    $sql = "SELECT t.TIPOMEM 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN tipomem t ON t.ID_TIPOMEM= ws.ID_TIPOMEM
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 1";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $tmem1 = $row['TIPOMEM'];
                    /*/////////////////////PROVEEDOR MEMORIA 1//////////////////////*/
                    $sql = "SELECT p.PROVEEDOR 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN proveedor p ON p.ID_PROVEEDOR= ws.ID_PROVEEDOR
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 1";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $pmem1 = $row['PROVEEDOR'];
                    /*/////////////////////MARCA MEMORIA 1//////////////////////*/
                    $sql = "SELECT m.MARCA 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN marcas m ON m.ID_MARCA= ws.ID_MARCA
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 1";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $mmem1 = $row['MARCA'];
                    /*/////////////////////FACTURA MEMORIA 1//////////////////////*/
                    $sql = "SELECT FACTURA FROM wsmem WHERE ID_WS='$consulta[0]' AND SLOT = 1";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $famem1 = $row['FACTURA'];
                    /*/////////////////////GARANTIA MEMORIA 1//////////////////////*/
                    $sql = "SELECT GARANTIA FROM wsmem WHERE ID_WS='$consulta[0]' AND SLOT = 1";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $gmem1 = $row['GARANTIA'];
                    /*/////////////////////FECHA MEMORIA 1//////////////////////*/
                    $sql = "SELECT FECHA FROM wsmem WHERE ID_WS='$consulta[0]' AND SLOT = 1";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $fmem1 = $row['FECHA'];



                    /*/////////////////////MEMORIA 2//////////////////////*/
                    $sql = "SELECT m.MEMORIA 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN memoria m ON m.ID_MEMORIA = ws.ID_MEMORIA
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 2";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $mem2 = $row['MEMORIA'];
                    /*/////////////////////TIPO MEMORIA 2//////////////////////*/
                    $sql = "SELECT t.TIPOMEM 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN tipomem t ON t.ID_TIPOMEM= ws.ID_TIPOMEM
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 2";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $tmem2 = $row['TIPOMEM'];
                    /*/////////////////////PROVEEDOR MEMORIA 2//////////////////////*/
                    $sql = "SELECT p.PROVEEDOR 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN proveedor p ON p.ID_PROVEEDOR= ws.ID_PROVEEDOR
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 2";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $pmem2 = $row['PROVEEDOR'];
                    /*/////////////////////MARCA MEMORIA 2//////////////////////*/
                    $sql = "SELECT m.MARCA 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN marcas m ON m.ID_MARCA= ws.ID_MARCA
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 2";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $mmem2 = $row['MARCA'];
                    /*/////////////////////FACTURA MEMORIA 2//////////////////////*/
                    $sql = "SELECT FACTURA FROM wsmem WHERE ID_WS='$consulta[0]' AND SLOT = 2";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $famem2 = $row['FACTURA'];
                    /*/////////////////////GARANTIA MEMORIA 2//////////////////////*/
                    $sql = "SELECT GARANTIA FROM wsmem WHERE ID_WS='$consulta[0]' AND SLOT = 2";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $gmem2 = $row['GARANTIA'];
                    /*/////////////////////FECHA MEMORIA 2//////////////////////*/
                    $sql = "SELECT FECHA FROM wsmem WHERE ID_WS='$consulta[0]' AND SLOT = 2";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $fmem2 = $row['FECHA'];



                    /*/////////////////////MEMORIA 3//////////////////////*/
                    $sql = "SELECT m.MEMORIA 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN memoria m ON m.ID_MEMORIA = ws.ID_MEMORIA
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 3";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $mem3 = $row['MEMORIA'];
                    /*/////////////////////TIPO MEMORIA 3//////////////////////*/
                    $sql = "SELECT t.TIPOMEM 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN tipomem t ON t.ID_TIPOMEM= ws.ID_TIPOMEM
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 3";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $tmem3 = $row['TIPOMEM'];
                    /*/////////////////////PROVEEDOR MEMORIA 3//////////////////////*/
                    $sql = "SELECT p.PROVEEDOR 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN proveedor p ON p.ID_PROVEEDOR= ws.ID_PROVEEDOR
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 1";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $pmem3 = $row['PROVEEDOR'];
                    /*/////////////////////MARCA MEMORIA 3//////////////////////*/
                    $sql = "SELECT m.MARCA 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN marcas m ON m.ID_MARCA= ws.ID_MARCA
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 3";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $mmem3 = $row['MARCA'];
                    /*/////////////////////FACTURA MEMORIA 3//////////////////////*/
                    $sql = "SELECT FACTURA FROM wsmem WHERE ID_WS='$consulta[0]' AND SLOT = 3";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $famem3 = $row['FACTURA'];
                    /*/////////////////////GARANTIA MEMORIA 3//////////////////////*/
                    $sql = "SELECT GARANTIA FROM wsmem WHERE ID_WS='$consulta[0]' AND SLOT = 3";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $gmem3 = $row['GARANTIA'];
                    /*/////////////////////FECHA MEMORIA 3//////////////////////*/
                    $sql = "SELECT FECHA FROM wsmem WHERE ID_WS='$consulta[0]' AND SLOT = 3";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $fmem3 = $row['FECHA'];



                    /*/////////////////////MEMORIA 4//////////////////////*/
                    $sql = "SELECT m.MEMORIA 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN memoria m ON m.ID_MEMORIA = ws.ID_MEMORIA
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 4";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $mem4 = $row['MEMORIA'];
                    /*/////////////////////TIPO MEMORIA 4//////////////////////*/
                    $sql = "SELECT t.TIPOMEM 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN tipomem t ON t.ID_TIPOMEM= ws.ID_TIPOMEM
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 4";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $tmem4 = $row['TIPOMEM'];
                    /*/////////////////////PROVEEDOR MEMORIA 4//////////////////////*/
                    $sql = "SELECT p.PROVEEDOR 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN proveedor p ON p.ID_PROVEEDOR= ws.ID_PROVEEDOR
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 4";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $pmem4 = $row['PROVEEDOR'];
                    /*/////////////////////MARCA MEMORIA 4//////////////////////*/
                    $sql = "SELECT m.MARCA 
                    FROM inventario i 
                    LEFT JOIN wsmem ws ON ws.ID_WS = i.ID_WS
                    LEFT JOIN marcas m ON m.ID_MARCA= ws.ID_MARCA
                    WHERE i.ID_WS='$consulta[0]' AND ws.SLOT = 4";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $mmem4 = $row['MARCA'];
                    /*/////////////////////FACTURA MEMORIA 4//////////////////////*/
                    $sql = "SELECT FACTURA FROM wsmem WHERE ID_WS='$consulta[0]' AND SLOT = 4";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $famem4 = $row['FACTURA'];
                    /*/////////////////////GARANTIA MEMORIA 4//////////////////////*/
                    $sql = "SELECT GARANTIA FROM wsmem WHERE ID_WS='$consulta[0]' AND SLOT = 4";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $gmem4 = $row['GARANTIA'];
                    /*/////////////////////FECHA MEMORIA 4//////////////////////*/
                    $sql = "SELECT FECHA FROM wsmem WHERE ID_WS='$consulta[0]' AND SLOT = 4";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $fmem4 = $row['FECHA'];











                    /*/////////////////////DISCO 1//////////////////////*/
                    $sql = "SELECT d.DISCO 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN disco d ON d.ID_DISCO= dw.ID_DISCO
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 1";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $disc1 = $row['DISCO'];
                     /*/////////////////////TIPO DISCO 1//////////////////////*/
                    $sql = "SELECT t.TIPOD 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN tipodisco t ON t.ID_TIPOD= dw.ID_TIPOD
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 1";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $tdisc1 = $row['TIPOD'];
                    /*/////////////////////PROVEEDOR DISCO 1//////////////////////*/
                    $sql = "SELECT p.PROVEEDOR 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN proveedor p ON p.ID_PROVEEDOR= dw.ID_PROVEEDOR
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 1";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $pdisc1 = $row['PROVEEDOR'];
                    /*/////////////////////MARCA DISCO 1//////////////////////*/
                    $sql = "SELECT m.MARCA 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN modelo mo ON mo.ID_MODELO = dw.ID_MODELO
                    LEFT JOIN marcas m ON m.ID_MARCA= mo.ID_MARCA
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 1";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $mdisc1 = $row['MARCA'];
                    /*/////////////////////FACTURA DISCO 1//////////////////////*/
                    $sql = "SELECT FACTURA FROM discows WHERE ID_WS='$consulta[0]' AND NUMERO = 1";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $fadisc1 = $row['FACTURA'];
                    /*/////////////////////GARANTIA DISCO 1//////////////////////*/
                    $sql = "SELECT GARANTIA FROM discows WHERE ID_WS='$consulta[0]' AND NUMERO = 1";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $gdisc1 = $row['GARANTIA'];
                    /*/////////////////////FECHA DISCO 1//////////////////////*/
                    $sql = "SELECT FECHA FROM discows WHERE ID_WS='$consulta[0]' AND NUMERO = 1";;
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $fdisc1 = $row['FECHA'];



                    /*/////////////////////DISCO 2//////////////////////*/
                    $sql = "SELECT d.DISCO 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN disco d ON d.ID_DISCO= dw.ID_DISCO
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 2";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $disc2 = $row['DISCO'];
                     /*/////////////////////TIPO DISCO 2//////////////////////*/
                    $sql = "SELECT t.TIPOD 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN tipodisco t ON t.ID_TIPOD= dw.ID_TIPOD
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 2";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $tdisc2 = $row['TIPOD'];
                    /*/////////////////////PROVEEDOR DISCO 2//////////////////////*/
                    $sql = "SELECT p.PROVEEDOR 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN proveedor p ON p.ID_PROVEEDOR= dw.ID_PROVEEDOR
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 2";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $pdisc2 = $row['PROVEEDOR'];
                    /*/////////////////////MARCA DISCO 2//////////////////////*/
                    $sql = "SELECT m.MARCA 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN modelo mo ON mo.ID_MODELO = dw.ID_MODELO
                    LEFT JOIN marcas m ON m.ID_MARCA= mo.ID_MARCA
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 2";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $mdisc2 = $row['MARCA'];
                    /*/////////////////////FACTURA DISCO 2//////////////////////*/
                    $sql = "SELECT FACTURA FROM discows WHERE ID_WS='$consulta[0]' AND NUMERO = 2";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $fadisc2 = $row['FACTURA'];
                    /*/////////////////////GARANTIA DISCO 2//////////////////////*/
                    $sql = "SELECT GARANTIA FROM discows WHERE ID_WS='$consulta[0]' AND NUMERO = 2";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $gdisc2 = $row['GARANTIA'];
                    /*/////////////////////FECHA DISCO 2//////////////////////*/
                    $sql = "SELECT FECHA FROM discows WHERE ID_WS='$consulta[0]' AND NUMERO = 2";;
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $fdisc2 = $row['FECHA'];



                    /*/////////////////////DISCO 3//////////////////////*/
                    $sql = "SELECT d.DISCO 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN disco d ON d.ID_DISCO= dw.ID_DISCO
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 3";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $disc3 = $row['DISCO'];
                     /*/////////////////////TIPO DISCO 3//////////////////////*/
                    $sql = "SELECT t.TIPOD 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN tipodisco t ON t.ID_TIPOD= dw.ID_TIPOD
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 3";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $tdisc3 = $row['TIPOD'];
                    /*/////////////////////PROVEEDOR DISCO 3//////////////////////*/
                    $sql = "SELECT p.PROVEEDOR 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN proveedor p ON p.ID_PROVEEDOR= dw.ID_PROVEEDOR
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 3";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $pdisc3 = $row['PROVEEDOR'];
                    /*/////////////////////MARCA DISCO 3//////////////////////*/
                    $sql = "SELECT m.MARCA 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN modelo mo ON mo.ID_MODELO = dw.ID_MODELO
                    LEFT JOIN marcas m ON m.ID_MARCA= mo.ID_MARCA
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 3";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $mdisc3 = $row['MARCA'];
                    /*/////////////////////FACTURA DISCO 3//////////////////////*/
                    $sql = "SELECT FACTURA FROM discows WHERE ID_WS='$consulta[0]' AND NUMERO = 3";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $fadisc3 = $row['FACTURA'];
                    /*/////////////////////GARANTIA DISCO 3//////////////////////*/
                    $sql = "SELECT GARANTIA FROM discows WHERE ID_WS='$consulta[0]' AND NUMERO = 3";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $gdisc3 = $row['GARANTIA'];
                    /*/////////////////////FECHA DISCO 3//////////////////////*/
                    $sql = "SELECT FECHA FROM discows WHERE ID_WS='$consulta[0]' AND NUMERO = 3";;
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $fdisc3 = $row['FECHA'];



                    /*/////////////////////DISCO 4//////////////////////*/
                    $sql = "SELECT d.DISCO 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN disco d ON d.ID_DISCO= dw.ID_DISCO
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 4";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $disc4 = $row['DISCO'];
                     /*/////////////////////TIPO DISCO 4//////////////////////*/
                    $sql = "SELECT t.TIPOD 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN tipodisco t ON t.ID_TIPOD= dw.ID_TIPOD
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 4";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $tdisc4 = $row['TIPOD'];
                    /*/////////////////////PROVEEDOR DISCO 4//////////////////////*/
                    $sql = "SELECT p.PROVEEDOR 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN proveedor p ON p.ID_PROVEEDOR= dw.ID_PROVEEDOR
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 4";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $pdisc4 = $row['PROVEEDOR'];
                    /*/////////////////////MARCA DISCO 4//////////////////////*/
                    $sql = "SELECT m.MARCA 
                    FROM inventario i 
                    LEFT JOIN discows dw ON dw.ID_WS = i.ID_WS
                    LEFT JOIN modelo mo ON mo.ID_MODELO = dw.ID_MODELO
                    LEFT JOIN marcas m ON m.ID_MARCA= mo.ID_MARCA
                    WHERE i.ID_WS='$consulta[0]' AND dw.NUMERO = 4";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $mdisc4 = $row['MARCA'];
                    /*/////////////////////FACTURA DISCO 4//////////////////////*/
                    $sql = "SELECT FACTURA FROM discows WHERE ID_WS='$consulta[0]' AND NUMERO = 4";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $fadisc4 = $row['FACTURA'];
                    /*/////////////////////GARANTIA DISCO 4//////////////////////*/
                    $sql = "SELECT GARANTIA FROM discows WHERE ID_WS='$consulta[0]' AND NUMERO = 4";
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $gdisc4 = $row['GARANTIA'];
                    /*/////////////////////FECHA DISCO 4//////////////////////*/
                    $sql = "SELECT FECHA FROM discows WHERE ID_WS='$consulta[0]' AND NUMERO = 4";;
                    $resultado = $datos_base->query($sql);
                    $row = $resultado->fetch_assoc();
                    $fdisc4 = $row['FECHA'];

                    function fecha($f){
                        $fecha = "0000-00-00";
                        $fv = "";

                        if($f == $fecha OR $f == $fv)
                        {
                            $f = date("d-m-Y", strtotime($f));
                            $f = "-";
                            /*$fec = "-";*/
                        }
                        else{
                            $f = date("d-m-Y", strtotime($f));
                        }
                        return $f;
                    }

                ?>  
                    <div class="form-group row" style=" padding:5px;">
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>EQUIPO:</u>&nbsp &nbsp &nbsp<?php echo $consulta[3]?></h4>
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>USUARIO:</u>&nbsp &nbsp &nbsp<?php echo $nom ?></h4>
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>ÁREA DE UBICACIÓN:</u>&nbsp &nbsp &nbsp<?php echo $are?></h4>
                    </div>


                    <div class="form-group row" style="padding:5px;">
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>TIPO DE EQUIPO:</u>&nbsp &nbsp &nbsp<?php echo $tip?></h4>
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>MARCA:</u>&nbsp &nbsp &nbsp<?php echo $mar?></h4>
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>ESTADO DEL EQUIPO:</u>&nbsp &nbsp &nbsp<?php echo $est?></h4>
                    </div>

                    <hr style='display: block; height: 3px;'>

                    <div class="form-group row" style="padding:5px;">
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>SISTEMA OPERATIVO:</u>&nbsp &nbsp &nbsp<?php echo $so?></h4>
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>PROCESADOR:</u>&nbsp &nbsp &nbsp<?php echo $micro?></h4>
                    </div>

                    <div class="form-group row" style="padding:5px;">
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>PLACA MADRE:</u>&nbsp &nbsp &nbsp<?php echo $placam." - ".$placammarca;?></h4>
                    </div>


                    <div class="form-group row" style="padding:10px;">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    <u>1°&nbspMEMORIA</u>: <?php echo $mem1." - ".$tmem1;?>
                                </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>PROVEEDOR:</u>&nbsp &nbsp &nbsp<?php echo $pmem1?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FACTURA:</u>&nbsp &nbsp &nbsp<?php echo $famem1?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FECHA:</u>&nbsp &nbsp &nbsp
                                        <?php 
                                        $f1= fecha($fmem1); 
                                        echo $f1;
                                        ?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>MARCA:</u>&nbsp &nbsp &nbsp<?php echo $mmem1?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>GARANTIA:</u>&nbsp &nbsp &nbsp<?php echo $gmem1?></h4>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                <u>2°&nbspMEMORIA</u>: <?php echo $mem2." - ".$tmem2;?>
                                </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>PROVEEDOR:</u>&nbsp &nbsp &nbsp<?php echo $pmem2?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FACTURA:</u>&nbsp &nbsp &nbsp<?php echo $famem2?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FECHA:</u>&nbsp &nbsp &nbsp
                                        <?php 
                                        $f1= fecha($fmem2); 
                                        echo $f1;
                                        ?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>MARCA:</u>&nbsp &nbsp &nbsp<?php echo $mmem2?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>GARANTIA:</u>&nbsp &nbsp &nbsp<?php echo $gmem2?></h4>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                <u>3°&nbspMEMORIA</u>: <?php echo $mem3." - ".$tmem3;?>
                                </button>
                                </h2>
                                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>PROVEEDOR:</u>&nbsp &nbsp &nbsp<?php echo $pmem3?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FACTURA:</u>&nbsp &nbsp &nbsp<?php echo $famem3?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FECHA:</u>&nbsp &nbsp &nbsp
                                        <?php 
                                        $f1= fecha($fmem3); 
                                        echo $f1;
                                        ?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>MARCA:</u>&nbsp &nbsp &nbsp<?php echo $mmem3?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>GARANTIA:</u>&nbsp &nbsp &nbsp<?php echo $gmem3?></h4>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                    <u>4°&nbspMEMORIA</u>: <?php echo $mem4." - ".$tmem4;?>
                                </button>
                                </h2>
                                <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>PROVEEDOR:</u>&nbsp &nbsp &nbsp<?php echo $pmem4?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FACTURA:</u>&nbsp &nbsp &nbsp<?php echo $famem4?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FECHA:</u>&nbsp &nbsp &nbsp
                                        <?php 
                                        $f1= fecha($fmem4); 
                                        echo $f1;
                                        ?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>MARCA:</u>&nbsp &nbsp &nbsp<?php echo $mmem4?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>GARANTIA:</u>&nbsp &nbsp &nbsp<?php echo $gmem4?></h4>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="form-group row" style="padding:10px;">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOn">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOn" aria-expanded="false" aria-controls="flush-collapseOn">
                                    <u>1°&nbspDISCO</u>: <?php echo $disc1." - ".$tdisc1;?>
                                </button>
                                </h2>
                                <div id="flush-collapseOn" class="accordion-collapse collapse" aria-labelledby="flush-headingOn" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>PROVEEDOR:</u>&nbsp &nbsp &nbsp<?php echo $pdisc1?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FACTURA:</u>&nbsp &nbsp &nbsp<?php echo $fadisc1?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FECHA:</u>&nbsp &nbsp &nbsp
                                        <?php 
                                        $f1= fecha($fdisc1); 
                                        echo $f1;
                                        ?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>MARCA:</u>&nbsp &nbsp &nbsp<?php echo $mdisc1?></h4>
                                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>GARANTIA:</u>&nbsp &nbsp &nbsp<?php echo $gdisc1?></h4>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTw">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTw" aria-expanded="false" aria-controls="flush-collapseTw">
                                    <u>2°&nbspDISCO</u>: <?php echo $disc2." - ".$tdisc2;?>
                                </button>
                                </h2>
                                <div id="flush-collapseTw" class="accordion-collapse collapse" aria-labelledby="flush-headingTw" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FACTURA:</u>&nbsp &nbsp &nbsp<?php echo $fadisc2?></h4>
                                    <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FECHA:</u>&nbsp &nbsp &nbsp
                                    <?php 
                                    $f1= fecha($fdisc2); 
                                    echo $f1;
                                    ?></h4>
                                    <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>MARCA:</u>&nbsp &nbsp &nbsp<?php echo $mdisc2?></h4>
                                    <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>GARANTIA:</u>&nbsp &nbsp &nbsp<?php echo $gdisc2?></h4>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingThre">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThre" aria-expanded="false" aria-controls="flush-collapseThre">
                                    <u>3°&nbspDISCO</u>: <?php echo $disc3." - ".$tdisc3;?>
                                </button>
                                </h2>
                                <div id="flush-collapseThre" class="accordion-collapse collapse" aria-labelledby="flush-headingThre" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FACTURA:</u>&nbsp &nbsp &nbsp<?php echo $fadisc3?></h4>
                                    <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FECHA:</u>&nbsp &nbsp &nbsp
                                    <?php 
                                    $f1= fecha($fdisc3); 
                                    echo $f1;
                                    ?></h4>
                                    <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>MARCA:</u>&nbsp &nbsp &nbsp<?php echo $mdisc3?></h4>
                                    <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>GARANTIA:</u>&nbsp &nbsp &nbsp<?php echo $gdisc3?></h4>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingFou">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFou" aria-expanded="false" aria-controls="flush-collapseFou">
                                    <u>4°&nbspDISCO</u>: <?php echo $disc4." - ".$tdisc4;?>
                                </button>
                                </h2>
                                <div id="flush-collapseFou" class="accordion-collapse collapse" aria-labelledby="flush-headingFou" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FACTURA:</u>&nbsp &nbsp &nbsp<?php echo $fadisc4?></h4>
                                    <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FECHA:</u>&nbsp &nbsp &nbsp
                                    <?php 
                                    $f1= fecha($fdisc4); 
                                    echo $f1;
                                    ?></h4>
                                    <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>MARCA:</u>&nbsp &nbsp &nbsp<?php echo $mdisc4?></h4>
                                    <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>GARANTIA:</u>&nbsp &nbsp &nbsp<?php echo $gdisc4?></h4>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <hr style='display: block; height: 3px;'>

                    <div class="form-group row" style="padding:5px;">
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>SERIALN:</u>&nbsp &nbsp &nbsp<?php echo $consulta[2]?></h4>
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>MASTERIZACIÓN:</u>&nbsp &nbsp &nbsp<?php echo $consulta[10]?></h4>
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>OBSERVACIÓN:</u>&nbsp &nbsp &nbsp<?php echo $consulta[7]?></h4>
                    </div>

                    <div class="form-group row" style="padding:5px;">
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>RED:</u>&nbsp &nbsp &nbsp<?php echo $red?></h4>
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>NRO MAC:</u>&nbsp &nbsp &nbsp<?php echo $consulta[11]?></h4> 
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>RESERVA DE IP:</u>&nbsp &nbsp &nbsp<?php echo $consulta[12]?></h4>
                    </div>

                    <div class="form-group row" style="padding:5px;">
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>PROVEEDOR:</u>&nbsp &nbsp &nbsp<?php echo $prov?></h4>
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>FACTURA:</u>&nbsp &nbsp &nbsp<?php echo $consulta[9]?></h4>
                        <h4 id="lblForm"class="col-form-label col-xl col-lg"><u>GARANTIA:</u>&nbsp &nbsp &nbsp<?php echo $consulta[17]?></h4>
                    </div>
            </div>
	</section>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>