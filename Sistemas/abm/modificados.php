<?php
include('../particular/conexion.php');

/* --------------------MODIFICAR PLAN: modPlanes.php --------------------- */
// if(isset($_POST['btnModPlanes'])){
    $id = $_POST['id'];
    $nombrePlan = $_POST['nombrePlan'];
    $plan = $_POST['plan'];
    $proveedor = $_POST['proveedor'];
    $monto = $_POST['monto'];
    
    /*TRAIGO VALORES DE LOS CMB*/
    if($plan == "100"){
        $sql3 = "SELECT ID_PLAN FROM nombreplan WHERE ID_NOMBREPLAN = '$id'";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $plan = $row3['ID_PLAN'];
    }
    
    if($proveedor == "200"){
        $sql3 = "SELECT ID_PROVEEDOR FROM nombreplan WHERE ID_NOMBREPLAN = '$id'";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $proveedor = $row3['ID_PROVEEDOR'];
    }
    
    /*SI LOS CAMPOS ESTAN REPETIDOS*/
    $sqli = "SELECT COUNT(*) AS cantidad FROM nombreplan WHERE NOMBREPLAN = '$nombrePlan' AND ID_PLAN ='$plan' AND ID_NOMBREPLAN != '$id'";
    $result = $datos_base->query($sqli);
    $rowa = $result->fetch_assoc();
    $cantidad = $rowa['cantidad'];
    
    if($cantidad > 0){
        header("Location: ./abmPlanesCelulares.php?no");
        mysqli_close($datos_base);
    }else{
        mysqli_query($datos_base, "UPDATE nombreplan SET NOMBREPLAN = '$nombrePlan', ID_PLAN ='$plan', ID_PROVEEDOR = '$proveedor', MONTO = '$monto' WHERE ID_NOMBREPLAN = '$id'");
        header("Location: ./abmPlanesCelulares.php?mod");
        mysqli_close($datos_base);
    }
// }
/* ------------------------------------------ */
/* ------------------------------------------ */

?>