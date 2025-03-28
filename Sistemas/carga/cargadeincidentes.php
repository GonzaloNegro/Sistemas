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
	<title>CARGA DE INCIDENTES</title>
	<meta charset="utf-8">
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
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<!--Estilo bootstrap para select2-->
	<link rel="stylesheet" href="/path/to/select2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="../estilos/estilocarga.css">
<!--  	<script>
		$(function (){
			$("#txtfechainicio").datepicker() ({
				dateformat: "yyyy-mm-dd"
			});
		});
	</script>
		<script>
		$(function (){
			$("#txtfechafin").datepicker() ({
				dateformat: "yyyy-mm-dd"
			});
		});
	</script> -->

		<script>
	$(document).ready(function(){
    $("#slctestado").change(function(){
        
		function limpiar(){
			$("#txtaDerivacion").val('');
			$("#txtfechafin").val('');
			$("#slctResoDer").val('');
		};

		if ($("#slctestado").val() == '3') {
			limpiar();
			$("#txtaDerivacion").show(1300);
		    $("#resoderi").show(1300);
		    $("#slctResoDer").show(1300);
			$("#txtfechafin").hide(1000);
			$("#lblfechaFin").hide(1000);
			
		}
		if ($("#slctestado").val() == '1' || $("#slctestado").val() == '2' || $("#slctestado").val() == '5') {
			limpiar();
			$("#txtaDerivacion").show(1300);
			$("#txtfechafin").show(1300);
			$("#lblfechaFin").show(1300);
		}

		
		if($("#slctestado").val() == '4'){
			limpiar();
			$("#txtaDerivacion").hide(1000);
		    $("#resoderi").hide(1000);
		    $("#slctResoDer").hide(1000);
			$("#txtfechafin").hide(1000);
			$("#lblfechaFin").hide(1000);
		}
    });
    });
</script>

	<style>
			body{
				background-color: #edf0f5;
			}
	</style>
