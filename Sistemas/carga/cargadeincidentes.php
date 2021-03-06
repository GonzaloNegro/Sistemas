<?php 
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>CARGA DE INCIDENTES</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoObrasPúblicas.png">
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
	<link rel="stylesheet" type="text/css" href="../estilos/estilocarga.css">
	<!--Estilo bootstrap para select2-->
	<link rel="stylesheet" href="/path/to/select2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
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
        
		

		if ($("#slctestado").val() == '3') {
			$("#txtaDerivacion").show(1300);
		    $("#resoderi").show(1300);
		    $("#slctResoDer").show(1300);
			$("#txtfechafin").hide(1000);
			$("#lblfechaFin").hide(1000);
		}
		if ($("#slctestado").val() == '1' || $("#slctestado").val() == '2' || $("#slctestado").val() == '5') {
			$("#txtaDerivacion").show(1300);
			$("#txtfechafin").show(1300);
			$("#lblfechaFin").show(1300);
		}

		
		if($("#slctestado").val() == '4'){
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
			<script>
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
						if (form.estado.value == "1" || form.estado.value == "2" || form.estado.value == "3" || form.estado.value == "5") { 
							if (form.fecha_solucion.value ==""){
								alert("Por favor, ingresa la fecha de solucion"); 
								form.fecha_solucion.focus(); 
								return true; }
								 if (form.motivo.value ==""){
								 alert("Por favor, complete el campo de motivo"); 
								 form.motivo.focus(); 
								 return true; }
								
								}
								
						
									form.submit()
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

<header class="p-3 mb-3 border-bottom altura">
    <div class="container-fluid">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none"><div id="foto"></div>
          <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use> </svg>-->
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 ">
            <li><a href="cargadeincidentes.php" class="nav-link px-2 link-secondary link destacado" 
			style="border-left: 5px solid #53AAE0;">NUEVO INCIDENTE</a>
 				<ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
					<li><a class="dropdown-item" href="cargarapidaporusuario.php">CARGA RÁPIDA POR USUARIO</a></li>
  					<li><hr class="dropdown-divider"></li>
                	<li><a class="dropdown-item" href="cargarapidaportipificacion.php">CARGA RÁPIDA POR TIPIFICACIÓN</a></li>
                </ul>
			</li>
            <li><a href="../consulta/consulta.php" class="nav-link px-2 link-dark link" style="border-left: 5px solid #53AAE0;">CONSULTA</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="../consultaconsulta.php">CONSULTA DE INCIDENTES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/consultausuario.php">CONSULTA DE USUARIOS</a></li>
					<li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/consultaaltas.php">CONSULTA PARA ALTAS</a></li>
                </ul>
            </li>
            <li><a href="../consulta/inventario.php" class="nav-link px-2 link-dark link">INVENTARIO</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="../consulta/inventario.php">EQUIPOS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/impresoras.php">IMPRESORAS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="..consulta/monitores.php">MONITORES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="..consulta/otrosp.php">OTROS PERIFÉRICOS</a></li>
                </ul>
            </li>
            <li><a href="../abm/abm.php" class="nav-link px-2 link-dark link">ABM</a></li>
            <li><a href="../reportes/tiporeporte.php" class="nav-link px-2 link-dark link">REPORTES</a></li>
			<?php if($row['ID_RESOLUTOR'] == 6//GONZALO
					/*OR $row['ID_RESOLUTOR'] == 2 //CLAUDIA*/
					OR $row['ID_RESOLUTOR'] == 10 //EUGENIA
					OR $row['ID_RESOLUTOR'] == 15 //RODRIGO
					OR $row['ID_RESOLUTOR'] == 20 //GUSTAVO
					){
                        echo'
						<li><a href="../particular/estadisticas.php" class="nav-link px-2 link-dark link">ESTADISTICAS</a></li>
                    ';
					} ?>
			<li><a href="../calen/calen.php" class="nav-link px-2 link-dark link"><i class="bi bi-calendar3"></i></a>
            <li class="ubicacion link"><a href="../particular/bienvenida.php"><i class="bi bi-info-circle"></i></a></li>
        </ul>
		<div class="notif" id="notif">
			<i class="bi bi-bell" id="cant">
			<?php
			$cant="SELECT count(*) as cantidad FROM ticket WHERE ID_ESTADO = 4;";
			$result = $datos_base->query($cant);
			$rowa = $result->fetch_assoc();
			$cantidad = $rowa['cantidad'];

			/* $fechaActual = date('m'); */
			if($cantidad > 0){
				echo $cantidad;
			}
			?></i>
			<script type="text/javascript">
				var valor = "<?php echo $cantidad; ?>";
				console.log(valor);
			</script>
		</div>
        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false"><h5><i class="bi bi-person rounded-circle"></i><?php echo utf8_decode($row['RESOLUTOR']);?></h5></a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
		  <?php if($row['ID_RESOLUTOR'] == 6)
		  { echo '
		  	<li><a class="dropdown-item" href="../particular/agregados.php">CAMBIOS AGREGADOS</a></li>
            <li><hr class="dropdown-divider"></li>';}?>
            <li><a class="dropdown-item" href="../particular/contraseña.php">CAMBIAR CONTRASEÑA</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../particular/salir.php">CERRAR SESIÓN</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
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
									<select name="prioridad" class="form-control col-xl col-lg" required>
										<option value="" selected disabled="prioridad">-SELECCIONE UNA-</option>
										<?php
										include("../particular/conexion.php");
										$consulta= "SELECT * FROM prioridad";
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
										$consulta= "SELECT * FROM tipificacion WHERE ID_TIPIFICACION >= 20";
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
								<textarea name="descripcion" style="margin-left: 40px; text-transform:uppercase;" class="form-control col" placeholder="DESCRIPCIÓN DEL INCIDENTE" rows="3" required></textarea>
							</div>
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<div class="form-group row" style="margin: 10px; padding:10px;">
								<label class="col-form-label col-xl" id="lblfechaFin" style="display:none;">FECHA SOLUCIÓN: </label>
								<input type="date" name="fecha_solucion" id="txtfechafin" style="display:none;"class="form-control col-xl derecha">
							<label class="col-form-label col-xl">ESTADO INCIDENTE: </label>
							<select id="slctestado" name="estado" required class="form-control col-xl derecha" >
								<option value='0' selected disabled="estado">-SELECCIONE UNA-</option>
								<?php
								include("../particular/conexion.php");
								$consulta= "SELECT * FROM estado";
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
								<option value="0" selected disabled="derivado">-SELECCIONE UNA-</option>
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
							<textarea name="motivo" style="margin-left: 40px; display: none;" id="txtaDerivacion" class="form-control col" placeholder="MOTIVO" style="text-transform:uppercase" rows="3"></textarea>
							</div>
							<!--//////////////////////////////////////////////////////////////////-->
							<!--//////////////////////////////////////////////////////////////////-->
							<div class="row justify-content-end" style="margin: 10px; padding:10px;">
							<input id="btnform" type="button" value="GUARDAR" onClick="validar_formulario(this.form)"  name="g1" class="col-2 button">
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
					<img src="../imagenes/logoGobierno.png" class="img-fluid">
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
	<script src="../js/script.js"></script>
</body>
</html>