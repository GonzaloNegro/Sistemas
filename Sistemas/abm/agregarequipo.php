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
	<title>AGREGAR EQUIPO</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoObrasPúblicas.png">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>

<script>
	$(document).ready(function(){
    $("#slcusu").change(function(){
        
		if ($("#slcusu").val() == '277') {
			$("#lblarea").show(1300);
		    $("#slcarea").show(1300);
		}
		if ($("#slcusu").val() != '277') {
			$("#lblarea").hide(1000);
		    $("#slcarea").hide(1000);
		}
    });
    });
</script>
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

    <div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="abmequipos.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
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
                                <select name="usu" id="slcusu" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                    <option  value="0" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM usuarios  ORDER BY NOMBRE ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_USUARIO'] ?>><?php echo $opciones['NOMBRE']?></option>
                                    <?php endforeach?>
                                </select>
                                <label  name="txtarea" id="lblarea" class="col-form-label col-xl col-lg" style="display: none; font-size: 23px;">AREA:</label>
                                <select name="area" id="slcarea" style="text-transform:uppercase; display:none;" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM area  ORDER BY AREA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_AREA'] ?>><?php echo $opciones['AREA']?></option>
                                    <?php endforeach?>
                                </select>
                                
                        </div>

                        <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:</label>
                                <select name="est" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM estado_ws  ORDER BY ESTADO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_ESTADOWS'] ?>><?php echo $opciones['ESTADO']?></option>
                                    <?php endforeach?>
                                </select>

                                <label id="lblForm" class="col-form-label col-xl col-lg">N° WS:</label> 
							              <input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="serieg" placeholder="WSXXXXX" required>
                        </div>


                        <div class="form-group row" style="margin: 10px; padding:10px;">
                            
                            <label id="lblForm"class="col-form-label col-xl col-lg">N° SERIE:</label>
                            <input class="form-control col-xl col-lg" style="text-transform:uppercase;" type="text" name="serialn" required>
                            <label id="lblForm"class="col-form-label col-xl col-lg">MARCA:</label>
                            <select name="marca" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
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


                        <div class="form-group row" style="margin: 10px; padding:10px;">
                        
                                <label id="lblForm"class="col-form-label col-xl col-lg">S.O:</label>
                                <select name="so" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM so ORDER BY SIST_OP ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_SO'] ?>><?php echo $opciones['SIST_OP']?></option>
                                    <?php endforeach?>
                                </select>
                                <label id="lblForm" class="col-form-label col-xl col-lg">TIPO PC:</label> 
							              <select name="tippc" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipows ORDER BY TIPOWS ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOWS'] ?>><?php echo $opciones['TIPOWS']?></option>
                                    <?php endforeach?>
                                </select>


                        </div> 


                        <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm"class="col-form-label col-xl col-lg">MASTERIZACIÓN:</label>
                            <select name="masterizacion" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                            <label id="lblForm" class="col-form-label col-xl col-lg">MAC:</label> 
							              <input class="form-control col-xl col-lg" name="mac" placeholder="N° MAC">
                            </div> 


                        <div class="form-group row" style="margin: 10px; padding:10px;">
                            
                            <label id="lblForm"class="col-form-label col-xl col-lg">RIP:</label>
                            <select name="reserva" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                            <label id="lblForm" class="col-form-label col-xl col-lg">IP:</label> 
						              	<input class="form-control col-xl col-lg" name="ip" placeholder="N° IP">
                        </div>


                        <div class="form-group row" style="margin: 10px; padding:10px;">
                            
                            <label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR:</label>
                            <select name="prov" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
                                <label id="lblForm" class="col-form-label col-xl col-lg">FACTURA:</label> 
							              <input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="fac" placeholder="N° Factura">

                        </div>


                        <div class="form-group row" style="margin: 10px; padding:10px;">
                            <label id="lblForm" class="col-form-label col-xl col-lg">GARANTIA:</label> 
							              <input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar" placeholder="TIEMPO DE GARANTIA">
                            <label id="lblForm"class="col-form-label col-xl col-lg">RED:</label>
                            <select name="red" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM red ORDER BY RED ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_RED'] ?>><?php echo $opciones['RED']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>


                        <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm"class="col-form-label col-xl col-lg">PROCEDENCIA:</label>
                            <select name="procedencia" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM procedencia ORDER BY PROCEDENCIA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROCEDENCIA'] ?>><?php echo $opciones['PROCEDENCIA']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓN:</label> 
                              <textarea class="form-control col-xl col-lg" name="obs" placeholder="OBSERVACIÓN" style="text-transform:uppercase" rows="3" ></textarea>
                        </div>







