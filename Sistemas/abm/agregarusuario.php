<?php 
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>AGREGAR USUARIO</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
<script type="text/javascript">
			function done(){
				Swal.fire({
                        title: "Usuario cargado correctamente.",
                        icon: "success",
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
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.location.href='abmusuario.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
<script type="text/javascript">
			function repeat(){
				Swal.fire({
                        title: "Usuario cargado correctamente. Verifique el nombre del usuario, ya que existe este nombre registrado previamente!",
                        icon: "info",
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
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.location.href='abmusuario.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
<script type="text/javascript">
			function no(){
				Swal.fire({
                        title: "El Usuario ya está registrado",
                        icon: "error",
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
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.location.href='agregarusuario.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
			<script>
        function validar_formulario(){
			
			var fieldsToValidate = [
                    {
                        selector: "#nombre_usuario",
                        errorMessage: "No ingresó nombre del usuario."
                    },
                    {
                        selector: "#cuil",
                        errorMessage: "No ingresó cuil."
                    },
                    {
                        selector: "#cuil",
                        errorMessage: "No seleccionó área."
                    },
                    {
                        selector: "#turno",
                        errorMessage: "No seleccionó turno."
                    },
                    {
                        selector: "#activo",
                        errorMessage: "No seleccionó activo."
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
                        title: "Esta seguro de guardar este usuario?",
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
            <a id="vlv"  href="../consulta/consultausuario.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>	
        <section id="Inicio">
		<div id="titulo" style="margin: 20px;">
			<h1>AGREGAR USUARIO</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
						<form method="POST" action="guardarmodusuario.php">
                            <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm" class="col-form-label col-xl col-lg">USUARIO:</label>
                            <input id="nombre_usuario" class="form-control col-xl col-lg" style="text-transform:uppercase;" type="text" name="nombre_usuario" placeholder="APELLIDO Y NOMBRE" required>
							<label id="lblForm"class="col-form-label col-xl col-lg">CUIL:</label>
                            <input id="cuil" class="form-control col-xl col-lg" type="text" name="cuil" placeholder="CUIL" required>
                            </div>
                            <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">ÁREA:</label>
                            <select id="area" name="area" class="form-control col-xl col-lg" required>
							<option selected disabled="area">-SELECCIONE UNA-</option>
							<?php
							include("../particular/conexion.php");

							$consulta= "SELECT a.ID_AREA, a.AREA, r.REPA FROM area a inner join reparticion r on a.ID_REPA=r.ID_REPA ORDER BY AREA ASC";
							$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
							?>
							<?php foreach ($ejecutar as $opciones): ?> 
								<option value="<?php echo $opciones['ID_AREA']?>"><?php echo $opciones['AREA']?> - <?php echo $opciones['REPA']?></option>						
							<?php endforeach ?>
							</select>


							<label id="lblForm"class="col-form-label col-xl col-lg">PISO:</label>
                            <select name="piso" style="text-transform:uppercase" class="form-control col-xl col-lg">
<!-- 								<option selected disabled="piso">-SELECCIONE UNA-</option> -->
								<option value="PB" selected>PB</option>
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
							<label id="lblForm"class="col-form-label col-xl col-lg">INTERNO:</label>
                            <input class="form-control col-xl col-lg" type="text" name="interno" placeholder="INTERNO" class="corto">
							<label id="lblForm"class="col-form-label col-xl col-lg">TELEFONO PERSONAL:</label>
                            <input class="form-control col-xl col-lg" type="text" name="telefono_personal" placeholder="TELEFONO PERSONAL">
                            </div>
                            <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">CORREO:</label>
                            <input class="form-control col-xl col-lg" type="text" name="correo" maxlength="75" placeholder="CORREO" class="achicar">
							<label id="lblForm"class="col-form-label col-xl col-lg">CORREO PERSONAL:</label>
                            <input class="form-control col-xl col-lg" type="text" maxlength="75" name="correo_personal" placeholder="CORREO PERSONAL" class="achicar">
							</div>
							<div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">TURNO:</label>
							<select id="turno" name="turno" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
							<option selected disabled>-SELECCIONE UNA-</option>
							<?php
							include("../particular/conexion.php");

							$consulta= "SELECT * FROM turnos ORDER BY TURNO ASC";
							$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
							?>
							<?php foreach ($ejecutar as $opciones): ?> 
								<option value="<?php echo $opciones['ID_TURNO']?>"><?php echo $opciones['TURNO']?></option>						
							<?php endforeach ?>
							</select>
							<label id="lblForm"class="col-form-label col-xl col-lg">ACTIVO:</label>
							<select id="activo" name="activo" class="form-control col-xl col-lg" required>
<!-- 								<option selected disabled>-SELECCIONE UNA-</option> -->
								<option value="ACTIVO" selected>ACTIVO</option>
								<option value="INACTIVO">INACTIVO</option>
							</select>
							</div>
							<div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">OBSERVACIÓN:</label>
							<textarea class="form-control col-xl col-lg" name="obs" placeholder="OBSERVACIÓN" style="text-transform:uppercase" rows="3"></textarea>
							</div>
                            <?php 
							if ($row['ID_PERFIL'] != 5) {
								echo '<div class="row justify-content-end" style="margin: 10px; padding:10px;">
                                        <input onClick="enviar_formulario(this.form)" style="width: 20%;"class="col-3 button" type="button" value="GUARDAR" >
                                        </div>';
							}
						?>
                            
					</form>
					<?php
				if(isset($_GET['ok'])){
					?>
					<script>done();</script>
					<?php			
				}
				if(isset($_GET['repeat'])){
					?>
					<script>repeat();</script>
					<?php			
				}
				if(isset($_GET['no'])){
					?>
					<script>no();</script>
					<?php			
				}
			?>
		</div>
	</section>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>