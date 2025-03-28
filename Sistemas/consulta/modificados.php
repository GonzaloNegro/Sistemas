<?php
session_start();
include('../particular/conexion.php');

/* -----------------CELULAR: modificarCelular.php----------------- */
if(isset($_POST['modificarCelular'])){
    $id = $_POST['id'];
    $imei = $_POST['imei'];
    $usuario = $_POST['usuario'];
    $linea = $_POST['linea'];
    $estado = $_POST['estado'];
    $proveedor = $_POST['proveedor'];
    $modelo = $_POST['modelo'];
    $procedencia = $_POST['procedencia'];
    $obs = $_POST['obs'];

    if($usuario == "100"){
        $sql3 = "SELECT ID_USUARIO FROM celular WHERE ID_CELULAR = '$id'";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $usuario = $row3['ID_USUARIO'];
    }
    if($estado == "200"){
        $sql3 = "SELECT ID_ESTADOWS FROM celular WHERE ID_CELULAR = '$id'";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $estado = $row3['ID_ESTADOWS'];
    }
    if($proveedor == "300"){
        $sql3 = "SELECT ID_PROVEEDOR FROM celular WHERE ID_CELULAR = '$id'";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $proveedor = $row3['ID_PROVEEDOR'];
    }
    if($modelo == "400"){
        $sql3 = "SELECT ID_MODELO FROM celular WHERE ID_CELULAR = '$id'";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $modelo = $row3['ID_MODELO'];
    }
    if($procedencia == "500"){
        $sql3 = "SELECT ID_PROCEDENCIA FROM celular WHERE ID_CELULAR = '$id'";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $procedencia = $row3['ID_PROCEDENCIA'];
    }

    if($estado !=  1){//SI ESTADO ES DIFERENTE A "EN USO"
        //SI ESTA DADO DE BAJA O SIN ASIGNAR
        //TABLA celular: UPDATE USUARIO, ESTADO

        //TABLA movicelular: INSERT MODIFICANDO ESTADO, USUARIO, FECHA

        //TABLA lineacelular: INSERT MODIFICANDO ID_USUARIO Y SI TIENE LINEA ASIGNADA SACARLA.


    }else{//SI EL ESTADO ES "EN USO"
        //VERIFICAR SI $linea ES '' O TIENE UN VALOR, PARA VERIFICAR SI SE ASIGNA A UNA LINEA EXISTENTE O NO
        if($linea = ''){//CELULAR SIN ASIGNAR A UNA LINEA
            //TABLA celular: UPDATE USUARIO, ESTADO, PROVEEDOR, MODELO, PROCEDENCIA

            //TABLA movicelular: INSERT ID_MOVICEL DEFAULT, ID_CELULAR, ESTADOM USUARIO, FECHA, OBS

            //TABLA lineacelular: INSERT ID_LINEACELULAR DEFAULT, ID_LINEA SERA 0, ID_CELULAR, USUARIO, FECHA


        }else{//CELULAR CON LINEA ASIGNADA
            //TABLA celular: UPDATE

            //TABLA movicelular: 

            //TABLA lineacelular: 

        }
    }
}





