<?php
include('conexion.php');

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
/* ////////////////////////// */


/* MEMORIAS */
/* $mem1 = $_POST['mem1'];
$tmem1 = $_POST['tmem1'];
$prov1 = $_POST['prov1'];
$fact1 = $_POST['fact1'];
$marc1 = $_POST['marc1'];
$fec1 = $_POST['fec1'];
$gar1 = $_POST['gar1'];

$mem2 = $_POST['mem2'];
$tmem2 = $_POST['tmem2'];
$prov2 = $_POST['prov2'];
$fact2 = $_POST['fact2'];
$marc2 = $_POST['marc2'];
$fec2 = $_POST['fec2'];
$gar2 = $_POST['gar2'];

$mem3 = $_POST['mem3'];
$tmem3 = $_POST['tmem3'];
$prov3 = $_POST['prov3'];
$fact3 = $_POST['fact3'];
$marc3 = $_POST['marc3'];
$fec3 = $_POST['fec3'];
$gar3 = $_POST['gar3'];

$mem4 = $_POST['mem4'];
$tmem4 = $_POST['tmem4'];
$prov4 = $_POST['prov4'];
$fact4 = $_POST['fact4'];
$marc4 = $_POST['marc4'];
$fec4 = $_POST['fec4'];
$gar4 = $_POST['gar4']; */
/* ////////////////////////// */

/* DISCOS */
$disc1 = $_POST['disc1'];
$tdisc1 = $_POST['tdisc1'];
$dprov1 = $_POST['dprov1'];
$dfact1 = $_POST['dfact1'];
$dmod1 = $_POST['dmod1'];
$dfec1 = $_POST['dfec1'];
$dgar1 = $_POST['dgar1'];

$disc2 = $_POST['disc2'];
$tdisc2 = $_POST['tdisc2'];
$dprov2 = $_POST['dprov2'];
$dfact2 = $_POST['dfact2'];
$dmod2 = $_POST['dmod2'];
$dfec2 = $_POST['dfec2'];
$dgar2 = $_POST['dgar2'];

$disc3 = $_POST['disc3'];
$tdisc3 = $_POST['tdisc3'];
$dprov3 = $_POST['dprov3'];
$dfact3 = $_POST['dfact3'];
$dmod3 = $_POST['dmod3'];
$dfec3 = $_POST['dfec3'];
$dgar3 = $_POST['dgar3'];

$disc4 = $_POST['disc4'];
$tdisc4 = $_POST['tdisc4'];
$dprov4 = $_POST['dprov4'];
$dfact4 = $_POST['dfact4'];
$dmod4 = $_POST['dmod4'];
$dfec4 = $_POST['dfec4'];
$dgar4 = $_POST['dgar4'];


/* ////////////////////////// */

$ppla = $_POST['ppla'];
$prpla = $_POST['prpla'];
$fapla = $_POST['fapla'];
$fpla = $_POST['fpla'];
$gpla = $_POST['gpla'];
$nropla = $_POST['nropla'];

$mmic = $_POST['mmic'];
$pmic = $_POST['pmic'];
$facmic = $_POST['facmic'];
$fmic = $_POST['fmic'];
$gmic = $_POST['gmic'];
$nromic = $_POST['nromic'];

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

/* FECHAS */
$fec1 = date("Y-m-d", strtotime($fec1));
$fec2 = date("Y-m-d", strtotime($fec2));
$fec3 = date("Y-m-d", strtotime($fec3));
$fec4 = date("Y-m-d", strtotime($fec4));

$dfec1 = date("Y-m-d", strtotime($fec1));
$dfec2 = date("Y-m-d", strtotime($dfec2));
$dfec3 = date("Y-m-d", strtotime($dfec3));
$dfec4 = date("Y-m-d", strtotime($dfec4));

$fpla = date("Y-m-d", strtotime($fpla));
$fmic = date("Y-m-d", strtotime($fmic));
$pvfec = date("Y-m-d", strtotime($pvfec));
$pvfec1 = date("Y-m-d", strtotime($pvfec1));

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


if($disc1 == 0){$disc1 = 15;}
if($tdisc1 == 0){$tdisc1 = 4;}
if($dprov1 == 0){$dprov1 = 7;}
if($dfact1 == ""){$dfact1 = "-";}
if($dmod1 == 0){$dmod1 = 197;}
if($dgar1 == ""){$dgar1 = "-";}

if($disc2 == 0){$disc2 = 15;}
if($tdisc2 == 0){$tdisc2 = 4;}
if($dprov2 == 0){$dprov2 = 7;}
if($dfact2 == ""){$dfact2 = "-";}
if($dmod2 == 0){$dmod2 = 197;}
if($dgar2 == ""){$dgar2 = "-";}