<!-- <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">PLACA MADRE</h1> -->

<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingpm">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsepm" aria-expanded="false" aria-controls="flush-collapsepm">
      <u>PLACA MADRE</u>
      </button>
    </h2>
    <div id="flush-collapsepm" class="accordion-collapse collapse" aria-labelledby="flush-headingpm" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PLACA:</label> 
							    <select name="ppla" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT p.ID_PLACAM, p.PLACAM, m.MARCA 
                                    FROM placam p
                                    INNER JOIN marcas m ON m.ID_MARCA = p.ID_MARCA
                                    ORDER BY PLACAM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PLACAM']?>><?php echo $opciones['PLACAM']." - ".$opciones['MARCA'] ?></option>
                                    <?php endforeach?>
                                </select>
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="prpla" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="fapla" placeholder="N° FACTURA">
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="fpla">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gpla" placeholder="TIEMPO DE GARANTIA">
              <label id="lblForm"class="col-form-label col-xl col-lg">N°SERIE:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="nropla" placeholder="N° DE SERIE">
        </div>
      </div>
    </div>
  </div>

















<!-- <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">MICROPROCESADOR</h1> -->

<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingmi">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsemi" aria-expanded="false" aria-controls="flush-collapsepmi">
      <u>MICROPROCESADOR</u>
      </button>
    </h2>
    <div id="flush-collapsemi" class="accordion-collapse collapse" aria-labelledby="flush-headingmi" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MICRO:</label> 
							    <select name="mmic" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.ID_MICRO, m.MICRO, ma.MARCA 
                                    FROM micro m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                                    ORDER BY MICRO ASC"; 
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MICRO'] ?>><?php echo $opciones['MICRO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="pmic" style="text-transform:uppercase" class="form-control col-xl col-lg">
                  <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="facmic" placeholder="N° FACTURA">
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="fmic">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gmic" placeholder="TIEMPO DE GARANTIA">
              <label id="lblForm"class="col-form-label col-xl col-lg">N°SERIE:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="nromic" placeholder="N° DE SERIE">
        </div>
      </div>
    </div>
  </div>





















<!--   <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">PLACA DE VIDEO</h1> -->

<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingpl">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsepl" aria-expanded="false" aria-controls="flush-collapsepl">
      <u>1°&nbspPLACA DE VIDEO</u>
      </button>
    </h2>
    <div id="flush-collapsepl" class="accordion-collapse collapse" aria-labelledby="flush-headingpl" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PLACA:</label> 
							    <select name="pvmem" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.MODELO, me.MEMORIA, t.TIPOMEM, p.ID_PVIDEO
                                    FROM pvideo p
                                    LEFT JOIN modelo m ON m.ID_MODELO = p.ID_MODELO
                                    LEFT JOIN memoria me ON me.ID_MEMORIA = p.ID_MEMORIA
                                    LEFT JOIN tipomem t ON t.ID_TIPOMEM = p.ID_TIPOMEM
                                    LEFT JOIN tipop ti ON ti.ID_TIPOP = m.ID_TIPOP
                                    WHERE ti.ID_TIPOP = 15
                                    ORDER BY m.MODELO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PVIDEO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MEMORIA']." - ".$opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="pvprov" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="pvfact" placeholder="N° FACTURA">
          <label id="lblForm" class="col-form-label col-xl col-lg">N° SERIE:</label> 
          <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="pvnserie" placeholder="N° SERIE">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="pvfec">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="pvgar" placeholder="TIEMPO DE GARANTIA">
        </div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingpl1">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsepl1" aria-expanded="false" aria-controls="flush-collapsepl1">
      <u>2°&nbspPLACA DE VIDEO</u>
      </button>
    </h2>
    <div id="flush-collapsepl1" class="accordion-collapse collapse" aria-labelledby="flush-headingpl1" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PLACA:</label> 
            <select name="pvmem1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.MODELO, me.MEMORIA, t.TIPOMEM, p.ID_PVIDEO
                                    FROM pvideo p
                                    LEFT JOIN modelo m ON m.ID_MODELO = p.ID_MODELO
                                    LEFT JOIN memoria me ON me.ID_MEMORIA = p.ID_MEMORIA
                                    LEFT JOIN tipomem t ON t.ID_TIPOMEM = p.ID_TIPOMEM
                                    LEFT JOIN tipop ti ON ti.ID_TIPOP = m.ID_TIPOP
                                    WHERE ti.ID_TIPOP = 15
                                    ORDER BY m.MODELO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PVIDEO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MEMORIA']." - ".$opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="pvprov1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="pvfact1" placeholder="N° FACTURA">
          <label id="lblForm" class="col-form-label col-xl col-lg">N° SERIE:</label> 
          <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="pvnserie1" placeholder="N° SERIE">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="pvfec1">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="pvgar1" placeholder="TIEMPO DE GARANTIA">
        </div>
      </div>
    </div>
  </div>