/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */
/* -----------------MONTOS/LINEAS: modificarLinea.php----------------- */
/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */
if(isset($_POST['modificarLinea'])){
    $id = $_POST['id'];
    $nro = $_POST['nro'];
    $usuario = $_POST['usuario'];

    if($_POST['celular'] == null || $_POST['celular'] ==''){
        $celular = 0;
    }else{
        $celular = $_POST['celular'];
    }

    $estado = $_POST['estado'];
    $descuento = $_POST['descuento'];
    $fechaDescuento = $_POST['fechaDescuento'];
    $nombrePlan = $_POST['nombrePlan'];
    $roaming = $_POST['roaming'];
    $extras = $_POST['extras'];
    $obs = $_POST['obs'];

    $fechaActual = date('Y-m-d');

    if($usuario == "100"){
        $sql3 = "SELECT ID_USUARIO FROM linea WHERE ID_LINEA = '$id'";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $usuario = $row3['ID_USUARIO'];
    }
    if($estado == "200"){
        $sql3 = "SELECT ID_ESTADOWS FROM linea WHERE ID_LINEA = '$id'";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $estado = $row3['ID_ESTADOWS'];
    }
    if($nombrePlan == "300"){
        $sql3 = "SELECT ID_NOMBREPLAN FROM linea WHERE ID_LINEA = '$id'";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $nombrePlan = $row3['ID_NOMBREPLAN'];
    }
    if($roaming == "400"){
        $sql3 = "SELECT ID_ROAMING FROM linea WHERE ID_LINEA = '$id'";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $roaming = $row3['ID_ROAMING'];
    }

    if($estado !=  1){//SI ESTADO ES DIFERENTE A "EN USO"
        //SI ESTA DADO DE BAJA O SIN ASIGNAR
        //TABLA linea: UPDATE 
        mysqli_query($datos_base, "UPDATE linea SET ID_USUARIO = 277, ID_ESTADOWS = '$estado', DESCUENTO = 0, FECHADESCUENTO = '0000-00-00', ID_NOMBREPLAN = 0, ID_ROAMING = 1 WHERE ID_LINEA = '$id'"); 

        //TABLA movilinea: INSERT MODIFICANDO ESTADO, USUARIO, FECHA
        mysqli_query($datos_base, "INSERT INTO movilinea VALUES (DEFAULT, '$id', 277, '$estado', 0, 0, '0000-00-00', 1, 0, 0, 0, '', '$fechaActual')");

        //TABLA lineacelular: INSERT MODIFICANDO ID_USUARIO Y SI TIENE CELULAR ASIGNADO SACARLO.
        $sql3 = "SELECT * FROM lineacelular
        WHERE ID_LINEA = '$id'
        ORDER BY ID_LINEACELULAR DESC";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $celularAsignado = $row3['ID_CELULAR'];
        $usuarioAsignado = $row3['ID_USUARIO'];

        if(isset($celularAsignado)){
        //SI TIENE CELULAR ASIGNADO, HACER INSERT EN lineacelular DE ID_LINEA Y DE ID_CELULAR
        mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, 0, '$celularAsignado', '$usuarioAsignado', '$fechaActual')");

        mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, '$id', 0, 277, '$fechaActual')");
        }else{
        //SI NO TIENE ASIGNADO UN CELULAR, HACER INSERT NUEVO EN lineacelular MODIFICANDO ID_USUARIO
        mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, '$id', 0, 277, '$fechaActual')");
        }

    }else{//SI EL ESTADO ES "EN USO"
        //VERIFICAR SI ACTUALMENTE LA LINEA ESTA ASIGNADA A UN CELULAR
        $sql3 = "SELECT * FROM lineacelular
        WHERE ID_LINEA = '$id'
        ORDER BY ID_LINEACELULAR DESC";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $celularAsignado = $row3['ID_CELULAR'];
        $usuarioAsignado = $row3['ID_USUARIO'];

        //SI SE MODIFICA EL DATO DEL SELECT DEL CELULAR
        if($celularAsignado != $celular){
            if($celular == 0){//EL CELULAR ES VACIO
                //SE INSERTA UN NUEVO DATO SOBRE LA LINEA, QUE AHORA ESTARA SIN CELULAR
                mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, '$id', 0, '$usuario', '$fechaActual')");
                
                //SE INSERTA UN NUEVO DATO SOBRE EL CELULAR VIEJO, QUE AHORA ESTARA SIN LINEA
                mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, 0, '$celularAsignado', '$usuarioAsignado', '$fechaActual')");
            }else{//SE LE ASIGNA UN NUEVO CELULAR
                //PRIMERO LA LINEA PASA A DEJAR EL USUARIO ANTERIOR Y SE PASA A SIN ASIGNAR
                mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, '$id', 0, 277, '$fechaActual')");
                //SE INSERTA UN NUEVO DATO LINKEANDO EL NUEVO CELULAR A LA LINEA
                mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, '$id', '$celular', '$usuario', '$fechaActual')");
            }
        }

        //CONSULTAR LOS DATOS ACTUALES DE LA BD
        $sql3 = "SELECT m.ID_MOVILINEA, l.NRO, m.ID_LINEA, m.ID_USUARIO, m.ID_ESTADOWS, m.ID_NOMBREPLAN, m.FECHADESCUENTO, m.DESCUENTO, m.EXTRAS, m.OBSERVACION, m.ID_ROAMING
        FROM linea l
        INNER JOIN movilinea m ON m.ID_LINEA = l.ID_LINEA
        WHERE m.ID_LINEA = '$id'
        ORDER BY m.ID_MOVILINEA DESC
        LIMIT 1";
        $result3 = $datos_base->query($sql3);
        $row3 = $result3->fetch_assoc();
        $nroBD = $row3['NRO'];
        $lineaBD = $row3['ID_LINEA'];
        $usuarioBD = $row3['ID_USUARIO'];
        $estadoBD = $row3['ID_ESTADOWS'];
        $nombrePlanBD = $row3['ID_NOMBREPLAN'];
        $fechaDescuentoBD = $row3['FECHADESCUENTO'];
        $descuentoBD = $row3['DESCUENTO'];
        $extrasBD = $row3['EXTRAS'];
        $observacionBD = $row3['OBSERVACION'];
        $roamingBD = $row3['ID_ROAMING'];

        if($nro != $nroBD OR $usuario != $usuarioBD OR $estado != $estadoBD OR $descuento != $descuentoBD OR $fechaDescuento != $fechaDescuentoBD OR $nombrePlan != $nombrePlanBD OR $roaming != $roamingBD){
            mysqli_query($datos_base, "UPDATE linea SET NRO = '$nro', ID_USUARIO = '$usuario', ID_ESTADOWS = '$estado', DESCUENTO = '$descuento', FECHADESCUENTO = '$fechaDescuento', ID_NOMBREPLAN = '$nombrePlan', ID_ROAMING = '$roaming' WHERE ID_LINEA = '$id'"); 
        }

        if($usuario != $usuarioBD OR $estado != $estadoBD OR $descuento != $descuentoBD OR $fechaDescuento != $fechaDescuentoBD OR $nombrePlan != $nombrePlanBD OR $roaming != $roamingBD OR $extras != $extrasBD OR $observacion != $observacionBD){

           //CALULAR MONTO DEL PLAN
           $sql3 = "SELECT * FROM nombreplan WHERE ID_NOMBREPLAN = '$nombrePlan'";
           $result3 = $datos_base->query($sql3);
           $row3 = $result3->fetch_assoc();
           $montoDelPlan = $row3['MONTO'];

           $iva = 21;
           $impInternos = 1.21;
   
        //    $descuentoParaCuenta= $descuento * 0.01;
        //    $valor_descuento=$montoDelPlan*$descuentoParaCuenta;
        //    $monto_total=$montoDelPlan-$valor_descuento;
   
        //    $impuesto = ($monto_total * $iva) / 100;
        // Se sube a BD el extra cargado en input de pantalla. Hay que reveer el calculo del extra ya que no da preciso
        //    $extras = $impuesto + $impInternos;
        //    $monto_total = $monto_total + $extras;
        
        $descuentoParaCuenta= 1-($descuento * 0.01);
        $monto_iva=$montoDelPlan*$impInternos;     
        $monto_total=$monto_iva*$descuentoParaCuenta;
        $extras_iva=$extras*$impInternos;
        $monto_total = $monto_total + $extras;


           mysqli_query($datos_base, "INSERT INTO movilinea VALUES (DEFAULT, '$id', '$usuario', '$estado', '$nombrePlan', '$montoDelPlan', '$fechaDescuento', '$roaming', '$descuento', '$extras', '$monto_total', '$obs', '$fechaActual')");
        }
    }
    mysqli_close($datos_base);	
    header('Location: ./montosLineas.php'); 
}





