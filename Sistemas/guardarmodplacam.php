<?php
include('conexion.php');

$placam = $_POST['placam'];
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
$sql = "SELECT * FROM placam WHERE PLACAM = '$placam'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$pm = $row['PLACAM'];


/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
$sqli = "SELECT * FROM placam WHERE PLACAM = '$placam' AND ID_MARCA ='$marca'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$pcm = $row2['PLACAM'];
$mar = $row2['ID_MARCA'];


if($placam == $pcm AND $marca == $mar){ 
    header("Location: agregarplacam.php?no");
}
elseif($placam == $pm){
    mysqli_query($datos_base, "INSERT INTO placam VALUES (DEFAULT, '$placam', '$marca')"); 
    header("Location: agregarplacam.php?repeat");
}
else{
    mysqli_query($datos_base, "INSERT INTO placam VALUES (DEFAULT, '$placam', '$marca')"); 
    header("Location: agregarplacam.php?ok");
}
mysqli_close($datos_base);
?>