</div>































<!-- <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">MEMORIAS</h1> -->

<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading1">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse1" aria-expanded="false" aria-controls="flush-collapse1">
        <u>1°&nbspMEMORIA</u>
      </button>
    </h2>
    <div id="flush-collapse1" class="accordion-collapse collapse" aria-labelledby="flush-heading1" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM memoria ORDER BY MEMORIA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tmem1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipomem ORDER BY TIPOMEM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="prov1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="fact1" placeholder="N° FACTURA">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MARCA:</label> 
							    <select name="marc1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="fec1">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar1" placeholder="TIEMPO DE GARANTIA">
              <label id="lblForm" class="col-form-label col-xl col-lg">VELOCIDAD:</label> 
							    <select name="pvel1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM velocidad ORDER BY FRECUENCIA_RAM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_FRECUENCIA'] ?>><?php echo $opciones['FRECUENCIA_RAM']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading2">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse2" aria-expanded="false" aria-controls="flush-collapse2">
        <u>2°&nbspMEMORIA</u>
      </button>
    </h2>
    <div id="flush-collapse2" class="accordion-collapse collapse" aria-labelledby="flush-heading2" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM memoria ORDER BY MEMORIA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tmem2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipomem ORDER BY TIPOMEM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
                        </div>
                        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="prov2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="fact2" placeholder="N° FACTURA">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MARCA:</label> 
							    <select name="marc2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="fec2" placeholder="N° FACTURA">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar2" placeholder="TIEMPO DE GARANTIA">
              <label id="lblForm" class="col-form-label col-xl col-lg">VELOCIDAD:</label> 
							    <select name="pvel2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM velocidad ORDER BY FRECUENCIA_RAM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_FRECUENCIA'] ?>><?php echo $opciones['FRECUENCIA_RAM']?></option>
                                    <?php endforeach?>
                                </select>
        </div> 
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading3">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse3" aria-expanded="false" aria-controls="flush-collapse3">
        <u>3°&nbspMEMORIA</u>
      </button>
    </h2>
    <div id="flush-collapse3" class="accordion-collapse collapse" aria-labelledby="flush-heading3" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
            <div class="form-group row" style="margin: 10px; padding:10px;">
                <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM memoria ORDER BY MEMORIA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tmem3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipomem ORDER BY TIPOMEM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
            </div> 
            <div class="form-group row" style="margin: 10px; padding:10px;">
                  <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="prov3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="fact3" placeholder="N° FACTURA">
          </div>
          <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">MARCA:</label> 
							    <select name="marc3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="fec3" placeholder="N° FACTURA">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar3" placeholder="TIEMPO DE GARANTIA">
              <label id="lblForm" class="col-form-label col-xl col-lg">VELOCIDAD:</label> 
							    <select name="pvel3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM velocidad ORDER BY FRECUENCIA_RAM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_FRECUENCIA'] ?>><?php echo $opciones['FRECUENCIA_RAM']?></option>
                                    <?php endforeach?>
                                </select>
        </div> 
    </div>
  </div>
</div>
<div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading4">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse4" aria-expanded="false" aria-controls="flush-collapse4">
        <u>4°&nbspMEMORIA</u>
      </button>
    </h2>
    <div id="flush-collapse4" class="accordion-collapse collapse" aria-labelledby="flush-heading4" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">CAPACIDAD:</label> 
							    <select name="mem4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM memoria ORDER BY MEMORIA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MEMORIA'] ?>><?php echo $opciones['MEMORIA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tmem4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipomem ORDER BY TIPOMEM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOMEM'] ?>><?php echo $opciones['TIPOMEM']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="prov4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="fact4" placeholder="N° FACTURA">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MARCA:</label> 
							    <select name="marc4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="fec4" placeholder="N° FACTURA">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar4" placeholder="TIEMPO DE GARANTIA">
              <label id="lblForm" class="col-form-label col-xl col-lg">VELOCIDAD:</label> 
							    <select name="pvel4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM velocidad ORDER BY FRECUENCIA_RAM ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_FRECUENCIA'] ?>><?php echo $opciones['FRECUENCIA_RAM']?></option>
                                    <?php endforeach?>
                                </select>
        </div> 
        </div>
        </div>
    </div>
  </div>







