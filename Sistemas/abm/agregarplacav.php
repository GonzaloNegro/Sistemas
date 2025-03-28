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
	<title>AGREGAR PLACA DE VIDEO</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<style>
	<style>
			body{
				background-color: #edf0f5;
			}
	</style>
</head>
<body>
   <script>
        function validar_formulario(){
			
			var fieldsToValidate = [
                    {
                        selector: "#memoria",
                        errorMessage: "No ingresó nombre de placa de video."
                    },
                    {
                        selector: "#modelo",
                        errorMessage: "No seleccionó modelo."
                    },
                    {
                        selector: "#modelo",
                        errorMessage: "No seleccionó tipo."
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
                        title: "Esta seguro de guardar esta placa de video?",
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
            <a id="vlv"  href="abmplacav.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
        <section id="Inicio">
		<div id="titulo" style="margin: 20px;">
			<h1>AGREGAR PLACA DE VIDEO</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
            <form method="POST" action="guardarmodplacav.php">
            <div class="form-group row" style="margin: 10px; padding:10px;">
                <label id="lblForm"class="col-form-label col-xl col-lg">MEMORIA:</label>
                <select id="memoria" name="memoria" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                        <option selected disabled="memoria">-SELECCIONE UNA-</option>
                        <?php
                        include("../particular/conexion.php");

                        $consulta= "SELECT * FROM memoria ORDER BY MEMORIA ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                            <option value="<?php echo $opciones['ID_MEMORIA']?>"><?php echo $opciones['MEMORIA']?></option>						
                    <?php endforeach ?>
                </select>

                <label id="lblForm"class="col-form-label col-xl col-lg">MODELO:</label>
                <select id="modelo" name="modelo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                        <option selected disabled="modelo">-SELECCIONE UNA-</option>
                        <?php
                        include("../particular/conexion.php");

                        $consulta= "SELECT * FROM modelo WHERE ID_TIPOP = 15 ORDER BY MODELO ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                            <option value="<?php echo $opciones['ID_MODELO']?>"><?php echo $opciones['MODELO']?></option>						
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group row" style="margin: 10px; padding:10px;">
                <label id="lblForm"class="col-form-label col-xl col-lg">TIPO MEMORIA:</label>
                <select id="tipo" name="tipo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                        <option selected disabled="tipo">-SELECCIONE UNA-</option>
                        <?php
                        include("../particular/conexion.php");

                        $consulta= "SELECT * FROM tipomem ORDER BY TIPOMEM ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                            <option value="<?php echo $opciones['ID_TIPOMEM']?>"><?php echo $opciones['TIPOMEM']?></option>						
                    <?php endforeach ?>
                </select>
            </div>

            <div class="row justify-content-end" style="margin: 10px; padding:10px;">
                <input onClick="enviar_formulario(this.form)" style="width: 20%;"class="col-3 button" type="button" value="GUARDAR" >
            </div>
        </form>
		</div>
	</section>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>