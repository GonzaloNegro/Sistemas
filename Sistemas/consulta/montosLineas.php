<?php 
session_start();
error_reporting(0);
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
	<title>MONTOS LÍNEAS</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymus"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    if (!isset($_POST['nombreplan'])){$_POST['nombreplan'] = '';}
    if (!isset($_POST["orden"])){$_POST["orden"] = '';}
    if (!isset($_POST["estado"])){$_POST["estado"] = '';}
    if (!isset($_POST["reparticion"])){$_POST["reparticion"] = '';}
?>
<?php include('../layout/inventario.php'); ?>
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
			<h1>MONTOS LÍNEAS</h1>
		</div>
        <form method="POST" id="form_filtro" action="./MontosLineas.php" class="contFilter--name">
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">Número/Usuario</label>
                        <input type="text" style="text-transform:uppercase;" id="buscar" name="buscar"  placeholder="Buscar" class="form-control largo">
                    </div>
                    <div>
                        <label class="form-label">Nombre plan</label>
                        <select id="nombreplan" name="nombreplan" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT n.NOMBREPLAN, p.PLAN, n.ID_NOMBREPLAN, e.PROVEEDOR
                            FROM nombreplan n
                            LEFT JOIN plan p ON p.ID_PLAN = n.ID_PLAN inner join proveedor e on n.ID_PROVEEDOR=e.ID_PROVEEDOR
                            WHERE n.MONTO > 0
                            ORDER BY n.NOMBREPLAN ASC
                            ";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_NOMBREPLAN']?>"><?php echo $opciones['NOMBREPLAN']." - ".$opciones['PLAN']?> - <?php echo $opciones['PROVEEDOR']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Proveedor</label>
                        <select id="proveedor" name="proveedor" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "select proveedor, id_proveedor from proveedor where id_proveedor=34 or id_proveedor=35 order by proveedor asc";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['id_proveedor']?>"><?php echo $opciones['proveedor']?></option>
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
                        <label class="form-label">Estado</label>
                        <select id="estado" name="estado" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM estado_ws ORDER BY ESTADO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_ESTADOWS']?>"><?php echo $opciones['ESTADO']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Orden</label>
                        <select id="orden" name="orden" class="form-control largo">
                            <?php if ($_POST["orden"] != ''){ ?>
                                <option value="<?php echo $_POST["orden"]; ?>">
                                    <?php 
                            if ($_POST["orden"] == '1'){echo 'ORDENAR POR USUARIO';} 
                            if ($_POST["orden"] == '2'){echo 'ORDENAR POR NOMBRE PLAN';}
                            if ($_POST["orden"] == '3'){echo 'ORDENAR POR ESTADO';}
                            if ($_POST["orden"] == '4'){echo 'ORDENAR POR MONTO TOTAL ASCENDENTE';}
                            if ($_POST["orden"] == '5'){echo 'ORDENAR POR MONTO TOTAL DESCENDENTE';}
                            ?>
                            </option>
                            <?php } ?>
                            <option value="">SIN ORDEN</option>
                            <option value="1">ORDENAR POR USUARIO</option>
                            <option value="2">ORDENAR POR NOMBRE PLAN</option>
                            <option value="3">ORDENAR POR ESTADO</option>
                            <option value="4">ORDENAR POR MONTO TOTAL ASCENDENTE</option>
                            <option value="5">ORDENAR POR MONTO TOTAL DESCENDENTE</option>
                        </select>
                    </div>

                    <div style="display:flex;justify-content: flex-end;">
                        <!-- <input type="submit" class="btn btn-success" name="busqueda" value="Buscar"> -->
                        <input onClick="filtrar()" class="btn btn-success" name="busqueda" value="Buscar">
                    </div>
                </div>

                <div class="filtros-listadoParalelo">
                    
                    <?php if($row['ID_PERFIL'] == 1 || $row['ID_PERFIL'] == 2 || $row['ID_PERFIL'] == 6){
                        echo '<div>
                                    <button class="btn btn-success" style="font-size: 20px;"><a href="./agregarLinea.php" style="text-decoration:none !important;color:white;" target="_blank">Agregar nueva línea</a></button>
                                </div>';
                    }
                    ?>
                    <div>
                        <button class="btn btn-warning" style="font-size: 20px;background-color:#FF7800;"><a href="./montosMensuales.php" style="text-decoration:none !important;color:white;" target="_blank">Montos mensuales</a></button>
                    </div>
                    <div class="export">
                        Exportar a: <button type="submit" form="formu" style="border:none; background-color:transparent;"><i class="fa-solid fa-file-excel fa-2x" style="color: #1f5120;"></i>&nbspCSV</button>
                    </div>
                </div>
            </div>
        <?php 

        if ($_POST['buscar'] == ''){ $_POST['buscar'] = ' ';}
        $aKeyword = explode(" ", $_POST['buscar']);

        if ($_POST["buscar"] == '' AND $_POST['ID_NOMBREPLAN'] == '' AND $_POST['ID_ESTADOWS'] == '' AND $_POST['ID_PROVEEDOR'] == ''){ 
                $query ="SELECT m.ID_MOVILINEA, m.ID_LINEA, m.EXTRAS, l.NRO, e.ESTADO, p.PLAN, n.NOMBREPLAN, n.MONTO, u.NOMBRE, l.DESCUENTO, l.FECHADESCUENTO, r.ROAMING, pr.PROVEEDOR, m.MONTOTOTAL, re.REPA
                FROM movilinea m
                INNER JOIN (
                    SELECT ID_LINEA, MAX(ID_MOVILINEA) AS UltimoID
                    FROM movilinea
                    GROUP BY ID_LINEA
                ) ultimos ON m.ID_LINEA = ultimos.ID_LINEA AND m.ID_MOVILINEA = ultimos.UltimoID
                LEFT JOIN linea l ON m.ID_LINEA = l.ID_LINEA 
                LEFT JOIN estado_ws e ON e.ID_ESTADOWS = l.ID_ESTADOWS 
                LEFT JOIN nombreplan n ON n.ID_NOMBREPLAN = l.ID_NOMBREPLAN 
                LEFT JOIN plan p ON p.ID_PLAN = n.ID_PLAN
                LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = n.ID_PROVEEDOR 
                LEFT JOIN roaming r ON r.ID_ROAMING = l.ID_ROAMING
                LEFT JOIN usuarios u ON u.ID_USUARIO = l.ID_USUARIO 
                LEFT JOIN area a on a.ID_AREA=u.ID_AREA
                LEFT JOIN reparticion re on a.ID_REPA=re.ID_REPA
                ORDER BY u.NOMBRE ASC ";
        }elseif(isset($_POST['busqueda'])){
                $query = "SELECT m.ID_MOVILINEA, m.ID_LINEA, m.EXTRAS, l.NRO, e.ESTADO, p.PLAN, n.NOMBREPLAN, n.MONTO, u.NOMBRE, l.DESCUENTO, l.FECHADESCUENTO, r.ROAMING, pr.PROVEEDOR, m.MONTOTOTAL, re.REPA
                FROM movilinea m
                INNER JOIN (
                    SELECT ID_LINEA, MAX(ID_MOVILINEA) AS UltimoID
                    FROM movilinea
                    GROUP BY ID_LINEA
                ) ultimos ON m.ID_LINEA = ultimos.ID_LINEA AND m.ID_MOVILINEA = ultimos.UltimoID
                LEFT JOIN linea l ON m.ID_LINEA = l.ID_LINEA 
                LEFT JOIN estado_ws e ON e.ID_ESTADOWS = l.ID_ESTADOWS 
                LEFT JOIN nombreplan n ON n.ID_NOMBREPLAN = l.ID_NOMBREPLAN 
                LEFT JOIN plan p ON p.ID_PLAN = n.ID_PLAN
                LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = n.ID_PROVEEDOR 
                LEFT JOIN roaming r ON r.ID_ROAMING = l.ID_ROAMING
                LEFT JOIN usuarios u ON u.ID_USUARIO = l.ID_USUARIO 
                LEFT JOIN area a on a.ID_AREA=u.ID_AREA
                LEFT JOIN reparticion re on a.ID_REPA=re.ID_REPA  ";

                if ($_POST["buscar"] != '' ){ 
                        $query .= " WHERE (u.NOMBRE LIKE LOWER('%".$aKeyword[0]."%') OR l.NRO LIKE LOWER('%".$aKeyword[0]."%')) ";
                
                    for($i = 1; $i < count($aKeyword); $i++) {
                    if(!empty($aKeyword[$i])) {
                        $query .= " OR u.NOMBRE LIKE '%" . $aKeyword[$i] . "%' l.NRO LIKE '%" . $aKeyword[$i] . "%' ";
                    }
                    }

                }
        if ($_POST["reparticion"] != '' ){
            $query .= " AND re.ID_REPA = '".$_POST["reparticion"]."' ";
        }    
        if ($_POST["nombreplan"] != '' ){
            $query .= " AND n.ID_NOMBREPLAN = '".$_POST["nombreplan"]."' ";
        }
        if ($_POST["estado"] != '' ){
            $query .= " AND e.ID_ESTADOWS = '".$_POST["estado"]."' ";
        }

        if ($_POST["proveedor"] != '' ){
            $query .= " AND pr.ID_PROVEEDOR = '".$_POST["proveedor"]."' ";
        }

        $query .= " GROUP BY l.NRO ";


        if ($_POST["orden"] == '1' ){
        $query .= " ORDER BY u.NOMBRE ASC ";
        }

        if ($_POST["orden"] == '2' ){
        $query .= " ORDER BY n.NOMBREPLAN ASC ";
        }
        if ($_POST["orden"] == '3' ){
            $query .= "  ORDER BY e.ESTADO ASC ";
        }
        if ($_POST["orden"] == '4' ){
            $query .= " ORDER BY m.MONTOTOTAL ASC ";
        }
        if ($_POST["orden"] == '5' ){
            $query .= " ORDER BY m.MONTOTOTAL DESC ";
        }


}else{
/*     $query ="SELECT l.ID_LINEA, l.NRO, e.ESTADO, p.PLAN, n.NOMBREPLAN, n.MONTO, u.NOMBRE, l.DESCUENTO, l.FECHADESCUENTO, r.ROAMING, pr.PROVEEDOR, m.MONTOTOTAL, m.EXTRAS
    FROM linea l
    LEFT JOIN movilinea m ON m.ID_LINEA = l.ID_LINEA 
    LEFT JOIN estado_ws e ON e.ID_ESTADOWS = l.ID_ESTADOWS 
    LEFT JOIN plan p ON p.ID_PLAN = l.ID_PLAN
    LEFT JOIN nombreplan n ON n.ID_NOMBREPLAN = l.ID_NOMBREPLAN 
    LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = n.ID_PROVEEDOR 
    LEFT JOIN roaming r ON r.ID_ROAMING = l.ID_ROAMING
    LEFT JOIN usuarios u ON u.ID_USUARIO = m.ID_USUARIO
    GROUP BY m.ID_LINEA
    ORDER BY m.ID_MOVILINEA DESC"; */

    $query ="SELECT m.ID_MOVILINEA, m.ID_LINEA, m.EXTRAS, l.NRO, e.ESTADO, p.PLAN, n.NOMBREPLAN, n.MONTO, u.NOMBRE, l.DESCUENTO, l.FECHADESCUENTO, r.ROAMING, pr.PROVEEDOR, m.MONTOTOTAL, re.REPA
    FROM movilinea m
    INNER JOIN (
        SELECT ID_LINEA, MAX(ID_MOVILINEA) AS UltimoID
        FROM movilinea
        GROUP BY ID_LINEA
    ) ultimos ON m.ID_LINEA = ultimos.ID_LINEA AND m.ID_MOVILINEA = ultimos.UltimoID
    LEFT JOIN linea l ON m.ID_LINEA = l.ID_LINEA 
    LEFT JOIN estado_ws e ON e.ID_ESTADOWS = l.ID_ESTADOWS 
    LEFT JOIN nombreplan n ON n.ID_NOMBREPLAN = l.ID_NOMBREPLAN 
    LEFT JOIN plan p ON p.ID_PLAN = n.ID_PLAN
    LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = n.ID_PROVEEDOR 
    LEFT JOIN roaming r ON r.ID_ROAMING = l.ID_ROAMING
    LEFT JOIN usuarios u ON u.ID_USUARIO = l.ID_USUARIO 
    LEFT JOIN area a on a.ID_AREA=u.ID_AREA
    LEFT JOIN reparticion re on a.ID_REPA=re.ID_REPA
    ";
}

