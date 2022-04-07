<?php
session_start();
include('conexion.php');

$id = $_POST['id'];
$nombre = $_POST['nom'];
$cuil = $_POST['cuil'];
$are = $_POST['are'];
$pis = $_POST['piso'];
$int = $_POST['int'];
$cor = $_POST['cor'];
$corp = $_POST['corp'];
$tel = $_POST['tel'];
$tur = $_POST['tur'];
$obs = $_POST['obs'];
$act = $_POST['act'];

/*BOTON MODIFICAR*/
if($pis == "400"){
  $sqlp = "SELECT PISO FROM usuarios WHERE ID_USUARIO = '$id'";
  $pis = $sqlp;
}
if($act == "300"){
  $sqla = "SELECT ACTIVO FROM usuarios WHERE ID_USUARIO = '$id'";
  $act = $sqla;
}
if($are == "200"){
  $sql = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$id'";
  $result = $datos_base->query($sql);
  $row = $result->fetch_assoc();
  $are = $row['ID_AREA'];
}
if($tur == "100"){
  $sql2 = "SELECT ID_TURNO FROM usuarios WHERE ID_USUARIO = '$id'";
  $result2 = $datos_base->query($sql2);
  $row2 = $result2->fetch_assoc();
  $tur = $row2['ID_TURNO'];
}

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$sql = "SELECT * FROM usuarios WHERE (CUIL ='$cuil' AND ID_USUARIO != '$id')";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$cui = $row['CUIL'];

if($cuil == $cui)
  {
    header("Location: abmusuario.php?no");
  }
else
  {
    mysqli_query($datos_base, "UPDATE usuarios SET NOMBRE = '$nombre', CUIL = '$cuil', ID_AREA = '$are', PISO = '$pis', INTERNO = '$int', CORREO = '$cor', CORREO_PERSONAL = '$corp', TELEFONO_PERSONAL = '$tel', ID_TURNO = '$tur', ACTIVO = '$act', OBSERVACION = '$obs' WHERE ID_USUARIO = '$id'");
    header("Location: abmusuario.php?ok");
  }
mysqli_close($datos_base);
?>