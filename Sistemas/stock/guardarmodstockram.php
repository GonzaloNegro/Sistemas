<?php
include('../particular/conexion.php');

$id = $_POST['id'];
$mem = $_POST['mem'];
$tipo = $_POST['tipo'];
$vel = $_POST['vel'];
$cant = $_POST['cant'];

/*TRAIGO VALORES DE LOS CMB*/
if($mem == "100"){
    $sql3 = "SELECT ID_MEMORIA FROM stockram WHERE ID_STOCKRAM = '$id'";
    $result3 = $datos_base->query($sql3);
    $row3 = $result3->fetch_assoc();
    $mem = $row3['ID_MEMORIA'];
}

if($tipo == "200"){
    $sql4 = "SELECT ID_TIPOMEM FROM stockram WHERE ID_STOCKRAM = '$id'";
    $result4 = $datos_base->query($sql4);
    $row4 = $result4->fetch_assoc();
    $tipo = $row4['ID_TIPOMEM'];
}

if($vel == "300"){
    $sql3 = "SELECT ID_FRECUENCIA FROM stockram WHERE ID_STOCKRAM = '$id'";
    $result3 = $datos_base->query($sql3);
    $row3 = $result3->fetch_assoc();
    $vel = $row3['ID_FRECUENCIA'];
}


/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
$sqli = "SELECT ID_STOCKRAM FROM stockram WHERE ID_MEMORIA = '$mem' AND ID_TIPOMEM ='$tipo' AND ID_FRECUENCIA = '$vel' AND ID_STOCKRAM != '$id'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$stockreg = $row2['ID_STOCKRAM'];

if(isset($stockreg)){
    header("Location: stockram.php?no");
    mysqli_close($datos_base);
}else{
    mysqli_query($datos_base, "UPDATE stockram SET ID_MEMORIA ='$mem', ID_TIPOMEM = '$tipo', ID_FRECUENCIA = '$vel', CANTIDAD = '$cant' WHERE ID_STOCKRAM = '$id'"); 
    header("Location: stockram.php?mod");
    mysqli_close($datos_base);
}
?>