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
$sql = "SELECT CUIL, RESOLUTOR FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>MONTOS MENSUALES</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<div id="reporteEst">
    <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
        <a id="vlv"  href="./montosLineas.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left" style="color:white;"></i></a>
    </div>
</div>
<?php
    if (!isset($_POST['buscar'])){$_POST['buscar'] = '';}
    if (!isset($_POST['mes'])){$_POST['mes'] = '';}
    if (!isset($_POST["orden"])){$_POST["orden"] = '';}
    if (!isset($_POST['año'])){$_POST['año'] = '';}
?>
<section id="consulta">
		<div id="titulo">
			<h1>MONTOS MENSUALES</h1>
		</div>
        <form method="POST" id="form_filtro" action="./montosMensuales.php" class="contFilter--name">
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">AÑO</label>
                        <!-- <input type="text" style="text-transform:uppercase;" name="buscar"  placeholder="2024" class="form-control largo"> -->
                        <select id="año" name="año" class="form-control largo">
                            <option value="">-SELECCIONAR-</option>
                        </select>
                        <script>
                            // Obtener el año actual
                            const currentYear = new Date().getFullYear();
                            const startYear = 2020; // Año inicial

                            // Referencia al select
                            const yearSelect = document.getElementById('año');

                            // Generar opciones dinámicamente
                            for (let year = currentYear; year >= startYear; year--) {
                                const option = document.createElement('option');
                                option.value = year;
                                option.textContent = year;
                                // Seleccionar el año actual por defecto
                                if (year === currentYear) {
                                    option.selected = true;
                                }
                                yearSelect.appendChild(option);
                            }
                        </script>
                    </div>
                    <div>
                        <label class="form-label">MES DE VENCIMIENTO:</label>
                        <select id="mes" name="mes" class="form-control largo">
                            <option value="">-SELECCIONAR-</option>
                            <option value="1">ENERO - CORRESPONDE A DICIEMBRE</option>
                            <option value="2" >FEBRERO - CORRESPONDE A ENERO</option>
                            <option value="3">MARZO - CORRESPONDE A FEBRERO</option>
                            <option value="4">ABRIL - CORRESPONDE A MARZO</option>
                            <option value="5">MAYO - CORRESPONDE A ABRIL</option>
                            <option value="6">JUNIO - CORRESPONDE A MAYO</option>
                            <option value="7">JULIO - CORRESPONDE A JUNIO</option>
                            <option value="8">AGOSTO - CORRESPONDE A JULIO</option>
                            <option value="9">SEPTIEMBRE - CORRESPONDE A AGOSTO</option>
                            <option value="10">OCTUBRE - CORRESPONDE A SEPTIEMBRE</option>
                            <option value="11">NOVIEMBRE - CORRESPONDE A OCTUBRE</option>
                            <option value="12">DICIEMBRE - CORRESPONDE A NOVIEMBRE</option>
                        </select>
                    </div>
  
                </div>
                <div class="filtros-listadoParalelo">
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
                        <label class="form-label">Edificio</label>
                        <select id="edificio" name="edificio" class="form-control largo">
                            <option value="">TODOS</option>
                            <option value="1">HUMBERTO PRIMO 607</option>
                            <option value="2">HUMBERTO PRIMO 725</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Orden</label>
                        <select id="assigned-tutor-filter" id="orden" name="orden" class="form-control largo">
                            <?php if ($_POST["orden"] != ''){ ?>
                                <option value="<?php echo $_POST["orden"]; ?>">
                                    <?php 
                            if ($_POST["orden"] == '1'){echo 'ORDENAR POR USUARIO';} 
                            if ($_POST["orden"] == '2'){echo 'ORDENAR POR NOMBRE PLAN';}
                            if ($_POST["orden"] == '3'){echo 'ORDENAR POR PLAN';} 
                            if ($_POST["orden"] == '4'){echo 'ORDENAR POR ESTADO';}
                            if ($_POST["orden"] == '5'){echo 'ORDENAR POR MONTO TOTAL ASCENDENTE';}
                            if ($_POST["orden"] == '6'){echo 'ORDENAR POR MONTO TOTAL DESCENDENTE';}
                            ?>
                            </option>
                            <?php } ?>
                            <option value="">SIN ORDEN</option>
                            <option value="1">ORDENAR POR USUARIO</option>
                            <option value="2">ORDENAR POR NOMBRE PLAN</option>
                            <option value="3">ORDENAR POR PLAN</option>
                            <option value="4">ORDENAR POR ESTADO</option>
                            <option value="5">ORDENAR POR MONTO TOTAL ASCENDENTE</option>
                            <option value="6">ORDENAR POR MONTO TOTAL DESCENDENTE</option>
                        </select>
                    </div>

                    <div style="display:flex;justify-content: flex-end;">
                        <input onClick="filtrar()" class="btn btn-success" name="busqueda" value="Buscar">

                    <?php
                    if(isset($_POST['busqueda'])){;?>

                        <button type="submit" form="formu" style="border:none; background-color:transparent;"><i class="fa-solid fa-file-excel fa-2x" style="color: #1f5120;"></i>CSV</button>
                    </div>
                    <?php }; ?>
