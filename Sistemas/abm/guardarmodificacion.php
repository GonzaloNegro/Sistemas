<?php
session_start();
include('..particular/conexion.php');

$id = $_POST['id_inc'];
$fecini = $_POST['fecha_inicio'];
$usu = $_POST['usuario'];
$desc = $_POST['descripcion'];
$est = $_POST['estado'];
$res = $_POST['resolutor'];
/* $nro = $_POST['nro_equipo']; */
$mot = $_POST['motivo'];

// Obteniendo la fecha actual del sistema con PHP
$fechaActual = date('Y-m-d');


/*/////////////BOTONES////////////////*/

/*BOTON MODIFICAR*/
if(isset($_POST['btnmod'])){
  include('..particular/conexion.php');
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

	$resolutororig=mysqli_query($datos_base, "SELECT ID_RESOLUTOR FROM ticket WHERE ID_TICKET = '$id'");
	if ($row = mysqli_fetch_row($resolutororig)) {
		$resolutororig = trim($row[0]);
		}

  mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, 3, DEFAULT, '$fechaActual', '$resolutororig', DEFAULT)");

  $fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
  if ($row = mysqli_fetch_row($fec)) {
  $fec1 = trim($row[0]);
  }

  mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$id', '$fec1')");

  /* ACA YA ESTARIA EN DERIVADO EL USUARIO ORIGINAL (SEGUNDO PASO DEL USUARIO ORIGINAL) */

  /* ACA EMPEZARIA A ESTAR EN ESTADO DE EN PROCESO DEL NUEVO RESOLUTOR */

	mysqli_query($datos_base, "UPDATE ticket SET ID_ESTADO = 4, ID_RESOLUTOR = '$res', ID_USUARIO = '$usu', DESCRIPCION = '$desc' WHERE ID_TICKET = '$id'");

	mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, 4, '$mot', '$fechaActual', '$res', DEFAULT)");

	$tic=mysqli_query($datos_base, "SELECT MAX(ID_TICKET) AS id FROM ticket");
		if ($row = mysqli_fetch_row($tic)) {
			$tic1 = trim($row[0]);
			}
	$fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
		if ($row = mysqli_fetch_row($fec)) {
			$fec1 = trim($row[0]);
			}
	mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$tic1','$fec1')");
  header("Location: ../consulta/cambio.php?mod");
  mysqli_close($datos_base);	
}

/*BOTON SOLUCIONAR*/
if(isset($_POST['btnsol'])){
  include('..particular/conexion.php');

  $sql = "SELECT ID_RESOLUTOR from ticket WHERE ID_TICKET = '$id'";
  $result = $datos_base->query($sql);
  $row = $result->fetch_assoc();
  $ori = $row['ID_RESOLUTOR'];

  mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, 2, '$mot', '$fechaActual', '$ori', DEFAULT)");
  
  /*mysqli_query($datos_base, "UPDATE fecha SET ID_RESOLUTOR = '$res' WHERE ID_TICKET = '$id'");*/
  
  mysqli_query($datos_base, "UPDATE ticket SET ID_ESTADO = 2, FECHA_SOLUCION = '$fechaActual' WHERE ID_TICKET = '$id'");

  $fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
  if ($row = mysqli_fetch_row($fec)) {
	$fec1 = trim($row[0]);
	}

  mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$id', '$fec1')");
  header("Location: ../consulta/cambio.php?sol");
  mysqli_close($datos_base);	
}

/*BOTON ANULAR*/
if(isset($_POST['btnan']))
{
  include('..particular/conexion.php');
  $sql = "SELECT ID_RESOLUTOR from ticket WHERE ID_TICKET = '$id'";
  $result = $datos_base->query($sql);
  $row = $result->fetch_assoc();

  $ori = $row['ID_RESOLUTOR'];

  mysqli_query($datos_base, "UPDATE ticket SET ID_ESTADO = '5', FECHA_SOLUCION = '$fechaActual' WHERE ID_TICKET = '$id'");

  mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, '5', '$mot', '$fechaActual', '$ori', DEFAULT)");

  $fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");
  if ($row = mysqli_fetch_row($fec)) {
    $fec1 = trim($row[0]);
    }

  mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$id', '$fec1')");

  header("Location: ../consulta/cambio.php?an");
  mysqli_close($datos_base);	
}
?>