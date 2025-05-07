<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM placam WHERE ID_PLACAM='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_PLACAM'],/*0*/
		$filas['PLACAM'],/*1*/
        $filas['ID_MARCA']/*2*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>MODIFICAR PLACA MADRE</title>
    <link rel="icon" href="../imagenes/logoInfraestructura.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
                        title: "Esta seguro de modificar esta placa madre?",
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
            <a id="vlv"  href="abmplacamadre.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
    <div id="titulo">
			<h1>MODIFICAR PLACA MADRE</h1>
	</div>
	<div id="principalu" style="width: 97%" class="container-fluid">
                        <?php 
                        include("../particular/conexion.php");
                        $sent= "SELECT MARCA FROM marcas WHERE ID_MARCA = $consulta[2]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $ma = $row['MARCA'];?>
                <form method="POST" action="./modificados.php">
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">ID: </label>
                        <input type="text" class="id" name="id" style="background-color:transparent;" value="<?php echo $consulta[0]?>" readonly>
                    </div>
                    
                    <div class="form-group row">
                        <label id="lblForm" class="col-form-label col-xl col-lg">PLACA MADRE:</label>
                        <input class="form-control col-xl col-lg" type="text" name="placam" placeholder="NOMBRE DEL MODELO" value="<?php echo $consulta[1]?>" required>
                    </div>
                        
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">MARCA:</label>
                        <select name="marca" class="form-control col-xl col-lg" style="text-transform:uppercase">
                        <option selected value="100"><?php echo $ma?></option>
                        <?php
                        include("../particular/conexion.php");
                        $consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                        <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                        <?php endforeach?>
                        </select>
                    </div>

                    <div class="row justify-content-end">
                        <input onClick="enviar_formulario(this.form)" style="width: 20%;"class="btn btn-success" type="button" name="modPLacam" value="MODIFICAR" >
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
</body>
</html>