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

	$consulta="SELECT i.ID_WS, i.SERIEG
        FROM inventario i
        LEFT JOIN wsusuario ws 
            ON i.ID_WS = ws.ID_WS
            AND ws.ID_WSUSU = (
                SELECT MAX(wsu.ID_WSUSU)
                FROM wsusuario wsu
                WHERE wsu.ID_WS = i.ID_WS
            )
	where ws.ID_USUARIO=$usuario AND i.ID_ESTADOWS=1";

	$result=mysqli_query($datos_base,$consulta) or die(mysqli_error($datos_base));
    
	
	$cadena="<option value='0'>-SELECCIONE UNA-</OPTION>";

	while ($ver=mysqli_fetch_row($result)) {
		$cadena=$cadena.'<option value='.$ver[0].'>'.utf8_encode($ver[1]).'</option>';
	}

	echo  $cadena;
	// ."</select>";
	

?>