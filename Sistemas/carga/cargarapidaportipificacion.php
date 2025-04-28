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
				// swal(  {title: "Se ha cargado su incidente correctamente",
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
                        title: "Incidente cargado correctamente.",
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

<script type="text/javascript">
	$(document).ready(function(){
		$('#buscador1').val(1);
		recargarLista1();

		$('#buscador1').change(function(){
			recargarLista1();
		});
	})
</script>
<script type="text/javascript">
	function recargarLista1(){
		$.ajax({
			type:"POST",
			url:"../particular/datos.php",
			data:"usuario=" + $('#buscador1').val(),
			success:function(r){
				$('#equipo').html(r);
			}
		});
	}
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#buscador2').val(1);
		recargarLista2();

		$('#buscador2').change(function(){
			recargarLista2();
		});
	})
</script>
<script type="text/javascript">
	function recargarLista2(){
		$.ajax({
			type:"POST",
			url:"../particular/datos.php",
			data:"usuario=" + $('#buscador2').val(),
			success:function(r){
				$('#equipo2').html(r);
			}
		});
	}
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#buscador3').val(1);
		recargarLista3();

		$('#buscador3').change(function(){
			recargarLista3();
		});
	})
</script>
<script type="text/javascript">
	function recargarLista3(){
		$.ajax({
			type:"POST",
			url:"../particular/datos.php",
			data:"usuario=" + $('#buscador3').val(),
			success:function(r){
				$('#equipo3').html(r);
			}
		});
	}
