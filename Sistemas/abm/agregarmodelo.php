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
	<title>AGREGAR MODELO</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

				Swal.fire({
                        title: "Modelo cargado correctamente.",
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
                            window.location.href='abmmodelos.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
<script type="text/javascript">
			function repeat(){
				Swal.fire({
                        title: "Modelo cargado correctamente. Verifique el nombre del modelo, ya que existe este nombre registrado previamente!",
                        icon: "info",
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
                            window.location.href='abmmodelos.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
<script type="text/javascript">
			function no(){
				Swal.fire({
                        title: "El modelo ya está registrado",
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
                            window.location.href='agregarmodelo.php';


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
                        selector: "#modelo",
                        errorMessage: "No ingresó nombre del modelo."
                    },
                    {
                        selector: "#marca",
                        errorMessage: "No seleccionó marca."
                    },
                    {
                        selector: "#tipo",
                        errorMessage: "No seleccionó tipo."
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
		function enviar_formulario(formulario, accion){
			// Asigna el valor de la acción al campo oculto "accion"
			formulario.querySelector('#accion').value = accion;
			if (validar_formulario()) {
				const campos = [
					{ id: 'modelo', label: 'Nombre del modelo' },
					{ id: 'marca', label: 'Marca', esSelect: true },
					{ id: 'tipo', label: 'Tipo de periférico', esSelect: true }
				];

				confirmarEnvioFormulario(
					formulario,
					campos,
					"Datos del modelo",
					"¿Está seguro de guardar este modelo?"
				);
			}
		}	
		</script>
<main>
	<div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="abmmodelos.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
        <section id="Inicio">
		<div id="titulo">
			<h1>AGREGAR MODELO</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
                <form method="POST" action="./agregados.php">
                        <div class="form-group row">
							<label id="lblForm" class="col-form-label col-xl col-lg">MODELO:<span style="color:red;">*</span></label>
                            <input id="modelo" class="form-control col-xl col-lg" style=text-transform:uppercase; type="text" name="modelo" placeholder="NOMBRE DEL MODELO" required>
                        </div>

                        <div class="form-group row">
							<label id="lblForm"class="col-form-label col-xl col-lg">MARCA:<span style="color:red;">*</span></label>
                            <select id="marca" name="marca" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
							<option selected disabled="area">-SELECCIONE UNA-</option>
							<?php
							include("../particular/conexion.php");
							$consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
							$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
							?>
							<?php foreach ($ejecutar as $opciones): ?> 
								<option value="<?php echo $opciones['ID_MARCA']?>"><?php echo $opciones['MARCA']?></option>						
							<?php endforeach ?>
							</select>
                        </div>

                        <div class="form-group row">
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO:<span style="color:red;">*</span></label>
							<select id="tipo" name="tipo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
							<option selected disabled>-SELECCIONE UNA-</option>
							<?php
							include("../particular/conexion.php");
							$consulta= "SELECT * FROM tipop ORDER BY TIPO ASC";
							$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
							?>
							<?php foreach ($ejecutar as $opciones): ?> 
							<option value="<?php echo $opciones['ID_TIPOP']?>"><?php echo $opciones['TIPO']?></option>						
							<?php endforeach ?>
							</select>
                        </div>
                        <!-- Campo oculto para la acción -->
                        <input type="hidden" id="accion" name="accion" value="agregarModelo">
                        <div class="row justify-content-end">
                            <input onclick="enviar_formulario(this.form, 'agregarModelo')" style="width: 20%;" class="btn btn-success" type="button" name="agregarModelo" value="GUARDAR" >
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
    <script src="../js/confirmacionForm.js"></script>
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>