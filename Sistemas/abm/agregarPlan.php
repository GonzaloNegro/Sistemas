<?php 
session_start();
error_reporting(0);
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
	<title>AGREGAR PLAN</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
                        title: "Plan cargado correctamente.",
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
                            window.location.href='abmcelulares.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
<script type="text/javascript">
			function no(){
				Swal.fire({
                        title: "El plan ya está registrado",
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
                            window.location.href='abmcelulares.php';


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
                        selector: "#nombrePlan",
                        errorMessage: "No ingresó nombre del plan."
                    },
                    {
                        selector: "#proveedor",
                        errorMessage: "No seleccionó proveedor."
                    },
                    {
                        selector: "#plan",
                        errorMessage: "No seleccionó plan."
                    },
                    {
                        selector: "#monto",
                        errorMessage: "No ingresó monto."
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
		function enviar_formulario(formulario, accion) {
			// Asigna el valor de la acción al campo oculto "accion"
			formulario.querySelector('#accion').value = accion;
			if (validar_formulario()) {
				const campos = [
					{ id: 'nombrePlan', label: 'Nombre del Plan' },
					{ id: 'proveedor', label: 'Proveedor', esSelect: true },
					{ id: 'plan', label: 'Plan', esSelect: true },
					{ id: 'monto', label: 'Monto' }
				];

				confirmarEnvioFormulario(
					formulario,
					campos,
					"Datos del Plan",
					"¿Está seguro de guardar este Plan?"
				);
			}
		}	
		</script>
<main>
	<div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="abmPlanesCelulares.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
		<div id="titulo">
			<h1>AGREGAR PLAN</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
			<form method="POST" action="./agregados.php">

				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE:<span style="color:red;">*</span></label>
					<input id="nombrePlan" style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="nombrePlan" placeholder="NOMBRE PLAN" required>
                </div>

                <div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR:<span style="color:red;">*</span></label>
						<select id="proveedor" name="proveedor" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
						<option selected disabled="">-SELECCIONE UNA-</option>
						<?php
						include("../particular/conexion.php");
						$consulta= "SELECT * FROM proveedor WHERE ID_PROVEEDOR IN (34, 35) ORDER BY PROVEEDOR ASC;
						";
						$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
						?>
						<?php foreach ($ejecutar as $opciones): ?> 
							<option value="<?php echo $opciones['ID_PROVEEDOR']?>"><?php echo $opciones['PROVEEDOR']?></option>
						<?php endforeach ?>
						</select>
				</div>
				
                <div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">PLAN:<span style="color:red;">*</span></label>
						<select id="plan" name="plan" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
						<option selected disabled="">-SELECCIONE UNA-</option>
						<?php
						include("../particular/conexion.php");
						$consulta= "SELECT * FROM plan";
						$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
						?>
						<?php foreach ($ejecutar as $opciones): ?> 
							<option value="<?php echo $opciones['ID_PLAN']?>"><?php echo $opciones['PLAN']?></option>
						<?php endforeach ?>
						</select>
                </div>

                <div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">MONTO SIN DESCUENTO:<span style="color:red;">*</span></label>
					<input id="monto" style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="number" name="monto" step="0.01" placeholder="10,00" required>
				</div>
				<!-- Campo oculto para la acción -->
				<input type="hidden" id="accion" name="accion" value="agregarPlan">
                <?php 
                    if ($row['ID_PERFIL'] != 5) {
                        echo '<div class="form-group row justify-content-end">
                            <input onclick="enviar_formulario(this.form, \'agregarPlan\')" style="width:20%"class="btn btn-success" name="agregarPlan" type="button" value="GUARDAR" class="button">
                        </div>	';
                    }
                ?>
				
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