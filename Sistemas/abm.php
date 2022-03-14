<!--html actual de reportes-->
<!--la pagina trae la tabla de incidentes original, se agrego lnk de inconos de bootstrap"-->
<!--SE CAMBIO EL TIPO DE REPORTES, SOLO ESTA HECHO PARA RESOLUTOR Y TIPIFICACION-->
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
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>ALTA BAJA MODIFICACIÓN</title>
	<link href="estiloabm.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="jquery/1/jquery-ui.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
   <style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
	<section id="Inicio">
    <div id="reporteEst" style="width: 97%; margin-left: 20px;">   
            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                <a id="vlv"  href="consulta.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
            </div>					
         </div>

        <h1>ALTA BAJA MODIFICACIÓN</h1>
        <hr style='display: block;'><br>
        <div id="principal">
            <div id=izq
            data-aos="fade-right"
            data-aos-anchor="#example-anchor"
            data-aos-offset="500"
            data-aos-duration="500">
            <?php if($row['ID_RESOLUTOR'] == 6//GONZALO
					/*OR $row['ID_RESOLUTOR'] == 2 //CLAUDIA*/
					OR $row['ID_RESOLUTOR'] == 10 //EUGENIA
					OR $row['ID_RESOLUTOR'] == 15 //RODRIGO
					/*OR $row['ID_RESOLUTOR'] == 20 //GUSTAVO*/
					){
                        echo'

                    
                    <a href=abmtipificacion.php><input type="button" class="button but2" value="ABM TIPIFICACIÓN"></a>
                    <a href=abmresolutor.php><input type="button" class="button but2" value="ABM RESOLUTOR"></a>
                    <a href="abmequipos.php"><input type="button" class="button but2" value="ABM EQUIPOS"></a>
                 ';
					} ?>
                    <a href=abmarea.php><input type="button" class="button but2" value="ABM ÁREA"></a>
                    <a href="abmimpresoras.php"><input type="button" class="button but2" value="ABM IMPRESORAS"></a>
                    <a href="abmmonitores.php"><input type="button" class="button but2" value="ABM MONITORES"></a>
            </div>
            <div id=der
            data-aos="fade-left"
            data-aos-anchor="#example-anchor"
            data-aos-offset="500"
            data-aos-duration="500">

                <?php if($row['ID_RESOLUTOR'] == 6//GONZALO
					/*OR $row['ID_RESOLUTOR'] == 2 //CLAUDIA*/
					OR $row['ID_RESOLUTOR'] == 10 //EUGENIA
					OR $row['ID_RESOLUTOR'] == 15 //RODRIGO
					/*OR $row['ID_RESOLUTOR'] == 20 //GUSTAVO*/
					){
                        echo'
                    <a href="abmmarcas.php"><input type="button" class="button but2" value="ABM MARCAS"></a>
                    <a href="abmmicro.php"><input type="button" class="button but2" value="ABM MICRO"></a>
                    <a href="abmmodelos.php"><input type="button" class="button but2" value="ABM MODELOS"></a>
                    <a href="abmplacamadre.php"><input type="button" class="button but2" value="ABM PLACA MADRE"></a>
                    ';
					} ?>
                    <a href="abmotros.php"><input type="button" class="button but2" value="ABM OTROS PERIFERICOS"></a>
                    <a href="abmusuario.php"><input type="button" class="button but2" value="ABM USUARIO"></a>

            </div>
        </div>
    </section>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html> 