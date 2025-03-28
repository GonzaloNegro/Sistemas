<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM lineacelular WHERE ID_LINEACELULAR='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_LINEACELULAR'],/*0*/
		$filas['ID_LINEA'],/*1*/
		$filas['ID_CELULAR'],/*2*/
        $filas['ID_USUARIO'],/*3*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>DETALLES DE LINEA</title>
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
            <a id="vlv"  href="./celulares.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
<!--             <div class="btn-group col-3" role="group" >
                <button style="border: none;"><a id="botonleft" class="btn btn-secondary"<?php echo "href=impresoramov.php?no=".$consulta[0].""?>>MOVIMIENTOS</a></button>
                <button id="botonright" type="button" class="btn btn-success" onClick="imprimir()" ><i class='bi bi-printer'></i></button>
            </div> -->
		</div>
    </header>
	<section id="ingreso">
    <div id="titulo">
                <h1>DETALLES DE LINEA</h1>
        </div>
            <div id="detalles">
            <?php
                /*/////////////////////NOMBRE//////////////////////*/
                $sql = "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO='$consulta[3]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $nom = $row['NOMBRE'];
                /*/////////////////////AREA//////////////////////*/
                $sql = "SELECT a.AREA FROM usuarios u LEFT JOIN area a ON a.ID_AREA = u.ID_AREA WHERE u.ID_USUARIO='$consulta[3]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $are = $row['AREA'];
                /*/////////////////////ESTADO//////////////////////*/
                $sql = "SELECT e.ESTADO FROM estado_ws e INNER JOIN linea l ON l.ID_ESTADOWS = e.ID_ESTADOWS WHERE l.ID_LINEA='$consulta[1]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $est = $row['ESTADO'];
                /*/////////////////////NRO//////////////////////*/
                $sql = "SELECT NRO FROM linea WHERE ID_LINEA='$consulta[1]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $nro = $row['NRO'];
                /*/////////////////////ROAMING//////////////////////*/
                $sql = "SELECT r.ROAMING FROM movilinea m LEFT JOIN roaming r ON r.ID_ROAMING = m.ID_ROAMING WHERE m.ID_LINEA ='$consulta[1]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $roam = $row['ROAMING'];
                 /*/////////////////////PROCEDENCIA//////////////////////*/
                 $sql = "SELECT pr.PROCEDENCIA FROM periferico p LEFT JOIN procedencia pr ON pr.ID_PROCEDENCIA = p.ID_PROCEDENCIA WHERE p.ID_PROCEDENCIA='$consulta[6]'";
                 $resultado = $datos_base->query($sql);
                 $row = $resultado->fetch_assoc();
                 $proce = $row['PROCEDENCIA'];
                 /*/////////////////////PROVEEDOR//////////////////////*/
                 $sql = "SELECT pr.PROVEEDOR 
                 FROM linea l 
                 LEFT JOIN nombreplan n ON n.ID_NOMBREPLAN = l.ID_NOMBREPLAN 
                 LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = n.ID_PROVEEDOR 
                 WHERE l.ID_LINEA='$consulta[1]'";
                 $resultado = $datos_base->query($sql);
                 $row = $resultado->fetch_assoc();
                 $prove = $row['PROVEEDOR'];
                /*/////////////////////PLAN//////////////////////*/
                $sql = "SELECT p.PLAN, n.NOMBREPLAN
                FROM movilinea m
                LEFT JOIN nombreplan n ON n.ID_NOMBREPLAN = m.ID_NOMBREPLAN 
                LEFT JOIN plan p ON p.ID_PLAN = m.ID_PLAN 
                WHERE m.ID_LINEA='$consulta[1]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $plan = $row['PLAN'];
                $nombreplan = $row['NOMBREPLAN'];
                
                /*/////////////////////MARCA - MODELO//////////////////////*/
                $sql = "SELECT m.MODELO, ma.MARCA
                FROM celular c
                LEFT JOIN modelo m ON m.ID_MODELO = c.ID_MODELO 
                LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                WHERE c.ID_CELULAR ='$consulta[2]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $modelo = $row['MODELO'];
                $marca = $row['MARCA'];
                /*/////////////////////ESTADO//////////////////////*/
                $sql = "SELECT e.ESTADO FROM estado_ws e INNER JOIN celular c ON c.ID_ESTADOWS = e.ID_ESTADOWS WHERE c.ID_CELULAR='$consulta[2]'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $estC = $row['ESTADO'];
                 /*/////////////////////PROVEEDOR//////////////////////*/
                 $sql = "SELECT pr.PROVEEDOR 
                 FROM celular c
                 LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = c.ID_PROVEEDOR 
                 WHERE c.ID_CELULAR='$consulta[2]'";
                 $resultado = $datos_base->query($sql);
                 $row = $resultado->fetch_assoc();
                 $proveC = $row['PROVEEDOR'];
                 /*/////////////////////PROCEDENCIA//////////////////////*/
                 $sql = "SELECT pr.PROCEDENCIA 
                 FROM celular c
                 LEFT JOIN procedencia pr ON pr.ID_PROCEDENCIA = c.ID_PROCEDENCIA 
                 WHERE c.ID_CELULAR='$consulta[2]'";
                 $resultado = $datos_base->query($sql);
                 $row = $resultado->fetch_assoc();
                 $proce = $row['PROCEDENCIA'];
                 /*/////////////////////IMEI//////////////////////*/
                 $sql = "SELECT IMEI FROM celular WHERE ID_CELULAR='$consulta[2]'";
                 $resultado = $datos_base->query($sql);
                 $row = $resultado->fetch_assoc();
                 $imei = $row['IMEI'];
?>
            <h4><u>USUARIO RESPONSABLE:</u>&nbsp &nbsp &nbsp<?php echo $nom ?></h4>
            <h4><u>ÁREA DE UBICACIÓN:</u>&nbsp &nbsp &nbsp<?php echo $are?></h4>
            <h4><u>NÚMERO:</u>&nbsp &nbsp &nbsp<?php echo $nro?></h4>
            <h4><u>PLAN:</u>&nbsp &nbsp &nbsp<?php echo $nombreplan." - ".$plan?></h4>
            <h4><u>PROVEEDOR:</u>&nbsp &nbsp &nbsp<?php echo $prove?></h4>
            <h4><u>ESTADO:</u>&nbsp &nbsp &nbsp<?php echo $est?></h4>
            <h4><u>ROAMING:</u>&nbsp &nbsp &nbsp<?php echo $roam?></h4>
            <hr style='display: block; height: 3px;'>
            <h3 style='color:#53AAE0'>CELULAR ASOCIADO</h3>
            <h4><u>MARCA:</u>&nbsp &nbsp &nbsp<?php echo $marca?></h4>
            <h4><u>MODELO:</u>&nbsp &nbsp &nbsp<?php echo $modelo?></h4>
            <h4><u>IMEI:</u>&nbsp &nbsp &nbsp<?php echo $imei?></h4>
            <h4><u>PROVEEDOR:</u>&nbsp &nbsp &nbsp<?php echo $proveC?></h4>
            <h4><u>PROCEDENCIA:</u>&nbsp &nbsp &nbsp<?php echo $proce?></h4>
            <h4><u>ESTADO:</u>&nbsp &nbsp &nbsp<?php echo $estC?></h4>
            </div>
	</section>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>