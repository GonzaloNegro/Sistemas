<?php
session_start();
include('conexion.php');

$id = $_POST['id'];
$area = $_POST['area'];
$repa = $_POST['repa'];
$est = $_POST['estado'];
$obs = $_POST['obs'];

/*TRAIGO VALORES DE LOS CMB*/
if($repa == "100"){
    $sql = "SELECT ID_REPA FROM area WHERE ID_AREA = '$id'";
    $result = $datos_base->query($sql);
    $row = $result->fetch_assoc();
    $repa = $row['ID_REPA'];
}

/*TRAIGO VALORES DE LOS CMB*/
if($est == "200"){
    $sql = "SELECT ACTIVO FROM area WHERE ID_AREA = '$id'";
    $result = $datos_base->query($sql);
    $row = $result->fetch_assoc();
    $est = $ro4['ACTIVO'];
}

/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
$sqli = "SELECT * FROM area WHERE AREA = '$area' AND ID_REPA ='$repa' AND ID_AREA != '$id'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$are = $row2['AREA'];
$rep = $row2['ID_REPA'];


if($area == $are AND $repa == $rep){ 
    header("Location: abmarea.php?no");
}
else{
    mysqli_query($datos_base, "UPDATE area SET AREA = '$area', ID_REPA = '$repa', ACTIVO = '$est', OBSERVACION = '$obs' WHERE ID_AREA = '$id'");
    header("Location: abmarea.php?ok");
}
mysqli_close($datos_base);
?>