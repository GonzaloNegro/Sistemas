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

	$consulta="SELECT * FROM inventario i inner join wsusuario u 
	on i.ID_WS=u.ID_WS where u.ID_USUARIO=$usuario";

	$result=mysqli_query($datos_base,$consulta) or die(mysqli_error($datos_base));
    
	
	$cadena="<label class='col-form-label col-xl col-lg'>EQUIPO DEL USUARIO:</label> 
			<select id='equipo' name='equipo' class='form-control col-xl col-lg' required>
			<option value='0'>-SELECCIONE UNA-</OPTION>";

	while ($ver=mysqli_fetch_row($result)) {
		$cadena=$cadena.'<option value='.$ver[0].'>'.utf8_encode($ver[3]).'</option>';
	}

	echo  $cadena."</select>";
	

?>