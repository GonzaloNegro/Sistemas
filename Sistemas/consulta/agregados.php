<?php
session_start();
include('../particular/conexion.php');

/* -----------------CELULAR: agregarCelular.php----------------- */
if(isset($_POST['agregarCelular'])){
    $imei = $_POST['imei'];
    $usuario = $_POST['usuario'];
    $linea = $_POST['linea'];
    $estado = $_POST['estado'];
    $proveedor = $_POST['proveedor'];
    $modelo = $_POST['modelo'];
    $procedencia = $_POST['procedencia'];
    $obs = $_POST['obs'];

    // Obteniendo la fecha actual del sistema con PHP
    $fechaActual = date('Y-m-d');

    /* SI IMEI ESTA REPETIDO */
    $sql = "SELECT * FROM celular WHERE IMEI = '$imei'";
    $resultado = $datos_base->query($sql);
    $row = $resultado->fetch_assoc();
    $imeiRegistrado = $row['IMEI'];

    /* SI EL USUARIO YA TIENE UN REGISTRO */
    $sql = "SELECT COUNT(*) AS TOTAL FROM celular WHERE ID_USUARIO = '$usuario' AND ID_ESTADOWS = 1";
    $resultado = $datos_base->query($sql);
    $row = $resultado->fetch_assoc();
    $usuarioRegistrado = $row['TOTAL'];

    if($imei == $imeiRegistrado){
        header("Location: agregarCelular.php?no");
    }
    else if($usuarioRegistrado > 1){
        header("Location: agregarCelular.php?reg");
    }
    else{
        //SI EL CELULAR ESTA ASIGNADO A UNA LINEA O NO
        if($linea = ''){//CELULAR SIN ASIGNAR A UNA LINEA
            //INSERTAR EN TABLA celular
            mysqli_query($datos_base, "INSERT INTO celular VALUES (DEFAULT, '$imei', '$usuario', '$estado', '$proveedor', '$modelo', '$procedencia')");

            //INSERTAR EN TABLA movicelular
            $tic=mysqli_query($datos_base, "SELECT MAX(ID_CELULAR) AS id FROM celular");
            if ($row = mysqli_fetch_row($tic)) {
                $tic1 = trim($row[0]);
                }
    
            mysqli_query($datos_base, "INSERT INTO movicelular VALUES(DEFAULT, '$tic1','$estado', '$usuario', '$fechaActual','$obs')");

            //INSERTAR EN TABLA lineacelular
            mysqli_query($datos_base, "INSERT INTO lineacelular VALUES(DEFAULT, 0, '$tic1', '$usuario', '$fechaActual')");

        }else{//CELULAR ASIGNADO A UNA LINEA
            //INSERTAR EN TABLA celular
            mysqli_query($datos_base, "INSERT INTO celular VALUES (DEFAULT, '$imei', '$usuario', '$estado', '$proveedor', '$modelo', '$procedencia')");

            //INSERTAR EN TABLA movicelular
            $tic=mysqli_query($datos_base, "SELECT MAX(ID_CELULAR) AS id FROM celular");
            if ($row = mysqli_fetch_row($tic)) {
                $tic1 = trim($row[0]);
                }
    
            mysqli_query($datos_base, "INSERT INTO movicelular VALUES(DEFAULT, '$tic1','$estado', '$usuario', '$fechaActual','$obs')");

            //INSERTAR EN TABLA lineacelular            
            mysqli_query($datos_base, "INSERT INTO lineacelular VALUES(DEFAULT, '$linea', '$tic1', '$usuario', '$fechaActual')");
        }

        header("Location: agregarCelular.php?ok");
    }
    mysqli_close($datos_base);
}


/* --------------------------------------------------------- */
/* -----------------LINEA: agregarLinea.php----------------- */
/* --------------------------------------------------------- */

