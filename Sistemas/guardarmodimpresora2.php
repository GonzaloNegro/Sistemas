<?php
include('conexion.php');

$id = $_POST['id'];
$serieg = $_POST['serieg'];
$serie = $_POST['serie'];
$mac = $_POST['mac'];
$obs = $_POST['obs'];
$ip = $_POST['ip'];
$factura = $_POST['factura'];
$garantia = $_POST['garantia'];
$rip = $_POST['rip'];
$modelo = $_POST['modelo'];
$estado = $_POST['estado'];
$prov = $_POST['prov'];
$tipop = $_POST['tipop'];
$usu = $_POST['usu'];
$proc = $_POST['proc'];

$fechaActual = date('Y-m-d');

if($rip == "100"){
    $sql = "SELECT RIP FROM periferico WHERE ID_PERI = '$id'";
    $result = $datos_base->query($sql);
    $row = $result->fetch_assoc();
    $rip = $row['RIP'];
}

if($modelo == "200"){
    $sql1 = "SELECT ID_MODELO FROM periferico WHERE ID_PERI = '$id'";
    $result1 = $datos_base->query($sql1);
    $row1 = $result1->fetch_assoc();
    $modelo = $row1['ID_MODELO'];
}

if($estado == "300"){
    $sql2 = "SELECT ID_ESTADOWS FROM periferico WHERE ID_PERI = '$id'";
    $result2 = $datos_base->query($sql2);
    $row2 = $result2->fetch_assoc();
    $estado = $row2['ID_ESTADOWS'];
}

if($prov == "400"){
    $sql3 = "SELECT ID_PROVEEDOR FROM periferico WHERE ID_PERI = '$id'";
    $result3 = $datos_base->query($sql3);
    $row3 = $result3->fetch_assoc();
    $prov = $row3['ID_PROVEEDOR'];
}

if($tipop == "500"){
    $sql4 = "SELECT ID_TIPOP FROM periferico WHERE ID_PERI = '$id'";
    $result4 = $datos_base->query($sql4);
    $row4 = $result4->fetch_assoc();
    $tipop = $row4['ID_TIPOP'];
}

if($usu == "600"){
    $sql5 = "SELECT ID_USUARIO FROM periferico WHERE ID_PERI = '$id'";
    $result5 = $datos_base->query($sql5);
    $row5 = $result5->fetch_assoc();
    $usu = $row5['ID_USUARIO'];
}


if($marca == "800"){
    $sql6 = "SELECT ID_PROCEDENCIA FROM periferico WHERE ID_PERI = '$id'";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $proc = $row6['ID_PROCEDENCIA'];
}

/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
/* $sqli = "SELECT * FROM periferico WHERE SERIEG = '$serieg'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$serg = $row2['SERIEG']; */

$sqli = "SELECT ID_MARCA FROM modelo WHERE ID_MODELO = '$modelo'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$marca = $row2['ID_MARCA'];

$sqli = "SELECT * FROM periferico WHERE SERIE ='$serie' AND ID_PERI != '$id' ";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$ser = $row2['SERIE'];

$sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$area = $row2['ID_AREA'];

if($serie == $ser){ 
    header("Location: abmimpresoras.php?no");
}
else{
    /* MOVIMIENTOS DEL PERIFERICO */
    $sqli = "SELECT ID_AREA, ID_USUARIO, ID_ESTADOWS FROM periferico WHERE ID_PERI = '$id'";
    $resultado2 = $datos_base->query($sqli);
    $row2 = $resultado2->fetch_assoc();
    $a = $row2['ID_AREA'];
    $u = $row2['ID_USUARIO'];
    $e = $row2['ID_ESTADOWS'];
    if($a != $area || $u != $usu || $e != $estado){
    mysqli_query($datos_base, "INSERT INTO movimientosperi VALUES (DEFAULT, '$fechaActual', '$id', '$area', '$usu', '$estado')");
    }


    mysqli_query($datos_base, "UPDATE periferico SET ID_TIPOP = '$tipop', SERIEG = '$serieg', ID_MARCA = '$marca', SERIE = '$serie', ID_PROCEDENCIA = '$proc', OBSERVACION = '$obs', MAC = '$mac', RIP = '$rip', IP = '$ip', ID_PROVEEDOR = '$prov', FACTURA = '$factura', ID_AREA = '$area', ID_USUARIO = '$usu', GARANTIA = '$garantia', ID_ESTADOWS = '$estado', ID_MODELO = '$modelo' WHERE ID_PERI = '$id'");

    header("Location: abmimpresoras.php?ok");
}
mysqli_close($datos_base);
?>