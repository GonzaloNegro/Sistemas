<?php
session_start();
include('..particular/conexion.php');

$id = $_POST['id'];
$marca = $_POST['marca'];

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$sql = "SELECT * FROM marcas WHERE MARCA = '$marca'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$ma = $row['MARCA'];
  

if($marca == $ma){
  header("Location: agregarmarca.php?no");
}
else{
  mysqli_query($datos_base, "INSERT INTO marcas VALUES (DEFAULT, '$marca')"); 
  header("Location: agregarmarca.php?ok");
}
mysqli_close($datos_base);	
?>