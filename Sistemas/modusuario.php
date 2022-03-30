<?php 
session_start();
include('conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM usuarios WHERE ID_USUARIO='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_USUARIO'],/*0*/
		$filas['NOMBRE'],/*1*/
		$filas['CUIL'],/*2*/
        $filas['ID_AREA'],/*3*/
        $filas['PISO'],/*4*/
        $filas['INTERNO'],/*5*/
        $filas['CORREO'],/*6*/
        $filas['CORREO_PERSONAL'],/*7*/
        $filas['TELEFONO_PERSONAL'],/*8*/
        $filas['ID_TURNO'],/*9*/
        $filas['ACTIVO'],/*10*/
        $filas['OBSERVACION']/*11*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
<title>MODIFICAR USUARIO</title>
<link rel="icon" href="imagenes/logoObrasPúblicas.png">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloagregar.css">
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
					<a id="vlv"  href="abmusuario.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
				</div>					
		</div>
	<section id="Inicio">
    <div id="titulo" style="margin: 20px;">
			<h1>MODIFICAR USUARIO</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid">
                <?php
                include("conexion.php");
                $sent= "SELECT AREA FROM area WHERE ID_AREA = $consulta[3]";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $ar = $row['AREA'];
                ?>
                
                <?php 
                include("conexion.php");
                $sent= "SELECT TURNO FROM turnos WHERE ID_TURNO = $consulta[9]";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $turno = $row['TURNO'];
                ?>

                <form method="POST" action="guardarmodusuario2.php">
                    <label>ID: </label>
                    <input type="text" class="id" name="id" value="<?php echo $consulta[0]?>">
                    
                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">NOMBRE: </label>&nbsp &nbsp
                        <input class="form-control col-xl col-lg" type="text" name="nom" value="<?php echo $consulta[1]?>">
                        <label id="lblForm" class="col-form-label col-xl col-lg">CUIL: </label>&nbsp &nbsp
                        <input class="form-control col-xl col-lg" type="text" name="cuil" value="<?php echo $consulta[2]?>">
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">PISO:</label>
                            <select name="piso" class="form-control col-xl col-lg" required>
                                <option selected value="400"><?php echo $consulta[4]?></option>
								<option value="PB">PB</option>
								<option value="P1">P1</option>
								<option value="P2">P2</option>
							</select>
                        <label id="lblForm" class="col-form-label col-xl col-lg">INTERNO:</label>
                        <input class="form-control col-xl col-lg" type="text" name="int" value="<?php echo $consulta[5]?>">
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">CORREO: </label>&nbsp &nbsp
                        <input class="form-control col-xl col-lg" type="text" name="cor" value="<?php echo $consulta[6]?>">
                        <label id="lblForm" class="col-form-label col-xl col-lg">CORREO PERSONAL: </label>&nbsp &nbsp
                        <input class="form-control col-xl col-lg" type="text" name="corp" value="<?php echo $consulta[7]?>">
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">TELEFONO: </label>&nbsp &nbsp
                        <input class="form-control col-xl col-lg" type="text" name="tel" value="<?php echo $consulta[8]?>">
                        <label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓNES:</label> &nbsp &nbsp
                        <textarea class="form-control col-xl col-lg" name="obs" style="text-transform:uppercase" rows="3"><?php echo $consulta[11]?></textarea>
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">ESTADO:</label>&nbsp &nbsp
                        <select class="form-control col-xl col-lg" name="act" required>
                                    <option selected value="300"><?php echo $consulta[10]?></option>
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="INACTIVO">INACTIVO</option>
                                </select>
                        <label id="lblForm" class="col-form-label col-xl col-lg">ÁREA:</label>&nbsp &nbsp
                        <select  class="form-control col-xl col-lg" name="are">
                                        <option selected value="200"><?php echo $ar?></option>
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
                    <label id="lblForm" class="col-form-label col-xl col-lg">TURNO:</label>&nbsp &nbsp
                    <select  class="form-control col-xl col-lg" name="tur">
                                    <option selected value="100"><?php echo $turno?></option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM turnos";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TURNO'] ?>><?php echo $opciones['TURNO']?></option>
                                    <?php endforeach?>
                                </select>
                    </div>
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                    <div class="row justify-content-end" style="margin: 10px; padding:10px;">
                            <input style="width: 20%;"class="col-3 button" type="submit" value="MODIFICAR" >
                    </div>
                </form>
	    </div>
	</section>
</body>
</html>