// if(isset($_POST['agregarLinea'])){
if(isset($_POST['text'])){
    $numero = $_POST['text'];
    $usuario = $_POST['usuario'];
    $celular = $_POST['celular'];
    $estado = $_POST['estado'];
    // $plan = $_POST['plan'];
    $descuento = $_POST['descuento'];
    $fechaDesc = $_POST['fecha'];
    $nombrePlan = $_POST['nombrePlan'];
    $roaming = $_POST['roaming'];
    $obs = $_POST['obs'];
    $extras = $_POST['extras'];

    // Obteniendo la fecha actual del sistema con PHP
    $fechaActual = date('Y-m-d');

    /* SI IMEI ESTA REPETIDO */
    $sql = "SELECT * FROM linea WHERE NRO = '$numero'";
    $resultado = $datos_base->query($sql);
    $row = $resultado->fetch_assoc();
    $numeroRegistrado = $row['NRO'];

    /* SI EL USUARIO YA TIENE UN REGISTRO */
    $sql = "SELECT COUNT(*) AS TOTAL FROM movilinea WHERE ID_USUARIO = '$usuario' AND ID_ESTADOWS = 1";
    $resultado = $datos_base->query($sql);
    $row = $resultado->fetch_assoc();
    $usuarioRegistrado = $row['TOTAL'];

    if($numero == $numeroRegistrado){
        header("Location: agregarLinea.php?no");
    }
    else if($usuarioRegistrado > 3){
        header("Location: agregarLinea.php?reg");
    }
    else{

        //CALULAR MONTO DEL PLAN
        $sql3 = "SELECT * FROM nombreplan WHERE ID_NOMBREPLAN = '$nombrePlan'";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $montoDelPlan = $row3['MONTO'];

        $iva = 21;
        $impInternos = 1.21;
        //CALCULAR MONTO TOTAL
        $descuentoParaCuenta= 1-($descuento * 0.01);
        $monto_iva=$montoDelPlan*$impInternos;     
        $monto_total=$monto_iva*$descuentoParaCuenta;
        $extras_iva=$extras*$impInternos;
        $monto_total = $monto_total + $extras;

        //SI  LA LINEA ESTA ASIGNADA A UN CELULAR O NO
        if($celular = ''){//LINEA SIN ASIGNAR A UN CELULAR
            //INSERTAR EN TABLA linea
            mysqli_query($datos_base, "INSERT INTO linea VALUES (DEFAULT, '$numero', '$usuario', '$estado', '$descuento', '$fechaDesc', '$nombrePlan', '$roaming')");

            //INSERTAR EN TABLA movilinea
            $tic=mysqli_query($datos_base, "SELECT MAX(ID_LINEA) AS id FROM linea");
            if ($row = mysqli_fetch_row($tic)) {
                $tic1 = trim($row[0]);
                }
                mysqli_query($datos_base, "INSERT INTO movilinea VALUES(DEFAULT, '$tic1', '$usuario','$estado', '$nombrePlan', '$montoDelPlan', '$fechaDesc','$roaming', '$descuento', '$extras', '$monto_total', '$obs', '$fechaActual')");

            //INSERTAR EN TABLA lineacelular
            mysqli_query($datos_base, "INSERT INTO lineacelular VALUES(DEFAULT, '$tic1', 0, '$usuario', '$fechaActual')");

        }else{//CELULAR ASIGNADO A UNA LINEA
            //INSERTAR EN TABLA linea
            mysqli_query($datos_base, "INSERT INTO linea VALUES (DEFAULT, '$numero', '$usuario', '$estado', '$descuento', '$fechaDesc', '$nombrePlan', '$roaming')");

            //INSERTAR EN TABLA movilinea
            $tic=mysqli_query($datos_base, "SELECT MAX(ID_LINEA) AS id FROM linea");
            if ($row = mysqli_fetch_row($tic)) {
                $tic1 = trim($row[0]);
                }
                mysqli_query($datos_base, "INSERT INTO movilinea VALUES(DEFAULT, '$tic1', '$usuario','$estado', '$nombrePlan',  '$montoDelPlan', '$fechaDesc', '$roaming','$descuento', '$extras', '$monto_total', '$obs', '$fechaActual')");

            //INSERTAR EN TABLA lineacelular
            mysqli_query($datos_base, "INSERT INTO lineacelular VALUES(DEFAULT, '$tic1', '$celular', '$usuario', '$fechaActual')");

        }

        header("Location: agregarLinea.php?ok");
    }
    mysqli_close($datos_base);
}

?>