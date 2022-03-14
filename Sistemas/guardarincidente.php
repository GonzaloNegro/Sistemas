<?php
session_start();
include('conexion.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Phpmailer/Exception.php';
require 'Phpmailer/PHPMailer.php';
require 'Phpmailer/SMTP.php';

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

/*$area = $_POST['area'];*/
/*$fecha1 = $_POST['fecha_inicio'];*/
$descripcion = $_POST['descripcion'];
$usuario = $_POST['usuario'];
$tipificacion = $_POST['tipificacion'];
$estado = $_POST['estado'];

/* if(empty($_FILES['imagen'])){
	$imagen = '-';
}
else{
	$imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
}
 */

/*$fecha2 = $_POST['fecha_solucion'];*/
/*$tipo = $_POST['tiporesolutor'];*/
$prioridad = $_POST['prioridad'];

if(isset($_POST['fecha_inicio'])){
	if(!empty($_POST['fecha_inicio'])){
		$date = $_POST['fecha_inicio'];
		$date = strtotime($date);
		$date = date('Y-m-d', $date);
	}
}

if(isset($_POST['fecha_solucion'])){
	if(!empty($_POST['fecha_solucion'])){
		$date2 = $_POST['fecha_solucion'];
		$date2 = strtotime($date2);
		$date2 = date('Y-m-d', $date2);
	}
}

/* GUARDO EL TICKET YA SEA DERIVADO O GENERADO POR USUARIO LOGUEADO*/
	if($estado == "3"){

		$sqla = "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = '$usuario'";
		$result = $datos_base->query($sqla);
		$r = $result->fetch_assoc();
		$idusu = $r['NOMBRE'];

		$motivo = $_POST['motivo'];
		$derivado = $_POST['derivado'];

		$sql = "SELECT ID_TIPO_RESOLUTOR from resolutor WHERE ID_RESOLUTOR = '$derivado'";
		$resultado = $datos_base->query($sql);
		$row = $resultado->fetch_assoc();
		$renv = $row['ID_TIPO_RESOLUTOR'];

		mysqli_query($datos_base, "INSERT INTO ticket VALUES (DEFAULT, '$date', '$descripcion', '$idusu', '$usuario', DEFAULT, '$tipificacion', '$prioridad', '$estado', DEFAULT, '$date2', '$original','$renv', DEFAULT, '$hora')");

		mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, '$estado', '$motivo', '$date', '$original', DEFAULT)");

		$tic=mysqli_query($datos_base, "SELECT MAX(ID_TICKET) AS id FROM ticket");
		if ($row = mysqli_fetch_row($tic)) {
			$tic1 = trim($row[0]);
			}

		$fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
		if ($row = mysqli_fetch_row($fec)) {
			$fec1 = trim($row[0]);
			}

		mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$tic1','$fec1')");
		mysqli_close($datos_base);	
		/*ACA YA ETERMINAN LOS DATOS DE QUIEN CARGA*/
		/*EMPIEZAN LOS DATOS DE A QUIEN SE LE DERIVO */
		include('conexion.php');

		$tic=mysqli_query($datos_base, "SELECT MAX(ID_TICKET) AS id FROM ticket");
		if ($row = mysqli_fetch_row($tic)) {
			$tic1 = trim($row[0]);
			}

		mysqli_query($datos_base, "UPDATE ticket SET ID_ESTADO = 4, ID_RESOLUTOR = '$derivado' WHERE ID_TICKET = '$tic1'");

		mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, 4, '$motivo', '$date', '$derivado', DEFAULT)");

		$tic=mysqli_query($datos_base, "SELECT MAX(ID_TICKET) AS id FROM ticket");
		if ($row = mysqli_fetch_row($tic)) {
			$tic1 = trim($row[0]);
			}
		$fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
		if ($row = mysqli_fetch_row($fec)) {
			$fec1 = trim($row[0]);
			}
		mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$tic1','$fec1')");
	}
	else{
		$sqla = "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = '$usuario'";
		$result = $datos_base->query($sqla);
		$r = $result->fetch_assoc();
		$idusu = $r['NOMBRE'];

		$sql = "SELECT ID_TIPO_RESOLUTOR from resolutor WHERE ID_RESOLUTOR = '$original'";
		$resultado = $datos_base->query($sql);
		$row = $resultado->fetch_assoc();
		$renu = $row['ID_TIPO_RESOLUTOR'];

		mysqli_query($datos_base, "INSERT INTO ticket VALUES (DEFAULT, '$date', '$descripcion', '$idusu', '$usuario', DEFAULT,'$tipificacion', '$prioridad', '$estado', DEFAULT, '$date2', '$original','$renu', DEFAULT, '$hora')"); 

		mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, '$estado', '', '$date', '$original', DEFAULT)");
		/*MAIL GENERADO PARA EL USUARIO LOGUEADO*/

		$tic=mysqli_query($datos_base, "SELECT MAX(ID_TICKET) AS id FROM ticket");
		if ($row = mysqli_fetch_row($tic)) {
			$tic1 = trim($row[0]);
			}
		
		$fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
		if ($row = mysqli_fetch_row($fec)) {
			$fec1 = trim($row[0]);
			}
		mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$tic1','$fec1')");
	}
header("Location: cargadeincidentes.php?ok");
mysqli_close($datos_base);		
?>