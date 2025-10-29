<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$consulta=mysqli_query($datos_base, "SELECT * FROM ticket ORDER BY FECHA_INICIO DESC, ID_TICKET DESC");
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ESTADISTICAS</title><meta charset="utf-8">
    <link rel="icon" href="../imagenes/logoInfraestructura.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="../js/./chart.min.js"></script>
    <link href="../estilos/estadisticas.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include('../layout/reportes.php'); ?>
  <div id="titulo" style="margin-top:20px; margin-bottom: 20px;" data-aos="zoom-in">
		<h1>ESTADÍSTICAS</h1>
    </div>
    <section class="cards">
        <div class="cabecerafiltro">
            <form action="./estadisticas.php" class="cabecerafiltro" method="POST">
                <label class="form-label">Período:</label>
                    <input type="date" id="buscafechadesde" name="buscafechadesde" class="form-control" >
                    <input type="date" id="buscafechahasta" name="buscafechahasta" class="form-control" >
                <button name="buscar" id="buscar" style="margin-right: 5px;" class="btn btn-success" type="submit">BUSCAR</button>
                <button href="./estadisticas.php" id="limpiar" class="btn btn-danger">LIMPIAR</button>
            </form>
        </div>
        <?php 
        $sql = "SELECT FECHA_SOLUCION FROM ticket ORDER BY FECHA_SOLUCION ASC LIMIT 1,1";
        $resultado = $datos_base->query($sql);
        $row = $resultado->fetch_assoc();
        $comienzoFecha = $row['FECHA_SOLUCION'];
        
        $sql = "SELECT FECHA_SOLUCION FROM ticket ORDER BY FECHA_SOLUCION DESC LIMIT 1,1";
        $resultado = $datos_base->query($sql);
        $row = $resultado->fetch_assoc();
        $finFecha = $row['FECHA_SOLUCION']; 

        date_default_timezone_set('UTC');
        date_default_timezone_set("America/Buenos_Aires");
        $fechaActual = date('Y-m-d');

        $comienzoFecha = '2020-01-01';
        $finFecha = $fechaActual;

        if(isset($_POST['buscafechadesde']) AND isset($_POST['buscafechahasta'])){
            $comienzoFecha = $_POST['buscafechadesde'];
            $finFecha = $_POST['buscafechahasta'];
        }
        if($_POST['buscafechadesde'] == NULL OR $_POST['buscafechahasta'] == NULL){
            $comienzoFecha = '2020-01-01';
            $finFecha = $fechaActual;
        }

            $fecha1 = date("d-m-Y", strtotime($comienzoFecha));
            $fecha2 = date("d-m-Y", strtotime($finFecha));
            ?>

            <?php
                $sql6 = "SELECT COUNT(ID_TICKET) AS cant FROM ticket WHERE FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha'";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $cant = $row6['cant'];

                $sql6 = "SELECT COUNT(ID_TICKET) AS sol FROM ticket WHERE ID_ESTADO = 2 AND FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha'";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $sol = $row6['sol'];

                $canttot = ($sol / $cant)*100;
            ?>
        <div class="cabecera--periodo">
            <p class="contador-incidentes--peri">
                PERÍODO: <?php echo $fecha1 . " AL " . $fecha2; ?> |
                Porcentaje de incidentes solucionados: <?php echo round($canttot, 2) . "%"; ?>
            </p>
        </div>
    </section>

    <section class="grillasEstadistica">
        <?php
            // Forzar meses en español
            $meses = [
                1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril",
                5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto",
                9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
            ];
            
            // Últimos 6 meses dinámicos
            $fechaHoy = date("Y-m-01"); 
            $fechaInicio = date("Y-m-01", strtotime("-5 months", strtotime($fechaHoy))); 
        ?>
        <div class="grillasEstadistica--mensuales">
            <?php
            $anioActual = date("Y");

            // Array de meses en español
            $meses = [
                1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril",
                5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto",
                9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
            ];

            // 1) Total de tickets del año
            $sqlTotalAnio = "
                SELECT COUNT(ID_TICKET) AS total_anio
                FROM ticket
                WHERE YEAR(FECHA_SOLUCION) = $anioActual
            ";
            $resultTotalAnio = $datos_base->query($sqlTotalAnio);
            $rowTotalAnio = $resultTotalAnio->fetch_assoc();
            $totalAnio = $rowTotalAnio['total_anio'];

            // 2) Mes con más tickets del año
            $sqlMesTop = "
                SELECT MONTH(FECHA_SOLUCION) AS mes, COUNT(ID_TICKET) AS total
                FROM ticket
                WHERE YEAR(FECHA_SOLUCION) = $anioActual
                GROUP BY MONTH(FECHA_SOLUCION)
                ORDER BY total DESC
                LIMIT 1
            ";
            $resultMesTop = $datos_base->query($sqlMesTop);
            $rowMesTop = $resultMesTop->fetch_assoc();
            $mesTop = $rowMesTop['mes'];
            $totalTicketsMes = $rowMesTop['total'];

            // 3) Resolutor con más tickets del año
            $sqlResolutor = "
                SELECT r.RESOLUTOR, COUNT(t.ID_TICKET) AS cantidad
                FROM ticket t
                INNER JOIN resolutor r ON t.ID_RESOLUTOR = r.ID_RESOLUTOR
                WHERE YEAR(t.FECHA_SOLUCION) = $anioActual
                GROUP BY r.ID_RESOLUTOR
                ORDER BY cantidad DESC
                LIMIT 1
            ";
            $resultResolutor = $datos_base->query($sqlResolutor);
            $rowResolutor = $resultResolutor->fetch_assoc();

            // 4) Tipificación más solicitada del año
            $sqlTipificacion = "
                SELECT tip.TIPIFICACION, COUNT(t.ID_TICKET) AS cantidad
                FROM ticket t
                INNER JOIN tipificacion tip ON t.ID_TIPIFICACION = tip.ID_TIPIFICACION
                WHERE YEAR(t.FECHA_SOLUCION) = $anioActual
                GROUP BY tip.ID_TIPIFICACION
                ORDER BY cantidad DESC
                LIMIT 1
            ";
            $resultTipificacion = $datos_base->query($sqlTipificacion);
            $rowTipificacion = $resultTipificacion->fetch_assoc();
            ?>

            <div style="border:1px solid #ccc; padding:15px; width:auto; border-radius:5px;">
                <h2 style="color:#00519C;font-size:18px;font-weight:bold;text-align:center;">
                    RESUMEN INCIDENTES - AÑO <?php echo $anioActual; ?>
                </h2>

                <div>
                    <p style="text-align:left;">
                        <strong>Total de incidentes del año:</strong>
                        <span style="display:inline-block; margin-left:10px; font-size:1em; color: black;">
                            <?php echo $totalAnio; ?>
                        </span>
                    </p>
                </div>

                <hr style="border-top:2px solid #ccc;">

                <p style="text-align:left;">
                    <strong>Mes con más tickets:</strong>
                    <span style="display:inline-block; margin-left:10px; font-size:1em; color: black;"><?php echo $meses[$mesTop] . " -  Cantidad: " . $totalTicketsMes; ?></span>
                </p>

                <p style="text-align:left;">
                    <strong>Resolutor top del año:</strong>
                    <span style="display:inline-block; margin-left:10px; font-size:1em; color: black;"><?php echo $rowResolutor['RESOLUTOR']; ?></span>
                </p>

                <p style="text-align:left;">
                    <strong>Cantidad tickets del resolutor:</strong>
                    <span style="display:inline-block; margin-left:10px; font-size:1em; color: black;"><?php echo $rowResolutor['cantidad']; ?></span>
                </p>

                <p style="text-align:left;">
                    <strong>Tipificación más solicitada del año:</strong>
                    <span style="display:inline-block; margin-left:10px; font-size:0.9em; color: black;"><?php echo $rowTipificacion['TIPIFICACION']; ?></span>
                </p>

                <p style="text-align:left;">
                    <strong>Cantidad tickets de la tipificación:</strong>
                    <span style="display:inline-block; margin-left:10px; font-size:1em; color: black;"><?php echo $rowTipificacion['cantidad']; ?></span>
                </p>
            </div>
