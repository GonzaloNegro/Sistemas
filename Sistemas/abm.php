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
	<title>ALTA BAJA MODIFICACIÓN</title>
	<link href="estiloabm.css" rel="stylesheet" type="text/css" />
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
   <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="jquery/1/jquery-ui.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <style>
			body{
			background-color: #edf0f5;
			}
	</style>
   
</head>
<body>
	<section id="Inicio">
		<div id="titulo">
			<h1 style="margin-top:35px;">ALTA - BAJA - MODIFICACIÓN</h1>
		</div>
        <div id="principal">
             <div id=izq>
                 <h2>INCIDENTES</h2>
                 <a href="agregararea.php"><input type="button" class="button but1" value="ABM ÁREA"></a>
                 <a href="agregarresolutor.php"><input type="button" class="button but1" value="ABM RESOLUTOR"></a>
                 <a href="agregartipificacion.php"><input type="button" class="button but1" value="ABM TIPIFICACIÓN"></a>
                 <a href="agregarusuario.php"><input type="button" class="button but1" value="ABM USUARIO"></a>
                 </div>
             <div id=der>
                <h2>INVENTARIO</h2>
                 <a href="#"><input type="button" class="button but2" value="ABM EQUIPOS"></a>
                 <a href="#"><input type="button" class="button but2" value="ABM IMPRESORAS"></a>
                 <a href="#"><input type="button" class="button but2" value="ABM MONITORES"></a>
                </div>
        </div>
         <div id="volver" >
			    <a id="vlv" href="cargadeincidentes.php" class="btn btn-primary">VOLVER</a>
		 </div><br>
    </section>
</body>
</html> 