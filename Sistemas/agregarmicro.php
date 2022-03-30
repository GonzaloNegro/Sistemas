<?php 
session_start();
include('conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: Inicio.php'); 
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
	<title>AGREGAR MICRO</title><meta charset="utf-8">
	<link rel="icon" href="imagenes/logoObrasPúblicas.png">
	<link rel="stylesheet" type="text/css" href="estiloagregar.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<style>
			body{
				background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
			function ok(){
				swal(  {title: "Micro cargado correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmmicro.php';
						}
						}
						);
			}	
			</script>
<script type="text/javascript">
			function repeat(){
				swal(  {title: "Micro cargado correctamente. Verifique el nombre de la marca, ya que existe este nombre registrado previamente!",
						icon: "info",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmmicro.php';
						}
						}
						);
			}	
			</script>
<script type="text/javascript">
			function no(){
				swal(  {title: "El micro de la marca ingresada ya está registrado",
						icon: "error",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='agregarmicro.php';
						}
						}
						);
			}	
			</script>
	<div id="reporteEst" style="width: 97%; margin-left: 20px;">   
				<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
					<a id="vlv"  href="abmmicro.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
				</div>					
		</div>
		
        <section id="Inicio">
		<div id="titulo" style="margin: 20px;">
			<h1>AGREGAR MICRO</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
						<form method="POST" action="guardarmodmicro.php">
                            <div class="form-group row" style="margin: 10px; padding:10px;">
                                <label id="lblForm" class="col-form-label col-xl col-lg">MICRO:</label>
                                <input class="form-control col-xl col-lg" style="text-transform:uppercase;" type="text" name="micro" placeholder="NOMBRE DEL MODELO" required>
                            <label id="lblForm"class="col-form-label col-xl col-lg">MARCA:</label>
                                <select name="marca" class="form-control col-xl col-lg" required>
                                <option selected disabled="area">-SELECCIONE UNA-</option>
                                <?php
                                include("conexion.php");

                                $consulta= "SELECT * FROM marcas";
                                $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                ?>
                                <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value="<?php echo $opciones['ID_MARCA']?>"><?php echo $opciones['MARCA']?></option>						
                                <?php endforeach ?>
                                </select>
                            </div>

                            <div class="row justify-content-end" style="margin: 10px; padding:10px;">
                                <input style="width: 20%;"class="col-3 button" type="submit" value="GUARDAR" >
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
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>