</script>
<script>
        function validar_formulario(){

			var fieldsToValidate = [
                    {
                        selector: "#txtfecha",
                        errorMessage: "No ingresó fecha."
                    },
                    {
                        selector: "#tip",
                        errorMessage: "No seleccionó tipificación."
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
		//Validamos qen el caso que se cargue un incidente este tenga usuario seleccionado y descripcion redactada
		function validar_incidentes(){
			var isValid=true;
			var tieneIncidentes=true;
			var nombreIncidente=""; 

			//obtenemos el valor de los usuarios
			var user1=$('#buscador1').val();
			var user2=$('#buscador2').val();
			var user3=$('#buscador3').val();
			//obtenemos el valor de las descripciones
			var descrip1=$('#descripcion1').val();
			var descrip2=$('#descripcion2').val();
			var descrip3=$('#descripcion3').val();

			//En el caso que ambos esten vacios o llenos (user y descripcion) los campos de cada incidente devuelve true y permite el envio del formulario
			//En el caso en que ambos sean distintos (uno vacio y otro no) envía false y no permite el envío hasta solucionar

			//Para validar el caso que ambos sean distintos, se usa Validacion con compuerta XOR 
			
			//Validacion para detectar si algun incidente se cargo
			if (user1==null && user2==null && user3==null && descrip1=="" && descrip2=="" && descrip3=="") {
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
			}
			else{
				//Incidente 1
			if ((user1==null || descrip1=="") && !(user1==null && descrip1=="")) {
				isValid=false;
				nombreIncidente="Incidente 1";
			}
			
			if ((user2==null || descrip2=="") && !(user2==null && descrip2=="")) {
				isValid=false;
				nombreIncidente="Incidente 2";
			 }
			
			if ((user3==null || descrip3=="") && !(user3==null && descrip3=="")) {
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
			// else{
			// 	alert("FAlla");
			// }
		}

		</script>

<?php include('../layout/incidente.php'); ?>
	<section id="Inicio" class="container-fluid">
		<div id="titulo" style="margin-top:20px; margin-bottom:20px;" data-aos="zoom-in">
			<h1>CARGA RÁPIDA POR TIPIFICACIÓN</h1>
		</div>
		<div id="principal" class="container-fluid" data-aos="zoom-in">
			<form method="POST" name="formulario_carga" action="guardarcargarapidatip.php" enctype="multipart/form-data">

			<div class="form-group row">
				<label class="col-form-label col-xl col-lg">FECHA:</label>
				<input type="date" class="form-control col-xl col-lg" name="fechaini" id="txtfecha" required>
				<!-- <input class="form-control col-xl col-lg" type="text" name="fecha_inicio" id="txtfechainicio" required> -->
				<!--//////////////////////////////////////////////////////////////////-->
				<!--//////////////////////////////////////////////////////////////////-->
			</div>
			<div class="form-group row">
				<label class="col-form-label col-xl">TIPIFICACIÓN: </label>
					<select name="tipificacion" id="tip" class="form-control col-xl" required>
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

			<div class="form-group row">
				<div class="accordion accordion-flush" id="accordionFlushExample">
				<div class="accordion-item">
					<h2 class="accordion-header" id="flush-headingOne">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
					INCIDENTE N°1:
					</button>
					</h2>
					<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
					<div class="accordion-body">
						<div class="form-group row">
							<label class='col-form-label col-xl col-lg'>USUARIO:</label>
							<!---->
							<select name="usuario1" id="buscador1" class='form-control col-xl col-lg' style="width:100px !important;">
								<option value="" selected disabled="usuario">-SELECCIONE UNA-</option>
								<?php
								include("../particular/conexion.php");
								$consulta= "SELECT * FROM usuarios WHERE ID_ESTADOUSUARIO = 1 AND ID_USUARIO <> 277 ORDER BY NOMBRE ASC";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?>
									<option value="<?php echo $opciones['ID_USUARIO']?>"><?php echo $opciones['NOMBRE']?></option>
								<?php endforeach ?>

								</select>
								<!--BUSCADOR-->
								<script>
								$('#buscador1').select2();
								</script>
								<script>
								$(document).ready(function(){
									$('#buscador1').change(function(){
										buscador1='b='+$('#buscador1').val();
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
					</div>
					<div class="form-group row">
						<label class='col-form-label col-xl col-lg'>EQUIPO DEL USUARIO:</label>
						<select id='equipo' name='equipo' class='form-control col-xl col-lg'></select>
					</div>
						<div class="form-group row">
							<label class="col-form-label col-xl">DESCRIPCIÓN: </label>
							<textarea id="descripcion1" name="descripcion1" style="text-transform:uppercase;" class="form-control col" placeholder="DESCRIPCIÓN DEL INCIDENTE N°1" rows="3" ></textarea>
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
		<div class="accordion-body">
			<div class="form-group row">
            <label class="col-form-label col-xl col-lg">USUARIO:</label>
								<select name="usuario2" id="buscador2" class="form-control col-xl col-lg">
								<option value="" selected disabled="usuario">-SELECCIONE UNA-</option>
								<?php
								include("../particular/conexion.php");
								$consulta= "SELECT * FROM usuarios WHERE ID_ESTADOUSUARIO = 1 AND ID_USUARIO <> 277 ORDER BY NOMBRE ASC";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?>
									<option value="<?php echo $opciones['ID_USUARIO']?>"><?php echo $opciones['NOMBRE']?></option>
								<?php endforeach ?>

								</select>
									<!--BUSCADOR-->
									<script>
										$('#buscador2').select2();
									</script>
									<script>
										$(document).ready(function(){
											$('#buscador2').change(function(){
												buscador2='b='+$('#buscador2').val();
												$.ajax({
													type: 'post',
													url: 'Controladores/session.php',
													data: buscador2,
													success: function(r){
														$('#tabla').load('Componentes/Tabla.php');
													}
												})
											})
										})
									</script>
			</div>
			<div class="form-group row">
				<label class='col-form-label col-xl col-lg'>EQUIPO DEL USUARIO:</label>
				<select id='equipo2' name='equipo2' class='form-control col-xl col-lg'></select>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-xl">DESCRIPCIÓN: </label>
				<textarea name="descripcion2" id="descripcion2" style="text-transform:uppercase;" class="form-control col" placeholder="DESCRIPCIÓN DEL INCIDENTE N°2" rows="3" ></textarea>
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
            <div class="accordion-body">
                <div class="form-group row">
                    <label class="col-form-label col-xl col-lg">USUARIO:</label>
                    <select name="usuario3" id="buscador3" class="form-control col-xl col-lg">
                    <option value="" selected disabled="usuario">-SELECCIONE UNA-</option>
                    <?php
                    include("../particular/conexion.php");
					$consulta= "SELECT * FROM usuarios WHERE ID_ESTADOUSUARIO = 1 AND ID_USUARIO <> 277 ORDER BY NOMBRE ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));?>
                    <?php foreach ($ejecutar as $opciones): ?>
                    <option value="<?php echo $opciones['ID_USUARIO']?>"><?php echo $opciones['NOMBRE']?></option>
                    <?php endforeach ?>
                    </select>
                    <!--BUSCADOR-->
                    <script>
                        $('#buscador3').select2();
                    </script>
                    <script>
                        $(document).ready(function(){
                            $('#buscador3').change(function(){
                                    buscador2='b='+$('#buscador3').val();
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
				</div>
                <div class="form-group row">
					<label class='col-form-label col-xl col-lg'>EQUIPO DEL USUARIO:</label>
					<select id='equipo3' name='equipo3' class='form-control col-xl col-lg'></select>
				</div>
                <div class="form-group row">
					<label class="col-form-label col-xl">DESCRIPCIÓN: </label>
                    <textarea id="descripcion3" name="descripcion3" style="text-transform:uppercase;" class="form-control col" placeholder="DESCRIPCIÓN DEL INCIDENTE N°3" rows="3"></textarea>
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
			echo ' <div class="row justify-content-end" style="margin: 10px; padding:10px;">
					<input id="btnform" type="button" onClick="enviar_formulario(this.form)" value="GUARDAR" onClick="validar_formulario(this.form)"  name="g1" class="btn btn-success">
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