<!--                     <div>
                        <h3 style="color:#53AAE0;" id="monto_total">MONTO TOTAL: $<?php $montoTotal; ?></h3>
                    </div> -->
                </div>
            </div>
            <?php 
            $mesActual = date("n");
            $añoActual = date("Y");
            // if ($_POST['buscar'] == ''){ $_POST['buscar'] = ' ';}
            // $aKeyword = explode(" ", $_POST['buscar']);

            if(isset($_POST['busqueda'])){
                $mesFiltro=$_POST['mes'];
                $añoFiltro=$_POST['año'];
                // $_POST["buscar"] == '' AND 
                if ($_POST['mes'] == '' AND $_POST['proveedor'] == '' AND $_POST['edificio'] == '' AND $_POST['año'] == ''){ 
                        $query ="SELECT m.ID_MOVILINEA, m.ID_LINEA, m.EXTRAS, l.NRO, e.ESTADO, p.PLAN, n.NOMBREPLAN, n.MONTO, u.NOMBRE, l.DESCUENTO, l.FECHADESCUENTO, r.ROAMING, pr.PROVEEDOR, m.MONTOTOTAL, m.FECHA
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
                        LEFT JOIN usuarios u ON u.ID_USUARIO = m.ID_USUARIO
                        ORDER BY u.NOMBRE ASC ";
                }elseif(isset($_POST['busqueda'])){
                        $query = "SELECT m.ID_MOVILINEA, m.ID_LINEA, m.EXTRAS, l.NRO, e.ESTADO, p.PLAN, n.NOMBREPLAN, n.MONTO, u.NOMBRE, l.DESCUENTO, l.FECHADESCUENTO, r.ROAMING, pr.PROVEEDOR, m.MONTOTOTAL, m.FECHA
                        FROM movilinea m
                        LEFT JOIN linea l ON m.ID_LINEA = l.ID_LINEA 
                        LEFT JOIN estado_ws e ON e.ID_ESTADOWS = l.ID_ESTADOWS 
                        LEFT JOIN nombreplan n ON n.ID_NOMBREPLAN = l.ID_NOMBREPLAN 
                        LEFT JOIN plan p ON p.ID_PLAN = n.ID_PLAN
                        LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = n.ID_PROVEEDOR 
                        LEFT JOIN roaming r ON r.ID_ROAMING = l.ID_ROAMING
                        LEFT JOIN usuarios u ON u.ID_USUARIO = m.ID_USUARIO
                        INNER JOIN area a ON a.ID_AREA=u.ID_AREA
                        INNER JOIN reparticion rp ON rp.ID_REPA=a.ID_REPA  ";

                        if ($_POST["buscar"] != '' ){ 
                                $query .= " WHERE (YEAR(m.FECHA) LIKE LOWER('%".$aKeyword[0]."%')) ";
                        
                            for($i = 1; $i < count($aKeyword); $i++) {
                            if(!empty($aKeyword[$i])) {
                                $query .= " OR YEAR(m.FECHA) LIKE '%" . $aKeyword[$i] . "%' ";
                            }
                            }
                        }

                        if ($_POST["proveedor"] != '' ){
                            $query .= " AND pr.ID_PROVEEDOR = '".$_POST["proveedor"]."' ";
                        }
                    
                        if ($_POST["mes"] != '' && $_POST['año']){
                            $query .= " AND MONTH(m.FECHA) = $mesFiltro and YEAR(m.FECHA) = $añoFiltro ";
                        }
                        //Se agrega filtracion por edificio, si es 1 se traen todas las que sean reparticion de HP 607 y si es 2 todas las de HP 725
                        if ($_POST["edificio"] == 1 ){
                            $query .= " AND rp.ID_REPA=4 ";
                        }
                        if ($_POST["edificio"] == 2 ){
                            $query .= " AND rp.ID_REPA!=4 ";
                        }
                        //se agrega esta condicion para obtener la ultima modificacion en el mes de la linea. Esto se debe a que por cada modificacion de la linea se inserta una nueva fila
                        $query .= " AND m.ID_MOVILINEA = (
                             SELECT MAX(t.ID_MOVILINEA)
                             FROM movilinea t
                             WHERE m.id_linea = t.id_linea
                             and MONTH(t.FECHA) =  $mesFiltro
                             and YEAR(t.FECHA) = $añoFiltro
                         )";

                        if ($_POST["orden"] == '1' ){
                            $query .= " ORDER BY u.NOMBRE ASC ";
                        }

                        if ($_POST["orden"] == '2' ){
                            $query .= " ORDER BY n.NOMBREPLAN ASC ";
                        }

                        if ($_POST["orden"] == '3' ){
                            $query .= " ORDER BY p.PLAN ASC ";
                        }
                        if ($_POST["orden"] == '4' ){
                            $query .= "  ORDER BY e.ESTADO ASC ";
                        }
                        if ($_POST["orden"] == '5' ){
                            $query .= " ORDER BY m.MONTOTOTAL ASC ";
                        }
                        if ($_POST["orden"] == '6' ){
                            $query .= " ORDER BY m.MONTOTOTAL DESC ";
                        }
                }
            $sql = $datos_base->query($query);
            $numeroSql = mysqli_num_rows($sql);
            ?>
        </form>
    <?php 
        if($_POST["buscar"] == ' ' AND $_POST['mes'] == ''){;
        ?>

        <div class="principal-info" style="margin-top:15px;">


        <?php };?>
    <table class="table_id" style="width: 98%; margin: 0 auto;">
        <thead>
            <tr>
                <th><p style='text-align:right; margin-right: 10px;'>NÚMERO</p></th>
                <th><p style='text-align:left; margin-left: 10px;'>USUARIO</p></th>
                <th><p style='text-align:left; margin-left: 10px;'>PLAN</p></th>
                <th><p style='text-align:left; margin-left: 10px;'>PROVEEDOR</p></th>
                <th><p style='text-align:left; margin-left: 10px;'>ROAMING</p></th>
                <th><p style='text-align:right; margin-right: 10px;'>MONTO</p></th>
                <th><p style='text-align:right; margin-right: 10px;'>EXTRAS</p></th>
                <th><p style='text-align:right; margin-right: 10px;'>DESCUENTO</p></th>
                <th><p style='text-align:center;'>FECHA DESCUENTO</p></th>
                <th><p style='text-align:right; margin-right: 10px;'>MONTO TOTAL</p></th>
                <th><p style='text-align:left; margin-left: 10px;'>ESTADO</p></th>
            </tr>
        </thead>

        <?php 
        $cantidadTotal = 0;
        $montoTotal = 0; 
        $montoTotalSD = 0;
        ?>
        <?php While($rowSql = $sql->fetch_assoc()) {
            $cantidadTotal++;
            $NUMERO=$rowSql['NRO'];
            /* $fecdes = date("d-m-Y", strtotime($rowSql['FECHADESCUENTO'])); */
            $montoTotal = $montoTotal + $rowSql['MONTOTOTAL']; 
            // $montoTotalSD = $montoTotalSD + $rowSql['MONTO']; 
            $fecha = "0000-00-00";
            if($rowSql['FECHADESCUENTO'] == $fecha)
            {
                $fec = date("d-m-Y", strtotime($rowSql['FECHADESCUENTO']));
                $fec = "-";
                /*$fec = "-";*/
            }
            else{
                $fec = date("d-m-Y", strtotime($rowSql['FECHADESCUENTO']));
            }
            echo "
                <tr>
                <td><h4 style='font-size:14px; text-align: right; margin-right: 5px;'>".$rowSql['NRO']."</h4 ></td>
                <td><h4 style='font-size:14px; text-align: left; margin-left: 5px;'>".$rowSql['NOMBRE']."</h4 ></td>
                <td><h4 style='font-size:14px; text-align: left; margin-left: 5px;'>".$rowSql['NOMBREPLAN']." - ".$rowSql['PLAN']."</h4 ></td>
                <td><h4 style='font-size:14px; text-align: left; margin-left: 5px;'>".$rowSql['PROVEEDOR']."</h4 ></td>
                <td><h4 style='font-size:14px; text-align: left; margin-left: 5px;'>".$rowSql['ROAMING']."</h4 ></td>
                <td><h4 style='font-size:14px; text-align: right; margin-right: 5px;color:green;font-weight:bold;'>"."$".$rowSql['MONTO']."</h4 ></td>
                <td><h4 style='font-size:14px; text-align: right; margin-right: 5px;color:red;font-weight:bold;'>"."$".$rowSql['EXTRAS']."</h4 ></td>
                <td><h4 style='font-size:14px; text-align: right; margin-right: 5px;'>".$rowSql['DESCUENTO']."%"."</h4 ></td>
                <td><h4 style='font-size:14px; text-align: center;'>".$fec."</h4 ></td>
                <td><h4 style='font-size:18px; text-align: right; margin-right: 5px;color:green;font-weight:bold;'>"."$".$rowSql['MONTOTOTAL']."</h4 ></td>
                <td><h4 style='font-size:14px; text-align: left; margin-left: 5px;'>".$rowSql['ESTADO']."</h4 ></td>
            </tr>
            ";
        }
        // $_POST['buscar'] != "" AND $_POST['buscar'] != " " OR 
        if($_POST['mes'] != "" OR $_POST['año'] != ""){
            $montoTotal = number_format($montoTotal, 2, ',', '');
            $prov=$_POST["proveedor"]; 
            // $montoTotalSD = number_format($montoTotalSD, 2, ',', '');
            echo "
            <div class=filtrado>
            <h2>Filtrado por:</h2>
                <ul>";
                    // if($_POST['buscar'] != "" AND $_POST['buscar'] != " "){
                    //     echo "<li><u>AÑO</u>: ".$_POST['buscar']."</li>";
                    // }
                    if($_POST['mes'] != ""){
                        switch ($_POST['mes']) {
                            case '01': $mes = 'Enero';break;
                            case '02': $mes = 'Febrero';break;
                            case '03': $mes = 'Marzo';break;
                            case '04': $mes = 'Abril';break;
                            case '05': $mes = 'Mayo';break;
                            case '06': $mes = 'Junio';break;
                            case '07': $mes = 'Julio';break;
                            case '08': $mes = 'Agosto';break;
                            case '09': $mes = 'Septiembre';break;
                            case '10': $mes = 'Octubre';break;
                            case '11': $mes = 'Noviembre';break;
                            case '12': $mes = 'Diciembre';break;
                            default: $mes = 'Non'; break;
                          }
                        echo "<li><u>MES</u>: ".$mes."</li>";
                        echo "<li><u>AÑO</u>: ".$añoFiltro."</li>";
                    }
                    if($_POST['proveedor'] != ""){
                        include("../particular/conexion.php");
                        $sent= "SELECT PROVEEDOR FROM proveedor WHERE ID_PROVEEDOR = $prov";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $proveedor = $row['PROVEEDOR'];
                        echo "<li><u>PROVEEDOR:</u>: ".$proveedor."</li>";
                    }
                    if($_POST['edificio'] == 1){
                        echo "<li><u>EDIFICIO:</u>: HUMBERTO PRIMO 607</li>";
                    }
                    if($_POST['edificio'] == 2){
                        echo "<li><u>EDIFICIO:</u>: HUMBERTO PRIMO 725</li>";
                    }
                    echo"
                </ul>
                <h2>Cantidad de registros: </h2>
                <ul><li>$cantidadTotal</li></ul>
                <!--<h3 style='color:#53AAE0;'>MONTO TOTAL: $$montoTotal</h3>-->";

                // $buscar = $_POST["buscar"];
                //$mesGr = $_POST["mes"];
                $mesFiltro=$_POST['mes'];
                $añoFiltro=$_POST['año'];
                $prov=$_POST["proveedor"]; 
                $queryy="SELECT COUNT(ID_MOVILINEA) AS CANTIDAD, n.NOMBREPLAN AS nomPlanGr, p.PLAN AS planGr, SUM(m.MONTOTOTAL) AS totalGr, m.MONTO, SUM(m.MONTO) as totalSd, pr.PROVEEDOR 
                    FROM movilinea m
                    INNER JOIN nombreplan n ON n.ID_NOMBREPLAN = m.ID_NOMBREPLAN
                    INNER JOIN plan p ON p.ID_PLAN = n.ID_PLAN
                    INNER JOIN proveedor pr on n.ID_PROVEEDOR=pr.ID_PROVEEDOR
                    LEFT JOIN usuarios u ON u.ID_USUARIO = m.ID_USUARIO
                    INNER JOIN area a ON a.ID_AREA=u.ID_AREA
                    INNER JOIN reparticion rp ON rp.ID_REPA=a.ID_REPA  
                    WHERE MONTH(m.FECHA) = $mesFiltro and YEAR(m.FECHA) = $añoFiltro 
                    AND m.ID_MOVILINEA = (
                                  SELECT MAX(t.ID_MOVILINEA)
                                  FROM movilinea t
                                  WHERE m.id_linea = t.id_linea
                                  and MONTH(t.FECHA) =  $mesFiltro
                                  and YEAR(t.FECHA) = $añoFiltro
                              ) ";
                    if ($_POST["proveedor"] != '' ){
                        $queryy .="AND pr.ID_PROVEEDOR = $prov ";
                    }
                    if ($_POST["edificio"] != '' ){

                       if ($_POST["edificio"] == 1 ){
                            $queryy .= " AND rp.ID_REPA=4 ";
                        }
                        if ($_POST["edificio"] == 2 ){
                            $queryy .= " AND rp.ID_REPA!=4 ";
                        }
                    }
                    $queryy .= "GROUP BY n.NOMBREPLAN, n.ID_PLAN
                         ORDER BY n.NOMBREPLAN ASC";

                // if ($_POST["proveedor"] != '' ){
                //     $cons=mysqli_query($datos_base, "SELECT COUNT(ID_MOVILINEA) AS CANTIDAD, n.NOMBREPLAN AS nomPlanGr, p.PLAN AS planGr, SUM(m.MONTOTOTAL) AS totalGr, m.MONTO, SUM(m.MONTO) as totalSd, pr.PROVEEDOR 
                //     FROM movilinea m
                //     INNER JOIN nombreplan n ON n.ID_NOMBREPLAN = m.ID_NOMBREPLAN
                //     INNER JOIN plan p ON p.ID_PLAN = n.ID_PLAN
                //     INNER JOIN proveedor pr on n.ID_PROVEEDOR=pr.ID_PROVEEDOR
                //     LEFT JOIN usuarios u ON u.ID_USUARIO = m.ID_USUARIO
                //         INNER JOIN area a ON a.ID_AREA=u.ID_AREA
                //         INNER JOIN reparticion rp ON rp.ID_REPA=a.ID_REPA  
                //     WHERE MONTH(m.FECHA) = $mesGr AND m.ID_MOVILINEA = (
                //                  SELECT MAX(t.ID_MOVILINEA)
                //                  FROM movilinea t
                //                  WHERE m.id_linea = t.id_linea
                //              )
                //              AND pr.ID_PROVEEDOR = $prov
                //     GROUP BY n.NOMBREPLAN, n.ID_PLAN
                //     ORDER BY n.NOMBREPLAN ASC");
                // }
                // else{
                //     $cons=mysqli_query($datos_base, "SELECT COUNT(ID_MOVILINEA) AS CANTIDAD, n.NOMBREPLAN AS nomPlanGr, p.PLAN AS planGr, SUM(m.MONTOTOTAL) AS totalGr, m.MONTO, SUM(m.MONTO) as totalSd, pr.PROVEEDOR
                //     FROM movilinea m
                //     INNER JOIN nombreplan n ON n.ID_NOMBREPLAN = m.ID_NOMBREPLAN
                //     INNER JOIN plan p ON p.ID_PLAN = n.ID_PLAN
                //     INNER JOIN proveedor pr on n.ID_PROVEEDOR=pr.ID_PROVEEDOR
                //     LEFT JOIN usuarios u ON u.ID_USUARIO = m.ID_USUARIO
                //         INNER JOIN area a ON a.ID_AREA=u.ID_AREA
                //         INNER JOIN reparticion rp ON rp.ID_REPA=a.ID_REPA  
                //     WHERE MONTH(m.FECHA) = $mesGr AND m.ID_MOVILINEA = (
                //                  SELECT MAX(t.ID_MOVILINEA)
                //                  FROM movilinea t
                //                  WHERE m.id_linea = t.id_linea
                //              )
                //     GROUP BY n.NOMBREPLAN, n.ID_PLAN
                //     ORDER BY n.NOMBREPLAN ASC");
                // }


                    //se agrega esta subconsulta para obtener la ultima modificacion en el mes de la linea. Esto se debe a que por cada modificacion de la linea se inserta una nueva fila
                $sqli = $datos_base->query($queryy);
                $num_rows= mysqli_num_rows($sqli);
                echo "
                    <div class='row' style='width:95%;display:flex;flex-direction:row;gap:15px;justify-content: space-between;'>
                        <div class='col'><p style='font-size:18px;text-align:left;text-decoration:underline;'>PLAN</p></div>
                        <div class='col'><p style='font-size:18px;text-decoration:underline;text-align:right;'>CANTIDAD DE LINEAS</p></div>
                        <div class='col'><p style='font-size:18px;text-decoration:underline;text-align:right;'>MONTO CON DESCUENTO</p></div>
                        <div class='col'><p style='font-size:18px;text-decoration:underline;text-align:right;'>MONTO UNITARIO SIN DESCUENTO</p></div>
                        <div class='col'><p style='font-size:18px;text-decoration:underline;text-align:right;'>MONTO SIN DESCUENTO</p></div>
                    
                     </div>";
                     
                // while($consul = mysqli_fetch_array($cons))
                while($rowSqli = $sqli->fetch_assoc()) {
                // {
                //     echo "
                //     <div class='row' style='width:80%;display:flex;flex-direction:row;gap:10px;justify-content: space-between;'>
                //     <div class='col'><p style='font-size:18px;text-align:left;'>".$consul['nomPlanGr']." - ".$consul['planGr'].": </p></div>
                //     <div class='col'><p style='color:green;font-weight:bold;'>".$consul['CANTIDAD']."</p></div>
                //     <div class='col'><p style='color:green;font-weight:bold;'>$".$consul['totalGr']."</p></div>
                //     <div class='col'><p style='color:green;font-weight:bold;'>$".$consul['MONTO']."</p></div>
                //     <div class='col'><p style='color:green;font-weight:bold;'>$".$consul['totalSd']."</p></div>
                    
                //     </div>";
                // }
                
                    echo "
                    <div class='row' style='width:95%;display:flex;flex-direction:row;gap:10px;justify-content: space-between;'>
                    <div class='col'><p style='font-size:18px;text-align:left;'>".$rowSqli['nomPlanGr']." - ".$rowSqli['planGr'].": </p></div>
                    <div class='col'><p style='color:green;font-weight:bold;text-align:right;'>".$rowSqli['CANTIDAD']."</p></div>
                    <div class='col'><p style='color:green;font-weight:bold;text-align:right;'>$".$rowSqli['totalGr']."</p></div>
                    <div class='col'><p style='color:green;font-weight:bold;text-align:right;'>$".$rowSqli['MONTO']."</p></div>
                    <div class='col'><p style='color:green;font-weight:bold;text-align:right;'>$".$rowSqli['totalSd']."</p></div>
                    
                    </div><hr style='height: 1px;'>";
                }

                
                echo "
                <h2>Monto total con descuento:</h2>
                <ul><li style='color:green;font-weight:bold;'>$".$montoTotal."</li></ul>
                <!--<h2>Monto total sin descuento:</h2>
                <ul><li style='color:green;font-weight:bold;'>$".$montoTotalSD."</li></ul>-->
                </div>";
                
            }
    }else{ 
        $query = "";
    }
        echo '</table>';
        ?>
		</div>
        <form id="formu" action="../exportar/ExcelMontosMensuales.php" method="POST">
            <input type="text" id="excel" name="sql" class="valorPeque" readonly="readonly" value="<?php echo $query;?>">
        </form>
	</ >
    <script>
        function montoTotal(monto){
            var montoVar= "MONTO TOTAL: $"+monto;
            $("#monto_total").text(montoVar);
        }
    </script>
    <script>montoTotal(<?php echo $montoTotal;?>);</script>
    <script>
        function filtrar(){
            var mes= $("#mes").val();

            if(mes==null || mes==""){
                Swal.fire({
                        title: "Por favor seleccione el mes a visualizar",
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
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>