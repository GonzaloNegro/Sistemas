<?php
session_start();
include('../particular/conexion.php');

$id = $_POST['id'];

$tipi = $_POST['tip'];
$tip = preg_replace("/[[:space:]]/","",($tipi));

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$contador = 0;

$consulta=mysqli_query($datos_base, "SELECT REPLACE(TIPIFICACION, ' ', '') AS TIPIFICACION FROM tipificacion");
while($listar = mysqli_fetch_array($consulta)) 
{
  if($listar['TIPIFICACION'] == $tip){
    $contador ++;
  }
}

if($contador > 0){
  header("Location: abmtipificacion.php?no");
}
else{
  mysqli_query($datos_base, "UPDATE tipificacion SET TIPIFICACION = '$tipi' WHERE ID_TIPIFICACION = '$id'"); 
  header("Location: abmtipificacion.php?ok");
}
?>