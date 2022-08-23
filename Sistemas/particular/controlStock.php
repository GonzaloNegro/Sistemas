<?php
session_start();
include('../particular/conexion.php');

$valorteclado = $_POST['valorteclado'];
$valorfuente = $_POST['valorfuente'];

if(isset($_POST['btnteclado'])){
    mysqli_query($datos_base, "UPDATE stock SET CANTIDAD = '$valorteclado' WHERE ID_STOCK = 1"); 
}

if(isset($_POST['btnfuente'])){
    mysqli_query($datos_base, "UPDATE stock SET CANTIDAD = '$valorfuente' WHERE ID_STOCK = 2"); 
}

header("Location: stock.php?ok");
mysqli_close($datos_base);	
?>