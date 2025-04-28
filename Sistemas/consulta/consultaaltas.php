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
<?php
if($row['ID_PERFIL'] == 5) 
{       
    header('Location: ../consulta/consulta.php'); 
    exit();
};
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>CONSULTA PARA ALTAS</title>
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="jquery/1/jquery-ui.js"></script>
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
    <main>
        <?php include('../layout/consulta.php'); ?>
        <h1 data-aos="zoom-in">CONSULTA PARA ALTAS</h1>
        <section id="Inicio">
            <div id="principal1">
                <a href="consultamarcas.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-MARCAS-</button></a>
                <a href="consultamicros.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-MICROS-</button></a>
                <a href="consultamodelos.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-MODELOS-</button></a>
                <a href="consultapmadre.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-PLACA MADRE-</button></a>
                <a href="consultapvideo.php"><button type="submit" class="boton_fondo_corredizo_izquierda">-PLACA DE VIDEO-</button></a>     
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