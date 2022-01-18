<?php
session_start();
include('conexion.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Phpmailer/Exception.php';
require 'Phpmailer/PHPMailer.php';
require 'Phpmailer/SMTP.php';

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
$numero = $_POST['numero'];
$tipificacion = $_POST['tipificacion'];
$estado = $_POST['estado'];
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

/*TRAER ID DE USUARIO

$idusu = "SELECT ID_USUARIO 
FROM usuarios
WHERE NOMBRE LIKE '%$usuario%'";

$result = $datos_base->query($sqla);
$r = $result->fetch_assoc();
$idusu = $r['ID_USUARIO'];

FIN TRAER USUARIO*/

/* GUARDO EL TICKET YA SEA DERIVADO O GENERADO POR USUARIO LOGUEADO*/
if($estado == "3"){

	$sqla = "SELECT ID_USUARIO FROM usuarios WHERE NOMBRE = '$usuario'";
	$result = $datos_base->query($sqla);
	$r = $result->fetch_assoc();
	$idusu = $r['ID_USUARIO'];

	$motivo = $_POST['motivo'];
	$derivado = $_POST['derivado'];

	$sql = "SELECT ID_TIPO_RESOLUTOR from resolutor WHERE ID_RESOLUTOR = '$derivado'";
	$resultado = $datos_base->query($sql);
	$row = $resultado->fetch_assoc();
	$renv = $row['ID_TIPO_RESOLUTOR'];

	mysqli_query($datos_base, "INSERT INTO ticket VALUES (DEFAULT, '$date', '$descripcion', '$usuario', '$idusu', '$imagen', '$tipificacion', '$prioridad', '$estado', '$numero', '$date2', '$derivado','$renv', DEFAULT, DEFAULT)");

	mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, '$estado', '$motivo', '$date', '$derivado', DEFAULT)");
	/*MAIL GENERADO PARA EL USUARIO DERIVADO*/

	/*include('conexion.php');
	$header = "Mensaje enviado desde gobierno";
	$mensaje = "El día: ".$date." se generó un incidente para el usuario: ".$usuario."\r\n"."Incidente: ".$descripcion."\r\n"."Por favor revise esta situación y gestione su solución.";
	mail("gonzalonnegro@gmail.com", "Dirección de Sistemas y Telecomunicaciones  -  Sistema de Gestión de Tickets", $mensaje, $header);*/
	/*$maillogin*/

	$mail = new PHPMailer(true);

	try {
		//Server settings
		$mail->SMTPDebug = 0;                      			//Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = 'gonzalonnegro@gmail.com';                   //SMTP username
		$mail->Password   = '';                               //SMTP password
		$mail->SMTPSecure = 'tls';      				      //Enable implicit TLS encryption
		$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	
		//Recipients
		$mail->setFrom('gonzalonnegro@gmail.com', 'Gonzalito');
		$mail->addAddress('gonzalonnegro@gmail.com', 'Joe User');     //Add a recipient
	
		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'Asunto';
		$mail->Body    = 'Correo de prueba';
	
		$mail->send();
		echo 'El mensaje se envio correctamente';
	} catch (Exception $e) {
		echo "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";
	}





}
else{

	$sqla = "SELECT ID_USUARIO FROM usuarios WHERE NOMBRE = '$usuario'";
	$result = $datos_base->query($sqla);
	$r = $result->fetch_assoc();
	$idusu = $r['ID_USUARIO'];

	$sql = "SELECT ID_TIPO_RESOLUTOR from resolutor WHERE ID_RESOLUTOR = '$original'";
	$resultado = $datos_base->query($sql);
	$row = $resultado->fetch_assoc();
	$renu = $row['ID_TIPO_RESOLUTOR'];

	mysqli_query($datos_base, "INSERT INTO ticket VALUES (DEFAULT, '$date', '$descripcion', '$usuario', '$idusu', '$imagen','$tipificacion', '$prioridad', '$estado', '$numero', '$date2', '$original','$renu', DEFAULT, DEFAULT)"); 

	mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, '$estado', '', '$date', '$original', DEFAULT)");
	/*MAIL GENERADO PARA EL USUARIO LOGUEADO*/
}


/*Traer los datos del ID_TICKET y el ID_FECHA  del ticket generado*/

include('conexion.php');

$tic=mysqli_query($datos_base, "SELECT MAX(ID_TICKET) AS id FROM ticket");
if ($row = mysqli_fetch_row($tic)) {
	$tic1 = trim($row[0]);
	}

$fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
if ($row = mysqli_fetch_row($fec)) {
	$fec1 = trim($row[0]);
	}

mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$tic1','$fec1')");
header("Location: cargadeincidentes.php?ok");
mysqli_close($datos_base);		
?>