/*         $consulta=mysqli_query($datos_base, $query); */
         $sql = $datos_base->query($query);

         $numeroSql = mysqli_num_rows($sql);

        ?>
<!--         <div class="contResult">
            <p style="font-weight: bold; color:#53AAE0;"><i class="mdi mdi-file-document"></i> <?php echo $numeroSql; ?> Resultados encontrados</p>
        </div> -->
    </form>

    <?php
        $sqla = "SELECT ID_MOVILINEA AS id, YEAR(FECHA) AS AÑO, MONTH(FECHA) AS MES FROM movilinea ORDER BY FECHA DESC LIMIT 1";
        $resultado = $datos_base->query($sqla);
        $row_ = $resultado->fetch_assoc();
        $idUltimoRegistro = $row_['id'];
        $añoUltimoRegistro = $row_['AÑO'];
        $mesUltimoRegistro = $row_['MES'];

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        $mesActual = date("n");
    $añoActual = date("Y");
    switch ($mesActual) {
        case '1': $mes = 'Enero';break;
        case '2': $mes = 'Febrero';break;
        case '3': $mes = 'Marzo';break;
        case '4': $mes = 'Abril';break;
        case '5': $mes = 'Mayo';break;
        case '6': $mes = 'Junio';break;
        case '7': $mes = 'Julio';break;
        case '8': $mes = 'Agosto';break;
        case '9': $mes = 'Septiembre';break;
        case '10': $mes = 'Octubre';break;
        case '11': $mes = 'Noviembre';break;
        case '12': $mes = 'Diciembre';break;
        default: $mes = ''; break;
        }

    if($añoUltimoRegistro == $añoActual && $mesUltimoRegistro == $mesActual){

    }elseif($añoUltimoRegistro <= $añoActual && $mesUltimoRegistro != $mesActual){
        if($row['ID_PERFIL'] == 1 || $row['ID_PERFIL'] == 2){
    ?>
    <!-- Boton de actulizar monto mensual-->
    <form method="POST" action="./modificados.php" class="contFilter--name">
    <div style="width:100%;padding:10px 30px;display: flex;justify-content: flex-end;align-items: flex-end;">
        <button type="submit" name="btnActualizarMontoMensual" class="btn btn-danger">Actualizar montos mes <?php echo $mes;?></button>
<!--         <a href="montosLineasActualizado.php" name="btnActualizarMontoMensual" class="btn btn-danger">Actualizar montos mes <?php echo $mes;?></a> -->

    </div>
    <?php }}?>
    </form>

    <?php 
        if($_POST["buscar"] == ' ' AND $_POST['nombreplan'] == '' AND $_POST['estado'] == '' AND $_POST['reparticion'] == ''){;
        ?>

        <div class="principal-info">
            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM linea";
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
                        <span class="count-name">Líneas Registradas</span>
                    </div>
                </div>
            </div>

            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM linea WHERE ID_ESTADOWS = 1";
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
                        <span class="count-name">Líneas Activas</span>
                    </div>
                </div>
            </div>


            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM linea WHERE ID_ESTADOWS = 2 OR ID_ESTADOWS = 3";
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
                        <span class="count-name">Líneas Inactivas</span>
                    </div>
                </div>
            </div>
        </div>

        <?php };?>

    <table class="table_id" id="tabla_lineas" style="width: 98%; margin: 0 auto;">
        <thead>
            <tr>
                <th><p style='text-align:right; margin-right: 10px;'>NÚMERO</p></th>
                <th><p style='text-align:left; margin-left: 10px;'>USUARIO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">REPARTICIÓN</p></th>
                <th><p style='text-align:left; margin-left: 10px;'>PLAN</p></th>
                <th><p style='text-align:left; margin-left: 10px;'>PROVEEDOR</p></th>
                <th><p style='text-align:left; margin-left: 10px;'>ROAMING</p></th>
                <th><p style='text-align:right; margin-right: 10px;'>MONTO</p></th>
                <th><p style='text-align:right; margin-right: 10px;'>EXTRAS</p></th>
                <th><p style='text-align:right; margin-right: 10px;'>DESCUENTO</p></th>
                <!-- <th><p style='text-align:center;'>FECHA DESCUENTO</p></th> -->
                <th><p style='text-align:right; margin-right: 10px;'>MONTO TOTAL</p></th>
                <th><p style='text-align:left; margin-left: 10px;'>ESTADO</p></th>
                <th><p>ACCIÓN</p></th>
            </tr>
        </thead>

        <?php $cantidadTotal = 0;?>
        <?php While($rowSql = $sql->fetch_assoc()) {
            $cantidadTotal++;
            $NUMERO=$rowSql['NRO'];
            echo "
                <tr>
                <td><h4 style='font-size:16px; text-align: right; margin-right: 5px;'>".$rowSql['NRO']."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$rowSql['NOMBRE']."</h4 ></td>
                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['REPA']."</h4></td>
                <td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$rowSql['NOMBREPLAN']." - ".$rowSql['PLAN']."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$rowSql['PROVEEDOR']."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$rowSql['ROAMING']."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: right; margin-right: 5px;color:green;font-weight:bold;'>"."$".$rowSql['MONTO']."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: right; margin-right: 5px;color:red;font-weight:bold;'>"."$".$rowSql['EXTRAS']."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: right; margin-right: 5px;'>".$rowSql['DESCUENTO']."%"."</h4 ></td>
                <td><h4 style='font-size:18px; text-align: right; margin-right: 5px;color:green;font-weight:bold;'>"."$".$rowSql['MONTOTOTAL']."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$rowSql['ESTADO']."</h4 ></td>
                <td class='text-center text-nowrap'>
                    <a class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#exampleModal' data-bs-whatever='@mdo' onclick='cargar_informacion(".$rowSql['ID_LINEA'].")' target=new class=mod>Info</a>

                    <a class='btn btn-success' data-bs-toggle='modal' data-bs-target='#exampleModal2'
                    data-bs-whatever='@mdo' style=' color:white;' onclick='cargar_informacion2(".$rowSql['ID_LINEA'].")' class=mod>Mov. Info</a>

                    <a class='btn btn-success' data-bs-toggle='modal' data-bs-target='#exampleModal3'
                    data-bs-whatever='@mdo' class='btn btn-warning' style='background-color:#FF7800;' onclick='cargar_informacion3(".$rowSql['ID_LINEA'].")' class=mod>Mov. Linea</a>
                    ";
                    if($row['ID_PERFIL'] == 1 || $row['ID_PERFIL'] == 2 || $row['ID_PERFIL'] == 6) 
                    { echo"
                    <a class='btn btn-info' style=' color:white;' href=modificarLinea.php?num=".$rowSql['ID_LINEA']." target=_blank class=mod>Editar</a>";
                    }
                    ;
                    echo"
                </td>
            </tr>
            ";
        }
        if($_POST['buscar'] != "" AND $_POST['buscar'] != " " OR $_POST['reparticion'] != "" OR $_POST['nombreplan'] != "" OR $_POST['estado'] != ""){
            echo "
            <div class=filtrado>
            <h2>Filtrado por:</h2>
                <ul>";
                    if($_POST['buscar'] != "" AND $_POST['buscar'] != " "){
                        echo "<li><u>NÚMERO/USUARIO</u>: ".$_POST['buscar']."</li>";
                    }
                    if($_POST['reparticion'] != ""){
                        $sql = "SELECT REPA FROM reparticion WHERE ID_REPA = $_POST[reparticion]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $repa = $row['REPA'];
                        echo "<li><u>REPARTICIÓN</u>: ".$repa."</li>";
                    }
                    if($_POST['nombreplan'] != ""){
                        $sql = "SELECT NOMBREPLAN FROM nombreplan WHERE ID_NOMBREPLAN = $_POST[nombreplan]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $nombreplan = $row['NOMBREPLAN'];
                        echo "<li><u>NOMBREPLAN</u>: ".$nombreplan."</li>";
                    }
                    if($_POST['estado'] != ""){
                        $sql = "SELECT ESTADO FROM estado_ws WHERE ID_ESTADOWS = $_POST[estado]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $estadows = $row['ESTADO'];
                        echo "<li><u>ESTADO</u>: ".$estadows."</li>";
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
        <form id="formu" action="../exportar/ExcelMontosLineas.php" method="POST">
            <input type="text" id="excel" name="sql" class="valorPeque" readonly="readonly" value="<?php echo $query;?>">
        </form>
	</section>
	<footer></footer>

    <div class="modal fade modal--usu" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">INFORMACIÓN</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="mostrar_mensaje" style="display:flex;flex-direction:column;gap:10px;">
                    </div>
                </div>
                <div id="resultado" class="resultado">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal--usu" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="display:flex;justify-content:center;width:100%;">
            <div class="modal-content"  style="width:auto;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">HISTORIAL MOVIMIENTOS DE INFORMACIÓN</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="mostrar_mensaje2"></table>
                </div>
                <div id="resultado" class="resultado">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal--usu" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="display:flex;justify-content:center;width:100%;">
            <div class="modal-content"  style="width:auto;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">HISTORIAL MOVIMIENTOS LÍNEA</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="mostrar_mensaje3"></table>
                </div>
                <div id="resultado" class="resultado">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!--FUNCIONALIDAD EN JQUERY QUE PETICIONA A consultarDatosLinea.php los detalles de la linea-->
    <script>
    function cargar_informacion(id_linea) {
        //buscar ES EL ID DEL CASO//
        var parametros = {
            "idLinea": id_linea
        };
        //LA VARIABLE BUSCAR UTILIZA EL ID CASO Y LA ENVIA AL SERVIDOR DE NOVEDADES///
        $.ajax({
            data: parametros,
            url: "./consultarDatosLinea.php",
            type: "POST",
            //TRAE DE FORMA ASINCRONA, CONSUME EL SERVIDOR DE NOVEDADES Y MUESTRA EN EL DIV MOSTRAR_MENSAJE TODAS LAS NOVEDADES RELACIONADAS////
            beforesend: function() {
                $("#mostrar_mensaje").html("Mensaje antes de Enviar");
            },

            success: function(mensaje) {
                $("#mostrar_mensaje").html(mensaje);
            }
        });
    };
    function cargar_informacion2(id_linea) {
        //buscar ES EL ID DEL CASO//
        var parametros = {
            "idLinea": id_linea
        };
        //LA VARIABLE BUSCAR UTILIZA EL ID CASO Y LA ENVIA AL SERVIDOR DE NOVEDADES///
        $.ajax({
            data: parametros,
            url: "./consultarDatosLinea2.php",
            type: "POST",
            //TRAE DE FORMA ASINCRONA, CONSUME EL SERVIDOR DE NOVEDADES Y MUESTRA EN EL DIV MOSTRAR_MENSAJE TODAS LAS NOVEDADES RELACIONADAS////
            beforesend: function() {
                $("#mostrar_mensaje2").html("Mensaje antes de Enviar");
            },

            success: function(mensaje) {
                $("#mostrar_mensaje2").html(mensaje);
            }
        });
    };
    function cargar_informacion3(id_linea) {
        //buscar ES EL ID DEL CASO//
        var parametros = {
            "idLinea": id_linea
        };
        //LA VARIABLE BUSCAR UTILIZA EL ID CASO Y LA ENVIA AL SERVIDOR DE NOVEDADES///
        $.ajax({
            data: parametros,
            url: "./consultarDatosLinea3.php",
            type: "POST",
            //TRAE DE FORMA ASINCRONA, CONSUME EL SERVIDOR DE NOVEDADES Y MUESTRA EN EL DIV MOSTRAR_MENSAJE TODAS LAS NOVEDADES RELACIONADAS////
            beforesend: function() {
                $("#mostrar_mensaje3").html("Mensaje antes de Enviar");
            },

            success: function(mensaje) {
                $("#mostrar_mensaje3").html(mensaje);
            }
        });
    };
    </script>  
    <script>
        function filtrar(){
            var buscar= $("#buscar").val();
            var nombreplan= $("#nombreplan").val();
            var plan= $("#plan").val();
            var estado= $("#estado").val();
            var orden= $("#orden").val();
            if(buscar=="" && nombreplan=="" && plan=="" && estado=="" && orden==""){
                Swal.fire({
                        title: "Por favor seleccione una opción a filtrar.",
                        icon: "warning",
                        showConfirmButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                        customClass:{
                            actions: 'reverse-button'
                        }
                    })
                // alert("Seleccione un mes a visualizar");
                // $("#mes").focus()
            }
            else{
                $("#form_filtro").submit();
            }
        }
    </script>        
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
	
</body>
</html>