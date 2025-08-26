<?php
session_start();
include('../particular/conexion.php');
date_default_timezone_set('America/Argentina/Buenos_Aires'); // Configura la zona horaria de Argentina
$hora_actual = date("H:i:s"); // Formato de hora: HH:mm:ss

$id = $_POST['id_inc'];
$fecini = $_POST['fecha_inicio'];
$usu = $_POST['usuario'];
$desc = $_POST['descripcion'];
$est = $_POST['estado'];
$res = $_POST['resolutor'];
$mot = $_POST['motivo'];
$ws = $_POST['equipo'];

// Obteniendo la fecha actual del sistema con PHP
$fechaActual = date('Y-m-d');

/* VERIFICO SI LOS VALORES SON LOS ACTUALES */
if($ws == "200"){
  $sql = "SELECT ID_WS from ticket WHERE ID_TICKET = '$id'";
  $result = $datos_base->query($sql);
  $row = $result->fetch_assoc();
  $ws = $row['ID_WS'];
}
if($usu == "150"){
  $sql = "SELECT ID_USUARIO from ticket WHERE ID_TICKET = '$id'";
  $result = $datos_base->query($sql);
  $row = $result->fetch_assoc();
  $usu = $row['ID_USUARIO'];
}
if($res == "100"){
  $sql = "SELECT ID_RESOLUTOR from ticket WHERE ID_TICKET = '$id'";
  $result = $datos_base->query($sql);
  $row = $result->fetch_assoc();
  $res = $row['ID_RESOLUTOR'];
}
if($est == "50"){
  $sqli = "SELECT ID_ESTADO from ticket WHERE ID_TICKET = '$id'";
  $resulta = $datos_base->query($sqli);
  $rowa = $resulta->fetch_assoc();
  $est = $rowa['ID_ESTADO'];
}
/* TRAIGO EL RESOLUTOR ORIGINAL */
$sql = "SELECT ID_RESOLUTOR from ticket WHERE ID_TICKET = '$id'";
$result = $datos_base->query($sql);
$row = $result->fetch_assoc();
$ori = $row['ID_RESOLUTOR'];

///////SI NO SE SELECCIONA UN EQUIPO, LO BUSCAMOS////////////
if($ws == 0 OR $ws == ""){
			$sql = "SELECT i.ID_WS FROM inventario i INNER JOIN wsusuario w ON i.ID_WS=w.ID_WS WHERE w.ID_USUARIO = '$usu'";
			$resultado = $datos_base->query($sql);
			$row = $resultado->fetch_assoc();
			$ws = $row['ID_WS'];
		}
/*/////////////BOTONES////////////////*/
/*BOTON MODIFICAR*/
if(isset($_POST['btnmod'])){
  if($est == 4 || $est == 1){/* EN PROCESO || SUSPENDIDO */
  /* SI ESTADO ES EN PROCESO O SUSPENDIDO, SOLO SE GUARDA 1 MOVIMIENTO
  INSERT EN fecha
  INSERT EN fecha_ticket
  UPDATE EN ticket */
  mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, '$est', UPPER('$mot'), '$fechaActual', '$res', '$hora_actual')");

  $fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
  if ($row = mysqli_fetch_row($fec)) {
  $fec1 = trim($row[0]);
  }

  mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$id', '$fec1')");

  mysqli_query($datos_base, "UPDATE ticket SET ID_ESTADO = '$est', ID_RESOLUTOR = '$res', ID_USUARIO = '$usu', DESCRIPCION = UPPER('$desc'), ID_WS = '$ws' WHERE ID_TICKET = '$id'");
      
  } else if($est == 3){/* DERIVADO */
  /* SI EL ESTADO ES DERIVADO, SE GUARDAN 2 MOVIMIENTOS.
  PRIMERO SE DEBE GUARDAR EL DERIVADO CON SU MOTIVO
  POSTERIORMENTE SE DEBE GUARDAR EL ESTADO EN PROCESO DEL NUEVO RESOLUTOR

  INSERT EN fecha DEL ESTADO EN DERIVADO, ACTUAL RESOLUTOR Y GUARDAR EL MOTIVO DE DERIVACION
  INSERT EN fecha_ticket PARA GUARDAR ESTE MOVIMIENTO

  INSERT EN fecha DEL ESTADO EN PROCESO CON EL NUEVO RESOLUTOR
  INSERT EN fecha_ticket PARA GUARDAR ESTE MOVIMIENTO
  UPDATE EN TICKET A ESTADO EN PROCESO
  */
  mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, '$est', UPPER('$mot'), '$fechaActual', '$ori', '$hora_actual')");

  $fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
  if ($row = mysqli_fetch_row($fec)) {
    $fec1 = trim($row[0]);
  }

  mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$id', '$fec1')");


  /* AHORA PASAR EL TICKET A EN PROCESO */
  mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, 4, '-', '$fechaActual', '$res', '$hora_actual')");

  $fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
  if ($row = mysqli_fetch_row($fec)) {
    $fec1 = trim($row[0]);
  }

  mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$id', '$fec1')");

  mysqli_query($datos_base, "UPDATE ticket SET ID_ESTADO = 4, ID_RESOLUTOR = '$res', ID_USUARIO = '$usu', DESCRIPCION = UPPER('$desc'), ID_WS = '$ws' WHERE ID_TICKET = '$id'");
  }

  header("Location: cambio.php?mod");
  mysqli_close($datos_base);	
}

/*BOTON SOLUCIONAR*/
if(isset($_POST['btnsol'])){
  mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, 2, UPPER('$mot'), '$fechaActual', '$ori', '$hora_actual')");
  
  mysqli_query($datos_base, "UPDATE ticket SET ID_ESTADO = 2, FECHA_SOLUCION = '$fechaActual' WHERE ID_TICKET = '$id'");

  $fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
  if ($row = mysqli_fetch_row($fec)) {
	$fec1 = trim($row[0]);
	}

  mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$id', '$fec1')");
  header("Location: cambio.php?sol");
  mysqli_close($datos_base);	
}

/*BOTON ANULAR*/
if(isset($_POST['btnan'])){
  mysqli_query($datos_base, "UPDATE ticket SET ID_ESTADO = '5', FECHA_SOLUCION = '$fechaActual' WHERE ID_TICKET = '$id'");

  mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, '5', UPPER('$mot'), '$fechaActual', '$ori', '$hora_actual')");

  $fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
  if ($row = mysqli_fetch_row($fec)) {
    $fec1 = trim($row[0]);
    }

  mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$id', '$fec1')");

  header("Location: cambio.php?an");
  mysqli_close($datos_base);	
}
?>