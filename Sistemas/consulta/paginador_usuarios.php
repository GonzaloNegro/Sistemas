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
        if (!isset($_GET['usuario'])){$_GET['usuario'] = '';}
        if (!isset($_GET['area'])){$_GET['area'] = '';}
        if (!isset($_GET["reparticion"])){$_POST["reparticion"] = '';}
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



if (!empty($_GET['usuario'])) {
    $aKeyword = explode(" ", $_GET['usuario']);
    // $usuario = intval($_GET['usuario']);
    $where[] = " (u.NOMBRE LIKE LOWER('%".$aKeyword[0]."%') OR u.CUIL LIKE LOWER('%".$aKeyword[0]."%')) ";

    for($i = 1; $i < count($aKeyword); $i++) {
    if(!empty($aKeyword[$i])) {
        $where[] = " OR u.NOMBRE LIKE '%" . $aKeyword[$i] . "%' OR u.CUIL LIKE '%" . $aKeyword[$i] . "%' ";
    }
    }
}

if (!empty($_GET['estado'])) {
    $estado = intval($_GET['estado']);
    if ($estado == '1' ){
        $where[] = "u.ACTIVO = 'ACTIVO' ";
    }
    if ($estado == '2' ){
        $where[] = "u.ACTIVO = 'INACTIVO' ";
    }
}


if (!empty($_GET['area'])) {
    $area = intval($_GET['area']);
    $where[] = "u.ID_AREA = $area";
}

if (!empty($_GET['reparticion'])) {
    $reparticion = intval($_GET['reparticion']);
    $where[] = "a.ID_REPA = $reparticion";
    
}

//Se construye el segmiento del orden de las filas de la consulta
$order="";
if ($_GET["orden"] == '1' ){
    $order .= " ORDER BY u.NOMBRE ASC ";
}

if ($_GET["orden"] == '2' ){
$order .= " ORDER BY a.AREA ASC ";
}

if ($_GET["orden"] == '3' ){
$order .= "  ORDER BY r.REPA ASC ";
}

// Construir consulta WHERE
$whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Consultar el total de registros
$sqlTotal = "SELECT COUNT(*) as total FROM usuarios u
LEFT JOIN area a ON  u.ID_AREA = a.ID_AREA
LEFT JOIN reparticion r ON r.ID_REPA = a.ID_REPA  $whereClause";
$resultTotal = $datos_base->query($sqlTotal);
$totalRegistros = $resultTotal->fetch_assoc()['total'];
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
?>



<?php 
//query para obtener los incidentes
       $query ="SELECT u.ID_USUARIO, u.NOMBRE, u.CUIL, a.AREA, u.INTERNO, u.ACTIVO, r.REPA
                FROM usuarios u
                LEFT JOIN area a ON  u.ID_AREA = a.ID_AREA
                LEFT JOIN reparticion r ON r.ID_REPA = a.ID_REPA 
                $whereClause $order 
                LIMIT $inicio, $registrosPorPagina";

        $query_excel ="SELECT u.ID_USUARIO, u.NOMBRE, u.CUIL, a.AREA, u.INTERNO, u.ACTIVO, r.REPA
                FROM usuarios u
                LEFT JOIN area a ON  u.ID_AREA = a.ID_AREA
                LEFT JOIN reparticion r ON r.ID_REPA = a.ID_REPA
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
    'totalUsuarios' => $totalRegistros,
    'query' => $query_excel
]);

// $conn->close();
?>

