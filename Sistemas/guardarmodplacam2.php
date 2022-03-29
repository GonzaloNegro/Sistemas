<?php
include('conexion.php');

$id = $_POST['id'];
$placam = $_POST['placam'];
$marca = $_POST['marca'];
/* $proveedor = $_POST['proveedor'];
$garantia = $_POST['garantia'];
$factura = $_POST['factura'];
if(isset($_POST['fecha'])){
	if(!empty($_POST['fecha'])){
		$date = $_POST['fecha'];
		$date = strtotime($date);
		$date = date('Y-m-d', $date);
	}
} */

/*TRAIGO VALORES DE LOS CMB*/

if($marca == "100"){
    $sql3 = "SELECT ID_MARCA FROM placam WHERE ID_PLACAM = '$id'";
    $result3 = $datos_base->query($sql3);
    $row3 = $result3->fetch_assoc();
  
    $marca = $row3['ID_MARCA'];
}
/*TRAIGO VALORES DE LOS CMB*/

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$sql = "SELECT * FROM placam WHERE PLACAM = '$placam' AND ID_PLACAM != '$id'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$pm = $row['PLACAM'];

$sqli = "SELECT * FROM placam WHERE PLACAM = '$placam' AND ID_MARCA ='$marca' AND ID_PLACAM != '$id'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$pcm = $row2['PLACAM'];
$mar = $row2['ID_MARCA'];
/*SI AMBOS CAMPOS ESTAN REPETIDOS*/

/*CONTROL FINAL*/
if($placam == $pcm AND $marca == $mar){ 
    header("Location: abmplacamadre.php?no");
}
elseif($placam == $pm){
    mysqli_query($datos_base, "UPDATE placam SET PLACAM = '$placam', ID_MARCA = '$marca' WHERE ID_PLACAM = '$id'"); 
    header("Location: abmplacamadre.php?repeat");
}
else{
    mysqli_query($datos_base, "UPDATE placam SET PLACAM = '$placam', ID_MARCA = '$marca' WHERE ID_PLACAM = '$id'");  
    header("Location: abmplacamadre.php?ok");
}
mysqli_close($datos_base);
?>