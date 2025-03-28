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
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$consulta=mysqli_query($datos_base, "SELECT * FROM ticket ORDER BY FECHA_INICIO DESC, ID_TICKET DESC");
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>REPORTES DE INCIDENTES</title>
	<link rel="icon" href="../imagenes/logoObrasPúblicas.png">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
   <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link href="../estilos/estilotiporeporte.css" rel="stylesheet" type="text/css" />
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
<?php include('../layout/reportes.php'); ?>

	<section id="Inicio">
		<div id="titulo" style="margin-top:20px; margin-bottom: 20px;" data-aos="zoom-in">
			<h1>TIPO DE REPORTE</h1>
		</div>
  </section>
      
		<script>
/*                            function ocultar() {
							document.getElementById("der").style.display = "none";
							document.getElementById("contenedorinv").style.display = "block";
                                      }

							function mostrar() {
							document.getElementById("der").style.display = "block";
							document.getElementById("contenedorinv").style.display = "none";
                                      } */
        </script>
         
    </section>

    <section class="tarjetas">

        <div class="card" data-aos="zoom-in">
          <div class="face front">
            <img src="../imagenes/incidentes.jpg" alt="">
            <h3>INCIDENTES</h3>
          </div>
          <div class="face back">
            <h3>INCIDENTES</h3>
            <div class="link">
              <a href="reporteincidentes.php">INCIDENTES</a> 
            </div>
          </div>
        </div>

        <div class="card" data-aos="zoom-in">
          <div class="face front">
          <img src="../imagenes/inventario.jpg" alt="">
            <h3>INVENTARIO</h3>
          </div>
          <div class="face back">
            <h3>INVENTARIO</h3>
            <div class="link">
              <a href="reporteinventario.php">EQUIPOS</a> 
            </div>
            <div class="link">
            <a href="reporteperifericos.php">PERIFÉRICOS</a> 
            </div>
            <div class="link">
            <a href="relevamientoinventario.php">INVENTARIO</a> 
            </div>
            <div class="link">
            <a href="reporteimpresora.php">IMPRESORAS DINAMICO</a> 
            </div>
            <div class="link">
            <a href="reporteequipo.php">EQUIPOS DINAMICO</a> 
            </div>
            <div class="link">
            <a href="../consulta/reportePlanesTelefonia.php">PLANES TELEFÓNICOS</a> 
            </div>
            <div class="link">
            <a href="../consulta/reporteLineasTelefonia.php">LÍNEAS TELEFÓNICAS</a> 
            </div>
          </div>
        </div>

        <div class="card" data-aos="zoom-in">
          <div class="face front">
          <img src="../imagenes/flechas.png" alt="">
            <h3>MOVIMIENTOS</h3>
          </div>
          <div class="face back">
            <h3>MOVIMIENTOS</h3>
            <div class="link">
              <a href="reportemovimientosequipos.php?movimiento=0">EQUIPOS</a> 
            </div>
            <div class="link">
            <a href="reportemovimientosperifericos.php?movimiento=0">IMPRESORAS/PERIFÉRICOS</a> 
            </div>
            <h3>MEJORAS</h3>
            <div class="link">
              <a href="reportemejorasequipos.php?mejora=0">EQUIPOS</a> 
            </div>
          </div>
          
            
            
            
          </div>
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
		const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
		const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
	</script>
	
</body>
</html>