<?php
include('../particular/conexion.php');

$memoria = $_POST['memoria'];
$modelo = $_POST['modelo'];
$tipo = $_POST['tipo'];

/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
$sqli = "SELECT * FROM pvideo WHERE ID_MEMORIA = '$memoria' AND ID_MODELO ='$modelo' AND ID_TIPOMEM = '$tipo'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$placavreg = $row2['ID_PVIDEO'];

if(isset($placavreg)){
    header("Location: abmplacav.php?no");
    mysqli_close($datos_base);
}else{
    mysqli_query($datos_base, "INSERT INTO pvideo VALUES (DEFAULT, '$memoria', '$modelo', '$tipo')"); 
    header("Location: abmplacav.php?ok");
    mysqli_close($datos_base);
}
?>