/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */
/* -----------------MONTOS/LINEAS: montosLineas.php----------------- */
/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */
if(isset($_POST['btnActualizarMontoMensual'])){
    //SELECCIONAR MES Y AÑO DE movilinea EN UNA VARIABLE
    $sqla = "SELECT YEAR(FECHA) AS AÑO, MONTH(FECHA) AS MES FROM `movilinea` ORDER BY FECHA DESC LIMIT 1;";
    $resultado = $datos_base->query($sqla);
    $row = $resultado->fetch_assoc();
    $añomovilinea = $row['AÑO'];
    $mesmovilinea = $row['MES'];

    //SELECCIONAR LOS DATOS DE movilinea DONDE CUMPLAN MES Y AÑO
    $resultados=mysqli_query($datos_base, "SELECT * FROM `movilinea` WHERE YEAR(FECHA) = $añomovilinea AND MONTH(FECHA) = $mesmovilinea AND ID_ESTADOWS = 1");
    // $resultados=mysqli_query($datos_base, "SELECT * FROM movilinea m WHERE m.ID_MOVILINEA = ( SELECT MAX(t.ID_MOVILINEA) FROM movilinea t WHERE m.id_linea = t.id_linea ) AND ID_ESTADOWS = 1");
    $num_rows= mysqli_num_rows($resultados);
    while($consulta = mysqli_fetch_array($resultados))
    {
        $idLinea=$consulta['ID_LINEA'];
        $idUsuario=$consulta['ID_USUARIO'];
        $idEstado=$consulta['ID_ESTADOWS'];
        $idNombrePlan=$consulta['ID_NOMBREPLAN'];
        $extras=$consulta['EXTRAS'];

        $sqla = "SELECT MONTO FROM nombreplan WHERE ID_NOMBREPLAN = $idNombrePlan;";
        $resultado = $datos_base->query($sqla);
        $row = $resultado->fetch_assoc();
        $montoNuevo = $row['MONTO'];

        $fechaDescuento=$consulta['FECHADESCUENTO'];
        $idRoaming=$consulta['ID_ROAMING'];
        $descuento=$consulta['DESCUENTO'];

        $montoTotal=$consulta['MONTOTOTAL'];
        $observacion=$consulta['OBSERVACION'];
        $fechaActual = date('Y-m-d');

        $iva = 21;
        $impInternos = 1.21;

        // $descuentoParaCuenta=($consulta['DESCUENTO'])*0.01;
        // $valor_descuento=$montoNuevo*$descuentoParaCuenta;
        // $monto_total=$montoNuevo-$valor_descuento;

        // $impuesto = ($monto_total * $iva) / 100;
        // $extras = $impuesto + $impInternos;
        // $monto_total = $monto_total + $extras;

        $descuentoParaCuenta= 1-($descuento * 0.01);
        $monto_iva=$montoNuevo*$impInternos;     
        $monto_total=$monto_iva*$descuentoParaCuenta;
        // $extras=$extras*$impInternos;
        $extras_iva=$extras*$impInternos;
        $monto_total = $monto_total + $extras;

        //HACER UN INSERT en movilinea
        mysqli_query($datos_base, "INSERT INTO movilinea VALUES (DEFAULT, '$idLinea', '$idUsuario', '$idEstado', '$idNombrePlan', '$montoNuevo', '$fechaDescuento', '$idRoaming', '$descuento', '$extras', '$monto_total', '$observacion', '$fechaActual')");

    }
    mysqli_close($datos_base);	
    header('Location: ./montosLineas.php'); 
}

?>