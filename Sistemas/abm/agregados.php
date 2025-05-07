<?php
session_start();
include('../particular/conexion.php');

/* -----------------PLANES: agregarPlan.php----------------- */
if(isset($_POST['agregarPlan'])){
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
    }else{
        mysqli_query($datos_base, "INSERT INTO nombreplan VALUES (DEFAULT, '$nombrePlan', '$idPlan', '$proveedor', '$monto')");
        header("Location: ./abmPlanesCelulares.php?ok");
    }
    mysqli_close($datos_base);
}





/* --------------------------------------------------------- */
/* ----------------- AGREGAR USUARIO: agregarUsuario.php----------------- */
/* --------------------------------------------------------- */
if(isset($_POST['agregarUsuario'])){
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
}





/* --------------------------------------------------------- */
/* ----------------- AGREGAR ÁREA #: agregararea.php----------------- */
/* --------------------------------------------------------- */
if(isset($_POST['agregarArea'])){
    date_default_timezone_set('America/Argentina/Buenos_Aires'); // Configura la zona horaria de Argentina
    $hora_actual = date("H:i:s"); // Formato de hora: HH:mm:ss
    $fecha = date('Y-m-d');
    
    /*BUSCO EL RESOLUTOR PARA agregados*/
    $cuil = $_SESSION['cuil'];
    
    $sqli = "SELECT RESOLUTOR FROM resolutor WHERE CUIL = '$cuil'";
    $resultado2 = $datos_base->query($sqli);
    $row2 = $resultado2->fetch_assoc();
    $resolutorActivo = $row2['RESOLUTOR'];
    
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
    }
    else{
        mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'ÁREA', '$area', '$fecha', '$hora_actual', '$resolutorActivo')");
    
        mysqli_query($datos_base, "INSERT INTO area VALUES (DEFAULT, '$area', '$repa', '$est', '$obs')");
        header("Location: agregararea.php?ok");
    }
    mysqli_close($datos_base);
}





/* --------------------------------------------------------- */
/* ----------------- AGREGAR TIPIFIACION: agregartipificacion.php----------------- */
/* --------------------------------------------------------- */
if(isset($_POST['agregarTipificacion'])){
    date_default_timezone_set('America/Argentina/Buenos_Aires'); // Configura la zona horaria de Argentina
    $hora_actual = date("H:i:s"); // Formato de hora: HH:mm:ss
    
    /*BUSCO EL RESOLUTOR PARA agregados*/
    $cuil = $_SESSION['cuil'];
    
    $sqli = "SELECT RESOLUTOR FROM resolutor WHERE CUIL = '$cuil'";
    $resultado2 = $datos_base->query($sqli);
    $row2 = $resultado2->fetch_assoc();
    $resolutorActivo = $row2['RESOLUTOR'];
    
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
    
    $fecha = date('Y-m-d');
    
    if($contador > 0){
      header("Location: agregartipificacion.php?no");
    }
    else{
      mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'TIPIFICACIÓN', '$tipi', '$fecha', '$hora_actual', '$resolutorActivo')");
    
      mysqli_query($datos_base, "INSERT INTO tipificacion VALUES (DEFAULT, '$tipi')"); 
      header("Location: agregartipificacion.php?ok");
    }
    mysqli_close($datos_base);
}





/* --------------------------------------------------------- */
/* ----------------- AGREGAR RESOLUTOR: agregarresolutor.php----------------- */
/* --------------------------------------------------------- */
if(isset($_POST['agregarResolutor'])){
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
    
    $fecha = date('Y-m-d');
    
    if($cuil == $cui)
    {
        header("Location: agregarresolutor.php?no");
    }
    else if($resolutor == $res)
    {
        mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'RESOLUTOR', '$resolutor', '$fecha')");
    
        mysqli_query($datos_base, "INSERT INTO resolutor VALUES (DEFAULT, '$resolutor', '$tipo', '$cuil', '$correo', '$telefono', 1234,'$perfil')");
        header("Location: agregarresolutor.php?repeat");
    }
    else
    {
        mysqli_query($datos_base, "INSERT INTO agregado VALUES (DEFAULT, 'RESOLUTOR', '$resolutor', '$fecha')");
        
        mysqli_query($datos_base, "INSERT INTO resolutor VALUES (DEFAULT, '$resolutor', '$tipo', '$cuil', '$correo', '$telefono', 1234,'$rol')"); 
    header("Location: agregarresolutor.php?ok");
    }
    mysqli_close($datos_base);
}





