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
        /* ----------------- AGREGAR TIPIFIACION: agregartipificacion.php----------------- */
        case 'agregarTipificacion':
            $tipi = $_POST['tip'] ?? '';
    
            //CORTAR ESPACIOS EN BLANCO:
            $sinEspacios = preg_replace("/[[:space:]]/","",($tipi));
            //CALCULAR EL TAMAÑO
            $tamaño = mb_strlen($sinEspacios);
            //ORDENAR ALFABÉTICAMENTE
            $letras = (str_split($sinEspacios));
            sort($letras, SORT_REGULAR);
            $respuesta = implode($letras);
            
            /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
            $contador = 0;
            
            $consulta=mysqli_query($datos_base, "SELECT REPLACE(TIPIFICACION, ' ', '') AS TIPIFICACION FROM tipificacion");
            while($listar = mysqli_fetch_array($consulta)) 
            {
              //CALCULAR EL TAMAÑO
              $tamaño2 = mb_strlen($listar['TIPIFICACION']);
              //ORDENAR ALFABÉTICAMENTE
              $letras2 = (str_split($listar['TIPIFICACION']));
              sort($letras2, SORT_REGULAR);
              //var_dump($letras);
              $respuesta2 = implode($letras2);
            
              if($respuesta == $respuesta2 AND $tamaño == $tamaño2){
                $contador ++;
              }
            }
            
            if($contador > 0){
              header("Location: agregartipificacion.php?no");
              exit;
            }
            else{
                mysqli_query($datos_base, "INSERT INTO tipificacion VALUES (DEFAULT, '$tipi')"); 
                
                mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'TIPIFICACIÓN', 'AGREGADO', '$tipi', '', '$fechaActual', '$horaActual', '$resolutorActivo')");
        
                header("Location: agregartipificacion.php?ok");
                exit;
            }
            break;

        /* ----------------- AGREGAR ÁREA #: agregararea.php----------------- */
        case 'agregarArea':
            $area = $_POST['area'] ?? '';
            $obs = $_POST['obs'] ?? '';
            $repa = $_POST['repa'] ?? 0;
            $est = $_POST['estado'] ?? 0;
            
            /*SI AMBOS CAMPOS ESTAN REPETIDOS*/
            $sqli = "SELECT * FROM area WHERE AREA = '$area' AND ID_REPA ='$repa'";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $are = $row2['AREA'];
            $rep = $row2['ID_REPA'];
            
            if($area == $are AND $repa == $rep){ 
                header("Location: agregararea.php?no");
                exit;
            }
            else{
                mysqli_query($datos_base, "INSERT INTO area VALUES (DEFAULT, '$area', '$repa', '$est', '$obs')");
                
                mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'ÁREA', 'AGREGADO', '$area', '', '$fechaActual', '$horaActual', '$resolutorActivo')");
        
                header("Location: agregararea.php?ok");
                exit;
            }
            break;

        /* -----------------PLANES: agregarPlan.php----------------- */
        case 'agregarPlan':
            $nombrePlan = $_POST['nombrePlan'] ?? '';
            $monto = $_POST['monto'] ?? '';
            $idPlan = $_POST['plan'] ?? 0;
            $proveedor = $_POST['proveedor'] ?? 0;
        
            /* SI IMEI ESTA REPETIDO */
            $sql = "SELECT COUNT(*) AS TOTAL FROM nombreplan WHERE NOMBREPLAN = '$nombrePlan' AND ID_PLAN = '$idPlan'";
            $resultado = $datos_base->query($sql);
            $row = $resultado->fetch_assoc();
            $cantidadRegistros = $row['TOTAL'];
        
            if($cantidadRegistros > 0){//SI HAY ALGUN REGISTRO EXISTENTE CON ESOS DATOS
                header("Location: ./abmPlanesCelulares.php?no");
                exit;
            }else{
                mysqli_query($datos_base, "INSERT INTO nombreplan VALUES (DEFAULT, '$nombrePlan', '$idPlan', '$proveedor', '$monto')");
        
                mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'PLAN', 'AGREGADO', '$nombrePlan', '', '$fechaActual', '$horaActual', '$resolutorActivo')");
        
                header("Location: ./abmPlanesCelulares.php?ok");
                exit;
            }
            break;

        /* ----------------- AGREGAR USUARIO: agregarUsuario.php----------------- */
        case 'agregarUsuario':
            $nombre = $_POST['nombre_usuario'] ?? '';
            $cuil = $_POST['cuil'] ?? '';
            $int = $_POST['interno'] ?? '';
            $tel = $_POST['telefono_personal'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $correop = $_POST['correo_personal'] ?? '';
            $estadoUsuario = 1; /* SETEO EL ESTADO A ACTIVO PARA SU REGISTRO */
            $obs = $_POST['obs'] ?? '';
            $area = $_POST['area'] ?? 0;
            $piso = $_POST['piso'] ?? 0;
            $turno = $_POST['turno'] ?? 0;
            
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
            
            if($cuil == $cui){
                header("Location: agregarusuario.php?no");
            }
            else if($nombre == $nom){
                mysqli_query($datos_base, "INSERT INTO usuarios VALUES (DEFAULT, '$nombre', '$cuil', '$area', '$piso', '$int', '$correo', '$correop', '$tel', '$turno', '$act', '$obs')"); 

                mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'USUARIO', 'AGREGADO', '$nombre', '', '$fechaActual', '$horaActual', '$resolutorActivo')");

                header("Location: agregarusuario.php?repeat");
                exit;
            }
            else{
                mysqli_query($datos_base, "INSERT INTO usuarios VALUES (DEFAULT, '$nombre', '$cuil', '$area', '$piso', '$int', '$correo', '$correop', '$tel', '$turno', '$act', '$obs')"); 

                mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'USUARIO', 'AGREGADO', '$nombre', '', '$fechaActual', '$horaActual', '$resolutorActivo')");

                header("Location: agregarusuario.php?ok");
                exit;
            }
            break;


            /* ----------------- AGREGAR RESOLUTOR: agregarresolutor.php----------------- */
            case 'agregarResolutor':
                $resolutor = $_POST['nombre_resolutor'] ?? '';
                $cuil = $_POST['cuil'] ?? '';
                $correo = $_POST['correo'] ?? '';
                $telefono = $_POST['telefono'] ?? '';
                $tipo = $_POST['tipo'] ?? 0;
                $perfil = $_POST['perfil'] ?? 0;

                /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
                $sql = "SELECT RESOLUTOR, CUIL FROM resolutor WHERE RESOLUTOR = '$resolutor' OR CUIL='$cuil'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $res = $row['RESOLUTOR'];
                $cui = $row['CUIL'];
                
                if($cuil == $cui)
                {
                    header("Location: agregarresolutor.php?no");
                    exit;
                }
                else if($resolutor == $res)
                {
                    mysqli_query($datos_base, "INSERT INTO resolutor VALUES (DEFAULT, '$resolutor', '$tipo', '$cuil', '$correo', '$telefono', 1234,'$perfil')");
                    
                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'RESOLUTOR', 'AGREGADO', '$resolutor', '', '$fechaActual', '$horaActual', '$resolutorActivo')");

                    header("Location: agregarresolutor.php?repeat");
                    exit;
                }
                else
                {
                    mysqli_query($datos_base, "INSERT INTO resolutor VALUES (DEFAULT, '$resolutor', '$tipo', '$cuil', '$correo', '$telefono', 1234,'$perfil')"); 

                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'RESOLUTOR', 'AGREGADO',  '$resolutor', '', '$fechaActual', '$horaActual', '$resolutorActivo')");

                    header("Location: agregarresolutor.php?ok");
                    exit;
                }
                break;


            /* ----------------- AGREGAR MARCA: agregarmarca.php----------------- */
            case 'agregarMarca':
                $marca = $_POST['marca'] ?? '';

                /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
                $sql = "SELECT * FROM marcas WHERE MARCA = '$marca'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $ma = $row['MARCA'];
                
                if($marca == $ma){
                    header("Location: agregarmarca.php?no");
                    exit;
                }
                else{
                    mysqli_query($datos_base, "INSERT INTO marcas VALUES (DEFAULT, '$marca')"); 

                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'MARCA', 'AGREGADO',  '$marca', '', '$fechaActual', '$horaActual', '$resolutorActivo')");

                    header("Location: agregarmarca.php?ok");
                    exit;
                }
                break;


            /* ----------------- AGREGAR MICRO: agregarmicro.php----------------- */
            case 'agregarMicro':
                $micro = $_POST['micro'] ?? '';
                $marca = $_POST['marca'] ?? 0;
                
                /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
                $sql = "SELECT * FROM micro WHERE MICRO = '$micro'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $mi = $row['MICRO'];
                
                /*SI AMBOS CAMPOS ESTAN REPETIDOS*/
                $sqli = "SELECT * FROM micro WHERE MICRO = '$micro' AND ID_MARCA ='$marca'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $mic = $row2['MICRO'];
                $mar = $row2['ID_MARCA'];
                
                
                if($micro == $mic AND $marca == $mar){ 
                    header("Location: agregarmicro.php?no");
                }
                elseif($micro == $mi){
                    mysqli_query($datos_base, "INSERT INTO micro VALUES (DEFAULT, '$micro', '$marca')"); 

                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'MICRO', 'AGREGADO',  '$micro', '', '$fechaActual', '$horaActual', '$resolutorActivo')");

                    header("Location: agregarmicro.php?repeat");
                    exit;
                }
                else{
                    mysqli_query($datos_base, "INSERT INTO micro VALUES (DEFAULT, '$micro', '$marca')"); 

                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'MICRO', 'AGREGADO',  '$micro', '', '$fechaActual', '$horaActual', '$resolutorActivo')");

                    header("Location: agregarmicro.php?ok");
                    exit;
                }
                break;


            /* ----------------- AGREGAR MODELO: agregarmodelo.php----------------- */
            case 'agregarModelo':
                $modelo = $_POST['modelo'] ?? '';
                $marca = $_POST['marca'] ?? 0;
                $tipo = $_POST['tipo'] ?? 0;
                
                /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
                $sql = "SELECT * FROM modelo WHERE MODELO = '$modelo'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $mo = $row['MODELO'];
                
                
                /*SI AMBOS CAMPOS ESTAN REPETIDOS*/
                $sqli = "SELECT * FROM modelo WHERE MODELO = '$modelo' AND ID_MARCA ='$marca'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $mod = $row2['MODELO'];
                $mar = $row2['ID_MARCA'];
                
                
                if($modelo == $mod AND $marca == $mar){ 
                    header("Location: agregarmodelo.php?no");
                    exit;
                }
                elseif($modelo == $mo){
                    mysqli_query($datos_base, "INSERT INTO modelo VALUES (DEFAULT, '$modelo', '$tipo', '$marca')"); 

                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'MODELO', 'AGREGADO',  '$modelo', '', '$fechaActual', '$horaActual', '$resolutorActivo')");
                    
                    header("Location: agregarmodelo.php?repeat");
                    exit;
                }
                else{
                    mysqli_query($datos_base, "INSERT INTO modelo VALUES (DEFAULT, '$modelo', '$tipo', '$marca')");

                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'MODELO', 'AGREGADO',  '$modelo', '', '$fechaActual', '$horaActual', '$resolutorActivo')");

                    header("Location: agregarmodelo.php?ok");
                    exit;
                }
                break;


            /* ----------------- AGREGAR PLACA DE VIDEO: agregarplacav.php----------------- */
            case 'agregarPlacav':
                $memoria = $_POST['memoria']  ?? 0;
                $modelo = $_POST['modelo']  ?? 0;
                $tipo = $_POST['tipo']  ?? 0;
                
                /*SI AMBOS CAMPOS ESTAN REPETIDOS*/
                $sqli = "SELECT * FROM pvideo WHERE ID_MEMORIA = '$memoria' AND ID_MODELO ='$modelo' AND ID_TIPOMEM = '$tipo'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $placavreg = $row2['ID_PVIDEO'];
                
                if(isset($placavreg)){
                    header("Location: abmplacav.php?no");
                    exit;
                }else{
                    mysqli_query($datos_base, "INSERT INTO pvideo VALUES (DEFAULT, '$memoria', '$modelo', '$tipo')"); 

                    /* BUSCO EL MODELO PARA AGREGAR A agregados.php */
                    $sqli = "SELECT MODELO FROM modelo WHERE ID_MODELO = '$modelo' AND ID_MODELO ='$modelo'";
                    $resultado2 = $datos_base->query($sqli);
                    $row2 = $resultado2->fetch_assoc();
                    $modeloParaAgregado = $row2['MODELO'];

                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'PLACA VIDEO', 'AGREGADO',  '$modeloParaAgregado', '', '$fechaActual', '$horaActual', '$resolutorActivo')");

                    header("Location: abmplacav.php?ok");
                    exit;
                }
                break;


            /* ----------------- AGREGAR PLACA MADRE: agregarplacam.php----------------- */
            case 'agregarPlacam':
                $placam = $_POST['placam'] ?? '';
                $marca = $_POST['marca'] ?? 0;

                /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
                $sql = "SELECT * FROM placam WHERE PLACAM = '$placam'";
                $resultado = $datos_base->query($sql);
                $row = $resultado->fetch_assoc();
                $pm = $row['PLACAM'];
                
                /*SI AMBOS CAMPOS ESTAN REPETIDOS*/
                $sqli = "SELECT * FROM placam WHERE PLACAM = '$placam' AND ID_MARCA ='$marca'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $pcm = $row2['PLACAM'];
                $mar = $row2['ID_MARCA'];
                
                if($placam == $pcm AND $marca == $mar){ 
                    header("Location: agregarplacam.php?no");
                    exit;
                }
                elseif($placam == $pm){
                    mysqli_query($datos_base, "INSERT INTO placam VALUES (DEFAULT, '$placam', '$marca')"); 

                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'PLACA MADRE', 'AGREGADO',  '$placam', '', '$fechaActual', '$horaActual', '$resolutorActivo')");

                    header("Location: agregarplacam.php?repeat");
                    exit;
                }
                else{
                    mysqli_query($datos_base, "INSERT INTO placam VALUES (DEFAULT, '$placam', '$marca')"); 

                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'PLACA MADRE', 'AGREGADO',  '$placam', '', '$fechaActual', '$horaActual', '$resolutorActivo')");

                    header("Location: agregarplacam.php?ok");
                    exit;
                }
                break;


            /* ----------------- AGREGAR IMRPESORA: agregarimpresora.php----------------- */
            case 'agregarImpresora':
                $serieg = $_POST['serieg'] ?? '';
                $serie = $_POST['serie'] ?? '';
                $gar = $_POST['gar'] ?? '';
                $fac = $_POST['fac'] ?? '';
                $mac = $_POST['mac'] ?? '';
                $ip = $_POST['ip'] ?? '';
                $obs = $_POST['obs'] ?? '';

                $modelo = $_POST['modelo'] ?? 0;
                $tipop = $_POST['tipop'] ?? 0;
                $equip = $_POST['equip'] ?? 0;
                $est = $_POST['est'] ?? 0;
                $prov = $_POST['prov'] ?? 0;
                $reserva = $_POST['reserva'] ?? 0;
                $proc = $_POST['proc'] ?? 0;

                $sqli = "SELECT ID_MARCA FROM modelo WHERE ID_MODELO = '$modelo'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $marca = $row2['ID_MARCA'];

                $sqli = "SELECT * FROM periferico WHERE SERIE ='$serie' AND (ID_TIPOP = 1 OR ID_TIPOP = 2 OR ID_TIPOP = 3 OR ID_TIPOP = 4 OR ID_TIPOP = 10 OR ID_TIPOP = 13)";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $ser = $row2['SERIE'];

                $sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $area = $row2['ID_AREA'];

                if($serie == $ser){ 
                    header("Location: agregarimpresora.php?no");
                    exit;
                }
                else{
                    mysqli_query($datos_base, "INSERT INTO periferico VALUES (DEFAULT, '$tipop', DEFAULT, '$serieg', '$marca', '$serie', '$proc', '$obs', 'IMPRESORA', '$mac', '$reserva', '$ip', '$prov', '$fac', '$area', '$usu', '$gar', '$est', '$modelo')");/* USUARIO ESTA MAL, AHORA SE ASIGNA A UN EQUIPO */

                    /* GUARDANDO PARA LOS MOVIMIENTOS */
                    $pe=mysqli_query($datos_base, "SELECT MAX(ID_PERI) AS id FROM periferico");
                    if ($row = mysqli_fetch_row($pe)) {
                        $per = trim($row[0]);
                        }

                    mysqli_query($datos_base, "INSERT INTO movimientosperi VALUES (DEFAULT, '$fechaActual', '$per', '$area', '$usu', '$est')");/* EL USUARIO HAY QUE TRAERLO DESDE LA TABLA INTERMEDIA A TRAVES DELE QUIPO */

                    /* BUSCO EL MODELO PARA AGREGAR A agregados.php */
                    $sqli = "SELECT MODELO FROM modelo WHERE ID_MODELO = '$modelo' AND ID_MODELO ='$modelo'";
                    $resultado2 = $datos_base->query($sqli);
                    $row2 = $resultado2->fetch_assoc();
                    $modeloParaAgregado = $row2['MODELO'];

                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'IMPRESORA', 'AGREGADO',  '$modeloParaAgregado', '', '$fechaActual', '$horaActual', '$resolutorActivo')");

                    header("Location: agregarimpresora.php?ok");
                    exit;
                }
                break;


            /* ----------------- AGREGAR MONITOR: agregarmonitor.php----------------- */
            case 'agregarMonitor':
            $tipop = $_POST['tipop'] ?? 0;
            $equip = $_POST['equip'] ?? 0;
            $modelo = $_POST['mod'] ?? 0;
            $est = $_POST['est'] ?? 0;
            $prov = $_POST['prov'] ?? 0;

            $serieg = $_POST['serieg'] ?? '';
            $serie = $_POST['serie'] ?? '';
            $gar = $_POST['gar'] ?? '';
            $fac = $_POST['fac'] ?? '';
            $obs = $_POST['obs'] ?? '';

            $sqli = "SELECT ID_MARCA FROM modelo
            WHERE ID_MODELO = '$modelo'";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $marca = $row2['ID_MARCA'];

            /*SI AMBOS CAMPOS ESTAN REPETIDOS*/
            $sqli = "SELECT * FROM periferico WHERE SERIE ='$serie' AND (ID_TIPOP = 7 OR ID_TIPOP = 8)";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $ser = $row2['SERIE'];

            $sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
            $resultado2 = $datos_base->query($sqli);
            $row2 = $resultado2->fetch_assoc();
            $area = $row2['ID_AREA'];/* ACA NO ES MAS USUARIO, ES QUIPO AL QUE ESTA ASIGNADO */


            if($serie == $ser){ 
                header("Location: agregarmonitor.php?no");
                exit;
            }
            else{
                mysqli_query($datos_base, "INSERT INTO periferico VALUES (DEFAULT, '$tipop', DEFAULT, '$serieg', '$marca', '$serie', 3, '$obs', 'MONITOR', DEFAULT, 'NO', DEFAULT, '$prov', '$fac', '$area', '$usu', '$gar', '$est', '$modelo')");/* EL INSERT NO VA A FUNCIONAR PORQUE $usu NO LO TRAIGO MAS, TRAIGO EL EQUIPO */


                /* GUARDANDO PARA LOS MOVIMIENTOS */
                $pe=mysqli_query($datos_base, "SELECT MAX(ID_PERI) AS id FROM periferico");
                if ($row = mysqli_fetch_row($pe)) {
                    $per = trim($row[0]);
                    }

                mysqli_query($datos_base, "INSERT INTO movimientosperi VALUES (DEFAULT, '$fechaActual', '$per', '$area', '$usu', '$est')");/* EL INSERT NO VA A FUNCIONAR PORQUE $usu NO LO TRAIGO MAS, TRAIGO EL EQUIPO */

                /* BUSCO EL MODELO PARA AGREGAR A agregados.php */
                $sqli = "SELECT MODELO FROM modelo WHERE ID_MODELO = '$modelo' AND ID_MODELO ='$modelo'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $modeloParaAgregado = $row2['MODELO'];

                mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'MONITOR', 'AGREGADO',  '$modeloParaAgregado', '', '$fechaActual', '$horaActual', '$resolutorActivo')");

                header("Location: agregarmonitor.php?ok");
                exit;
            }
                break;


            /* ----------------- AGREGAR OTROS PERIFERICOS: agregarotrosperifericos.php----------------- */
            case 'agregarOtrosPerifericos':
                $tipop = $_POST['tipop'] ?? 0;
                $marca = $_POST['marca'] ?? 0;
                $equip = $_POST['equip'] ?? 0;
                $modelo = $_POST['mod'] ?? 0;
                $est = $_POST['est'] ?? 0;
                $prov = $_POST['prov'] ?? 0;

                $serie = $_POST['serie'] ?? '';
                $serieg = $_POST['serieg'] ?? '';
                $gar = $_POST['gar'] ?? '';
                $fac = $_POST['fac'] ?? '';
                $obs = $_POST['obs'] ?? '';
                
                /*SI AMBOS CAMPOS ESTAN REPETIDOS*/
                $sqli = "SELECT * FROM periferico WHERE SERIEG = '$serieg' AND (ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12)";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $serg = $row2['SERIEG'];
                
                $sqli = "SELECT * FROM periferico WHERE SERIE ='$serie' AND (ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12)";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $ser = $row2['SERIE'];
                
                $sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $area = $row2['ID_AREA'];/* HAY QUE TRAER EL USUARIO POR TABLA INTERMEDIA */
                
                if($tipop == 5){
                    $tip = 'TICKEADORA';
                }
                elseif($tipop == 6){
                    $tip = 'SCANNER';
                }
                elseif($tipop == 9){
                    $tip = 'CAMARA';
                }
                elseif($tipop == 11){
                    $tip = 'TELÉFONO ANALÓGICO';
                }
                elseif($tipop == 12){
                    $tip = 'TELÉFONO IP';
                }
                
                if($serieg == $serg OR $serie == $ser){ 
                    header("Location: agregarotrosperifericos.php?no");
                    exit;
                }
                else{
                    mysqli_query($datos_base, "INSERT INTO periferico VALUES (DEFAULT, '$tipop', DEFAULT, '$serieg', '$marca', '$serie', 3, '$obs', '$tip', DEFAULT, 'NO', DEFAULT, '$prov', '$fac', '$area', '$usu', '$gar', '$est', '$modelo')");/* NO VA A FUNCIONAR PORQUE FALTA LOGICA RELACIONADA AL EQUIPO , USAURIO NO ESTA EN LA TABLA */
                
                    /* GUARDANDO PARA LOS MOVIMIENTOS */
                    $pe=mysqli_query($datos_base, "SELECT MAX(ID_PERI) AS id FROM periferico");
                    if ($row = mysqli_fetch_row($pe)) {
                        $per = trim($row[0]);
                        }
                
                    mysqli_query($datos_base, "INSERT INTO movimientosperi VALUES (DEFAULT, '$fechaActual', '$per', '$area', '$usu', '$est')");/* HAY QUE CONSULTAR AL USUARIO NUEVAMENTE POR TABLA INTERMEDIA */
                
                    /* BUSCO EL MODELO PARA AGREGAR A agregados.php */
                    $sqli = "SELECT MODELO FROM modelo WHERE ID_MODELO = '$modelo' AND ID_MODELO ='$modelo'";
                    $resultado2 = $datos_base->query($sqli);
                    $row2 = $resultado2->fetch_assoc();
                    $modeloParaAgregado = $row2['MODELO'];

                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'OTROS PERIFÉRICOS', 'AGREGADO',  '$modeloParaAgregado', '', '$fechaActual', '$horaActual', '$resolutorActivo')");

                    header("Location: agregarotrosperifericos.php?ok");
                    exit;
                }
                break;


            /* ----------------- AGREGAR EQUIPO: agregarequipo.php----------------- */
            case 'agregarEquipo':
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
                $procedencia = $_POST['procedencia'];
                $obs = $_POST['obs'];
                
                /* ////////////////////////// */
                
                /* FECHAS */
                if(isset($_POST['fec1'])){$fec1 = $_POST['fec1'];$fec1 = date("Y-m-d", strtotime($fec1));}else{$fec1 = "2001-01-01";}
                if(isset($_POST['fec2'])){$fec2 = $_POST['fec2'];$fec2 = date("Y-m-d", strtotime($fec2));}else{$fec2 = "2001-01-01";}
                if(isset($_POST['fec3'])){$fec3 = $_POST['fec3'];$fec3 = date("Y-m-d", strtotime($fec3));}else{$fec3 = "2001-01-01";}
                if(isset($_POST['fec4'])){$fec4 = $_POST['fec4'];$fec4 = date("Y-m-d", strtotime($fec4));}else{$fec4 = "2001-01-01";}
                
                if(isset($_POST['dfec1'])){$dfec1 = $_POST['dfec1'];$dfec1 = date("Y-m-d", strtotime($dfec1));}else{$dfec1 = "2001-01-01";}
                if(isset($_POST['dfec2'])){$dfec2 = $_POST['dfec2'];$dfec2 = date("Y-m-d", strtotime($dfec2));}else{$dfec2 = "2001-01-01";}
                if(isset($_POST['dfec3'])){$dfec3 = $_POST['dfec3'];$dfec3 = date("Y-m-d", strtotime($dfec3));}else{$dfec3 = "2001-01-01";}
                if(isset($_POST['dfec4'])){$dfec4 = $_POST['dfec4'];$dfec4 = date("Y-m-d", strtotime($dfec4));}else{$dfec4 = "2001-01-01";}
                
                
                
                if(isset($_POST['fpla'])){$fpla = $_POST['fpla'];$fpla = date("Y-m-d", strtotime($fpla));}else{$fpla = "2001-01-01";}
                if(isset($_POST['fmic'])){$fmic = $_POST['fmic'];$fmic = date("Y-m-d", strtotime($fmic));}else{$fmic = "2001-01-01";}
                if(isset($_POST['pvfec'])){$pvfec = $_POST['pvfec'];$pvfec = date("Y-m-d", strtotime($pvfec));}else{$pvfec = "2001-01-01";}
                if(isset($_POST['pvfec1'])){$pvfec1 = $_POST['pvfec1'];$pvfec1 = date("Y-m-d", strtotime($pvfec1));}else{$pvfec1 = "2001-01-01";}
                
                
                /* ////////////////////////// */
                /*SI AMBOS CAMPOS ESTAN REPETIDOS*/
                $sqli = "SELECT * FROM inventario WHERE SERIEG = '$serieg'";
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $serg = $row2['SERIEG'];
                
                $sqli = "SELECT * FROM inventario WHERE SERIALN ='$serialn'"; 
                $resultado2 = $datos_base->query($sqli);
                $row2 = $resultado2->fetch_assoc();
                $ser = $row2['SERIALN'];
                
                if(isset($_POST['area'])){
                    $area = $_POST['area'];
                }else{
                    $sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
                    $resultado2 = $datos_base->query($sqli);
                    $row2 = $resultado2->fetch_assoc();
                    $area = $row2['ID_AREA'];
                }
                /* USUARIO 277 ES SIN ASIGNAR */
                /* ////////////////////////// */
                /*SI LOS CAMPOS ESTAN VACIOS*/
                if($mac == ""){$mac = "-";}
                if($ip == ""){$ip = "-";}
                if($fac == ""){$fac = "-";}
                if($gar == ""){$gar = "-";}
                if($obs == ""){$obs = "-";}
                
                if(isset($_POST['mem1'])){$mem1 = $_POST['mem1'];}else{$mem1 = 9;}/* if($mem1 == 0){$mem1 = 9;} */
                if(isset($_POST['tmem1'])){$tmem1 = $_POST['tmem1'];}else{$tmem1 = 5;}/* if($tmem1 == 0){$tmem1 = 5;} */
                if(isset($_POST['prov1'])){$prov1 = $_POST['prov1'];}else{$prov1 = 7;}/* if($prov1 == 0){$prov1 = 7;} */
                if(isset($_POST['fact1'])){$fact1 = $_POST['fact1'];}else{$fact1 = "-";}/* if($fact1 == ""){$fact1 = "-";} */
                if(isset($_POST['marc1'])){$marc1 = $_POST['marc1'];}else{$marc1 = 1;}/* if($marc1 == 0){$marc1 = 1;} */
                if(isset($_POST['gar1'])){$gar1 = $_POST['gar1'];}else{$gar1 = "-";}/* if($gar1 == ""){$gar1 = "-";} */
                if(isset($_POST['pvel1'])){$pvel1 = $_POST['pvel1'];}else{$pvel1 = 1;}
                
                if(isset($_POST['mem2'])){$mem2 = $_POST['mem2'];}else{$mem2 = 9;}/* if($mem1 == 0){$mem1 = 9;} */
                if(isset($_POST['tmem2'])){$tmem2 = $_POST['tmem2'];}else{$tmem2 = 5;}/* if($tmem1 == 0){$tmem1 = 5;} */
                if(isset($_POST['prov2'])){$prov2 = $_POST['prov2'];}else{$prov2 = 7;}/* if($prov1 == 0){$prov1 = 7;} */
                if(isset($_POST['fact2'])){$fact2 = $_POST['fact2'];}else{$fact2 = "-";}/* if($fact1 == ""){$fact1 = "-";} */
                if(isset($_POST['marc2'])){$marc2 = $_POST['marc2'];}else{$marc2 = 1;}/* if($marc1 == 0){$marc1 = 1;} */
                if(isset($_POST['gar2'])){$gar2 = $_POST['gar2'];}else{$gar2 = "-";}/* if($gar1 == ""){$gar1 = "-";} */
                if(isset($_POST['pvel2'])){$pvel2 = $_POST['pvel2'];}else{$pvel2 = 1;}
                
                if(isset($_POST['mem3'])){$mem3 = $_POST['mem3'];}else{$mem3 = 9;}/* if($mem1 == 0){$mem1 = 9;} */
                if(isset($_POST['tmem3'])){$tmem3 = $_POST['tmem3'];}else{$tmem3 = 5;}/* if($tmem1 == 0){$tmem1 = 5;} */
                if(isset($_POST['prov3'])){$prov3 = $_POST['prov3'];}else{$prov3 = 7;}/* if($prov1 == 0){$prov1 = 7;} */
                if(isset($_POST['fact3'])){$fact3 = $_POST['fact3'];}else{$fact3 = "-";}/* if($fact1 == ""){$fact1 = "-";} */
                if(isset($_POST['marc3'])){$marc3 = $_POST['marc3'];}else{$marc3 = 1;}/* if($marc1 == 0){$marc1 = 1;} */
                if(isset($_POST['gar3'])){$gar3 = $_POST['gar3'];}else{$gar3 = "-";}/* if($gar1 == ""){$gar1 = "-";} */
                if(isset($_POST['pvel3'])){$pvel3 = $_POST['pvel3'];}else{$pvel3 = 1;}
                
                if(isset($_POST['mem4'])){$mem4 = $_POST['mem4'];}else{$mem4 = 9;}/* if($mem1 == 0){$mem1 = 9;} */
                if(isset($_POST['tmem4'])){$tmem4 = $_POST['tmem4'];}else{$tmem4 = 5;}/* if($tmem1 == 0){$tmem1 = 5;} */
                if(isset($_POST['prov4'])){$prov4 = $_POST['prov4'];}else{$prov4 = 7;}/* if($prov1 == 0){$prov1 = 7;} */
                if(isset($_POST['fact4'])){$fact4 = $_POST['fact4'];}else{$fact4 = "-";}/* if($fact1 == ""){$fact1 = "-";} */
                if(isset($_POST['marc4'])){$marc4 = $_POST['marc4'];}else{$marc4 = 1;}/* if($marc1 == 0){$marc1 = 1;} */
                if(isset($_POST['gar4'])){$gar4 = $_POST['gar4'];}else{$gar4 = "-";}/* if($gar1 == ""){$gar1 = "-";} */
                if(isset($_POST['pvel4'])){$pvel4 = $_POST['pvel4'];}else{$pvel4 = 1;}
                
                
                
                
                /* DISCOS */
                if(isset($_POST['disc1'])){$disc1 = $_POST['disc1'];}else{$disc1 = 15;}/* if($disc1 == 0){$disc1 = 15;} */
                if(isset($_POST['tdisc1'])){$tdisc1 = $_POST['tdisc1'];}else{$tdisc1 = 4;}/* if($tdisc1 == 0){$tdisc1 = 4;} */
                if(isset($_POST['dprov1'])){$dprov1 = $_POST['dprov1'];}else{$dprov1 = 7;}/* if($dprov1 == 0){$dprov1 = 7;} */
                if(isset($_POST['dfact1'])){$dfact1 = $_POST['dfact1'];}else{$dfact1 = "-";}/* if($dfact1 == ""){$dfact1 = "-";} */
                if(isset($_POST['dmod1'])){$dmod1 = $_POST['dmod1'];}else{$dmod1 = 197;}/* if($dmod1 == 0){$dmod1 = 197;} */
                if(isset($_POST['dgar1'])){$dgar1 = $_POST['dgar1'];}else{$dgar1 = "-";}/* if($dgar1 == ""){$dgar1 = "-";} */
                
                if(isset($_POST['disc2'])){$disc2 = $_POST['disc2'];}else{$disc2 = 15;}/* if($disc1 == 0){$disc1 = 15;} */
                if(isset($_POST['tdisc2'])){$tdisc2 = $_POST['tdisc2'];}else{$tdisc2 = 4;}/* if($tdisc1 == 0){$tdisc1 = 4;} */
                if(isset($_POST['dprov2'])){$dprov2 = $_POST['dprov2'];}else{$dprov2 = 7;}/* if($dprov1 == 0){$dprov1 = 7;} */
                if(isset($_POST['dfact2'])){$dfact2 = $_POST['dfact2'];}else{$dfact2 = "-";}/* if($dfact1 == ""){$dfact1 = "-";} */
                if(isset($_POST['dmod2'])){$dmod2 = $_POST['dmod2'];}else{$dmod2 = 197;}/* if($dmod1 == 0){$dmod1 = 197;} */
                if(isset($_POST['dgar2'])){$dgar2 = $_POST['dgar2'];}else{$dgar2 = "-";}/* if($dgar1 == ""){$dgar1 = "-";} */
                
                if(isset($_POST['disc3'])){$disc3 = $_POST['disc3'];}else{$disc3 = 15;}/* if($disc1 == 0){$disc1 = 15;} */
                if(isset($_POST['tdisc3'])){$tdisc3 = $_POST['tdisc3'];}else{$tdisc3 = 4;}/* if($tdisc1 == 0){$tdisc1 = 4;} */
                if(isset($_POST['dprov3'])){$dprov3 = $_POST['dprov3'];}else{$dprov3 = 7;}/* if($dprov1 == 0){$dprov1 = 7;} */
                if(isset($_POST['dfact3'])){$dfact3 = $_POST['dfact3'];}else{$dfact3 = "-";}/* if($dfact1 == ""){$dfact1 = "-";} */
                if(isset($_POST['dmod3'])){$dmod3 = $_POST['dmod3'];}else{$dmod3 = 197;}/* if($dmod1 == 0){$dmod1 = 197;} */
                if(isset($_POST['dgar3'])){$dgar3 = $_POST['dgar3'];}else{$dgar3 = "-";}/* if($dgar1 == ""){$dgar1 = "-";} */
                
                if(isset($_POST['disc4'])){$disc4 = $_POST['disc4'];}else{$disc4 = 15;}/* if($disc1 == 0){$disc1 = 15;} */
                if(isset($_POST['tdisc4'])){$tdisc4 = $_POST['tdisc4'];}else{$tdisc4 = 4;}/* if($tdisc1 == 0){$tdisc1 = 4;} */
                if(isset($_POST['dprov4'])){$dprov4 = $_POST['dprov4'];}else{$dprov4 = 7;}/* if($dprov1 == 0){$dprov1 = 7;} */
                if(isset($_POST['dfact4'])){$dfact4 = $_POST['dfact4'];}else{$dfact4 = "-";}/* if($dfact1 == ""){$dfact1 = "-";} */
                if(isset($_POST['dmod4'])){$dmod4 = $_POST['dmod4'];}else{$dmod4 = 197;}/* if($dmod1 == 0){$dmod1 = 197;} */
                if(isset($_POST['dgar4'])){$dgar4 = $_POST['dgar4'];}else{$dgar4 = "-";}/* if($dgar1 == ""){$dgar1 = "-";} */
                
                
                /* PLACA MADRE */
                if(isset($_POST['ppla'])){$ppla = $_POST['ppla'];}else{$ppla = 96;}/* $ppla = $_POST['ppla']; */
                if(isset($_POST['prpla'])){$prpla = $_POST['prpla'];}else{$prpla = 7;}/* if($prpla == 0){$prpla = 7;} */
                if(isset($_POST['fapla'])){$fapla = $_POST['fapla'];}else{$fapla = "-";}/* if($fapla == ""){$fapla = "-";} */
                if(isset($_POST['gpla'])){$gpla = $_POST['gpla'];}else{$gpla = "-";}/* if($gpla == ""){$gpla = "-";} */
                if(isset($_POST['nropla'])){$nropla = $_POST['nropla'];}else{$nropla = "-";}/* $nropla = $_POST['nropla'];*/
                
                /* MICRO */
                
                if(isset($_POST['mmic'])){$mmic = $_POST['mmic'];}else{$mmic = 80;}/* $mmic = $_POST['mmic']; */
                if(isset($_POST['nromic'])){$nromic = $_POST['nromic'];}else{$nromic = "-";}/* $nromic = $_POST['nromic']; */
                if(isset($_POST['pmic'])){$pmic = $_POST['pmic'];}else{$pmic = 7;}/* if($pmic == 0){$pmic = 7;} */
                if(isset($_POST['facmic'])){$facmic = $_POST['facmic'];}else{$facmic = "-";}/*if($facmic == ""){$facmic = "-";}*/
                if(isset($_POST['gmic'])){$gmic = $_POST['gmic'];}else{$gmic = "-";}/* if($gmic == ""){$gmic = "-";}*/
                
                
                /* PLACA DE VIDEO */
                
                if(isset($_POST['pvmem'])){$pvmem = $_POST['pvmem'];}else{$pvmem = 9;}/*if($pvmem == ""){$pvmem = 9;}*/
                if(isset($_POST['pvprov'])){$pvprov = $_POST['pvprov'];}else{$pvprov = 7;}/* if($pvprov == ""){$pvprov = "7";} */
                if(isset($_POST['pvfact'])){$pvfact = $_POST['pvfact'];}else{$pvfact = "-";}/* if($pvfact == ""){$pvfact = "-";} */
                if(isset($_POST['pvnserie'])){$pvnserie = $_POST['pvnserie'];}else{$pvnserie = "-";}/*if($pvnserie == ""){$pvnserie = "-";}*/
                if(isset($_POST['pvgar'])){$pvgar = $_POST['pvgar'];}else{$pvgar = "-";}/*if($pvgar == ""){$pvgar = "-";}*/
                
                
                if(isset($_POST['pvmem1'])){$pvmem1 = $_POST['pvmem1'];}else{$pvmem1 = 9;}
                if(isset($_POST['pvprov1'])){$pvprov1 = $_POST['pvprov1'];}else{$pvprov1 = 7;}
                if(isset($_POST['pvfact1'])){$pvfact1 = $_POST['pvfact1'];}else{$pvfact1 = "-";}
                if(isset($_POST['pvnserie1'])){$pvnserie1 = $_POST['pvnserie1'];}else{$pvnserie1 = "-";}
                if(isset($_POST['pvgar1'])){$pvgar1 = $_POST['pvgar1'];}else{$pvgar1 = "-";}
                
                
                /* ////////////////////////// */
                if($serieg == $serg){ 
                    header("Location: ../consulta/inventario.php?no");
                }
                else{
                    mysqli_query($datos_base, "INSERT INTO inventario VALUES (DEFAULT, '$area', '$serialn', '$serieg', '$marca', '$so', '$est', '$obs', '$prov', '$fac', '$masterizacion', '$mac', '$reserva', '$ip', '$red', '$tippc', '$gar', '$procedencia')");
                    /* FALTA ACOMODAR LA PARTE DE USUARIO, NO ESTA MAS */
                
                    $tic=mysqli_query($datos_base, "SELECT MAX(ID_WS) FROM inventario");
                        if ($row = mysqli_fetch_row($tic)) {
                            $idws = trim($row[0]);
                            }
                    /* PLACA MADRE */
                    mysqli_query($datos_base, "INSERT INTO placamws VALUES ('$idws', '$ppla', '$prpla', '$gpla', '$fapla', '$fpla', '$nropla')");
                
                    /* MICRO */
                    mysqli_query($datos_base, "INSERT INTO microws VALUES ('$idws', '$mmic', '$pmic', '$facmic', '$gmic', '$fmic', '$nromic')");
                
                    /* PVIDEO */
                    mysqli_query($datos_base, "INSERT INTO pvideows VALUES ('$idws', '$pvmem', '$pvnserie', '$pvprov', '$pvfact', '$pvfec', '$pvgar', 1)");
                
                    mysqli_query($datos_base, "INSERT INTO pvideows VALUES ('$idws', '$pvmem1', '$pvnserie1', '$pvprov1', '$pvfact1', '$pvfec1', '$pvgar1', 2)");
                
                    /* DISCO */
                    mysqli_query($datos_base, "INSERT INTO discows VALUES ('$idws', '$disc1', '$dprov1', '$dfact1', '$dfec1','$dgar1', '$tdisc1', 1, '$dmod1')");
                
                    mysqli_query($datos_base, "INSERT INTO discows VALUES ('$idws', '$disc2', '$dprov2', '$dfact2', '$dfec2', '$dgar2', '$tdisc2', 2, '$dmod2')");
                
                    mysqli_query($datos_base, "INSERT INTO discows VALUES ('$idws', '$disc3', '$dprov3', '$dfact3', '$dfec3', '$dgar3', '$tdisc3', 3, '$dmod3')");
                
                    mysqli_query($datos_base, "INSERT INTO discows VALUES ('$idws', '$disc4', '$dprov4', '$dfact4', '$dfec4','$dgar4', '$tdisc4', 4, '$dmod4')");
                
                
                    /* MEMORIA */
                    mysqli_query($datos_base, "INSERT INTO wsmem VALUES ('$idws', '$mem1', '$tmem1', '$prov1', '$fact1', '$fec1', '$marc1', '$gar1', 1, '$pvel1')");
                    
                    mysqli_query($datos_base, "INSERT INTO wsmem VALUES ('$idws', '$mem2', '$tmem2', '$prov2', '$fact2', '$fec2', '$marc2', '$gar2', 2, '$pvel2')");
                
                    mysqli_query($datos_base, "INSERT INTO wsmem VALUES ('$idws', '$mem3', '$tmem3', '$prov3', '$fact3', '$fec3', '$marc3', '$gar3', 3, '$pvel3')");
                
                    mysqli_query($datos_base, "INSERT INTO wsmem VALUES ('$idws', '$mem4', '$tmem4', '$prov4', '$fact4', '$fec4', '$marc4', '$gar4', 4, '$pvel4')");
                
                
                    mysqli_query($datos_base, "INSERT INTO wsusuario VALUES (DEFAULT, '$idws', '$usu', '$fechaActual', '0000-00-00')");
                
                    /* GUARDANDO PARA LOS MOVIMIENTOS */
                    mysqli_query($datos_base, "INSERT INTO movimientos VALUES (DEFAULT, '$fechaActual', '$idws', '$usu', '$area', '$est', '$marca', '$so', '$masterizacion', '$mac', '$reserva', '$ip', '$red')");
                
                    /* GUARDANDO PARA LAS MEJORAS */
                    mysqli_query($datos_base, "INSERT INTO mejoras VALUES (DEFAULT, '$fechaActual', '$idws', '$ppla', '$mmic', '$pvmem', '$pvmem1', '$mem1', '$tmem1', '$pvel1', '$mem2', '$tmem2', '$pvel2', '$mem3', '$tmem3', '$pvel3', '$mem4', '$tmem4', '$pvel4', '$disc1', '$tdisc1', '$disc2', '$tdisc2', '$disc3', '$tdisc3', '$disc4', '$tdisc4')");

                    mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'EQUIPO', 'AGREGADO',  '$serieg', '', '$fechaActual', '$horaActual', '$resolutorActivo')");
                
                    header("Location: ../consulta/inventario.php?ok");
                    exit;
                }
                break;

        default:
            echo "Acción no reconocida.";
            break;
    }
} else {
    echo "No se recibió ninguna acción.";
}


/* CIERRO CONEXIÓN */
mysqli_close($datos_base);
?>
