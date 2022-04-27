<?php 
session_start();
include('conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT CUIL, RESOLUTOR FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Inventario</title><meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloreporte.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>

		<style>
			#h2{
	              text-align: left;	
	              font-family: TrasandinaBook;
	              font-size: 16px;
	              color: #edf0f5;
	              margin-left: 10px;
	              margin-top: 5px;;
               
				}
			h4{
				text-align: center;	
				font-family: TrasandinaBook;
				font-size: 20px;
				text-transform: uppercase;
			}
        </style>
        <section id="reporte">
        <div id="mostrar_reporte" style="width: 97%; margin-left: 20px; display: block;">
			
		            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
	                    <a id="vlv"  href="tiporeporte.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
                        <div class="btn-group col-2" role="group" >
                              <button id="botonleft" type="button" class="btn btn-secondary" onclick="location.href='consulta.php'" ><i style=" margin-bottom:10px;"class='bi bi-house-door'></i></button>
                              <button id="botonright" type="button" class="btn btn-success" onClick="imprimir()" ><i class='bi bi-printer'></i></button>
                        </div>
		            </div>
		            <style type="text/css" media="print">
                              @media print {
                                             #vlv {display:none;}
                                             #pr, #botonleft, #botonright {display:none;}
		                                     #pr2 {display:none;}
											 #tit{ margin-top: 50px;}
											 #ind{ margin-top: 20px;}
											 #tablareporte{ margin-top: 20px;}
											 #accion{ display:none;}
											 #cabeceraacc{ display:none;}
											 h4{font-size:15px;}
							  }
                    </style>
		            <script>
                           function imprimir() {
            	             window.print();
                                      }
                    </script>
                    <h1 id="tit" style="font-size:45px;">REPORTE DE INVENTARIO<h1>
					<hr style='display: block;'>
					<br>
                    <?php
                    $contpctot=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=1");
                    $totalpc = mysqli_fetch_array($contpctot);
                    $contpcact=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=1 and ID_ESTADOWS=1");
                    $totalpcact = mysqli_fetch_array($contpcact);
                    $contpcstk=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=1 and ID_ESTADOWS=2");
                    $totalpcstk = mysqli_fetch_array($contpcstk);
                    $contpcbaja=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=1 and ID_ESTADOWS=3");
                    $totalpcbaja = mysqli_fetch_array($contpcbaja);
                    $contmonact=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='MONITOR' and ID_ESTADOWS=1");
					$totalmonact = mysqli_fetch_array($contmonact);
                    $contmonbaja=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='MONITOR' and ID_ESTADOWS!=1");
					$totalmonbaja = mysqli_fetch_array($contmonbaja);
                    $conttotalmon=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='MONITOR'");
					$totalmon = mysqli_fetch_array($conttotalmon);
                    $contnottot=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=2");
                    $totalnot = mysqli_fetch_array($contnottot);
                    $contnotact=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=2 and ID_ESTADOWS=1");
                    $totalnotact = mysqli_fetch_array($contnotact);
                    $contnotstk=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=2 and ID_ESTADOWS=2");
                    $totalnotstk = mysqli_fetch_array($contnotstk);
                    $contnotbaja=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=2 and ID_ESTADOWS=3");
                    $totalnotbaja = mysqli_fetch_array($contnotbaja);
                    ?>
                    <h1 id='titulo'>REPORTE DE EQUIPOS</h1>
                    <table width=97%>
						<thead style="border-bottom: solid 5px #073256 !important;">
						<tr>
						<th><p>PC EN USO</p></th>
                        <th><p>PC EN STOCK</p></th>
                        <th><p>PC BAJA</p></th>
                        <th><p>PC TOTAL</p></th>
                        <th><p>MONITORES EN USO</p></th>
                        <th><p>MONITORES EN STOCK</p></th>
                        <th><p>MONITORES TOTAL</p></th>
                        <th><p>NOTEBOOK EN USO</p></th>
                        <th><p>NOTEBOOK EN STOCK</p></th>
                        <th><p>NOTEBOOK BAJA</p></th>
                        <th><p>NOTEBOOK TOTAL</p></th>
						</tr>
						</thead>
                        <?php echo"
                        <tr style='border-bottom: solid 1px #073256;'>
                        <td><h4 style='text-align: center;	'>".$totalpcact['TOTAL']."</h4></td>
                        <td><h4 style='text-align: center;	'>".$totalpcbaja['TOTAL']."</h4></td>
						<td><h4 style='text-align: center;	'>".$totalpcstk['TOTAL']."</h4></td>
						<td><h4 style='text-align: center;	'>".$totalpc['TOTAL']."</h4></td>
                        <td><h4 style='text-align: center;	'>".$totalmonact['TOTAL']."</h4></td>
                        <td><h4 style='text-align: center;	'>".$totalmonbaja['TOTAL']."</h4></td>
                        <td><h4 style='text-align: center;	'>".$totalmon['TOTAL']."</h4></td>
                        <td><h4 style='text-align: center;	'>".$totalnotact['TOTAL']."</h4></td>
                        <td><h4 style='text-align: center;	'>".$totalnotbaja['TOTAL']."</h4></td>
						<td><h4 style='text-align: center;	'>".$totalnotstk['TOTAL']."</h4></td>
						<td><h4 style='text-align: center;	'>".$totalnot['TOTAL']."</h4></td>
							
						</tr></table>";	?>



