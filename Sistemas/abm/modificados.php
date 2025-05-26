<?php
session_start();
include('../particular/conexion.php');

/* -------------DATOS GENERALES------------- */
date_default_timezone_set('America/Argentina/Buenos_Aires'); // Configura la zona horaria de Argentina
$horaActual = date("H:i:s"); // Formato de hora: HH:mm:ss
$fechaActual = date('Y-m-d');

/*BUSCO EL RESOLUTOR PARA agregados*/
$cuil = $_SESSION['cuil'];

$sqli = "SELECT ID_RESOLUTOR FROM resolutor WHERE CUIL = '$cuil'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$resolutorActivo = $row2['ID_RESOLUTOR'];
/* ------------------------------- */


if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    switch ($accion) {
        /* --------------------MODIFICAR PLAN: modPlanes.php --------------------- */
        case 'btnModPlanes':
            $id = $_POST['id'] ?? null;
            $nombrePlan = $_POST['nombrePlan'] ?? '';
            $monto = $_POST['monto'] ?? '';
            $plan = $_POST['plan'] ?? 0;
            $proveedor = $_POST['proveedor'] ?? 0;
        
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
            $sqli = "SELECT COUNT(*) AS cantidad FROM nombreplan WHERE NOMBREPLAN = '$nombrePlan' AND ID_PLAN ='$plan' AND ID_PROVEEDOR = '$proveedor' AND ID_NOMBREPLAN != '$id'";
            $result = $datos_base->query($sqli);
            $rowa = $result->fetch_assoc();
            $cantidad = $rowa['cantidad'];
            
            if($cantidad > 0){
                header("Location: ./abmPlanesCelulares.php?no");
                exit;
            }else{
                mysqli_query($datos_base, "UPDATE nombreplan SET NOMBREPLAN = '$nombrePlan', ID_PLAN ='$plan', ID_PROVEEDOR = '$proveedor', MONTO = '$monto' WHERE ID_NOMBREPLAN = '$id'");
                header("Location: ./abmPlanesCelulares.php?mod");
                exit;
            }
            break;
            
            /* ------------------MODIFICAR USUARIO: modusuario.php------------------------ */
        case 'modUsuario':
            $id = $_POST['id'] ?? null;
            $nombre = $_POST['nom'] ?? '';
            $cuil = $_POST['cuil'] ?? '';
            $int = $_POST['int'] ?? '';
            $cor = $_POST['cor'] ?? '';
            $corp = $_POST['corp'] ?? '';
            $tel = $_POST['tel'] ?? '';
            $obs = $_POST['obs'] ?? '';
            $are = $_POST['are'] ?? '';
            $pis = $_POST['piso'] ?? '';
            $act = $_POST['act'] ?? '';
            $tur = $_POST['tur'] ?? '';
            
            /*BOTON MODIFICAR*/
            if($pis == "300"){
            $sqlp = "SELECT PISO FROM usuarios WHERE ID_USUARIO = '$id'";
            $result = $datos_base->query($sqlp);
            $row = $result->fetch_assoc();
            $pis = $row['PISO'];
            }/* else{
            $pis = $_POST['piso'];
            } */
            if($act == "400"){
            $sqla = "SELECT ACTIVO FROM usuarios WHERE ID_USUARIO = '$id'";
            $result = $datos_base->query($sqla);
            $row = $result->fetch_assoc();
            $act = $row['ACTIVO'];
            }/* else{
            $act = $_POST['act'];
            } */
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
            
            
            /* 
            -OBTENER EL ESTADO ACTUAL, COMPARAR CON EL NUEVO ESTADO.
            -SI EL ESTADO ES IGUAL{
            -UPDATE EN TABLA USUARIOS
            }-SI EL NUEVO ESTADO ES ACTIVO{
                HACER UPDATE EN TABLA usuarios
                HACER UN INSERT EN LA TABLA WSUSUARIO PARA EL USUARIO SOLAMENTE, MOSTRANDOLO ACTIVO
            }-SI EL NUEVO ESTADO ES INACTIVO{
                -HACER UNA CONSULTA DE EQUIPO ASIGNADO
                -SI EL USUARIO TIENE UN EQUIPO ASIGNADO{
                -HACER UNA CONSULTA SI ESA MAQUINA TIENE PERIFERICOS ASIGNADOS (TABLA EQUIPO_PERIFERICO)
                -PREGUNTAR SI ESTA SEGURO QUE DESEA DESACTIVAR EL USUARIO, QUE LA MAQUINA ASIGNADA SE PONDRA EN STOCK Y SUS PERIFERICOS TAMBIEN
            
                -HACER UN UPDATE EN TABLA INVENTARIO PARA CAMBIAR EL ESTADO DEL EQUIPO A S/A - STOCK
                -HACER UN INSERT EN LA TABLA WSUSUARIO PARA MOVER EL USUARIO A DESVINCULACION
                -HACER UN INSERT EN LA TABLA WSUSUARIO PARA MOVER EL EQUIPO A DESVINCULACION
            
                -HACER UN UPDATE EN TABLA PERIFERICO PARA CAMBIAR EL ESTADO DEL PERIFERICO A S/A - STOCK
                -HACER UN INSERT EN LA TABLA EQUIPO_PERIFERICO PARA MOVER EL EQUIPO A DESVINCULACION
                -HACER UN INSERT EN LA TABLA EQUIPO_PERIFERICO PARA MOVER EL PERIFERICO A DESVINCULACION
                }ELSE{
                HACER UN UPDATE EN LA TABLA usuarios
                HACER UN INSERT EN LA TABLA WSUSUARIO PARA EL USUARIO SOLAMENTE PARA REGISTRARLO (SIN EQUIPO)
                }
            }
            */
            
            
            /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
            $sql = "SELECT * FROM usuarios WHERE (CUIL ='$cuil' AND ID_USUARIO != '$id')";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $cui = $row['CUIL'];
            
            if($cuil == $cui)
            {
                header("Location: abmusuario.php?no");
                exit;
            }
            else
            {
                mysqli_query($datos_base, "UPDATE usuarios SET NOMBRE = '$nombre', CUIL = '$cuil', ID_AREA = '$are', PISO = '$pis', INTERNO = '$int', CORREO = '$cor', CORREO_PERSONAL = '$corp', TELEFONO_PERSONAL = '$tel', ID_TURNO = '$tur', ACTIVO = '$act', OBSERVACION = '$obs' WHERE ID_USUARIO = '$id'");
                header("Location: abmusuario.php?ok");
                exit;
            }
            break;

        /* ------------------ MODIFICAR ÁREA: modarea.php------------------------ */
        case 'modArea':
            $id = $_POST['id'] ?? null;
            $area = $_POST['area'] ?? '';
            $obs = $_POST['obs'] ?? '';
            $est = $_POST['estado'] ?? 0;
            $repa = $_POST['repa'] ?? 0;
            
            /*TRAIGO VALORES DE LOS CMB*/
            if($repa == "100"){
                $sql = "SELECT ID_REPA FROM area WHERE ID_AREA = '$id'";
                $result = $datos_base->query($sql);
                $row = $result->fetch_assoc();
                $repa = $row['ID_REPA'];
            }
            
            /*TRAIGO VALORES DE LOS CMB*/
            if($est == "200"){
                $sql = "SELECT ACTIVO FROM area WHERE ID_AREA = '$id'";
                $result = $datos_base->query($sql);
                $row = $result->fetch_assoc();
                $est = $ro4['ACTIVO'];
            }
        
            /* SI EL ÁREA PASA A INACTIVA, HACER QUE TODOS LOS USUARIOS DE DICHA ÁREA PASEN A SIN ASIGNAR*/
            
            /* SI EL ÁREA CAMBIA DE NOMBRE, INFORMAR QUE LOS USUARIOS ASIGNADOS AL ÁREA ANTERIOR AHORA FORMARAN PARTE DE LA NUEVA ÁREA RENOMBRADA */
        
            /*SI AMBOS CAMPOS ESTAN REPETIDOS*/
            $sqli = "SELECT * FROM area WHERE AREA = '$area' AND ID_REPA ='$repa' AND ID_AREA != '$id'";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $are = $row2['AREA'];
            $rep = $row2['ID_REPA'];
            $estadoBD = $row2['ACTIVO'];
            
            if($area == $are AND $repa == $rep){ 
                header("Location: abmarea.php?no");
            }
            else{
                if($estadoBD <> $est){
                    mysqli_query($datos_base, "UPDATE area SET AREA = '$area', ID_REPA = '$repa', ACTIVO = '$est', OBSERVACION = '$obs' WHERE ID_AREA = '$id'");
                    header("Location: abmarea.php?ok");
                    exit;
                }else{
                    mysqli_query($datos_base, "UPDATE area SET AREA = '$area', ID_REPA = '$repa', OBSERVACION = '$obs' WHERE ID_AREA = '$id'");
                    header("Location: abmarea.php?ok");
                    exit;
                }
            }
            break;

        /* ------------------ MODIFICAR TIPIFICACION: modtipificacion.php------------------------ */
        case 'modTipificacion':
            $id = $_POST['id'] ?? 0;
            $tipi = $_POST['tip'] ?? '';
            $tip = preg_replace("/[[:space:]]/","",($tipi));
            
            /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
            $contador = 0;
            
            $consulta=mysqli_query($datos_base, "SELECT REPLACE(TIPIFICACION, ' ', '') AS TIPIFICACION FROM tipificacion");
            while($listar = mysqli_fetch_array($consulta)) 
            {
                if($listar['TIPIFICACION'] == $tip){
                $contador ++;
                }
            }
            
            if($contador > 0){
                header("Location: abmtipificacion.php?no");
                exit;
            }
            else{
                mysqli_query($datos_base, "UPDATE tipificacion SET TIPIFICACION = '$tipi' WHERE ID_TIPIFICACION = '$id'"); 
                header("Location: abmtipificacion.php?ok");
                exit;
            }
            break;

        /* ------------------ MODIFICAR RESOLUTOR: modresolutor.php ------------------------ */
        case 'modResolutor':
            $id = $_POST['id'] ?? 0;
            $nom = $_POST['nom'] ?? '';
            $cuil = $_POST['cuil'] ?? '';
            $cor = $_POST['cor'] ?? '';
            $tel = $_POST['tel'] ?? '';
            $tipo = $_POST['tipo'] ?? 0;
            $perfil = $_POST['perfil'] ?? 0;
            
            if($tipo == "100"){
                $sql = "SELECT ID_TIPO_RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = '$id'";
                $result = $datos_base->query($sql);
                $row = $result->fetch_assoc();
                $tipo = $row['ID_TIPO_RESOLUTOR'];
            }
            
            if($perfil == "101"){
                $sql = "SELECT ID_PERFIL FROM resolutor WHERE ID_RESOLUTOR = '$id'";
                $result = $datos_base->query($sql);
                $row = $result->fetch_assoc();
                $perfil = $row['ID_PERFIL'];
            }
            
            /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
            $sql = "SELECT RESOLUTOR, CUIL FROM resolutor WHERE RESOLUTOR = '$resolutor' OR CUIL='$cuil' AND ID_RESOLUTOR != '$id'";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $res = $row['RESOLUTOR'];
            $cui = $row['CUIL'];
            
            if($cuil == $cui){
                header("Location: abmresolutor.php?no");
                exit;
                }
            else{
                mysqli_query($datos_base, "UPDATE resolutor SET RESOLUTOR = '$nom', ID_TIPO_RESOLUTOR = '$tipo', CUIL = '$cuil', CORREO = '$cor', TELEFONO = '$tel', ID_PERFIL = '$perfil' WHERE ID_RESOLUTOR = '$id'");
                header("Location: abmresolutor.php?ok");
                exit;
            }
            break;

        /* ------------------ MODIFICAR MARCA: modmarca.php------------------------ */
        case 'modMarca':
            $id = $_POST['id'] ?? 0;
            $marca = $_POST['marca'] ?? '';
            
            /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
            $sql = "SELECT * FROM marcas WHERE MARCA = '$marca' AND ID_MARCA != '$id'";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $ma = $row['MARCA'];
                
            
            if($marca == $ma){
                header("Location: abmmarcas.php?no");
                exit;
            }
            else{
                mysqli_query($datos_base, "UPDATE marcas SET MARCA = '$marca' WHERE ID_MARCA = '$id'"); 
                header("Location: abmmarcas.php?ok");
                exit;
            }
            break;

        /* ------------------ MODIFICAR MICRO: modmicro.php------------------------ */
        case 'modMicro':
            $id = $_POST['id'] ?? 0;
            $micro = $_POST['micro'] ?? '';
            $marca = $_POST['marca'] ?? 0;
            
            if($marca == "100"){
                $sql3 = "SELECT ID_MARCA FROM micro WHERE ID_MICRO = '$id'";
                $result3 = $datos_base->query($sql3);
                $row3 = $result3->fetch_assoc();
                
                $marca = $row3['ID_MARCA'];
            }
            /*TRAIGO VALORES DE LOS CMB*/
            
            /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
            $sql = "SELECT * FROM micro WHERE MICRO = '$micro' AND ID_MICRO != '$id'";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $mi = $row['MICRO'];
            
            $sqli = "SELECT * FROM micro WHERE MICRO = '$micro' AND ID_MARCA ='$marca' AND ID_MICRO != '$id'";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $mic = $row2['MICRO'];
            $mar = $row2['ID_MARCA'];
            /*SI AMBOS CAMPOS ESTAN REPETIDOS*/
            
            /*CONTROL FINAL*/
            if($micro == $mic AND $marca == $mar){ 
                header("Location: abmmicro.php?no");
            }
            elseif($micro == $mi){
                mysqli_query($datos_base, "UPDATE micro SET MICRO = '$micro', ID_MARCA = '$marca' WHERE ID_MICRO = '$id'"); 
                header("Location: abmmicro.php?repeat");
                exit;
            }
            else{
                mysqli_query($datos_base, "UPDATE micro SET MICRO = '$micro', ID_MARCA = '$marca' WHERE ID_MICRO = '$id'"); 
                header("Location: abmmicro.php?ok");
                exit;
            }
            break;

        /* ------------------ MODIFICAR MODELO: modmodelo.php------------------------ */
        case 'modModelo':
            $id = $_POST['id'] ?? 0;
            $modelo = $_POST['modelo'] ?? '';
            $marca = $_POST['marca'] ?? 0;
            $tipo = $_POST['tipo'] ?? 0;
            
            /*TRAIGO VALORES DE LOS CMB*/
            if($tipo == "200"){
                $sql4 = "SELECT ID_TIPOP FROM modelo WHERE ID_MODELO = '$id'";
                $result4 = $datos_base->query($sql4);
                $row4 = $result4->fetch_assoc();
                
                $tipo = $row4['ID_TIPOP'];
            }
            
            if($marca == "100"){
                $sql3 = "SELECT ID_MARCA FROM modelo WHERE ID_MODELO = '$id'";
                $result3 = $datos_base->query($sql3);
                $row3 = $result3->fetch_assoc();
                
                $marca = $row3['ID_MARCA'];
            }
            /*TRAIGO VALORES DE LOS CMB*/
            
            /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
            $sql = "SELECT * FROM modelo WHERE MODELO = '$modelo' AND ID_MODELO != '$id'";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $mo = $row['MODELO'];
            
            $sqli = "SELECT * FROM modelo WHERE MODELO = '$modelo' AND ID_MARCA ='$marca' AND ID_MODELO != '$id'";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $mod = $row2['MODELO'];
            $mar = $row2['ID_MARCA'];
            /*SI AMBOS CAMPOS ESTAN REPETIDOS*/
            
            /*CONTROL FINAL*/
            if($modelo == $mod AND $marca == $mar){ 
                header("Location: abmmodelos.php?no");
                exit;
            }
            elseif($modelo == $mo){
                mysqli_query($datos_base, "UPDATE modelo SET MODELO = '$modelo', ID_TIPOP = '$tipo', ID_MARCA = '$marca' WHERE ID_MODELO = '$id'"); 
                header("Location: abmmodelos.php?repeat");
                exit;
            }
            else{
                mysqli_query($datos_base, "UPDATE modelo SET MODELO ='$modelo', ID_TIPOP = '$tipo', ID_MARCA = '$marca' WHERE ID_MODELO = '$id'"); 
                header("Location: abmmodelos.php?ok");
                exit;
            }
            break;

        /* ------------------ MODIFICAR PLACA DE VIDEO: modplacav.php------------------------ */
        case 'modPlacav':
            $id = $_POST['id'] ?? 0;
            $memoria = $_POST['memoria'] ?? 0;
            $modelo = $_POST['modelo'] ?? 0;
            $tipo = $_POST['tipo'] ?? 0;
            
            /*TRAIGO VALORES DE LOS CMB*/
            if($memoria == "100"){
                $sql3 = "SELECT ID_MEMORIA FROM pvideo WHERE ID_PVIDEO = '$id'";
                $result3 = $datos_base->query($sql3);
                $row3 = $result3->fetch_assoc();
                $memoria = $row3['ID_MEMORIA'];
            }
            
            if($modelo == "200"){
                $sql3 = "SELECT ID_MODELO FROM pvideo WHERE ID_PVIDEO = '$id'";
                $result3 = $datos_base->query($sql3);
                $row3 = $result3->fetch_assoc();
                $modelo = $row3['ID_MODELO'];
            }
            
            if($tipo == "300"){
                $sql3 = "SELECT ID_TIPOMEM FROM pvideo WHERE ID_PVIDEO = '$id'";
                $result3 = $datos_base->query($sql3);
                $row3 = $result3->fetch_assoc();
                $tipo = $row3['ID_TIPOMEM'];
            }
            
            /*SI LOS CAMPOS ESTAN REPETIDOS*/
            $sqli = "SELECT ID_PVIDEO FROM pvideo WHERE ID_MEMORIA = '$memoria' AND ID_MODELO ='$modelo' AND ID_TIPOMEM = '$tipo' AND ID_PVIDEO != '$id'";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $placavreg = $row2['ID_PVIDEO'];
            
            if(isset($placavreg)){
                header("Location: abmplacav.php?no");
                exit;
            }else{
                mysqli_query($datos_base, "UPDATE pvideo SET ID_MEMORIA = '$memoria', ID_MODELO ='$modelo', ID_TIPOMEM = '$tipo' WHERE ID_PVIDEO = '$id'");
                header("Location: abmplacav.php?mod");
                exit;
            }
            break;

        /* ------------------ MODIFICAR PLACA MADRE: modPLacam.php------------------------ */
        case 'modPLacam':
            $id = $_POST['id'] ?? 0;
            $placam = $_POST['placam'] ?? '';
            $marca = $_POST['marca'] ?? 0;
            
            /*TRAIGO VALORES DE LOS CMB*/
            if($marca == "100"){
                $sql3 = "SELECT ID_MARCA FROM placam WHERE ID_PLACAM = '$id'";
                $result3 = $datos_base->query($sql3);
                $row3 = $result3->fetch_assoc();
                
                $marca = $row3['ID_MARCA'];
            }
            /*TRAIGO VALORES DE LOS CMB*/
            
            /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
            $sql = "SELECT * FROM placam WHERE PLACAM = '$placam' AND ID_PLACAM != '$id'";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $pm = $row['PLACAM'];
            
            $sqli = "SELECT * FROM placam WHERE PLACAM = '$placam' AND ID_MARCA ='$marca' AND ID_PLACAM != '$id'";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $pcm = $row2['PLACAM'];
            $mar = $row2['ID_MARCA'];
            /*SI AMBOS CAMPOS ESTAN REPETIDOS*/
            
            /*CONTROL FINAL*/
            if($placam == $pcm AND $marca == $mar){ 
                header("Location: abmplacamadre.php?no");
            }
            elseif($placam == $pm){
                mysqli_query($datos_base, "UPDATE placam SET PLACAM = '$placam', ID_MARCA = '$marca' WHERE ID_PLACAM = '$id'"); 
                header("Location: abmplacamadre.php?repeat");
                exit;
            }
            else{
                mysqli_query($datos_base, "UPDATE placam SET PLACAM = '$placam', ID_MARCA = '$marca' WHERE ID_PLACAM = '$id'");  
                header("Location: abmplacamadre.php?ok");
                exit;
            }
            break;

        /* ----------------- MODIFICAR IMPRESORA: modimpresora.php----------------- */
        case 'modImpresora':
            $serieg = $_POST['serieg'] ?? '';
            $serie = $_POST['serie'] ?? '';
            $mac = $_POST['mac'] ?? '';
            $obs = $_POST['obs'] ?? '';
            $ip = $_POST['ip'] ?? '';
            $factura = $_POST['factura'] ?? '';
            $garantia = $_POST['garantia'] ?? '';
            
            $id = $_POST['id'] ?? 0;
            $rip = $_POST['rip'] ?? 0;
            $modelo = $_POST['modelo'] ?? 0;
            $estado = $_POST['estado'] ?? 0;
            $prov = $_POST['prov'] ?? 0;
            $tipop = $_POST['tipop'] ?? 0;
            $equipo = $_POST['equip'] ?? 0;
            $proc = $_POST['proc'] ?? 0;
    
            
            if($rip == "100"){
                $sql = "SELECT RIP FROM periferico WHERE ID_PERI = '$id'";
                $result = $datos_base->query($sql);
                $row = $result->fetch_assoc();
                $rip = $row['RIP'];
            }
            
            if($modelo == "200"){
                $sql1 = "SELECT ID_MODELO FROM periferico WHERE ID_PERI = '$id'";
                $result1 = $datos_base->query($sql1);
                $row1 = $result1->fetch_assoc();
                $modelo = $row1['ID_MODELO'];
            }
            
            if($estado == "300"){
                $sql2 = "SELECT ID_ESTADOWS FROM periferico WHERE ID_PERI = '$id'";
                $result2 = $datos_base->query($sql2);
                $row2 = $result2->fetch_assoc();
                $estado = $row2['ID_ESTADOWS'];
            }
            
            if($prov == "400"){
                $sql3 = "SELECT ID_PROVEEDOR FROM periferico WHERE ID_PERI = '$id'";
                $result3 = $datos_base->query($sql3);
                $row3 = $result3->fetch_assoc();
                $prov = $row3['ID_PROVEEDOR'];
            }
            
            if($tipop == "500"){
                $sql4 = "SELECT ID_TIPOP FROM periferico WHERE ID_PERI = '$id'";
                $result4 = $datos_base->query($sql4);
                $row4 = $result4->fetch_assoc();
                $tipop = $row4['ID_TIPOP'];
            }
            
            $sqli = "SELECT * FROM periferico WHERE SERIE ='$serie' AND ID_PERI != '$id' ";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $ser = $row2['SERIE'];
            
            if($serie == $ser){ 
                header("Location: ../consulta/impresoras.php?noMod");
                exit;
            }
            else{
                /* TRAIGO LOS DATOS ACTUALES DEL PERIFERICO */
                $sql4 = "SELECT ID_WS, ID_ESTADOWS
                FROM equipo_periferico 
                WHERE ID_PERI = '$id' 
                ORDER BY ID_EQUIPO_PERIFERICO DESC 
                LIMIT 1";
                $result4 = $datos_base->query($sql4);
                $row4 = $result4->fetch_assoc();
                $equipoBD = $row4['ID_WS'];
                $estadoBD = $row4['ID_ESTADOWS'];

                if($estado == 1 AND $estadoBD == $estado){/* BASE DE DATOS Y FORMULARIO: ACTIVO */
                    if($equipoBD != $equipo){/*  SI CAMBIA DE EQUIPO */
                        /* -INSERT DE DESVINCULACION DEL EQUIPO ACTUAL(tabla equipo_periferico) */
                        mysqli_query($datos_base, "INSERT INTO equipo_periferico VALUES (DEFAULT, '$equipoBD', 0, '0000-00-00', '$fechaActual', '$estado')");
                        /* -INSERT DE DESVINCULACION DEL PERIFERICO (tabla equipo_periferico) */
                        mysqli_query($datos_base, "INSERT INTO equipo_periferico VALUES (DEFAULT, 0, '$id', '0000-00-00', '$fechaActual', '$estado')");
                        /* -INSERT DE VINCULACION DEL NUEVO EQUIPO CON ESTE PERIFERICO (tabla equipo_periferico) */
                        mysqli_query($datos_base, "INSERT INTO equipo_periferico VALUES (DEFAULT, '$equipo', '$id', '$fechaActual', '0000-00-00', '$estado')");
                        
                        
                        /* -UPDATE DE LOS DATOS DEL FORM (tabla periferico) */
                        mysqli_query($datos_base, "UPDATE periferico SET ID_TIPOP = '$tipop', SERIEG = '$serieg', SERIE = '$serie', ID_PROCEDENCIA = '$proc', OBSERVACION = '$obs', MAC = '$mac', RIP = '$rip', IP = '$ip', ID_PROVEEDOR = '$prov', FACTURA = '$factura', GARANTIA = '$garantia', ID_MODELO = '$modelo' WHERE ID_PERI = '$id'");

                        /* -INSERT DEL NUEVO EQUIPO Y ESPECIFICAR IMPRESORA (tabla agregados) */
                        $descripcion = $serg . " - " . $equipoBD;
                        mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'IMPRESORA', 'MODIFICADO', '$equipo', '$descripcion', '$fechaActual', '$horaActual', '$resolutorActivo')");
                    }else{/* SI SIGUE CON EL MISMO EQUIPO */
                        /* -UPDATE DE LOS DEMAS DATOS (tabla perifericos) */
                        mysqli_query($datos_base, "UPDATE periferico SET ID_TIPOP = '$tipop', SERIEG = '$serieg',  SERIE = '$serie', ID_PROCEDENCIA = '$proc', OBSERVACION = '$obs', MAC = '$mac', RIP = '$rip', IP = '$ip', ID_PROVEEDOR = '$prov', FACTURA = '$factura', GARANTIA = '$garantia', ID_MODELO = '$modelo' WHERE ID_PERI = '$id'");
                    }
                
                } elseif ($estadoBD == 1 AND $estado != $estadoBD){ /* BASE DE DATO: ACTIVO || FORMULARIO: BAJA O STOCK */
                    /* -INSERT DE DESVINCULACION DEL EQUIPO (tabla equipo_periferico) */
                    mysqli_query($datos_base, "INSERT INTO equipo_periferico VALUES (DEFAULT, '$equipo', 0, '0000-00-00', '$fechaActual', '$estado')");
                    /* -INSERT DE DESVINCULACION DEL PERIFERICO (tabla equipo_periferico) */
                    mysqli_query($datos_base, "INSERT INTO equipo_periferico VALUES (DEFAULT, 0, '$id', '0000-00-00', '$fechaActual', '$estado')");

                    /* -UPDATE PARA DAR DE BAJA AL PERIFERICO Y DEMAS DATOS (tabla periferico) */
                    mysqli_query($datos_base, "UPDATE periferico SET ID_TIPOP = '$tipop', SERIEG = '$serieg',  SERIE = '$serie', ID_PROCEDENCIA = '$proc', OBSERVACION = '$obs', MAC = '$mac', RIP = '$rip', IP = '$ip', ID_PROVEEDOR = '$prov', FACTURA = '$factura', GARANTIA = '$garantia', ID_ESTADOWS = '$estado', ID_MODELO = '$modelo' WHERE ID_PERI = '$id'");

                    /* -INSERT DEL NUEVO ESTADO Y ESPECIFICAR IMPRESORA (tabla agregados) */
                    $descripcion = $serg . " - " . $estado;
                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'IMPRESORA', 'MODIFICADO', '$estadoBD', '$descripcion', '$fechaActual', '$horaActual', '$resolutorActivo')");
                } elseif ($estadoBD != 1 AND $estado == 1) {/*  BASE DE DATOS: BAJA O STOCK || FORMULARIO: ACTIVO */
                    /* -INSERT DE VINCULACION DEL PERIFERICO Y EQUIPO (tabla equipo_periferico) */
                    mysqli_query($datos_base, "INSERT INTO equipo_periferico VALUES (DEFAULT, '$equipo', '$id', '$fechaActual', '0000-00-00', '$estado')");

                    /* -UPDATE DE LOS DATOS DEL FORM (tabla periferico) */
                    mysqli_query($datos_base, "UPDATE periferico SET ID_TIPOP = '$tipop', SERIEG = '$serieg', SERIE = '$serie', ID_PROCEDENCIA = '$proc', OBSERVACION = '$obs', MAC = '$mac', RIP = '$rip', IP = '$ip', ID_PROVEEDOR = '$prov', FACTURA = '$factura', GARANTIA = '$garantia',  ID_ESTADOWS = '$estado', ID_MODELO = '$modelo' WHERE ID_PERI = '$id'");

                    /* -INSERT DEL NUEVO ESTADO Y ESPECIFICAR IMPRESORA (tabla agregados) */
                    $descripcion = $serg . " - " . $estado;
                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'IMPRESORA', 'MODIFICADO', '$estadoBD', '$descripcion', '$fechaActual', '$horaActual', '$resolutorActivo')");
                }
                header("Location: ../consulta/impresoras.php?okMod");
                exit;
            }
            break;

        /* ----------------- MODIFICAR MONITORES: modmonitores.php----------------- */
        case 'modMonitores':
            $id = $_POST['id'] ?? 0;
            $tipop = $_POST['tipop'] ?? 0;
            $equip = $_POST['equip'] ?? 0;
            $modelo = $_POST['modelo'] ?? 0;
            $estado = $_POST['estado'] ?? 0;
            $prov = $_POST['prov'] ?? 0;
            
            $serieg = $_POST['serieg'] ?? '';
            $gar = $_POST['garantia'] ?? '';
            $fac = $_POST['fac'] ?? '';
            $obs = $_POST['obs'] ?? '';
            
            $sqli = "SELECT ID_MARCA FROM modelo
            WHERE ID_MODELO = '$modelo'";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $marca = $row2['ID_MARCA'];
            
            if($modelo == "200"){
                $sql1 = "SELECT ID_MODELO FROM periferico WHERE ID_PERI = '$id'";
                $result1 = $datos_base->query($sql1);
                $row1 = $result1->fetch_assoc();
                $modelo = $row1['ID_MODELO'];
            }
            
            if($estado == "300"){
                $sql2 = "SELECT ID_ESTADOWS FROM periferico WHERE ID_PERI = '$id'";
                $result2 = $datos_base->query($sql2);
                $row2 = $result2->fetch_assoc();
                $estado = $row2['ID_ESTADOWS'];
            }
            
            if($prov == "400"){
                $sql3 = "SELECT ID_PROVEEDOR FROM periferico WHERE ID_PERI = '$id'";
                $result3 = $datos_base->query($sql3);
                $row3 = $result3->fetch_assoc();
                $prov = $row3['ID_PROVEEDOR'];
            }
            
            if($tipop == "500"){
                $sql4 = "SELECT ID_TIPOP FROM periferico WHERE ID_PERI = '$id'";
                $result4 = $datos_base->query($sql4);
                $row4 = $result4->fetch_assoc();
                $tipop = $row4['ID_TIPOP'];
            }
            
            if($usu == "600"){
                $sql5 = "SELECT ID_USUARIO FROM periferico WHERE ID_PERI = '$id'";
                $result5 = $datos_base->query($sql5);
                $row5 = $result5->fetch_assoc();
                $usu = $row5['ID_USUARIO'];/* ACA NO ES MAS USUARIO, ES QUIPO AL QUE ESTA ASIGNADO */
            }
            
            $sqli = "SELECT * FROM periferico WHERE SERIE ='$serie' AND ID_PERI != '$id' AND (ID_TIPOP = 7 OR ID_TIPOP = 8)";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $ser = $row2['SERIE'];
            
            $sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $area = $row2['ID_AREA'];
            
            
            if(/* $serieg == $serg OR */ $serie == $ser){ 
                header("Location: abmmonitores.php?no");
                exit;
            }
            else{
                /* MOVIMIENTOS DEL PERIFERICO */
                $sqli = "SELECT ID_AREA, ID_USUARIO, ID_ESTADOWS FROM periferico WHERE ID_PERI = '$id'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $a = $row2['ID_AREA'];
                $u = $row2['ID_USUARIO'];
                $e = $row2['ID_ESTADOWS'];
                if($a != $area || $u != $usu || $e != $estado){
                mysqli_query($datos_base, "INSERT INTO movimientosperi VALUES (DEFAULT, '$fechaActual', '$id', '$area', '$usu', '$estado')");/* DEBERIA VOLVER A CONSULTAR BIEN EL USUARIO QUE ESTA RELACIONADO AL EQUIPO */
                }
            
            
                mysqli_query($datos_base, "UPDATE periferico SET ID_TIPOP = '$tipop', SERIEG = '$serieg', ID_MARCA = '$marca', SERIE = '$serie', OBSERVACION = '$obs', FACTURA = '$fac', ID_AREA = '$area', ID_USUARIO = '$usu', GARANTIA = '$garantia', ID_ESTADOWS = '$estado', ID_PROVEEDOR = '$prov', ID_MODELO = '$modelo' WHERE ID_PERI = '$id'");
            /* EL UPDATE NO VA A FUNCIONAR PORQUE $usu NO LO TRAIGO MAS, TRAIGO EL EQUIPO */
                header("Location: abmmonitores.php?ok");
                exit;
            }
            break;

        /* ----------------- MODIFICAR OTROS PERIFERICOS: modotros.php----------------- */
        case 'modOtros':
            $id = $_POST['id'] ?? 0;
            $modelo = $_POST['modelo'] ?? 0;
            $marca = $_POST['mar'] ?? 0;
            $equip = $_POST['equip'] ?? 0;
            $estado = $_POST['estado'] ?? 0;
            $prov = $_POST['prov'] ?? 0;
            $tipop = $_POST['tipop'] ?? 0;
            
            $serieg = $_POST['serieg'] ?? '';
            $serie = $_POST['serie'] ?? '';
            $gar = $_POST['garantia'] ?? '';
            $fac = $_POST['fac'] ?? '';
            $obs = $_POST['obs'] ?? '';

            if($marca == "100"){
                $sql6 = "SELECT ID_MARCA FROM periferico WHERE ID_PERI = '$id'";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $marca = $row6['ID_MARCA'];
            }
            
            if($modelo == "200"){
                $sql1 = "SELECT ID_MODELO FROM periferico WHERE ID_PERI = '$id'";
                $result1 = $datos_base->query($sql1);
                $row1 = $result1->fetch_assoc();
                $modelo = $row1['ID_MODELO'];
            }
            
            if($estado == "300"){
                $sql2 = "SELECT ID_ESTADOWS FROM periferico WHERE ID_PERI = '$id'";
                $result2 = $datos_base->query($sql2);
                $row2 = $result2->fetch_assoc();
                $estado = $row2['ID_ESTADOWS'];
            }
            
            if($prov == "400"){
                $sql3 = "SELECT ID_PROVEEDOR FROM periferico WHERE ID_PERI = '$id'";
                $result3 = $datos_base->query($sql3);
                $row3 = $result3->fetch_assoc();
                $prov = $row3['ID_PROVEEDOR'];
            }
            
            if($tipop == "500"){
                $sql4 = "SELECT ID_TIPOP FROM periferico WHERE ID_PERI = '$id'";
                $result4 = $datos_base->query($sql4);
                $row4 = $result4->fetch_assoc();
                $tipop = $row4['ID_TIPOP'];
            }
            
            if($usu == "600"){
                $sql5 = "SELECT ID_USUARIO FROM periferico WHERE ID_PERI = '$id'";
                $result5 = $datos_base->query($sql5);
                $row5 = $result5->fetch_assoc();
                $usu = $row5['ID_USUARIO'];/* HAY QUE TRAER EL USUARIO POR TABLA INTERMEDIA */
            }
            
            $sqli = "SELECT * FROM periferico WHERE SERIE ='$serie' AND ID_PERI != '$id' AND (ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12)";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $ser = $row2['SERIE'];
            
            $sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $area = $row2['ID_AREA'];
            
            
            if(/* $serieg == $serg OR */ $serie == $ser){ 
                header("Location: abmotros.php?no");
                exit;
            }
            else{
                /* MOVIMIENTOS DEL PERIFERICO */
                $sqli = "SELECT ID_AREA, ID_USUARIO, ID_ESTADOWS FROM periferico WHERE ID_PERI = '$id'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $a = $row2['ID_AREA'];
                $u = $row2['ID_USUARIO'];
                $e = $row2['ID_ESTADOWS'];
                if($a != $area || $u != $usu || $e != $estado){
                mysqli_query($datos_base, "INSERT INTO movimientosperi VALUES (DEFAULT, '$fechaActual', '$id', '$area', '$usu', '$estado')");/* NO VA A FUNCIONAR PORQUE FALTA LOGICA RELACIONADA AL EQUIPO , USAURIO NO ESTA EN LA TABLA */
                }
            
            
                mysqli_query($datos_base, "UPDATE periferico SET ID_TIPOP = '$tipop', SERIEG = '$serieg', ID_MARCA = '$marca', SERIE = '$serie', OBSERVACION = '$obs', FACTURA = '$factura', ID_AREA = '$area', ID_USUARIO = '$usu', GARANTIA = '$garantia', ID_ESTADOWS = '$estado', ID_MODELO = '$modelo' WHERE ID_PERI = '$id'");
            /* HAY QUE CONSULTAR AL USUARIO NUEVAMENTE POR TABLA INTERMEDIA */
                header("Location: abmotros.php?ok");
                exit;
            }
            break;

        /* ----------------- MODIFICAR EQUIPO: modequipo.php----------------- */
        case 'modEquipo':
            $id = $_POST['id'];
            $usu = $_POST['usu'];
            $marca = $_POST['marca'];
            $serieg = $_POST['serieg'];
            $serialn = $_POST['serialn'];
            $tippc = $_POST['tippc'];
            $est = $_POST['est'];
            $so = $_POST['so'];
            $masterizacion = $_POST['masterizacion'];
            $red = $_POST['red'];
            $mac = $_POST['mac'];
            $reserva = $_POST['reserva'];
            $ip = $_POST['ip'];
            $prov = $_POST['prov'];
            $fac = $_POST['fac'];
            $gar = $_POST['gar'];
            $obs = $_POST['obs'];
            $procedencia = $_POST['procedencia'];
            
            
            $mem1 = $_POST['mem1'];
            $tmem1 = $_POST['tmem1'];
            $prov1 = $_POST['prov1'];
            $marc1 = $_POST['marc1'];
            $fact1 = $_POST['fact1'];
            $fec1 = $_POST['fec1'];
            $gar1 = $_POST['gar1'];
            $pvel1 = $_POST['pvel1'];
            
            $mem2 = $_POST['mem2'];
            $tmem2 = $_POST['tmem2'];
            $prov2 = $_POST['prov2'];
            $marc2 = $_POST['marc2'];
            $fact2 = $_POST['fact2'];
            $fec2 = $_POST['fec2'];
            $gar2 = $_POST['gar2'];
            $pvel2 = $_POST['pvel2'];
            
            $mem3 = $_POST['mem3'];
            $tmem3 = $_POST['tmem3'];
            $prov3 = $_POST['prov3'];
            $marc3 = $_POST['marc3'];
            $fact3 = $_POST['fact3'];
            $fec3 = $_POST['fec3'];
            $gar3 = $_POST['gar3'];
            $pvel3 = $_POST['pvel3'];
            
            $mem4 = $_POST['mem4'];
            $tmem4 = $_POST['tmem4'];
            $prov4 = $_POST['prov4'];
            $marc4 = $_POST['marc4'];
            $fact4 = $_POST['fact4'];
            $fec4 = $_POST['fec4'];
            $gar4 = $_POST['gar4'];
            $pvel4 = $_POST['pvel4'];
            
            
            
            $disc1 = $_POST['disc1'];
            $tdisc1 = $_POST['tdisc1'];
            $dprov1 = $_POST['dprov1'];
            $dmod1 = $_POST['dmod1'];
            $dfact1 = $_POST['dfact1'];
            $dfec1 = $_POST['dfec1'];
            $dgar1 = $_POST['dgar1'];
            
            $disc2 = $_POST['disc2'];
            $tdisc2 = $_POST['tdisc2'];
            $dprov2 = $_POST['dprov2'];
            $dmod2 = $_POST['dmod2'];
            $dfact2 = $_POST['dfact2'];
            $dfec2 = $_POST['dfec2'];
            $dgar2 = $_POST['dgar2'];
            
            $disc3 = $_POST['disc3'];
            $tdisc3 = $_POST['tdisc3'];
            $dprov3 = $_POST['dprov3'];
            $dmod3 = $_POST['dmod3'];
            $dfact3 = $_POST['dfact3'];
            $dfec3 = $_POST['dfec3'];
            $dgar3 = $_POST['dgar3'];
            
            $disc4 = $_POST['disc4'];
            $tdisc4 = $_POST['tdisc4'];
            $dprov4 = $_POST['dprov4'];
            $dmod4 = $_POST['dmod4'];
            $dfact4 = $_POST['dfact4'];
            $dfec4 = $_POST['dfec4'];
            $dgar4 = $_POST['dgar4'];
            
            
            
            
            /* ////////////////////////// */
            $placam = $_POST['placam'];
            $placamprov = $_POST['placamprov'];
            $placamfact = $_POST['placamfact'];
            $placamfecha = $_POST['placamfecha'];
            $placamgar = $_POST['placamgar'];
            $planro = $_POST['planro'];
            
            $micro = $_POST['micro'];
            $microprov = $_POST['microprov'];
            $microfac = $_POST['microfac'];
            $microfec = $_POST['microfec'];
            $microgar = $_POST['microgar'];
            $micnro = $_POST['micnro'];
            
            $pvmem = $_POST['pvmem'];
            $pvprov = $_POST['pvprov'];
            $pvfact = $_POST['pvfact'];
            $pvnserie = $_POST['pvnserie'];
            $pvfec = $_POST['pvfec'];
            $pvgar = $_POST['pvgar'];
            
            $pvmem1 = $_POST['pvmem1'];
            $pvprov1 = $_POST['pvprov1'];
            $pvfact1 = $_POST['pvfact1'];
            $pvnserie1 = $_POST['pvnserie1'];
            $pvfec1 = $_POST['pvfec1'];
            $pvgar1 = $_POST['pvgar1'];
            /* ////////////////////////// */
            if($masterizacion == "100"){
                $sql = "SELECT MASTERIZADA FROM inventario WHERE ID_WS = '$id'";
                $result = $datos_base->query($sql);
                $row = $result->fetch_assoc();
                $masterizacion = $row['MASTERIZADA'];
            }
            
            if($reserva == "200"){
                $sql1 = "SELECT RIP FROM inventario WHERE ID_WS = '$id'";
                $result1 = $datos_base->query($sql1);
                $row1 = $result1->fetch_assoc();
                $reserva = $row1['RIP'];
            }
            
            if($red == "300"){
                $sql2 = "SELECT ID_RED FROM inventario WHERE ID_WS = '$id'";
                $result2 = $datos_base->query($sql2);
                $row2 = $result2->fetch_assoc();
                $red = $row2['ID_RED'];
            }
            
            if($placam == "400"){
                $sql3 = "SELECT ID_PLACAM FROM inventario WHERE ID_WS = '$id'";
                $result3 = $datos_base->query($sql3);
                $row3 = $result3->fetch_assoc();
                $placam = $row3['ID_PLACAM'];
            }
            
            if($so == "500"){
                $sql4 = "SELECT ID_SO FROM inventario WHERE ID_WS = '$id'";
                $result4 = $datos_base->query($sql4);
                $row4 = $result4->fetch_assoc();
                $so = $row4['ID_SO'];
            }
            
            /* if($micro == "600"){
                $sql5 = "SELECT ID_MICRO FROM inventario WHERE ID_WS = '$id'";
                $result5 = $datos_base->query($sql5);
                $row5 = $result5->fetch_assoc();
                $micro = $row5['ID_MICRO'];
            } */
            
            if($est == "700"){
                $sql6 = "SELECT ID_ESTADOWS FROM inventario WHERE ID_WS = '$id'";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $est = $row6['ID_ESTADOWS'];
            }
            
            if($prov == "800"){
                $sql6 = "SELECT ID_PROVEEDOR FROM inventario WHERE ID_WS = '$id'";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $prov = $row6['ID_PROVEEDOR'];
            }
            
            if($tippc == "900"){
                $sql6 = "SELECT ID_TIPOWS FROM inventario WHERE ID_WS = '$id'";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $tippc = $row6['ID_TIPOWS'];
            }
            
            if($usu == "1000"){
                $sql6 = "SELECT ID_USUARIO FROM inventario WHERE ID_WS = '$id'";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $usu = $row6['ID_USUARIO'];
            }
            
            if($marca == "1100"){
                $sql6 = "SELECT ID_MARCA FROM inventario WHERE ID_WS = '$id'";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $marca = $row6['ID_MARCA'];
            }
            
            
            
            
            
            
            
            /* ////////////////////MEMORIA///////////////////////////// */
            /* //////////////////////////////////////////////////////// */
            
            if($mem1 == "1200"){
                $sql6 = "SELECT ID_MEMORIA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $mem1 = $row6['ID_MEMORIA'];
            }elseif($mem1 == "0" OR $mem1 == ""){
                $mem1 = 9;
            }
            
            if($tmem1 == "1201"){
                $sql6 = "SELECT ID_TIPOMEM FROM wsmem WHERE ID_WS = '$id' AND SLOT = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $tmem1 = $row6['ID_TIPOMEM'];
            }
            
            if($prov1 == "1202"){
                $sql6 = "SELECT ID_PROVEEDOR FROM wsmem WHERE ID_WS = '$id' AND SLOT = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $prov1 = $row6['ID_PROVEEDOR'];
            }
            
            if($marc1 == "1203"){
                $sql6 = "SELECT ID_MARCA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $marc1 = $row6['ID_MARCA'];
            }
            
            if($pvel1 == "1204"){
                $sql6 = "SELECT ID_FRECUENCIA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $pvel1 = $row6['ID_FRECUENCIA'];
            }
            
            
            
            
            if($mem2 == "1300"){
                $sql6 = "SELECT ID_MEMORIA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 2";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $mem2 = $row6['ID_MEMORIA'];
            }
            
            if($tmem2 == "1301"){
                $sql6 = "SELECT ID_TIPOMEM FROM wsmem WHERE ID_WS = '$id' AND SLOT = 2";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $tmem2 = $row6['ID_TIPOMEM'];
            }
            
            if($prov2 == "1302"){
                $sql6 = "SELECT ID_PROVEEDOR FROM wsmem WHERE ID_WS = '$id' AND SLOT = 2";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $prov2 = $row6['ID_PROVEEDOR'];
            }
            
            if($marc2 == "1303"){
                $sql6 = "SELECT ID_MARCA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 2";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $marc2 = $row6['ID_MARCA'];
            }
            
            if($pvel2 == "1304"){
                $sql6 = "SELECT ID_FRECUENCIA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $pvel2 = $row6['ID_FRECUENCIA'];
            }
            
            
            
            if($mem3 == "1400"){
                $sql6 = "SELECT ID_MEMORIA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 3";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $mem3 = $row6['ID_MEMORIA'];
            }
            
            if($tmem3 == "1401"){
                $sql6 = "SELECT ID_TIPOMEM FROM wsmem WHERE ID_WS = '$id' AND SLOT = 3";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $tmem3 = $row6['ID_TIPOMEM'];
            }
            
            if($prov3 == "1402"){
                $sql6 = "SELECT ID_PROVEEDOR FROM wsmem WHERE ID_WS = '$id' AND SLOT = 3";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $prov3 = $row6['ID_PROVEEDOR'];
            }
            
            if($marc3 == "1403"){
                $sql6 = "SELECT ID_MARCA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 3";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $marc3 = $row6['ID_MARCA'];
            }
            
            if($pvel3 == "1404"){
                $sql6 = "SELECT ID_FRECUENCIA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $pvel3 = $row6['ID_FRECUENCIA'];
            }
            
            
            if($mem4 == "1500"){
                $sql6 = "SELECT ID_MEMORIA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 4";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $mem4 = $row6['ID_MEMORIA'];
            }
            
            if($tmem4 == "1501"){
                $sql6 = "SELECT ID_TIPOMEM FROM wsmem WHERE ID_WS = '$id' AND SLOT = 4";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $tmem4 = $row6['ID_TIPOMEM'];
            }
            
            if($prov4 == "1502"){
                $sql6 = "SELECT ID_PROVEEDOR FROM wsmem WHERE ID_WS = '$id' AND SLOT = 4";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $prov4 = $row6['ID_PROVEEDOR'];
            }
            
            if($marc4 == "1503"){
                $sql6 = "SELECT ID_MARCA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 4";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $marc4 = $row6['ID_MARCA'];
            }
            
            if($pvel4 == "1504"){
                $sql6 = "SELECT ID_FRECUENCIA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $pvel4 = $row6['ID_FRECUENCIA'];
            }
            
            
            
            
            
            
            
            /* ////////////////////DISCOS///////////////////////////// */
            /* //////////////////////////////////////////////////////// */
            
            if($disc1 == "1600"){
                $sql6 = "SELECT ID_DISCO FROM discows WHERE ID_WS = '$id' AND NUMERO = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $disc1 = $row6['ID_DISCO'];
            }
            
            if($tdisc1 == "1601"){
                $sql6 = "SELECT ID_TIPOD FROM discows WHERE ID_WS = '$id' AND NUMERO = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $tdisc1 = $row6['ID_TIPOD'];
            }
            
            if($dprov1 == "1602"){
                $sql6 = "SELECT ID_PROVEEDOR FROM discows WHERE ID_WS = '$id' AND NUMERO = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $dprov1 = $row6['ID_PROVEEDOR'];
            }
            
            if($dmod1 == "1603"){
                $sql6 = "SELECT ID_MODELO FROM discows WHERE ID_WS = '$id' AND NUMERO = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $dmod1 = $row6['ID_MODELO'];
            }
            
            
            
            if($disc2 == "1700"){
                $sql6 = "SELECT ID_DISCO FROM discows WHERE ID_WS = '$id' AND NUMERO = 2";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $disc2 = $row6['ID_DISCO'];
            }
            
            if($tdisc2 == "1701"){
                $sql6 = "SELECT ID_TIPOD FROM discows WHERE ID_WS = '$id' AND NUMERO = 2";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $tdisc2 = $row6['ID_TIPOD'];
            }
            
            if($dprov2 == "1702"){
                $sql6 = "SELECT ID_PROVEEDOR FROM discows WHERE ID_WS = '$id' AND NUMERO = 2";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $dprov2 = $row6['ID_PROVEEDOR'];
            }
            
            if($dmod2 == "1703"){
                $sql6 = "SELECT ID_MODELO FROM discows WHERE ID_WS = '$id' AND NUMERO = 2";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $dmod2 = $row6['ID_MODELO'];
            }
            
            
            
            
            if($disc3 == "1800"){
                $sql6 = "SELECT ID_DISCO FROM discows WHERE ID_WS = '$id' AND NUMERO = 3";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $disc3 = $row6['ID_DISCO'];
            }
            
            if($tdisc3 == "1801"){
                $sql6 = "SELECT ID_TIPOD FROM discows WHERE ID_WS = '$id' AND NUMERO = 3";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $tdisc3 = $row6['ID_TIPOD'];
            }
            
            if($dprov3 == "1802"){
                $sql6 = "SELECT ID_PROVEEDOR FROM discows WHERE ID_WS = '$id' AND NUMERO = 3";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $dprov3 = $row6['ID_PROVEEDOR'];
            }
            
            if($dmod3 == "1803"){
                $sql6 = "SELECT ID_MODELO FROM discows WHERE ID_WS = '$id' AND NUMERO = 3";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $dmod3 = $row6['ID_MODELO'];
            }
            
            
            
            
            if($disc4 == "1900"){
                $sql6 = "SELECT ID_DISCO FROM discows WHERE ID_WS = '$id' AND NUMERO = 4";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $disc4 = $row6['ID_DISCO'];
            }
            
            if($tdisc4 == "1901"){
                $sql6 = "SELECT ID_TIPOD FROM discows WHERE ID_WS = '$id' AND NUMERO = 4";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $tdisc4 = $row6['ID_TIPOD'];
            }
            
            if($dprov4 == "1902"){
                $sql6 = "SELECT ID_PROVEEDOR FROM discows WHERE ID_WS = '$id' AND NUMERO = 4";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $dprov4 = $row6['ID_PROVEEDOR'];
            }
            
            if($dmod4 == "1903"){
                $sql6 = "SELECT ID_MODELO FROM discows WHERE ID_WS = '$id' AND NUMERO = 4";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $dmod4 = $row6['ID_MODELO'];
            }
            
            
            
            /* ////////////////////PLACA MADRE///////////////////////////// */
            /* //////////////////////////////////////////////////////// */
            if($placam == "2000"){
                $sql6 = "SELECT ID_PLACAM FROM placamws WHERE ID_WS = '$id'";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $placam = $row6['ID_PLACAM'];
            }
            if($placamprov == "2001"){
                $sql6 = "SELECT ID_PROVEEDOR FROM placamws WHERE ID_WS = '$id'";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $placamprov = $row6['ID_PROVEEDOR'];
            }
            /* ////////////////////MICROPROCESADOR///////////////////////////// */
            /* //////////////////////////////////////////////////////// */
            if($micro == "2100"){
                $sql6 = "SELECT ID_MICRO FROM microws WHERE ID_WS = '$id'";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $micro = $row6['ID_MICRO'];
            }
            if($microprov == "2101"){
                $sql6 = "SELECT ID_PROVEEDOR FROM microws WHERE ID_WS = '$id'";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $microprov = $row6['ID_PROVEEDOR'];
            }
            /* ////////////////////PLACA DE VIDEO///////////////////////////// */
            /* //////////////////////////////////////////////////////// */
            if($pvmem == "2200"){
                $sql6 = "SELECT ID_PVIDEO FROM pvideows WHERE ID_WS = '$id' AND SLOT = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $pvmem = $row6['ID_PVIDEO'];
            }
            if($pvprov == "2201"){
                $sql6 = "SELECT ID_PROVEEDOR FROM pvideows WHERE ID_WS = '$id' AND SLOT = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $pvprov = $row6['ID_PROVEEDOR'];
            }
            
            if($pvmem1 == "2300"){
                $sql6 = "SELECT ID_PVIDEO FROM pvideows WHERE ID_WS = '$id' AND SLOT = 2";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $pvmem1 = $row6['ID_PVIDEO'];
            }
            if($pvprov1 == "2301"){
                $sql6 = "SELECT ID_PROVEEDOR FROM pvideows WHERE ID_WS = '$id' AND SLOT = 2";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $pvprov1 = $row6['ID_PROVEEDOR'];
            }
            
            if($procedencia == "2400"){
                $sql6 = "SELECT ID_PROCEDENCIA FROM inventario WHERE ID_WS = '$id'";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $procedencia = $row6['ID_PROCEDENCIA'];
            }
            
            /*SI AMBOS CAMPOS ESTAN REPETIDOS*/ 
            $sqli = "SELECT * FROM inventario WHERE (SERIEG = '$serieg' AND ID_WS != '$id')";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $serg = $row2['SERIEG'];
            
            $area = $_POST['area'];
            
            if($usu == 277){
            
                    if($area == "1100" || $area == 0 || null){
                    $sql6 = "SELECT ID_AREA FROM inventario WHERE ID_WS = '$id'";
                    $result6 = $datos_base->query($sql6);
                    $row6 = $result6->fetch_assoc();
                    $area = $row6['ID_AREA'];
                    }
            
            
            /*     if(($_POST['area']) != "1100"){
                    $area = $_POST['area'];
                }else{
                    $sqli = "SELECT ID_AREA FROM inventario WHERE ID_WS = '$id'";
                    $resultado2 = $datos_base->query($sqli);
                    $row2 = $resultado2->fetch_assoc();
                    $area = $row2['ID_AREA'];
                } */
            }else{
            /*     if(isset($_POST['area'])){
                    if($_POST['area'] == "1100"){
                        $sql6 = "SELECT ID_AREA FROM inventario WHERE ID_WS = '$id'";
                        $result6 = $datos_base->query($sql6);
                        $row6 = $result6->fetch_assoc();
                        $area = $row6['ID_AREA'];
                    }
                }else{ */
                $sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $area = $row2['ID_AREA'];
                /* } */
            }
            
            
            if($serieg == $serg){ 
                header("Location: ../consulta/inventario.php?noMod");
            }
            else{    
                /* MOVIMIENTOS DEL EQUIPO */
                $sqli = "SELECT ID_AREA, ID_USUARIO, ID_ESTADOWS, ID_MARCA, ID_SO, MASTERIZADA, MAC, RIP, IP, ID_RED FROM inventario WHERE ID_WS = '$id'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $a = $row2['ID_AREA'];
                $u = $row2['ID_USUARIO'];
                $e = $row2['ID_ESTADOWS'];
                $mr = $row2['ID_MARCA'];
                $s = $row2['ID_SO'];
                $ma = $row2['MASTERIZADA'];
                $mc = $row2['MAC'];
                $r = $row2['RIP'];
                $i = $row2['IP'];
                $rd = $row2['ID_RED'];
                if($a != $area || $u != $usu || $e != $est || $mr != $marca || $s != $so || $ma != $masterizacion || $mc != $mac || $r != $reserva || $i != $ip || $rd != $red){
                    mysqli_query($datos_base, "INSERT INTO movimientos VALUES (DEFAULT, '$fechaActual', '$id', '$usu', '$area', '$est', '$marca', '$so', '$masterizacion', '$mac', '$reserva', '$ip', '$red')");
                }
            
                /* GUARDANDO PARA LAS MEJORAS */
                $sqli = "SELECT ID_PLACAM FROM placamws WHERE ID_WS = '$id'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $mejpm = $row2['ID_PLACAM'];
            
                $sqli = "SELECT ID_MICRO FROM microws WHERE ID_WS = '$id'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $mejmic = $row2['ID_MICRO'];
            
                $sqli = "SELECT ID_PVIDEO FROM pvideows WHERE ID_WS = '$id' AND SLOT = 1";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $mejpv1 = $row2['ID_PVIDEO'];
            
                $sqli = "SELECT ID_PVIDEO FROM pvideows WHERE ID_WS = '$id' AND SLOT = 2";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $mejpv2 = $row2['ID_PVIDEO'];
            
                /* MEMORIA PARA MEJORAS */
                $sqli = "SELECT ID_MEMORIA, ID_TIPOMEM, ID_FRECUENCIA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 1";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $mejmem1 = $row2['ID_MEMORIA'];
                $mejtmem1 = $row2['ID_TIPOMEM'];
                $mejfre1 = $row2['ID_FRECUENCIA'];
            
                $sqli = "SELECT ID_MEMORIA, ID_TIPOMEM, ID_FRECUENCIA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 2";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $mejmem2 = $row2['ID_MEMORIA'];
                $mejtmem2 = $row2['ID_TIPOMEM'];
                $mejfre2 = $row2['ID_FRECUENCIA'];
            
                $sqli = "SELECT ID_MEMORIA, ID_TIPOMEM, ID_FRECUENCIA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 3";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $mejmem3 = $row2['ID_MEMORIA'];
                $mejtmem3 = $row2['ID_TIPOMEM'];
                $mejfre3 = $row2['ID_FRECUENCIA'];
            
                $sqli = "SELECT ID_MEMORIA, ID_TIPOMEM, ID_FRECUENCIA FROM wsmem WHERE ID_WS = '$id' AND SLOT = 4";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $mejmem4 = $row2['ID_MEMORIA'];
                $mejtmem4 = $row2['ID_TIPOMEM'];
                $mejfre4 = $row2['ID_FRECUENCIA'];
            
                /* DISCO PARA MEJORAS */
                $sqli = "SELECT ID_DISCO, ID_TIPOD FROM discows WHERE ID_WS = '$id' AND NUMERO = 1";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $mejdis1 = $row2['ID_DISCO'];
                $mejtdis1 = $row2['ID_TIPOD'];
            
                $sqli = "SELECT ID_DISCO, ID_TIPOD FROM discows WHERE ID_WS = '$id' AND NUMERO = 2";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $mejdis2 = $row2['ID_DISCO'];
                $mejtdis2 = $row2['ID_TIPOD'];
            
                $sqli = "SELECT ID_DISCO, ID_TIPOD FROM discows WHERE ID_WS = '$id' AND NUMERO = 3";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $mejdis3 = $row2['ID_DISCO'];
                $mejtdis3 = $row2['ID_TIPOD'];
            
                $sqli = "SELECT ID_DISCO, ID_TIPOD FROM discows WHERE ID_WS = '$id' AND NUMERO = 4";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $mejdis4 = $row2['ID_DISCO'];
                $mejtdis4 = $row2['ID_TIPOD'];
            
                if($mejpm != $placam || $mejmic != $micro || $mejpv1 != $pvmem || $mejpv2 != $pvmem1 || $mejmem1 != $mem1 || $mejtmem1 != $tmem1 || $mejfre1 != $pvel1 || $mejmem2 != $mem2 || $mejtmem2 != $tmem2 || $mejfre2 != $pvel2 || $mejmem3 != $mem3 || $mejtmem3 != $tmem3 || $mejfre3 != $pvel3 || $mejmem4 != $mem4 || $mejtmem4 != $tmem4 || $mejfre4 != $pvel4 || $mejdis1 != $disc1 || $mejtdis1 != $tdisc1 || $mejdis2 != $disc2 || $mejtdis2 != $tdisc2 || $mejdis3 != $disc3 || $mejtdis3 != $tdisc3 || $mejdis4 != $disc4 || $mejtdis4 != $tdisc4){
                mysqli_query($datos_base, "INSERT INTO mejoras VALUES (DEFAULT, '$fechaActual', '$id', '$placam', '$micro', '$pvmem', '$pvmem1', '$mem1', '$tmem1', '$pvel1', '$mem2', '$tmem2', '$pvel2', '$mem3', '$tmem3', '$pvel3', '$mem4', '$tmem4', '$pvel4', '$disc1', '$tdisc1', '$disc2', '$tdisc2', '$disc3', '$tdisc3', '$disc4', '$tdisc4')");
                }
            
                $mejdis1 = $row2['ID_DISCO'];
                $mejtdis1 = $row2['ID_TIPOD'];
            
            
            
                mysqli_query($datos_base, "UPDATE inventario SET ID_AREA = '$area', SERIALN = '$serialn', SERIEG = '$serieg', ID_MARCA = '$marca', ID_ESTADOWS = '$est', ID_SO = '$so', OBSERVACION = '$obs', ID_PROVEEDOR = '$prov', FACTURA = '$fac', MASTERIZADA = '$masterizacion', MAC = '$mac', RIP = '$reserva', IP = '$ip', ID_RED = '$red', ID_TIPOWS = '$tippc', ID_USUARIO = '$usu', ID_PROCEDENCIA = '$procedencia' WHERE ID_WS = '$id'");
            
            
                /* PLACA MADRE */
                mysqli_query($datos_base, "UPDATE placamws SET ID_PLACAM = '$placam', ID_PROVEEDOR = '$placamprov', GARANTIA = '$placamgar', FACTURA = '$placamfact', FECHA = '$placamfecha', NSERIE = '$planro' WHERE ID_WS = '$id'");
            
            
                /* MICROPROCESADOR */
                mysqli_query($datos_base, "UPDATE microws SET ID_MICRO = '$micro', ID_PROVEEDOR = '$microprov', GARANTIA = '$microgar', FACTURA = '$microfac', FECHA = '$microfec', NSERIE = '$micnro' WHERE ID_WS = '$id'");
            
            
                /* PLACA DE VIDEO */
                mysqli_query($datos_base, "UPDATE pvideows SET ID_PVIDEO = '$pvmem', ID_PROVEEDOR = '$pvprov', NSERIE = '$pvnserie', GARANTIA = '$pvgar', FACTURA = '$pvfact', FECHA = '$pvfec' WHERE ID_WS = '$id' AND SLOT = 1");
            
                mysqli_query($datos_base, "UPDATE pvideows SET ID_PVIDEO = '$pvmem1', ID_PROVEEDOR = '$pvprov1', NSERIE = '$pvnserie1', GARANTIA = '$pvgar1', FACTURA = '$pvfact1', FECHA = '$pvfec1' WHERE ID_WS = '$id' AND SLOT = 2");
            
            
                /* DISCO */
                mysqli_query($datos_base, "UPDATE discows SET ID_DISCO = '$disc1', ID_TIPOD = '$tdisc1', ID_PROVEEDOR = '$dprov1', FACTURA = '$dfact1', FECHA = '$dfec1', ID_MODELO = '$dmod1', GARANTIA = '$dgar1' WHERE ID_WS = '$id' AND NUMERO = 1");
            
                mysqli_query($datos_base, "UPDATE discows SET ID_DISCO = '$disc2', ID_TIPOD = '$tdisc2', ID_PROVEEDOR = '$dprov2', FACTURA = '$dfact2', FECHA = '$dfec2', ID_MODELO = '$dmod2', GARANTIA = '$dgar2' WHERE ID_WS = '$id' AND NUMERO = 2");
                
                mysqli_query($datos_base, "UPDATE discows SET ID_DISCO = '$disc3', ID_TIPOD = '$tdisc3', ID_PROVEEDOR = '$dprov3', FACTURA = '$dfact3', FECHA = '$dfec3', ID_MODELO = '$dmod3', GARANTIA = '$dgar3' WHERE ID_WS = '$id' AND NUMERO = 3");
            
                mysqli_query($datos_base, "UPDATE discows SET ID_DISCO = '$disc4', ID_TIPOD = '$tdisc4', ID_PROVEEDOR = '$dprov4', FACTURA = '$dfact4', FECHA = '$dfec4', ID_MODELO = '$dmod4', GARANTIA = '$dgar4' WHERE ID_WS = '$id' AND NUMERO = 4");
            
            
                /* MEMORIA */
                mysqli_query($datos_base, "UPDATE wsmem SET ID_MEMORIA = '$mem1', ID_TIPOMEM = '$tmem1', ID_PROVEEDOR = '$prov1', FACTURA = '$fact1', FECHA = '$fec1', ID_MARCA = '$marc1', GARANTIA = '$gar1', ID_FRECUENCIA = $pvel1 WHERE ID_WS = '$id' AND SLOT = 1");
            
                mysqli_query($datos_base, "UPDATE wsmem SET ID_MEMORIA = '$mem2', ID_TIPOMEM = '$tmem2', ID_PROVEEDOR = '$prov2', FACTURA = '$fact2', FECHA = '$fec2', ID_MARCA = '$marc2', GARANTIA = '$gar2', ID_FRECUENCIA = $pvel2 WHERE ID_WS = '$id' AND SLOT = 2");
            
                mysqli_query($datos_base, "UPDATE wsmem SET ID_MEMORIA = '$mem3', ID_TIPOMEM = '$tmem3', ID_PROVEEDOR = '$prov3', FACTURA = '$fact3', FECHA = '$fec3', ID_MARCA = '$marc3', GARANTIA = '$gar3', ID_FRECUENCIA = $pvel3 WHERE ID_WS = '$id' AND SLOT = 3");
            
                mysqli_query($datos_base, "UPDATE wsmem SET ID_MEMORIA = '$mem4', ID_TIPOMEM = '$tmem4', ID_PROVEEDOR = '$prov4', FACTURA = '$fact4', FECHA = '$fec4', ID_MARCA = '$marc4', GARANTIA = '$gar4', ID_FRECUENCIA = $pvel4 WHERE ID_WS = '$id' AND SLOT = 4");
            
                mysqli_query($datos_base, "UPDATE wsusuario SET ID_USUARIO = '$usu' WHERE ID_WS = '$id'");
            
            
                header("Location: ../consulta/inventario.php?okMod");
                exit;
            }
            break;

        /* -----------------MONTOS/LINEAS: modificarLinea.php----------------- */
        case 'modificarLinea':
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
            header('Location: ../consulta/montosLineas.php?ok'); 
            exit;
            break;

        /* -----------------CELULAR: modificarCelular.php----------------- */
        case 'modificarCelular':
            $id = $_POST['id'] ?? 0;
            $imei = $_POST['imei'] ?? '';
            $usuario = $_POST['usuario'] ?? 277;
            $linea = $_POST['linea'] ?? 0;
            $estado = $_POST['estado'] ?? 0;
            $proveedor = $_POST['proveedor'] ?? 0;
            $modelo = $_POST['modelo'] ?? 0;
            $procedencia = $_POST['procedencia'] ?? 0;
            $obs = $_POST['obs'] ?? '';
        
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

            /* TRAIGO DATOS ACTUALES DEL CELULAR */
            $sql3 = "SELECT c.ID_USUARIO, c.ID_ESTADOWS, l.ID_LINEA 
            FROM celular c
            LEFT JOIN lineacelular l ON l.ID_CELULAR = c.ID_CELULAR
            WHERE ID_CELULAR = '$id'";
            $result3 = $datos_base->query($sql3);
            $row3 = $result3->fetch_assoc();
            $usuarioBD = $row3['ID_USUARIO'];
            $estadoBD = $row3['ID_ESTADOWS'];
            $lineaBD = $row3['ID_LINEA'];

            $error = false;

            if($estado == 1 AND $estadoBD == $estado){/* BASE DE DATOS Y FORMULARIO: ACTIVO */
               /*  SIGUE IGUAL EL ESTADO, ME FIJO SI CAMBIO EL USUARIO O LINEA */
                /*  tabla celular UPDATE de datos */
                if(mysqli_query($datos_base, "UPDATE celular SET IMEI = '$imei', ID_USUARIO = '$usuario', ID_ESTADOWS = '$estado', ID_PROVEEDOR = '$proveedor', ID_MODELO = '$modelo', ID_PROCEDENCIA = '$procedencia' WHERE ID_CELULAR = '$id'")) $error = true;
                
                if($usuarioBD != $usuario){	
                    /* tabla movicelular INSERT solo por modificacion de usuario, estado */
                    if(mysqli_query($datos_base, "INSERT INTO movicelular VALUES (DEFAULT, '$id', '$estado', '$usuario', '$fechaActual', '$obs')")) $error = true;   

                    if($usuarioBD == 0 || $usuarioBD == 277){/* Sin usuario y pasa a uno asignado */
                        /* tabla lineacelular se vincula con el nuevo usuario
                        tabla lineacelular INSERT nuevo vinculo usuario y linea con celular*/
                        if(mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, '$linea', '$id', '$usuario', '$fechaActual')")) $error = true;   

                    }elseif($usuario == 0 || $usuario == 277){/* Tiene usuario y pasa a sin asignar */
                        /* tabla lineacelular INSERT desvinculacion del celular del usuario y linea */
                        if(mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, 0, '$id', $usuario, '$fechaActual')")) $error = true;   
                        /* tabla lineacelular INSERT desvinculacion de usuario y linea del celular */
                        if(mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, '$lineaBD', 0, '$usuarioBD', '$fechaActual')")) $error = true;   
                    }else{/* Tiene usuario y se cambia de usuario */
                        /* tabla lineacelular INSERT desvinculacion del celular del usuario y linea */
                        if(mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, 0, '$id', 0, '$fechaActual')")) $error = true;   
                        /* tabla lineacelular INSERT desvinculacion de usuario y linea del celular */
                        if(mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, '$lineaBD', 0, '$usuarioBD', '$fechaActual')")) $error = true;   

                        /* tabla lineacelular INSERT vinculacion de usuario y linea con celular */
                        if(mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, '$linea', '$id', '$usuario', '$fechaActual')")) $error = true;   
                    }
                    /* tabla agregado INSERT cambio de usuario con datos del celu */
                    $usuarioConcatenadoNuevo = 'IMEI: ' . $imei . '-' . $usuario;
                    $usuarioConcatenadoViejo = 'IMEI: ' . $imei . '-' . $usuarioBD;
                    if(mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'CELULAR', 'MODIFICADO', '$usuarioConcatenadoNuevo', '$usuarioConcatenadoViejo', '$fechaActual', '$horaActual', '$resolutorActivo')")) $error = true;   

                }elseif($lineaBD != $linea){/* Mismo usuario y solo cambia la linea del usuario */
                    /*  tabla lineacelular INSERT desvinculacion celular y usuario de la linea */
                    if(mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, 0, '$id', 0, '$fechaActual')")) $error = true;   

                    /*  tabla lineacelular INSERT desvinculacion de la linea del usuario y celular */
                    if(mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, '$lineaBD', 0, '$usuarioBD', '$fechaActual')")) $error = true;   

                    /* tabla lineacelular INSERT vinculacion celular y usuario a la nueva linea */
                    if(mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, '$linea', '$id', '$usuarioBD', '$fechaActual')")) $error = true;

                     /* tabla agregado INSERT cambio de inea con datos del celu */
                    $usuarioConcatenadoNuevo = 'IMEI: ' . $imei . '-' . $linea;
                    $usuarioConcatenadoViejo = 'IMEI: ' . $imei . '-' . $lineaBD;
                    if(mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'CELULAR', 'MODIFICADO', '$usuarioConcatenadoNuevo', '$usuarioConcatenadoViejo', '$fechaActual', '$horaActual', '$resolutorActivo')")) $error = true;  

                }           
            } elseif ($estadoBD == 1 AND $estado != $estadoBD){/* BASE DE DATO: ACTIVO || FORMULARIO: BAJA O STOCK */
                /*  SE DA DE BAJA EL CELULAR, SE ROMPE EL VINCULO CON USUARIO Y LINEA */
                /* tabla celular UPDATE de datos */
                if(mysqli_query($datos_base, "UPDATE celular SET IMEI = '$imei', ID_USUARIO = '$usuario', ID_ESTADOWS = '$estado', ID_PROVEEDOR = '$proveedor', ID_MODELO = '$modelo', ID_PROCEDENCIA = '$procedencia' WHERE ID_CELULAR = '$id'")) $error = true;
                /* tabla movicelular INSERT. Cambia usuario y estado */
                if(mysqli_query($datos_base, "INSERT INTO movicelular VALUES (DEFAULT, '$id', '$estado', '$usuario', '$fechaActual', '$obs')")) $error = true;   


                /*  tabla lineacelular INSERT desvinculacion usuario de la linea del celular*/
                if(mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, '$lineaBD', 0, '$usuarioBD', '$fechaActual')")) $error = true;   

                /*  tabla lineacelular INSERT desvinculacion del celular de la linea y del usuario */
                if(mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, '$linea', '$id', '$usuario', '$fechaActual')")) $error = true;   

                /* tabla agregado INSERT cambio de inea con datos del celu */
                $usuarioConcatenadoNuevo = 'IMEI: ' . $imei . '-' . $estado;
                $usuarioConcatenadoViejo = 'IMEI: ' . $imei . '-' . $estadoBD;
                if(mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'CELULAR', 'MODIFICADO', '$usuarioConcatenadoNuevo', '$usuarioConcatenadoViejo', '$fechaActual', '$horaActual', '$resolutorActivo')")) $error = true;  
            } elseif ($estadoBD != 1 AND $estado == 1) {/*  BASE DE DATOS: BAJA O STOCK || FORMULARIO: ACTIVO */
                /* tabla celular UPDATE de datos */
                if(!mysqli_query($datos_base, "UPDATE celular SET IMEI = '$imei', ID_USUARIO = '$usuario', ID_ESTADOWS = '$estado', ID_PROVEEDOR = '$proveedor', ID_MODELO = '$modelo', ID_PROCEDENCIA = '$procedencia' WHERE ID_CELULAR = '$id'")) $error = true;

                /* tabla movicelular INSERT. Cambia usuario (SI SE ASIGNA) y estado */
                if(!mysqli_query($datos_base, "INSERT INTO movicelular VALUES (DEFAULT, '$id', '$estado', '$usuario', '$fechaActual', '$obs')")) $error = true;  

                /* SOLO SI SE ASIGNA UNA LINEA: tabla lineacelular INSERT vinculacion linea con celular  */
                if(!mysqli_query($datos_base, "INSERT INTO lineacelular VALUES (DEFAULT, '$linea', '$id', '$usuario', '$fechaActual')")) $error = true;   

                /* tabla agregado INSERT cambio de estado y usuario con datos del celu (SI ES QUE SE ASIGNA) */
                $usuarioConcatenadoNuevo = 'IMEI: ' . $imei . '-' . $estado;
                $usuarioConcatenadoViejo = 'IMEI: ' . $imei . '-' . $estadoBD;
                if(!mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'CELULAR', 'MODIFICADO', '$usuarioConcatenadoNuevo', '$usuarioConcatenadoViejo', '$fechaActual', '$horaActual', '$resolutorActivo')")) $error = true;  
            }
                // REDIRECCIÓN FINAL
                if ($error) {
                    header("Location: ./celulares.php?noMod");
                } else {
                    header("Location: ./celulares.php?okMod");
                }
                exit;
            break;

        default:
            echo "Acción no reconocida.";
            break;
        }
    } else{
        echo "No se recibió ninguna acción.";
    }


    /* -----------------MONTOS/LINEAS: montosLineas.php----------------- */
    //BOTON ACTUALIZAR MONTOS MENSUALES
    if(isset($_POST['operador'])){
        $operador=$_POST['operador'];
        $bloquearActualizacion = false;

        //SELECCIONAR MES Y AÑO DE movilinea EN UNA VARIABLE
        $sqla = "SELECT YEAR(FECHA) AS AÑO, MONTH(FECHA) AS MES FROM `movilinea` ORDER BY FECHA DESC LIMIT 1;";
        $resultado = $datos_base->query($sqla);
        $row = $resultado->fetch_assoc();
        $añomovilinea = $row['AÑO'];
        $mesmovilinea = $row['MES'];

        $añoactual = date('Y');
        $mesactual = date('n');

        //VALIDACION PARA CONTROLAR QUE NO HAYA ACTUALIZACIONES ANTERIORES
        if ($operador == "claro") {
            $verificar = "SELECT COUNT(*) AS TOTAL FROM movilinea m
                        INNER JOIN linea l ON m.ID_LINEA = l.ID_LINEA
                        INNER JOIN nombreplan n ON l.ID_NOMBREPLAN = n.ID_NOMBREPLAN
                        WHERE YEAR(FECHA) = $añoactual AND MONTH(FECHA) = $mesactual AND n.ID_PROVEEDOR = 35";
        } elseif ($operador == "personal") {
            $verificar = "SELECT COUNT(*) AS TOTAL FROM movilinea m
                        INNER JOIN linea l ON m.ID_LINEA = l.ID_LINEA
                        INNER JOIN nombreplan n ON l.ID_NOMBREPLAN = n.ID_NOMBREPLAN
                        WHERE YEAR(FECHA) = $añoactual AND MONTH(FECHA) = $mesactual AND n.ID_PROVEEDOR = 34";
        } elseif ($operador == "todos") {
            // Verificamos si hay movimientos de Personal o Claro
            $verificar = "SELECT 
                            SUM(CASE WHEN n.ID_PROVEEDOR = 34 THEN 1 ELSE 0 END) AS PERSONAL,
                            SUM(CASE WHEN n.ID_PROVEEDOR = 35 THEN 1 ELSE 0 END) AS CLARO
                        FROM movilinea m
                        INNER JOIN linea l ON m.ID_LINEA = l.ID_LINEA
                        INNER JOIN nombreplan n ON l.ID_NOMBREPLAN = n.ID_NOMBREPLAN
                        WHERE YEAR(FECHA) = $añoactual AND MONTH(FECHA) = $mesactual";
        }
        
        $resultadoVerif = $datos_base->query($verificar);
        $rowVerif = $resultadoVerif->fetch_assoc();
        
        if ($operador == "todos") {
            if ($rowVerif['PERSONAL'] > 0 || $rowVerif['CLARO'] > 0) {
                $bloquearActualizacion = true;
                // $mensajeError = "Ya hay líneas actualizadas este mes para Personal o Claro.";
                $mensajeError = "error";
            }
        } else {
            if ($rowVerif['TOTAL'] > 0) {
                $bloquearActualizacion = true;
                // $mensajeError = "Ya hay líneas actualizadas este mes para el operador seleccionado.";
                $mensajeError = "errorp";
            }
        }
        
        if ($bloquearActualizacion) {
            // echo "<script>alert('$mensajeError'); window.location.href='montosLineas.php';</script>";
            echo "<script>window.location.href='montosLineas.php?$mensajeError';</script>";
            exit;
        }

        //SELECCIONAR LOS DATOS DE movilinea DONDE CUMPLAN MES Y AÑO
        //ID proveedor Personal = 34
        //ID proveedor Claro = 35

        $fecha = new DateTime();              // Fecha actual
        $fecha = (new DateTime('first day of this month'))->modify('-1 month');           // Le restamos un mes

        $mesAnterior = $fecha->format('n');   // Mes sin cero inicial (1-12)
        $añoAnterior = $fecha->format('Y');   // Año con cuatro dígitos

        if ($operador=="claro") {
            $query="SELECT m.ID_LINEA, m.ID_USUARIO, m.ID_ESTADOWS, m.ID_NOMBREPLAN, m.EXTRAS, m.FECHADESCUENTO, m.ID_ROAMING, m.DESCUENTO, m.MONTOTOTAL, m.OBSERVACION
            FROM movilinea m
            INNER JOIN linea l ON l.ID_LINEA = m.ID_LINEA
            INNER JOIN nombreplan n ON l.ID_NOMBREPLAN = n.ID_NOMBREPLAN
            INNER JOIN (
                SELECT t.ID_LINEA, MAX(t.ID_MOVILINEA) AS ULTIMO_MOVIMIENTO
                FROM movilinea t
                INNER JOIN linea l2 ON l2.ID_LINEA = t.ID_LINEA
                INNER JOIN nombreplan n2 ON l2.ID_NOMBREPLAN = n2.ID_NOMBREPLAN
                WHERE YEAR(t.FECHA) = $añoAnterior 
                AND MONTH(t.FECHA) = $mesAnterior 
                AND t.ID_ESTADOWS = 1 
                AND n2.ID_PROVEEDOR = 35
                GROUP BY t.ID_LINEA
            ) ultimos ON m.ID_LINEA = ultimos.ID_LINEA AND m.ID_MOVILINEA = ultimos.ULTIMO_MOVIMIENTO";
        }
        if ($operador=="personal") {
            $query="SELECT m.ID_LINEA, m.ID_USUARIO, m.ID_ESTADOWS, m.ID_NOMBREPLAN, m.EXTRAS, m.FECHADESCUENTO, m.ID_ROAMING, m.DESCUENTO, m.MONTOTOTAL, m.OBSERVACION
        FROM movilinea m
        INNER JOIN linea l ON l.ID_LINEA = m.ID_LINEA
        INNER JOIN nombreplan n ON l.ID_NOMBREPLAN = n.ID_NOMBREPLAN
        INNER JOIN (
            SELECT t.ID_LINEA, MAX(t.ID_MOVILINEA) AS ULTIMO_MOVIMIENTO
            FROM movilinea t
            INNER JOIN linea l2 ON l2.ID_LINEA = t.ID_LINEA
            INNER JOIN nombreplan n2 ON l2.ID_NOMBREPLAN = n2.ID_NOMBREPLAN
            WHERE YEAR(t.FECHA) = $añoAnterior 
            AND MONTH(t.FECHA) = $mesAnterior 
            AND t.ID_ESTADOWS = 1 
            AND n2.ID_PROVEEDOR = 34
            GROUP BY t.ID_LINEA
        ) ultimos ON m.ID_LINEA = ultimos.ID_LINEA AND m.ID_MOVILINEA = ultimos.ULTIMO_MOVIMIENTO";
            }
        if ($operador=="todos") {
            $query = "SELECT m.ID_LINEA, m.ID_USUARIO, m.ID_ESTADOWS, m.ID_NOMBREPLAN, m.EXTRAS, m.FECHADESCUENTO, m.ID_ROAMING, m.DESCUENTO, m.MONTOTOTAL, m.OBSERVACION
            FROM movilinea m
            INNER JOIN (
                SELECT ID_LINEA, MAX(ID_MOVILINEA) AS ULTIMO_MOVIMIENTO
                FROM movilinea
                WHERE YEAR(FECHA) = $añoAnterior AND MONTH(FECHA) = $mesAnterior AND ID_ESTADOWS = 1
                GROUP BY ID_LINEA
            ) ultimos ON m.ID_LINEA = ultimos.ID_LINEA AND m.ID_MOVILINEA = ultimos.ULTIMO_MOVIMIENTO";
        }
        $resultados=mysqli_query($datos_base, $query);
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

            $iva = 21;
            $impInternos = 1.21;

            // $descuentoParaCuenta=($consulta['DESCUENTO'])*0.01;
            // $valor_descuento=$montoNuevo*$descuentoParaCuenta;
            // $monto_total=$montoNuevo-$valor_descuento;

            // $impuesto = ($monto_total * $iva) / 100;
            // $extras = $impuesto + $impInternos;
            // $monto_total = $monto_total + $extras;

                //Reseteamos los extras
            if ($extras!=36.30 && $extras!=0) {
                $extras=0;
            }

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
        header('Location: ./montosLineas.php?ok');
        exit;
    }

/* CIERRO CONEXIÓN */
mysqli_close($datos_base);