<?php
include('conexion.php');

$tipop = $_POST['tipop'];
$serieg = $_POST['serieg'];
$marca = $_POST['marca'];
$serie = $_POST['serie'];
$usu = $_POST['usu'];
$modelo = $_POST['mod'];
$est = $_POST['est'];
$gar = $_POST['gar'];
$prov = $_POST['prov'];
$fac = $_POST['fac'];
$obs = $_POST['obs'];

$fechaActual = date('Y-m-d');

/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
$sqli = "SELECT * FROM periferico WHERE SERIEG = '$serieg' AND (ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12)";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$serg = $row2['SERIEG'];

$sqli = "SELECT * FROM periferico WHERE SERIE ='$serie' AND (ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12)";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$ser = $row2['SERIE'];

$sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$area = $row2['ID_AREA'];

if($tipop == 5){
    $tip = 'TICKEADORA';
}
elseif($tipop == 6){
    $tip = 'SCANNER';
}
elseif($tipop == 9){
    $tip = 'CAMARA';
}
elseif($tipop == 11){
    $tip = 'TELÉFONO ANALÓGICO';
}
elseif($tipop == 12){
    $tip = 'TELÉFONO IP';
}

if($serieg == $serg OR $serie == $ser){ 
    header("Location: agregarotrosperifericos.php?no");
}
else{
    mysqli_query($datos_base, "INSERT INTO periferico VALUES (DEFAULT, '$tipop', DEFAULT, '$serieg', '$marca', '$serie', 3, '$obs', '$tip', DEFAULT, 'NO', DEFAULT, '$prov', '$fac', '$area', '$usu', '$gar', '$est', '$modelo')");

    /* GUARDANDO PARA LOS MOVIMIENTOS */
    $pe=mysqli_query($datos_base, "SELECT MAX(ID_PERI) AS id FROM periferico");
    if ($row = mysqli_fetch_row($pe)) {
        $per = trim($row[0]);
        }

    mysqli_query($datos_base, "INSERT INTO movimientosperi VALUES (DEFAULT, '$fechaActual', '$per', '$area', '$usu', '$est')");

    header("Location: agregarotrosperifericos.php?ok");
}
mysqli_close($datos_base);
?>