</head>
<body>
	<script type="text/javascript">
			function done(){
				swal(  {title: "Se ha cargado su incidente correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='../consulta/consulta.php';
						}
						}
						);
			}	
			</script>
			<!-- <script>
				function alerta(campo) { 
				alert("Por favor, completa el campo "+campo) 
				}
					function validar_formulario(form){
						if (form.fecha_inicio.value == "") { 
							alerta('\"Fecha de Inicio\"'); form.fecha_inicio.focus(); return true; 
							}
						if (form.usuario.value == "") { 
							alerta('\"Usuario\"'); form.usuario.focus(); return true; }
						if (form.descripcion.value == "") { 
							alerta('\"Descripcion\"'); form.descripcion.focus(); return true; }
						if (form.prioridad.value == "") { 
							alerta('\"Prioridad\"'); form.prioridad.focus(); return true; }
						if (form.tipificacion.value == "") { 
							alerta('\"Tipificacion\"'); form.tipificacion.focus(); return true; }
						if (form.estado.value == "0") { 
							alerta('\"Estado\"'); form.estado.focus(); return true; }
						if (form.estado.value == "3" ) { 
							if (form.derivado.value =="0"){
								alert("Por favor, selecciona el resolutor derivado"); 
								form.derivado.focus(); 
								return true; }
								
								}
						if (form.estado.value == "1" || form.estado.value == "2"  || form.estado.value == "5") { 
							if (form.fecha_solucion.value ==""){
								alert("Por favor, ingresa la fecha de solucion"); 
								form.fecha_solucion.focus(); 
								return true; }
								 if (form.motivo.value ==""){
								 alert("Por favor, complete el campo de motivo"); 
								 form.motivo.focus(); 
								 return true; }
								
								}
								else if(form.estado.value == "3"){
									if (form.motivo.value ==""){
										alert("Por favor, complete el campo de motivo"); 
										form.motivo.focus(); 
										return true; }
								}
								
						
									form.submit()
						}
			</script> -->
			<script>
        function validar_formulario(){
			var resolutor = $('#slctResoDer').val();
			var estado = $('#slctestado').val();
        	var fechasolucion = $('#txtfechafin').val();
			var motivo = $('#txtaDerivacion').val();
			

        	var fieldsToValidate = [
                    {
                        selector: "#txtfechainicio",
                        errorMessage: "No ingresó fecha de inicio."
                    },
                    {
                        selector: "#buscador",
                        errorMessage: "No seleccionó usuario."
                    },
                    {
                        selector: "#prioridad",
                        errorMessage: "No seleccionó prioridad."
                    },
                    {
                        selector: "#tip",
                        errorMessage: "No seleccionó tipificación."
                    },
                    {
                        selector: "#descripcion",
                        errorMessage: "No ingresó Descripción."
                    },
                    {
                        selector: "#slctestado",
                        errorMessage: "No seleccionó estado."
                    }
                ];

                var isValid = true;
				// Se recorre todos los campos cuyos nombres estan en el array de arriba
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
				isValidEstado=true;
				//Validaciones de los campos que aparecen si se cambia de estado. 
				if(estado == "1" || estado == "2"  || estado == "5"){
					if (fechasolucion ==""){
								Swal.fire({
            						title: "Por favor seleccione la fecha de solución.",
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
									isValidEstado=false; }
					if (motivo ==""){
								Swal.fire({
            						title: "Por favor seleccione el motivo.",
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
									isValidEstado=false;}
				}
				if(estado == "3"){
									if(resolutor =="" ||resolutor ==null ){
										Swal.fire({
            							title: "Por favor seleccione el Resolutor Derivado",
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
										
										isValidEstado=false;}
									if (motivo ==""){
										Swal.fire({
            							title: "Por favor seleccione el motivo.",
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
									isValidEstado=false;}
									
									 }
							if (isValid ==true && isValidEstado==true) {
								
								return true;
							}
							else{
								return false;
							}
		};
		function validar_fechas(){
			//Obtenemos los valores de fecha de inicio y de solucion
			var fecha_ini=$('#txtfechainicio').val();
			var fecha_solucion=$('#txtfechafin').val();
			//Obtenemos el estado
			var estado=$('#slctestado').val();
			var isValid=true;
			
			//Se obtiene la fecha actual y el año
			var hoy = new Date();
            var fechaActual = hoy.toISOString().split("T")[0];
            var añoActual = hoy.getFullYear();
			var añoIngresado = new Date(fecha_ini).getFullYear();

			//Validacion de fecha igual o menor a la actual y que sea en el año actual
			if (fecha_ini > fechaActual || añoActual < añoIngresado) {
                    Swal.fire({
            			title: "La fecha de inicio debe ser hoy o una fecha anterior.",
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
			//Validar que el estado no sea En Proceso o Derivado para asi controlar la fecha de solucion. Si no es ninguno de estos ndos estados, se procede con los controles
			if (estado != 3 && estado != 4) {
				//Valida que la fecha sea mayor o igual a la fecha de inicio
				if (fecha_solucion<fecha_ini) {
					Swal.fire({
            			title: "La fecha de solucion debe ser mayor o igual a la fecha de inicio.",
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
				//Valida qe la fecha de solucion sea igual o menor a la fecha de hoy
				if (fecha_solucion>fechaActual) {
					Swal.fire({
            			title: "La fecha de solucion no debe superar a la fecha actual.",
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
			}
			
			if (isValid==true) {
				return true;
			}
			else{
				return false;
			}
		};
		function enviar_formulario(formulario){
			// var formulario = document.getElementById('formulario_carga');
        	if (validar_formulario() && validar_fechas()
			) {
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
<!--Select dinamico para actualizar el select de equipo a partir del usuario seleccionado-->
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
<?php include('../layout/incidente.php'); ?>
	<section id="Inicio" class="container-fluid">
		<div id="titulo" style="margin-top:20px; margin-bottom:20px;" data-aos="zoom-in">
			<h1>CARGA DE INCIDENTES</h1>
		</div>
		<div id="principal" class="container-fluid" data-aos="zoom-in">
						<form method="POST" name="formulario_carga" action="guardarincidente.php" enctype="multipart/form-data">
							<!--<label>NUMERO DE TICKET: <input type="text" name="numero_ticket" placeholder="NÚMERO DE TICKET" required></label>-->

							<div class="form-group row" style="margin: 10px; padding:10px;">
								<label class="col-form-label col-xl col-lg">FECHA INICIO:</label>
								<input type="date" class="form-control col-xl col-lg" name="fecha_inicio" id="txtfechainicio" required>
								<!-- <input class="form-control col-xl col-lg" type="text" name="fecha_inicio" id="txtfechainicio" required> -->
								<!--//////////////////////////////////////////////////////////////////-->
								<!--//////////////////////////////////////////////////////////////////-->
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
							
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							
  								<!--select equipo-->
								<div class="form-group row" style="margin: 10px; padding:10px;" id="select2lista">
								<label class='col-form-label col-xl col-lg'>EQUIPO DEL USUARIO:</label> 
			                    <select id='equipo' name='equipo' class='form-control col-xl col-lg' required></select>
								</div>
                                <!--////-->
								<div class="form-group row" style="margin: 10px; padding:10px;">
								<label class="col-form-label col-xl col-lg">PRIORIDAD: </label>
									<select name="prioridad" id="prioridad" class="form-control col-xl col-lg" required>
										<option value="" selected disabled="prioridad">-SELECCIONE UNA-</option>
										<?php
										include("../particular/conexion.php");
										$consulta= "SELECT * FROM prioridad ORDER BY PRIORIDAD ASC";
										$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
										?>
										<?php foreach ($ejecutar as $opciones): ?> 
										<option value="<?php echo $opciones['ID_PRIORIDAD']?>"><?php echo $opciones['PRIORIDAD']?></option>
										<?php endforeach ?>
									</select>
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
									

									<!--BUSCADOR-->
									<script>
									/* 		$('#tip').select2(); */
										</script>

										<script>
	/* 										$(document).ready(function(){
												$('#tip').change(function(){
													buscador='b='+$('#tip').val();
													$.ajax({
														type: 'post',
														url: 'Controladores/session.php',
														data: tip,
														success: function(r){
															$('#tabla').load('Componentes/Tabla.php');
														}
													})
												})
											}) */
										</script>


								<!--//////////////////////////////////////////////////////////////////-->
								<!--//////////////////////////////////////////////////////////////////-->
							</div>
														<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<div class="form-group row" style="margin: 10px; padding:10px;">
								<textarea name="descripcion" id="descripcion" style="margin-left: 40px; text-transform:uppercase;" class="form-control col" placeholder="DESCRIPCIÓN DEL INCIDENTE" rows="3" required></textarea>
							</div>
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<div class="form-group row" style="margin: 10px; padding:10px;">
								<label class="col-form-label col-xl" id="lblfechaFin" style="display:none;">FECHA SOLUCIÓN: </label>
								<input type="date" name="fecha_solucion" id="txtfechafin" style="display:none;"class="form-control col-xl derecha">
							<label class="col-form-label col-xl">ESTADO INCIDENTE: </label>
							<select id="slctestado" name="estado" required class="form-control col-xl derecha" >
								<option value='' selected disabled="estado">-SELECCIONE UNA-</option>
								<?php
								include("../particular/conexion.php");
								$consulta= "SELECT * FROM estado ORDER BY ESTADO ASC";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_ESTADO']?>"><?php echo $opciones['ESTADO']?></option>
								<?php endforeach ?>
							</select>
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<!-- <label class="col-form-label col-xl">ADJUNTAR ARCHIVOS: </label>
							<input type="file" name="imagen" class="form-control col-xl archivo" > -->
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<label class="col-form-label col-xl" id="resoderi" style="display: none;">RESOLUTOR DERIVADO: </label>
							<select name="derivado" id="slctResoDer" style="display: none;" class="form-control col-xl derecha">
								<option value="" selected disabled="derivado">-SELECCIONE UNA-</option>
								<?php
								include("../particular/conexion.php");
								$consulta= "SELECT * FROM resolutor ORDER BY RESOLUTOR ASC";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_RESOLUTOR']?>"><?php echo $opciones['RESOLUTOR']?></option>
								<?php endforeach ?>
							</select>
							
							</div>

							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<div class="row" style="margin: 10px; padding:10px;">
							<textarea name="motivo" style="margin-left: 40px; display: none; text-transform:uppercase;" id="txtaDerivacion" class="form-control col" placeholder="MOTIVO" rows="3"></textarea>
							</div>
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<div class="row justify-content-end" style="margin: 10px; padding:10px;">
							<!-- <input id="btnform" type="button" value="GUARDAR" onClick="validar_formulario(this.form)"  name="g1" class="col-2 button"> -->
							<?php 
								if ($row['ID_PERFIL'] != 5) {
								echo '<input id="btnform" type="button" value="GUARDAR" onClick="enviar_formulario(this.form)"  name="g1" class="col-2 button">';
								}
							?>
							
							</div>
							
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