<?php
include('conexion.php');

$modelo = $_POST['modelo'];
$marca = $_POST['marca'];
$tipop = $_POST['tipop'];
$serieg = $_POST['serieg'];
$serie = $_POST['serie'];
$usu = $_POST['usu'];
$est = $_POST['est'];
$gar = $_POST['gar'];
$prov = $_POST['prov'];
$fac = $_POST['fac'];
$mac = $_POST['mac'];
$reserva = $_POST['reserva'];
$ip = $_POST['ip'];
$obs = $_POST['obs'];
$proc = $_POST['proc'];

/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
$sqli = "SELECT * FROM periferico WHERE SERIEG = '$serieg' AND (ID_TIPOP = 1 OR ID_TIPOP = 2 OR ID_TIPOP = 3 OR ID_TIPOP = 4 OR ID_TIPOP = 10 OR ID_TIPOP = 13)";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$serg = $row2['SERIEG'];

$sqli = "SELECT * FROM periferico WHERE SERIE ='$serie' AND (ID_TIPOP = 1 OR ID_TIPOP = 2 OR ID_TIPOP = 3 OR ID_TIPOP = 4 OR ID_TIPOP = 10 OR ID_TIPOP = 13)";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$ser = $row2['SERIE'];

$sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$area = $row2['ID_AREA'];

if($serieg == $serg OR $serie == $ser){ 
    header("Location: agregarimpresora.php?no");
}
else{
    mysqli_query($datos_base, "INSERT INTO periferico VALUES (DEFAULT, '$tipop', DEFAULT, '$serieg', '$marca', '$serie', '$proc', '$obs', 'IMPRESORA', '$mac', '$reserva', '$ip', '$prov', '$fac', '$area', '$usu', '$gar', '$est', '$modelo')");
    header("Location: agregarimpresora.php?ok");
}
mysqli_close($datos_base);
?>