<?php
include('conexion.php');

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

$fechaActual = date('Y-m-d');

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

if($micro == "600"){
    $sql5 = "SELECT ID_MICRO FROM inventario WHERE ID_WS = '$id'";
    $result5 = $datos_base->query($sql5);
    $row5 = $result5->fetch_assoc();
    $micro = $row5['ID_MICRO'];
}

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

/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
/* $sqli = "SELECT * FROM periferico WHERE SERIEG = '$serieg'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$serg = $row2['SERIEG']; */

$sqli = "SELECT * FROM inventario WHERE (SERIEG = '$serieg' AND ID_WS != '$id')";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$serg = $row2['SERIEG'];

if($usu == 277){
    if(($_POST['area']) != 1100){
        $area = $_POST['area'];
    }else{
        $sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
        $resultado2 = $datos_base->query($sqli);
        $row2 = $resultado2->fetch_assoc();
        $area = $row2['ID_AREA'];
    }
}else{
    $sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
    $resultado2 = $datos_base->query($sqli);
    $row2 = $resultado2->fetch_assoc();
    $area = $row2['ID_AREA'];
}





/* if(isset($_POST['area'])){
    $area = $_POST['area'];
}else{
    $sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
    $resultado2 = $datos_base->query($sqli);
    $row2 = $resultado2->fetch_assoc();
    $area = $row2['ID_AREA'];
} */

if($serieg == $serg){ 
    header("Location: abmequipos.php?no");
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



    mysqli_query($datos_base, "UPDATE inventario SET ID_AREA = '$area', SERIALN = '$serialn', SERIEG = '$serieg', ID_MARCA = '$marca', ID_ESTADOWS = '$est', ID_SO = '$so', OBSERVACION = '$obs', ID_PROVEEDOR = '$prov', FACTURA = '$fac', MASTERIZADA = '$masterizacion', MAC = '$mac', RIP = '$reserva', IP = '$ip', ID_RED = '$red', ID_TIPOWS = '$tippc', ID_USUARIO = '$usu' WHERE ID_WS = '$id'");


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


    header("Location: abmequipos.php?ok");
}
mysqli_close($datos_base);
?>