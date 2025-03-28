<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM tipificacion WHERE ID_TIPIFICACION='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_TIPIFICACION'],/*0*/
		$filas['TIPIFICACION'],/*1*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
<title>MODIFICAR TIPIFICACIÓN</title>
<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script>
	function validar(){
		var tipificacion = $('#tipificacion').val();
		if (tipificacion == ""|| tipificacion == null) {
			Swal.fire({
            	title: "Por favor ingrese la tipificación.",
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
				return false;
				}
		else{
				return true;
					}
				}
</script>
<script>
	function enviar_formulario(form){
		if (validar()) {
			Swal.fire({
            title: "Esta seguro de modificar esta tipificación?",
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
                    form.submit()
				}
				else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                    }
                    })
				}}
			</script>
	<div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="abmtipificacion.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
    <div id="titulo">
			<h1>MODIFICAR TIPIFICACIÓN</h1>
		</div>
		<div id="principal">
			<form method="POST" action="guardarmodtipificacion2.php">
				<div class="form--info">
					<label>TIPIFICACIÓN ID: </label>
					<input type="text" class="id" name="id" value="<?php echo $consulta[0]?>" readonly>
				</div>
				<div class="form--info">
					<input id="tipificacion" style="text-transform:uppercase;" class="form-control"  type="text" name="tip" value="<?php echo $consulta[1]?>">
				</div>	
				<div class="form--info--btn">
					<input class="btn btn-success" type="button" onClick="enviar_formulario(this.form)" value="MODIFICAR" >
				</div>
			</form>
	    </div>
	</section>
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>