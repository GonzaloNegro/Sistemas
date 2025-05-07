<?php 
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT CUIL, RESOLUTOR FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>AGREGAR RESOLUTOR</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
			function ok(){
				// swal(  {title: "Resolutor cargado correctamente",
				// 		icon: "success",
				// 		showConfirmButton: true,
				// 		showCancelButton: false,
				// 		})
				// 		.then((confirmar) => {
				// 		if (confirmar) {
				// 			window.location.href='abmresolutor.php';
				// 		}
				// 		}
				// 		);
				// 		}
						Swal.fire({
                        title: "Resolutor cargado correctamente.",
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
                            window.location.href='abmresolutor.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
<script type="text/javascript">
			function repeat(){
				// swal(  {title: "Resolutor cargado correctamente. Verifique el nombre del resolutor, ya que existe este nombre registrado previamente!",
				// 		icon: "info",
				// 		})
				// 		.then((confirmar) => {
				// 		if (confirmar) {
				// 			window.location.href='abmresolutor.php';
				// 		}
				// 		}
				// 		);
						Swal.fire({
                        title: "Resolutor cargado correctamente. Verifique el nombre del resolutor, ya que existe este nombre registrado previamente!",
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
                            window.location.href='abmresolutor.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
				
			}	
			</script>
<script type="text/javascript">
			function no(){
				// swal(  {title: "El resolutor ya está registrado",
				// 		icon: "error",
				// 		})
				// 		.then((confirmar) => {
				// 		if (confirmar) {
				// 			window.location.href='agregarresolutor.php';
				// 		}
				// 		}
				// 		);
						Swal.fire({
                        title: "El resolutor ya está registrado",
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
                            window.location.href='agregarresolutor.php';


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
                        selector: "#nombre_resolutor",
                        errorMessage: "No ingresó nombre del resolutor."
                    },
                    {
                        selector: "#cuil",
                        errorMessage: "No ingresó cuil."
                    },
                    {
                        selector: "#correo",
                        errorMessage: "No ingresó correo."
                    },
                    {
                        selector: "#telefono",
                        errorMessage: "No ingresó teléfono."
                    },
                    {
                        selector: "#tipo",
                        errorMessage: "No seleccionó tipo."
                    },
                    {
                        selector: "#perfil",
                        errorMessage: "No seleccionó perfil."
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
                        title: "Esta seguro de guardar este resolutor?",
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
        <script>
            function validarLongitud(input) {
                if (input.value.length > 11) {
                    input.value = input.value.slice(0, 11);
                }
            }
        </script>

<main>
	<div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="abmresolutor.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
		<div id="titulo">
			<h1>AGREGAR RESOLUTOR</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
					<form method="POST" action="./agregados.php">
                        <div class="form-group row">
                            <label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE:</label>
							<input id="nombre_resolutor" style="text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="nombre_resolutor" placeholder="NOMBRE" required>
                        </div>	
                        <div class="form-group row">
							<label id="lblForm"class="col-form-label col-xl col-lg">CUIL:</label>
                            <input id="cuil" class="form-control col-form-label col-xl col-lg" type="number"  oninput="validarLongitud(this)" name="cuil" placeholder="20xxxxxxxx3" required>
                        </div>

                        <div class="form-group row">
                            <label id="lblForm" class="col-form-label col-xl col-lg">CORREO:</label> 
							<input id="correo" style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" type="mail" name="correo" placeholder="xxxxx@cba.gov.ar">
                        </div>  

                        <div class="form-group row">
							<label id="lblForm"class="col-form-label col-xl col-lg">TELEFONO:</label>
                            <input id="telefono" style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" type="number" name="telefono" placeholder="351xxxxxxx">
                        </div>    
						
                        <div class="form-group row">
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select id="tipo" name="tipo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
								<option selected disabled="area">-SELECCIONE UNA-</option>
								<?php
								include("../particular/conexion.php");
								$consulta= "SELECT * FROM tipo_resolutor ORDER BY TIPO_RESOLUTOR ASC";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_TIPO_RESOLUTOR']?>"><?php echo $opciones['TIPO_RESOLUTOR']?></option>
								<?php endforeach ?>
								</select>
                        </div>  
                        <div class="form-group row">
                            <label id="lblForm"class="col-form-label col-xl col-lg">PERFIL:</label>
								<select id="perfil" name="perfil" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
								<option selected disabled="perfil">-SELECCIONE UNA-</option>
								<?php
								include("../particular/conexion.php");
								$consulta= "SELECT * FROM perfiles ORDER BY PERFILES ASC";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_PERFIL']?>"><?php echo $opciones['PERFILES']?></option>
								<?php endforeach ?>
								</select>
						</div>  
						<div class="form-group row justify-content-end">
					<input style="width:20%" onClick="enviar_formulario(this.form)" type="button" value="GUARDAR" name="agregarResolutor" class="btn btn-success">
				</div>	
					</form>
					<?php
				if(isset($_GET['ok'])){
					?>
					<script>ok();</script>
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
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>