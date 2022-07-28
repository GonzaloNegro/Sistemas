<?php
include('../particular/conexion.php');

$micro = $_POST['micro'];
$marca = $_POST['marca'];
/* $factura = $_POST['factura'];
$proveedor = $_POST['proveedor'];
$garantia = $_POST['garantia'];
if(isset($_POST['fecha'])){
	if(!empty($_POST['fecha'])){
		$date = $_POST['fecha'];
		$date = strtotime($date);
		$date = date('Y-m-d', $date);
	}
} */

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$sql = "SELECT * FROM micro WHERE MICRO = '$micro'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$mi = $row['MICRO'];


/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
$sqli = "SELECT * FROM micro WHERE MICRO = '$micro' AND ID_MARCA ='$marca'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$mic = $row2['MICRO'];
$mar = $row2['ID_MARCA'];


if($micro == $mic AND $marca == $mar){ 
    header("Location: agregarmicro.php?no");
}
elseif($micro == $mi){
    mysqli_query($datos_base, "INSERT INTO micro VALUES (DEFAULT, '$micro', '$marca')"); 
    header("Location: agregarmicro.php?repeat");
}
else{
    mysqli_query($datos_base, "INSERT INTO micro VALUES (DEFAULT, '$micro', '$marca')"); 
    header("Location: agregarmicro.php?ok");
}
mysqli_close($datos_base);
?>