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
	<title>CONSULTA</title>
	<meta charset="utf-8">
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
        if (!isset($_POST['usuario'])){$_POST['usuario'] = '';}
        if (!isset($_POST['resolutor'])){$_POST['resolutor'] = '';}
        if (!isset($_POST["estado"])){$_POST["estado"] = '';}
        if (!isset($_POST['buscafechadesde'])){$_POST['buscafechadesde'] = '';}
        if (!isset($_POST['buscafechahasta'])){$_POST['buscafechahasta'] = '';}
        if (!isset($_POST["orden"])){$_POST["orden"] = '';}
    ?>
<header class="p-3 mb-3 border-bottom altura">
    <div class="container-fluid">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none"><div id="foto"></div>
          <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use> </svg>-->
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
		<li><a href="../carga/cargadeincidentes.php" class="nav-link px-2 link-secondary link destacado">NUEVO INCIDENTE</a>
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
		<div id="titulo">
			<h1>CONSULTA DE INCIDENTES</h1>
		</div>
        <form method="POST" action="./consulta.php" class="contFilter--name">
            <div class="filtros-listado">
                <div>
                    <label class="form-label">Descripción</label>
                    <input type="text" style="text-transform:uppercase;" name="buscar"  placeholder="Buscar" class="form-control largo">
                </div>
                <div>
                    <label class="form-label">Período</label>
                    <div class="fechas">
                        <div>
                            <input type="date" id="buscafechadesde" name="buscafechadesde" class="form-control largo" >
                        </div>
                        <div>
                            <input type="date" id="buscafechahasta" name="buscafechahasta" class="form-control largo" >
                        </div>
                    </div>
                </div>
                <div>
                    <label class="form-label">Orden</label>
                    <select id="assigned-tutor-filter" id="orden" name="orden" class="form-control largo">
                        <?php if ($_POST["orden"] != ''){ ?>
                            <option value="<?php echo $_POST["orden"]; ?>">
                                <?php 
                        if ($_POST["orden"] == '1'){echo 'ORDENAR POR INCIDENTE';} 
                        if ($_POST["orden"] == '2'){echo 'ORDENAR POR USUARIO';} 
                        if ($_POST["orden"] == '3'){echo 'ORDENAR POR ESTADO';}
                        if ($_POST["orden"] == '4'){echo 'ORDENAR POR RESOLUTOR';} 
                        if ($_POST["orden"] == '5'){echo 'ORDENAR POR FECHA DE SOLUCIÓN';} 
                        ?>
                        </option>
                        <?php } ?>
                        <option value="">SIN ORDEN</option>
                        <option value="1">ORDENAR POR INCIDENTE</option>
                        <option value="2">ORDENAR POR USUARIO</option>
                        <option value="3">ORDENAR POR ESTADO</option>
                        <option value="4">ORDENAR POR RESOLUTOR</option>
                        <option value="5">ORDENAR POR FECHA DE SOLUCIÓN</option>
                    </select>
                </div>
            </div>
                
            <div class="filtros-listado">
                <div>
                    <label class="form-label">Usuario</label>
                    <select id="subject-filter" id="usuario" name="usuario" class="form-control largo">
                        <option value="">TODOS</option>
                        <?php 
                        $consulta= "SELECT * FROM usuarios ORDER BY NOMBRE ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                            <option value="<?php echo $opciones['ID_USUARIO']?>"><?php echo $opciones['NOMBRE']?></option>
                            <?php endforeach ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Estado</label>
                    <select id="subject-filter" id="estado" name="estado" class="form-control largo">
                        <option value="">TODOS</option>
                        <?php 
                        $consulta= "SELECT * FROM estado ORDER BY ESTADO ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                            <option value="<?php echo $opciones['ID_ESTADO']?>"><?php echo $opciones['ESTADO']?></option>
                            <?php endforeach ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Resolutor</label>
                    <select id="subject-filter" id="resolutor" name="resolutor" class="form-control largo">
                        <option value="">TODOS</option>
                        <?php 
                        $consulta= "SELECT * FROM resolutor ORDER BY RESOLUTOR ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                            <option value="<?php echo $opciones['ID_RESOLUTOR']?>"><?php echo $opciones['RESOLUTOR']?></option>
                            <?php endforeach ?>
                    </select>
                </div>
                <div class="export">
                    <button type="submit" form="formu" style="border:none; background-color:transparent;"><i class="fa-solid fa-file-excel fa-2x" style="color: #1f5120;"></i>&nbspCSV</button>
                    <input type="submit" class="btn btn-success" name="busqueda" value="Buscar">
                </div>
            </div>
        <?php 

        if ($_POST['buscar'] == ''){ $_POST['buscar'] = ' ';}
        $aKeyword = explode(" ", $_POST['buscar']);

        if ($_POST["buscar"] == '' AND $_POST['id_estado'] == '' AND $_POST['id_tipo'] == '' AND $_POST['id_via'] == '' AND $_POST['buscafechadesde'] == '' AND $_POST['buscafechahasta'] == ''){ 
                $query ="SELECT t.ID_TICKET, t.FECHA_INICIO, u.NOMBRE, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, t.FECHA_SOLUCION, r.RESOLUTOR
                FROM ticket t 
                LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO
                LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
                LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
                LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR
                ORDER BY t.FECHA_INICIO DESC, t.ID_TICKET DESC ";
        }elseif(isset($_POST['busqueda'])){
                $query = "SELECT t.ID_TICKET, t.FECHA_INICIO, u.NOMBRE, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, t.FECHA_SOLUCION, r.RESOLUTOR
                FROM ticket t 
                LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO
                LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
                LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
                LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR ";

                if ($_POST["buscar"] != '' ){ 
                        $query .= " WHERE (t.DESCRIPCION LIKE LOWER('%".$aKeyword[0]."%')) ";
                
                    for($i = 1; $i < count($aKeyword); $i++) {
                    if(!empty($aKeyword[$i])) {
                        $query .= " OR t.DESCRIPCION LIKE '%" . $aKeyword[$i] . "%' ";
                    }
                    }

                }
            
        if ($_POST["usuario"] != '' ){
            $query .= " AND t.ID_USUARIO = '".$_POST["usuario"]."' ";
        }
        if ($_POST["estado"] != '' ){
            $query .= " AND t.ID_ESTADO = '".$_POST["estado"]."' ";
        }
        if ($_POST["resolutor"] != '' ){
            $query .= " AND t.ID_RESOLUTOR = '".$_POST["resolutor"]."' ";
        }
        if ($_POST["buscafechadesde"] != '' ){
            $query .= " AND t.FECHA_SOLUCION BETWEEN '".$_POST["buscafechadesde"]."' AND '".$_POST["buscafechahasta"]."' ";
        }



         if ($_POST["orden"] == '1' ){
                    $query .= " ORDER BY t.ID_TICKET DESC ";
         }

         if ($_POST["orden"] == '2' ){
                $query .= " ORDER BY u.NOMBRE ASC ";
         }

         if ($_POST["orden"] == '3' ){
                $query .= "  ORDER BY e.ESTADO ASC ";
         }

         if ($_POST["orden"] == '4' ){
                $query .= "  ORDER BY r.RESOLUTOR ASC ";
         }
         if ($_POST["orden"] == '5' ){
            $query .= "  ORDER BY t.FECHA_SOLUCION DESC ";
     }
}else{
    $query ="SELECT t.ID_TICKET, t.FECHA_INICIO, u.NOMBRE, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, t.FECHA_SOLUCION, r.RESOLUTOR, t.ID_ESTADO
    FROM ticket t 
    LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO
    LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
    LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
    LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR
    WHERE t.ID_ESTADO = 3 OR t.ID_ESTADO = 4 OR t.ID_ESTADO = 2
    ORDER BY t.ID_ESTADO DESC, t.FECHA_INICIO DESC, t.ID_TICKET DESC
    LIMIT 50";
}