<!-- <h1 style="font-size: 32px; color: #5c6f82; text-decoration: underline;">DISCOS</h1> -->

<div class="accordion accordion-flush" id="accordionFlushExample" style="margin-top: 25px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        <u>1°&nbspDISCO</u>
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
			    <label id="lblForm"class="col-form-label col-xl col-lg">CAPACIDAD:</label>
                            <select name="disc1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM disco ORDER BY DISCO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tdisc1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipodisco ORDER BY TIPOD ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="dprov1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="dfact1" placeholder="N° FACTURA">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MODELO:</label> 
							    <select name="dmod1" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA 
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                                    WHERE m.ID_TIPOP = 14
                                    ORDER BY m.MODELO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="dfec1" placeholder="N° FACTURA">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="dgar1" placeholder="TIEMPO DE GARANTIA">
        </div> 
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
        <u>2°&nbspDISCO</u>
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
			    <label id="lblForm"class="col-form-label col-xl col-lg">CAPACIDAD:</label>
                            <select name="disc2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM disco ORDER BY DISCO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tdisc2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipodisco ORDER BY TIPOD ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="dprov2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="dfact2" placeholder="N° FACTURA">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MODELO:</label> 
							    <select name="dmod2" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA 
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                                    WHERE m.ID_TIPOP = 14
                                    ORDER BY m.MODELO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="dfec2">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="dgar2" placeholder="TIEMPO DE GARANTIA">
        </div> 
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
        <u>3°&nbspDISCO</u>
      </button>
    </h2>
    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
			<label id="lblForm"class="col-form-label col-xl col-lg">CAPACIDAD:</label>
                            <select name="disc3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM disco ORDER BY DISCO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tdisc3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipodisco ORDER BY TIPOD ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
          </div>
          <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="dprov3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="dfact3" placeholder="N° FACTURA">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
          <label id="lblForm" class="col-form-label col-xl col-lg">MODELO:</label> 
							    <select name="dmod3" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA 
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                                    WHERE m.ID_TIPOP = 14
                                    ORDER BY m.MODELO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="dfec3">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="dgar3" placeholder="TIEMPO DE GARANTIA">
        </div> 
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
        <u>4°&nbspDISCO</u>
      </button>
    </h2>
    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body" style="color: #53AAE0;">
        <div class="form-group row" style="margin: 10px; padding:10px;">
			<label id="lblForm"class="col-form-label col-xl col-lg">CAPACIDAD:</label>
                            <select name="disc4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM disco ORDER BY DISCO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_DISCO'] ?>><?php echo $opciones['DISCO']?></option>
                                    <?php endforeach?>
                                </select>
                            <label id="lblForm"class="col-form-label col-xl col-lg">TIPO:</label>
                            <select name="tdisc4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM tipodisco ORDER BY TIPOD ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_TIPOD'] ?>><?php echo $opciones['TIPOD']?></option>
                                    <?php endforeach?>
                                </select>
          </div>
          <div class="form-group row" style="margin: 10px; padding:10px;">
            <label id="lblForm" class="col-form-label col-xl col-lg">PROVEEDOR:</label> 
							    <select name="dprov4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FACTURA:</label>
              <input class="form-control col-xl col-lg" type="text" style="text-transform:uppercase;" name="dfact4" placeholder="N° FACTURA">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;"> 
          <label id="lblForm" class="col-form-label col-xl col-lg">MODELO:</label> 
							    <select name="dmod4" style="text-transform:uppercase" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA 
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                                    WHERE m.ID_TIPOP = 14
                                    ORDER BY m.MODELO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                </select>
							<label id="lblForm"class="col-form-label col-xl col-lg">FECHA:</label>
              <input type="date" class="form-control col-xl col-lg" name="dfec4">
        </div>
        <div class="form-group row" style="margin: 10px; padding:10px;">
							<label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA:</label>
              <input type="text" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="dgar4" placeholder="TIEMPO DE GARANTIA">
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
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>