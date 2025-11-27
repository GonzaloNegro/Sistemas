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
	<title>AGREGAR CELULAR</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
    <!--BUSCADOR SELECT-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<!--FIN BUSCADOR SELECT-->
    <!--Estilo bootstrap para select2-->
	<link rel="stylesheet" href="/path/to/select2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
			function ok(){
				swal(  {title: "Celular cargado correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='./celulares.php';
						}
						}
						);
			}
			</script>
<script type="text/javascript">
			function no(){
				swal(  {title: "El celular ya está registrado",
						icon: "error",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='./celulares.php';
						}
						}
						);
			}
			</script>
<main>
	<div id="reporteEst">
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="./celulares.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
    </div>
	<section id="Inicio">
		<div id="titulo">
			<h1>AGREGAR CELULAR</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
						<form method="POST" action="agregados.php">
						<div class="form-group row">
							<label id="lblForm"class="col-form-label col-xl col-lg">IMEI:<span style="color:red;">*</span></label>
							<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="imei" id="imei" placeholder="IMEI" required>
						</div>	

						<div class="form-group row" >
							<label id="lblForm"class="col-form-label col-xl col-lg">USUARIO:<span style="color:red;">*</span></label>
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
                    <!--BUSCADOR-->
						<!--Agregar {theme: 'bootstrap4',} dentro de select-->
						<script>
							$('#usuario').select2({theme: 'bootstrap4',});
						</script>
                        <!--BUSCADOR-->
                        <script>
							$(document).ready(function(){
								// Cuando se abre el dropdown, enfocamos el input de búsqueda
                                $('#usuario').on('select2:open', function () {
                                    const input = document.querySelector('.select2-container--open .select2-search__field');
                                    if (input) input.focus();
                                });
								$('#usuario').change(function(){
									buscador='b='+$('#usuario').val();
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
                        <!--///////////////////////////////////////////////////////////-->
                        </div>

						<div class="form-group row" >
<!-- 							<div id="divlineas" class="col-xl col-lg">
								<label id="lblForm"class="col-form-label col-xl col-lg">ASIGNADO A LINEA:</label>
								<div class="col-xl col-lg" >
									<input type="checkbox" class="chkLinea" name="checklinea" id="checklinea">
								</div>
							</div> -->

							<!-- <div id="lineasusuario" class="col-xl col-lg"> -->
							<label id="lblForm"class="col-form-label col-xl col-lg">LINEA:<span style="color:red;">*</span></label>
							<select name="linea" id="lineas" style="text-transform:uppercase" class="form-control col-xl col-lg" required><option value="" selected disabled>- SELECCIONE UNA-</option></select>
							<!-- </div> -->
						</div>

						<!-- <option selected disabled="">-SELECCIONE UNA-</option>
							<?php
							// include("../particular/conexion.php");
							// $consulta= "SELECT * FROM linea l INNER JOIN lineacelular c on c.ID_LINEA=l.ID_LINEA where c.ID_USUARIO=2 AND C.ID_CELULAR=0";
							// $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
							// ?>
							<?php ## foreach ($ejecutar as $opciones): ?>
							 <option value="<?php ##echo $opciones['ID_LINEA']?>"><?php ##echo $opciones['NRO']?></option>
							<?php ## endforeach ?>
							 -->

							 <div class="form-group row" >
                            <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:<span style="color:red;">*</span></label>
                            <select name="estado" id="estado" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
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

						<div class="form-group row" >
                            <label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR:<span style="color:red;">*</span></label>
                            <select name="proveedor" id="proveedor" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                            <option selected disabled="">-SELECCIONE UNA-</option>
                            <?php
                            include("../particular/conexion.php");
                            $consulta= "SELECT * FROM proveedor WHERE ID_PROVEEDOR BETWEEN 34 AND 35 ORDER BY PROVEEDOR ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?>
                                <option value="<?php echo $opciones['ID_PROVEEDOR']?>"><?php echo $opciones['PROVEEDOR']?></option>
                            <?php endforeach ?>
                            </select>
                        </div>

						<div class="form-group row" >
							<label id="lblForm"class="col-form-label col-xl col-lg">MODELO:<span style="color:red;">*</span></label>
                            <select name="modelo" id="modelo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                            <option selected disabled="">-SELECCIONE UNA-</option>
                            <?php
                            include("../particular/conexion.php");
                            $consulta= "SELECT m.MODELO, ma.MARCA, ID_MODELO
                            FROM modelo m
                            LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
							WHERE m.ID_TIPOP BETWEEN 17 AND 18
                            ORDER BY m.MODELO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?>
                                <option value="<?php echo $opciones['ID_MODELO']?>"><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                            <?php endforeach ?>
                            </select>
                    <!--BUSCADOR-->
						<!--Agregar {theme: 'bootstrap4',} dentro de select-->
						<script>
							$('#modelo').select2({theme: 'bootstrap4',});
						</script>
                        <!--BUSCADOR-->
                        <script>
							$(document).ready(function(){
								// Cuando se abre el dropdown, enfocamos el input de búsqueda
                                $('#modelo').on('select2:open', function () {
                                    const input = document.querySelector('.select2-container--open .select2-search__field');
                                    if (input) input.focus();
                                });
								$('#modelo').change(function(){
									buscador='b='+$('#modelo').val();
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
                        <!--///////////////////////////////////////////////////////////-->
						</div>

						<div class="form-group row" >
                            <label id="lblForm"class="col-form-label col-xl col-lg">PROCEDENCIA:<span style="color:red;">*</span></label>
                            <select name="procedencia" id="procedencia" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                            <option selected disabled="">-SELECCIONE UNA-</option>
                            <?php
                            include("../particular/conexion.php");
                            $consulta= "SELECT * FROM procedencia WHERE ID_PROCEDENCIA = 3 OR ID_PROCEDENCIA = 6 ORDER BY PROCEDENCIA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?>
                                <option value="<?php echo $opciones['ID_PROCEDENCIA']?>"><?php echo $opciones['PROCEDENCIA']?></option>
                            <?php endforeach ?>
                            </select>
						</div>

						<div class="form-group row">
							<label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓN:</label>
                            <textarea class="form-control col-xl col-lg" name="obs" placeholder="OBSERVACIÓN" style="text-transform:uppercase" rows="3" ></textarea>
							<input type="hidden" name="agregarCelular" value="GUARDAR">
						</div>
						<?php 
								if ($row['ID_PERFIL'] != 5) {
								echo '<div class="form-group row justify-content-end">
								<input style="width:20%" class="btn btn-success" onClick="enviar_formulario(this.form)" type="button" name="agregarCelular" value="GUARDAR" class="button">
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
        function validar_formulario(){
			
			var fieldsToValidate = [
                    {
                        selector: "#imei",
                        errorMessage: "No ingresó el nro. de IMEI."
                    },
                    {
                        selector: "#usuario",
                        errorMessage: "No seleccionó usuario."
                    },
                    {
                        selector: "#lineas",
                        errorMessage: "No seleccionó Línea asignada."
                    },
                    {
                        selector: "#estado",
                        errorMessage: "No ingresó el estado."
                    },
                    {
                        selector: "#proveedor",
                        errorMessage: "No seleccionó proveedor."
                    },
                    {
                        selector: "#modelo",
                        errorMessage: "No seleccionó modelo."
                    },
                    {
                        selector: "#procedencia",
                        errorMessage: "No seleccionó procedencia."
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
                            formulario.submit();


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}
		}
				
		</script>
	<script>
/* 	$(document).ready(function(){
    $("#usuario").change(function(){
		$("#checklinea").prop('checked', false);
		$("#lineasusuario").hide(0);
        $("#divlineas").show(1300);
    });

	$("#checklinea").change(function(){
        $("#lineasusuario").show(1300);
    });
    }); */
	function cargarLineas() {
        var usuario = document.getElementById("usuario").value;
		// alert(usuario)
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "obtener_lineas.php?usuario=" + usuario, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("lineas").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }
</script>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>