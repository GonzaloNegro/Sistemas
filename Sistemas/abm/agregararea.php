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
	<title>AGREGAR ÁREA</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
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
			function ok(){
				// swal(  {title: "Área agregada correctamente",
				// 		icon: "success",
				// 		showConfirmButton: true,
				// 		showCancelButton: false,
				// 		})
				// 		.then((confirmar) => {
				// 		if (confirmar) {
				// 			window.location.href='abmarea.php';
				// 		}
				// 		}
				// 		);
				Swal.fire({
                        title: "Área cargada correctamente.",
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
                            window.location.href='abmarea.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
<script type="text/javascript">
			function no(){
				// swal(  {title: "La área ingresada ya está registrada",
				// 		icon: "error",
				// 		})
				// 		.then((confirmar) => {
				// 		if (confirmar) {
				// 			window.location.href='agregararea.php';
				// 		}
				// 		}
				// 		);
				Swal.fire({
                        title: "El área ya está registrada",
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
                            window.location.href='agregararea.php';


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
                        title: "Esta seguro de guardar esta área?",
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
		<div id="titulo" style="">
			<h1 style="font-size: 40px;">AGREGAR ÁREA</h1>
		</div>
        <div id="principalu" style="width: auto" class="container-fluid" data-aos="zoom-in">
						<form method="POST" action="guardarmodarea.php">
						<div class="form-group row" style="margin: 10px; padding:10px;">
						    <label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE DEL ÁREA:</label>
							<input id="area" style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="area" placeholder="NOMBRE DEL ÁREA" required>

							<label id="lblForm"class="col-form-label col-xl col-lg">REPARTICIÓN:</label>
							<select id="repa" name="repa" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
							<option selected disabled>-SELECCIONE UNA-</option>
							<?php
							include("../particular/conexion.php");

							$consulta= "SELECT * FROM reparticion ORDER BY REPA ASC";
							$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
							?>
							<?php foreach ($ejecutar as $opciones): ?> 
								<option value="<?php echo $opciones['ID_REPA']?>"><?php echo $opciones['REPA']?></option>						
							<?php endforeach ?>
							</select>
				        </div>	
						<div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:</label>
							<select id="estado" name="estado" class="form-control col-xl col-lg" required>
								<option value="ACTIVO" selected>ACTIVO</option>
								<option value="INACTIVO" >INACTIVO</option>
							</select>

							<label id="lblForm"class="col-form-label col-xl col-lg">OBSERVACIONES:</label>
							<textarea id="observacion"class="form-control col-xl col-lg" name="obs" placeholder="OBSERVACIONES" style="text-transform:uppercase" rows="3"></textarea>
				        </div>	
						<?php 
							if ($row['ID_PERFIL'] != 5) {
								echo '<div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
											<input onClick="enviar_formulario(this.form)" style="width:20%"class="col-3 button" type="button" value="GUARDAR" class="button">
										</div>';
							}
						?>
							
					</form>
					<?php
					if(isset($_GET['ok'])){
						?>
						<script>ok();</script>
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
	<footer></footer>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>