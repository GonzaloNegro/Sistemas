<?php 
session_start();
include('conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: Inicio.php'); 
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
	<title>CARGA RÁPIDA</title><meta charset="utf-8">
	<link rel="icon" href="imagenes/logoObrasPúblicas.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="jquery/1/jquery-ui.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="jquery/1/jquery-ui.js"></script>
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
	<link rel="stylesheet" type="text/css" href="estilocarga.css">
	<style>
			body{
				background-color: #edf0f5;
			}
	</style>
</head>
<body>
	<script type="text/javascript">
			function done(){
				swal(  {title: "Se han cargado sus incidentes correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='consulta.php';
						}
						}
						);
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
			url:"datos.php",
			data:"usuario=" + $('#buscador').val(),
			success:function(r){
				$('#select2lista').html(r);
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
<!-- 				<li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="cargarapidaportipificacion.php">CARGA RÁPIDA POR TIPIFICACIÓN</a></li> -->
                </ul>
			</li>
            <li><a href="consulta.php" class="nav-link px-2 link-dark link">CONSULTA</a></li>
            <li><a href="inventario.php" class="nav-link px-2 link-dark link">INVENTARIO</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="inventario.php">EQUIPOS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="impresoras.php">IMPRESORAS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="monitores.php">MONITORES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="otrosp.php">OTROS PERIFÉRICOS</a></li>
                </ul>
            </li>
            <li><a href="abm.php" class="nav-link px-2 link-dark link">ABM</a></li>
            <li><a href="tiporeporte.php" class="nav-link px-2 link-dark link">REPORTES</a></li>
			<?php if($row['ID_RESOLUTOR'] == 6//GONZALO
					/*OR $row['ID_RESOLUTOR'] == 2 //CLAUDIA*/
					OR $row['ID_RESOLUTOR'] == 10 //EUGENIA
					OR $row['ID_RESOLUTOR'] == 15 //RODRIGO
					OR $row['ID_RESOLUTOR'] == 20 //GUSTAVO
					){
                        echo'
						<li><a href="estadisticas.php" class="nav-link px-2 link-dark link">ESTADISTICAS</a></li>
                    ';
					} ?>
			<li><a href="calen/calen.php" class="nav-link px-2 link-dark link"><i class="bi bi-calendar3"></i></a>
            <li class="ubicacion link"><a href="bienvenida.php"><i class="bi bi-info-circle"></i></a></li>
        </ul>
        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false"><h5><i class="bi bi-person rounded-circle"></i><?php echo utf8_decode($row['RESOLUTOR']);?></h5></a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
		  <?php if($row['ID_RESOLUTOR'] == 6)
		  { echo '
		  	<li><a class="dropdown-item" href="agregados.php">CAMBIOS AGREGADOS</a></li>
            <li><hr class="dropdown-divider"></li>';}?>
            <li><a class="dropdown-item" href="contraseña.php">CAMBIAR CONTRASEÑA</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="salir.php">CERRAR SESIÓN</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
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
						include("conexion.php");
						$consulta= "SELECT * FROM usuarios WHERE ACTIVO LIKE 'ACTIVO' ORDER BY NOMBRE ASC";
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
						<div class="form-group row" style="margin: 10px; padding:10px;" id="select2lista"></div>
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
										include("conexion.php");
										$consulta= "SELECT * FROM tipificacion WHERE ID_TIPIFICACION >= 20";
										$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
										?>
										<?php foreach ($ejecutar as $opciones): ?> 
										<option value="<?php echo $opciones['ID_TIPIFICACION']?>"><?php echo $opciones['TIPIFICACION']?></option>
										<?php endforeach ?>
										</select>
								</div>
								<div class="form-group row" style="margin: 10px; padding:10px;">
									<textarea name="descripcion1" style="margin-left: 40px; text-transform:uppercase;" class="form-control col" placeholder="DESCRIPCIÓN DEL INCIDENTE" rows="3"></textarea>
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
										include("conexion.php");
										$consulta= "SELECT * FROM tipificacion WHERE ID_TIPIFICACION >= 20";
										$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
										?>
										<?php foreach ($ejecutar as $opciones): ?> 
										<option value="<?php echo $opciones['ID_TIPIFICACION']?>"><?php echo $opciones['TIPIFICACION']?></option>
										<?php endforeach ?>
										</select>

								</div>
								<div class="form-group row" style="margin: 10px; padding:10px;">
									<textarea name="descripcion2" style="margin-left: 40px; text-transform:uppercase;" class="form-control col" placeholder="DESCRIPCIÓN DEL INCIDENTE" rows="3"></textarea>
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
										include("conexion.php");
										$consulta= "SELECT * FROM tipificacion WHERE ID_TIPIFICACION >= 20";
										$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
										?>
										<?php foreach ($ejecutar as $opciones): ?> 
										<option value="<?php echo $opciones['ID_TIPIFICACION']?>"><?php echo $opciones['TIPIFICACION']?></option>
										<?php endforeach ?>
										</select>
								</div>
								<div class="form-group row" style="margin: 10px; padding:10px;">
									<textarea name="descripcion3" style="margin-left: 40px; text-transform:uppercase;" class="form-control col" placeholder="DESCRIPCIÓN DEL INCIDENTE" rows="3"></textarea>
								</div>
							</div>
							</div>
						</div>
					</div>
				</div>	

				<!--//////////////////////////////////////////////////////////////////-->
				<!--//////////////////////////////////////////////////////////////////-->
				<div class="row justify-content-end" style="margin: 10px; padding:10px;">
					<input id="btnform" type="submit" value="GUARDAR" name="g1" class="col-2 button">
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
					<img src="imagenes/logoGobierno.png" class="img-fluid">
				</div>
			</div>
		</div>
	</footer>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
  		AOS.init();
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>