<div>
    <h2 style="color:#00519C; font-size:20px; font-weight:bold; text-align:left;">
        INCIDENTES POR RESOLUTOR (AÑO CORRIENTE)
    </h2>

    <table class="table_id" style="width: 98%; margin: 0 auto; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align:left; padding:5px;">RESOLUTOR</th>
                <th style="text-align:right; padding:5px;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $anioActual = date('Y');
        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        $sql = "
            SELECT r.RESOLUTOR, COUNT(t.ID_TICKET) AS cantidad, r.ID_RESOLUTOR
            FROM ticket t
            INNER JOIN resolutor r ON t.ID_RESOLUTOR = r.ID_RESOLUTOR
            WHERE YEAR(t.FECHA_SOLUCION) = '$anioActual'
            GROUP BY r.RESOLUTOR
            ORDER BY cantidad DESC
            LIMIT 5
        ";
        $result = $datos_base->query($sql);

        if($result->num_rows > 0):
            while($row = $result->fetch_assoc()):
                $idRes = $row['ID_RESOLUTOR'];

                $sqlMes = "
                    SELECT MONTH(t.FECHA_SOLUCION) AS mes, COUNT(*) AS cant
                    FROM ticket t
                    WHERE t.ID_RESOLUTOR = '$idRes' AND YEAR(t.FECHA_SOLUCION) = '$anioActual'
                    GROUP BY MONTH(t.FECHA_SOLUCION)
                    ORDER BY MONTH(t.FECHA_SOLUCION) DESC
                ";
                $resMes = $datos_base->query($sqlMes);

                $tablaMeses = '<table style="width:98%; border-collapse: collapse; box-sizing:border-box;">';
                $tablaMeses .= '<tr><th style="border-bottom:1px solid #ccc; padding:5px;">Mes</th><th style="border-bottom:1px solid #ccc; padding:5px;">Cantidad</th></tr>';

                if($resMes->num_rows > 0){
                    while($m = $resMes->fetch_assoc()){
                        $tablaMeses .= '<tr>';
                        $tablaMeses .= '<td style="padding:5px;">'.$meses[$m['mes']-1].'</td>';
                        $tablaMeses .= '<td style="text-align:center; padding:5px;">'.$m['cant'].'</td>';
                        $tablaMeses .= '</tr>';
                    }
                } else {
                    $tablaMeses .= '<tr><td colspan="2" style="text-align:center; padding:5px;">No hay tickets registrados por mes</td></tr>';
                }
                $tablaMeses .= '</table>';
        ?>
            <tr>
                <td>
                    <button class="swal-btn" data-html='<?php echo $tablaMeses; ?>' style="width:100%; text-align:left; padding:5px; border:none; background:none; cursor:pointer;">
                        <?php echo $row['RESOLUTOR']; ?>
                    </button>
                </td>
                <td style="text-align:center;"><?php echo $row['cantidad']; ?></td>
            </tr>
        <?php
            endwhile;
        else:
        ?>
            <tr>
                <td colspan="2" style="text-align:center; padding:10px;">
                    <em>No hay datos registrados</em>
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.swal-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const htmlContent = btn.getAttribute('data-html');
        Swal.fire({
            title: 'Tickets por mes',
            html: htmlContent,
            width: 500,
            showCloseButton: true,    // Solo cruz arriba
            showConfirmButton: false, // Sin botón "Cerrar"
            focusConfirm: false,
            scrollbarPadding: false
        });
    });
});
</script>

            </div>



        <div class="grillasEstadistica--mensuales">
            <div>
                <?php
                $sql = "
                    SELECT 
                        YEAR(FECHA_SOLUCION) AS anio,
                        MONTH(FECHA_SOLUCION) AS mes,
                        COUNT(ID_TICKET) AS cantidad,
                        ROUND(AVG(DATEDIFF(FECHA_SOLUCION, FECHA_INICIO)), 2) AS dias_promedio
                    FROM ticket
                    WHERE FECHA_SOLUCION BETWEEN '$fechaInicio' AND LAST_DAY('$fechaHoy')
                    GROUP BY YEAR(FECHA_SOLUCION), MONTH(FECHA_SOLUCION)
                    ORDER BY anio DESC, mes DESC
                ";
                $result = $datos_base->query($sql);
                ?>

                <div>
                    <h2 style="color:#00519C;font-size:20px;font-weight:bold;text-align:left;">
                        INCIDENTES ÚLTIMOS 6 MESES
                    </h2>
                    
                    <table class="table_id" style="width: 98%; margin: 0 auto;">
                        <thead>
                            <tr>
                                <th><p style="text-align:left;padding:5px;">MES</p></th>
                                <th><p style="text-align:right;padding:5px;">AÑO</p></th>
                                <th><p style="text-align:right;padding:5px;">CANTIDAD</p></th>
                                <th><p style="text-align:right;padding:5px;">PROMEDIO DÍAS RESOLUCIÓN</p></th>
                            </tr>
                        </thead>
                        <tbody id="tabla-datos">
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><h4 style="text-align:left;padding:5px;"><?php echo $meses[$row['mes']]; ?></h4></td>
                                    <td><h4 style="text-align:right;padding:5px;"><?php echo $row['anio']; ?></h4></td>
                                    <td><h4 style="text-align:right;padding:5px;"><?php echo $row['cantidad']; ?></h4></td>
                                    <td><h4 style="text-align:right;padding:5px;"><?php echo $row['dias_promedio']; ?></h4></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
           <div>
                <div>       
                    <?php
                    // Mes y año actuales
                    $anioActual = date('Y');
                    $mesActual = date('m');

                    // Consulta: cantidad de tickets por resolutor en el mes corriente (máximo 6)
                    $sql = "
                        SELECT 
                            r.RESOLUTOR,
                            COUNT(t.ID_TICKET) AS cantidad
                        FROM ticket t
                        INNER JOIN resolutor r ON t.ID_RESOLUTOR = r.ID_RESOLUTOR
                        WHERE YEAR(t.FECHA_SOLUCION) = '$anioActual'
                        AND MONTH(t.FECHA_SOLUCION) = '$mesActual'
                        GROUP BY r.RESOLUTOR
                        ORDER BY cantidad DESC
                        LIMIT 6
                    ";

                    $result = $datos_base->query($sql);
                    ?>

                    <div>
                        <h2 style="color:#00519C;font-size:20px;font-weight:bold;text-align:left;">
                            INCIDENTES POR RESOLUTOR (6) - MES CORRIENTE
                        </h2>

                        <table class="table_id" style="width: 98%; margin: 0 auto;">
                            <thead>
                                <tr>
                                    <th><p style="text-align:left;padding:5px;">RESOLUTOR</p></th>
                                    <th><p style="text-align:right;padding:5px;">CANTIDAD</p></th>
                                </tr>
                            </thead>
                            <tbody id="tabla-datos">
                                <?php if($result->num_rows > 0): ?>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><h4 style="text-align:left;padding:5px;"><?php echo $row['RESOLUTOR']; ?></h4></td>
                                            <td><h4 style="text-align:center;"><?php echo $row['cantidad']; ?></h4></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" style="text-align:center;padding:10px;">
                                            <em>Aún no hay datos registrados en el corriente mes</em>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="grillasEstadistica--mensuales">
            <div>
                <?php
                $sql = "
                    SELECT anio, mes, RESOLUTOR, cantidad
                    FROM (
                        SELECT 
                            YEAR(t.FECHA_SOLUCION) AS anio,
                            MONTH(t.FECHA_SOLUCION) AS mes,
                            r.RESOLUTOR,
                            COUNT(t.ID_TICKET) AS cantidad,
                            ROW_NUMBER() OVER (PARTITION BY YEAR(t.FECHA_SOLUCION), MONTH(t.FECHA_SOLUCION) ORDER BY COUNT(t.ID_TICKET) DESC) AS rn
                        FROM ticket t
                        INNER JOIN resolutor r ON t.ID_RESOLUTOR = r.ID_RESOLUTOR
                        WHERE t.FECHA_SOLUCION BETWEEN '$fechaInicio' AND LAST_DAY('$fechaHoy')
                        GROUP BY YEAR(t.FECHA_SOLUCION), MONTH(t.FECHA_SOLUCION), r.RESOLUTOR
                    ) ranked
                    WHERE rn = 1
                    ORDER BY anio DESC, mes DESC
                ";
                $result = $datos_base->query($sql);
                ?>

                <div>
                    <h2 style="color:#00519C;font-size:20px;font-weight:bold;text-align:left;">
                        TOP RESOLUTOR POR MES - ÚLTIMOS 6 MESES
                    </h2>

                    <table class="table_id" style="width: 98%; margin: 0 auto;">
                        <thead>
                            <tr>
                                <th><p style="text-align:left;padding:5px;">RESOLUTOR</p></th>
                                <th><p style="text-align:left;padding:5px;">MES</p></th>
                                <th><p style="text-align:right;padding:5px;">AÑO</p></th>
                                <th><p style="text-align:right;padding:5px;">CANTIDAD</p></th>
                            </tr>
                        </thead>
                        <tbody id="tabla-datos">
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><h4 style="text-align:left;padding:5px;"><?php echo $row['RESOLUTOR']; ?></h4></td>
                                    <td><h4 style="text-align:left;padding:5px;"><?php echo $meses[$row['mes']]; ?></h4></td>
                                    <td><h4 style="text-align:center;"><?php echo $row['anio']; ?></h4></td>
                                    <td><h4 style="text-align:center;"><?php echo $row['cantidad']; ?></h4></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <?php
                $sql = "
                    SELECT anio, mes, TIPIFICACION, cantidad
                    FROM (
                        SELECT 
                            YEAR(t.FECHA_SOLUCION) AS anio,
                            MONTH(t.FECHA_SOLUCION) AS mes,
                            tip.TIPIFICACION,
                            COUNT(t.ID_TICKET) AS cantidad,
                            ROW_NUMBER() OVER (
                                PARTITION BY YEAR(t.FECHA_SOLUCION), MONTH(t.FECHA_SOLUCION) 
                                ORDER BY COUNT(t.ID_TICKET) DESC
                            ) AS rn
                        FROM ticket t
                        INNER JOIN tipificacion tip ON t.ID_TIPIFICACION = tip.ID_TIPIFICACION
                        WHERE t.FECHA_SOLUCION BETWEEN '$fechaInicio' AND LAST_DAY('$fechaHoy')
                        GROUP BY YEAR(t.FECHA_SOLUCION), MONTH(t.FECHA_SOLUCION), tip.TIPIFICACION
                    ) ranked
                    WHERE rn = 1
                    ORDER BY anio DESC, mes DESC
                ";
                $result = $datos_base->query($sql);
                ?>

                <div>
                    <h2 style="color:#00519C;font-size:20px;font-weight:bold;text-align:left;">
                        TOP TIPIFICACIÓN POR MES - ÚLTIMOS 6 MESES
                    </h2>

                    <table class="table_id" style="width: 98%; margin: 0 auto;">
                        <thead>
                            <tr>
                                <th><p style="text-align:left;padding:5px;">TIPIFICACIÓN</p></th>
                                <th><p style="text-align:left;padding:5px;">MES</p></th>
                                <th><p style="text-align:center;padding:5px;">AÑO</p></th>
                                <th><p style="text-align:center;padding:5px;">CANTIDAD</p></th>
                            </tr>
                        </thead>
                        <tbody id="tabla-datos">
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><h4 style="text-align:left;padding:5px;"><?php echo $row['TIPIFICACION']; ?></h4></td>
                                    <td><h4 style="text-align:left;padding:5px;"><?php echo $meses[$row['mes']]; ?></h4></td>
                                    <td><h4 style="text-align:center;"><?php echo $row['anio']; ?></h4></td>
                                    <td><h4 style="text-align:center;"><?php echo $row['cantidad']; ?></h4></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </section>


  <section class="contenedor">
    <div class="grafico" style="width: 1200px; height: 720px;">
        <h1><u>INCIDENTES POR MES</u></h1>
        <canvas id="MiGrafica5" ></canvas>
    </div>
  </section>

  <section class="contenedor">
    <div class="grafico" style="width: 1200px; height: 720px;">
            <h1><u>INCIDENTES POR RESOLUTOR</u></h1>
            <canvas id="MiGrafica" ></canvas>
    </div>
    <div class="grafico2" style="width: 1200px; height: 720px;">
            <h1><u>INCIDENTES POR USUARIO</u></h1>
            <canvas id="MiGrafica4" ></canvas>
    </div>
  </section>

  <section class="contenedor1">
    <div class="grafico1" style="width: 1200px; height: 720px;">
            <h1><u>INCIDENTES POR TIPIFICACIÓN</u></h1>
            <canvas id="MiGrafica2" ></canvas>
    </div>
    <div class="informacion1" style="width: 1200px; height: 720px;">
        <h1><u>INCIDENTES POR ÁREA</u></h1>
        <canvas id="MiGrafica3" ></canvas>
    </div>
  </section>

