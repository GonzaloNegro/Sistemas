<?php 
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>CONSULTA MODELOS</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloallabm.css">
</head>
<body>
<?php
     if (!isset($_POST['buscar'])){$_POST['buscar'] = '';}
     if (!isset($_POST["tipo"])){$_POST["tipo"] = '';}
?>
    <section id="inicio">
		<div id="reporteEst">   
			<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
				<a id="vlv"  href="consultaaltas.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
                <?php if($row['ID_PERFIL'] == 1 || $row['ID_PERFIL'] == 2) 
				{ echo'<a id="agr" href="../abm/abmmodelo.php" class="btn btn-success" type="button">+</a>';
				}
				?>
			</div>					
		</div>
        <h1>CONSULTA MODELOS</h1>
		<div id="filtros">
			<div id="filtros-listado">
				<form method="POST" action="consultamodelos.php">
					
					<!-- Fila 1: Label + Input -->
					<div class="fila">
						<label class="form-label">MODELO/MARCA/TIPO</label>
						<input type="text" style="text-transform:uppercase;" name="buscar" placeholder="Buscar" class="form-control largo">
					</div>    
					
					<!-- Fila 2: Label + Select -->
					<div class="fila">
						<label class="form-label">TIPO:</label>
						<select id="tipo" name="tipo" style="text-transform:uppercase" class="form-control largo" required>
							<option selected disabled>-SELECCIONE UNA-</option>
							<?php
							include("../particular/conexion.php");
							$consulta = "SELECT * FROM tipop ORDER BY TIPO ASC";
							$ejecutar = mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
							foreach ($ejecutar as $opciones): 
							?> 
								<option value="<?php echo $opciones['ID_TIPOP']?>"><?php echo $opciones['TIPO']?></option>						
							<?php endforeach ?>
						</select>
					</div>

					<!-- Fila 3: Botones -->
					<div>
						<input class="btn btn-success" type="submit" name="btn2" value="BUSCAR" id="btnForm"></input>
						<input class="btn btn-danger"  type="submit" name="btn1" value="LIMPIAR" id="btnLimpiar"></input>
					</div>

				</form>
			</div>
		</div>
        <?php
			echo "<table class='table_id tablaLineas' id='tabla_lineas'>
					<thead>
						<tr>
							<th><p style='text-align:left;padding:5px;'>MODELO</p></th>
							<th><p style='text-align:left;padding:5px;'>MARCA</p></th>
							<th><p style='text-align:left;padding:5px;'>TIPO</p></th>
						</tr>
					</thead>
				";
				if(isset($_POST['btn2'])){
					$where = [];
					if (!empty($_POST['buscar'])) {
						$doc = $datos_base->real_escape_string($_POST['buscar']);
						$where[] = " (m.MODELO LIKE '%$doc%' OR ma.MARCA LIKE '%$doc%' OR t.TIPO LIKE '%$doc%') ";
					}
					if (!empty($_POST['tipo'])) {
						$tipo = (int)$_POST['tipo'];
						$where[] = " t.ID_TIPOP = $tipo";
					}

					// Construir consulta WHERE
					$whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
					
					$consulta_sql = "SELECT m.ID_MODELO, m.MODELO, ma.MARCA, t.TIPO
					FROM modelo m 
					LEFT JOIN marcas AS ma ON ma.ID_MARCA = m.ID_MARCA
					LEFT JOIN tipop AS t ON t.ID_TIPOP = m.ID_TIPOP
					$whereClause
					ORDER BY m.MODELO ASC";
					// $consultar=mysqli_query($datos_base, "SELECT m.ID_MODELO, m.MODELO, ma.MARCA, t.TIPO
					// FROM modelo m 
					// LEFT JOIN marcas AS ma ON ma.ID_MARCA = m.ID_MARCA
					// LEFT JOIN tipop AS t ON t.ID_TIPOP = m.ID_TIPOP
					// WHERE m.MODELO LIKE '%$doc%' OR ma.MARCA LIKE '%$doc%' OR t.TIPO LIKE '%$doc%'
					// ORDER BY m.MODELO ASC");
					$consultar=mysqli_query($datos_base, $consulta_sql);
					$cantidadTotal = 0;
					while($listar = mysqli_fetch_array($consultar)){
						$cantidadTotal++;
						echo
						"<tr>
							<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['MODELO']."</h4></td>
							<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['MARCA']."</h4></td>
							<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['TIPO']."</h4></td>
						</tr>";
					}
				}else{
					$consultar=mysqli_query($datos_base, "SELECT m.ID_MODELO, m.MODELO, ma.MARCA, t.TIPO
					FROM modelo m 
					LEFT JOIN marcas AS ma ON ma.ID_MARCA = m.ID_MARCA
					LEFT JOIN tipop AS t ON t.ID_TIPOP = m.ID_TIPOP 
					ORDER BY m.MODELO ASC");
					while($listar = mysqli_fetch_array($consultar))
					{
						echo
						" 
							<tr>
								<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['MODELO']."</h4></td>
								<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['MARCA']."</h4></td>
								<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['TIPO']."</h4></td>
							</tr>
						";
					}
				}
				if($_POST['buscar'] != "" AND $_POST['buscar'] != " " OR $_POST['tipo'] != ""){
					echo "
					<div class='filtrado'>
					<h2>Filtrado por:</h2>
						<ul>";
							if($_POST['buscar'] != "" AND $_POST['buscar'] != " "){
								$buscar = strtoupper($_POST['buscar']);
								echo "<li><u>MODELO/MARCA/TIPO</u>: ".$buscar."</li>";
							}
							if($_POST['tipo'] != ""){
								$sql = "SELECT TIPO FROM tipop WHERE ID_TIPOP = $_POST[tipo]";
								$resultado = $datos_base->query($sql);
								$row = $resultado->fetch_assoc();
								$tipo = $row['TIPO'];
								echo "<li><u>TIPO</u>: ".$tipo."</li>";
							}
							echo"
						</ul>
						<h2>Cantidad de registros: </h2>
						<ul><li>$cantidadTotal</li></ul>
					</div>";	
				}
				echo "</table>";?>
    </section>
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="../js/shortcutKeys.js"></script>
</body>
</html>