<?php
require_once('./../particular/conexion.php');
$id = $_REQUEST['id']; 

$sqlDeleteEvento = ("DELETE FROM eventoscalendar WHERE  id='" .$id. "'");
$resultProd = mysqli_query($datos_base, $sqlDeleteEvento);

?>
  