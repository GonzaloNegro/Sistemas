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
        if (!isset($_GET['busqueda'])){$_GET['busqueda'] = '';}
        if (!isset($_GET['area'])){$_GET['area'] = '';}
        if (!isset($_GET["reparticion"])){$_GET["reparticion"] = '';}
        if (!isset($_GET["so"])){$_GET["so"] = '';}
        if (!isset($_GET["micro"])){$_GET["micro"] = '';}
        if (!isset($_GET["tipows"])){$_GET["tipows"] = '';}
        if (!isset($_GET['estado'])){$_GET['estado'] = '';}
        if (!isset($_GET["orden"])){$_GET["orden"] = '';}
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
    $where[] = " (u.NOMBRE LIKE LOWER('%".$aKeyword[0]."%') OR i.SERIEG LIKE LOWER('%".$aKeyword[0]."%') OR i.OBSERVACION LIKE LOWER('%".$aKeyword[0]."%')) ";

    for($i = 1; $i < count($aKeyword); $i++) {
    if(!empty($aKeyword[$i])) {
        $where[] = " OR u.NOMBRE LIKE '%" . $aKeyword[$i] . "%' OR i.SERIEG LIKE '%" . $aKeyword[$i] . "%' OR i.OBSERVACION LIKE '%" . $aKeyword[$i] . "%' ";
    }
    }
}
if (!empty($_GET['reparticion'])) {
    $reparticion = intval($_GET['reparticion']);
    $where[] = "a.ID_REPA = $reparticion";
    
}
if (!empty($_GET['area'])) {
    $area = intval($_GET['area']);
    $where[] = "u.ID_AREA = $area";
}
if (!empty($_GET['so'])) {
    $so = intval($_GET['so']);
    $where[] = "s.ID_SO = $so";
}
if (!empty($_GET['micro'])) {
    $micro = intval($_GET['micro']);
    $where[] = "m.ID_MICRO = $micro";
}
if (!empty($_GET['tipows'])) {
    $tipows = intval($_GET['tipows']);
    $where[] = "t.ID_TIPOWS = $tipows";
}
if (!empty($_GET['estado'])) {
    $estado = intval($_GET['estado']);
    $where[] = "e.ID_ESTADOWS = $estado ";
    
}
//Se construye el segmiento del orden de las filas de la consulta
$order="";
$tipo_orden=$_GET["orden"];
if ($tipo_orden == '1' ){
    $order .= " ORDER BY u.NOMBRE ASC ";
}

if ($tipo_orden == '2' ){
$order .= " ORDER BY a.AREA ASC ";
}

if ($tipo_orden == '3' ){
$order .= "  ORDER BY r.REPA ASC ";
}
if ($tipo_orden == '4' ){
$order .= " ORDER BY s.SIST_OP ASC ";
}

if ($tipo_orden == '5' ){
$order .= " ORDER BY m.MICRO ASC ";
}

if ($tipo_orden == '6' ){
$order .= "  ORDER BY t.TIPOWS ASC ";
}

if ($tipo_orden == '7' ){
$order .= "  ORDER BY e.ESTADO ASC ";
}

// Construir consulta WHERE
$whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Consultar el total de registros
$sqlTotal = "SELECT COUNT(*) as total FROM inventario i 
LEFT JOIN area AS a ON i.ID_AREA = a.ID_AREA
LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
LEFT JOIN tipows AS t ON t.ID_TIPOWS = i.ID_TIPOWS
LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
LEFT JOIN so AS s ON s.ID_SO = i.ID_SO
LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = i.ID_ESTADOWS  $whereClause";
$resultTotal = $datos_base->query($sqlTotal);
$totalRegistros = $resultTotal->fetch_assoc()['total'];
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
?>



<?php 
//query para obtener los equipos
       $query ="SELECT i.ID_WS, a.AREA, r.REPA, u.NOMBRE, t.TIPOWS, i.SERIEG, s.SIST_OP, m.MICRO, i.OBSERVACION, e.ESTADO
       FROM inventario i 
       LEFT JOIN area AS a ON i.ID_AREA = a.ID_AREA
       LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
       LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
       LEFT JOIN tipows AS t ON t.ID_TIPOWS = i.ID_TIPOWS
       LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
       LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
       LEFT JOIN so AS s ON s.ID_SO = i.ID_SO
       LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = i.ID_ESTADOWS 
                $whereClause $order 
                LIMIT $inicio, $registrosPorPagina";

        $query_excel ="SELECT i.ID_WS, a.AREA, r.REPA, u.NOMBRE, t.TIPOWS, i.SERIEG, s.SIST_OP, m.MICRO, i.OBSERVACION, e.ESTADO
        FROM inventario i 
        LEFT JOIN area AS a ON i.ID_AREA = a.ID_AREA
        LEFT JOIN reparticion AS r ON r.ID_REPA = a.ID_REPA
        LEFT JOIN usuarios AS u ON u.ID_USUARIO = i.ID_USUARIO
        LEFT JOIN tipows AS t ON t.ID_TIPOWS = i.ID_TIPOWS
        LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
        LEFT JOIN micro AS m ON m.ID_MICRO = mw.ID_MICRO
        LEFT JOIN so AS s ON s.ID_SO = i.ID_SO
        LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = i.ID_ESTADOWS
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
    'totalInventario' => $totalRegistros,
    'query' => $query_excel
]);

// $conn->close();
?>

