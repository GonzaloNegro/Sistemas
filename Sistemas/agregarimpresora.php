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
	<title>AGREGAR IMPRESORA</title><meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloagregar.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
			function ok(){
				swal(  {title: "Impresora cargada correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmimpresoras.php';
						}
						}
						);
			}	
			</script>

<script type="text/javascript">
			function no(){
				swal(  {title: "La impresora ingresada ya está registrada",
						icon: "error",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='agregarimpresora.php';
						}
						}
						);
			}	
			</script>
		<div id="reporteEst" style="width: 97%; margin-left: 20px;">   
				<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
					<a id="vlv"  href="abmimpresoras.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
				</div>					
		</div>
	<section id="Inicio">
		<div id="titulo" style="margin:20px;">
			<h1>AGREGAR IMPRESORA</h1>
		</div>
		<div id="principale" style="width: auto" class="container-fluid" data-aos="zoom-in">
						<form method="POST" action="guardarmodimpresora.php">

                            <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO IMPRESORA:</label>
                                <select name="tipop" class="form-control col-xl col-lg">
                                <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM tipop WHERE ID_TIPOP <= 4 OR ID_TIPOP = 10 OR ID_TIPOP = 13";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_TIPOP'] ?>><?php echo $opciones['TIPO']?></option>
                                        <?php endforeach?>
                                </select>
                                <label id="lblForm"class="col-form-label col-xl col-lg">MARCA:</label>
                                <select name="marca" class="form-control col-xl col-lg">
                                        <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM marcas";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                        <?php endforeach?>
                                    </select>
                            </div>


                            <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm"class="col-form-label col-xl col-lg">MODELO:</label>
                                <select name="modelo" class="form-control col-xl col-lg">
                                        <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM modelo";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']?></option>
                                        <?php endforeach?>
                                    </select>
                                <label id="lblForm" class="col-form-label col-xl col-lg">N° GOBIERNO:</label> 
                                <input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="serieg" required>

                            </div>    





                            <div class="form-group row" style="margin: 10px; padding:10px;">
                                <label id="lblForm" class="col-form-label col-xl col-lg">N° SERIE:</label> 
                                <input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="serie" required>
                                <label id="lblForm"class="col-form-label col-xl col-lg">PROCEDENCIA:</label>
                                <select name="proc" class="form-control col-xl col-lg">
                                        <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM procedencia";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_PROCEDENCIA'] ?>><?php echo $opciones['PROCEDENCIA']?></option>
                                        <?php endforeach?>
                                    </select>
                            </div> 




                            <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm"class="col-form-label col-xl col-lg">USUARIO:</label>
                            <select name="usu" class="form-control col-xl col-lg">
                                        <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM usuarios";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_USUARIO'] ?>><?php echo $opciones['NOMBRE']?></option>
                                        <?php endforeach?>
                                    </select>
                                <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:</label>
                                <select name="est" class="form-control col-xl col-lg">
                                        <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM estado_ws";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_ESTADOWS'] ?>><?php echo $opciones['ESTADO']?></option>
                                        <?php endforeach?>
                                    </select>
                            </div> 




                            <div class="form-group row" style="margin: 10px; padding:10px;">
                                <label id="lblForm" class="col-form-label col-xl col-lg">GARANTIA:</label> 
                                <input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar" placeholder="TIEMPO DE GARANTIA" >
                                <label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR:</label>
                                <select name="prov" class="form-control col-xl col-lg">
                                        <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                        <?php
                                        include("conexion.php");
                                        $consulta= "SELECT * FROM proveedor";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                        <?php endforeach?>
                                    </select>
                            </div> 




                            <div class="form-group row" style="margin: 10px; padding:10px;">
                                <label id="lblForm" class="col-form-label col-xl col-lg">FACTURA:</label> 
                                <input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="fac" placeholder="N° Factura">
                                <label id="lblForm" class="col-form-label col-xl col-lg">MAC:</label> 
                                <input class="form-control col-xl col-lg" name="mac" placeholder="N° MAC">
                            </div>




                            <div class="form-group row" style="margin: 10px; padding:10px;"> 
                                <label id="lblForm"class="col-form-label col-xl col-lg">RESERVA IP:</label>
                                <select name="reserva" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                                <label id="lblForm" class="col-form-label col-xl col-lg">IP:</label> 
                                <input class="form-control col-xl col-lg" name="ip" placeholder="N° IP">
                            </div>


                            <div class="form-group row" style="margin: 10px; padding:10px;">
                                <label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓNES:</label> 
                                <textarea class="form-control col-xl col-lg" name="obs" placeholder="Observaciónes" style="text-transform:uppercase" rows="3"></textarea>
                            </div>


                            <div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
                                <input style="width: 20%;"class="col-3 button" type="submit" value="GUARDAR IMPRESORA" class="button">
                            </div>    
					</form>
                    <?php
				if(isset($_GET['ok'])){
					?>
					<script>ok();</script>
					<?php			
				}
				if(isset($_GET['no'])){
					?>
					<script>no();</script>
					<?php			
				}
			?>
		</div>
	</section>
	<footer></footer>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>