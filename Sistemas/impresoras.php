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
	<title>Inventario</title><meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloimpresoras.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
		<nav id="botonera">
			<ul class="nav">
				<li><label for="btn-menu" style="cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="60" fill="black" class="bi bi-list" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
				</svg></label></li>
				</li>
				<li><a href="cargadeincidentes.php">CARGA</a>
				        <!--<ul id="sub">
                                        <li><a href="cargarapidaporusuario.php">-Carga rápida por usuario</a></li>
										<li><a href="#.php">-Carga rápida por tipificación</a></li>
                        </ul>-->
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
		<div class="container-menu">
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
		<style>
			#h2{
	              text-align: left;	
	              font-family: TrasandinaBook;
	              font-size: 16px;
	              color: #edf0f5;
	              margin-left: 10px;
	              margin-top: 5px;;
               
				}
        </style>
        <section id="inventario">
        <div id="titulo">
			<h1>INVENTARIO IMPRESORAS</h1>
		</div>
		<div id="filtro" class="container-fluid">
			<form method="POST" action="impresoras.php">
			<div class="form-group row">
					<input type="text" style="margin-left: 10px; width: 60%; height: 50px; margin-top: 12px;"  name="buscar"  placeholder="Buscar"  class="form-control largo col-xl-4 col-lg-4">
					<input type="submit" value="VER" name="btn2" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;">
					<input type="submit" value="LIMPIAR" name="btn1" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;">
				</div>
			</form>
		</div>
        <div id="mostrar_inventario">
			<?php
				echo "<table width=100%>
						<thead>
							<tr>
								<th><p>IMPRESORA</p></th>
								<th><p>USUARIO</p></th>
								<th><p>ÁREA</p></th>
                                <th><p>N° WS</p></th>
								<th><p>TIPO</p></th>
                                <th><p>MARCA</p></th>
								<th><p>MAS DETALLES</p></th>
							</tr>
						</thead>
					";
					if(isset($_POST['btn2'])){
						$doc = $_POST['buscar'];
						$contador = 0;
						$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA			
								FROM periferico p 
										LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
										LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
										INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
										INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
										WHERE p.TIPOP LIKE '%IMPRESORA%'
										AND u.NOMBRE LIKE '%$doc%' 
										OR t.TIPO LIKE '%$doc%' 
										OR p.NOMBREP LIKE '%$doc%' 
										OR m.MARCA LIKE '%$doc%'  
										OR p.SERIEG LIKE '%$doc%'
										OR a.AREA LIKE '%$doc%'
								ORDER BY u.NOMBRE ASC");
									while($listar = mysqli_fetch_array($consultar))
									{
										echo
										" 
											<tr>
											<td><h4 style='font-size:16px;'>".$listar['NOMBREP']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['TIPO']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
											<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalleimp.php?no=".$listar['ID_PERI']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
											<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
											<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
										  </svg></a></td>
											</tr>
										";$contador = $contador + 1;
									}
							}
							else
							{
								$contador = 0;
								$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, p.NOMBREP, t.TIPO, m.MARCA			
										FROM periferico p 
										LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
										LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
										INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
										INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
										WHERE p.TIPOP LIKE '%IMPRESORA%'
										ORDER BY u.NOMBRE ASC");
											while($listar = mysqli_fetch_array($consultar))
											{
												echo
												" 
													<tr>
													<td><h4 style='font-size:16px;'>".$listar['NOMBREP']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['TIPO']."</h4></td>
													<td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
														<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalleimp.php?no=".$listar['ID_PERI']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
														<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
														<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/></svg></a></td>
													</tr>
												";$contador = $contador + 1;
											}
									}
								echo "<div id=contador>
							<p>CANTIDAD DE IMPRESORAS: $contador </p>
						</div>
				</table>";
					?>
        </section>
</body>
</html>