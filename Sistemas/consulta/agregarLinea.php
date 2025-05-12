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
	<title>AGREGAR LINEA</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">

</head>
<body>
<script type="text/javascript">
			function ok(){
				// swal(  {title: "Linea cargada correctamente",
				// 		icon: "success",
				// 		showConfirmButton: true,
				// 		showCancelButton: false,
				// 		})
				// 		.then((confirmar) => {
				// 		if (confirmar) {
				// 			window.location.href='./montosLineas.php';
				// 		}
				// 		}
				// 		);
				Swal.fire({
                        title: "Línea cargada correctamente.",
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
                            window.location.href='./montosLineas.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
<script type="text/javascript">
			function no(){
				// swal(  {title: "La linea ya esta registrada",
				// 		icon: "error",
				// 		})
				// 		.then((confirmar) => {
				// 		if (confirmar) {
				// 			window.location.href='./montosLineas.php';
				// 		}
				// 		}
				// 		);
				Swal.fire({
                        title: "La Línea ya está registrada",
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
                            window.location.href='./montosLineas.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
				<script>
					$(document).ready(function () {
					$('input#cardnumber')
						.keypress(function (event) {
						if (event.which < 48 || event.which > 57 || this.value.length > 9) {
							return false;
						}
						});
					});
				</script>
<main>
	<div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="./montosLineas.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
		<div id="titulo">
			<h1>AGREGAR LINEA</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
			<form method="POST" action="agregados.php">

				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">NÚMERO:</label>
					<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="number" name="text" id="cardnumber" placeholder="NÚMERO" required>
				</div>

				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">USUARIO:</label>
					<select name="usuario" id="usuario" style="text-transform:uppercase" onchange="cargarLineas()" class="form-control col-xl col-lg" required>
					<option selected disabled="">-SELECCIONE UNA-</option>
					<?php
					include("../particular/conexion.php");
					$consulta= "SELECT * FROM usuarios WHERE ID_ESTADOUSUARIO = 1 ORDER BY NOMBRE ASC";
					$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
					?>
					<?php foreach ($ejecutar as $opciones): ?> 
					<option value="<?php echo $opciones['ID_USUARIO']?>"><?php echo $opciones['NOMBRE']?></option>
					<?php endforeach ?>
					</select>
				</div>

				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:</label>
					<select id="estado" name="estado" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
					<option selected disabled="">-SELECCIONE UNA-</option>
					<?php
					include("../particular/conexion.php");
					$consulta= "SELECT * FROM estado_ws ORDER BY ESTADO ASC";
					$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
					?>
					<?php foreach ($ejecutar as $opciones): ?> 
					<option value="<?php echo $opciones['ID_ESTADOWS']?>"><?php echo $opciones['ESTADO']?></option>
					<?php endforeach ?>
					</select>
				</div>

				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">CELULAR:</label>
					<select name="celular" id="celulares" style="text-transform:uppercase" class="form-control col-xl col-lg" required><option value="" selected disabled>- SELECCIONE UNA OPCIÓN -</option></select>
				</div>

				<!--<div class="form-group row" style="margin: 10px; padding:10px;">
					 <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:</label>
					<select name="estado" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
					<option selected disabled="">-SELECCIONE UNA-</option>
					<?php
					include("../particular/conexion.php");
					$consulta= "SELECT * FROM estado_ws ORDER BY ESTADO ASC";
					$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
					?>
					<?php foreach ($ejecutar as $opciones): ?> 
						<option value="<?php echo $opciones['ID_ESTADOWS']?>"><?php echo $opciones['ESTADO']?></option>
					<?php endforeach ?>
					</select> -->

					<!-- <label id="lblForm"class="col-form-label col-xl col-lg">PLAN:</label>
					<select name="plan" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
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
				</div>-->
				
				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">DESCUENTO:</label>
					<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="number" name="descuento" id="descuento" step="0.01" placeholder="10,00" required>
				</div>

				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">FECHA DESCUENTO:</label>
					<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="date" name="fecha" id="fecha" required>
				</div>

				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE PLAN:</label>
					<select id="nombrePlan" name="nombrePlan" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
					<option selected disabled="">-SELECCIONE UNA-</option>
					<?php
					include("../particular/conexion.php");
					$consulta= "SELECT n.NOMBREPLAN, p.PLAN, n.ID_NOMBREPLAN, pr.PROVEEDOR
					FROM nombreplan n
					INNER JOIN plan p ON p.ID_PLAN = n.ID_PLAN
					inner join proveedor pr on n.ID_PROVEEDOR=pr.ID_PROVEEDOR
					ORDER BY n.nombreplan";
					$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
					?>
					<?php foreach ($ejecutar as $opciones): ?> 
					<option value="<?php echo $opciones['ID_NOMBREPLAN']?>"><?php echo $opciones['NOMBREPLAN'].' - '.$opciones['PLAN'].' - '.$opciones['PROVEEDOR']?></option>
					<?php endforeach ?>
					</select>
				</div>

				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">ROAMING:</label>
					<select name="roaming" id="roaming" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
					<option selected disabled="">-SELECCIONE UNA-</option>
					<?php
					include("../particular/conexion.php");
					$consulta= "SELECT * FROM roaming ORDER BY ROAMING ASC";
					$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
					?>
					<?php foreach ($ejecutar as $opciones): ?> 
					<option value="<?php echo $opciones['ID_ROAMING']?>"><?php echo $opciones['ROAMING']?></option>
					<?php endforeach ?>
					</select>
				</div>  
				
				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">EXTRAS:</label>
					<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="number" name="extras" id="extras" step="0.01" placeholder="0,00" required>
				</div>

				<div class="form-group row">
					<label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓN:</label> 
					<textarea class="form-control col-xl col-lg" name="obs" placeholder="OBSERVACIÓN" style="text-transform:uppercase" rows="3" ></textarea>
				</div> 
				<?php 
					if ($row['ID_PERFIL'] != 5) {
					echo '<div class="form-group row justify-content-end">
					<input style="width:20%" onClick="enviar_formulario(this.form)" class="btn btn-success" type="button" name="agregarLinea" value="GUARDAR" class="button">
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
	<script>
/* 	$(document).ready(function(){
    $("#usuario").change(function(){
		$("#checkCelular").prop('checked', false);
		$("#celularesusuario").hide(0);
        $("#divCelulares").show(1300);
    });

	$("#checkCelular").change(function(){
        $("#celularesusuario").show(1300);
    });
    }); */
	function cargarLineas() {
        var usuario = document.getElementById("usuario").value;
		// alert(usuario)
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "obtener_celulares.php?usuario=" + usuario, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("celulares").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }
</script>
<script>
        function validar_formulario(){
			
			var fieldsToValidate = [
                    {
                        selector: "#cardnumber",
                        errorMessage: "No ingresó el nro. de línea."
                    },
                    {
                        selector: "#usuario",
                        errorMessage: "No seleccionó usuario."
                    },
                    {
                        selector: "#estado",
                        errorMessage: "No seleccionó estado."
                    },
                    {
                        selector: "#descuento",
                        errorMessage: "No ingresó el descuento."
                    },
                    {
                        selector: "#fecha",
                        errorMessage: "No ingresó fecha de descuento."
                    },
                    {
                        selector: "#nombrePlan",
                        errorMessage: "No seleccionó plan."
                    },
                    {
                        selector: "#roaming",
                        errorMessage: "No seleccionó estado de roaming."
                    },
                    {
                        selector: "#extras",
                        errorMessage: "No ingresó los extras. Si no tiene, ingresar el valor 0."
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
                        title: "Esta seguro de guardar esta línea?",
                        icon: "warning",
                        showConfirmButton: true,
                        showCancelButton: true,
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
                            formulario.submit()


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}
		}
				
		</script>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>