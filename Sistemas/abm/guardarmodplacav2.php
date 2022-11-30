<?php
include('../particular/conexion.php');

$id = $_POST['id'];
$memoria = $_POST['memoria'];
$modelo = $_POST['modelo'];
$tipo = $_POST['tipo'];

/*TRAIGO VALORES DE LOS CMB*/

if($memoria == "100"){
    $sql3 = "SELECT ID_MEMORIA FROM pvideo WHERE ID_PVIDEO = '$id'";
    $result3 = $datos_base->query($sql3);
    $row3 = $result3->fetch_assoc();
    $memoria = $row3['ID_MEMORIA'];
}

if($modelo == "200"){
    $sql3 = "SELECT ID_MODELO FROM pvideo WHERE ID_PVIDEO = '$id'";
    $result3 = $datos_base->query($sql3);
    $row3 = $result3->fetch_assoc();
    $modelo = $row3['ID_MODELO'];
}

if($tipo == "300"){
    $sql3 = "SELECT ID_TIPOMEM FROM pvideo WHERE ID_PVIDEO = '$id'";
    $result3 = $datos_base->query($sql3);
    $row3 = $result3->fetch_assoc();
    $tipo = $row3['ID_TIPOMEM'];
}

/*SI LOS CAMPOS ESTAN REPETIDOS*/
$sqli = "SELECT ID_PVIDEO FROM pvideo WHERE ID_MEMORIA = '$memoria' AND ID_MODELO ='$modelo' AND ID_TIPOMEM = '$tipo' AND ID_PVIDEO != '$id'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$placavreg = $row2['ID_PVIDEO'];

if(isset($placavreg)){
    header("Location: abmplacav.php?no");
    mysqli_close($datos_base);
}else{
    mysqli_query($datos_base, "UPDATE pvideo SET ID_MEMORIA = '$memoria', ID_MODELO ='$modelo', ID_TIPOMEM = '$tipo' WHERE ID_PVIDEO = '$id'");
    header("Location: abmplacav.php?mod");
    mysqli_close($datos_base);
}
?>