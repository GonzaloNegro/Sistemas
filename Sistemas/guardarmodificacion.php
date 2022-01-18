<?php
session_start();
include('conexion.php');

$id = $_POST['id_inc'];
$fecini = $_POST['fecha_inicio'];
$usu = $_POST['usuario'];
$desc = $_POST['descripcion'];
$fecsol = $_POST['fecha_solucion'];
$est = $_POST['estado'];
$res = $_POST['resolutor'];
$nro = $_POST['nro_equipo'];
$mot = $_POST['motivo'];

// Obteniendo la fecha actual del sistema con PHP
$fechaActual = date('Y-m-d');


/*/////////////BOTONES////////////////*/

/*BOTON MODIFICAR*/
if(isset($_POST['btnmod'])){
  include('conexion.php');
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

  mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, '$est', '$mot', '$fechaActual', '$res', DEFAULT)");


  mysqli_query($datos_base, "UPDATE ticket SET DESCRIPCION = '$desc', FECHA_SOLUCION = '$fechaActual',
    ID_ESTADO = '$est', ID_RESOLUTOR = '$res' WHERE ID_TICKET = '$id'");


  $fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");

  if ($row = mysqli_fetch_row($fec)) {
  $fec1 = trim($row[0]);
  }

  mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$id', '$fec1')");
  header("Location: cambio.php?mod");
  mysqli_close($datos_base);	
}

/*BOTON SOLUCIONAR*/
if(isset($_POST['btnsol'])){
  include('conexion.php');

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
  header("Location: cambio.php?sol");
  mysqli_close($datos_base);	
}

/*BOTON ANULAR*/
if(isset($_POST['btnan']))
{
  include('conexion.php');
  $sql = "SELECT ID_RESOLUTOR from ticket WHERE ID_TICKET = '$id'";
  $result = $datos_base->query($sql);
  $row = $result->fetch_assoc();

  $ori = $row['ID_RESOLUTOR'];

  mysqli_query($datos_base, "UPDATE ticket SET ID_ESTADO = '5', FECHA_SOLUCION = '$fechaActual' WHERE ID_TICKET = '$id'");

  mysqli_query($datos_base, "INSERT INTO fecha VALUES(DEFAULT, '5', '$mot', '$fechaActual', '$ori', DEFAULT)");

 /* $fec=mysqli_query($datos_base, "SELECT MAX(ID_FECHA) AS id FROM fecha");

  if ($row = mysqli_fetch_row($fec)) {
	$fec1 = trim($row[0]);
	}

  mysqli_query($datos_base, "INSERT INTO fecha_ticket VALUES(DEFAULT, '$id', '$fec1')");*/
  header("Location: cambio.php?an");
  mysqli_close($datos_base);	
}
/*
header("Location: consulta.php?ok");*/
?>