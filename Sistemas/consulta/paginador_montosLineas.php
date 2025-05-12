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
<?php
        if (!isset($_GET['buscar'])){$_GET['buscar'] = '';}
        if (!isset($_GET['nombreplan'])){$_GET['nombreplan'] = '';}
        if (!isset($_GET["orden"])){$_GET["orden"] = '';}
        if (!isset($_GET["estado"])){$_GET["estado"] = '';}
        if (!isset($_GET["reparticion"])){$_GET["reparticion"] = '';}
        if (!isset($_GET["proveedor"])){$_GET["proveedor"] = '';}
    
    ?>


<?php
// Parámetros de paginación
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$registrosPorPagina = 30; // Cambiar según la necesidad
$inicio = ($pagina - 1) * $registrosPorPagina;


$filtroUsuario = isset($_GET['usuario']) && $_GET['usuario'] !== '' ? $_GET['usuario'] : null;


$where = [];



if (!empty($_GET['busqueda'])) {
    $aKeyword = explode(" ", $_GET['busqueda']);
    // $usuario = intval($_GET['usuario']);
    $where[] = " (LOWER(u.NOMBRE) LIKE LOWER('%".$aKeyword[0]."%') OR l.NRO LIKE LOWER('%".$aKeyword[0]."%')) ";

    for($i = 1; $i < count($aKeyword); $i++) {
    if(!empty($aKeyword[$i])) {
        $where[] = " OR u.NOMBRE LIKE '%" . $aKeyword[$i] . "%' OR l.NRO LIKE '%" . $aKeyword[$i] . "%' ";
    }
    }
}
if (!empty($_GET['reparticion'])) {
    $reparticion = intval($_GET['reparticion']);
    $where[] = "re.ID_REPA = $reparticion";   
}
if (!empty($_GET['nombreplan'])) {
    $nombreplan = intval($_GET['nombreplan']);
    $where[] = "n.ID_NOMBREPLAN = $nombreplan";
}
if (!empty($_GET['proveedor'])) {
    $proveedor = intval($_GET['proveedor']);
    $where[] = "n.ID_PROVEEDOR = $proveedor";
}
if (!empty($_GET['estado'])) {
    $estado = intval($_GET['estado']);
    $where[] = "e.ID_ESTADOWS = $estado ";
    
}

$order =" GROUP BY l.NRO ";
//Se construye el segmiento del orden de las filas de la consulta

$tipo_orden=$_GET["orden"];
if ($_GET["orden"] == '1' ){
    $order .= " ORDER BY u.NOMBRE ASC ";
}

if ($_GET["orden"] == '2' ){
    $order .= " ORDER BY n.NOMBREPLAN ASC ";
}

if ($_GET["orden"] == '3' ){
    $order .= "  ORDER BY e.ESTADO ASC ";
}
if ($_GET["orden"] == '4' ){
    $order .= " ORDER BY m.MONTOTOTAL ASC ";
}
if ($_GET["orden"] == '5' ){
$order .= "  ORDER BY m.MONTOTOTAL DESC ";
}

// Construir consulta WHERE
$whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Consultar el total de registros
$sqlTotal = "SELECT COUNT(*) as total FROM movilinea m
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
                LEFT JOIN usuarios u ON u.ID_USUARIO = l.ID_USUARIO 
                LEFT JOIN area a on a.ID_AREA=u.ID_AREA
                LEFT JOIN reparticion re on a.ID_REPA=re.ID_REPA $whereClause";
$resultTotal = $datos_base->query($sqlTotal);
$totalRegistros = $resultTotal->fetch_assoc()['total'];
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
?>



<?php 
//query para obtener los equipos
       $query ="SELECT m.ID_MOVILINEA, m.ID_LINEA, m.EXTRAS, l.NRO, e.ESTADO, p.PLAN, n.NOMBREPLAN, n.MONTO, u.NOMBRE, l.DESCUENTO, l.FECHADESCUENTO, pr.PROVEEDOR, m.MONTOTOTAL, re.REPA
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
                LEFT JOIN usuarios u ON u.ID_USUARIO = l.ID_USUARIO 
                LEFT JOIN area a on a.ID_AREA=u.ID_AREA
                LEFT JOIN reparticion re on a.ID_REPA=re.ID_REPA   
                $whereClause $order 
                LIMIT $inicio, $registrosPorPagina";
//query que se enviara a excelimpresoras
        $query_excel ="SELECT m.ID_MOVILINEA, m.ID_LINEA, m.EXTRAS, l.NRO, e.ESTADO, p.PLAN, n.NOMBREPLAN, n.MONTO, u.NOMBRE, l.DESCUENTO, l.FECHADESCUENTO, pr.PROVEEDOR, m.MONTOTOTAL, re.REPA
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
                LEFT JOIN usuarios u ON u.ID_USUARIO = l.ID_USUARIO 
                LEFT JOIN area a on a.ID_AREA=u.ID_AREA
                LEFT JOIN reparticion re on a.ID_REPA=re.ID_REPA 
        $whereClause $order ";


//Se agregan todas las filas a un array que se enviara en formato json junto con el total dde paginas, pagina actual, el total de incidentes y la sentencia query que se utilizara para generar el excel        
$sql = $datos_base->query($query);
$datos = [];
while ($fila = $sql->fetch_assoc()) {
    $datos[] = $fila;
}

// Devolver los datos en formato JSON
echo json_encode([
    'datos' => $datos,
    'pagina' => $pagina,
    'totalPaginas' => $totalPaginas,
    'totalMontosLineas' => $totalRegistros,
    'query' => $query_excel
]);

// $conn->close();
?>

