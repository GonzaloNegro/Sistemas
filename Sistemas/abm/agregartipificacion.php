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
	<title>AGREGAR TIPIFICACIÓN</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
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
				// swal(  {title: "Tipificacion cargada correctamente",
				// 		icon: "success",
				// 		showConfirmButton: true,
				// 		showCancelButton: false,
				// 		})
				// 		.then((confirmar) => {
				// 		if (confirmar) {
				// 			window.location.href='abmtipificacion.php';
				// 		}
				// 		}
				// 		);

						Swal.fire({
                        title: "Tipificacion cargada correctamente",
                        icon: "success",
                        showConfirmButton: true,
                        showCancelButton: false,
						confirmButtonColor: '#198754',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Confirmar',
						cancelButtonText: "Cancelar",
						reverseButtons: true,
								customClass:{
                            actions: 'reverse-button'
                        }
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.location.href='abmtipificacion.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
<script type="text/javascript">
			function no(){
				Swal.fire({
                        title: "La tipificación ya está registrada",
                        icon: "error",
                        showConfirmButton: true,
                        showCancelButton: false,
              confirmButtonColor: '#198754',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: "Cancelar",
                reverseButtons: true,
                        customClass:{
                            actions: 'reverse-button'
                        }
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.location.href='agregartipificacion.php';


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
                        selector: "#tipificacion",
                        errorMessage: "No ingresó nombre de la Tipificación."
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
			</script>
			<script>
				
			function enviar_formulario(formulario, accion) {
			// Asigna el valor de la acción al campo oculto "accion"
			formulario.querySelector('#accion').value = accion;

			if (validar_formulario()) {
				const campos = [
					{ id: 'tipificacion', label: 'Nombre de la Tipificación' }
				];

				confirmarEnvioFormulario(
					formulario,
					campos,
					"Datos de la tipifícación",
					"¿Está seguro de guardar esta tipificación?"
				);
			}
		}
			</script>
<main>
	<div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="abmtipificacion.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>	
	<section id="Inicio">
		<div id="titulo">
			<h1>AGREGAR TIPIFICACIÓN</h1>
		</div>
		<div id="principalu">
			<form method="POST" action="./agregados.php">
				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE DE LA TIPIFICACIÓN:</label>
					<input id="tipificacion" style="text-transform:uppercase;" class="form-control col-form-label col-xl col-lg" type="text" name="tip" placeholder="NOMBRE DE TIPIFICACIÓN" required>
				</div>	
				<!-- Campo oculto para la acción -->
				<input type="hidden" id="accion" name="accion" value="agregarTipificacion">

				<div class="form-group row justify-content-end">
					<input class="btn btn-success" type="button" name="agregarTipificacion" style="width:20%" onclick="enviar_formulario(this.form, 'agregarTipificacion')" value="GUARDAR">
				</div>	
			</form>
					<?php

					//$tipi = "PRODUCTO NUEVO";

					//CORTAR ESPACIOS EN BLANCO:
					//$sinEspacios = preg_replace("/[[:space:]]/","",($tipi));
					//CALCULAR EL TAMAÑO
					//$tamaño = mb_strlen($sinEspacios);

					//ORDENAR ALFABÉTICAMENTE
					//$letras = (str_split($sinEspacios));
					//sort($letras, SORT_REGULAR);

					//var_dump($letras); NO DESCOMENTAR

					//$respuesta = implode($letras);
					//var_dump($respuesta); NO DESCOMENTAR
					
					//str_shuffle($tip); orden aleatorio
					//echo "Palabra sin espacios : ".$sinEspacios."<br>";
					//echo "Tamaño: ".$tamaño."<br>";
					//echo "Ordenado alfabeticamente: ".$respuesta;
					

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
	<script src="../js/confirmacionForm.js"></script>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>