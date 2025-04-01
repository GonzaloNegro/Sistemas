<header class="p-3 mb-3 border-bottom altura">
    <div class="container-fluid">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none"><div id="foto"></div>
          <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use> </svg>-->
        </a>

        <ul style="margin-left:20px !important;" class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 espacio">
		<li><a href="../carga/cargadeincidentes.php" class="nav-link px-2 link-secondary link destacado">NUEVO INCIDENTE</a>
 				<ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
					<li><a class="dropdown-item" href="../carga/cargarapidaporusuario.php">CARGA RÁPIDA POR USUARIO</a></li>
	 				<li><hr class="dropdown-divider"></li>
                	<li><a class="dropdown-item" href="../carga/cargarapidaportipificacion.php">CARGA RÁPIDA POR TIPIFICACIÓN</a></li>
                </ul>
			</li>
			<li><a href="../consulta/consulta.php" class="nav-link px-2 link-dark link">CONSULTA</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="../consulta/consulta.php">CONSULTA DE INCIDENTES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/consultausuario.php">CONSULTA DE USUARIOS</a></li>
					<li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/consultaaltas.php">CONSULTA PARA ALTAS</a></li>
                </ul>
            </li>
            <li><a href="../consulta/inventario.php" class="nav-link px-2 link-dark link">INVENTARIO</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="../consulta/inventario.php">EQUIPOS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/impresoras.php">IMPRESORAS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/monitores.php">MONITORES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/otrosp.php">OTROS PERIFÉRICOS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/celulares.php">CELULARES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../consulta/montosLineas.php">MONTOS/LÍNEAS</a></li>
                </ul>
            </li>
            <li><a href="#" class="nav-link px-2 link-dark link" style="border-left: 5px solid #53AAE0;">GESTIÓN</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a href="../abm/abm.php" class="dropdown-item">ABM</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="../reportes/tiporeporte.php" class="dropdown-item">REPORTES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <?php if($row['ID_PERFIL'] == 1 OR $row['ID_PERFIL'] == 2 OR $row['ID_PERFIL'] == 5){
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
        <?php include('notificacion.php'); ?>
        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false"><h5 style="color: #007BFF;"><i class="bi bi-person rounded-circle" style="color: #007BFF;"></i> <?php echo utf8_decode($row['RESOLUTOR']);?></h5></a>
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