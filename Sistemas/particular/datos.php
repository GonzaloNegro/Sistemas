<?php 

session_start();
include('conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();

$usuario=$_POST['usuario'];

	$consulta="SELECT i.*
	FROM inventario i
	INNER JOIN (
		SELECT w1.ID_WS, w1.ID_USUARIO
		FROM wsusuario w1
		INNER JOIN (
			SELECT ID_WS, MAX(ID_WSUSU) AS UltimoMov
			FROM wsusuario
			GROUP BY ID_WS
		) w2 ON w1.ID_WS = w2.ID_WS AND w1.ID_WSUSU = w2.UltimoMov
	) ult
		ON i.ID_WS = ult.ID_WS
	WHERE ult.ID_USUARIO = $usuario
	AND i.ID_ESTADOWS = 1;";

	$result=mysqli_query($datos_base,$consulta) or die(mysqli_error($datos_base));
    
	
	$cadena="<option value='0'>-SELECCIONE UNA-</OPTION>";

	while ($ver=mysqli_fetch_row($result)) {
		$cadena=$cadena.'<option value='.$ver[0].'>'.utf8_encode($ver[1]).'</option>';
	}

	echo  $cadena;
	// ."</select>";
	

?>