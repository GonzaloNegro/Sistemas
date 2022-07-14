<!--html actual de reportes-->
<!--la pagina trae la tabla de incidentes original, se agrego lnk de inconos de bootstrap"-->
<!--SE CAMBIO EL TIPO DE REPORTES, SOLO ESTA HECHO PARA RESOLUTOR Y TIPIFICACION-->
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
$consulta=mysqli_query($datos_base, "SELECT * FROM ticket ORDER BY FECHA_INICIO DESC, ID_TICKET DESC");
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>Reportes de Incidencias</title>
	<link href="estiloreporte.css" rel="stylesheet" type="text/css" />
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
   <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="jquery/1/jquery-ui.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <script>
	$(document).ready(function(){
    $("#slctipo").change(function(){
      $("#btncarga").show(700);
		
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
<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                        <a id="vlv" href="tiporeporte.php" class="btn btn-primary">VOLVER</a>
	                    <a id="pr" class="btn btn-secondary" style="width: 50px; height:40px; border-radius: 10px;" onclick="location.href='consulta.php'"><i style=" margin-bottom:10px;"class='bi bi-house-door'></i></a>
		            </div>

	<section id="Inicio">
		<div id="titulo">
			<h1 style="margin-top:60px;">REPORTES DE EQUIPOS</h1>
       
		</div>
	

<!--Selector de filtro-->

<!--Selector de filtro-->
<div id="principal" style="height: auto;"  class="container-fluid">
<div id="formprin" class="form-group row" style="margin: 10px; padding:10px; padding-bottom: 30px;">
   <label id="lblForm" style="margin-top:20px; font-size:28px;"class="col-form-label col-xl col-lg">SELECCIONE EL TIPO DE REPORTE:</label>
   <select id="slctipo" style="margin-top:20px;" name="tiporeporteinvent"  class="form-control col-xl col-lg" formControlName="Activo" onChange="mostrarFiltros()" required>
       <option value="0" selected disabled="tipo">-SELECCIONE UNA-</option>
       <option value="reportecpu.php?repa=0&opc=AREA">AREA</option>
       <option value="reportecpu.php?repa=0&opc=ESTADO">ESTADO</option>
       <option value="reportecpu.php?repa=0&opc=PROVEEDOR">PROVEEDOR</option>
	   <option value="reportecpu.php?repa=0&opc=SO">SISTEMA OPERATIVO</option>
	   <option value="reportecpu.php?repa=0&opc=MICRO">MICROPROCESADOR</option>
</select>
</div>



<div id="btncarga" class="form-group row justify-content-end" style="display: none;">
<input id="boton" style="width:200px; margin-right:30px; margin-bottom:20px;" class="col-xl-2 col-lg-2 button" type="button" value="CARGAR REPORTE" >
</div>
</div>

<script>
$(document).ready(function(){
    $("#boton").click(function() {
		window.location.href = $("#slctipo").val()
});});
</script>



<script src="filtrosinventario.js"></script>

</section>
<footer></footer>
</body>
</html>