<?php
                    $contimppropact=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='IMPRESORA' and ID_ESTADOWS=1 AND ID_PROCEDENCIA=3");
					$totalimppropact = mysqli_fetch_array($contimppropact);
                    $contimpbaja=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='IMPRESORA' and ID_ESTADOWS!=1 AND ID_PROCEDENCIA=3");
					$totalimpbaja = mysqli_fetch_array($contimpbaja);
                    $conttotalimpalq=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='IMPRESORA' AND ID_PROCEDENCIA=1");
					$totalimpalq = mysqli_fetch_array($conttotalimpalq);
                    $conttotalimp=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='IMPRESORA'");
					$totalimp = mysqli_fetch_array($conttotalimp);
                    $conttotalscact=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='SCANNER' AND ID_ESTADOWS=1");
					$totalscact = mysqli_fetch_array($conttotalscact);
                    $conttotalscbaja=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='SCANNER' AND ID_ESTADOWS!=1");
					$totalscbaja = mysqli_fetch_array($conttotalscbaja);
                    $conttotalsc=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='SCANNER'");
					$totalsc = mysqli_fetch_array($conttotalsc);
                    $conttotaltkact=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='TICKEADORA' AND ID_ESTADOWS=1");
					$totaltkact = mysqli_fetch_array($conttotaltkact);
                    $conttotaltkbaja=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='TICKEADORA' AND ID_ESTADOWS!=1");
					$totaltkbaja = mysqli_fetch_array($conttotaltkbaja);
                    $conttotaltk=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='TICKEADORA'");
					$totaltk = mysqli_fetch_array($conttotaltk);
                    ?>
                    <h1 id='titulo' style="margin-top:50px;">REPORTE DE PERIFERICOS</h1>
                    <table width=97%>
						<thead style="border-bottom: solid 5px #073256 !important;">
						<tr>
						<th><p>IMPRESORAS PROPIAS EN USO</p></th>
                        <th><p>IMPRESORAS PROPIAS EN STOCK</p></th>
                        <th><p>IMPRESORAS ALQUILADAS</p></th>
                        <th><p>IMPRESORAS TOTAL</p></th>
                        <th><p>SCANNERS EN USO</p></th>
                        <th><p>SCANNERS EN STOCK</p></th>
                        <th><p>SCANNERS TOTAL</p></th>
                        <th><p>TICKEADORA EN USO</p></th>
                        <th><p>TICKEADORA EN STOCK</p></th>
                        <th><p>TICKEADORA TOTAL</p></th>
						</tr>
						</thead>
                        <?php echo"
                        <tr style='border-bottom: solid 1px #073256;'>
                        <td><h4 style='text-align: center;	'>".$totalimppropact['TOTAL']."</h4></td>
                        <td><h4 style='text-align: center;	'>".$totalimpbaja['TOTAL']."</h4></td>
						<td><h4 style='text-align: center;	'>".$totalimpalq['TOTAL']."</h4></td>
						<td><h4 style='text-align: center;	'>".$totalimp['TOTAL']."</h4></td>
                        <td><h4 style='text-align: center;	'>".$totalscact['TOTAL']."</h4></td>
						<td><h4 style='text-align: center;	'>".$totalscbaja['TOTAL']."</h4></td>
						<td><h4 style='text-align: center;	'>".$totalsc['TOTAL']."</h4></td>
						<td><h4 style='text-align: center;	'>".$totaltkact['TOTAL']."</h4></td>
						<td><h4 style='text-align: center;	'>".$totaltkbaja['TOTAL']."</h4></td>
						<td><h4 style='text-align: center;	'>".$totaltk['TOTAL']."</h4></td>	
						</tr></table>";	?>

        </section>
</body>
</html>