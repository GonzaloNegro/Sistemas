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

$tipificacion = $_POST['tipificacion'];



$usuario1 = $_POST['usuario1'];
$equipo = $_POST ['equipo'];
$descripcion1 = $_POST['descripcion1'];


$usuario2 = $_POST['usuario2'];
$equipo2 = $_POST ['equipo2'];
$descripcion2 = $_POST['descripcion2'];


$usuario3 = $_POST['usuario3'];
$equipo3 = $_POST ['equipo3'];
$descripcion3 = $_POST['descripcion3'];
/* ////////////// */




/* GUARDO EL TICKET EQUIPO N°1*/
if(isset($usuario1)){
	$sqla = "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = '$usuario1'";
	$result = $datos_base->query($sqla);
	$r = $result->fetch_assoc();
	$usunom1 = $r['NOMBRE'];/* USUARIO ATENDIDO */

	if($equipo == 0 OR $equipo == ""){
		$sql = "SELECT ID_WS FROM inventario WHERE ID_USUARIO = '$usuario1'";
		$resultado = $datos_base->query($sql);
		$row = $resultado->fetch_assoc();
		$equipo = $row['ID_WS'];
	}

    /* TICKET */
	mysqli_query($datos_base, "INSERT INTO ticket VALUES (DEFAULT, '$date', '$descripcion1', '$usunom1', '$usuario1', DEFAULT, '$tipificacion', 2, 2, DEFAULT, '$date', '$original', 1, '$equipo', '$hora')");

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


/* GUARDO EL TICKET EQUIPO N°2*/
if(isset($usuario2)){
	$sqla = "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = '$usuario2'";
	$result = $datos_base->query($sqla);
	$r = $result->fetch_assoc();
	$usunom2 = $r['NOMBRE'];/* USUARIO ATENDIDO */

	if($equipo2 == 0 OR $equipo2 == ""){
		$sql = "SELECT ID_WS FROM inventario WHERE ID_USUARIO = '$usuario2'";
		$resultado = $datos_base->query($sql);
		$row = $resultado->fetch_assoc();
		$equipo2 = $row['ID_WS'];
	}

    /* TICKET */
	mysqli_query($datos_base, "INSERT INTO ticket VALUES (DEFAULT, '$date', '$descripcion2', '$usunom2', '$usuario2', DEFAULT, '$tipificacion', 2, 2, DEFAULT, '$date', '$original', 1, '$equipo2', '$hora')");

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


/* GUARDO EL TICKET EQUIPO N°3*/
if(isset($usuario3)){
	$sqla = "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = '$usuario3'";
	$result = $datos_base->query($sqla);
	$r = $result->fetch_assoc();
	$usunom3 = $r['NOMBRE'];/* USUARIO ATENDIDO */

	if($equipo3 == 0 OR $equipo3 == ""){
		$sql = "SELECT ID_WS FROM inventario WHERE ID_USUARIO = '$usuario3'";
		$resultado = $datos_base->query($sql);
		$row = $resultado->fetch_assoc();
		$equipo3 = $row['ID_WS'];
	}

    /* TICKET */
	mysqli_query($datos_base, "INSERT INTO ticket VALUES (DEFAULT, '$date', '$descripcion3', '$usunom3', '$usuario3', DEFAULT, '$tipificacion', 2, 2, DEFAULT, '$date', '$original', 1, '$equipo3', '$hora')");

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