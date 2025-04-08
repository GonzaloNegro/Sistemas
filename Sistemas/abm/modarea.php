<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
    $datos_base = mysqli_connect('localhost', 'root', '', 'incidentes') 
        or exit('No se puede conectar con la base de datos');

	/* sanitizar el valor recibido en $no_tic antes de meterlo en la consulta SQL. Esto es una medida de seguridad contra inyección SQL */
	$no_tic = mysqli_real_escape_string($datos_base, $no_tic);

    $sentencia = "SELECT * FROM area WHERE ID_AREA='" . $no_tic . "'";
    $resultado = mysqli_query($datos_base, $sentencia);

    return mysqli_fetch_assoc($resultado);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>MODIFICAR ÁREA</title>
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
        function validar_formulario(){
			
			var fieldsToValidate = [
                    {
                        selector: "#area",
                        errorMessage: "No ingresó nombre del área."
                    },
                    {
                        selector: "#repa",
                        errorMessage: "No ingresó repartición."
                    },
                    {
                        selector: "#estado",
                        errorMessage: "No ingresó estado."
                    }
                ];

                var isValid = true;

				$.each(fieldsToValidate, function(index, field) {
                    var element = $(field.selector);
                    if (element.val()== "" || element.val()== null) {
                      Swal.fire({
                      title: field.errorMessage,
                      icon: "warning",
                      showConfirmButton: true,
                      showCancelButton: false,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Aceptar',
                      cancelButtonText: "Cancelar",
                      customClass:{
                      actions: 'reverse-button'
                        }
                      })
                        isValid = false;
                        return false;
                    }
                });

				if (isValid ==true) {
								
								return true;
							}
							else{
								return false;
							}
		};
		function enviar_formulario(formulario){
        	if (validar_formulario()) {
				// alert("Todo OK");
				Swal.fire({
                        title: "Esta seguro de modificar esta área?",
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
		}
				
		</script>
    <div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="abmarea.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
		<div id="titulo" style="margin:20px;">
			<h1>MODIFICAR ÁREA</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid">
                <?php 
                include("../particular/conexion.php");
                $sent= "SELECT REPA FROM reparticion WHERE ID_REPA = $consulta[ID_REPA]";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $repa = $row['REPA'];
                ?>
                <form method="POST" action="guardarmodarea2.php">
                    <label>ID: </label>
                    <input type="text" class="id" name="id" value="<?php echo $consulta['ID_AREA']?>" readonly>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE DEL ÁREA: </label>
                        <input id="area" style="margin-top: 5px;text-transform:uppercase;" class="form-control col-form-label col-xl col-lg" type="text" name="area" value="<?php echo $consulta['AREA']?>">
                        
						<label id="lblForm"class="col-form-label col-xl col-lg">OBSERVACIONES:</label>
						<textarea class="form-control col-xl col-lg" name="obs" style="text-transform:uppercase" rows="3"><?php echo $consulta['OBSERVACION']?></textarea>
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:</label>
                        <select id="estado" name="estado" class="form-control col-form-label col-xl col-lg" required>
                            <option selected value="200"><?php echo $consulta['ACTIVO']?></option>
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="INACTIVO">INACTIVO</option>
                        </select>
                        <label id="lblForm"class="col-form-label col-xl col-lg">REPARTICIÓN:</label>
                        <select id="repa" name="repa" style="text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                            <option selected value="100"><?php echo $repa?></option>
                            <?php
                            include("../particular/conexion.php");
                            $consulta= "SELECT * FROM reparticion ORDER BY REPA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                            <option value= <?php echo $opciones['ID_REPA'] ?>><?php echo $opciones['REPA']?></option>
                            <?php endforeach?>
                        </select>
                    </div>
                    <div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
                        <input onClick="enviar_formulario(this.form)" style="width:20%"class="col-3 button" type="button" value="MODIFICAR" class="button">
                    </div>	
                </form>
	    </div>
	</section>
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>