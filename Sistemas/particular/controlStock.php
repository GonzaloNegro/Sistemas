<?php
session_start();
include('../particular/conexion.php');

$valorteclado = $_POST['valorteclado'];
$valorfuente = $_POST['valorfuente'];
$valortoner = $_POST['valortoner'];
$valorhdmi = $_POST['valorhdmi'];
$valorvga = $_POST['valorvga'];
$valordvi = $_POST['valordvi'];
$valorusbi = $_POST['valorusbi'];
$valordh = $_POST['valordh'];
$valordv = $_POST['valordv'];
$valorhv = $_POST['valorhv'];

if(isset($_POST['btnteclado'])){
    mysqli_query($datos_base, "UPDATE stock SET CANTIDAD = '$valorteclado' WHERE ID_STOCK = 1"); 
}

if(isset($_POST['btnfuente'])){
    mysqli_query($datos_base, "UPDATE stock SET CANTIDAD = '$valorfuente' WHERE ID_STOCK = 2"); 
}

if(isset($_POST['btntoner'])){
    mysqli_query($datos_base, "UPDATE stock SET CANTIDAD = '$valortoner' WHERE ID_STOCK = 3"); 
}

if(isset($_POST['btnhdmi'])){
    mysqli_query($datos_base, "UPDATE stock SET CANTIDAD = '$valorhdmi' WHERE ID_STOCK = 4"); 
}

if(isset($_POST['btnvga'])){
    mysqli_query($datos_base, "UPDATE stock SET CANTIDAD = '$valorvga' WHERE ID_STOCK = 5"); 
}

if(isset($_POST['btndvi'])){
    mysqli_query($datos_base, "UPDATE stock SET CANTIDAD = '$valordvi' WHERE ID_STOCK = 6"); 
}

if(isset($_POST['btnusbi'])){
    mysqli_query($datos_base, "UPDATE stock SET CANTIDAD = '$valorusbi' WHERE ID_STOCK = 7"); 
}

if(isset($_POST['btndh'])){
    mysqli_query($datos_base, "UPDATE stock SET CANTIDAD = '$valordh' WHERE ID_STOCK = 8"); 
}

if(isset($_POST['btndv'])){
    mysqli_query($datos_base, "UPDATE stock SET CANTIDAD = '$valordv' WHERE ID_STOCK = 9"); 
}

if(isset($_POST['btnhv'])){
    mysqli_query($datos_base, "UPDATE stock SET CANTIDAD = '$valorhv' WHERE ID_STOCK = 10"); 
}

header("Location: stock.php?ok");
mysqli_close($datos_base);	
?>