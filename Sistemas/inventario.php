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
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>INVENTARIO EQUIPOS</title><meta charset="utf-8">
	<link rel="icon" href="imagenes/logoObrasPúblicas.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="estiloconsulta.css">
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
        <section id="consulta">
        <div id="titulo" data-aos="zoom-in">
			<h1>INVENTARIO EQUIPOS</h1>
		</div>
		<div id="filtro" class="container-fluid">
			<form method="POST" action="inventario.php">
			<div class="form-group row">
				<input type="text" style="margin-left: 10px; width: 70%; height: 40px; margin-top: 12px; 	box-sizing: border-box; border-radius: 10px; text-transform:uppercase;" name="buscar"  placeholder="Buscar"  class="form-control largo col-xl-4 col-lg-4">

				<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn2" value="BUSCAR"></input>
				<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn1" value="LIMPIAR"></input>
					<!-- <input type="text" style="margin-left: 10px; width: 60%; height: 50px; margin-top: 12px;"  name="buscar"  placeholder="Buscar"  class="form-control largo col-xl-4 col-lg-4">
					<input type="submit" value="VER" name="btn2" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;">
					<input type="submit" value="LIMPIAR" name="btn1" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;"> -->
				</div>
			</form>
		</div>
        <div id="mostrar_inventario" class="container-fluid">
			<?php
				echo "<table width=100%>
						<thead>
							<tr>
								<th><p>REPARTICIÓN</p></th>
								<th><p>ÁREA</p></th>
								<th><p>USUARIO</p></th>
								<th><p>N° WS</p></th>
                                <th><p>S.O.</p></th>
                                <th><p>MICRO</p></th>
								<th><p>MAS DETALLES</p></th>
							</tr>
						</thead>
					";
					if(isset($_POST['btn2'])){
						$doc = $_POST['buscar'];
						$contador = 0;
						$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, i.MOTHERBOARD, s.SIST_OP, i.MICRO
								FROM inventario i 
								LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
								LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
								LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA 
								INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
								WHERE 
								a.AREA LIKE '%$doc%' 
								OR u.NOMBRE LIKE '%$doc%' 
								OR i.SERIEG LIKE '%$doc%' 
								OR r.REPA LIKE '%$doc%'  
								OR s.SIST_OP LIKE '%$doc%'
								OR i.MICRO LIKE '%$doc%'
								ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
									while($listar = mysqli_fetch_array($consultar))
									{
										$NUMERO=$listar['SERIEG'];
										echo
										" 
											<tr>
											<td><h4 style='font-size:14px;'>".$listar['REPA']."</h4></td>
											<td><h4 style='font-size:14px;'>".$listar['AREA']."</h4></td>
											<td><h4 style='font-size:14px;'>".$listar['NOMBRE']."</h4></td>
											<td><h4 style='font-size:14px;'>".$listar['SERIEG']."</h4></td>
											<td><h4 style='font-size:14px;'>".$listar['SIST_OP']."</h4></td>
											<td><h4 style='font-size:14px;'>".$listar['MICRO']."</h4></td>
											<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalleinv.php?no=".$listar['ID_WS']." target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
										<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
										<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
									  </svg></a>
									  <a class='btn btn-sm btn-outline-danger' href=equipos/$NUMERO.pdf target=new><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-filetype-pdf' viewBox='0 0 16 16'>
									  <path fill-rule='evenodd' d='M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z'/>
									</svg></a>
									</td>
											</tr>
										";
										$contador = $contador + 1;
									}
					}
					else
					{
					$contador = 0;
					$consultar=mysqli_query($datos_base, "SELECT i.ID_WS, a.AREA, r.REPA, u.NOMBRE, i.SERIEG, i.MOTHERBOARD, s.SIST_OP, i.MICRO
								FROM inventario i 
								LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
								LEFT JOIN area AS a ON a.ID_AREA = i.ID_AREA
								LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
								INNER JOIN so AS s ON s.ID_SO = i.ID_SO 
								ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC");
									while($listar = mysqli_fetch_array($consultar))
									{
										$NUMERO=$listar['SERIEG'];
										echo
										" 
											<tr>
											<td><h4 style='font-size:14px;'>".$listar['REPA']."</h4></td>
											<td><h4 style='font-size:14px;'>".$listar['AREA']."</h4></td>
											<td><h4 style='font-size:14px;'>".$listar['NOMBRE']."</h4></td>
											<td><h4 style='font-size:14px;'>".$listar['SERIEG']."</h4></td>
											<td><h4 style='font-size:14px;'>".$listar['SIST_OP']."</h4></td>
											<td><h4 style='font-size:14px;'>".$listar['MICRO']."</h4></td>
											<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalleinv.php?no=".$listar['ID_WS']." target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
										<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
										<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
									  </svg></a>
									  <a class='btn btn-sm btn-outline-danger' href=equipos/$NUMERO.pdf target=new><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-filetype-pdf' viewBox='0 0 16 16'>
									  <path fill-rule='evenodd' d='M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z'/>
									</svg></a>
									</td>
									
											</tr>
										";
										$contador = $contador + 1;
									}
								}
									echo "<div id=contador>";
									if(isset($_POST['buscar'])){
										$filtro = $_POST['buscar'];
										if($filtro != ""){
											$filtro = strtoupper($filtro);
											echo "<p>FILTRADO POR: $filtro</p>";
										}
									}
									echo"
								<p>CANTIDAD DE EQUIPOS: $contador </p>
							</div>
					</table>";
					?>
        </section>
		<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
  		AOS.init();
	</script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>