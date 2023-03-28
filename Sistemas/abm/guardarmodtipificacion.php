<?php
session_start();
include('../particular/conexion.php');

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

$fecha = date('Y-m-d');

if($contador > 0){
  header("Location: agregartipificacion.php?no");
}
else{
  mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'TIPIFICACIÓN', '$tipi', '$fecha')");

  mysqli_query($datos_base, "INSERT INTO tipificacion VALUES (DEFAULT, '$tipi')"); 
  header("Location: agregartipificacion.php?ok");
}
mysqli_close($datos_base);	
?>