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
        if (!isset($_GET['area'])){$_GET['area'] = '';}
        if (!isset($_GET["tipo"])){$_GET["tipo"] = '';}
        if (!isset($_GET["orden"])){$_GET["orden"] = '';}
        if (!isset($_GET['marca'])){$_GET['marca'] = '';}
        if (!isset($_GET["estado"])){$_GET["estado"] = '';}
        if (!isset($_GET["reparticion"])){$_GET["reparticion"] = '';}
    
    ?>


<?php
// Parámetros de paginación
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$registrosPorPagina = 30; // Cambiar según la necesidad
$inicio = ($pagina - 1) * $registrosPorPagina;


$filtroUsuario = isset($_GET['usuario']) && $_GET['usuario'] !== '' ? $_GET['usuario'] : null;


$where = [];

$where[] = " p.ID_TIPOP IN (5, 6, 9, 11, 12)";


if (!empty($_GET['buscar'])) {
    $aKeyword = explode(" ", $_GET['buscar']);
    // $usuario = intval($_GET['usuario']);
    $where[] = " (LOWER(u.NOMBRE) LIKE LOWER('%".$aKeyword[0]."%') OR LOWER(mo.MODELO) LIKE LOWER('%".$aKeyword[0]."%')) ";

    for($i = 1; $i < count($aKeyword); $i++) {
    if(!empty($aKeyword[$i])) {
        $where[] = " OR u.NOMBRE LIKE '%" . $aKeyword[$i] . "%' OR mo.MODELO LIKE '%" . $aKeyword[$i] . "%' ";
    }
    }
}
if (!empty($_GET['reparticion'])) {
    $reparticion = intval($_GET['reparticion']);
    $where[] = "r.ID_REPA = $reparticion";
    
}
if (!empty($_GET['marca'])) {
    $marca = intval($_GET['marca']);
    $where[] = "m.ID_MARCA = $marca";
}
if (!empty($_GET['area'])) {
    $area = intval($_GET['area']);
     $where[] = "u.ID_AREA = $area";
    //$where[] = "p.ID_AREA = $area";
}
if (!empty($_GET['tipo'])) {
    $tipop = intval($_GET['tipo']);
    $where[] = "t.ID_TIPOP = $tipop";
}
if (!empty($_GET['estado'])) {
    $estado = intval($_GET['estado']);
    $where[] = "e.ID_ESTADOWS = $estado ";
    
}
//Se construye el segmiento del orden de las filas de la consulta
$order="";
$tipo_orden=$_GET["orden"];
if ($_GET["orden"] == '1' ){
    $order .= " ORDER BY u.NOMBRE ASC ";
}

if ($_GET["orden"] == '2' ){
    $order .= " ORDER BY a.AREA ASC ";
}

if ($_GET["orden"] == '3' ){
    $order .= "  ORDER BY t.TIPO ASC ";
}
if ($_GET["orden"] == '4' ){
    $order .= " ORDER BY m.MARCA ASC ";
}
if ($_GET["orden"] == '5' ){
$order .= "  ORDER BY e.ESTADO ASC ";
}

// Construir consulta WHERE
$whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Consultar el total de registros
$sqlTotal = "SELECT COUNT(*) as total FROM periferico p 
                            LEFT JOIN modelo mo ON mo.ID_MODELO = p.ID_MODELO
                            LEFT JOIN equipo_periferico ep ON p.ID_PERI = ep.ID_PERI
                            LEFT JOIN inventario i ON ep.ID_WS = i.ID_WS
                            LEFT JOIN wsusuario ws ON i.ID_WS = ws.ID_WS
                            LEFT JOIN usuarios u ON ws.ID_USUARIO = u.ID_USUARIO
                            LEFT JOIN area a ON a.ID_AREA = u.ID_AREA
                            LEFT JOIN marcas m ON m.ID_MARCA = p.ID_MARCA
                            LEFT JOIN estado_ws e ON e.ID_ESTADOWS = p.ID_ESTADOWS
                            LEFT JOIN tipop t ON t.ID_TIPOP = p.ID_TIPOP
                            LEFT JOIN reparticion r ON a.ID_REPA = r.ID_REPA $whereClause";
$resultTotal = $datos_base->query($sqlTotal);
$totalRegistros = $resultTotal->fetch_assoc()['total'];
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
?>



<?php 
//query para obtener los equipos
       $query ="SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, p.TIPOP, e.ESTADO, r.REPA
                FROM periferico p 
                LEFT JOIN modelo mo ON mo.ID_MODELO = p.ID_MODELO
                LEFT JOIN equipo_periferico ep ON p.ID_PERI = ep.ID_PERI
                LEFT JOIN inventario i ON ep.ID_WS = i.ID_WS
                LEFT JOIN wsusuario ws ON i.ID_WS = ws.ID_WS
                LEFT JOIN usuarios u ON ws.ID_USUARIO = u.ID_USUARIO
                LEFT JOIN area a ON a.ID_AREA = u.ID_AREA
                LEFT JOIN marcas m ON m.ID_MARCA = p.ID_MARCA
                LEFT JOIN estado_ws e ON e.ID_ESTADOWS = p.ID_ESTADOWS
                LEFT JOIN tipop t ON t.ID_TIPOP = p.ID_TIPOP
                LEFT JOIN reparticion r ON a.ID_REPA = r.ID_REPA   
                $whereClause $order 
                LIMIT $inicio, $registrosPorPagina";
//query que se enviara a excelimpresoras
        $query_excel ="SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, p.TIPOP, e.ESTADO, r.REPA
                FROM periferico p 
                LEFT JOIN modelo mo ON mo.ID_MODELO = p.ID_MODELO
                LEFT JOIN equipo_periferico ep ON p.ID_PERI = ep.ID_PERI
                LEFT JOIN inventario i ON ep.ID_WS = i.ID_WS
                LEFT JOIN wsusuario ws ON i.ID_WS = ws.ID_WS
                LEFT JOIN usuarios u ON ws.ID_USUARIO = u.ID_USUARIO
                LEFT JOIN area a ON a.ID_AREA = u.ID_AREA
                LEFT JOIN marcas m ON m.ID_MARCA = p.ID_MARCA
                LEFT JOIN estado_ws e ON e.ID_ESTADOWS = p.ID_ESTADOWS
                LEFT JOIN tipop t ON t.ID_TIPOP = p.ID_TIPOP
                LEFT JOIN reparticion r ON a.ID_REPA = r.ID_REPA
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
    'totalOtrosP' => $totalRegistros,
    'query' => $query_excel
]);

// $conn->close();
?>

