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
        if (!isset($_GET['descripcion'])){$_GET['descripcion'] = '';}
        if (!isset($_GET['usuario'])){$_GET['usuario'] = '';}
        if (!isset($_GET['resolutor'])){$_GET['resolutor'] = '';}
        if (!isset($_GET["estado"])){$_POST["estado"] = '';}
        if (!isset($_GET['fechaDesde'])){$_GET['fechaDesde'] = '';}
        if (!isset($_GET['fechaHasta'])){$_GET['fechaHasta'] = '';}
        if (!isset($_GET["orden"])){$_GET["orden"] = '';}
        if (!isset($_GET["edificio"])){$_GET["edificio"] = '';}
    ?>


<?php
// Parámetros de paginación
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$registrosPorPagina = 30; // Cambiar según la necesidad
$inicio = ($pagina - 1) * $registrosPorPagina;


$filtroUsuario = isset($_GET['usuario']) && $_GET['usuario'] !== '' ? $_GET['usuario'] : null;


$where = [];
if (!empty($_GET['descripcion'])) {
    $descripcion = $_GET['descripcion'];
    $where[] = "t.DESCRIPCION LIKE '%$descripcion%'";
}

if (!empty($_GET['fechaDesde']) && !empty($_GET['fechaHasta'])) {
    $fechaDesde = $_GET['fechaDesde'];
    $fechaHasta = $_GET['fechaHasta'];
/*     $fechaDesde = date("d-m-Y", strtotime($_GET['fechaDesde']));
    $fechaHasta = date("d-m-Y", strtotime($_GET['fechaHasta'])); */
    $where[] = "t.FECHA_INICIO BETWEEN '$fechaDesde' AND '$fechaHasta'";
}

if (!empty($_GET['usuario'])) {
    $usuario = intval($_GET['usuario']);
    $where[] = "t.ID_USUARIO = $usuario";
}

if (!empty($_GET['estado'])) {
    $estado = intval($_GET['estado']);
    $where[] = "t.ID_ESTADO = $estado";
}

if (!empty($_GET['resolutor'])) {
    $resolutor = intval($_GET['resolutor']);
    $where[] = "t.ID_RESOLUTOR = $resolutor";
}

if (!empty($_GET['edificio'])) {
    $edificio = intval($_GET['edificio']);
    if ($_GET["edificio"] == 1 ){
        $where[] = "re.ID_REPA=4";
    }
    if ($_GET["edificio"] == 2 ){
        $where[] = "re.ID_REPA!=4 ";
    }
    
}
//Se construye el segmiento del orden de las filas de la consulta
$order="";
if ($_GET["orden"] == '1' ){
    $order .= " ORDER BY t.ID_TICKET DESC ";
}

if ($_GET["orden"] == '2' ){
$order .= " ORDER BY u.NOMBRE ASC ";
}

if ($_GET["orden"] == '3' ){
$order .= "  ORDER BY e.ESTADO ASC ";
}

if ($_GET["orden"] == '4' ){
$order .= "  ORDER BY r.RESOLUTOR ASC ";
}
if ($_GET["orden"] == '5' ){
$order .= "  ORDER BY t.FECHA_SOLUCION DESC ";
}
elseif ($_GET["orden"] == '' ) { 
$order .= "  ORDER BY t.FECHA_INICIO DESC, t.ID_TICKET DESC ";
}


// Construir consulta WHERE
$whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Consultar el total de registros
$sqlTotal = "SELECT COUNT(*) as total FROM ticket t 
LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO
LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR
LEFT JOIN area a ON a.ID_AREA=u.ID_AREA
LEFT JOIN reparticion re ON re.ID_REPA=a.ID_REPA  $whereClause";
$resultTotal = $datos_base->query($sqlTotal);
$totalRegistros = $resultTotal->fetch_assoc()['total'];
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
?>



<?php 
//query para obtener los incidentes
       $query ="SELECT t.ID_TICKET, DATE_FORMAT(t.FECHA_INICIO, '%d-%m-%Y') AS FECHA_INICIO, u.NOMBRE, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, DATE_FORMAT(t.FECHA_SOLUCION, '%d-%m-%Y') AS FECHA_SOLUCION, r.RESOLUTOR, re.REPA, a.AREA
                FROM ticket t 
                LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO
                LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
                LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
                LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR
                LEFT JOIN area a ON a.ID_AREA=u.ID_AREA
                LEFT JOIN reparticion re ON re.ID_REPA=a.ID_REPA 
                $whereClause $order 
                LIMIT $inicio, $registrosPorPagina";

        $query_excel ="SELECT t.ID_TICKET, DATE_FORMAT(t.FECHA_INICIO, '%d-%m-%Y') AS FECHA_INICIO, u.NOMBRE, t.DESCRIPCION, p.PRIORIDAD, e.ESTADO, t.NRO_EQUIPO, DATE_FORMAT(t.FECHA_SOLUCION, '%d-%m-%Y') AS FECHA_SOLUCION, r.RESOLUTOR, re.REPA, a.AREA
                FROM ticket t 
                LEFT JOIN usuarios u ON u.ID_USUARIO = t.ID_USUARIO
                LEFT JOIN prioridad p ON  p.ID_PRIORIDAD = t.ID_PRIORIDAD 
                LEFT JOIN estado e ON e.ID_ESTADO = t.ID_ESTADO
                LEFT JOIN resolutor r ON r.ID_RESOLUTOR = t.ID_RESOLUTOR
                LEFT JOIN area a ON a.ID_AREA=u.ID_AREA
                LEFT JOIN reparticion re ON re.ID_REPA=a.ID_REPA 
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
    'totalIncidentes' => $totalRegistros,
    'query' => $query_excel
]);

// $conn->close();
?>

