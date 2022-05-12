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
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR FROM resolutor WHERE CUIL='$iduser'";
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
    <div class="container-fluid">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none"><div id="foto"></div>
          <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use> </svg>-->
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="cargadeincidentes.php" class="nav-link px-2 link-secondary link destacado" 
			style="border-left: 5px solid #53AAE0;">NUEVO INCIDENTE</a>
 				<ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
					<li><a class="dropdown-item" href="cargarapidaporusuario.php">CARGA RÁPIDA POR USUARIO</a></li>
<!-- 				<li><hr class="dropdown-divider"></li>
                	<li><a class="dropdown-item" href="cargarapidaportipificacion.php">CARGA RÁPIDA POR TIPIFICACIÓN</a></li> -->
                </ul>
			</li>
      <li><a href="consulta.php" class="nav-link px-2 link-dark link" style="border-left: 5px solid #53AAE0;">CONSULTA</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="consulta.php">CONSULTA DE INCIDENTES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="consultausuario.php">CONSULTA DE USUARIOS</a></li>
                </ul>
            </li>
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
            <li><a href="tiporeporte.php" class="nav-link px-2 link-dark link" style="border-left: 5px solid #53AAE0;">REPORTES</a></li>
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
            <img src="imagenes/incidentes.jpg" alt="">
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
          <img src="imagenes/inventario.jpg" alt="">
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
          </div>
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>
</html>