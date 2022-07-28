<?php
include('../particular/conexion.php');

$id = $_POST['id'];
$modelo = $_POST['modelo'];
$marca = $_POST['marca'];
$tipo = $_POST['tipo'];

/*TRAIGO VALORES DE LOS CMB*/
if($tipo == "200"){
    $sql4 = "SELECT ID_TIPOP FROM modelo WHERE ID_MODELO = '$id'";
    $result4 = $datos_base->query($sql4);
    $row4 = $result4->fetch_assoc();
  
    $tipo = $row4['ID_TIPOP'];
}

if($marca == "100"){
    $sql3 = "SELECT ID_MARCA FROM modelo WHERE ID_MODELO = '$id'";
    $result3 = $datos_base->query($sql3);
    $row3 = $result3->fetch_assoc();
  
    $marca = $row3['ID_MARCA'];
}
/*TRAIGO VALORES DE LOS CMB*/

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$sql = "SELECT * FROM modelo WHERE MODELO = '$modelo' AND ID_MODELO != '$id'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$mo = $row['MODELO'];

$sqli = "SELECT * FROM modelo WHERE MODELO = '$modelo' AND ID_MARCA ='$marca' AND ID_MODELO != '$id'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$mod = $row2['MODELO'];
$mar = $row2['ID_MARCA'];
/*SI AMBOS CAMPOS ESTAN REPETIDOS*/

/*CONTROL FINAL*/
if($modelo == $mod AND $marca == $mar){ 
    header("Location: abmmodelos.php?no");
}
elseif($modelo == $mo){
    mysqli_query($datos_base, "UPDATE modelo SET MODELO = '$modelo', ID_TIPOP = '$tipo', ID_MARCA = '$marca' WHERE ID_MODELO = '$id'"); 
    header("Location: abmmodelos.php?repeat");
}
else{
    mysqli_query($datos_base, "UPDATE modelo SET MODELO ='$modelo', ID_TIPOP = '$tipo', ID_MARCA = '$marca' WHERE ID_MODELO = '$id'"); 
    header("Location: abmmodelos.php?ok");
}
mysqli_close($datos_base);
?>