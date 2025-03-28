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
<head>
	<title>MONTOS LÍNEAS</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymus"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<?php 
    $query ="SELECT m.ID_MOVILINEA, m.ID_LINEA, m.EXTRAS, l.NRO, e.ESTADO, p.PLAN, n.NOMBREPLAN, n.MONTO, u.NOMBRE, l.DESCUENTO, l.FECHADESCUENTO, r.ROAMING, pr.PROVEEDOR, m.MONTOTOTAL
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
    ";
    $sql = $datos_base->query($query);

    $numeroSql = mysqli_num_rows($sql);
?>
<table>
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


<?php While($rowSql = $sql->fetch_assoc()) {
            $cantidadTotal++;
            $NUMERO=$rowSql['NRO'];
            /* $fecdes = date("d-m-Y", strtotime($rowSql['FECHADESCUENTO'])); */

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
            $monto=$rowSql['MONTO'];
            $descuento=($rowSql['DESCUENTO'])*0.01;
            $extras=$rowSql['EXTRAS'];
            $valor_descuento=$monto*$descuento;
            $monto_total=$monto-$valor_descuento+$extras;
            echo "
                <tr>
                <td><h4 style='font-size:16px; text-align: right; margin-right: 5px;'>".$rowSql['NRO']."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$rowSql['NOMBRE']."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$rowSql['NOMBREPLAN']." - ".$rowSql['PLAN']."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$rowSql['PROVEEDOR']."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$rowSql['ROAMING']."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: right; margin-right: 5px;'>"."$".$monto."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: right; margin-right: 5px;'>"."$".$extras."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: right; margin-right: 5px;'>".$rowSql['DESCUENTO']."%"."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: center;'>".$fec."</h4 ></td>
                <td><h4 style='font-size:18px; text-align: right; margin-right: 5px;color:green;font-weight:bold;'>"."$".$monto_total."</h4 ></td>
                <td><h4 style='font-size:16px; text-align: left; margin-left: 5px;'>".$rowSql['ESTADO']."</h4 ></td>
                
            </tr>
            ";
        }
        echo '</table>';
        ?>