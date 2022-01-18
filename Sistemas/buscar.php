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
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Consulta de incidentes</title><meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloconsulta.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
	<header class="header">
		<div class="container">
			<div class="btn-menu">
		<nav id="botonera">
			<ul class="nav">
				<li><label for="btn-menu" style="cursor: pointer;"><img src="iconos/menu.png"></label></li>
				</li>
				<li><a href="cargadeincidentes.php">CARGA</a></li>
				<li><a href="consulta.php">CONSULTA </a></li>
			</div>
			</div>
			</ul>
		</nav>
	</header>
	<input type="checkbox" id="btn-menu">
		<div class="container-menu">
			<div class="cont-menu">
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

	<section id="consulta">
		<div id="titulo">
			<h1>CONSULTA DE INCIDENTES</h1>
		</div>
		<div id="filtro">

            <?php
            $busqueda = $_POST['buscar']
            ?>

			<form method="POST" action="buscar.php">
				<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" required class="largo">
				<input type="submit" value="Ver" class="button">
			</form>
		</div>
		<div id="mostrar_incidentes">
			<table>
				<thead>
					<tr>
						<th class="izquierda"><p>ID</p></th>
						<th><p>FECHA INICIO</p></th>
						<th><p>USUARIO</p></th>
						<th><p>DESCRIPCIÓN</p></th>
						<th><p>PRIORIDAD</p></th>
						<th><p>ESTADO</p></th>
						<th><p>N° EQUIPO</p></th>
						<th><p>FECHA DE SOLUCIÓN</p></th>
						<th class="derecha"><p>RESOLUTOR</p></th>
					</tr>
				</thead>

			<?php
                                
                                $sql_registe = mysqli_query("SELECT FROM * ticket
                                WHERE
                                (
                                ID_TICKET LIKE '%$busqueda%' OR
                                DESCRIPCION LIKE '%$busqueda%' OR
                                FECHA_INICIO LIKE '%$busqueda%' OR
                                USUARIO LIKE '%$busqueda%' OR
                                FECHA_SOLUCION LIKE '%$busqueda%' OR
                                NRO_EQUIPO LIKE '%$busqueda%'
                                )");
                                $numerosql = mysqli_num_rows($sql_registe);

                   while($rows = mysqli_fetch_assoc($sql_registe)){
			?>
				<tr>
					<td><h4><?php echo $data['ID_TICKET'];?></h4></td>
					<td><h4><?php echo $data['FECHA_INICIO'];?></h4></td>
					<td><h4><?php echo $data['USUARIO'];?></h4></td>
					<td><h4><?php echo $data['DESCRIPCION'];?></h4></td>
					<td><h4><?php echo $data['ID_PRIORIDAD'];?></h4></td>
					<td><h4><?php echo $data['ID_ESTADO'];?></h4></td>
					<td><h4><?php echo $data['NRO_EQUIPO'];?></h4></td>
					<td><h4><?php echo $data['FECHA_SOLUCION'];?></h4></td>
					<td><h4><?php echo $data['ID_RESOLUTOR'];?></h4></td>
				</tr>						
		<?php }?>
			</table>
		</div>
	</section>
	<footer></footer>
</body>
</html>