<!--   <section class="contenedor2">
    <div class="informacion" style="width: 600px; height: 750px;">
        <h1><u>INCIDENTES POR ESTADO</u></h1>
        <canvas id="MiGrafica1" ></canvas>
    </div>
  </section> -->


  


    <?php 
    include('../particular/conexion.php');

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 0, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res = $row6['RESOLUTOR'];
    $tot = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 1, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res1 = $row6['RESOLUTOR'];
    $tot1 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 2, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res2 = $row6['RESOLUTOR'];
    $tot2 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 3, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res3 = $row6['RESOLUTOR'];
    $tot3 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 4, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res4 = $row6['RESOLUTOR'];
    $tot4 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 5, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res5 = $row6['RESOLUTOR'];
    $tot5 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 6, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res6 = $row6['RESOLUTOR'];
    $tot6 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 7, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res7 = $row6['RESOLUTOR'];
    $tot7 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 8, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res8 = $row6['RESOLUTOR'];
    $tot8 = $row6['RecuentoFilas'];

    $sql6 = "SELECT r.RESOLUTOR, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY r.RESOLUTOR HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 9, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res9 = $row6['RESOLUTOR'];
    $tot9 = $row6['RecuentoFilas'];
    
    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha'";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $total = $row6['TOTAL'];

    $prom = round(($tot * 100)/$total,2);
    $prom1 = round(($tot1 * 100)/$total,2);
    $prom2 = round(($tot2 * 100)/$total,2);
    $prom3 = round(($tot3 * 100)/$total,2);
    $prom4 = round(($tot4 * 100)/$total,2);
    $prom5 = round(($tot5 * 100)/$total,2);
    $prom6 = round(($tot6 * 100)/$total,2);
    $prom7 = round(($tot7 * 100)/$total,2);
    $prom8 = round(($tot8 * 100)/$total,2);
    $prom9 = round(($tot9 * 100)/$total,2);







