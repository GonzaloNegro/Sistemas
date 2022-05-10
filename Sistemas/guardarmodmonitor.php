<?php
include('conexion.php');

$tipop = $_POST['tipop'];
$serieg = $_POST['serieg'];
$serie = $_POST['serie'];
$usu = $_POST['usu'];
$modelo = $_POST['mod'];
$est = $_POST['est'];
$gar = $_POST['gar'];
$prov = $_POST['prov'];
$fac = $_POST['fac'];
$obs = $_POST['obs'];


$sqli = "SELECT ID_MARCA FROM modelo
WHERE ID_MODELO = '$modelo'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$marca = $row2['ID_MARCA'];


/*SI AMBOS CAMPOS ESTAN REPETIDOS*/

$sqli = "SELECT * FROM periferico WHERE SERIE ='$serie' AND (ID_TIPOP = 7 OR ID_TIPOP = 8)";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$ser = $row2['SERIE'];

$sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$area = $row2['ID_AREA'];


if($serie == $ser){ 
    header("Location: agregarmonitor.php?no");
}
else{
    mysqli_query($datos_base, "INSERT INTO periferico VALUES (DEFAULT, '$tipop', DEFAULT, '$serieg', '$marca', '$serie', 3, '$obs', 'MONITOR', DEFAULT, 'NO', DEFAULT, '$prov', '$fac', '$area', '$usu', '$gar', '$est', '$modelo')");
    header("Location: agregarmonitor.php?ok");
}
mysqli_close($datos_base);
?>