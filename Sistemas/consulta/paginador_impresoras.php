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
        if (!isset($_GET["orden"])){$_GET["orden"] = '';}
        if (!isset($_GET['tipop'])){$_GET['tipop'] = 'IMPRESORA';}
        if (!isset($_GET["impresora"])){$_GET["impresora"] = '';}
        if (!isset($_GET["marca"])){$_GET["marca"] = '';}
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

$where[] = " p.TIPOP = 'IMPRESORA' ";


if (!empty($_GET['buscar'])) {
    $aKeyword = explode(" ", $_GET['buscar']);
    // $usuario = intval($_GET['usuario']);
    $where[] = " (u.NOMBRE LIKE LOWER('%".$aKeyword[0]."%') OR p.SERIEG LIKE LOWER('%".$aKeyword[0]."%'))";

    for($i = 1; $i < count($aKeyword); $i++) {
    if(!empty($aKeyword[$i])) {
        $where[] = " OR u.NOMBRE LIKE '%" . $aKeyword[$i] . "%' OR p.SERIEG LIKE '%" . $aKeyword[$i] . "%'";
    }
    }
}
if (!empty($_GET['reparticion'])) {
    $reparticion = intval($_GET['reparticion']);
    $where[] = "r.ID_REPA = $reparticion";
    
}
if (!empty($_GET['area'])) {
    $area = intval($_GET['area']);
    // $where[] = "u.ID_AREA = $area";
    $where[] = "p.ID_AREA = $area";
}
if (!empty($_GET['impresora'])) {
    $imp = intval($_GET['impresora']);
    $where[] = "mo.ID_MODELO = $imp";
}
if (!empty($_GET['marca'])) {
    $marca = intval($_GET['marca']);
    $where[] = "m.ID_MARCA = $marca";
}
if (!empty($_GET['tipop'])) {
    $tipop = intval($_GET['tipop']);
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
    $order .= " ORDER BY p.SERIEG ASC ";
 }

 if ($_GET["orden"] == '3' ){
    $order .= " ORDER BY a.AREA ASC ";
 }
 if ($_GET["orden"] == '4' ){
    $order .= " ORDER BY mo.MODELO ASC ";
}

if ($_GET["orden"] == '5' ){
        $order .= " ORDER BY m.MARCA ASC ";
}

if ($_GET["orden"] == '6' ){
        $order .= "  ORDER BY t.TIPO ASC ";
}

if ($_GET["orden"] == '7' ){
    $order .= "  ORDER BY e.ESTADO ASC ";
}

// Construir consulta WHERE
$whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Consultar el total de registros
$sqlTotal = "SELECT COUNT(*) as total FROM periferico p 
LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
        LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
        LEFT JOIN equipo_periferico ep ON p.ID_PERI=ep.ID_PERI
        LEFT JOIN inventario i ON ep.ID_WS=i.ID_WS
        LEFT JOIN wsusuario ws ON i.ID_WS=ws.ID_WS
        LEFT JOIN usuarios u ON ws.ID_USUARIO=u.ID_USUARIO
        INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
        INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP
        LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = p.ID_ESTADOWS
        LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA   $whereClause";
$resultTotal = $datos_base->query($sqlTotal);
$totalRegistros = $resultTotal->fetch_assoc()['total'];
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
?>



<?php 
//query para obtener los equipos
       $query ="SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, e.ESTADO, r.REPA			
       FROM periferico p 
       LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
        LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
        LEFT JOIN equipo_periferico ep ON p.ID_PERI=ep.ID_PERI
        LEFT JOIN inventario i ON ep.ID_WS=i.ID_WS
        LEFT JOIN wsusuario ws ON i.ID_WS=ws.ID_WS
        LEFT JOIN usuarios u ON ws.ID_USUARIO=u.ID_USUARIO
        INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
        INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP
        LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = p.ID_ESTADOWS
        LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA  
                $whereClause $order 
                LIMIT $inicio, $registrosPorPagina";
//query que se enviara a excelimpresoras
        $query_excel ="SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, e.ESTADO, r.REPA			
        FROM periferico p 
        LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
        LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
        LEFT JOIN equipo_periferico ep ON p.ID_PERI=ep.ID_PERI
        LEFT JOIN inventario i ON ep.ID_WS=i.ID_WS
        LEFT JOIN wsusuario ws ON i.ID_WS=ws.ID_WS
        LEFT JOIN usuarios u ON ws.ID_USUARIO=u.ID_USUARIO
        INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
        INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP
        LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = p.ID_ESTADOWS
        LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA   
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
    'totalImpresoras' => $totalRegistros,
    'query' => $query_excel
]);

// $conn->close();
?>

