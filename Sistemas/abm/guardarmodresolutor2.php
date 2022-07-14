<?php
session_start();
include('..particular/conexion.php');

$id = $_POST['id'];
$nom = $_POST['nom'];
$cuil = $_POST['cuil'];
$cor = $_POST['cor'];
$tel = $_POST['tel'];
$tipo = $_POST['tipo'];

if($tipo == "100"){
  $sql = "SELECT ID_TIPO_RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = '$id'";
  $result = $datos_base->query($sql);
  $row = $result->fetch_assoc();
  $tipo = $row['ID_TIPO_RESOLUTOR'];
}

/* SI UNO DE LOS CAMPOS ESTA REPETIDO */
$sql = "SELECT RESOLUTOR, CUIL FROM resolutor WHERE RESOLUTOR = '$resolutor' OR CUIL='$cuil' AND ID_RESOLUTOR != '$id'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
$res = $row['RESOLUTOR'];
$cui = $row['CUIL'];

if($cuil == $cui){
    header("Location: abmresolutor.php?no");
  }
else{
    mysqli_query($datos_base, "UPDATE resolutor SET RESOLUTOR = '$nom', ID_TIPO_RESOLUTOR = '$tipo', CUIL = '$cuil', CORREO = '$cor', TELEFONO = '$tel' WHERE ID_RESOLUTOR = '$id'");
    header("Location: abmresolutor.php?ok");
  }
mysqli_close($datos_base);