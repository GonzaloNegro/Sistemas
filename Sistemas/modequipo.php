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
        $filas['RIP'],/*14*/
        $filas['IP'],/*15*/
        $filas['ID_RED'],/*16*/
        $filas['ID_TIPOWS'],/*17*/
        $filas['ID_USUARIO'],/*18*/
        $filas['GARANTIA'],/*19*/
        $filas['ID_MICRO'],/*20*/
        $filas['ID_PLACAM']/*21*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
<title>MODIFICAR EQUIPO</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloagregar.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                    $sent= "SELECT RED FROM red WHERE ID_RED = $consulta[16]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $red = $row['RED'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT PLACAM FROM placam WHERE ID_PLACAM = $consulta[21]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $pla = $row['PLACAM'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT SIST_OP FROM so WHERE ID_SO = $consulta[6]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $so = $row['SIST_OP'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT MICRO FROM micro WHERE ID_MICRO = $consulta[20]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $mic = $row['MICRO'];
                ?>  
                <?php 
                    include("conexion.php");
                    $sent= "SELECT ESTADO FROM estado_ws WHERE ID_ESTADOWS = $consulta[8]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $est = $row['ESTADO'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT PROVEEDOR FROM proveedor WHERE ID_PROVEEDOR = $consulta[10]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $pro = $row['PROVEEDOR'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT TIPOWS FROM tipows WHERE ID_TIPOWS = $consulta[17]";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tip = $row['TIPOWS'];
                ?>  
                <?php 
                    include("conexion.php");
                    $sent= "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = $consulta[18]";
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
                    $sent= "SELECT m.MEMORIA FROM wsmem w LEFT JOIN memoria m ON m.ID_MEMORIA = w.ID_MEMORIA WHERE w.ID_WS = $consulta[0] AND w.SLOT = 2";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $mem2 = $row['MEMORIA'];
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
                    $sent= "SELECT m.MEMORIA FROM wsmem w LEFT JOIN memoria m ON m.ID_MEMORIA = w.ID_MEMORIA WHERE w.ID_WS = $consulta[0] AND w.SLOT = 4";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $mem4 = $row['MEMORIA'];
                ?>
                            <!-- TIPO MEMORIAS -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->
                <?php 
                    include("conexion.php");
                    $sent= "SELECT t.TIPOMEM FROM wsmem w LEFT JOIN tipomem t ON t.ID_TIPOMEM = w.ID_TIPOMEM WHERE w.ID_WS = $consulta[0] AND w.SLOT = 1";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tmem1 = $row['TIPOMEM'];
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
                    $sent= "SELECT t.TIPOMEM FROM wsmem w LEFT JOIN tipomem t ON t.ID_TIPOMEM = w.ID_TIPOMEM WHERE w.ID_WS = $consulta[0] AND w.SLOT = 3";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tmem3 = $row['TIPOMEM'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT t.TIPOMEM FROM wsmem w LEFT JOIN tipomem t ON t.ID_TIPOMEM = w.ID_TIPOMEM WHERE w.ID_WS = $consulta[0] AND w.SLOT = 4";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tmem4 = $row['TIPOMEM'];
                ?>

                         <!-- DISCOS -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->

                <?php 
                    include("conexion.php");
                    $sent= "SELECT d.DISCO FROM discows dw LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 1";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dis1 = $row['DISCO'];
                ?>
                 <?php 
                    include("conexion.php");
                    $sent= "SELECT d.DISCO FROM discows dw LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 2";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dis2 = $row['DISCO'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT d.DISCO FROM discows dw LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 3";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dis3 = $row['DISCO'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT d.DISCO FROM discows dw LEFT JOIN disco d ON d.ID_DISCO = dw.ID_DISCO WHERE dw.ID_WS = $consulta[0] AND dw.NUMERO = 4";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $dis4 = $row['DISCO'];
                ?>

                         <!-- TIPO DISCOS -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->

                <?php 
                    include("conexion.php");
                    $sent= "SELECT t.TIPOD FROM discows d LEFT JOIN tipodisco t ON t.ID_TIPOD = d.ID_TIPOD WHERE d.ID_WS = $consulta[0] AND d.NUMERO = 1";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tdis1 = $row['TIPOD'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT t.TIPOD FROM discows d LEFT JOIN tipodisco t ON t.ID_TIPOD = d.ID_TIPOD WHERE d.ID_WS = $consulta[0] AND d.NUMERO = 2";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tdis2 = $row['TIPOD'];
                ?>
                <?php
                    include("conexion.php");
                    $sent= "SELECT t.TIPOD FROM discows d LEFT JOIN tipodisco t ON t.ID_TIPOD = d.ID_TIPOD WHERE d.ID_WS = $consulta[0] AND d.NUMERO = 3";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tdis3 = $row['TIPOD'];
                ?>
                <?php 
                    include("conexion.php");
                    $sent= "SELECT t.TIPOD FROM discows d LEFT JOIN tipodisco t ON t.ID_TIPOD = d.ID_TIPOD WHERE d.ID_WS = $consulta[0] AND d.NUMERO = 4";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $tdis4 = $row['TIPOD'];
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
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="mac" value="<?php echo $consulta[13]?>">
                        <label id="lblForm"class="col-form-label col-xl col-lg">OBSERVACIÓN: </label>
                        <textarea style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" name="obs" rows="3"><?php echo $consulta[9]?></textarea>
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">IP: </label>
                        <input style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" type="text" name="ip" value="<?php echo $consulta[15]?>">
                        <label id="lblForm"class="col-form-label col-xl col-lg">FACTURA: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="fac" value="<?php echo $consulta[11]?>">
                    </div>


                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="gar" value="<?php echo $consulta[19]?>">
                        <label id="lblForm"class="col-form-label col-xl col-lg">MASTERIZACIÓN: </label>
                        <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="masterizacion">
                        <option selected value="100"><?php echo $consulta[12]?></option>
                        <option value="SI">SI</option>
                            <option value ="NO">NO</option>
                        </select>
                    </div>


                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">RIP: </label>
                        <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="reserva">
                        <option selected value="200"><?php echo $consulta[14]?></option>
                            <option value ="NO">NO</option>
                            <option value="SI">SI</option>
                        </select>
                        <label id="lblForm"class="col-form-label col-xl col-lg">RED: </label>
                        <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="red">
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
                    <label id="lblForm"class="col-form-label col-xl col-lg">PLACA MADRE: </label>
                    <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="placam">
                                    <option selected value="400"><?php echo $pla?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM placam";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PLACAM'] ?>><?php echo $opciones['PLACAM']?></option>
                                    <?php endforeach?>
                                </select>
                    <label id="lblForm"class="col-form-label col-xl col-lg">SISTEMA OPERATIVO: </label>
                        <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="so">
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
                    </div>


                    <div class="form-group row" style="margin: 10px; padding:10px;">           
                        <label id="lblForm"class="col-form-label col-xl col-lg">MICRO: </label>
                        <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="micro">
                                        <option selected value="600"><?php echo $mic?></option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM micro";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_MICRO'] ?>><?php echo $opciones['MICRO']?></option>
                                        <?php endforeach?>
                                    </select>
                        <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO: </label>
                        <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="est">
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
                        <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="prov">
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
                        <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="tippc">
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
                        <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="usu">
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
                        <label id="lblForm"class="col-form-label col-xl col-lg">MARCA: </label>
                        <select style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" name="marca">
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

                    <hr style='display: block; height: 3px;'>
                    <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">MEMORIAS</h1>

<div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading1">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse1" aria-expanded="false" aria-controls="flush-collapse1">
        SLOT 1
      </button>
    </h2>
    <div id="flush-collapse1" class="accordion-collapse collapse" aria-labelledby="flush-heading1" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
				<select name="mem1" class="form-control col-xl col-lg">
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
                            <select name="tmem1" class="form-control col-xl col-lg">
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
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading2">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse2" aria-expanded="false" aria-controls="flush-collapse2">
        SLOT 2
      </button>
    </h2>
    <div id="flush-collapse2" class="accordion-collapse collapse" aria-labelledby="flush-heading2" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem2" class="form-control col-xl col-lg">
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
                            <select name="tmem2" class="form-control col-xl col-lg">
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
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading3">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse3" aria-expanded="false" aria-controls="flush-collapse3">
        SLOT 3
      </button>
    </h2>
    <div id="flush-collapse3" class="accordion-collapse collapse" aria-labelledby="flush-heading3" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem3" class="form-control col-xl col-lg">
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
                            <select name="tmem3" class="form-control col-xl col-lg">
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
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading4">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse4" aria-expanded="false" aria-controls="flush-collapse4">
        SLOT 4
      </button>
    </h2>
    <div id="flush-collapse4" class="accordion-collapse collapse" aria-labelledby="flush-heading4" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem4" class="form-control col-xl col-lg">
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
                            <select name="tmem4" class="form-control col-xl col-lg">
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
      </div>
    </div>
  </div>
</div>








                        

<hr style='display: block; height: 3px;'>
<h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">DISCOS</h1>

<div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        SLOT DE DISCO 1
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 1:</label>
                            <select name="disc1" class="form-control col-xl col-lg">
                            <option selected value="1600"><?php echo $dis1?></option>
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
                            <select name="tdisc1" class="form-control col-xl col-lg">
                            <option selected value="1601"><?php echo $tdis1?></option>
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
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
      SLOT DE DISCO 2
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 2:</label>
                            <select name="disc2" class="form-control col-xl col-lg">
                            <option selected value="1700"><?php echo $dis2?></option>
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
                            <select name="tdisc2" class="form-control col-xl col-lg">
                            <option selected value="1701"><?php echo $tdis2?></option>
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
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
      SLOT DE DISCO 3
      </button>
    </h2>
    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 3:</label>
                            <select name="disc3" class="form-control col-xl col-lg">
                            <option selected value="1800"><?php echo $dis3?></option>
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
                            <select name="tdisc3" class="form-control col-xl col-lg">
                            <option selected value="1801"><?php echo $tdis3?></option>
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
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
      SLOT DE DISCO 4
      </button>
    </h2>
    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
      <div class="form-group row" style="margin: 10px; padding:10px;">
			<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 4:</label>
                            <select name="disc4" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
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
                            <select name="tdisc4" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
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