<?php 
session_start();
include('conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR FROM resolutor WHERE CUIL='$iduser'";
$consulta=mysqli_query($datos_base, "SELECT * FROM ticket ORDER BY FECHA_INICIO DESC, ID_TICKET DESC");
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ESTADISTICAS</title><meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="./chart.min.js"></script>
    <link href="estadisticas.css" rel="stylesheet" type="text/css" />
    <style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<header class="p-3 mb-3 border-bottom altura">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none"><div id="foto"></div>
          <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use> </svg>-->
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 espacio">
            <li><a href="cargadeincidentes.php" class="nav-link px-2 link-secondary link">CARGA</a></li>
            <li><a href="consulta.php" class="nav-link px-2 link-dark link">CONSULTA</a></li>
            <li><a href="inventario.php" class="nav-link px-2 link-dark link">INVENTARIO</a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="inventario.php">EQUIPOS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="impresoras.php">IMPRESORAS</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="monitores.php">MONITORES</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="otrosp.php">OTROS PERIFÉRICOS</a></li>
                </ul>
            </li>
            <li><a href="abm.php" class="nav-link px-2 link-dark link">ABM</a></li>
            <li><a href="tiporeporte.php" class="nav-link px-2 link-dark link">REPORTES</a></li>
            <?php if($row['ID_RESOLUTOR'] == 6//GONZALO
					/*OR $row['ID_RESOLUTOR'] == 2 //CLAUDIA*/
					OR $row['ID_RESOLUTOR'] == 10 //EUGENIA
					OR $row['ID_RESOLUTOR'] == 15 //RODRIGO
					OR $row['ID_RESOLUTOR'] == 20 //GUSTAVO
					){
                        echo'
						<li><a href="estadisticas.php" class="nav-link px-2 link-dark link">ESTADISTICAS</a></li>
                    ';
					} ?>
            <li class="ubicacion"><a href="bienvenida.php"><i class="bi bi-info-circle"></i></a></li>
        </ul>
        <form method="POST" action="mensajes.php">
			    <button href="mensajes.php" class="mensaje" style="margin-right: 50px;"><i class="bi bi-chat-square-text"></i></button>
		    </form>
        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false"><h5><i class="bi bi-person rounded-circle"></i><?php echo utf8_decode($row['RESOLUTOR']);?></h5></a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="contraseña.php">CAMBIAR CONTRASEÑA</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="salir.php">CERRAR SESIÓN</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <section class="contenedor">
    <div class="grafico" style="width: 600px; height: 750px;">
            <h1>INCIDENTES POR RESOLUTOR</h1>
            <canvas id="MiGrafica" ></canvas>
    </div>
    <div class="informacion" style="width: 600px; height: 750px;">
        <h1>INCIDENTES POR ESTADO</h1>
        <canvas id="MiGrafica2" ></canvas>
    </div>
  </section>




    <?php 
    include('conexion.php');
    /* RODRIGO */
    $sql6 = "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = 15";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res = $row6['RESOLUTOR'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_RESOLUTOR=15";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tot = $row6['TOTAL'];
    /* RODRIGO */


    /* CLAUDIA */
    $sql6 = "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = 2";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res1 = $row6['RESOLUTOR'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_RESOLUTOR=2";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tot1 = $row6['TOTAL'];
    /* CLAUDIA */


    /* GABRIEL */
    $sql6 = "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = 5";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res2 = $row6['RESOLUTOR'];
    
    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_RESOLUTOR=5";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tot2 = $row6['TOTAL'];
    /* GABRIEL */


    /* PAMELA */
    $sql6 = "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = 13";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res3 = $row6['RESOLUTOR'];
    
    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_RESOLUTOR=13";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tot3 = $row6['TOTAL'];
    /* PAMELA */


    /* EDUARDO */
    $sql6 = "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = 3";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res4 = $row6['RESOLUTOR'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_RESOLUTOR=3";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tot4 = $row6['TOTAL'];
    /* EDUARDO */


    /* ENRIQUE */
    $sql6 = "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = 4";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res5 = $row6['RESOLUTOR'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_RESOLUTOR=4";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tot5 = $row6['TOTAL'];
    /* ENRIQUE */


    /* GONZALO */
    $sql6 = "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = 6";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res6 = $row6['RESOLUTOR'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_RESOLUTOR=6";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tot6 = $row6['TOTAL'];
    /* GONZALO */


    /* EUGE */
    $sql6 = "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = 10";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res7 = $row6['RESOLUTOR'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_RESOLUTOR=10";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tot7 = $row6['TOTAL'];
    /* EUGE */


    /* YANINA */
    $sql6 = "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = 19";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res8 = $row6['RESOLUTOR'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_RESOLUTOR=19";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tot8 = $row6['TOTAL'];
    /* YANINA */



    /* GASTON */
    $sql6 = "SELECT RESOLUTOR FROM resolutor WHERE ID_RESOLUTOR = 21";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $res9 = $row6['RESOLUTOR'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_RESOLUTOR=21";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $tot9 = $row6['TOTAL'];
    /* GASTON */
    
    $sql6 = "SELECT count(*) as TOTAL FROM ticket";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $total = $row6['TOTAL'];

    $prom = round(($tot * 100)/$total,2);
    $prom1 = round(($tot1 * 100)/$total,2);
    $prom2 = round(($tot2 * 100)/$total,2);
    $prom3 = round(($tot3 * 100)/$total,2);
    $prom4 = round(($tot4 * 100)/$total,2);
    $prom5 = round(($tot5 * 100)/$total,2);
    $prom6 = round(($tot6 * 100)/$total,2);
    $prom7 = round(($tot7 * 100)/$total,2);
    $prom8 = round(($tot8 * 100)/$total,2);
    $prom9 = round(($tot9 * 100)/$total,2);





/* ESTADOS */

    /* SUSPENDIDO */
    $sql6 = "SELECT ESTADO FROM estado WHERE ID_ESTADO = 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est1 = $row6['ESTADO'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_ESTADO = 1";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $etot1 = $row6['TOTAL'];
    /* SUSPENDIDO */


    /* SOLUCIONADO */
    $sql6 = "SELECT ESTADO FROM estado WHERE ID_ESTADO = 2";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est2 = $row6['ESTADO'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_ESTADO = 2";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $etot2 = $row6['TOTAL'];
    /* SOLUCIONADO */


    /* DERIVADO */
    $sql6 = "SELECT ESTADO FROM estado WHERE ID_ESTADO = 3";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est3 = $row6['ESTADO'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_ESTADO = 3";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $etot3 = $row6['TOTAL'];
    /* DERIVADO */


    /* EN PROCESO */
    $sql6 = "SELECT ESTADO FROM estado WHERE ID_ESTADO = 4";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est4 = $row6['ESTADO'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_ESTADO = 4";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $etot4 = $row6['TOTAL'];
    /* EN PROCESO */


    /* ANULADO */
    $sql6 = "SELECT ESTADO FROM estado WHERE ID_ESTADO = 5";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est5 = $row6['ESTADO'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_ESTADO = 5";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $etot5 = $row6['TOTAL'];
    /* ANULADO */

    $sql6 = "SELECT count(*) as TOTAL FROM ticket";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $etotal = $row6['TOTAL'];

    $eprom1 = round(($etot1 * 100)/$etotal,2);
    $eprom2 = round(($etot2 * 100)/$etotal,2);
    $eprom3 = round(($etot3 * 100)/$etotal,2);
    $eprom4 = round(($etot4 * 100)/$etotal,2);
    $eprom5 = round(($etot5 * 100)/$etotal,2);






    /* TIPIFICACIONES */
    $sql6 = "SELECT ESTADO FROM estado WHERE ID_ESTADO = 5";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $est5 = $row6['ESTADO'];

    $sql6 = "SELECT count(*) as TOTAL FROM ticket WHERE ID_ESTADO = 5";
    $result6 = $datos_base->query($sql6);
    $row6 = $result6->fetch_assoc();
    $etot5 = $row6['TOTAL'];


   /*  SELECT ID_SO from so ORDER BY SIST_OP desc limit 3;
    SELECT ID_SO from so ORDER BY SIST_OP desc limit 3, 1; */
    ?>
    <footer>
		<div class="footer">
			<div class="container-fluid">
				<div class="row">
					<img src="imagenes/logoGobierno.png" class="img-fluid">
				</div>
			</div>
		</div>
	</footer>
</body>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
  		AOS.init();
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
    let miCanvas=document.getElementById("MiGrafica").getContext("2d");

    var chart = new Chart(miCanvas,{
        type: "doughnut",
        data:{
            labels:[
            "<?php echo "$res: CANTIDAD: $tot   ||   PORCENTAJE: $prom%";?>", 
            "<?php echo "$res1: CANTIDAD: $tot1   ||   PORCENTAJE: $prom1%";?>", 
            "<?php echo "$res2: CANTIDAD: $tot2   ||   PORCENTAJE: $prom2%";?>", 
            "<?php echo "$res3: CANTIDAD: $tot3   ||   PORCENTAJE: $prom3%";?>",
            "<?php echo "$res4: CANTIDAD: $tot4   ||   PORCENTAJE: $prom4%";?>", 
            "<?php echo "$res5: CANTIDAD: $tot5   ||   PORCENTAJE: $prom5%";?>", 
            "<?php echo "$res6: CANTIDAD: $tot6   ||   PORCENTAJE: $prom6%";?>",
            "<?php echo "$res7: CANTIDAD: $tot7   ||   PORCENTAJE: $prom7%";?>", 
            "<?php echo "$res8: CANTIDAD: $tot8   ||   PORCENTAJE: $prom8%";?>",
            "<?php echo "$res9: CANTIDAD: $tot9   ||   PORCENTAJE: $prom9%";?>",],

            datasets:[{
                label: "INCIDENTES POR RESOLUTOR",
                backgroundColor: [
                    "rgb(0,197,255)", 
                    "rgb(255, 0, 0)",
                    "rgb(103, 1, 1)",
                    "rgb(255, 0, 189)", 
                    "rgb(96, 2, 121)",
                    "rgb(0, 224, 255)",
                    "rgb(0, 97, 111)", 
                    "rgb(0, 255, 42)",
                    "rgb(0, 121, 20)",
                    "rgb(232, 255, 0)"],
                borderColor: "rgb(0, 54, 255 )",
                data:[
                    <?php echo $tot;?>, 
                    <?php echo $tot1 ;?>, 
                    <?php echo $tot2 ;?>, 
                    <?php echo $tot3 ;?>,
                    <?php echo $tot4 ;?>, 
                    <?php echo $tot5 ;?>,
                    <?php echo $tot6 ;?>, 
                    <?php echo $tot7 ;?>,
                    <?php echo $tot8 ;?>, 
                    <?php echo $tot9 ;?> ]
            }]
        }
    })
    </script>

     <script>
    let miCanvas2=document.getElementById("MiGrafica2").getContext("2d");

    var chart = new Chart(miCanvas2,{
        type: "doughnut",
        data:{
            labels:[
            "<?php echo "$est1: CANTIDAD: $etot1   ||   PORCENTAJE: $eprom1%";?>", 
            "<?php echo "$est2: CANTIDAD: $etot2   ||   PORCENTAJE: $eprom2%";?>", 
            "<?php echo "$est3: CANTIDAD: $etot3   ||   PORCENTAJE: $eprom3%";?>", 
            "<?php echo "$est4: CANTIDAD: $etot4   ||   PORCENTAJE: $eprom4%";?>",
            "<?php echo "$est5: CANTIDAD: $etot5   ||   PORCENTAJE: $eprom5%";?>",],

            datasets:[{
                label: "INCIDENTES POR RESOLUTOR",
                backgroundColor: [
                    "rgb(0,197,255)", 
                    "rgb(255, 0, 0)",
                    "rgb(103, 1, 1)",
                    "rgb(255, 0, 189)", 
                    "rgb(96, 2, 121)",
                    "rgb(0, 224, 255)",
                    "rgb(0, 97, 111)", 
                    "rgb(0, 255, 42)",
                    "rgb(0, 121, 20)",
                    "rgb(232, 255, 0)"],
                borderColor: "rgb(0, 54, 255 )",
                data:[
                    <?php echo $etot1;?>, 
                    <?php echo $etot2 ;?>, 
                    <?php echo $etot3 ;?>, 
                    <?php echo $etot4 ;?>,
                    <?php echo $etot5 ;?>]
            }]
        }
    })
    </script>

</html>