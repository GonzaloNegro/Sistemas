<?php
session_start();
include('..particular/conexion.php');

$id = $_POST['id'];
$tip = $_POST['tip'];

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$sql = "SELECT * FROM tipificacion WHERE TIPIFICACION = '$tip' AND ID_TIPIFICACION != '$id'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$ti = $row['TIPIFICACION'];

if($tip == $ti){
  header("Location: abmtipificacion.php?no");
}
else{
  mysqli_query($datos_base, "UPDATE tipificacion SET TIPIFICACION = '$tip' WHERE ID_TIPIFICACION = '$id'"); 
  header("Location: abmtipificacion.php?ok");
}
?>