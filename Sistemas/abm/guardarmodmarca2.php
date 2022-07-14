<?php
session_start();
include('..particular/conexion.php');

$id = $_POST['id'];
$marca = $_POST['marca'];

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$sql = "SELECT * FROM marcas WHERE MARCA = '$marca' AND ID_MARCA != '$id'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$ma = $row['MARCA'];
  

if($marca == $ma){
  header("Location: abmmarcas.php?no");
}
else{
  mysqli_query($datos_base, "UPDATE marcas SET MARCA = '$marca' WHERE ID_MARCA = '$id'"); 
  header("Location: abmmarcas.php?ok");
}
mysqli_close($datos_base);	
?>