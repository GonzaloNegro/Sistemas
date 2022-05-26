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
	<title>INVENTARIO OTROS PERIFÉRICOS</title><meta charset="utf-8">
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
    <div class="container-fluid">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none"><div id="foto"></div>
          <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use> </svg>-->
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 espacio">
        <li><a href="cargadeincidentes.php" class="nav-link px-2 link-secondary link destacado">NUEVO INCIDENTE</a>
 				<ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
					<li><a class="dropdown-item" href="cargarapidaporusuario.php">CARGA RÁPIDA POR USUARIO</a></li>
<!-- 				<li><hr class="dropdown-divider"></li>
                	<li><a class="dropdown-item" href="cargarapidaportipificacion.php">CARGA RÁPIDA POR TIPIFICACIÓN</a></li> -->
                </ul>
			</li>
            <li><a href="consulta.php" class="nav-link px-2 link-dark link">CONSULTA</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="consulta.php">CONSULTA DE INCIDENTES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="consultausuario.php">CONSULTA DE USUARIOS</a></li>
                </ul>
            </li>
            <li><a href="inventario.php" class="nav-link px-2 link-dark link" style="border-left: 5px solid #53AAE0;">INVENTARIO</a>
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
			<li><a href="calen/calen.php" class="nav-link px-2 link-dark link"><i class="bi bi-calendar3"></i></a>
            <li class="ubicacion link"><a href="bienvenida.php"><i class="bi bi-info-circle"></i></a></li>
        </ul>
        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false"><h5><i class="bi bi-person rounded-circle"></i><?php echo utf8_decode($row['RESOLUTOR']);?></h5></a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
            <?php if($row['ID_RESOLUTOR'] == 6)
            { echo '
		  	<li><a class="dropdown-item" href="agregados.php">CAMBIOS AGREGADOS</a></li>
            <li><hr class="dropdown-divider"></li>';}?>
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
			<h1>INVENTARIO OTROS PERIFÉRICOS</h1>
		</div>
		<div id="filtro" class="container-fluid">
			<form method="POST" action="otrosp.php">
			<div class="form-group row">
				<input type="text" style="margin-left: 10px; width: 70%; height: 40px; margin-top: 12px; 	box-sizing: border-box; border-radius: 10px; text-transform:uppercase;" name="buscar"  placeholder="Buscar"  class="form-control largo col-xl-4 col-lg-4">

				<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn2" value="BUSCAR"></input>
				<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn1" value="LIMPIAR"></input>
				</div>
			</form>
		</div>
        <div id="mostrar_inventario" class="container-fluid">
			<?php
				echo "<table width=100%>
                <thead>
                    <tr>
                        <th><p>MODELO</p></th>
                        <th><p>USUARIO</p></th>
                        <th><p>ÁREA</p></th>
                        <th><p>SERIEG</p></th>
                        <th><p>TIPO</p></th>
                        <th><p>MARCA</p></th>
                        <th><p>MAS DETALLES</p></th>
                    </tr>
                </thead>
					";
					if(isset($_POST['btn2']))
                    {
                        $doc = $_POST['buscar'];
                        $contador = 0;
                        $consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, p.TIPOP		
                        FROM periferico p 
                        LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
                        LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
                        LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
                        LEFT JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
                        LEFT JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP
                        WHERE (p.TIPOP  LIKE '%SCANNER%' OR p.TIPOP  LIKE '%CAMARA%' OR p.TIPOP LIKE '%TICKEADORA%' OR p.TIPOP LIKE '%TELEFONO%')
                        /* WHERE p.ID_TIPOP = 9 OR p.ID_TIPOP = 6 OR p.ID_TIPOP = 5 OR p.ID_TIPOP = 11 OR p.ID_TIPOP = 12 */
                        AND (a.AREA LIKE '%$doc%'
									OR u.NOMBRE LIKE '%$doc%'
									OR p.SERIEG LIKE '%$doc%'
									OR mo.MODELO LIKE '%$doc%'
									OR t.TIPO LIKE '%$doc%'
									OR m.MARCA LIKE '%$doc%')
                        ORDER BY p.NOMBREP ASC");
                        while($listar = mysqli_fetch_array($consultar))
                            {
                                echo
                                " 
                                    <tr>
                                        <td><h4 style='font-size:16px;'>".$listar['MODELO']."</h4></td>
                                        <td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
                                        <td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
                                        <td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
                                        <td><h4 style='font-size:16px;'>".$listar['TIPO']."</h4></td>
                                        <td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
                                        <td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalleotros.php?no=".$listar['ID_PERI']." target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
                                        <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                                        <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/></svg></a></td>
                                    </tr>
										";
										$contador = $contador + 1;
									}
					}
				    else
				    {
                        $contador = 0;
                        $consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, p.TIPOP			
                        FROM periferico p 
                        LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
                        LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
                        LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
                        LEFT JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
                        LEFT JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
                        WHERE (p.TIPOP  LIKE '%SCANNER%' OR p.TIPOP  LIKE '%CAMARA%' OR p.TIPOP LIKE '%TICKEADORA%' OR p.TIPOP LIKE '%TELEFONO%')
                        /* WHERE p.ID_TIPOP = 9 OR p.ID_TIPOP = 6 OR p.ID_TIPOP = 5 OR p.ID_TIPOP = 11 OR p.ID_TIPOP = 12 */
                        ORDER BY p.NOMBREP ASC");
                            while($listar = mysqli_fetch_array($consultar))
                            {
                                echo
                                " 
                                    <tr>
                                        <td><h4 style='font-size:16px;'>".$listar['MODELO']."</h4></td>
                                        <td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
                                        <td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
                                        <td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
                                        <td><h4 style='font-size:16px;'>".$listar['TIPO']."</h4></td>
                                        <td><h4 style='font-size:16px;'>".$listar['MARCA']."</h4></td>
                                        <td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalleotros.php?no=".$listar['ID_PERI']." target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
                                        <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                                        <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/></svg></a></td>
                                    </tr>";
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
                <p>CANTIDAD DE PERIFÉRICOS: $contador </p>
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