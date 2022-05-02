<?php
session_start();
include('conexion.php');

/* date_default_timezone_set("America/Argentina"); */
ini_set('date.timezone', 'America/Argentina/Buenos_Aires');
$hora = date('H:i', time());


/*TRAIGO LOS DATOS DE QUIEN INGRESO AL SISTEMA*/
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT ID_RESOLUTOR, RESOLUTOR, CORREO FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();

/*GUARDO LOS DATOS DEL ID_RESOLUTOR EN UNA VARIABLE*/
$original = $row['ID_RESOLUTOR'];
$maillogin = $row['CORREO'];

include('conexion.php');

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

$descripcion1 = $_POST['usuadescripcion1'];


$usuario2 = $_POST['usuario2'];

$descripcion2 = $_POST['usuadescripcion2'];


$usuario3 = $_POST['usuario3'];

$descripcion3 = $_POST['usuadescripcion3'];
/* ////////////// */




/* GUARDO EL TICKET*/
if(isset($tipificacion1) AND isset($descripcion1)){
	$sqla = "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = '$usuario'";
	$result = $datos_base->query($sqla);
	$r = $result->fetch_assoc();
	$idusu = $r['NOMBRE'];/* USUARIO ATENDIDO */

	if($equipo == 0 OR $equipo == ""){
		$sql = "SELECT ID_WS FROM inventario WHERE ID_USUARIO = '$usuario'";
		$resultado = $datos_base->query($sql);
		$row = $resultado->fetch_assoc();
		$ws = $row['ID_WS'];
	}

    /* TICKET */
	mysqli_query($datos_base, "INSERT INTO ticket VALUES (DEFAULT, '$date', '$descripcion1', '$idusu', '$usuario', DEFAULT, '$tipificacion1', 2, 2, DEFAULT, '$date', '$original', 1, '$ws', '$hora')");

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

	if($equipo == 0 OR $equipo == ""){
		$sql = "SELECT ID_WS FROM inventario WHERE ID_USUARIO = '$usuario'";
		$resultado = $datos_base->query($sql);
		$row = $resultado->fetch_assoc();
		$ws = $row['ID_WS'];
	}

    /* TICKET */
	mysqli_query($datos_base, "INSERT INTO ticket VALUES (DEFAULT, '$date', '$descripcion2', '$idusu', '$usuario', DEFAULT, '$tipificacion2', 2, 2, DEFAULT, '$date', '$original', 1, '$ws', '$hora')");

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

	if($equipo == 0 OR $equipo == ""){
		$sql = "SELECT ID_WS FROM inventario WHERE ID_USUARIO = '$usuario'";
		$resultado = $datos_base->query($sql);
		$row = $resultado->fetch_assoc();
		$ws = $row['ID_WS'];
	}

    /* TICKET */
	mysqli_query($datos_base, "INSERT INTO ticket VALUES (DEFAULT, '$date', '$descripcion3', '$idusu', '$usuario', DEFAULT, '$tipificacion3', 2, 2, DEFAULT, '$date', '$original', 1, '$ws', '$hora')");

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