<?php 
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>AGREGAR IMPRESORA</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
			function ok(){
				// swal(  {title: "Impresora cargada correctamente",
				// 		icon: "success",
				// 		showConfirmButton: true,
				// 		showCancelButton: false,
				// 		})
				// 		.then((confirmar) => {
				// 		if (confirmar) {
				// 			window.location.href='abmimpresoras.php';
				// 		}
				// 		}
				// 		);
                Swal.fire({
                        title: "Impresora cargada correctamente.",
                        icon: "success",
                        showConfirmButton: true,
                        showCancelButton: false,
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
                            window.location.href='abmimpresoras.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>

<script type="text/javascript">
			function no(){
				// swal(  {title: "La impresora ingresada ya está registrada",
				// 		icon: "error",
				// 		})
				// 		.then((confirmar) => {
				// 		if (confirmar) {
				// 			window.location.href='agregarimpresora.php';
				// 		}
				// 		}
				// 		);
                Swal.fire({
                        title: "La impresora ya está registrada",
                        icon: "error",
                        showConfirmButton: true,
                        showCancelButton: false,
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
                            window.location.href='agregarimpresora.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
            <script>
        function validar_formulario(){
			
			var fieldsToValidate = [
                    {
                        selector: "#tipoimp",
                        errorMessage: "No seleccionó tipo de impresora."
                    },
                    {
                        selector: "#modelo",
                        errorMessage: "No ingresó modelo."
                    },
                    {
                        selector: "#serieg",
                        errorMessage: "No ingresó Nro. de gobierno."
                    },
                    {
                        selector: "#serie",
                        errorMessage: "No seleccionó Nro. de serie."
                    },
                    {
                        selector: "#proc",
                        errorMessage: "No seleccionó procedencia."
                    },
                    {
                        selector: "#usu",
                        errorMessage: "No seleccionó usuario."
                    },
                    {
                        selector: "#est",
                        errorMessage: "No seleccionó estado."
                    }
                ];

                var isValid = true;

				$.each(fieldsToValidate, function(index, field) {
                    var element = $(field.selector);
                    if (element.val()== "" || element.val()== null) {
                      Swal.fire({
                      title: field.errorMessage,
                      icon: "warning",
                      showConfirmButton: true,
                      showCancelButton: false,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Aceptar',
                      cancelButtonText: "Cancelar",
                      customClass:{
                      actions: 'reverse-button'
                        }
                      })
                        isValid = false;
                        return false;
                    }
                });

				if (isValid ==true) {
								
								return true;
							}
							else{
								return false;
							}
		};
		function enviar_formulario(formulario){
        	if (validar_formulario()) {
				// alert("Todo OK");
				Swal.fire({
                        title: "Esta seguro de guardar esta impresora?",
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
		}
				
		</script>
    <div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="../consulta/impresoras.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
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
                                <select id="tipoimp" name="tipop" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                        <?php
                                        include("../particular/conexion.php");
                                        $consulta= "SELECT * FROM tipop WHERE ID_TIPOP <= 4 OR ID_TIPOP = 10 OR ID_TIPOP = 13  ORDER BY TIPO ASC";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_TIPOP'] ?>><?php echo $opciones['TIPO']?></option>
                                        <?php endforeach?>
                                </select>
                                <label id="lblForm"class="col-form-label col-xl col-lg">MODELO:</label>
                                <select id="modelo" name="modelo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                        <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                        <?php
                                    include("../particular/conexion.php");
                                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA
                                    FROM modelo m
                                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                                    INNER JOIN tipop t ON t.ID_TIPOP = m.ID_TIPOP
                                    WHERE (m.ID_TIPOP = 1 OR m.ID_TIPOP = 2 OR m.ID_TIPOP = 3 OR m.ID_TIPOP = 4 OR m.ID_TIPOP = 10 OR m.ID_TIPOP = 13)  ORDER BY MODELO ASC";
                                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                    ?>
                                    <?php foreach ($ejecutar as $opciones): ?> 
                                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                                    <?php endforeach?>
                                    </select>
                            </div>


                            <div class="form-group row" style="margin: 10px; padding:10px;">
                                <label id="lblForm" class="col-form-label col-xl col-lg" >N° GOBIERNO:</label> 
                                <input id="serieg" class="form-control col-xl col-lg" placeholder="DE LA IMPRESORA" style="text-transform:uppercase;" name="serieg" required>
                                <label id="lblForm" class="col-form-label col-xl col-lg">N° SERIE:</label> 
                                <input id="serie" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="serie" required>
                            </div>    





                            <div class="form-group row" style="margin: 10px; padding:10px;">
                                <label id="lblForm"class="col-form-label col-xl col-lg">PROCEDENCIA:</label>
                                <select id="proc" name="proc" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
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
                                    <label id="lblForm"class="col-form-label col-xl col-lg">USUARIO:</label>
                            <select id="usu" name="usu" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                        <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                        <?php
                                        include("../particular/conexion.php");
                                        $consulta= "SELECT * FROM usuarios WHERE ACTIVO LIKE 'ACTIVO' ORDER BY NOMBRE ASC";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_USUARIO'] ?>><?php echo $opciones['NOMBRE']?></option>
                                        <?php endforeach?>
                                    </select>
                            </div> 




                            <div class="form-group row" style="margin: 10px; padding:10px;">
                                <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:</label>
                                <select id="est" name="est" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                                        <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                        <?php
                                        include("../particular/conexion.php");
                                        $consulta= "SELECT * FROM estado_ws ORDER BY ESTADO ASC";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_ESTADOWS'] ?>><?php echo $opciones['ESTADO']?></option>
                                        <?php endforeach?>
                                    </select>
                                    <label id="lblForm" class="col-form-label col-xl col-lg">GARANTIA:</label> 
                                <input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar" placeholder="TIEMPO DE GARANTIA" >
                            </div> 




                            <div class="form-group row" style="margin: 10px; padding:10px;">
                                <label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR:</label>
                                <select name="prov" style="text-transform:uppercase" class="form-control col-xl col-lg">
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
                                <label id="lblForm" class="col-form-label col-xl col-lg">MAC:</label> 
                                <input class="form-control col-xl col-lg" name="mac" placeholder="N° MAC">
                                <label id="lblForm"class="col-form-label col-xl col-lg">RESERVA IP:</label>
                                <select name="reserva" class="form-control col-xl col-lg">
                                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>




                            <div class="form-group row" style="margin: 10px; padding:10px;"> 
                                <label id="lblForm" class="col-form-label col-xl col-lg">IP:</label> 
                                <input class="form-control col-xl col-lg" name="ip" placeholder="N° IP">
                                <label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓN:</label> 
                                <textarea class="form-control col-xl col-lg" name="obs" placeholder="Observaciónes" style="text-transform:uppercase" rows="3"></textarea>
                            </div>

                            <?php 
                                if ($row['ID_PERFIL'] != 5) {
                                    echo'<div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
                                        <input onClick="enviar_formulario(this.form)" style="width: 20%;"class="col-3 button" type="button" value="GUARDAR IMPRESORA" class="button">
                                    </div> ';
                                }
                            ?>   
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
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>