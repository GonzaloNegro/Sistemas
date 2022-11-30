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
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();

$cu = $row['CUIL'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>CONSULTA USUARIOS</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoObrasPúblicas.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
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
		<li><a href="../carga/cargadeincidentes.php" class="nav-link px-2 link-secondary link destacado" 
			style="border-left: 5px solid #53AAE0;">NUEVO INCIDENTE</a>
 				<ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
					<li><a class="dropdown-item" href="../carga/cargarapidaporusuario.php">CARGA RÁPIDA POR USUARIO</a></li>
 				    <li><hr class="dropdown-divider"></li>
                	<li><a class="dropdown-item" href="../carga/cargarapidaportipificacion.php">CARGA RÁPIDA POR TIPIFICACIÓN</a></li>
                </ul>
			</li>
            <li><a href="consulta.php" class="nav-link px-2 link-dark link" style="border-left: 5px solid #53AAE0;">CONSULTA</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="consulta.php">CONSULTA DE INCIDENTES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="consultausuario.php">CONSULTA DE USUARIOS</a></li>
					<li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="consultaaltas.php">CONSULTA PARA ALTAS</a></li>
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
            <li><a href="../abm/abm.php" class="nav-link px-2 link-dark link">ABM</a></li>
            <li><a href="../reportes/tiporeporte.php" class="nav-link px-2 link-dark link">REPORTES</a></li>
			<?php if($row['ID_PERFIL'] == 1 OR $row['ID_PERFIL'] == 2){
                        echo'
						<li><a href="../particular/estadisticas.php" class="nav-link px-2 link-dark link">ESTADISTICAS</a></li>
                    ';
					} ?>
			<li><a href="../stock/stock.php" class="nav-link px-2 link-dark link">STOCK</a></li>
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
			<h1>CONSULTA DE USUARIOS</h1>
		</div>
		<div id="filtro" class="container-fluid">
            <form method="POST" action="consultausuario.php">
                    <div class="form-group row">
                        <input type="text" style="margin-left: 10px; width: 65%; height: 40px; margin-top: 12px; margin-left: 10px;	box-sizing: border-box; border-radius: 10px; text-transform:uppercase;" name="buscar"  placeholder="Buscar" class="form-control largo col-xl-4 col-lg-4">

                        <input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn2" value="BUSCAR"></input>

                        <input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn1" value="LIMPIAR"></input>
                    </div>
            </form>
        </div>
        <div id="mostrar_incidentes">
            <?php
                    echo "<table>
                            <thead>
                                <tr>
                                    <th><p>USUARIO</p></th>
                                    <th><p>CUIL</p></th>
                                    <th><p>ÁREA</p></th>
                                    <th><p>REPARTICIÓN</p></th>
                                    <th><p>INTERNO</p></th>
                                    <th><p>ESTADO</p></th>
                                </tr>
                            </thead>
                        ";
                        if(isset($_POST['btn2']))
                        {
                            $doc = $_POST['buscar'];
                            $consulta=mysqli_query($datos_base, "SELECT u.ID_USUARIO, u.NOMBRE, u.CUIL, a.AREA, u.INTERNO, u.ACTIVO, r.REPA
                            FROM usuarios u
                            LEFT JOIN area a ON u.ID_AREA = a.ID_AREA
                            LEFT JOIN reparticion r ON r.ID_REPA = a.ID_REPA
                            WHERE u.NOMBRE LIKE '%$doc%' OR u.CUIL LIKE '%$doc%' OR a.AREA LIKE '%$doc%' OR u.INTERNO LIKE '%$doc%' OR u.ACTIVO LIKE '%$doc%' OR r.REPA LIKE '%$doc%'
                            ORDER BY u.NOMBRE ASC");
                            while($listar = mysqli_fetch_array($consulta))
                            {
                            echo
                                "
                                <tr>
                                <td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4 ></td>
                                <td><h4 style='font-size:16px;'>".$listar['CUIL']."</h4 ></td>
                                <td><h4 style='font-size:16px;'>".$listar['AREA']."</h4 ></td>
                                <td><h4 style='font-size:14px;'>".$listar['REPA']."</h4 ></td>
                                <td><h4 style='font-size:14px;'>".$listar['INTERNO']."</h4 ></td>
                                <td><h4 style='font-size:16px;'>".$listar['ACTIVO']."</h4 ></td>
                                </tr>";
                            }
                        }
                        
                        else
                        {
                            $consulta=mysqli_query($datos_base, "SELECT u.ID_USUARIO, u.NOMBRE, u.CUIL, a.AREA, u.INTERNO, u.ACTIVO, r.REPA
                            FROM usuarios u
                            LEFT JOIN area a ON  u.ID_AREA = a.ID_AREA
                            LEFT JOIN reparticion r ON r.ID_REPA = a.ID_REPA
                            ORDER BY u.NOMBRE ASC");
                            while($listar = mysqli_fetch_array($consulta)) 
                            {
                            echo
                                " 
                                <tr>
                                <td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4 ></td>
                                <td><h4 style='font-size:16px;'>".$listar['CUIL']."</h4 ></td>
                                <td><h4 style='font-size:16px;'>".$listar['AREA']."</h4 ></td>
                                <td><h4 style='font-size:14px;'>".$listar['REPA']."</h4 ></td>
                                <td><h4 style='font-size:14px;'>".$listar['INTERNO']."</h4 ></td>
                                <td><h4 style='font-size:16px;'>".$listar['ACTIVO']."</h4 ></td>
                                </tr>";
                            }
                        }
                        echo "</table>";
            ?>
        </div>
    </section>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
  		AOS.init();
	</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
		const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
		const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
	</script>
	<script src="../js/script.js"></script>
</body>
</html>