/*         $consulta=mysqli_query($datos_base, $query); */
         $sql = $datos_base->query($query);

         $numeroSql = mysqli_num_rows($sql);

        ?>
        <div class="contResult">
            <p style="font-weight: bold; color:#53AAE0;"><i class="mdi mdi-file-document"></i> <?php echo $numeroSql; ?> Resultados encontrados</p>
        </div>
    </form>


    <table class="table_id" style="width: 98%; margin: 0 auto;">
        <thead>
            <tr>
                <th id="th">N°INCIDENTE</th>
                <th id="th" style="text-align:center;">FECHA INICIO</th>
                <th id="th" style="padding: 5px;">USUARIO</th>
                <th id="th" style="padding: 5px;">DESCRIPCIÓN</th>
                <th id="th" style="text-align:center;">ESTADO</th>
                <th id="th" style="text-align:center;">FECHA SOLUCIÓN</th>
                <th id="th" style="text-align:center;">RESOLUTOR</th>
                <th id="th">ACCIÓN</th>
            </tr>
        </thead>

        <?php While($rowSql = $sql->fetch_assoc()) {
                $fecord = date("d-m-Y", strtotime($rowSql['FECHA_INICIO']));

                $fecha = "0000-00-00";
                if($rowSql['FECHA_SOLUCION'] == $fecha)
                {
                    $fec = date("d-m-Y", strtotime($rowSql['FECHA_SOLUCION']));
                    $fec = "-";
                    /*$fec = "-";*/
                }
                else{
                    $fec = date("d-m-Y", strtotime($rowSql['FECHA_SOLUCION']));
                }
            echo "
                <tr>
                <td><h4 style='font-size:14px; text-align:right;margin-right: 5px;'>".$rowSql['ID_TICKET']."</h4></td>
                <td><h4 style='font-size:14px; text-align:center;'>".$fecord."</h4></td>
                <td><h4 class='wrap2' style='font-size:14px; text-align: left; margin-left: 5px;'>".$rowSql['NOMBRE']."</h4></td>
                <td><h4 class='wrap2' style='font-size:14px; text-align: left; margin-left: 5px;'>".$rowSql['DESCRIPCION']."</h4></td>
                <td><h4 class='wrap2' style='font-size:14px; text-align: center;'>".$rowSql['ESTADO']."</h4></td>
                <td><h4 style='font-size:14px; text-align: center;'>".$fec."</h4></td>
                <td><h4  style='font-size:14px; text-align: center;'>".$rowSql['RESOLUTOR']."</h4></td>
                <td class='text-center text-nowrap' style='padding:5px;'><a class='btn btn-info' href=modificacion.php?no=".$rowSql['ID_TICKET']." target=new class=mod style=' color:white;'>Info</a></td>
                </tr>
        ";
        }
        if($_POST['buscar'] != "" AND $_POST['buscar'] != " " OR $_POST['buscafechadesde'] != "" AND $_POST['buscafechahasta'] != "" OR $_POST['usuario'] != "" OR $_POST['estado'] != "" OR $_POST['resolutor'] != ""){
            echo "
            <div class=filtrado>
            <h2>Filtrado por:</h2>
                <ul>";
                    if($_POST['buscar'] != "" AND $_POST['buscar'] != " "){
                        echo "<li><u>DESCRIPCIÓN</u>: ".$_POST['buscar']."</li>";
                    }
                    if($_POST['buscafechadesde'] != "" AND $_POST['buscafechahasta'] != ""){
                        echo "<li><u>PERÍODO DE CREACIÓN</u>: ".date("d-m-Y", strtotime($_POST['buscafechadesde']))." - ".date("d-m-Y", strtotime($_POST['buscafechahasta']))."</li>";
                    }
                    if($_POST['estado'] != ""){
                        $sql = "SELECT ESTADO FROM estado WHERE ID_ESTADO = $_POST[estado]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $estado = $row['ESTADO'];
                        echo "<li><u>ESTADO</u>: ".$estado."</li>";
                    }
                    if($_POST['usuario'] != ""){
                        $sql = "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = $_POST[usuario]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $usuario = $row['NOMBRE'];
                        echo "<li><u>USUARIO</u>: ".$usuario."</li>";
                    }
                    if($_POST['resolutor'] != ""){
                        $sql = "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = $_POST[resolutor]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $resolutor = $row['RESOLUTOR'];
                        echo "<li><u>RESOLUTOR</u>: ".$resolutor."</li>";
                    }
                    echo"
                </ul>
            </div>
            ";
                }
        echo '</table>';
        ?>
		</div>
        <form id="formu" action="../exportar/ExcelIncidentes.php" method="POST">
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