/* ESTADOS */

    $sql6 = "SELECT e.ESTADO, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY e.ESTADO HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 0, 1;";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est1 = $row6['ESTADO'];
    $etot1 = $row6['RecuentoFilas'];

    $sql6 = "SELECT e.ESTADO, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY e.ESTADO HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 1, 1;";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est2 = $row6['ESTADO'];
    $etot2 = $row6['RecuentoFilas'];

    $sql6 = "SELECT e.ESTADO, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY e.ESTADO HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 2, 1;";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est3 = $row6['ESTADO'];
    $etot3 = $row6['RecuentoFilas'];

    $sql6 = "SELECT e.ESTADO, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY e.ESTADO HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 3, 1;";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est4 = $row6['ESTADO'];
    $etot4 = $row6['RecuentoFilas'];

    $sql6 = "SELECT e.ESTADO, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY e.ESTADO HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 4, 1;";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est5 = $row6['ESTADO'];
    $etot5 = $row6['RecuentoFilas'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha'";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $etotal = $row6['TOTAL'];

    $eprom1 = round(($etot1 * 100)/$etotal,2);
    $eprom2 = round(($etot2 * 100)/$etotal,2);
    $eprom3 = round(($etot3 * 100)/$etotal,2);
    $eprom4 = round(($etot4 * 100)/$etotal,2);
    $eprom5 = round(($etot5 * 100)/$etotal,2);









/* TIPIFICACIONES */

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 0, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip1 = $row6['TIPIFICACION'];
    $ttip1 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 1, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip2 = $row6['TIPIFICACION'];
    $ttip2 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 2, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip3 = $row6['TIPIFICACION'];
    $ttip3 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 3, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip4 = $row6['TIPIFICACION'];
    $ttip4 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 4, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip5 = $row6['TIPIFICACION'];
    $ttip5 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 5, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip6 = $row6['TIPIFICACION'];
    $ttip6 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 6, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip7 = $row6['TIPIFICACION'];
    $ttip7 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 7, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip8 = $row6['TIPIFICACION'];
    $ttip8 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 8, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip9 = $row6['TIPIFICACION'];
    $ttip9 = $row6['RecuentoFilas'];

    $sql6 = "SELECT ti.TIPIFICACION, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN tipificacion ti ON ti.ID_TIPIFICACION = t.ID_TIPIFICACION WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY ti.TIPIFICACION HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 9, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tip10 = $row6['TIPIFICACION'];
    $ttip10 = $row6['RecuentoFilas'];


    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha'";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $ttotal = $row6['TOTAL'];

    $tprom1 = round(($ttip1 * 100)/$ttotal,2);
    $tprom2 = round(($ttip2 * 100)/$ttotal,2);
    $tprom3 = round(($ttip3 * 100)/$ttotal,2);
    $tprom4 = round(($ttip4 * 100)/$ttotal,2);
    $tprom5 = round(($ttip5 * 100)/$ttotal,2);
    $tprom6 = round(($ttip6 * 100)/$ttotal,2);
    $tprom7 = round(($ttip7 * 100)/$ttotal,2);
    $tprom8 = round(($ttip8 * 100)/$ttotal,2);
    $tprom9 = round(($ttip9 * 100)/$ttotal,2);
    $tprom10 = round(($ttip10 * 100)/$ttotal,2);









/* AREAS*/

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 0, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are1 = $row6['AREA'];
    $tare1 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 1, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are2 = $row6['AREA'];
    $tare2 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 2, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are3 = $row6['AREA'];
    $tare3 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 3, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are4 = $row6['AREA'];
    $tare4 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 4, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are5 = $row6['AREA'];
    $tare5 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 5, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are6 = $row6['AREA'];
    $tare6 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 6, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are7 = $row6['AREA'];
    $tare7 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 7, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are8 = $row6['AREA'];
    $tare8 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 8, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are9 = $row6['AREA'];
    $tare9 = $row6['RecuentoFilas'];

    $sql6 = "SELECT a.AREA, COUNT(*) AS RecuentoFilas FROM ticket t LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO LEFT JOIN area a ON a.ID_AREA = u.ID_AREA WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY a.AREA HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 9, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $are10 = $row6['AREA'];
    $tare10 = $row6['RecuentoFilas'];


    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha'";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $atotal = $row6['TOTAL'];

    $aprom1 = round(($tare1 * 100)/$atotal,2);
    $aprom2 = round(($tare2 * 100)/$atotal,2);
    $aprom3 = round(($tare3 * 100)/$atotal,2);
    $aprom4 = round(($tare4 * 100)/$atotal,2);
    $aprom5 = round(($tare5 * 100)/$atotal,2);
    $aprom6 = round(($tare6 * 100)/$atotal,2);
    $aprom7 = round(($tare7 * 100)/$atotal,2);
    $aprom8 = round(($tare8 * 100)/$atotal,2);
    $aprom9 = round(($tare9 * 100)/$atotal,2);
    $aprom10 = round(($tare10 * 100)/$atotal,2);





/* USUARIOS */

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 0, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu1 = $row6['NOMBRE'];
    $tusu1 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 1, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu2 = $row6['NOMBRE'];
    $tusu2 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 2, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu3 = $row6['NOMBRE'];
    $tusu3 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 3, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu4 = $row6['NOMBRE'];
    $tusu4 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 4, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu5 = $row6['NOMBRE'];
    $tusu5 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 5, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu6 = $row6['NOMBRE'];
    $tusu6 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 6, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu7 = $row6['NOMBRE'];
    $tusu7 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 7, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu8 = $row6['NOMBRE'];
    $tusu8 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 8, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu9 = $row6['NOMBRE'];
    $tusu9 = $row6['RecuentoFilas'];

    $sql6 = "SELECT u.NOMBRE, COUNT(*) AS RecuentoFilas FROM ticket t INNER JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO WHERE t.FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha' GROUP BY u.NOMBRE HAVING COUNT(*) > 1 ORDER BY RecuentoFilas DESC LIMIT 9, 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $usu10 = $row6['NOMBRE'];
    $tusu10 = $row6['RecuentoFilas'];


    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE FECHA_SOLUCION BETWEEN '$comienzoFecha' AND '$finFecha'";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $utotal = $row6['TOTAL'];

    $uprom1 = round(($tusu1 * 100)/$utotal,2);
    $uprom2 = round(($tusu2 * 100)/$utotal,2);
    $uprom3 = round(($tusu3 * 100)/$utotal,2);
    $uprom4 = round(($tusu4 * 100)/$utotal,2);
    $uprom5 = round(($tusu5 * 100)/$utotal,2);
    $uprom6 = round(($tusu6 * 100)/$utotal,2);
    $uprom7 = round(($tusu7 * 100)/$utotal,2);
    $uprom8 = round(($tusu8 * 100)/$utotal,2);
    $uprom9 = round(($tusu9 * 100)/$utotal,2);
    $uprom10 = round(($tusu10 * 100)/$utotal,2);



/* ------------------------------------------- */
/* ESTADISTICAS MENSUAL*/
/* ------------------------------------------- */
$arraym2 = [];
$arrayf2 = [];

$sql6 = "SELECT COUNT(*) AS total, FECHA_SOLUCION
FROM ticket
WHERE ID_ESTADO = 2
GROUP BY MONTH(FECHA_SOLUCION), YEAR(FECHA_SOLUCION) 
ORDER BY FECHA_SOLUCION DESC 
LIMIT 0,1";
$result6 = $datos_base->query($sql6);
$row6 = $result6->fetch_assoc();
$montol1 = $row6['total'];
$fechal1 = $row6['FECHA_SOLUCION'];
$fecl1 = date("m/Y", strtotime($fechal1));
if(isset($montol1)){
    array_push($arraym2, $montol1);
    array_push($arrayf2, $fecl1);
}

$sql6 = "SELECT COUNT(*) AS total, FECHA_SOLUCION
FROM ticket
WHERE ID_ESTADO = 2
GROUP BY MONTH(FECHA_SOLUCION), YEAR(FECHA_SOLUCION) 
ORDER BY FECHA_SOLUCION DESC 
LIMIT 1,1";
$result6 = $datos_base->query($sql6);
$row6 = $result6->fetch_assoc();
$montol2 = $row6['total'];
$fechal2 = $row6['FECHA_SOLUCION'];
$fecl2 = date("m/Y", strtotime($fechal2));
if(isset($montol2)){
    array_push($arraym2, $montol2);
    array_push($arrayf2, $fecl2);
}

$sql6 = "SELECT COUNT(*) AS total, FECHA_SOLUCION
FROM ticket
WHERE ID_ESTADO = 2
GROUP BY MONTH(FECHA_SOLUCION), YEAR(FECHA_SOLUCION) 
ORDER BY FECHA_SOLUCION DESC 
LIMIT 2,1";
$result6 = $datos_base->query($sql6);
$row6 = $result6->fetch_assoc();
$montol3 = $row6['total'];
$fechal3 = $row6['FECHA_SOLUCION'];
$fecl3 = date("m/Y", strtotime($fechal3));
if(isset($montol3)){
    array_push($arraym2, $montol3);
    array_push($arrayf2, $fecl3);
}

$sql6 = "SELECT COUNT(*) AS total, FECHA_SOLUCION
FROM ticket
WHERE ID_ESTADO = 2
GROUP BY MONTH(FECHA_SOLUCION), YEAR(FECHA_SOLUCION) 
ORDER BY FECHA_SOLUCION DESC 
LIMIT 3,1";
$result6 = $datos_base->query($sql6);
$row6 = $result6->fetch_assoc();
$montol4 = $row6['total'];
$fechal4 = $row6['FECHA_SOLUCION'];
$fecl4 = date("m/Y", strtotime($fechal4));
if(isset($montol4)){
    array_push($arraym2, $montol4);
    array_push($arrayf2, $fecl4);
}

$sql6 = "SELECT COUNT(*) AS total, FECHA_SOLUCION
FROM ticket
WHERE ID_ESTADO = 2
GROUP BY MONTH(FECHA_SOLUCION), YEAR(FECHA_SOLUCION) 
ORDER BY FECHA_SOLUCION DESC 
LIMIT 4,1";
$result6 = $datos_base->query($sql6);
$row6 = $result6->fetch_assoc();
$montol5 = $row6['total'];
$fechal5 = $row6['FECHA_SOLUCION'];
$fecl5 = date("m/Y", strtotime($fechal5));
if(isset($montol5)){
    array_push($arraym2, $montol5);
    array_push($arrayf2, $fecl5);
}

$sql6 = "SELECT COUNT(*) AS total, FECHA_SOLUCION
FROM ticket
WHERE ID_ESTADO = 2
GROUP BY MONTH(FECHA_SOLUCION), YEAR(FECHA_SOLUCION) 
ORDER BY FECHA_SOLUCION DESC 
LIMIT 5,1";
$result6 = $datos_base->query($sql6);
$row6 = $result6->fetch_assoc();
$montol6 = $row6['total'];
$fechal6 = $row6['FECHA_SOLUCION'];
$fecl6 = date("m/Y", strtotime($fechal6));
if(isset($montol6)){
    array_push($arraym2, $montol6);
    array_push($arrayf2, $fecl6);
}

$sql6 = "SELECT COUNT(*) AS total, FECHA_SOLUCION
FROM ticket
WHERE ID_ESTADO = 2
GROUP BY MONTH(FECHA_SOLUCION), YEAR(FECHA_SOLUCION) 
ORDER BY FECHA_SOLUCION DESC 
LIMIT 6,1";
$result6 = $datos_base->query($sql6);
$row6 = $result6->fetch_assoc();
$montol7 = $row6['total'];
$fechal7 = $row6['FECHA_SOLUCION'];
$fecl7 = date("m/Y", strtotime($fechal7));
if(isset($montol7)){
    array_push($arraym2, $montol7);
    array_push($arrayf2, $fecl7);
}

$sql6 = "SELECT COUNT(*) AS total, FECHA_SOLUCION
FROM ticket
WHERE ID_ESTADO = 2
GROUP BY MONTH(FECHA_SOLUCION), YEAR(FECHA_SOLUCION) 
ORDER BY FECHA_SOLUCION DESC 
LIMIT 7,1";
$result6 = $datos_base->query($sql6);
$row6 = $result6->fetch_assoc();
$montol8 = $row6['total'];
$fechal8 = $row6['FECHA_SOLUCION'];
$fecl8 = date("m/Y", strtotime($fechal8));
if(isset($montol8)){
    array_push($arraym2, $montol8);
    array_push($arrayf2, $fecl8);
}

$sql6 = "SELECT COUNT(*) AS total, FECHA_SOLUCION
FROM ticket
WHERE ID_ESTADO = 2
GROUP BY MONTH(FECHA_SOLUCION), YEAR(FECHA_SOLUCION) 
ORDER BY FECHA_SOLUCION DESC 
LIMIT 8,1";
$result6 = $datos_base->query($sql6);
$row6 = $result6->fetch_assoc();
$montol9 = $row6['total'];
$fechal9 = $row6['FECHA_SOLUCION'];
$fecl9 = date("m/Y", strtotime($fechal9));
if(isset($montol9)){
    array_push($arraym2, $montol9);
    array_push($arrayf2, $fecl9);
}

$sql6 = "SELECT COUNT(*) AS total, FECHA_SOLUCION
FROM ticket
WHERE ID_ESTADO = 2
GROUP BY MONTH(FECHA_SOLUCION), YEAR(FECHA_SOLUCION) 
ORDER BY FECHA_SOLUCION DESC 
LIMIT 9,1";
$result6 = $datos_base->query($sql6);
$row6 = $result6->fetch_assoc();
$montol10 = $row6['total'];
$fechal10 = $row6['FECHA_SOLUCION'];
$fecl10 = date("m/Y", strtotime($fechal10));
if(isset($montol10)){
    array_push($arraym2, $montol10);
    array_push($arrayf2, $fecl10);
}

$sql6 = "SELECT COUNT(*) AS total, FECHA_SOLUCION
FROM ticket
WHERE ID_ESTADO = 2
GROUP BY MONTH(FECHA_SOLUCION), YEAR(FECHA_SOLUCION) 
ORDER BY FECHA_SOLUCION DESC 
LIMIT 10,1";
$result6 = $datos_base->query($sql6);
$row6 = $result6->fetch_assoc();
$montol11 = $row6['total'];
$fechal11 = $row6['FECHA_SOLUCION'];
$fecl11 = date("m/Y", strtotime($fechal11));
if(isset($montol11)){
    array_push($arraym2, $montol11);
    array_push($arrayf2, $fecl11);
}

$sql6 = "SELECT COUNT(*) AS total, FECHA_SOLUCION
FROM ticket
WHERE ID_ESTADO = 2
GROUP BY MONTH(FECHA_SOLUCION), YEAR(FECHA_SOLUCION) 
ORDER BY FECHA_SOLUCION DESC 
LIMIT 11,1";
$result6 = $datos_base->query($sql6);
$row6 = $result6->fetch_assoc();
$montol12 = $row6['total'];
$fechal12 = $row6['FECHA_SOLUCION'];
$fecl12 = date("m/Y", strtotime($fechal12));
if(isset($montol12)){
    array_push($arraym2, $montol12);
    array_push($arrayf2, $fecl12);
}

    ?>
    <footer>
		<div class="footer">
			<div class="container-fluid">
				<div class="row">
					<img src="../imagenes/cba-logo.png" class="img-fluid">
				</div>
			</div>
		</div>
	</footer>
</body>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
  		AOS.init();
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
    let miCanvas=document.getElementById("MiGrafica").getContext("2d");

    var chart = new Chart(miCanvas,{
        type: "bar",
        data:{
            labels:[
            "<?php echo "1- $res: $tot || $prom%";?>", 
            "<?php echo "2- $res1: $tot1 || $prom1%";?>", 
            "<?php echo "3- $res2: $tot2 || $prom2%";?>", 
            "<?php echo "4- $res3: $tot3 || $prom3%";?>",
            "<?php echo "5- $res4: $tot4 || $prom4%";?>", 
            "<?php echo "6- $res5: $tot5 || $prom5%";?>", 
            "<?php echo "7- $res6: $tot6 || $prom6%";?>",
            "<?php echo "8- $res7: $tot7 || $prom7%";?>", 
            "<?php echo "9- $res8: $tot8 || $prom8%";?>",
            "<?php echo "10- $res9: $tot9 || $prom9%";?>",],

            datasets:[{
                label: "INCIDENTES POR RESOLUTOR",
                backgroundColor: [
                    "rgb(0, 197, 255)", 
                    "rgb(255, 0, 0)",
                    "rgb(103, 1, 1)",
                    "rgb(255, 0, 189)", 
                    "rgb(96, 2, 121)",
                    "rgb(0, 224, 255)",
                    "rgb(0, 97, 111)", 
                    "rgb(0, 255, 42)",
                    "rgb(0, 121, 20)",
                    "rgb(248, 255, 21)",],
                borderColor: "black",
                data:[
                    <?php echo $tot;?>, 
                    <?php echo $tot1 ;?>, 
                    <?php echo $tot2 ;?>, 
                    <?php echo $tot3 ;?>,
                    <?php echo $tot4 ;?>, 
                    <?php echo $tot5 ;?>,
                    <?php echo $tot6 ;?>, 
                    <?php echo $tot7 ;?>,
                    <?php echo $tot8 ;?>, 
                    <?php echo $tot9 ;?> ]
            }]
        }
    })
    </script>

<script>
    let miCanvas4=document.getElementById("MiGrafica4").getContext("2d");

    var chart = new Chart(miCanvas4,{
        type: "bar",
        data:{
            labels:[
            "<?php echo "1- $usu1: $tusu1 || $uprom1%";?>", 
            "<?php echo "2- $usu2: $tusu2 || $uprom2%";?>", 
            "<?php echo "3- $usu3: $tusu3 || $uprom3%";?>", 
            "<?php echo "4- $usu4: $tusu4 || $uprom4%";?>",
            "<?php echo "5- $usu5: $tusu5 || $uprom5%";?>", 
            "<?php echo "6- $usu6: $tusu6 || $uprom6%";?>", 
            "<?php echo "7- $usu7: $tusu7 || $uprom7%";?>", 
            "<?php echo "8- $usu8: $tusu8 || $uprom8%";?>",
            "<?php echo "9- $usu9: $tusu9 || $uprom9%";?>",
            "<?php echo "10- $usu10: $tusu10 || $uprom10%";?>",],

            datasets:[{
                label: "INCIDENTES POR ESTADO",
                backgroundColor: [
                    "rgb(0,197,255)", 
                    "rgb(255, 0, 0)",
                    "rgb(103, 1, 1)",
                    "rgb(255, 0, 189)", 
                    "rgb(96, 2, 121)",
                    "rgb(0, 224, 255)",
                    "rgb(0, 97, 111)", 
                    "rgb(0, 255, 42)",
                    "rgb(0, 121, 20)",
                    "rgb(232, 255, 0)"],
                borderColor: "black",
                data:[
                    <?php echo $tusu1;?>, 
                    <?php echo $tusu2 ;?>, 
                    <?php echo $tusu3 ;?>, 
                    <?php echo $tusu4 ;?>,
                    <?php echo $tusu5;?>, 
                    <?php echo $tusu6 ;?>, 
                    <?php echo $tusu7 ;?>, 
                    <?php echo $tusu8 ;?>,
                    <?php echo $tusu9 ;?>,
                    <?php echo $tusu10 ;?>]
            }]
        }
    })
    </script>

<script>
    let miCanvas2=document.getElementById("MiGrafica2").getContext("2d");

    var chart = new Chart(miCanvas2,{
        type: "bar",
        data:{
            labels:[
            "<?php echo "1- $tip1: $ttip1 || $tprom1%";?>", 
            "<?php echo "2- $tip2: $ttip2 || $tprom2%";?>", 
            "<?php echo "3- $tip3: $ttip3 || $tprom3%";?>", 
            "<?php echo "4- $tip4: $ttip4 || $tprom4%";?>",
            "<?php echo "5- $tip5: $ttip5 || $tprom5%";?>", 
            "<?php echo "6- $tip6: $ttip6 || $tprom6%";?>", 
            "<?php echo "7- $tip7: $ttip7 || $tprom7%";?>", 
            "<?php echo "8- $tip8: $ttip8 || $tprom8%";?>",
            "<?php echo "9- $tip9: $ttip9 || $tprom9%";?>",
            "<?php echo "10- $tip10: $ttip10 || $tprom10%";?>",],

            datasets:[{
                label: "INCIDENTES POR TIPIFICACIÓN",
                backgroundColor: [
                    "rgb(0,197,255)", 
                    "rgb(255, 0, 0)",
                    "rgb(103, 1, 1)",
                    "rgb(255, 0, 189)", 
                    "rgb(96, 2, 121)",
                    "rgb(0, 224, 255)",
                    "rgb(0, 97, 111)", 
                    "rgb(0, 255, 42)",
                    "rgb(0, 121, 20)",
                    "rgb(232, 255, 0)"],
                borderColor: "black",
                data:[
                    <?php echo $ttip1;?>, 
                    <?php echo $ttip2 ;?>, 
                    <?php echo $ttip3 ;?>, 
                    <?php echo $ttip4 ;?>,
                    <?php echo $ttip5;?>, 
                    <?php echo $ttip6 ;?>, 
                    <?php echo $ttip7 ;?>, 
                    <?php echo $ttip8 ;?>,
                    <?php echo $ttip9 ;?>,
                    <?php echo $ttip10 ;?>]
            }]
        }
    })
    </script>

<script>
    let miCanvas3=document.getElementById("MiGrafica3").getContext("2d");

    var chart = new Chart(miCanvas3,{
        type: "bar",
        data:{
            labels:[
            "<?php echo "1- $are1: $tare1 || $aprom1%";?>", 
            "<?php echo "2- $are2: $tare2 || $aprom2%";?>", 
            "<?php echo "3- $are3: $tare3 || $aprom3%";?>", 
            "<?php echo "4- $are4: $tare4 || $aprom4%";?>",
            "<?php echo "5- $are5: $tare5 || $aprom5%";?>", 
            "<?php echo "6- $are6: $tare6 || $aprom6%";?>", 
            "<?php echo "7- $are7: $tare7 || $aprom7%";?>", 
            "<?php echo "8- $are8: $tare8 || $aprom8%";?>",
            "<?php echo "9- $are9: $tare9 || $aprom9%";?>",
            "<?php echo "10- $are10: $tare10 || $aprom10%";?>",],

            datasets:[{
                label: "INCIDENTES POR ÁREA",
                backgroundColor: [
                    "rgb(0,197,255)", 
                    "rgb(255, 0, 0)",
                    "rgb(103, 1, 1)",
                    "rgb(255, 0, 189)", 
                    "rgb(96, 2, 121)",
                    "rgb(0, 224, 255)",
                    "rgb(0, 97, 111)", 
                    "rgb(0, 255, 42)",
                    "rgb(0, 121, 20)",
                    "rgb(232, 255, 0)"],
                borderColor: "black",
                data:[
                    <?php echo $tare1;?>, 
                    <?php echo $tare2 ;?>, 
                    <?php echo $tare3 ;?>, 
                    <?php echo $tare4 ;?>,
                    <?php echo $tare5;?>, 
                    <?php echo $tare6 ;?>, 
                    <?php echo $tare7 ;?>, 
                    <?php echo $tare8 ;?>,
                    <?php echo $tare9 ;?>,
                    <?php echo $tare10 ;?>]
            }]
        }
    })
    </script>
    <script>
    let miCanvas5=document.getElementById("MiGrafica5").getContext("2d");

var chart = new Chart(miCanvas5,{
    type: "line",
    data:{
        labels:[
            <?php 
                $largo = count($arrayf2);
                $i = $largo -1;
                while($i >= 0){
                    echo json_encode($arrayf2[$i]).',';
                    $i--;
                }
                ;?>
        ],
        datasets:[{
            label: "INCIDENTES",
            backgroundColor: "blue",
            borderColor: "rgb(0, 197, 255)",
            data:[
                <?php 
                $largo = count($arraym2);
                $i = $largo - 1;
                while($i >= 0){
                    echo json_encode($arraym2[$i]).',';
                    $i--;
                }
                ;?>
                ]
        },
    ]
    }
})
    </script>

	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
		const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
		const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
	</script>
	
</html>