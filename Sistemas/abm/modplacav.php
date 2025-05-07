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

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM pvideo WHERE ID_PVIDEO='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_PVIDEO'],/*0*/
		$filas['ID_MEMORIA'],/*1*/
        $filas['ID_MODELO'],/*2*/
        $filas['ID_TIPOMEM'],/*3*/
	];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>MODIFICAR PLACA DE VIDEO</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<style>
			body{
				background-color: #edf0f5;
			}
	</style>
</head>
<body>
    <script>
        function enviar_formulario(formulario){
        	Swal.fire({
                        title: "Esta seguro de modificar esta placa de video?",
                        icon: "warning",
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: "Cancelar",
                        customClass:{
                            actions: 'reverse-button'
                        }
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            formulario.submit()


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}
    </script>
<main>
    <div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="abmplacav.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
        <section id="Inicio">
		<div id="titulo">
			<h1>MODIFICAR PLACA DE VIDEO</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
            <?php 
            $sent= "SELECT MEMORIA FROM memoria WHERE ID_MEMORIA = $consulta[1]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $mem = $row['MEMORIA'];

            $sent= "SELECT MODELO FROM modelo WHERE ID_MODELO = $consulta[2]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $mod = $row['MODELO'];

            $sent= "SELECT TIPOMEM FROM tipomem WHERE ID_TIPOMEM = $consulta[3]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $tipo = $row['TIPOMEM'];
            ?>
            <form method="POST" action="./modificados.php">
                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">ID: </label>
                    <input type="text" class="id" name="id" style="background-color:transparent;" value="<?php echo $consulta[0]?>" readonly>
                </div>
                
                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">MEMORIA:</label>
                    <select name="memoria" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                    <option selected value="100"><?php echo $mem?></option>
                    <?php
                    $consulta= "SELECT * FROM memoria ORDER BY MEMORIA ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value="<?php echo $opciones['ID_MEMORIA']?>"><?php echo $opciones['MEMORIA']?></option>						
                    <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">MODELO:</label>
                    <select name="modelo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                    <option selected value="200"><?php echo $mod?></option>
                    <?php
                    $consulta= "SELECT * FROM modelo WHERE ID_TIPOP = 15 ORDER BY MODELO ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value="<?php echo $opciones['ID_MODELO']?>"><?php echo $opciones['MODELO']?></option>						
                    <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">TIPO MEMORIA:</label>
                    <select name="tipo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                    <option selected value="300"><?php echo $tipo?></option>
                    <?php
                    $consulta= "SELECT * FROM tipomem ORDER BY TIPOMEM ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value="<?php echo $opciones['ID_TIPOMEM']?>"><?php echo $opciones['TIPOMEM']?></option>						
                    <?php endforeach ?>
                    </select>
                </div>

            <div class="row justify-content-end">
                <input onClick="enviar_formulario(this.form)" style="width: 20%;"class="btn btn-success" type="button" name="modPlacav" value="MODIFICAR" >
            </div>
        </form>
		</div>
	</section>
	</main>
	<footer>
		<div class="footer">
			<div class="container-fluid">
				<div class="row">
					<img src="../imagenes/cba-logo.png" class="img-fluid">
				</div>
			</div>
		</div>
	</footer>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>