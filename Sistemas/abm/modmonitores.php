<?php 
error_reporting(0);
session_start();
include('..particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM periferico WHERE ID_PERI='".$no_tic."'";
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
        $filas['ID_MODELO'],/*18*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>MODIFICAR MONITOR</title>
    <link rel="icon" href="../imagenes/logoObrasPúblicas.png">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
					<a id="vlv"  href="abmmonitores.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
				</div>					
		</div>
	<section id="Inicio">
    <div id="titulo" style="margin: 20px;">
			<h1>MODIFICAR MONITOR</h1>
		</div>
        <div id="principalu" style="width: 97%" class="container-fluid">

                        <!--  CONSULTA DE DATOS -->
                         <?php 
                        include("..particular/conexion.php");
                        $sent= "SELECT PROVEEDOR FROM proveedor WHERE ID_PROVEEDOR = $consulta[12]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $prov = $row['PROVEEDOR'];?>
                        <?php 
                        include("..particular/conexion.php");
                        $sent= "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = $consulta[15]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $usu = $row['NOMBRE'];?>
                         <?php 
                        include("..particular/conexion.php");
                        $sent= "SELECT ESTADO FROM estado_ws WHERE ID_ESTADOWS = $consulta[17]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $est = $row['ESTADO'];?>
                         <?php 
                        include("..particular/conexion.php");
                        $sent= "SELECT mo.MODELO, ma.MARCA 
                        FROM modelo mo
                        INNER JOIN marcas ma ON ma.ID_MARCA = mo.ID_MARCA 
                        WHERE mo.ID_MODELO = $consulta[18]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $mod = $row['MODELO']." - ".$row['MARCA'];?>
                         <?php 
                        include("..particular/conexion.php");
                        $sent= "SELECT TIPO FROM tipop WHERE ID_TIPOP = $consulta[1]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $tip = $row['TIPO'];?>
                        <?php 
                        include("..particular/conexion.php");
                        $sent= "SELECT SERIEG FROM inventario WHERE ID_USUARIO = $consulta[15]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $equipo = $row['SERIEG'];?>
                        <!--  CONSULTA DE DATOS -->


                <form method="POST" action="guardarmodmonitor2.php">
                
                    <label >ID: </label>&nbsp &nbsp
                    <input type="text" class="id" name="id" value="<?php echo $consulta[0]?>">
                    <label><u>MONITOR ASIGNADO AL EQUIPO:</u> <?php echo $equipo;?> </label>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">N° GOBIERNO: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;" class="form-control col-form-label col-xl col-lg" type="text" name="serieg" value="<?php echo $consulta[3]?>">
                        <label id="lblForm"class="col-form-label col-xl col-lg">N° SERIE: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="serie" value="<?php echo $consulta[5]?>">
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">FACTURA: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="fac" value="<?php echo $consulta[13]?>">
                        <label id="lblForm"class="col-form-label col-xl col-lg">OBSERVACIÓN: </label>
                        <textarea style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" name="obs" rows="3"><?php echo $consulta[7]?></textarea>
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA: </label>
                        <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="garantia" value="<?php echo $consulta[16]?>">
                        <label id="lblForm"class="col-form-label col-xl col-lg">MODELO:</label>
                            <select name="modelo" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                                            <option selected value="200"><?php echo $mod?></option>
                                            <?php
                                    include("..particular/conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                                    INNER JOIN tipop t ON t.ID_TIPOP = m.ID_TIPOP
                                    WHERE (m.ID_TIPOP = 7 OR m.ID_TIPOP = 8)";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                        </select>
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;"> 
                        <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO: </label>
                        <select name="estado" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                                        <option selected value="300"><?php echo $est?></option>
                                        <?php
                                        include("..particular/conexion.php");
                                        $consulta= "SELECT * FROM estado_ws";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_ESTADOWS'] ?>><?php echo $opciones['ESTADO']?></option>
                                        <?php endforeach?>
                                    </select>
                    <label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR: </label>
                    <select name="prov" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                                    <option selected value="400"><?php echo $prov?></option>
                                    <?php
                                    include("..particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
                    </div>
                                    
                    <div class="form-group row" style="margin: 10px; padding:10px;">
                    <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DE MONITOR: </label>
                    <select name="tipop" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                                    <option selected value="500"><?php echo $tip?></option>
                                    <?php
                                    include("..particular/conexion.php");
                                    $consulta= "SELECT * FROM tipop WHERE ID_TIPOP = 7 OR ID_TIPOP = 8";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOP'] ?>><?php echo $opciones['TIPO']?></option>
                                    <?php endforeach?>
                                </select>
                                <label id="lblForm"class="col-form-label col-xl col-lg">USUARIO: </label>
                        <select name="usu" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                                        <option selected value="600"><?php echo $usu?></option>
                                        <?php
                                        include("..particular/conexion.php");
                                        $consulta= "SELECT * FROM usuarios";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_USUARIO'] ?>><?php echo $opciones['NOMBRE']?></option>
                                        <?php endforeach?>
                                    </select>
                    </div>
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                    <div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
					    <input style="width:20%"class="col-3 button" type="submit" value="MODIFICAR" class="button">
				    </div>
                </form>
	    </div>
	</section>
</body>
</html>