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
    <link rel="icon" href="../imagenes/logoInfraestructura.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="../estilos/estiloabm.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <main> 
    <?php include('../layout/reportes.php'); ?>
    <h1 data-aos="zoom-in">ALTA BAJA MODIFICACIÓN</h1>
        <section id="Inicio">
            <div id="principal1">
            
                <?php if($row['ID_PERFIL'] == 1 OR $row['ID_PERFIL'] == 2){
                            echo'
                            
                        <a href=abmarea.php><button type="submit" class="boton_fondo_corredizo_izquierda">-ÁREAS-</button></a>
                        <a href=abmtipificacion.php><button type="submit" class="boton_fondo_corredizo_izquierda">-TIPIFICACIÓN-</button></a>
                        <a href=abmresolutor.php><button type="submit" class="boton_fondo_corredizo_izquierda">-RESOLUTOR-</button></a>
                        <a href="abmPlanesCelulares.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-PLANES CELULARES-</button></a>
                    ';
                        } ?>
                        <!-- <a href="abmequipos.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-EQUIPOS-</button></a> -->
                        
    <!--                     <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" title="Mensaje en cartel" data-bs-placement="top">Tooltip on right</button> -->

                        <!-- <a href="abmimpresoras.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-IMPRESORAS-</button></a> -->
                        <!-- <a href="abmmonitores.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-MONITORES-</button></a> -->                    

                    <?php if($row['ID_PERFIL'] == 1 OR $row['ID_PERFIL'] == 2){
                            echo'
                        <a href="abmmarcas.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-MARCAS-</button></a>
                        <a href="abmmicro.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-MICROS-</button></a>
                        <a href="abmmodelos.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-MODELOS-</button></a>
                        <a href="abmplacamadre.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-PLACA MADRE-</button></a>
                        <a href="abmplacav.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-PLACA DE VIDEO-</button></a>
                        ';
                        } ?>
                        <!-- <a href="abmusuario.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-USUARIOS-</button></a> -->
                    <!--  <a href="abmotros.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-OTROS PERIFÉRICOS-</button></a> -->
        
            </div>
        </section>
    </main> <!-- Cierra div contenido -->
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