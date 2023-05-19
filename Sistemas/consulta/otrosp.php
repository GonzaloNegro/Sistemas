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
?>
<!DOCTYPE html>
<html>
<head>
	<title>INVENTARIO EQUIPOS</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoObrasPúblicas.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymus"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<?php
    if (!isset($_POST['buscar'])){$_POST['buscar'] = '';}
    if (!isset($_POST['area'])){$_POST['area'] = '';}
    if (!isset($_POST["orden"])){$_POST["orden"] = '';}
    if (!isset($_POST['tipows'])){$_POST['tipows'] = '';}
    if (!isset($_POST["marca"])){$_POST["marca"] = '';}
    if (!isset($_POST["tipo"])){$_POST["tipo"] = '';}
?>
<header class="p-3 mb-3 border-bottom altura">
    <div class="container-fluid">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none"><div id="foto"></div>
          <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use> </svg>-->
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 espacio">
		<li><a href="../carga/cargadeincidentes.php" class="nav-link px-2 link-secondary link destacado">NUEVO INCIDENTE</a>
 				<ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
					<li><a class="dropdown-item" href="../carga/cargarapidaporusuario.php">CARGA RÁPIDA POR USUARIO</a></li>
	 				<li><hr class="dropdown-divider"></li>
                	<li><a class="dropdown-item" href="../carga/cargarapidaportipificacion.php">CARGA RÁPIDA POR TIPIFICACIÓN</a></li>
                </ul>
			</li>
			<li><a href="consulta.php" class="nav-link px-2 link-dark link">CONSULTA</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="consulta.php">CONSULTA DE INCIDENTES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="consultausuario.php">CONSULTA DE USUARIOS</a></li>
					<li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="consultaaltas.php">CONSULTA PARA ALTAS</a></li>
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
            <li><a href="#" class="nav-link px-2 link-dark link">GESTIÓN</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a href="../abm/abm.php" class="dropdown-item">ABM</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="../reportes/tiporeporte.php" class="dropdown-item">REPORTES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <?php if($row['ID_PERFIL'] == 1 OR $row['ID_PERFIL'] == 2){
                                echo'
                                <li><a href="../particular/estadisticas.php" class="dropdown-item">ESTADISTICAS</a></li>
                            ';
                            } 
                            ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="../stock/stock.php" class="dropdown-item">STOCK</a></li>
                </ul>
            </li>
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
 <section id="consulta">
		<div id="titulo">
			<h1>INVENTARIO OTROS PERIFÉRICOS</h1>
		</div>
        <form method="POST" action="./otrosp.php" class="contFilter--name">
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">Usuario/Modelo/Serieg</label>
                        <input type="text" style="text-transform:uppercase;" name="buscar"  placeholder="Buscar" class="form-control largo">
                    </div>
                    <div>
                        <label class="form-label">Área</label>
                        <select id="subject-filter" id="area" name="area" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM area ORDER BY AREA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_AREA']?>"><?php echo $opciones['AREA']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Orden</label>
                        <select id="assigned-tutor-filter" id="orden" name="orden" class="form-control largo">
                            <?php if ($_POST["orden"] != ''){ ?>
                                <option value="<?php echo $_POST["orden"]; ?>">
                                    <?php 
                            if ($_POST["orden"] == '1'){echo 'ORDENAR POR USUARIO';} 
                            if ($_POST["orden"] == '2'){echo 'ORDENAR POR AREA';} 
                            if ($_POST["orden"] == '3'){echo 'ORDENAR POR MARCA';}
                            if ($_POST["orden"] == '4'){echo 'ORDENAR POR TIPO';} 
                            ?>
                            </option>
                            <?php } ?>
                            <option value="">SIN ORDEN</option>
                            <option value="1">ORDENAR POR USUARIO</option>
                            <option value="2">ORDENAR POR AREA</option>
                            <option value="3">ORDENAR POR MARCA</option>
                            <option value="4">ORDENAR POR TIPO</option>
                        </select>
                    </div>
                </div>
                    
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">Marca</label>
                        <select id="subject-filter" id="marca" name="marca" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_MARCA']?>"><?php echo $opciones['MARCA']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Tipo</label>
                        <select id="subject-filter" id="tipo" name="tipo" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM tipop WHERE ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12 ORDER BY TIPO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_TIPOP']?>"><?php echo $opciones['TIPO']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div class="export">
                        <button type="submit" form="formu" style="border:none; background-color:transparent;"><i class="fa-solid fa-file-excel fa-2x" style="color: #1f5120;"></i>&nbspCSV</button>
                        <input type="submit" class="btn btn-success" name="busqueda" value="Buscar">
                    </div>
                </div>
            </div>
        <?php 

        if ($_POST['buscar'] == ''){ $_POST['buscar'] = ' ';}
        $aKeyword = explode(" ", $_POST['buscar']);

        if ($_POST["buscar"] == '' AND $_POST['ID_MARCA'] == '' AND $_POST['ID_AREA'] == '' AND $_POST['ID_TIPOP'] == ''){ 
                $query ="SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, p.TIPOP			
                FROM periferico p 
                LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
                LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
                LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
                LEFT JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
                LEFT JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP  ";
        }elseif(isset($_POST['busqueda'])){
                $query = "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, p.TIPOP			
                FROM periferico p 
                LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
                LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
                LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
                LEFT JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
                LEFT JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP   ";

                if ($_POST["buscar"] != '' ){ 
                        $query .= " WHERE (t.ID_TIPOP = 5 OR t.ID_TIPOP = 6 OR t.ID_TIPOP = 9 OR t.ID_TIPOP = 11 OR t.ID_TIPOP = 12) AND (u.NOMBRE LIKE LOWER('%".$aKeyword[0]."%') OR p.SERIEG LIKE LOWER('%".$aKeyword[0]."%') OR mo.MODELO LIKE LOWER('%".$aKeyword[0]."%')) ";
                
                    for($i = 1; $i < count($aKeyword); $i++) {
                    if(!empty($aKeyword[$i])) {
                        $query .= " OR u.NOMBRE LIKE '%" . $aKeyword[$i] . "%' OR p.SERIEG LIKE '%" . $aKeyword[$i] . "%' ";
                    }
                    }

                }
            
        if ($_POST["marca"] != '' ){
            $query .= " AND m.ID_MARCA = '".$_POST["marca"]."' ";
        }
        if ($_POST["area"] != '' ){
            $query .= " AND a.ID_AREA = '".$_POST["area"]."' ";
        }
        if ($_POST["tipo"] != '' ){
            $query .= " AND t.ID_TIPOP = '".$_POST["tipo"]."' ";
        }


         if ($_POST["orden"] == '1' ){
                    $query .= " ORDER BY u.NOMBRE ASC ";
         }

         if ($_POST["orden"] == '2' ){
                $query .= " ORDER BY a.AREA ASC ";
         }

         if ($_POST["orden"] == '3' ){
                $query .= "  ORDER BY m.MARCA ASC ";
         }

        if ($_POST["orden"] == '6' ){
                $query .= "  ORDER BY t.TIPO ASC ";
        }

}else{
    $query ="SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, p.TIPOP			
    FROM periferico p 
    LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
    LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
    LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
    LEFT JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
    LEFT JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
    WHERE (t.ID_TIPOP = 5 OR t.ID_TIPOP = 6 OR t.ID_TIPOP = 9 OR t.ID_TIPOP = 11 OR t.ID_TIPOP = 12) ORDER BY p.NOMBREP ASC";
}

