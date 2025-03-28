<?php
session_start();
include('../particular/conexion.php');

/* -----------------PLANES: agregarPlan.php----------------- */
// if(isset($_POST['agregarPlan'])){
    $nombrePlan = $_POST['nombrePlan'];
    // $idPlan = $_POST['imei'];
    $idPlan = $_POST['plan'];
    $proveedor = $_POST['proveedor'];
    $monto = $_POST['monto'];

    /* SI IMEI ESTA REPETIDO */
    $sql = "SELECT COUNT(*) AS TOTAL FROM nombreplan WHERE NOMBREPLAN = '$nombrePlan' AND ID_PLAN = '$idPlan'";
    $resultado = $datos_base->query($sql);
    $row = $resultado->fetch_assoc();
    $cantidadRegistros = $row['TOTAL'];

    if($cantidadRegistros > 0){//SI HAY ALGUN REGISTRO EXISTENTE CON ESOS DATOS
        header("Location: ./abmPlanesCelulares.php?no");
    }else{
        mysqli_query($datos_base, "INSERT INTO nombreplan VALUES (DEFAULT, '$nombrePlan', '$idPlan', '$proveedor', '$monto')");
        header("Location: ./abmPlanesCelulares.php?ok");
    }
    mysqli_close($datos_base);
// }


/* --------------------------------------------------------- */
/* ----------------- #: #.php----------------- */
/* --------------------------------------------------------- */
?>