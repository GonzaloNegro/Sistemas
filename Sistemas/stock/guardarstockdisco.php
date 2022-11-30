<?php
include('../particular/conexion.php');

$cap = $_POST['cap'];
$tipo = $_POST['tipo'];
$cant = $_POST['cant'];

/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
$sqli = "SELECT ID_STOCKDISCO FROM stockdisco WHERE ID_DISCO = '$cap' AND ID_TIPOD ='$tipo'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$stockreg = $row2['ID_STOCKDISCO'];

if(isset($stockreg)){
    header("Location: stockdisco.php?no");
    mysqli_close($datos_base);
}else{
    mysqli_query($datos_base, "INSERT INTO stockdisco VALUES (DEFAULT, '$cap', '$tipo', '$cant')");
    header("Location: stockdisco.php?ok");
    mysqli_close($datos_base);
}
?>