<?php
session_start();
include('../particular/conexion.php');

/* ------------------------------------------ */
/* --------------------MODIFICAR PLAN: modPlanes.php --------------------- */
/* ------------------------------------------ */
if(isset($_POST['btnModPlanes'])){
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
}

/* ------------------------------------------ */
/* ------------------MODIFICAR USUARIO: modusuario.php------------------------ */
/* ------------------------------------------ */
if(isset($_POST['modUsuario'])){
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
      }
    else
      {
        mysqli_query($datos_base, "UPDATE usuarios SET NOMBRE = '$nombre', CUIL = '$cuil', ID_AREA = '$are', PISO = '$pis', INTERNO = '$int', CORREO = '$cor', CORREO_PERSONAL = '$corp', TELEFONO_PERSONAL = '$tel', ID_TURNO = '$tur', ACTIVO = '$act', OBSERVACION = '$obs' WHERE ID_USUARIO = '$id'");
        header("Location: abmusuario.php?ok");
      }
      mysqli_close($datos_base);
}





/* ------------------------------------------ */
/* ------------------ MODIFICAR ÁREA: modarea.php------------------------ */
/* ------------------------------------------ */
if(isset($_POST['modArea'])){
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
    
    /*SI AMBOS CAMPOS ESTAN REPETIDOS*/
    $sqli = "SELECT * FROM area WHERE AREA = '$area' AND ID_REPA ='$repa' AND ID_AREA != '$id'";
    $resultado2 = $datos_base->query($sqli);
    $row2 = $resultado2->fetch_assoc();
    $are = $row2['AREA'];
    $rep = $row2['ID_REPA'];
    
    if($area == $are AND $repa == $rep){ 
        header("Location: abmarea.php?no");
    }
    else{
        mysqli_query($datos_base, "UPDATE area SET AREA = '$area', ID_REPA = '$repa', ACTIVO = '$est', OBSERVACION = '$obs' WHERE ID_AREA = '$id'");
        header("Location: abmarea.php?ok");
    }
    mysqli_close($datos_base);
}





/* ------------------------------------------ */
/* ------------------ MODIFICAR TIPIFICACION: modtipificacion.php------------------------ */
/* ------------------------------------------ */
if(isset($_POST['modTipificacion'])){
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
    }
    else{
      mysqli_query($datos_base, "UPDATE tipificacion SET TIPIFICACION = '$tipi' WHERE ID_TIPIFICACION = '$id'"); 
      header("Location: abmtipificacion.php?ok");
    }
}





/* ------------------------------------------ */
/* ------------------ MODIFICAR RESOLUTOR: modresolutor.php ------------------------ */
/* ------------------------------------------ */
if(isset($_POST['modResolutor'])){
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
    }
  else{
      mysqli_query($datos_base, "UPDATE resolutor SET RESOLUTOR = '$nom', ID_TIPO_RESOLUTOR = '$tipo', CUIL = '$cuil', CORREO = '$cor', TELEFONO = '$tel', ID_PERFIL = '$perfil' WHERE ID_RESOLUTOR = '$id'");
      header("Location: abmresolutor.php?ok");
    }
  mysqli_close($datos_base);
}





/* ------------------------------------------ */
/* ------------------ MODIFICAR MARCA: modmarca.php------------------------ */
/* ------------------------------------------ */
if(isset($_POST['modMarca'])){
  $id = $_POST['id'] ?? 0;
  $marca = $_POST['marca'] ?? '';
  
  /* SI UNO DE LOS CAMPOS ESTA REPETIDO */
  $sql = "SELECT * FROM marcas WHERE MARCA = '$marca' AND ID_MARCA != '$id'";
  $resultado = $datos_base->query($sql);
  $row = $resultado->fetch_assoc();
  $ma = $row['MARCA'];
    
  
  if($marca == $ma){
    header("Location: abmmarcas.php?no");
  }
  else{
    mysqli_query($datos_base, "UPDATE marcas SET MARCA = '$marca' WHERE ID_MARCA = '$id'"); 
    header("Location: abmmarcas.php?ok");
  }
  mysqli_close($datos_base);	
}





/* ------------------------------------------ */
/* ------------------ MODIFICAR MICRO: modmicro.php------------------------ */
/* ------------------------------------------ */
if(isset($_POST['modMicro'])){
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
  }
  else{
      mysqli_query($datos_base, "UPDATE micro SET MICRO = '$micro', ID_MARCA = '$marca' WHERE ID_MICRO = '$id'"); 
      header("Location: abmmicro.php?ok");
  }
  mysqli_close($datos_base);
}




/* ------------------------------------------ */
/* ------------------ MODIFICAR MODELO: modmodelo.php------------------------ */
/* ------------------------------------------ */
if(isset($_POST['modModelo'])){
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
  }
  elseif($modelo == $mo){
      mysqli_query($datos_base, "UPDATE modelo SET MODELO = '$modelo', ID_TIPOP = '$tipo', ID_MARCA = '$marca' WHERE ID_MODELO = '$id'"); 
      header("Location: abmmodelos.php?repeat");
  }
  else{
      mysqli_query($datos_base, "UPDATE modelo SET MODELO ='$modelo', ID_TIPOP = '$tipo', ID_MARCA = '$marca' WHERE ID_MODELO = '$id'"); 
      header("Location: abmmodelos.php?ok");
  }
  mysqli_close($datos_base);
}





/* ------------------------------------------ */
/* ------------------ MODIFICAR PLACA DE VIDEO: modplacav.php------------------------ */
/* ------------------------------------------ */
if(isset($_POST['modPlacav'])){
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
      mysqli_close($datos_base);
  }else{
      mysqli_query($datos_base, "UPDATE pvideo SET ID_MEMORIA = '$memoria', ID_MODELO ='$modelo', ID_TIPOMEM = '$tipo' WHERE ID_PVIDEO = '$id'");
      header("Location: abmplacav.php?mod");
      mysqli_close($datos_base);
  }
}





/* ------------------------------------------ */
/* ------------------ MODIFICAR PLACA MADRE: modPLacam.php------------------------ */
/* ------------------------------------------ */
if(isset($_POST['modPLacam'])){
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
  }
  else{
      mysqli_query($datos_base, "UPDATE placam SET PLACAM = '$placam', ID_MARCA = '$marca' WHERE ID_PLACAM = '$id'");  
      header("Location: abmplacamadre.php?ok");
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