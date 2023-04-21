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
    if (!isset($_POST["reparticion"])){$_POST["reparticion"] = '';}
    if (!isset($_POST["orden"])){$_POST["orden"] = '';}
    if (!isset($_POST['tipows'])){$_POST['tipows'] = '';}
    if (!isset($_POST["so"])){$_POST["so"] = '';}
    if (!isset($_POST["micro"])){$_POST["micro"] = '';}
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
			<h1>INVENTARIO DE EQUIPOS</h1>
		</div>
        <form method="POST" action="./inventario.php" class="contFilter--name">
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">Usuario/N°WS</label>
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
                        <label class="form-label">Repartición</label>
                        <select id="subject-filter" id="reparticion" name="reparticion" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM reparticion ORDER BY REPA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_REPA']?>"><?php echo $opciones['REPA']?></option>
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
                            if ($_POST["orden"] == '3'){echo 'ORDENAR POR REPARTICIÓN';}
                            if ($_POST["orden"] == '4'){echo 'ORDENAR POR SISTEMA OPERATIVO';} 
                            if ($_POST["orden"] == '5'){echo 'ORDENAR POR MICRO';}
                            if ($_POST["orden"] == '6'){echo 'ORDENAR POR TIPO';}
                            ?>
                            </option>
                            <?php } ?>
                            <option value="">SIN ORDEN</option>
                            <option value="1">ORDENAR POR USUARIO</option>
                            <option value="2">ORDENAR POR AREA</option>
                            <option value="3">ORDENAR POR REPARTICIÓN</option>
                            <option value="4">ORDENAR POR SISTEMA OPERATIVO</option>
                            <option value="5">ORDENAR POR MICRO</option>
                            <option value="6">ORDENAR POR TIPO</option>
                        </select>
                    </div>
                </div>
                    
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">Sistema Operativo</label>
                        <select id="subject-filter" id="so" name="so" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM so ORDER BY SIST_OP ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_SO']?>"><?php echo $opciones['SIST_OP']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Micro</label>
                        <select id="subject-filter" id="micro" name="micro" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM micro ORDER BY MICRO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_MICRO']?>"><?php echo $opciones['MICRO']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Tipo</label>
                        <select id="subject-filter" id="tipows" name="tipows" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM tipows ORDER BY TIPOWS ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_TIPOWS']?>"><?php echo $opciones['TIPOWS']?></option>
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

        if ($_POST["buscar"] == '' AND $_POST['ID_REPA'] == '' AND $_POST['ID_AREA'] == ''){ 
                $query ="SELECT i.ID_WS, a.AREA, r.REPA, u.NOMBRE, t.TIPOWS, i.SERIEG, s.SIST_OP, m.MICRO
                FROM inventario i 
                LEFT JOIN area AS a ON i.ID_AREA = a.ID_AREA
                LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
                LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
                LEFT JOIN tipows AS t ON t.ID_TIPOWS = i.ID_TIPOWS
                LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
                LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
                LEFT JOIN so AS s ON s.ID_SO = i.ID_SO 
                ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC ";
        }elseif(isset($_POST['busqueda'])){
                $query = "SELECT i.ID_WS, a.AREA, r.REPA, u.NOMBRE, t.TIPOWS, i.SERIEG, s.SIST_OP, m.MICRO
                FROM inventario i 
                LEFT JOIN area AS a ON i.ID_AREA = a.ID_AREA
                LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
                LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
                LEFT JOIN tipows AS t ON t.ID_TIPOWS = i.ID_TIPOWS
                LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
                LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
                LEFT JOIN so AS s ON s.ID_SO = i.ID_SO  ";

                if ($_POST["buscar"] != '' ){ 
                        $query .= " WHERE (u.NOMBRE LIKE LOWER('%".$aKeyword[0]."%') OR i.SERIEG LIKE LOWER('%".$aKeyword[0]."%')) ";
                
                    for($i = 1; $i < count($aKeyword); $i++) {
                    if(!empty($aKeyword[$i])) {
                        $query .= " OR u.NOMBRE LIKE '%" . $aKeyword[$i] . "%' OR i.SERIEG LIKE '%" . $aKeyword[$i] . "%' ";
                    }
                    }

                }
            
        if ($_POST["reparticion"] != '' ){
            $query .= " AND a.ID_REPA = '".$_POST["reparticion"]."' ";
        }
        if ($_POST["area"] != '' ){
            $query .= " AND u.ID_AREA = '".$_POST["area"]."' ";
        }
        if ($_POST["so"] != '' ){
            $query .= " AND s.ID_SO = '".$_POST["so"]."' ";
        }
        if ($_POST["micro"] != '' ){
            $query .= " AND m.ID_MICRO = '".$_POST["micro"]."' ";
        }
        if ($_POST["tipows"] != '' ){
            $query .= " AND t.ID_TIPOWS = '".$_POST["tipows"]."' ";
        }


         if ($_POST["orden"] == '1' ){
                    $query .= " ORDER BY u.NOMBRE ASC ";
         }

         if ($_POST["orden"] == '2' ){
                $query .= " ORDER BY a.AREA ASC ";
         }

         if ($_POST["orden"] == '3' ){
                $query .= "  ORDER BY r.REPA ASC ";
         }
         if ($_POST["orden"] == '4' ){
            $query .= " ORDER BY s.SIST_OP ASC ";
        }

        if ($_POST["orden"] == '5' ){
                $query .= " ORDER BY m.MICRO ASC ";
        }

        if ($_POST["orden"] == '6' ){
                $query .= "  ORDER BY t.TIPOWS ASC ";
        }

}else{
    $query ="SELECT i.ID_WS, a.AREA, r.REPA, u.NOMBRE, t.TIPOWS, i.SERIEG, s.SIST_OP, m.MICRO
    FROM inventario i 
    LEFT JOIN area AS a ON i.ID_AREA = a.ID_AREA
    LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
    LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
    LEFT JOIN tipows AS t ON t.ID_TIPOWS = i.ID_TIPOWS
    LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
    LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
    LEFT JOIN so AS s ON s.ID_SO = i.ID_SO 
    ORDER BY r.REPA ASC, a.AREA ASC, u.NOMBRE ASC
    LIMIT 50";
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
                $sql6 = "SELECT COUNT(*) AS total FROM inventario";
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
                        <span class="count-name">Equipos Registrados</span>
                    </div>
                </div>
            </div>

            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM inventario WHERE ID_ESTADOWS = 1";
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
                        <span class="count-name">Equipos Activos</span>
                    </div>
                </div>
            </div>


            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM inventario WHERE ID_ESTADOWS = 2";
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
                        <span class="count-name">Equipos Inactivos</span>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <table class="table_id" style="width: 98%; margin: 0 auto;">
        <thead>
            <tr>
                <th><p>REPARTICIÓN</p></th>
                <th><p style="text-align:left; margin-left: 5px;">ÁREA</p></th>
                <th><p style="text-align:left; margin-left: 5px;">USUARIO</p></th>
                <th><p style="text-align:center;">N° WS</p></th>
                <th><p>S.O.</p></th>
                <th><p style="text-align:left; margin-left: 5px;">MICRO</p></th>
                <th><p>TIPO</p></th>
                <th><p>MAS DETALLES</p></th>
            </tr>
        </thead>

        <?php While($rowSql = $sql->fetch_assoc()) {
            $NUMERO=$rowSql['SERIEG'];
            echo "
                <tr>
                    <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['REPA']."</h4></td>
                    <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['AREA']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:14px; text-align: left; margin-left: 5px;'>".$rowSql['NOMBRE']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:14px; text-align: center;'>".$rowSql['SERIEG']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:14px; text-align: center;'>".$rowSql['SIST_OP']."</h4></td>
                    <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['MICRO']."</h4></td>
                    <td><h4 style='font-size:14px; text-align: center;'>".$rowSql['TIPOWS']."</h4></td>
                    <td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalleinv.php?no=".$rowSql['ID_WS']." target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
                    <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                    <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                    </svg></a>
                    <a class='btn btn-sm btn-outline-danger' href=../equipos/$NUMERO.pdf target=new><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-filetype-pdf' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z'/></svg></a>
                    </td>
                </tr>
            ";
        }
        if($_POST['buscar'] != "" AND $_POST['buscar'] != " " OR $_POST['area'] != "" OR $_POST['reparticion'] != "" OR $_POST['so'] != "" OR $_POST['tipows'] != "" OR $_POST['micro'] != ""){
            echo "
            <div class=filtrado>
            <h2>Filtrado por:</h2>
                <ul>";
                    if($_POST['buscar'] != "" AND $_POST['buscar'] != " "){
                        echo "<li><u>USUARIO</u>: ".$_POST['buscar']."</li>";
                    }
                    if($_POST['area'] != ""){
                        $sql = "SELECT AREA FROM area WHERE ID_AREA = $_POST[area]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $area = $row['AREA'];
                        echo "<li><u>ÁREA</u>: ".$area."</li>";
                    }
                    if($_POST['reparticion'] != ""){
                        $sql = "SELECT REPA FROM reparticion WHERE ID_REPA = $_POST[reparticion]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $reparticion = $row['REPA'];
                        echo "<li><u>REPARTICIÓN</u>: ".$reparticion."</li>";
                    }
                    if($_POST['so'] != ""){
                        $sql = "SELECT SIST_OP FROM so WHERE ID_SO = $_POST[so]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $so = $row['SIST_OP'];
                        echo "<li><u>SISTEMA OPERATIVO</u>: ".$so."</li>";
                    }
                    if($_POST['micro'] != ""){
                        $sql = "SELECT MICRO FROM micro WHERE ID_MICRO = $_POST[micro]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $micro = $row['MICRO'];
                        echo "<li><u>MICRO</u>: ".$micro."</li>";
                    }
                    if($_POST['tipows'] != ""){
                        $sql = "SELECT TIPOWS FROM tipows WHERE ID_TIPOWS = $_POST[tipows]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $tipows = $row['TIPOWS'];
                        echo "<li><u>TIPO EQUIPO</u>: ".$tipows."</li>";
                    }
                    echo"
                </ul>
            </div>
            ";
                }
        echo '</table>';
        ?>
		</div>
        <form id="formu" action="../exportar/ExcelInventario.php" method="POST">
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