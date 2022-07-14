<?php
include('..particular/conexion.php');

$modelo = $_POST['modelo'];
$marca = $_POST['marca'];
$tipo = $_POST['tipo'];

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$sql = "SELECT * FROM modelo WHERE MODELO = '$modelo'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$mo = $row['MODELO'];


/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
$sqli = "SELECT * FROM modelo WHERE MODELO = '$modelo' AND ID_MARCA ='$marca'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$mod = $row2['MODELO'];
$mar = $row2['ID_MARCA'];


if($modelo == $mod AND $marca == $mar){ 
    header("Location: agregarmodelo.php?no");
}
elseif($modelo == $mo){
    mysqli_query($datos_base, "INSERT INTO modelo VALUES (DEFAULT, '$modelo', '$tipo', '$marca')"); 
    header("Location: agregarmodelo.php?repeat");
}
else{
    mysqli_query($datos_base, "INSERT INTO modelo VALUES (DEFAULT, '$modelo', '$tipo', '$marca')");
    header("Location: agregarmodelo.php?ok");
}
mysqli_close($datos_base);
?>