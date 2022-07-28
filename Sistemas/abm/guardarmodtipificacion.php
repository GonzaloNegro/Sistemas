<?php
session_start();
include('../particular/conexion.php');

$tip = $_POST['tip'];

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$sql = "SELECT * FROM tipificacion WHERE TIPIFICACION = '$tip'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$ti = $row['TIPIFICACION'];

$fecha = date('Y-m-d');

if($tip == $ti){
  header("Location: agregartipificacion.php?no");
}
else{
  mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'TIPIFICACIÓN', '$tip', '$fecha')");

  mysqli_query($datos_base, "INSERT INTO tipificacion VALUES (DEFAULT, '$tip')"); 
  header("Location: agregartipificacion.php?ok");
}
mysqli_close($datos_base);	
?>