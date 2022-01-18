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
   <style>
			body{
			background-color: #edf0f5;
			}
	</style>
   
</head>
<body>
<header class="header">
		<div class="container-fluid">
			<div class="btn-menu">
		<nav id="botonera" style="height: auto;">
			<ul class="nav">
				<li><label for="btn-menu" style="cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="60" fill="black" class="bi bi-list" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
</svg></label></li>
				</li>
				<li><a href="cargadeincidentes.php">CARGA</a>
                  
                 </li>
				<li><a href="consulta.php">CONSULTA </a></li>
				<li><a href="inventario.php">INVENTARIO </a>
					<ul id="sub">
									<li><a href="impresoras.php">-Impresoras</a></li>
									<li><a href="monitores.php">-Monitores</a></li>
						</ul>
				</li>
			</div>
			</div>
			</ul>
		</nav>
	</header>
	<input type="checkbox" id="btn-menu">
		<div class="container-menu" >
			<div class="cont-menu" style="padding: 10px">
         <nav >
					<div id="foto" style="margin-top: 21px; margin-bottom: 19px;"></div><br>			
					<h2 id="h2"><u>NOMBRE</u>: &nbsp<?php echo utf8_decode($row['RESOLUTOR']);?></h2>
					<h2 id="h2"><u>CUIL</u>: &nbsp &nbsp &nbsp &nbsp &nbsp<?php if ((isset($_SESSION['cuil'])) && ($_SESSION['cuil'] != "")){echo $_SESSION['cuil'];}?></h2><br>
					<h2 id="h2"><u>GESTIÓN: </u></h2>
					<a href="abm.php" class="color"><h2 id="h2">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp-ALTA/BAJA/MODIFICACIÓN</h2></a>
					<a href="tiporeporte.php" class="color"><h2 id="h2">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp-REPORTES</h2></a>
					<a href="contraseña.php" class="color"><h2 id="h2">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp-CAMBIAR CONTRASEÑA</h2></a><br><br><br>
					<a href="salir.php"><h2 id="h2"><u>CERRAR SESIÓN</u></h2></a>
				</nav>
				<label for="btn-menu">✖️</label>
			</div>
		</div>
	<section id="Inicio">
		<div id="titulo">
			<h1 style="margin-top:35px;">REPORTES DE INCIDENTES</h1>
       
		</div>
	

<!--Selector de filtro-->
<div id="principal"  style="width:75%; height: 150px; margin-top: 40px;" class="container-fluid">
<div id="formprin" class="form-group row" style="margin: 10px; padding:10px; padding-bottom: 30px;">
   <label id="lblForm" style="margin-top:20px; font-size:28px;"class="col-form-label col-xl col-lg">SELECCIONE EL TIPO DE REPORTE:</label>
   <select id="tipo" style="margin-top:20px;" name="tiporeporte" class="form-control col-xl col-lg" formControlName="Activo" onChange="mostrarFiltros()" required>
       <option value="0" selected disabled="tipo">-SELECCIONE UNA-</option>
       <option value="Estado">ESTADO</option>
       <option value="Tipificacion" value="Tipificacion">TIPIFICACION</option>
       <option value="Usuario" value="Usuario">USUARIO</option>
       <option value="Resolutor" value="Resolutor">RESOLUTOR</option>
</select>
</div>  
</div> 

<!--Filtros-->


<div id="repoUsuario" style="width:600px;" class="filtros container-fluid">
   <form method="POST" action="tablausuarios.php">
   <div class="form-group row " style="margin-top: 10px; margin-left: 5px; margin-right: 20px;" ><label style="font-size: 35px;" id="lblForm"class="col-form-label col-xl col-lg">USUARIOS:</label></div>
   <div class="form-group row" style="margin-top: 5px; margin-left: 5px; margin-right: 20px;">
         <label style="font-size: 30px;" id="lblForm"class="col-form-label col-xl col-lg">SELECCIONE UN PERIODO:</label>
       </div>
       <div class="form-group row" style="margin: 5px; margin-right: 20px;">
          <label style="font-size: 30px;" id="lblForm"class="col-form-label col-xl col-lg">DESDE:</label>
          <input class="col-xl col-lg form-control" style="margin-top: 10px;" type="date" name="fecha_desde" id="txtfechadesdeA" required>
       </div>
       <div class="form-group row" style="margin: 5px; margin-right: 20px;">   
          <label style="font-size: 30px;" id="lblForm"class="col-form-label col-xl col-lg">HASTA:</label>
          <input class="col-xl col-lg form-control" style="margin-top: 10px;" type="date" name="fecha_hasta" id="txtfechahastaA" required>
       </div>

       <div class="form-group row justify-content-center" style="margin: 10px; margin-top:20px; margin-right: 20px;">
          <input style="width:200px; margin-bottom:20px; margin-right: 5px;" class="col-xl-2 col-lg-2 button" type="reset" id="btnVolver4" value="VOLVER" onClick="volver()">
          <input style="width:200px; margin-left:10px; margin-bottom:20px;"class="col-xl-2 col-lg-2 button" type="submit" value="CARGAR REPORTE" class="button">
       </div>		
   </form>
</div>


