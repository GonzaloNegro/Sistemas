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
	<title>REPORTES DE INCIDENTES</title>
	<link rel="icon" href="imagenes/logoObrasPúblicas.png">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
   <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="jquery/1/jquery-ui.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link href="estilotiporeporte.css" rel="stylesheet" type="text/css" />
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
<header class="p-3 mb-3 border-bottom altura">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none"><div id="foto"></div>
          <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use> </svg>-->
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 espacio">
            <li><a href="cargadeincidentes.php" class="nav-link px-2 link-secondary link">CARGA</a></li>
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
            <li class="ubicacion"><a href="bienvenida.php"><i class="bi bi-info-circle"></i></a></li>
        </ul>
        <form method="POST" action="mensajes.php">
			    <button href="mensajes.php" class="mensaje" style="margin-right: 50px;"><i class="bi bi-chat-square-text"></i></button>
		    </form>
        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false"><h5><i class="bi bi-person rounded-circle"></i><?php echo utf8_decode($row['RESOLUTOR']);?></h5></a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="contraseña.php">CAMBIAR CONTRASEÑA</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="salir.php">CERRAR SESIÓN</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
	<section id="Inicio">
		<div id="titulo" style="margin-top:20px; margin-bottom: 65px;" data-aos="zoom-in">
			<h1>TIPO DE REPORTE</h1>
		</div>
		
        <div id="principal" >
             <div id=izq  data-aos="fade-right"
            data-aos-anchor="#example-anchor"
            data-aos-offset="500"
            data-aos-duration="500"><a href="reporteincidentes.php"><input type="button" class="button but1" value="INCIDENTES"></div>
             <!-- onmouseout="mostrar()" -->
			 <div id=der onmouseover="ocultar()" onmouseout="mostrar()" data-aos="fade-left"
            data-aos-anchor="#example-anchor"
            data-aos-offset="500"
            data-aos-duration="500"><a><input type="button" class="button but2" value="INVENTARIO"></div>
			 <div id="contenedorinv" style="display:none;">
			 <div class="d-grid gap-2 d-md-flex justify-content-center" style="margin-right: 10px;">
             <a href="reporteinventario.php" ><input type="button" class="button but3" value="EQUIPOS"></a>
             <a href="reporteperifericos.php"><input type="button" class="button but4" value="PERIFERICOS"></a>
             </div>
			 <div class="d-grid gap-2 col-6 mx-auto">
			 <a href="reporteestadotodos.php"><input type="button" class="button but3" style="font-size: 20px;" value="ESTADO INVENTARIO"></a>
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>
</html>