<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
    $datos_base = mysqli_connect('localhost', 'root', '', 'incidentes') 
        or exit('No se puede conectar con la base de datos');

    $no_tic = mysqli_real_escape_string($datos_base, $no_tic);

    $sentencia = "SELECT * FROM periferico WHERE ID_PERI='" . $no_tic . "'";
    $resultado = mysqli_query($datos_base, $sentencia);

    return mysqli_fetch_assoc($resultado);
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>MODIFICAR MONITOR</title>
    <link rel="icon" href="../imagenes/logoInfraestructura.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
    <script>
    function enviar_formulario(formulario){
        Swal.fire({
            title: "Esta seguro de modificar este monitor?",
            icon: "warning",
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: "Cancelar",
            customClass:{
                actions: 'reverse-button'
            }
        })
        .then((result) => {
            if (result.isConfirmed) {
                formulario.submit()
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }
    </script>
<main>
    <div id="reporteEst">   		
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="../consulta/monitores.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>			
    </div>
    <section id="Inicio">
        <div id="titulo">
            <h1>MODIFICAR MONITOR</h1>
        </div>
        <div id="principalu" style="width: 97%" class="container-fluid">
            <!--  CONSULTA DE DATOS -->
            <?php 
            $sent= "SELECT PROVEEDOR FROM proveedor WHERE ID_PROVEEDOR = '" . $consulta['ID_PROVEEDOR'] . "'";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $prov = $row['PROVEEDOR'];

            $sent= "SELECT ESTADO FROM estado_ws WHERE ID_ESTADOWS = '".$consulta['ID_ESTADOWS']."'";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $est = $row['ESTADO'];

            $sent= "SELECT mo.MODELO, ma.MARCA 
            FROM modelo mo
            INNER JOIN marcas ma ON ma.ID_MARCA = mo.ID_MARCA 
            WHERE mo.ID_MODELO = '".$consulta['ID_MODELO']."'";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $mod = $row['MODELO']." - ".$row['MARCA'];

            $sent= "SELECT TIPO FROM tipop WHERE ID_TIPOP = '".$consulta['ID_TIPOP']."'";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $tip = $row['TIPO'];
            ?>
            <!--  CONSULTA DE DATOS -->

            <form method="POST" action="guardarmodmonitor2.php">
                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">ID:</label>
                    <input type="text" class="id" name="id" value="<?php echo $consulta['ID_PERI']?>" style="background-color:transparent;" readonly>
                </div>
                    <?php
                        if(isset($equipo)){
                        echo"
                            <p><u>MONITOR ASIGNADO AL EQUIPO:</u> ".$equipo."</p>";
                        }else{
                            echo"
                            <p><u>EL MONITOR NO ESTA ASIGNADO A UN EQUIPO</u></p>;";
                        }
                    ?>

                <div class="form-group row">
                    <label id="lblForm" class="col-form-label col-xl col-lg">N° GOBIERNO: </label>
                    <input style="margin-top: 5px; text-transform:uppercase;" class="form-control col-form-label col-xl col-lg" type="text" name="serieg" value="<?php echo $consulta['SERIEG']?>">
                </div>

                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">N° SERIE: </label>
                    <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="serie" value="<?php echo $consulta['SERIE']?>">
                </div>
                
                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">FACTURA: </label>
                    <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="fac" value="<?php echo $consulta['FACTURA']?>">
                </div>

                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">OBSERVACIÓN: </label>
                    <textarea style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" name="obs" rows="3"><?php echo $consulta['OBSERVACION']?></textarea>
                </div>
                
                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA: </label>
                    <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="garantia" value="<?php echo $consulta['GARANTIA']?>">
                </div>

                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">MODELO:</label>
                    <select name="modelo" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                    <option selected value="200"><?php echo $mod?></option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA
                    FROM modelo m
                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                    INNER JOIN tipop t ON t.ID_TIPOP = m.ID_TIPOP
                    WHERE (m.ID_TIPOP = 7 OR m.ID_TIPOP = 8) ORDER BY m.MODELO ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA'];?></option>
                    <?php endforeach?>
                    </select>
                </div>

                <div class="form-group row"> 
                    <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO: </label>
                    <select name="estado" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                    <option selected value="300"><?php echo $est?></option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT * FROM estado_ws ORDER BY ESTADO ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_ESTADOWS'] ?>><?php echo $opciones['ESTADO']?></option>
                    <?php endforeach?>
                    </select>
                </div>

                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR: </label>
                    <select name="prov" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                    <option selected value="400"><?php echo $prov?></option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                    <?php endforeach?>
                    </select>
                </div>
                                
                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DE MONITOR: </label>
                    <select name="tipop" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                    <option selected value="500"><?php echo $tip?></option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT * FROM tipop WHERE ID_TIPOP = 7 OR ID_TIPOP = 8 ORDER BY TIPO ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_TIPOP'] ?>><?php echo $opciones['TIPO']?></option>
                    <?php endforeach?>
                    </select>
                </div>

                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">USUARIO: </label>
                    <select name="usu" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                    <option selected value="600"><?php echo $usu?></option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT * FROM usuarios WHERE ID_ESTADOUSUARIO = 1 ORDER BY NOMBRE ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_USUARIO'] ?>><?php echo $opciones['NOMBRE']?></option>
                    <?php endforeach?>
                    </select>
                </div>
                <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                <div class="form-group row justify-content-end">
                    <input onClick="enviar_formulario(this.form)" style="width:20%"class="btn btn-success" type="button" value="MODIFICAR" class="button">
                </div>
            </form>
        </div>
    </section>
    </main>
	<footer>
		<div class="footer">
			<div class="container-fluid">
				<div class="row">
					<img src="../imagenes/cba-logo.png" class="img-fluid">
				</div>
			</div>
		</div>
    </footer>
<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>