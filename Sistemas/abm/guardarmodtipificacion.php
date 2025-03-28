<?php
session_start();
include('../particular/conexion.php');
date_default_timezone_set('America/Argentina/Buenos_Aires'); // Configura la zona horaria de Argentina
$hora_actual = date("H:i:s"); // Formato de hora: HH:mm:ss

/*BUSCO EL RESOLUTOR PARA agregados*/
$cuil = $_SESSION['cuil'];

$sqli = "SELECT RESOLUTOR FROM resolutor WHERE CUIL = '$cuil'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$resolutorActivo = $row2['RESOLUTOR'];

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
  mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'TIPIFICACIÓN', '$tipi', '$fecha', '$hora_actual', '$resolutorActivo')");

  mysqli_query($datos_base, "INSERT INTO tipificacion VALUES (DEFAULT, '$tipi')"); 
  header("Location: agregartipificacion.php?ok");
}
mysqli_close($datos_base);	
?>