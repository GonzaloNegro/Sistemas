<?php
include('conexion.php');

$id = $_POST['id'];
$micro = $_POST['micro'];
$marca = $_POST['marca'];
$proveedor = $_POST['proveedor'];
$garantia = $_POST['garantia'];
$factura = $_POST['factura'];
if(isset($_POST['fecha'])){
	if(!empty($_POST['fecha'])){
		$date = $_POST['fecha'];
		$date = strtotime($date);
		$date = date('Y-m-d', $date);
	}
}

/*TRAIGO VALORES DE LOS CMB*/
if($tipo == "200"){
    $sql4 = "SELECT ID_PROVEEDOR FROM micro WHERE ID_MICRO = '$id'";
    $result4 = $datos_base->query($sql4);
    $row4 = $result4->fetch_assoc();
  
    $proveedor = $row4['ID_PROVEEDOR'];
}

if($marca == "100"){
    $sql3 = "SELECT ID_MARCA FROM micro WHERE ID_MICRO = '$id'";
    $result3 = $datos_base->query($sql3);
    $row3 = $result3->fetch_assoc();
  
    $marca = $row3['ID_MARCA'];
}
/*TRAIGO VALORES DE LOS CMB*/

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$sql = "SELECT * FROM micro WHERE MICRO = '$micro' AND ID_MICRO != '$id'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$mi = $row['MICRO'];

$sqli = "SELECT * FROM micro WHERE MICRO = '$micro' AND ID_MARCA ='$marca' AND ID_MICRO != '$id'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$mic = $row2['MICRO'];
$mar = $row2['ID_MARCA'];
/*SI AMBOS CAMPOS ESTAN REPETIDOS*/

/*CONTROL FINAL*/
if($micro == $mic AND $marca == $mar){ 
    header("Location: abmmicro.php?no");
}
elseif($micro == $mi){
    mysqli_query($datos_base, "UPDATE micro SET MICRO = '$micro', ID_MARCA = '$marca', FACTURA = '$factura', ID_PROVEEDOR = '$proveedor', GARANTIA = '$garantia', FECHA = '$date' WHERE ID_MICRO = '$id'"); 
    header("Location: abmmicro.php?repeat");
}
else{
    mysqli_query($datos_base, "UPDATE micro SET MICRO = '$micro', ID_MARCA = '$marca', FACTURA = '$factura', ID_PROVEEDOR = '$proveedor', GARANTIA = '$garantia', FECHA = '$date' WHERE ID_MICRO = '$id'"); 
    header("Location: abmmicro.php?ok");
}
mysqli_close($datos_base);
?>