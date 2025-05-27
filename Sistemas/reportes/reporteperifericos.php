<!--html actual de reportes-->
<!--la pagina trae la tabla de incidentes original, se agrego lnk de inconos de bootstrap"-->
<!--SE CAMBIO EL TIPO DE REPORTES, SOLO ESTA HECHO PARA RESOLUTOR Y TIPIFICACION-->
<?php 
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
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
	<title>Reportes Periféricos</title>
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<link href="../estilos/estiloreporte.css" rel="stylesheet" type="text/css" />
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
   <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
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
  <a id="vlv"  href="../reportes/tiporeporte.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
	                    <a id="pr" class="btn btn-secondary" style="width: 50px; height:40px; border-radius: 10px;" onclick="location.href='../consulta/consulta.php'"><i style=" margin-bottom:10px;"class='bi bi-house-door'></i></a>
		            </div>
	<section id="Inicio">
		<div id="titulo">
			<h1 style="margin-top: 20px;">REPORTES DE PERIFERICOS</h1>
       
		</div>
	

<!--Selector de filtro-->
<div id="principal" style="height: auto;"  class="container-fluid">
<!-- <form method="POST" action="reportesdispositivo.php"> -->
<div id="formprin" class="form-group row" style="margin: 10px; padding:10px; padding-bottom: 30px;">
   <label id="lblForm" style="margin-top:20px; font-size:28px;"class="col-form-label col-xl col-lg">SELECCIONE EL TIPO DE REPORTE:</label>
   <select id="slctipo" style="margin-top:20px;" name="tiporeporteinvent" class="form-control col-xl col-lg" formControlName="Activo" onChange="mostrarFiltros()" required>
       <option value="0" selected disabled="tipo">-SELECCIONE UNA-</option>
       <option value="AREA">AREA</option>
       <option value="ESTADO">ESTADO</option>
       <option value="PROVEEDOR">PROVEEDOR</option>
</select>
</div>
<div class="form-check form-group" style="margin-left: 60px;">
  <input class="form-check-input" type="radio" name="radioinv" id="radioinv" style="radio: 2px;" value="impresora" checked>
  <label class="form-check-label">
    IMPRESORAS
  </label>
</div>
<div class="form-check form-group" style="margin-left: 60px;">
  <input class="form-check-input" type="radio" name="radioinv" id="radioinv" value="monitor" >
  <label class="form-check-label">
    MONITORES
  </label>
</div>
<div class="form-check form-group" style="margin-left: 60px;">
  <input class="form-check-input" type="radio" name="radioinv" id="radioinv" value="scanner" >
  <label class="form-check-label">
    SCANNERS
  </label>
</div>
<div class="form-check form-group" style="margin-left: 60px; padding-bottom:20px;">
  <input class="form-check-input" type="radio" name="radioinv" id="radioinv" value="otros" >
  <label class="form-check-label">
    OTROS
  </label>
</div>
<div id="btncarga" class="form-group row justify-content-end" style="display: none;">
<input id="boton" style="width:150px; margin-right:30px; margin-bottom:20px;" class="col-xl-2 col-lg-2 btn btn-success" type="button" value="CARGAR REPORTE" >
</div> 
<!-- </form>  -->
</div> 
<!--FUNCIONALIDADES QUE REDIRIGEN LA PAGINA A REPORTESDISPOSITIVOS.PHP CON LOS PARAMETROS SELECCIONADOS-->
<script>
$(document).ready(function(){
  // $tipo=$("#slctipo").val();
  // $inv=$("#radioinv").val();
    $("#boton").click(function() {
      if ($("#slctipo").val()=='AREA'&document.querySelector('input[name="radioinv"]:checked').value=='scanner') {
        window.location.href = "reportesdispositivo.php?tiporeporte=AREA&tipodisp=scanner"
      }
      if ($("#slctipo").val()=='ESTADO'&document.querySelector('input[name="radioinv"]:checked').value=='scanner') {
        window.location.href = "reportesdispositivo.php?tiporeporte=ESTADO&tipodisp=scanner"
      }
      if ($("#slctipo").val()=='PROVEEDOR'&document.querySelector('input[name="radioinv"]:checked').value=='scanner') {
        window.location.href = "reportesdispositivo.php?tiporeporte=PROVEEDOR&tipodisp=scanner"
      }
      if ($("#slctipo").val()=='AREA'&document.querySelector('input[name="radioinv"]:checked').value=='impresora') {
        window.location.href = "reportesdispositivo.php?tiporeporte=AREA&tipodisp=impresora"
      }
      if ($("#slctipo").val()=='ESTADO'&document.querySelector('input[name="radioinv"]:checked').value=='impresora') {
        window.location.href = "reportesdispositivo.php?tiporeporte=ESTADO&tipodisp=impresora"
      }
      if ($("#slctipo").val()=='PROVEEDOR'&document.querySelector('input[name="radioinv"]:checked').value=='impresora') {
        window.location.href = "reportesdispositivo.php?tiporeporte=PROVEEDOR&tipodisp=impresora"
      }
      if ($("#slctipo").val()=='AREA'&document.querySelector('input[name="radioinv"]:checked').value=='monitor') {
        window.location.href = "reportesdispositivo.php?tiporeporte=AREA&tipodisp=monitor"
      }
      if ($("#slctipo").val()=='ESTADO'&document.querySelector('input[name="radioinv"]:checked').value=='monitor') {
        window.location.href = "reportesdispositivo.php?tiporeporte=ESTADO&tipodisp=monitor"
      }
      if ($("#slctipo").val()=='PROVEEDOR'&document.querySelector('input[name="radioinv"]:checked').value=='monitor') {
        window.location.href = "reportesdispositivo.php?tiporeporte=PROVEEDOR&tipodisp=monitor"
      }
      if ($("#slctipo").val()=='AREA'&document.querySelector('input[name="radioinv"]:checked').value=='otros') {
        window.location.href = "reportesdispositivo.php?tiporeporte=AREA&tipodisp=otros"
      }
      if ($("#slctipo").val()=='ESTADO'&document.querySelector('input[name="radioinv"]:checked').value=='otros') {
        window.location.href = "reportesdispositivo.php?tiporeporte=ESTADO&tipodisp=otros"
      }
      if ($("#slctipo").val()=='PROVEEDOR'&document.querySelector('input[name="radioinv"]:checked').value=='otros') {
        window.location.href = "reportesdispositivo.php?tiporeporte=PROVEEDOR&tipodisp=otros"
      }
      
		
});});
</script>
<!---Prueba-->
<!--Filtros-->

<script src="../js/filtrosinventario.js"></script>
<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</section>
<footer>
   </footer>
</body>
</html>