/*         $consulta=mysqli_query($datos_base, $query); */
         $sql = $datos_base->query($query);

         $numeroSql = mysqli_num_rows($sql);

        ?>
<!--         <div class="contResult">
            <p style="font-weight: bold; color:#53AAE0;"><i class="mdi mdi-file-document"></i> <?php echo $numeroSql; ?> Resultados encontrados</p>
        </div> -->
        <div class="principal-info">
            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $total = $row6['total'];
            ?>
            <div class="col-md-3">
                <div class="card-counter primary">
                    <div class="card-pri">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <span class="count-numbers"><?php echo $total;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Periféricos Registrados</span>
                    </div>
                </div>
            </div>

            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE ID_ESTADOWS = 1 AND (ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12)";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $activo = $row6['total'];
            ?>
            <div class="col-md-3">
                <div class="card-counter success">
                    <div class="card-pri">
                        <i class="fa-sharp fa-solid fa-arrow-up"></i>
                        <span class="count-numbers"><?php echo $activo;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Periféricos Activos</span>
                    </div>
                </div>
            </div>


            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE ID_ESTADOWS = 2 AND (ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12)";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $inactivos = $row6['total'];
            ?>
            <div class="col-md-3">
                <div class="card-counter danger">
                    <div class="card-pri">
                        <i class="fa-sharp fa-solid fa-arrow-down"></i>
                        <span class="count-numbers"><?php echo $inactivos;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Periféricos Inactivos</span>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <table class="table_id" style="width: 98%; margin: 0 auto;">
        <thead>
            <tr>
                <th><p style="text-align:left; margin-left: 5px;">MODELO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">USUARIO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">ÁREA</p></th>
                <th><p style="text-align:left; margin-left: 5px;">SERIEG</p></th>
                <th><p style="text-align:left; margin-left: 5px;">TIPO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">MARCA</p></th>
                <th><p>MAS DETALLES</p></th>
            </tr>
        </thead>

        <?php $cantidadTotal = 0;?>
        <?php While($rowSql = $sql->fetch_assoc()) {
            $cantidadTotal++;
            echo "
                <tr>
                    <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['MODELO']."</h4></td>
                    <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['NOMBRE']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:14px; text-align: left; margin-left: 5px;'>".$rowSql['AREA']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['SERIEG']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['TIPO']."</h4></td>
                    <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['MARCA']."</h4></td>
                    <td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalleotros.php?no=".$rowSql['ID_PERI']." target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
                    <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                    <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/></svg></a></td>
                </tr>
            ";
        }
        if($_POST['buscar'] != "" AND $_POST['buscar'] != " " OR $_POST['area'] != "" OR $_POST['marca'] != "" OR $_POST['tipo'] != ""){
            echo "
            <div class=filtrado>
            <h2>Filtrado por:</h2>
                <ul>";
                    if($_POST['buscar'] != "" AND $_POST['buscar'] != " "){
                        echo "<li><u>USUARIO/MODELO/SERIEG</u>: ".$_POST['buscar']."</li>";
                    }
                    if($_POST['area'] != ""){
                        $sql = "SELECT AREA FROM area WHERE ID_AREA = $_POST[area]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $area = $row['AREA'];
                        echo "<li><u>ÁREA</u>: ".$area."</li>";
                    }
                    if($_POST['marca'] != ""){
                        $sql = "SELECT MARCA FROM marcas WHERE ID_MARCA = $_POST[marca]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $marca = $row['MARCA'];
                        echo "<li><u>MARCA</u>: ".$marca."</li>";
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
            </div>
            ";
                }
        echo '</table>';
        ?>
		</div>
        <form id="formu" action="../exportar/ExcelOtrosPeri.php" method="POST">
            <input type="text" id="excel" name="sql" class="valorPeque" readonly="readonly" value="<?php echo $query;?>">
        </form>
	</section>
	<footer></footer>
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