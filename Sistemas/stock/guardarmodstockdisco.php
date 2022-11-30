<?php
include('../particular/conexion.php');

$id = $_POST['id'];
$cap = $_POST['cap'];
$tipo = $_POST['tipo'];
$cant = $_POST['cant'];

/*TRAIGO VALORES DE LOS CMB*/
if($cap == "100"){
    $sql3 = "SELECT ID_DISCO FROM stockdisco WHERE ID_STOCKDISCO = '$id'";
    $result3 = $datos_base->query($sql3);
    $row3 = $result3->fetch_assoc();
    $cap = $row3['ID_DISCO'];
}

if($tipo == "200"){
    $sql4 = "SELECT ID_TIPOD FROM stockdisco WHERE ID_STOCKDISCO = '$id'";
    $result4 = $datos_base->query($sql4);
    $row4 = $result4->fetch_assoc();
    $tipo = $row4['ID_TIPOD'];
}

/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
$sqli = "SELECT ID_STOCKDISCO FROM stockdisco WHERE ID_DISCO = '$cap' AND ID_TIPOD ='$tipo' AND ID_STOCKDISCO != '$id'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$stockreg = $row2['ID_STOCKDISCO'];

if(isset($stockreg)){
    header("Location: stockdisco.php?no");
    mysqli_close($datos_base);
}else{
    mysqli_query($datos_base, "UPDATE stockdisco SET ID_DISCO ='$cap', ID_TIPOD = '$tipo', CANTIDAD = '$cant' WHERE ID_STOCKDISCO = '$id'"); 
    header("Location: stockdisco.php?mod");
    mysqli_close($datos_base);
}
?>