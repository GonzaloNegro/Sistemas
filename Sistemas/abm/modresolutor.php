<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT r.ID_RESOLUTOR,r.RESOLUTOR,r.ID_TIPO_RESOLUTOR,r.CUIL,r.CORREO,r.TELEFONO,r.ID_PERFIL,p.PERFILES 
    FROM resolutor r inner join perfiles p on r.ID_PERFIL=p.ID_PERFIL WHERE ID_RESOLUTOR='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_RESOLUTOR'],/*0*/
		$filas['RESOLUTOR'],/*1*/
		$filas['ID_TIPO_RESOLUTOR'],/*2*/
        $filas['CUIL'],/*3*/
        $filas['CORREO'],/*4*/
        $filas['TELEFONO'],/*5*/
        $filas['ID_PERFIL'],/*6*/
        $filas['PERFILES']/*7*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>MODIFICAR RESOLUTOR</title>
    <link rel="icon" href="../imagenes/logoInfraestructura.png">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
<script>
        function validar_formulario(){
			
			var fieldsToValidate = [
                    {
                        selector: "#nombre_resolutor",
                        errorMessage: "No ingresó nombre del resolutor."
                    },
                    {
                        selector: "#cuil",
                        errorMessage: "No ingresó cuil."
                    },
                    {
                        selector: "#correo",
                        errorMessage: "No ingresó correo."
                    },
                    {
                        selector: "#telefono",
                        errorMessage: "No ingresó teléfono."
                    },
                    {
                        selector: "#tipo",
                        errorMessage: "No seleccionó tipo."
                    },
                    {
                        selector: "#perfil",
                        errorMessage: "No seleccionó perfil."
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
                        title: "Esta seguro de modificar este resolutor?",
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
            <a id="vlv"  href="abmresolutor.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
    <div id="titulo" style="margin: 20px;">
			<h1>MODIFICAR RESOLUTOR</h1>
		</div>
        <?php 
                        //TIPO RESOLUTOR
                        include("../particular/conexion.php");
                        $sent= "SELECT TIPO_RESOLUTOR FROM tipo_resolutor WHERE ID_TIPO_RESOLUTOR = $consulta[2]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $tr = $row['TIPO_RESOLUTOR'];?>
                        <?php
                        //PERFIL
                        include("../particular/conexion.php");
                        $sent= "SELECT * FROM perfiles WHERE id_perfil=$consulta[6]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $tp = $row['PERFILES'];
                        ?>
                        
		<div id="principalu" style="width: 97%" class="container-fluid">
                <form method="POST" action="guardarmodresolutor2.php">
                    <label>ID: </label>&nbsp &nbsp 
                    <input type="text" class="id" name="id" value="<?php echo $consulta[0]?>">

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">NOMBRE: </label>
                        <input id="nombre_resolutor" class="form-control col-xl col-lg" style="text-transform:uppercase;" type="text" name="nom" value="<?php echo $consulta[1]?>">
                        <label id="lblForm" class="col-form-label col-xl col-lg">CUIL: </label>
                        <input id="cuil" class="form-control col-xl col-lg" type="text" name="cuil" value="<?php echo $consulta[3]?>">
                   </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">CORREO: </label>
                        <input id="correo" class="form-control col-xl col-lg" type="text" name="cor" value="<?php echo $consulta[4]?>">
                        <label id="lblForm" class="col-form-label col-xl col-lg">TELEFONO: </label>
                        <input id="telefono" class="form-control col-xl col-lg" type="text" name="tel" value="<?php echo $consulta[5]?>">
                    </div>

                    <div class="form-group row" style="margin: 10px; padding:10px;">
                        <label id="lblForm" class="col-form-label col-xl col-lg">TIPO DE RESOLUTOR:</label>
                        <select id="tipo" name="tipo" class="form-control col-xl col-lg" style="text-transform:uppercase">
                                        <option selected value="100"><?php echo $tr?></option>
                                        <?php
                                        include("../particular/conexion.php");
                                        $consulta= "SELECT * FROM tipo_resolutor ORDER BY TIPO_RESOLUTOR ASC";
                                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?> 
                                        <option value= <?php echo $opciones['ID_TIPO_RESOLUTOR'] ?>><?php echo $opciones['TIPO_RESOLUTOR']?></option>
                                        <?php endforeach?>
                        </select>
                        <label id="lblForm"class="col-form-label col-xl col-lg">PERFIL:</label>
								<select id="perfil" name="perfil" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
								<option selected value="101"><?php echo $tp?></option>
								<?php
								include("../particular/conexion.php");
								$consulta= "SELECT * FROM perfiles ORDER BY PERFILES ASC";
								$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
								?>
								<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_PERFIL']?>"><?php echo $opciones['PERFILES']?></option>
								<?php endforeach ?>
								</select>
                    </div>
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                    <div class="row justify-content-end" style="margin: 10px; padding:10px;">
                        <input onClick="enviar_formulario(this.form)" style="width: 20%;"class="col-3 button" type="button" value="MODIFICAR">
                    </div>
                </form>
	    </div>
	</section>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>