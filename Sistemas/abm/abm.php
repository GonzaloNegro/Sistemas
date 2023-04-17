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
	<title>ALTA BAJA MODIFICACIÓN</title>
    <link rel="icon" href="../imagenes/logoObrasPúblicas.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="../estilos/estiloabm.css" rel="stylesheet" type="text/css" />
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
        <li><a href="../carga/cargadeincidentes.php" class="nav-link px-2 link-secondary link destacado">NUEVO INCIDENTE</a>
 				<ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
					<li><a class="dropdown-item" href="../carga/cargarapidaporusuario.php">CARGA RÁPIDA POR USUARIO</a></li>
     				<li><hr class="dropdown-divider"></li>
                	<li><a class="dropdown-item" href="../carga/cargarapidaportipificacion.php">CARGA RÁPIDA POR TIPIFICACIÓN</a></li>
                </ul>
			</li>
            <li><a href="../consulta/consulta.php" class="nav-link px-2 link-dark link">CONSULTA</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="../consulta/consulta.php">CONSULTA DE INCIDENTES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/consultausuario.php">CONSULTA DE USUARIOS</a></li>
					<li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/consultaaltas.php">CONSULTA PARA ALTAS</a></li>
                </ul>
            </li>
            <li><a href="../consulta/inventario.php" class="nav-link px-2 link-dark link">INVENTARIO</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="../consulta/inventario.php">EQUIPOS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/impresoras.php">IMPRESORAS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/monitores.php">MONITORES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/otrosp.php">OTROS PERIFÉRICOS</a></li>
                </ul>
            </li>
            <li><a href="#" class="nav-link px-2 link-dark link">GESTIÓN</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a href="./abm.php" class="dropdown-item">ABM</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="../reportes/tiporeporte.php" class="dropdown-item">REPORTES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <?php if($row['ID_PERFIL'] == 1 OR $row['ID_PERFIL'] == 2){
                                echo'
                                <li><a href="../particular/estadisticas.php" class="dropdown-item">ESTADISTICAS</a></li>
                            ';
                            } 
                            ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="../stock/stock.php" class="dropdown-item">STOCK</a></li>
                </ul>
            </li>
			<li><a href="../calen/calen.php" class="nav-link px-2 link-dark link" data-bs-toggle="tooltip" title="Calendario" data-bs-placement="bottom"><i class="bi bi-calendar3"></i></a></li>
			<li class="ubicacion link"><a href="../particular/bienvenida.php" data-bs-toggle="tooltip" title="Novedades" data-bs-placement="bottom"><i class="bi bi-info-circle"></i></a></li>
			<li><a href="../Manual.pdf" class="ubicacion link" data-bs-toggle="tooltip" title="Manual" data-bs-placement="bottom"><i class="bi bi-journal"></i></a></li>
        </ul>
		<div class="notif" id="notif">
			<i class="bi bi-bell" id="cant" data-bs-toggle="tooltip" title="Notificaciones" data-bs-placement="bottom">
			<?php
			$cant="SELECT count(*) as cantidad FROM ticket WHERE ID_ESTADO = 4;";
			$result = $datos_base->query($cant);
			$rowa = $result->fetch_assoc();
			$cantidad = $rowa['cantidad'];

			/* $fechaActual = date('m'); */
			if($cantidad > 0){
				echo $cantidad;
			}
			?></i>
			<script type="text/javascript">
				var valor = "<?php echo $cantidad; ?>";
				console.log(valor);
			</script>
		</div>
        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false"><h5><i class="bi bi-person rounded-circle"></i><?php echo utf8_decode($row['RESOLUTOR']);?></h5></a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
            <?php if($row['ID_RESOLUTOR'] == 6)
            { echo '
		  	<li><a class="dropdown-item" href="../particular/agregados.php">CAMBIOS AGREGADOS</a></li>
            <li><hr class="dropdown-divider"></li>';}?>
            <li><a class="dropdown-item" href="../particular/contraseña.php">CAMBIAR CONTRASEÑA</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../particular/salir.php">CERRAR SESIÓN</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <h1 data-aos="zoom-in">ALTA BAJA MODIFICACIÓN</h1>
	<section id="Inicio">
        <div id="principal1">
            <div id=izq>
            <?php if($row['ID_PERFIL'] == 1 OR $row['ID_PERFIL'] == 2){
                        echo'
                    <a href=abmtipificacion.php><button type="submit" class="boton_fondo_corredizo_izquierda">-TIPIFICACIÓN-</button></a>
                    <a href=abmresolutor.php><button type="submit" class="boton_fondo_corredizo_izquierda">-RESOLUTOR-</button></a>
                 ';
					} ?>
                    <a href="abmequipos.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-EQUIPOS-</button></a>
                    
<!--                     <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" title="Mensaje en cartel" data-bs-placement="top">Tooltip on right</button> -->

                    <a href=abmarea.php><button type="submit" class="boton_fondo_corredizo_izquierda">-ÁREAS-</button></a>
                    <a href="abmimpresoras.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-IMPRESORAS-</button></a>
                    <a href="abmmonitores.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-MONITORES-</button></a>
            </div> 
            <div id=der>

                <?php if($row['ID_PERFIL'] == 1 OR $row['ID_PERFIL'] == 2){
                        echo'
                    <a href="abmmarcas.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-MARCAS-</button></a>
                    <a href="abmmicro.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-MICROS-</button></a>
                    <a href="abmmodelos.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-MODELOS-</button></a>
                    <a href="abmplacamadre.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-PLACA MADRE-</button></a>
                    <a href="abmplacav.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-PLACA DE VIDEO-</button></a>
                    ';
					} ?>
                    <a href="abmusuario.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-USUARIOS-</button></a>
                    <a href="abmotros.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-OTROS PERIFÉRICOS-</button></a>
            </div>
        </div>
    </section>
    <footer>
		<div class="footer">
			<div class="container-fluid">
				<div class="row">
					<img src="../imagenes/logoGobierno.png" class="img-fluid">
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
	<script src="../js/script.js"></script>
</body>
</html> 