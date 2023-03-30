<?php
session_start();
include('../particular/conexion.php');

$tipi = $_POST['tip'];

//CORTAR ESPACIOS EN BLANCO:
$sinEspacios = preg_replace("/[[:space:]]/","",($tipi));
//CALCULAR EL TAMAÑO
$tamaño = mb_strlen($sinEspacios);
//ORDENAR ALFABÉTICAMENTE
$letras = (str_split($sinEspacios));
sort($letras, SORT_REGULAR);
$respuesta = implode($letras);

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$contador = 0;

$consulta=mysqli_query($datos_base, "SELECT REPLACE(TIPIFICACION, ' ', '') AS TIPIFICACION FROM tipificacion");
while($listar = mysqli_fetch_array($consulta)) 
{
  //CALCULAR EL TAMAÑO
  $tamaño2 = mb_strlen($listar['TIPIFICACION']);
  //ORDENAR ALFABÉTICAMENTE
  $letras2 = (str_split($listar['TIPIFICACION']));
  sort($letras2, SORT_REGULAR);
  //var_dump($letras);
  $respuesta2 = implode($letras2);

  if($respuesta == $respuesta2 AND $tamaño == $tamaño2){
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