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
	<link href="estilotiporeporte.css" rel="stylesheet" type="text/css" />
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
   <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="jquery/1/jquery-ui.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script>
// 	$(document).ready(function(){
//       $("#der").hover(function(){
// 	    $("#der").fadeOut(0);
// 	    $("#contenedorinv").fadeIn(500);
// 	  });

// 	  $("#contenedorinv").mouseout(function(){
// 		$("#contenedorinv").fadeOut(0);
// 		$("#der").fadeIn(0);
	  
// 	  });
	
//     });
// </script>
   <style>
			body{
			background-color: #edf0f5;
			}
	</style>
   
</head>
<body>

<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                        <a id="vlv" style="width:120px;" href="cargadeincidentes.php" class="btn btn-primary">VOLVER</a>
	                    <a id="pr" class="btn btn-secondary" style="width: 50px; height:40px; border-radius: 10px;" onclick="location.href='consulta.php'"><i style=" margin-bottom:10px;"class='bi bi-house-door'></i></a>
		            </div>

	<section id="Inicio">
		<div id="titulo" style="margin-top:20px; margin-bottom: 65px;">
			<h1 >TIPO DE REPORTE</h1>
		</div>
		
        <div id="principal" >
             <div id=izq><a href="reporteincidentes.php"><input type="button" class="button but1" value="INCIDENTES"></div>
             <!-- onmouseout="mostrar()" -->
			 <div id=der onmouseover="ocultar()" onmouseout="mostrar()" ><a><input type="button" class="button but2" value="INVENTARIO"></div>
			 <div id="contenedorinv" style="display:none;">
			 <div class="d-grid gap-2 d-md-flex justify-content-center" style="margin-right: 10px;">
             <a href="reporteinventario.php" ><input type="button" class="button but3" value="EQUIPOS"></a>
             <a href="reporteperifericos.php"><input type="button" class="button but4" value="PERIFERICOS"></a>
             </div>
			 <div class="d-grid gap-2 col-6 mx-auto">
			 <a href="reporteestadotodos.php"><input type="button" class="button but3" style="font-size: 20px;" value="ESTADO INVENTARIO">
			 </div>
		</div>
        </div>
		<script>
                           function ocultar() {
							document.getElementById("der").style.display = "none";
							document.getElementById("contenedorinv").style.display = "block";
                                      }

							function mostrar() {
							document.getElementById("der").style.display = "block";
							document.getElementById("contenedorinv").style.display = "none";
                                      }
        </script>
         
    </section>
</body>
</html>