<div id="reporeso" style="width: 600px;" class="filtros container-fluid">
   <div class="container-fluid">
     <form method="POST" action="tablaresolutor.php">
     <div class="form-group row " style="margin-top: 10px; margin-left: 5px; margin-right: 20px;" ><label style="font-size: 35px;" id="lblForm"class="col-form-label col-xl col-lg">RESOLUTORES:</label></div>
    <div class="form-group row" style="margin-top: 5px; margin-left: 5px; margin-right: 20px;">
         <label style="font-size: 30px;" id="lblForm"class="col-form-label col-xl col-lg">SELECCIONE UN PERIODO:</label>
     </div>
     <div class="form-group row" style="margin: 5px; margin-right: 20px;">
          <label style="font-size: 30px;" id="lblForm"class="col-form-label col-xl col-lg">DESDE:</label>
          <input class="col-xl col-lg form-control" style="margin-top: 10px;" type="date" name="fecha_desde" id="txtfechadesdeA" required>
     </div>
     <div class="form-group row" style="margin: 5px; margin-right: 20px;">     
          <label style="font-size: 30px;" id="lblForm"class="col-form-label col-xl col-lg">HASTA:</label>
          <input class="col-xl col-lg form-control" style="margin-top: 10px;" type="date" name="fecha_hasta" id="txtfechahastaA" required>
       </div>

       <div class="form-group row justify-content-center" style="margin: 10px; margin-top:20px; margin-right: 20px;">
          <input style="width:200px; margin-bottom:20px; margin-right: 5px;" class="col-xl-2 col-lg-2 button" type="reset" id="btnVolver4" value="VOLVER" onClick="volver()">
          <input style="width:200px; margin-left:10px; margin-bottom:20px;"class="col-xl-2 col-lg-2 button" type="submit" value="CARGAR REPORTE" class="button">
       </div>		
		</form>
     </div>
</div>

<div id="reportipi" class="filtros container-fluid" style="width: 600px;">
    <div class="container-fluid">
        <form method="POST" action="tablatipificacion.php">
        <div class="form-group row " style="margin-top: 10px; margin-left: 5px; margin-right: 20px;" ><label style="font-size: 35px;" id="lblForm"class="col-form-label col-xl col-lg">TIPIFICACIONES:</label></div>
       <div class="form-group row" style="margin-top: 5px; margin-left: 5px; margin-right: 20px;">
               <label style="font-size: 30px;" id="lblForm"class="col-form-label col-xl col-lg">SELECCIONE UN PERIODO:</label>
       </div>
      <div class="form-group row" style="margin: 5px; margin-right: 20px;">
          <label style="font-size: 30px;" id="lblForm"class="col-form-label col-xl col-lg">DESDE:</label>
          <input class="col-xl col-lg form-control" style="margin-top: 10px;" type="date" name="fecha_desde" id="txtfechadesdeA" required>
      </div>
      <div class="form-group row" style="margin: 5px; margin-right: 20px;">
          <label style="font-size: 30px;" id="lblForm"class="col-form-label col-xl col-lg">HASTA:</label>
          <input class="col-xl col-lg form-control" style="margin-top: 10px;" type="date" name="fecha_hasta" id="txtfechahastaA" required>
       </div>

       <div class="form-group row justify-content-center" style="margin: 10px; margin-top:20px; margin-right: 20px;">
          <input style="width:200px; margin-bottom:20px; margin-right: 5px;" class="col-xl-2 col-lg-2 button" type="reset" id="btnVolver4" value="VOLVER" onClick="volver()">
          <input style="width:200px; margin-left:10px; margin-bottom:20px;"class="col-xl-2 col-lg-2 button" type="submit" value="CARGAR REPORTE" class="button">
       </div>	
        </form>
    </div>
</div>

       

<div id="repotodos" class="container-fluid filtros" style="width: 600px;">
   
   <div>
   <form method="POST" action="tablaestados.php">
       <div class="form-group row " style="margin-top: 10px; margin-left: 5px; margin-right: 20px;" ><label style="font-size: 35px;" id="lblForm"class="col-form-label col-xl col-lg">ESTADOS:</label></div>
       <div class="form-group row" style="margin-top: 5px; margin-left: 5px; margin-right: 20px;">
          <label style="font-size: 30px;" id="lblForm"class="col-form-label col-xl col-lg">SELECCIONE UN PERIODO:</label>
       </div>
       <div class="form-group row" style="margin: 5px; margin-right: 20px;">
          <label style="font-size: 30px;" id="lblForm"class="col-form-label col-xl col-lg">DESDE:</label>
          <input class="col-xl col-lg form-control" style="margin-top: 10px;" type="date" name="fecha_desde" id="txtfechadesdeA" required>
       </div>
       <div class="form-group row" style="margin: 5px; margin-right: 20px;">   
          <label style="font-size: 30px;" id="lblForm"class="col-form-label col-xl col-lg">HASTA:</label>
          <input class="col-xl col-lg form-control" style="margin-top: 10px;" type="date" name="fecha_hasta" id="txtfechahastaA" required>
       </div>

       <div class="form-group row justify-content-center" style="margin: 10px; margin-top:20px; margin-right: 20px;">
          <input style="width:200px; margin-bottom:20px; margin-right: 5px;"class="col-xl-2 col-lg-2 button" type="reset" id="btnVolver4" value="VOLVER" onClick="volver()">
          <input style="width:200px; margin-left:10px; margin-bottom:20px;"class="col-xl-2 col-lg-2 button" type="submit" value="CARGAR REPORTE" class="button">
       </div>	
   </form>
   </div>
</div>

<script src="filtrosincidentes.js"></script>

</section>
<footer>
   <div id="volver" class="row justify-content-center " style="width:99%; position: absolute; bottom:83px; left: 10px">
			    <a id="vlv" href="tiporeporte.php" class="btn btn-primary">VOLVER</a>
		 </div><br></footer>
</body>
</html>