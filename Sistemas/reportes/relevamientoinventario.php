<!--PAGINA QUE MUESTRA NUMEROS TOTALES DE PC, NOTEBOOK, MONITORES, IMPRESORAS, SCANNERS Y TICKEADORAS EN USO, BAJA Y EN STOCK-->

<?php 
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloreporte.css">
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
                        <a id="vlv"  href="../reportes/tiporeporte.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
                        <div class="btn-group col-2" role="group" >
                              <button id="botonleft" type="button" class="btn btn-secondary" onclick="location.href='../consulta/consulta.php'" ><i style=" margin-bottom:10px;"class='bi bi-house-door'></i></button>
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
            <div class="centrado">
              <!--PANEL PARA INFORMACION DE PC-->
                <div class="centrado--stats ">
                  <h4><u>PC</u></h4>
                  <?php
                  //CONSULTA PARA OBTENER NUMERO PC ACTIVAS
                    $contpcact=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=1 and ID_ESTADOWS=1");
                    $totalpcact = mysqli_fetch_array($contpcact);
                   //CONSULTA PARA OBTENER NUMERO PC EN STOCK
                    $contpcstk=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=1 and ID_ESTADOWS=2");
                    $totalpcstk = mysqli_fetch_array($contpcstk);
                     //CONSULTA PARA OBTENER NUMERO PC EN BAJA
                    $contpcbaja=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=1 and ID_ESTADOWS=3");
                    $totalpcbaja = mysqli_fetch_array($contpcbaja);
                     //CONSULTA PARA OBTENER NUMERO TOTAL DE PC
                    $contpc=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=1");
                    $totalpc= mysqli_fetch_array($contpc);
                  ?>      
                  <!--UBICO EN ETIQUETAS H4 LOS DATOS OBTENIDOS-->
                    <div class="labelInput">
                      <h4>En uso:</h4>
                      <h4><?php echo $totalpcact['TOTAL']; ?></h4>
                    </div>
                    <div class="labelInput">
                      <h4>En Stock:</h4>
                      <h4><?php echo $totalpcbaja['TOTAL']; ?></h4>
                    </div>
                    <div class="labelInput">
                      <h4>En Baja:</h4>
                      <h4><?php echo $totalpcstk['TOTAL']; ?></h4>
                    </div>
                    <hr style="border: 1px solid black;width:100%;height:1px;"/>
                    <div class="labelInput">
                      <h4 style="color:green;">Totales:</h4>
                      <h4 style="color:green;"><?php echo $totalpc['TOTAL']; ?></h4>
                    </div>
                </div>


                <!--PANEL PARA INFORMACION DE MONITORES-->
                <div class="centrado--stats ">
                    <h4><u>MONITORES</u></h4>
                  <?php
                  //CONSULTA PARA OBTENER NUMERO MONITORES ACTIVOS
                    $contmonact=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='MONITOR' and ID_ESTADOWS=1");
					          $totalmonact = mysqli_fetch_array($contmonact);
                    //CONSULTA PARA OBTENER NUMERO MONITORES EN BAJA
                    $contmonbaja=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='MONITOR' and ID_ESTADOWS=2");
					          $totalmonbaja = mysqli_fetch_array($contmonbaja);
                    //CONSULTA PARA OBTENER NUMERO MONITORES EN STOCK
                    $contmonstk=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='MONITOR' and ID_ESTADOWS=3");
					          $totalmonstk = mysqli_fetch_array($contmonstk);
                    //CONSULTA PARA OBTENER NUMERO TOTAL MONITORES 
                    $conttotalmon=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='MONITOR'");
					          $totalmon = mysqli_fetch_array($conttotalmon);
                  ?>     
                   <!--UBICO EN ETIQUETAS H4 LOS DATOS OBTENIDOS--> 
                    <div class="labelInput">
                      <h4>En uso:</h4>
                      <h4><?php echo $totalmonact['TOTAL']; ?></h4>
                    </div>
                    <div class="labelInput">
                      <h4>En Stock:</h4>
                      <h4><?php echo $totalmonstk['TOTAL']; ?></h4>
                    </div>
                    <div class="labelInput">
                      <h4>En Baja:</h4>
                      <h4><?php echo $totalmonbaja['TOTAL']; ?></h4>
                    </div>
                    <hr style="border: 1px solid black;width:100%;height:1px;"/>
                    <div class="labelInput">
                      <h4 style="color:green;">Totales:</h4>
                      <h4 style="color:green;"><?php echo $totalmon['TOTAL']; ?></h4>
                    </div>
                </div>

                <!--PANEL PARA INFORMACION DE NOTEBOOKS-->
                <div class="centrado--stats ">
                    <h4><u>NOTEBOOKS</u></h4>
                  <?php
                  //CONSULTA PARA OBTENER NUMERO TOTAL NOTEBOOKS
                    $contnottot=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=2");
                    $totalnot = mysqli_fetch_array($contnottot);
                  //CONSULTA PARA OBTENER NUMERO NOTEBOOKS ACTIVAS
                    $contnotact=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=2 and ID_ESTADOWS=1");
                    $totalnotact = mysqli_fetch_array($contnotact);
                  //CONSULTA PARA OBTENER NUMERO NOTEBOOKS EN STOCK
                    $contnotstk=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=2 and ID_ESTADOWS=3");
                    $totalnotstk = mysqli_fetch_array($contnotstk);
                  //CONSULTA PARA OBTENER NUMERO NOTEBOOKS BAJA
                    $contnotbaja=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario where ID_TIPOWS=2 and ID_ESTADOWS=2");
                    $totalnotbaja = mysqli_fetch_array($contnotbaja);
                  ?>   
                  <!--UBICO EN ETIQUETAS H4 LOS DATOS OBTENIDOS-->   
                    <div class="labelInput">
                      <h4>En uso:</h4>
                      <h4><?php echo $totalnotact['TOTAL']; ?></h4>
                    </div>
                    <div class="labelInput">
                      <h4>En Stock:</h4>
                      <h4><?php echo $totalnotstk['TOTAL']; ?></h4>
                    </div>
                    <div class="labelInput">
                      <h4>En Baja:</h4>
                      <h4><?php echo $totalnotbaja['TOTAL']; ?></h4>
                    </div>
                    <hr style="border: 1px solid black;width:100%;height:1px;"/>
                    <div class="labelInput">
                        <h4 style="color:green;">Totales:</h4>
                      <h4 style="color:green;"><?php echo $totalnot['TOTAL']; ?></h4>
                    </div>
                </div>

                <!--PANEL PARA INFORMACION DE PC-->

                <div class="centrado--stats particular">
                    <h4><u>IMPRESORAS</u></h4>
                  <?php
                   //CONSULTA PARA OBTENER NUMERO IMPRESORAS PROPIAS ACTIVAS
                    $contimppropact=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='IMPRESORA' and ID_ESTADOWS=1 AND ID_PROCEDENCIA=3");
					$totalimppropact = mysqli_fetch_array($contimppropact);
                   //CONSULTA PARA OBTENER NUMERO IMPRESORAS PROPIAS EN BAJA
                    $contimpbaja=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='IMPRESORA' and ID_ESTADOWS=2 AND ID_PROCEDENCIA=3");
					$totalimpbaja = mysqli_fetch_array($contimpbaja);
                   //CONSULTA PARA OBTENER NUMERO IMPRESORAS PROPIAS EN STOCK
                    $contimpstk=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='IMPRESORA' and ID_ESTADOWS=3 AND ID_PROCEDENCIA=3");
					$totalimpstk = mysqli_fetch_array($contimpstk);
                     //CONSULTA PARA OBTENER NUMERO IMPRESORAS ALQUILADAS                  
                    $conttotalimpalq=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='IMPRESORA' AND ID_PROCEDENCIA=1");
                    $totalimpalq= mysqli_fetch_array($conttotalimpalq);
                    //CONSULTA PARA OBTENER NUMERO IMPRESORAS OBRA
                    $conttotalimpobra=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='IMPRESORA' AND ID_PROCEDENCIA=2");
					$totalimpobra = mysqli_fetch_array($conttotalimpobra);
                  //CONSULTA PARA OBTENER NUMERO IMPRESORAS TOTAL
                    $conttotalimp=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='IMPRESORA'");
					$totalimp = mysqli_fetch_array($conttotalimp);
                  ?>
                   <!--UBICO EN ETIQUETAS H4 LOS DATOS OBTENIDOS-->      
                    <div class="labelInput">
                      <h4>En uso (PROPIAS):</h4>
                      <h4><?php echo $totalimppropact['TOTAL']; ?></h4>
                    </div>
                    <div class="labelInput">
                      <h4>En Stock (PROPIAS):</h4>
                      <h4><?php echo $totalimpstk['TOTAL']; ?></h4>
                    </div>
                    <div class="labelInput">
                      <h4>En Baja (PROPIAS):</h4>
                      <h4><?php echo $totalimpbaja['TOTAL']; ?></h4>
                    </div>
                    <div class="labelInput">
                      <h4>Alquiladas:</h4>
                      <h4><?php echo $totalimpalq['TOTAL']; ?></h4>
                    </div>
                    <div class="labelInput">
                      <h4>Obra:</h4>
                      <h4><?php echo $totalimpobra['TOTAL']; ?></h4>
                    </div>
                    <hr style="border: 1px solid black;width:100%;height:1px;"/>
                    <div class="labelInput">
                        <h4 style="color:green;">Totales:</h4>
                      <h4 style="color:green;"><?php echo $totalimp['TOTAL']; ?></h4>
                    </div>
                </div>

               <!--PANEL PARA INFORMACION DE SCANNERS-->

                <div class="centrado--stats">
                    <h4><u>SCANNERS</u></h4>
                  <?php
                   //CONSULTA PARA OBTENER NUMERO SCANNERS ACTIVOS
                    $conttotalscact=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='SCANNER' AND ID_ESTADOWS=1");
					$totalscact = mysqli_fetch_array($conttotalscact);
                   //CONSULTA PARA OBTENER NUMERO SCANNERS EN BAJA
                    $conttotalscbaja=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='SCANNER' AND ID_ESTADOWS=2");
					$totalscbaja = mysqli_fetch_array($conttotalscbaja);
                   //CONSULTA PARA OBTENER NUMERO SCANNERS EN STOCK
                    $conttotalscstk=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='SCANNER' AND ID_ESTADOWS=2");
					$totalscstk = mysqli_fetch_array($conttotalscstk);
                   //CONSULTA PARA OBTENER NUMERO TOTAL SCANNERS
                    $conttotalsc=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='SCANNER'");
					$totalsc = mysqli_fetch_array($conttotalsc);
                  ?>      
                  <!--UBICO EN ETIQUETAS H4 LOS DATOS OBTENIDOS-->
                    <div class="labelInput">
                      <h4>En uso:</h4>
                      <h4><?php echo $totalscact['TOTAL']; ?></h4>
                    </div>
                    <div class="labelInput">
                      <h4>En Stock:</h4>
                      <h4><?php echo $totalscstk['TOTAL']; ?></h4>
                    </div>
                    <div class="labelInput">
                      <h4>En Baja:</h4>
                      <h4><?php echo $totalscbaja['TOTAL']; ?></h4>
                    </div>
                    <hr style="border: 1px solid black;width:100%;height:1px;"/>
                    <div class="labelInput">
                        <h4 style="color:green;">Totales:</h4>
                      <h4 style="color:green;"><?php echo $totalsc['TOTAL']; ?></h4>
                    </div>
                </div>


                <!--PANEL PARA INFORMACION DE TIVKEADORAS-->

                                <div class="centrado--stats">
                    <h4><u>TICKEADORAS</u></h4>
                  <?php
                  //CONSULTA PARA OBTENER NUMERO TICKEADORAS ACTIVAS
                    $conttotaltkact=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='TICKEADORA' AND ID_ESTADOWS=1");
					$totaltkact = mysqli_fetch_array($conttotaltkact);
                  //CONSULTA PARA OBTENER NUMERO TICKEADORAS EN BAJA
                    $conttotaltkbaja=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='TICKEADORA' AND ID_ESTADOWS=2");
					$totaltkbaja = mysqli_fetch_array($conttotaltkbaja);
                    //CONSULTA PARA OBTENER NUMERO TICKEADORAS EN STOCK
                    $conttotaltkstk=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='TICKEADORA' AND ID_ESTADOWS=3");
					$totaltkstk = mysqli_fetch_array($conttotaltkstk);
                  //CONSULTA PARA OBTENER NUMERO TOTAL TICKEADORAS
                    $conttotaltk=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p where p.TIPOP='TICKEADORA'");
					$totaltk = mysqli_fetch_array($conttotaltk);
                  ?>  
                  <!--UBICO EN ETIQUETAS H4 LOS DATOS OBTENIDOS-->    
                    <div class="labelInput">
                      <h4>En uso:</h4>
                      <h4><?php echo $totaltkact['TOTAL']; ?></h4>
                    </div>
                    <div class="labelInput">
                      <h4>En Stock:</h4>
                      <h4><?php echo $totaltkstk['TOTAL']; ?></h4>
                    </div>
                    <div class="labelInput">
                      <h4>En Baja:</h4>
                      <h4><?php echo $totaltkbaja['TOTAL']; ?></h4>
                    </div>
                    <hr style="border: 1px solid black;width:100%;height:1px;"/>
                    <div class="labelInput">
                        <h4 style="color:green;">Totales:</h4>
                      <h4 style="color:green;"><?php echo $totaltk['TOTAL']; ?></h4>
                    </div>
                </div>

            </div>
        </section>
        <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>