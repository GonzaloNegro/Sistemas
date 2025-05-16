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
    $datos_base = mysqli_connect('localhost', 'root', '', 'incidentes') 
        or exit('No se puede conectar con la base de datos');

	$no_tic = mysqli_real_escape_string($datos_base, $no_tic);

    $sentencia = "SELECT * FROM pvideo WHERE ID_PVIDEO='" . $no_tic . "'";
    $resultado = mysqli_query($datos_base, $sentencia);

    return mysqli_fetch_assoc($resultado);
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
</head>
<body>
    <script>
        function validar_formulario(){
			
			var fieldsToValidate = [
                    {
                        selector: "#memoria",
                        errorMessage: "No ingresó la memoria de la placa de video."
                    },
                    {
                        selector: "#modelo",
                        errorMessage: "No seleccionó modelo."
                    },
                    {
                        selector: "#tipo",
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

    function enviar_formulario(formulario, accion) {
        // Asigna el valor de la acción al campo oculto "accion"
        if (validar_formulario()) {

        const campos = [
            { id: 'memoria', label: 'Memoria de la placa de video', esSelect: true  },
            { id: 'modelo', label: 'Modelo', esSelect: true },
            { id: 'tipo', label: 'Tipo de memoria', esSelect: true }
        ];

        let mensajeHtml = "<ul style='text-align:left;'>"; 

        campos.forEach(campo => {
            const elemento = document.getElementById(campo.id);
            let valor = campo.esSelect
                ? elemento.options[elemento.selectedIndex].text
                : elemento.value;

            if (valor.trim() !== "") {
                mensajeHtml += `<li><strong>${campo.label}:</strong> ${valor.toUpperCase()}</li>`;
            }
        });

        mensajeHtml += "</ul>";

        mensajeHtml += `<br>
            <strong style="color:red;">Recuerde que cambiar los datos de la placa de video afectará los registros.</strong>`;

        mensajeHtml += '<br><strong>¿Está seguro de modificar esta placa de video?</strong><br><br>';

        Swal.fire({
            title: "Datos modificados de la placa de video",
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
            <a id="vlv"  href="abmplacav.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
        <section id="Inicio">
		<div id="titulo">
			<h1>MODIFICAR PLACA DE VIDEO</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
            <?php 
            $sent= "SELECT MEMORIA FROM memoria WHERE ID_MEMORIA = $consulta[ID_MEMORIA]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $mem = $row['MEMORIA'];

            $sent= "SELECT MODELO FROM modelo WHERE ID_MODELO = $consulta[ID_MODELO]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $mod = $row['MODELO'];

            $sent= "SELECT TIPOMEM FROM tipomem WHERE ID_TIPOMEM = $consulta[ID_TIPOMEM]";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $tipo = $row['TIPOMEM'];
            ?>
            <form method="POST" action="./modificados.php">
                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">ID: </label>
                    <input type="text" class="id" name="id" style="background-color:transparent;" value="<?php echo $consulta['ID_PVIDEO']?>" readonly>
                </div>
                
                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">MEMORIA:</label>
                    <select name="memoria" id="memoria" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
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
                    <select name="modelo" id="modelo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
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
                    <select name="tipo" style="text-transform:uppercase" id="tipo" class="form-control col-xl col-lg" required>
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
                <!-- Campo oculto para la acción -->
                <input type="hidden" id="accion" name="accion" value="modPlacav">
                <div class="row justify-content-end">
                    <input onclick="enviar_formulario(this.form, 'modPlacav')" style="width: 20%;"class="btn btn-success" type="button" name="modPlacav" value="MODIFICAR" >
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