<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
    $datos_base = mysqli_connect('localhost', 'root', '', 'incidentes') 
        or exit('No se puede conectar con la base de datos');

	$no_tic = mysqli_real_escape_string($datos_base, $no_tic);

    $sentencia = "SELECT * FROM modelo WHERE ID_MODELO='" . $no_tic . "'";
    $resultado = mysqli_query($datos_base, $sentencia);

    return mysqli_fetch_assoc($resultado);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>MODIFICAR MODELOS</title>
    <link rel="icon" href="../imagenes/logoInfraestructura.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
</head>
<body>
    <script>
          function validar_formulario(){
			
			var fieldsToValidate = [
                    {
                        selector: "#modelo",
                        errorMessage: "No ingresó nombre del modelo."
                    },
                    {
                        selector: "#marca",
                        errorMessage: "No ingresó una marca."
                    },
                    {
                        selector: "#tipo",
                        errorMessage: "No ingresó el tipo de periférico."
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

        function enviar_formulario(formulario) {
        if (validar_formulario()) {

        const campos = [
            { id: 'modelo', label: 'Nombre del modelo' },
            { id: 'marca', label: 'Marca', esSelect: true },
            { id: 'tipo', label: 'Tipo Periférico', esSelect: true }
        ];

        let mensajeHtml = "<ul style='text-align:left;'>"; 

        campos.forEach(campo => {
            const elemento = document.getElementById(campo.id);
            let valor = campo.esSelect
                ? elemento.options[elemento.selectedIndex].text
                : elemento.value;

            if (valor.trim() !== "") {
                mensajeHtml += `<li><strong>${campo.label}:</strong> ${valor}</li>`;
            }
        });

        mensajeHtml += "</ul>";

        mensajeHtml += `<br>
            <strong style="color:red;">Recuerde que cambiar los datos del modelo afectará los registros.</strong>`;

        mensajeHtml += '<br><strong>¿Está seguro de modificar este modelo?</strong><br><br>';

        Swal.fire({
            title: "Datos modificados del modelo",
            icon: "warning",
            html: mensajeHtml,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: "Cancelar",
            reverseButtons: true,
            customClass: {
                actions: 'reverse-button'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                formulario.submit();
            }
        });
    }
}
    </script>
<main>
    <div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="abmmodelos.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
    <div id="titulo">
			<h1>MODIFICAR MODELO</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid">
                       <!--  CONSULTA DE DATOS -->
                        <?php 
                        include("..particular/conexion.php");
                        $sent= "SELECT TIPO FROM tipop WHERE ID_TIPOP = $consulta[ID_TIPOP]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $tp = $row['TIPO'];?>
                        <?php 
                        include("..particular/conexion.php");
                        $sent= "SELECT MARCA FROM marcas WHERE ID_MARCA = $consulta[ID_MARCA]";
                        $resultado = $datos_base->query($sent);
                        $row = $resultado->fetch_assoc();
                        $ma = $row['MARCA'];?>
                        <!--  CONSULTA DE DATOS -->

            <form method="POST" action="./modificados.php">
                <div class="form-group row">
				    <label id="lblForm"class="col-form-label col-xl col-lg">ID: </label>
                    <input type="text" class="id" name="id" style="background-color:transparent;" value="<?php echo $consulta['ID_MODELO']?>" readonly>
                </div>

                <div class="form-group row">
                    <label id="lblForm" class="col-form-label col-xl col-lg">NOMBRE DEL MODELO: </label>
                    <input class="form-control col-xl col-lg" id="modelo" type="text" name="modelo" value="<?php echo $consulta['MODELO']?>">
                </div>

                <div class="form-group row">
                    <label id="lblForm" class="col-form-label col-xl col-lg">MARCA: </label>
                    <select name="marca" style="text-transform:uppercase" id="marca" class="form-control col-xl col-lg">
                    <option selected value="100"><?php echo $ma?></option>
                    <?php
                    include("..particular/conexion.php");
                    $consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_MARCA'] ?>><?php echo $opciones['MARCA']?></option>
                    <?php endforeach?>
                    </select>
                </div>

                <div class="form-group row">
                    <label id="lblForm" class="col-form-label col-xl col-lg">TIPO: </label>
                    <select name="tipo" style="text-transform:uppercase" id="tipo" class="form-control col-xl col-lg">
                    <option selected value="200"><?php echo $tp?></option>
                    <?php
                    include("..particular/conexion.php");
                    $consulta= "SELECT * FROM tipop ORDER BY TIPO ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_TIPOP'] ?>><?php echo $opciones['TIPO']?></option>
                    <?php endforeach?>
                    </select>
                </div>
                <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                <div class="row justify-content-end">
                    <input onclick="enviar_formulario(this.form)" style="width: 20%;" class="btn btn-success" type="button" name="modModelo" value="MODIFICAR">
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