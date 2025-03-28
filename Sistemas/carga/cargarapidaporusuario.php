<?php 
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>CARGA RÁPIDA</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="../jquery/1/jquery-ui.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<!--BUSCADOR SELECT-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<!--FIN BUSCADOR SELECT-->
	<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<!--Estilo bootstrap para select2-->
	<link rel="stylesheet" href="/path/to/select2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="../estilos/estilocarga.css">
	<style>
			body{
				background-color: #edf0f5;
			}
	</style>
</head>
<body>
	<script type="text/javascript">
			function done(){
				// swal(  {title: "Se han cargado sus incidentes correctamente",
				// 		icon: "success",
				// 		showConfirmButton: true,
				// 		showCancelButton: false,
				// 		})
				// 		.then((confirmar) => {
				// 		if (confirmar) {
				// 			window.location.href='../consulta/consulta.php';
				// 		}
				// 		}
				// 		);
				Swal.fire({
                        title: "Se han cargado sus incidentes correctamente.",
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
                            window.location.href='../consulta/consulta.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
<!--Select dinamico-->
<script type="text/javascript">
	$(document).ready(function(){
		$('#buscador').val(1);
		recargarLista();

		$('#buscador').change(function(){
			recargarLista();
		});
	})
</script>
<script type="text/javascript">
	function recargarLista(){
		$.ajax({
			type:"POST",
			url:"../particular/datos.php",
			data:"usuario=" + $('#buscador').val(),
			success:function(r){
				$('#equipo').html(r);
			}
		});
	}
</script>
<script>
        function validar_formulario(){
			
			var fieldsToValidate = [
                    {
                        selector: "#txtfecha",
                        errorMessage: "No ingresó Fecha."
                    },
                    {
                        selector: "#buscador",
                        errorMessage: "No seleccionó usuario."
                    },
                    {
                        selector: "#equipo",
                        errorMessage: "No seleccionó equipo."
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
		function validar_fecha(){
			var isValid=true;
			//Obtenemos los valores de fecha de inicio y de solucion
			var fecha=$('#txtfecha').val();
			//Se obtiene la fecha actual y el año
			var hoy = new Date();
            var fechaActual = hoy.toISOString().split("T")[0];
            var añoActual = hoy.getFullYear();
			var añoIngresado = new Date(fecha).getFullYear();

			//Validacion de fecha igual o menor a la actual y que sea en el año actual
			if (fecha > fechaActual || añoActual<añoIngresado) {
                    Swal.fire({
            			title: "La fecha debe ser hoy o una fecha anterior.",
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
					var isValid=false;
                }
			if (isValid==true) {
				return true;
			}
			else{
				return false;
			}
		};
		//Validamos qen el caso que se cargue un incidente este tenga tipificacion seleccionada y descripcion redactada
		function validar_incidentes(){
			var isValid=true;
			var nombreIncidente=""; 

			//obtenemos el valor de los usuarios
			var tip1=$('#tipificacion1').val();
			var tip2=$('#tipificacion2').val();
			var tip3=$('#tipificacion3').val();
			//obtenemos el valor de las descripciones
			var descrip1=$('#descripcion1').val();
			var descrip2=$('#descripcion2').val();
			var descrip3=$('#descripcion3').val();

			//En el caso que ambos esten vacios o llenos (user y descripcion) los campos de cada incidente devuelve true y permite el envio del formulario
			//En el caso en que ambos sean distintos (uno vacio y otro no) envía false y no permite el envío hasta solucionar

			//Para validar el caso que ambos sean distintos, se usa Validacion con compuerta XOR 
			
			//Validacion para detectar si algun incidente se cargo
			if (tip1==null && tip2==null && tip3==null && descrip1=="" && descrip2=="" && descrip3=="") {
				Swal.fire({
                      title: "No hay incidentes cargados",
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
					  isValid=false;
			} else {
				//Incidente 1
			if ((tip1==null || descrip1=="") && !(tip1==null && descrip1=="")) {
				isValid=false;
				nombreIncidente="Incidente 1";
			}
			
			if ((tip2==null || descrip2=="") && !(tip2==null && descrip2=="")) {
				isValid=false;
				nombreIncidente="Incidente 2";
			 }
			
			if ((tip3==null || descrip3=="") && !(tip3==null && descrip3=="")) {
				isValid=false;
				nombreIncidente="Incidente 3";
			}

			//MEnsaje de alerta

			Swal.fire({
                      title: "Hay campos vacios en "+nombreIncidente,
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

			}

			
			

			if (isValid==true) {
				return true;
			}
			else{
				return false;
			}


		}
		function enviar_formulario(formulario){
        	if (validar_formulario() && validar_incidentes() && validar_fecha()) {
				// alert("Todo OK");
				Swal.fire({
                        title: "Esta seguro de guardar este incidente?",
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
<?php include('../layout/incidente.php'); ?>
	<section id="Inicio" class="container-fluid">
		<div id="titulo" style="margin-top:20px; margin-bottom:20px;" data-aos="zoom-in">
			<h1>CARGA RÁPIDA POR USUARIO</h1>
		</div>
		<div id="principal" class="container-fluid" data-aos="zoom-in">
			<form method="POST" action="guardarcargarapidausu.php">

					<div class="form-group row" style="margin: 10px; padding:10px;">
						<label class="col-form-label col-xl col-lg">FECHA:</label>
						<input type="date" class="form-control col-xl col-lg" name="fechaini" id="txtfecha" required>
						<label class="col-form-label col-xl col-lg">USUARIO:</label>
						<select name="usuario" id="buscador" required class="form-control col-xl col-lg extend">
						<option value="" selected disabled="usuario">-SELECCIONE UNA-</option>
						<?php
						include("../particular/conexion.php");
						$consulta= "SELECT * FROM usuarios WHERE ACTIVO LIKE 'ACTIVO' AND ID_USUARIO <> 277 ORDER BY NOMBRE ASC";
						$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
						?>
						<?php foreach ($ejecutar as $opciones): ?> 
							<option value="<?php echo $opciones['ID_USUARIO']?>"><?php echo $opciones['NOMBRE']?></option>
						<?php endforeach ?>

						</select>
						<!--BUSCADOR-->
						<!--Agregar {theme: 'bootstrap4',} dentro de select-->
						<script>
							$('#buscador').select2({theme: 'bootstrap4',});
						</script>
						<script>
							$(document).ready(function(){
								$('#buscador').change(function(){
									buscador='b='+$('#buscador').val();
									$.ajax({
										type: 'post',
										url: 'Controladores/session.php',
										data: buscador,
										success: function(r){
											$('#tabla').load('Componentes/Tabla.php');
										}
									})
								})
							})
						</script>
						<!--//////////////////////////////////////////////////////////////////-->
						<!--//////////////////////////////////////////////////////////////////-->
		            </div>
  					<!--select equipo-->
						<div class="form-group row" style="margin: 10px; padding:10px;" id="select2lista">
						<label class='col-form-label col-xl col-lg'>EQUIPO DEL USUARIO:</label> 
			            <select id='equipo' name='equipo' class='form-control col-xl col-lg' required></select></div>
                    <!--////-->	

				<div class="form-group row" style="margin: 10px; padding:10px;">
					<div class="accordion accordion-flush" id="accordionFlushExample">
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-headingOne">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
							INCIDENTE N°1:
							</button>
							</h2>
							<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
							<div class="accordion-body">
								<div class="form-group row" style="margin: 10px; padding:10px;">
									<label class="col-form-label col-xl">TIPIFICACIÓN: </label>
										<select name="tipificacion1" id="tipificacion1" class="form-control col-xl">
										<option value="" selected disabled="tipificacion">-SELECCIONE UNA-</option>
										<?php
										include("../particular/conexion.php");
										$consulta= "SELECT * FROM tipificacion WHERE ID_TIPIFICACION >= 20 ORDER BY TIPIFICACION ASC";
										$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
										?>
										<?php foreach ($ejecutar as $opciones): ?> 
										<option value="<?php echo $opciones['ID_TIPIFICACION']?>"><?php echo $opciones['TIPIFICACION']?></option>
										<?php endforeach ?>
										</select>
								</div>
								<div class="form-group row" style="margin: 10px; padding:10px;">
									<textarea id="descripcion1" name="descripcion1" style="margin-left: 40px; text-transform:uppercase;" class="form-control col" placeholder="DESCRIPCIÓN DEL INCIDENTE" rows="3"></textarea>
								</div>
							</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-headingTwo">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
							INCIDENTE N°2:
							</button>
							</h2>
							<div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
							<div class="accordion-body">
								<div class="form-group row" style="margin: 10px; padding:10px;">
									<label class="col-form-label col-xl">TIPIFICACIÓN: </label>
										<select name="tipificacion2" id="tipificacion2" class="form-control col-xl">
										<option value="" selected disabled="tipificacion">-SELECCIONE UNA-</option>
										<?php
										include("../particular/conexion.php");
										$consulta= "SELECT * FROM tipificacion WHERE ID_TIPIFICACION >= 20 ORDER BY TIPIFICACION ASC";
										$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
										?>
										<?php foreach ($ejecutar as $opciones): ?> 
										<option value="<?php echo $opciones['ID_TIPIFICACION']?>"><?php echo $opciones['TIPIFICACION']?></option>
										<?php endforeach ?>
										</select>

								</div>
								<div class="form-group row" style="margin: 10px; padding:10px;">
									<textarea id="descripcion2" name="descripcion2" style="margin-left: 40px; text-transform:uppercase;" class="form-control col" placeholder="DESCRIPCIÓN DEL INCIDENTE" rows="3"></textarea>
								</div>
							</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-headingThree">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
							INCIDENTE N°3:
							</button>
							</h2>
							<div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
							<div class="accordion-body">
								<div class="form-group row" style="margin: 10px; padding:10px;">
									<label class="col-form-label col-xl">TIPIFICACIÓN: </label>
										<select name="tipificacion3" id="tipificacion3" class="form-control col-xl">
										<option value="" selected disabled="tipificacion">-SELECCIONE UNA-</option>
										<?php
										include("../particular/conexion.php");
										$consulta= "SELECT * FROM tipificacion WHERE ID_TIPIFICACION >= 20 ORDER BY TIPIFICACION ASC";
										$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
										?>
										<?php foreach ($ejecutar as $opciones): ?> 
										<option value="<?php echo $opciones['ID_TIPIFICACION']?>"><?php echo $opciones['TIPIFICACION']?></option>
										<?php endforeach ?>
										</select>
								</div>
								<div class="form-group row" style="margin: 10px; padding:10px;">
									<textarea id="descripcion3" name="descripcion3" style="margin-left: 40px; text-transform:uppercase;" class="form-control col" placeholder="DESCRIPCIÓN DEL INCIDENTE" rows="3"></textarea>
								</div>
							</div>
							</div>
						</div>
					</div>
				</div>	

				<!--//////////////////////////////////////////////////////////////////-->
				<!--//////////////////////////////////////////////////////////////////-->
				<?php 
								if ($row['ID_PERFIL'] != 5) {
								echo '<div class="row justify-content-end" style="margin: 10px; padding:10px;">
								<input id="btnform" onClick="enviar_formulario(this.form)" type="button" value="GUARDAR" name="g1" class="col-2 button">
							</div>';
								}
							?>
				
							
			</form>		
			<?php
			if(isset($_GET['ok'])){
				/*echo "<h3>Incidente cargado</h3>";*/?>
				<script>done();</script>
				<?php			
			}
			?>
		</div>
	</section>
	<footer>
		<div class="footer">
			<div class="container-fluid">
				<div class="row">
					<img src="../imagenes/cba-logo.png" class="img-fluid">
				</div>
			</div>
		</div>
	</footer>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
  		AOS.init();
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
		const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
		const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
	</script>
	
</body>
</html>