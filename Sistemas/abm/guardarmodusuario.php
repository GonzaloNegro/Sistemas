<?php
include('../particular/conexion.php');

$nombre = $_POST['nombre_usuario'];
$cuil = $_POST['cuil'];
$area = $_POST['area'];
$piso = $_POST['piso'];
$int = $_POST['interno'];
$tel = $_POST['telefono_personal'];
$correo = $_POST['correo'];
$correop = $_POST['correo_personal'];
$turno = $_POST['turno'];
$estadoUsuario = 1; /* SETEO EL ESTADO A ACTIVO PARA SU REGISTRO */
$obs = $_POST['obs'];

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$sql = "SELECT NOMBRE, CUIL FROM usuarios WHERE NOMBRE = '$nombre' OR CUIL='$cuil'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$nom = $row['NOMBRE'];
$cui = $row['CUIL'];


/* 
SI EL ESTADO ES ACTIVO{
    -INSERT EN TABLA usuarios
    -INSERT EN TABLA wsusuarios EN MODO VINCULACION (SE VINCULA AL SISTEMA) SIN EQUIPO
}


********NO PERMITIR QUE SE PUEDA CARGAR EL USUARIO COMO INACTIVO, QUE LO REGISTREN Y LUEGO LO MODIFIQUEN AL ESTADO SI QUIEREN REGISTRARLO INACTIVO********
*/

if($cuil == $cui)
{
    header("Location: agregarusuario.php?no");
}
else if($nombre == $nom)
{
    mysqli_query($datos_base, "INSERT INTO usuarios VALUES (DEFAULT, '$nombre', '$cuil', '$area', '$piso', '$int', '$correo', '$correop', '$tel', '$turno', '$act', '$obs')"); 
    header("Location: agregarusuario.php?repeat");
}
else
{
mysqli_query($datos_base, "INSERT INTO usuarios VALUES (DEFAULT, '$nombre', '$cuil', '$area', '$piso', '$int', '$correo', '$correop', '$tel', '$turno', '$act', '$obs')"); 
header("Location: agregarusuario.php?ok");
}
mysqli_close($datos_base);
?>