if($disc3 == 0){$disc3 = 15;}
if($tdisc3 == 0){$tdisc3 = 4;}
if($dprov3 == 0){$dprov3 = 7;}
if($dfact3 == ""){$dfact3 = "-";}
if($dmod3 == 0){$dmod3 = 197;}
if($dgar3 == ""){$dgar3 = "-";}

if($disc4 == 0){$disc4 = 15;}
if($tdisc4 == 0){$tdisc4 = 4;}
if($dprov4 == 0){$dprov4 = 7;}
if($dfact4 == ""){$dfact4 = "-";}
if($dmod4 == 0){$dmod4 = 197;}
if($dgar4 == ""){$dgar4 = "-";}


if($prpla == 0){$prpla = 7;}
if($fapla == ""){$fapla = "-";}
if($gpla == ""){$gpla = "-";}


if($pmic == 0){$pmic = 7;}
if($facmic == ""){$facmic = "-";}
if($gmic == ""){$gmic = "-";}


if($pvprov == ""){$pvprov = "7";}
if($pvfact == ""){$pvfact = "-";}
if($pvnserie == ""){$pvnserie = "-";}
if($pvgar == ""){$pvgar = "-";}

if($pvprov1 == ""){$pvprov1 = "7";}
if($pvfact1 == ""){$pvfact1 = "-";}
if($pvnserie1 == ""){$pvnserie1 = "-";}
if($pvgar1 == ""){$pvgar1 = "-";}
/* ////////////////////////// */
if($serieg == $serg OR $serialn == $ser){ 
    header("Location: agregarequipo.php?no");
}
else{
    mysqli_query($datos_base, "INSERT INTO inventario VALUES (DEFAULT, '$area', '$serialn', '$serieg', '$marca', '$so', '$est', '$obs', '$prov', '$fac', '$masterizacion', '$mac', '$reserva', '$ip', '$red', '$tippc', '$usu', '$gar')");

    $tic=mysqli_query($datos_base, "SELECT MAX(ID_WS) FROM inventario");
		if ($row = mysqli_fetch_row($tic)) {
			$idws = trim($row[0]);
			}
    /* PLACA MADRE */
    mysqli_query($datos_base, "INSERT INTO placamws VALUES ('$idws', '$ppla', '$prpla', '$glpa', '$fapla', '$fpla', '$nropla')");

    /* MICRO */
    mysqli_query($datos_base, "INSERT INTO microws VALUES ('$idws', '$mmic', '$pmic', '$facmic', '$gmic', '$fmic', '$nromic')");

    /* PVIDEO */
    mysqli_query($datos_base, "INSERT INTO pvideows VALUES ('$idws', '$pvmem', '$pvnserie', '$pvprov', '$pvfact', '$pvfec', '$pvgar', 1)");

    mysqli_query($datos_base, "INSERT INTO pvideows VALUES ('$idws', '$pvmem1', '$pvnserie1', '$pvprov1', '$pvfact1', '$pvfec1', '$pvgar1', 2)");

    /* DISCO */
    mysqli_query($datos_base, "INSERT INTO discows VALUES ('$idws', '$disc1', '$dprov1', '$dfact1', '$dfec1','$dgar1', '$tdisc1', '$dmod1', 1)");

    mysqli_query($datos_base, "INSERT INTO discows VALUES ('$idws', '$disc2', '$dprov2', '$dfact2', '$dfec2', '$dgar2', '$tdisc2', '$dmod2', 2)");

    mysqli_query($datos_base, "INSERT INTO discows VALUES ('$idws', '$disc3', '$dprov3', '$dfact3', '$dfec3', '$dgar3', '$tdisc3', '$dmod3', 3)");

    mysqli_query($datos_base, "INSERT INTO discows VALUES ('$idws', '$disc4', '$dprov4', '$dfact4', '$dfec4','$dgar4', '$tdisc4', '$dmod4', 4)");


    /* MEMORIA */
    mysqli_query($datos_base, "INSERT INTO wsmem VALUES ('$idws', '$mem1', '$tmem1', '$prov1', '$fact1', '$fec1', '$marc1', '$gar1', 1, '$pvel1')");
    
    mysqli_query($datos_base, "INSERT INTO wsmem VALUES ('$idws', '$mem2', '$tmem2', '$prov2', '$fact2', '$fec2', '$marc2', '$gar2', 2, '$pvel2')");

    mysqli_query($datos_base, "INSERT INTO wsmem VALUES ('$idws', '$mem3', '$tmem3', '$prov3', '$fact3', '$fec3', '$marc3', '$gar3', 3, '$pvel3')");

    mysqli_query($datos_base, "INSERT INTO wsmem VALUES ('$idws', '$mem4', '$tmem4', '$prov4', '$fact4', '$fec4', '$marc4', '$gar4', 4, '$pvel4')");

    header("Location: agregarequipo.php?ok");
}
mysqli_close($datos_base);
?>