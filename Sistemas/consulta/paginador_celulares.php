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
    if (!isset($_GET["proveedor"])){$_GET["proveedor"] = '';}
    if (!isset($_GET['modelo'])){$_GET['modelo'] = '';}
    if (!isset($_GET["estado"])){$_GET["estado"] = '';}
    if (!isset($_GET["orden"])){$_GET["orden"] = '';}
    if (!isset($_GET["reparticion"])){$_GET["reparticion"] = '';}
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
    $where[] = " (LOWER(u.NOMBRE) LIKE LOWER('%".$aKeyword[0]."%') OR c.IMEI LIKE LOWER('%".$aKeyword[0]."%')) ";

    for($i = 1; $i < count($aKeyword); $i++) {
    if(!empty($aKeyword[$i])) {
        $where[] = " OR u.NOMBRE LIKE '%" . $aKeyword[$i] . "%' OR c.IMEI LIKE '%" . $aKeyword[$i] . "%' ";
    }
    }
}
if (!empty($_GET['reparticion'])) {
    $reparticion = intval($_GET['reparticion']);
    $where[] = "r.ID_REPA = $reparticion";
    
}
if (!empty($_GET['proveedor'])) {
    $proveedor = intval($_GET['proveedor']);
    $where[] = "pr.ID_PROVEEDOR = $proveedor";
}
if (!empty($_GET['modelo'])) {
    $modelo = intval($_GET['modelo']);
     $where[] = "mo.ID_MODELO = $modelo";
    //$where[] = "p.ID_AREA = $area";
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
    $order .= " ORDER BY pr.PROVEEDOR ASC ";
}

if ($_GET["orden"] == '3' ){
    $order .= "  ORDER BY mo.MODELO ASC ";
}
if ($_GET["orden"] == '4' ){
$order .= "  ORDER BY e.ESTADO ASC ";
}

// Construir consulta WHERE
$whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Consultar el total de registros
$sqlTotal = "SELECT COUNT(*) as total FROM movicelular m
                INNER JOIN (
                    SELECT ID_CELULAR, MAX(ID_MOVICEL) AS UltimoID
                    FROM movicelular
                    GROUP BY ID_CELULAR
                ) ultimos ON m.ID_CELULAR = ultimos.ID_CELULAR AND m.ID_MOVICEL = ultimos.UltimoID
                LEFT JOIN celular c ON m.ID_CELULAR = c.ID_CELULAR
                LEFT JOIN estado_ws e ON e.ID_ESTADOWS = c.ID_ESTADOWS
                LEFT JOIN modelo mo ON mo.ID_MODELO = c.ID_MODELO
                LEFT JOIN marcas ma ON ma.ID_MARCA = mo.ID_MARCA
                LEFT JOIN procedencia p ON p.ID_PROCEDENCIA = c.ID_PROCEDENCIA
                LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = c.ID_PROVEEDOR 
                LEFT JOIN usuarios u ON u.ID_USUARIO = m.ID_USUARIO 
                LEFT JOIN area a on a.ID_AREA=u.ID_AREA
                LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA $whereClause";
$resultTotal = $datos_base->query($sqlTotal);
$totalRegistros = $resultTotal->fetch_assoc()['total'];
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
?>



<?php 
//query para obtener los equipos
       $query ="SELECT m.ID_MOVICEL, m.ID_CELULAR, c.IMEI, e.ESTADO, u.NOMBRE, pr.PROVEEDOR, mo.MODELO, p.PROCEDENCIA, ma.MARCA, r.REPA
                FROM movicelular m
                INNER JOIN (
                    SELECT ID_CELULAR, MAX(ID_MOVICEL) AS UltimoID
                    FROM movicelular
                    GROUP BY ID_CELULAR
                ) ultimos ON m.ID_CELULAR = ultimos.ID_CELULAR AND m.ID_MOVICEL = ultimos.UltimoID
                LEFT JOIN celular c ON m.ID_CELULAR = c.ID_CELULAR
                LEFT JOIN estado_ws e ON e.ID_ESTADOWS = c.ID_ESTADOWS
                LEFT JOIN modelo mo ON mo.ID_MODELO = c.ID_MODELO
                LEFT JOIN marcas ma ON ma.ID_MARCA = mo.ID_MARCA
                LEFT JOIN procedencia p ON p.ID_PROCEDENCIA = c.ID_PROCEDENCIA
                LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = c.ID_PROVEEDOR 
                LEFT JOIN usuarios u ON u.ID_USUARIO = m.ID_USUARIO 
                LEFT JOIN area a on a.ID_AREA=u.ID_AREA
                LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA    
                $whereClause $order 
                LIMIT $inicio, $registrosPorPagina";
//query que se enviara a excelimpresoras
        $query_excel ="SELECT m.ID_MOVICEL, m.ID_CELULAR, c.IMEI, e.ESTADO, u.NOMBRE, pr.PROVEEDOR, mo.MODELO, p.PROCEDENCIA, ma.MARCA, r.REPA
                FROM movicelular m
                INNER JOIN (
                    SELECT ID_CELULAR, MAX(ID_MOVICEL) AS UltimoID
                    FROM movicelular
                    GROUP BY ID_CELULAR
                ) ultimos ON m.ID_CELULAR = ultimos.ID_CELULAR AND m.ID_MOVICEL = ultimos.UltimoID
                LEFT JOIN celular c ON m.ID_CELULAR = c.ID_CELULAR
                LEFT JOIN estado_ws e ON e.ID_ESTADOWS = c.ID_ESTADOWS
                LEFT JOIN modelo mo ON mo.ID_MODELO = c.ID_MODELO
                LEFT JOIN marcas ma ON ma.ID_MARCA = mo.ID_MARCA
                LEFT JOIN procedencia p ON p.ID_PROCEDENCIA = c.ID_PROCEDENCIA
                LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = c.ID_PROVEEDOR 
                LEFT JOIN usuarios u ON u.ID_USUARIO = m.ID_USUARIO 
                LEFT JOIN area a on a.ID_AREA=u.ID_AREA
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
    'totalCelulares' => $totalRegistros,
    'query' => $query_excel
]);

// $conn->close();
?>

