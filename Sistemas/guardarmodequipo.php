<?php
include('conexion.php');

$usu = $_POST['usu'];
$marca = $_POST['marca'];
$serieg = $_POST['serieg'];
$serialn = $_POST['serialn'];
$tippc = $_POST['tippc'];
$est = $_POST['est'];
$so = $_POST['so'];
$micro = $_POST['micro'];
$placam = $_POST['placam'];

$mem1 = $_POST['mem1'];
$tmem1 = $_POST['tmem1'];
$mem2 = $_POST['mem2'];
$tmem2 = $_POST['tmem2'];
$mem3 = $_POST['mem3'];
$tmem3 = $_POST['tmem3'];
$mem4 = $_POST['mem4'];
$tmem4 = $_POST['tmem4'];

$disc1 = $_POST['disc1'];
$tdisc1 = $_POST['tdisc1'];
$disc2 = $_POST['disc2'];
$tdisc2 = $_POST['tdisc2'];
$disc3 = $_POST['disc3'];
$tdisc3 = $_POST['tdisc3'];
$disc4 = $_POST['disc4'];
$tdisc4 = $_POST['tdisc4'];

$masterizacion = $_POST['masterizacion'];
$red = $_POST['red'];
$mac = $_POST['mac'];
$reserva = $_POST['reserva'];
$ip = $_POST['ip'];
$prov = $_POST['prov'];
$fac = $_POST['fac'];
$gar = $_POST['gar'];
$obs = $_POST['obs'];


/*SI AMBOS CAMPOS ESTAN REPETIDOS*/
$sqli = "SELECT * FROM inventario WHERE SERIEG = '$serieg'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$serg = $row2['SERIEG'];

$sqli = "SELECT * FROM inventario WHERE SERIALN ='$serialn'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$ser = $row2['SERIALN'];

$sqli = "SELECT ID_AREA FROM usuarios WHERE ID_USUARIO = '$usu'";
$resultado2 = $datos_base->query($sqli);
$row2 = $resultado2->fetch_assoc();
$area = $row2['ID_AREA'];

if($serieg == $serg OR $serialn == $ser){ 
    header("Location: agregarequipo.php?no");
}
else{
    mysqli_query($datos_base, "INSERT INTO inventario VALUES (DEFAULT, '$area', '$serialn', '$serieg', '$marca', DEFAULT, '$so', DEFAULT, '$est', '$obs', '$prov', '$fac', '$masterizacion', '$mac', '$reserva', '$ip', '$red', '$tippc', '$usu', '$gar', '$micro', '$placam')");

    $tic=mysqli_query($datos_base, "SELECT MAX(ID_WS) FROM inventario");
		if ($row = mysqli_fetch_row($tic)) {
			$idws = trim($row[0]);
			}

    mysqli_query($datos_base, "INSERT INTO discows VALUES ('$idws', '$disc1', DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, '$tdisc1', 1)");

    mysqli_query($datos_base, "INSERT INTO discows VALUES ('$idws', '$disc2', DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, '$tdisc2', 2)");

    mysqli_query($datos_base, "INSERT INTO discows VALUES ('$idws', '$disc3', DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, '$tdisc3', 3)");

    mysqli_query($datos_base, "INSERT INTO discows VALUES ('$idws', '$disc4', DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, '$tdisc4', 4)");


    mysqli_query($datos_base, "INSERT INTO wsmem VALUES ('$idws', '$mem1', '$tmem1', DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, 1)");
    
    mysqli_query($datos_base, "INSERT INTO wsmem VALUES ('$idws', '$mem2', '$tmem2', DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, 2)");

    mysqli_query($datos_base, "INSERT INTO wsmem VALUES ('$idws', '$mem3', '$tmem3', DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, 3)");

    mysqli_query($datos_base, "INSERT INTO wsmem VALUES ('$idws', '$mem4', '$tmem4', DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, 4)");

    header("Location: agregarequipo.php?ok");
}
mysqli_close($datos_base);
?>