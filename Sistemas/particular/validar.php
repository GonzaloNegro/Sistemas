<?php
	include('./conexion.php');
	include('./functions.php');

	$cuil = limpiar_cadena($_POST['cuil']);
	$clave = limpiar_cadena($_POST['clave']);

	$consulta= "SELECT * FROM resolutor WHERE CUIL='$cuil' and CONTRASEÑA='$clave'";
	$resultado=mysqli_query($datos_base,$consulta);

	$filas=mysqli_num_rows($resultado);

	if($filas){
		session_start();
		$_SESSION['cuil'] = $cuil; 
		header("location: ../consulta/consulta.php?okpw");
	}else{
		header("location: inicio.php?error"); 
	}

	mysqli_free_result($resultado);
	mysqli_close($datos_base);
?>

