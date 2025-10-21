<?php
session_start();
include('../particular/conexion.php');

/* date_default_timezone_set("America/Argentina"); */
ini_set('date.timezone', 'America/Argentina/Buenos_Aires');
$hora = date('H:i', time());


/*TRAIGO LOS DATOS DE QUIEN INGRESO AL SISTEMA*/
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT ID_RESOLUTOR, RESOLUTOR, CORREO FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();

/*GUARDO LOS DATOS DEL ID_RESOLUTOR EN UNA VARIABLE*/
$original = $row['ID_RESOLUTOR'];
$maillogin = $row['CORREO'];

include('../particular/conexion.php');

/* VARIABLES DE ESTE FRM */
if(isset($_POST['fechaini'])){
	if(!empty($_POST['fechaini'])){
		$date = $_POST['fechaini'];
		$date = strtotime($date);
		$date = date('Y-m-d', $date);
	}
}

$usuario = $_POST['usuario'];
$ws = $_POST['equipo'];
$prioridad = $_POST['prioridad'];
/* $equipo = $_POST['equipo']; AUN NO EN USO */

$tipificacion1 = $_POST['tipificacion1'];
$descripcion1 = $_POST['descripcion1'];
$descripcion1 = mysqli_real_escape_string($datos_base, $descripcion1);


$tipificacion2 = $_POST['tipificacion2'];
$descripcion2 = $_POST['descripcion2'];
$descripcion2 = mysqli_real_escape_string($datos_base, $descripcion2);

$tipificacion3 = $_POST['tipificacion3'];
$descripcion3 = $_POST['descripcion3'];
$descripcion3 = mysqli_real_escape_string($datos_base, $descripcion3);

/* ////////////// */




/* GUARDO EL TICKET*/
if(isset($tipificacion1) AND isset($descripcion1)){
	$sqla = "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = '$usuario'";
	$result = $datos_base->query($sqla);
	$r = $result->fetch_assoc();
	$idusu = $r['NOMBRE'];/* USUARIO ATENDIDO */

	if($ws == 0 OR $ws == ""){
		$sql = "SELECT i.ID_WS FROM inventario i INNER JOIN wsusuario w ON i.ID_WS=w.ID_WS WHERE w.ID_USUARIO = '$usuario'";
		$resultado = $datos_base->query($sql);
		$row = $resultado->fetch_assoc();
		$ws = $row['ID_WS'];
	}

    /* TICKET */
	mysqli_query($datos_base, "INSERT INTO ticket VALUES (DEFAULT, '$date', UPPER('$descripcion1'), '$idusu', '$usuario', DEFAULT, '$tipificacion1', '$prioridad', 2, DEFAULT, '$date', '$original', 1, '$ws', '$hora')");

    /* INSERTO LA FECHA DEL MOVIMIENTO */
	mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, 2, DEFAULT, '$date', '$original', '$hora')");

    /* TRAIGO EL NRO DEL TICKET */
	$tic=mysqli_query($datos_base, "SELECT MAX(ID_TICKET) AS id FROM ticket");
	if ($row = mysqli_fetch_row($tic)) {
		$tic1 = trim($row[0]);
		}

    /* TRAIGO EL ULTIMO ID FECHA */
	$fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
	if ($row = mysqli_fetch_row($fec)) {
		$fec1 = trim($row[0]);
		}

    /* INSERTO EN FECHA_TICKET EL MOVIMIENTO */
	mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$tic1','$fec1')");
    }



if(isset($tipificacion2) AND isset($descripcion2)){
	$sqla = "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = '$usuario'";
	$result = $datos_base->query($sqla);
	$r = $result->fetch_assoc();
	$idusu = $r['NOMBRE'];/* USUARIO ATENDIDO */

	if($ws == 0 OR $ws == ""){
		$sql = "SELECT i.ID_WS FROM inventario i INNER JOIN wsusuario w ON i.ID_WS=w.ID_WS WHERE w.ID_USUARIO = '$usuario'";
		$resultado = $datos_base->query($sql);
		$row = $resultado->fetch_assoc();
		$ws = $row['ID_WS'];
	}

    /* TICKET */
	mysqli_query($datos_base, "INSERT INTO ticket VALUES (DEFAULT, '$date', UPPER('$descripcion2'), '$idusu', '$usuario', DEFAULT, '$tipificacion2', '$prioridad', 2, DEFAULT, '$date', '$original', 1, '$ws', '$hora')");

    /* INSERTO LA FECHA DEL MOVIMIENTO */
	mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, 2, DEFAULT, '$date', '$original', '$hora')");

    /* TRAIGO EL NRO DEL TICKET */
	$tic=mysqli_query($datos_base, "SELECT MAX(ID_TICKET) AS id FROM ticket");
	if ($row = mysqli_fetch_row($tic)) {
		$tic1 = trim($row[0]);
		}

    /* TRAIGO EL ULTIMO ID FECHA */
	$fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
	if ($row = mysqli_fetch_row($fec)) {
		$fec1 = trim($row[0]);
		}

    /* INSERTO EN FECHA_TICKET EL MOVIMIENTO */
	mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$tic1','$fec1')");
    }

    if(isset($tipificacion3) AND isset($descripcion3)){
	$sqla = "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = '$usuario'";
	$result = $datos_base->query($sqla);
	$r = $result->fetch_assoc();
	$idusu = $r['NOMBRE'];/* USUARIO ATENDIDO */

	if($ws == 0 OR $ws == ""){
		$sql = "SELECT i.ID_WS FROM inventario i INNER JOIN wsusuario w ON i.ID_WS=w.ID_WS WHERE w.ID_USUARIO = '$usuario'";
		$resultado = $datos_base->query($sql);
		$row = $resultado->fetch_assoc();
		$ws = $row['ID_WS'];
	}

    /* TICKET */
	mysqli_query($datos_base, "INSERT INTO ticket VALUES (DEFAULT, '$date', UPPER('$descripcion3'), '$idusu', '$usuario', DEFAULT, '$tipificacion3', '$prioridad', 2, DEFAULT, '$date', '$original', 1, '$ws', '$hora')");

    /* INSERTO LA FECHA DEL MOVIMIENTO */
	mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, 2, DEFAULT, '$date', '$original', '$hora')");

    /* TRAIGO EL NRO DEL TICKET */
	$tic=mysqli_query($datos_base, "SELECT MAX(ID_TICKET) AS id FROM ticket");
	if ($row = mysqli_fetch_row($tic)) {
		$tic1 = trim($row[0]);
		}

    /* TRAIGO EL ULTIMO ID FECHA */
	$fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
	if ($row = mysqli_fetch_row($fec)) {
		$fec1 = trim($row[0]);
		}

    /* INSERTO EN FECHA_TICKET EL MOVIMIENTO */
	mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$tic1','$fec1')");	
    }

header("Location: cargarapidaporusuario.php?ok");
mysqli_close($datos_base);		
?>