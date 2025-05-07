<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
    $datos_base = mysqli_connect('localhost', 'root', '', 'incidentes') 
        or exit('No se puede conectar con la base de datos');

	/* sanitizar el valor recibido en $no_tic antes de meterlo en la consulta SQL. Esto es una medida de seguridad contra inyección SQL */
	$no_tic = mysqli_real_escape_string($datos_base, $no_tic);

    $sentencia = "SELECT * FROM tipificacion WHERE ID_TIPIFICACION='" . $no_tic . "'";
    $resultado = mysqli_query($datos_base, $sentencia);

    return mysqli_fetch_assoc($resultado);
}

?>
<!DOCTYPE html>
<html>
<head>
<title>MODIFICAR TIPIFICACIÓN</title>
<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
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

<main>
	<div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="abmtipificacion.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
    <div id="titulo">
			<h1>MODIFICAR TIPIFICACIÓN</h1>
		</div>
		<div id="principalu">
			<form method="POST" action="./modificados.php">			
				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">TIPIFICACIÓN ID:</label>
					<input type="text" class="id" name="id" value="<?php echo $consulta['ID_TIPIFICACION']?>" style="background-color:transparent;" readonly>
				</div>
				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE DE LA TIPIFICACIÓN:</label>
					<input id="tipificacion" style="text-transform:uppercase;" class="form-control col-form-label col-xl col-lg"  type="text" name="tip" value="<?php echo $consulta['TIPIFICACION']?>">
				</div>	
				<div class="form-group row justify-content-end">
					<input class="btn btn-success" type="button" style="width:20%" name="modTipificacion" onClick="enviar_formulario(this.form)" value="MODIFICAR" >
				</div>
			</form>
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
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>