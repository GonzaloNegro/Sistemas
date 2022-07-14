<?php
$cuil=$_POST['cuil'];
$clave=$_POST['clave'];
include('conexion.php');

$consulta= "SELECT * FROM resolutor WHERE CUIL='$cuil' and CONTRASEÑA='$clave'";
$resultado=mysqli_query($datos_base,$consulta);

$filas=mysqli_num_rows($resultado);


if($filas){
	session_start();
	$_SESSION['cuil'] = $cuil; 
	header("location: bienvenida.php");
	
}else{
	?>
	<?php
	header("location: inicio.php?error"); 
	?>
	<?php
}
mysqli_free_result($resultado);
mysqli_close($datos_base);
?>

