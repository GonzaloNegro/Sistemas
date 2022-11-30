<?php
include('../particular/conexion.php');

$mem = $_POST['mem'];
$tipo = $_POST['tipo'];
$vel = $_POST['vel'];
$cant = $_POST['cant'];

/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
$sqli = "SELECT ID_STOCKRAM FROM stockram WHERE ID_MEMORIA = '$mem' AND ID_TIPOMEM ='$tipo' AND ID_FRECUENCIA = '$vel'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$stockreg = $row2['ID_STOCKRAM'];

if(isset($stockreg)){
    header("Location: stockram.php?no");
    mysqli_close($datos_base);
}else{
    mysqli_query($datos_base, "INSERT INTO stockram VALUES (DEFAULT, '$mem', '$tipo', '$vel', '$cant')");
    header("Location: stockram.php?ok");
    mysqli_close($datos_base);
}
?>