/* --------------------------------------------------------- */
/* ----------------- AGREGAR MARCA: agregarmarca.php----------------- */
/* --------------------------------------------------------- */
if(isset($_POST['agregarMarca'])){
    $marca = $_POST['marca'] ?? '';

    /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
    $sql = "SELECT * FROM marcas WHERE MARCA = '$marca'";
    $resultado = $datos_base->query($sql);
    $row = $resultado->fetch_assoc();
    $ma = $row['MARCA'];
      
    
    if($marca == $ma){
      header("Location: agregarmarca.php?no");
    }
    else{
      mysqli_query($datos_base, "INSERT INTO marcas VALUES (DEFAULT, '$marca')"); 
      header("Location: agregarmarca.php?ok");
    }
    mysqli_close($datos_base);	
}





/* --------------------------------------------------------- */
/* ----------------- AGREGAR MICRO: agregarmicro.php----------------- */
/* --------------------------------------------------------- */
if(isset($_POST['agregarMicro'])){
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
        header("Location: agregarmicro.php?repeat");
    }
    else{
        mysqli_query($datos_base, "INSERT INTO micro VALUES (DEFAULT, '$micro', '$marca')"); 
        header("Location: agregarmicro.php?ok");
    }
    mysqli_close($datos_base);
}





/* --------------------------------------------------------- */
/* ----------------- AGREGAR MODELO: agregarmodelo.php----------------- */
/* --------------------------------------------------------- */
if(isset($_POST['agregarModelo'])){
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
    }
    elseif($modelo == $mo){
        mysqli_query($datos_base, "INSERT INTO modelo VALUES (DEFAULT, '$modelo', '$tipo', '$marca')"); 
        header("Location: agregarmodelo.php?repeat");
    }
    else{
        mysqli_query($datos_base, "INSERT INTO modelo VALUES (DEFAULT, '$modelo', '$tipo', '$marca')");
        header("Location: agregarmodelo.php?ok");
    }
    mysqli_close($datos_base);
}





/* --------------------------------------------------------- */
/* ----------------- AGREGAR PLACA DE VIDEO: agregarplacav.php----------------- */
/* --------------------------------------------------------- */
if(isset($_POST['agregarPlacav'])){
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
        mysqli_close($datos_base);
    }else{
        mysqli_query($datos_base, "INSERT INTO pvideo VALUES (DEFAULT, '$memoria', '$modelo', '$tipo')"); 
        header("Location: abmplacav.php?ok");
        mysqli_close($datos_base);
    }
}





/* --------------------------------------------------------- */
/* ----------------- AGREGAR PLACA MADRE: agregarplacam.php----------------- */
/* --------------------------------------------------------- */
if(isset($_POST['agregarPlacam'])){
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
    }
    elseif($placam == $pm){
        mysqli_query($datos_base, "INSERT INTO placam VALUES (DEFAULT, '$placam', '$marca')"); 
        header("Location: agregarplacam.php?repeat");
    }
    else{
        mysqli_query($datos_base, "INSERT INTO placam VALUES (DEFAULT, '$placam', '$marca')"); 
        header("Location: agregarplacam.php?ok");
    }
    mysqli_close($datos_base);
}





/* --------------------------------------------------------- */
/* ----------------- AGREGAR #: #.php----------------- */
/* --------------------------------------------------------- */
if(isset($_POST[''])){

}





/* --------------------------------------------------------- */
/* ----------------- AGREGAR #: #.php----------------- */
/* --------------------------------------------------------- */
if(isset($_POST[''])){

}
?>
