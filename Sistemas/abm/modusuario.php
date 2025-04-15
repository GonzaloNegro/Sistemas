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

    $sentencia = "SELECT * FROM usuarios WHERE ID_USUARIO='" . $no_tic . "'";
    $resultado = mysqli_query($datos_base, $sentencia);

    return mysqli_fetch_assoc($resultado);
}

?>
<!DOCTYPE html>
<html>
<head>
<title>MODIFICAR USUARIO</title>
<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        title: "Esta seguro de modificar este usuario?",
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
    <div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="../consulta/consultausuario.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
    <div id="titulo" style="margin: 20px;">
			<h1>MODIFICAR USUARIO</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid">
                <?php
                include("../particular/conexion.php");
                $sent= "SELECT a.AREA, r.REPA FROM area a inner join reparticion r on a.ID_REPA=r.ID_REPA WHERE ID_AREA = $consulta[ID_AREA]";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $ar = $row['AREA'];
                $repa = $row['REPA'];

                $sent= "SELECT TURNO FROM turnos WHERE ID_TURNO = $consulta[ID_TURNO]";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $turno = $row['TURNO'];

                $sent= "SELECT ESTADO FROM estado_usuario WHERE ID_ESTADOUSUARIO = $consulta[ID_ESTADOUSUARIO]";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $estado = $row['ESTADO'];
                ?>

                <form method="POST" action="guardarmodusuario2.php">
                    <label>ID: </label>
                    <input type="text" class="id" name="id" value="<?php echo $consulta['ID_USUARIO']?>" readonly>
                    
                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">NOMBRE: </label>&nbsp &nbsp
                        <input class="form-control col-xl col-lg" type="text" name="nom" value="<?php echo $consulta['NOMBRE']?>">
                        <label id="lblForm" class="col-form-label col-xl col-lg">CUIL: </label>&nbsp &nbsp
                        <input class="form-control col-xl col-lg" type="text" name="cuil" value="<?php echo $consulta['CUIL']?>">
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">INTERNO:</label>
                        <input class="form-control col-xl col-lg" type="text" name="int" value="<?php echo $consulta['INTERNO']?>">
                        <label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓN:</label> &nbsp &nbsp
                        <textarea class="form-control col-xl col-lg" name="obs" style="text-transform:uppercase" rows="3"><?php echo $consulta['OBSERVACION']?></textarea>
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">CORREO: </label>&nbsp &nbsp
                        <input class="form-control col-xl col-lg" type="text" name="cor" value="<?php echo $consulta['CORREO']?>">
                        <label id="lblForm" class="col-form-label col-xl col-lg">CORREO PERSONAL: </label>&nbsp &nbsp
                        <input class="form-control col-xl col-lg" type="text" name="corp" value="<?php echo $consulta['CORREO_PERSONAL']?>">
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">TELEFONO: </label>
                        <input class="form-control col-xl col-lg" type="text" name="tel" value="<?php echo $consulta['TELEFONO_PERSONAL']?>">
                        <label id="lblForm" class="col-form-label col-xl col-lg">PISO:</label>
                            <select name="piso" class="form-control col-xl col-lg">
                                <option selected value="300"><?php echo $consulta['PISO']?></option>
								<option value="PB">PB</option>
								<option value="P1">P1</option>
								<option value="P2">P2</option>
                                <option value="P3">P3</option>
								<option value="P4">P4</option>
                                <option value="P5">P5</option>
								<option value="P6">P6</option>
                                <option value="P7">P7</option>
								<option value="P8">P8</option>
                                <option value="P9">P9</option>
                                <option value="EP">EP</option>
								<option value="SUB">SUB</option>
							</select>
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">ESTADO:</label>
                        <select class="form-control col-xl col-lg" name="act">
                            <option selected value="400"><?php echo $estado?></option>
                                        <?php
                                        include("../particular/conexion.php");
                                        $consulta= "SELECT ESTADO FROM estado_usuario ";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_ESTADOUSUARIO'] ?>><?php echo $opciones['ESTADO']?></option>
                                        <?php endforeach?>
                                </select>
                        <label id="lblForm" class="col-form-label col-xl col-lg">ÁREA:</label>&nbsp &nbsp
                        <select  class="form-control col-xl col-lg" name="are" style="text-transform:uppercase">
                                        <option selected value="200"><?php echo $ar?> - <?php echo $repa?></option>
                                        <?php
                                        include("../particular/conexion.php");
                                        $consulta= "SELECT a.ID_AREA, a.AREA, r.REPA FROM area a inner join reparticion r on a.ID_REPA=r.ID_REPA ORDER BY AREA ASC";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_AREA'] ?>><?php echo $opciones['AREA']?> - <?php echo $opciones['REPA']?></option>
                                        <?php endforeach?>
                        </select>
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                    <label id="lblForm" class="col-form-label col-xl col-lg">TURNO:</label>&nbsp &nbsp
                    <select  class="form-control col-xl col-lg" name="tur" style="text-transform:uppercase">
                                    <option selected value="100"><?php echo $turno?></option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM turnos ORDER BY TURNO ASC";
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
                            <input onClick="enviar_formulario(this.form)" style="width: 20%;"class="col-3 button" type="button" value="MODIFICAR" >
                    </div>
                </form>
	    </div>
	</section>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>