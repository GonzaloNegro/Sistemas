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
	<title>AGREGAR EQUIPO</title><meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloagregar.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
			function ok(){
				swal(  {title: "Equipo cargado correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmequipos.php';
						}
						}
						);
			}	
			</script>
<script type="text/javascript">
			function no(){
				swal(  {title: "El equipo ya está registrado",
						icon: "error",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='agregarequipo.php';
						}
						}
						);
			}	
			</script>
		<div id="reporteEst" style="width: 97%; margin-left: 20px;">   
				<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
					<a id="vlv"  href="abmequipos.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
				</div>					
		</div>
	<section id="Inicio">
		<div id="titulo" style="margin:20px;">
			<h1>AGREGAR EQUIPO</h1>
		</div>
		<div id="principale" style="width: auto" class="container-fluid" data-aos="zoom-in">
						<form method="POST" action="guardarmodequipo.php">
                        
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
                            <label id="lblForm" class="col-form-label col-xl col-lg">N° WS:</label> 
							<input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="serieg" required>
                            <label id="lblForm"class="col-form-label col-xl col-lg">N° SERIE:</label>
                            <input class="form-control col-xl col-lg" style="text-transform:uppercase;" type="text" name="serialn" required>
                        </div>    


                        <div class="form-group row" style="margin: 10px; padding:10px;">
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
                                <label id="lblForm"class="col-form-label col-xl col-lg">S.O:</label>
                                <select name="so" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM so";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_SO'] ?>><?php echo $opciones['SIST_OP']?></option>
                                    <?php endforeach?>
                                </select>
                        </div> 


                        <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm"class="col-form-label col-xl col-lg">PROCESADOR:</label>
                            <select name="micro" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM micro";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MICRO'] ?>><?php echo $opciones['MICRO']?></option>
                                    <?php endforeach?>
                                </select>
                                <label id="lblForm"class="col-form-label col-xl col-lg">PLACA MADRE:</label>
                                <select name="placam" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM placam";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PLACAM'] ?>><?php echo $opciones['PLACAM']?></option>
                                    <?php endforeach?>
                                </select>
                        </div> 


                        <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">TIPO PC:</label> 
							<select name="tippc" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipows";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOWS'] ?>><?php echo $opciones['TIPOWS']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">MASTERIZACIÓN:</label>
                            <select name="masterizacion" class="form-control col-xl col-lg">
                                <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div> 


                        <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">MAC:</label> 
							<input class="form-control col-xl col-lg" name="mac" placeholder="N° MAC">
                            <label id="lblForm"class="col-form-label col-xl col-lg">RIP:</label>
                            <select name="reserva" class="form-control col-xl col-lg">
                                <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>


                        <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">IP:</label> 
							<input class="form-control col-xl col-lg" name="ip" placeholder="N° IP">
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
                            <label id="lblForm" class="col-form-label col-xl col-lg">GARANTIA:</label> 
							<input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar" >
                        </div>


                        <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm"class="col-form-label col-xl col-lg">RED:</label>
                            <select name="red" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM red";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_RED'] ?>><?php echo $opciones['RED']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓNES:</label> 
                            <textarea class="form-control col-xl col-lg" name="obs" placeholder="Observaciónes" style="text-transform:uppercase" rows="3" ></textarea>
                        </div>

                        <hr style='display: block; height: 3px;'>
                        <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">MEMORIAS</h1>
                        <!-- <label id="lblForm" class="col-form-label col-xl col-lg"><u>MEMORIAS:</u></label>  -->


<div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading1">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse1" aria-expanded="false" aria-controls="flush-collapse1">
        SLOT 1
      </button>
    </h2>
    <div id="flush-collapse1" class="accordion-collapse collapse" aria-labelledby="flush-heading1" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
        <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem1" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM memoria";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tmem1" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipomem";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
            </div>
        </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading2">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse2" aria-expanded="false" aria-controls="flush-collapse2">
        SLOT 2
      </button>
    </h2>
    <div id="flush-collapse2" class="accordion-collapse collapse" aria-labelledby="flush-heading2" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem2" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM memoria";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tmem2" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipomem";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
                        </div> 
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading3">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse3" aria-expanded="false" aria-controls="flush-collapse3">
        SLOT 3
      </button>
    </h2>
    <div id="flush-collapse3" class="accordion-collapse collapse" aria-labelledby="flush-heading3" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
            <div class="form-group row" style="margin: 10px; padding:10px;">
                <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem3" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM memoria";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tmem3" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipomem";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
                        </div> 
    </div>
  </div>
</div>
<div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading4">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse4" aria-expanded="false" aria-controls="flush-collapse4">
        SLOT 4
      </button>
    </h2>
    <div id="flush-collapse4" class="accordion-collapse collapse" aria-labelledby="flush-heading4" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
        <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem1" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM memoria";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tmem1" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipomem";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
            </div>
        </div>
    </div>
  </div>







                        <hr style='display: block; height: 3px;'>
<h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">DISCOS</h1>

<div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        SLOT DE DISCO 1
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
			<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 1:</label>
                            <select name="disc1" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM disco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DISCO 1:</label>
                            <select name="tdisc1" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipodisco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
      SLOT DE DISCO 2
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
			<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 2:</label>
                            <select name="disc2" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM disco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DISCO 2:</label>
                            <select name="tdisc2" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipodisco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
      SLOT DE DISCO 3
      </button>
    </h2>
    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
			<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 3:</label>
                            <select name="disc3" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM disco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DISCO 3:</label>
                            <select name="tdisc3" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipodisco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
      SLOT DE DISCO 4
      </button>
    </h2>
    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
			<label id="lblForm"class="col-form-label col-xl col-lg">SLOT DISCO 4:</label>
                            <select name="disc4" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM disco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DISCO 4:</label>
                            <select name="tdisc4" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("conexion.php");
                                    $consulta= "SELECT * FROM tipodisco";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
      </div>
    </div>
  </div>
</div>

                        <div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
							<input style="width: 20%;"class="col-3 button" type="submit" value="GUARDAR EQUIPO" class="button">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>