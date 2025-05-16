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

    $sentencia = "SELECT * FROM placam WHERE ID_PLACAM='" . $no_tic . "'";
    $resultado = mysqli_query($datos_base, $sentencia);

    return mysqli_fetch_assoc($resultado);
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
</head>
<body>
    <script>
          function validar_formulario(){
			
			var fieldsToValidate = [
                    {
                        selector: "#placam",
                        errorMessage: "No ingresó nombre de la placa madre."
                    },
                    {
                        selector: "#marca",
                        errorMessage: "No ingresó una marca."
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
            { id: 'placam', label: 'Nombre de la placa madre' },
            { id: 'marca', label: 'Marca', esSelect: true }
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
            <strong style="color:red;">Recuerde que cambiar los datos de la placa madre afectará los registros.</strong>`;

        mensajeHtml += '<br><strong>¿Está seguro de modificar esta placa madre?</strong><br><br>';

        Swal.fire({
            title: "Datos modificados de la placa madre",
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
                $sent= "SELECT MARCA FROM marcas WHERE ID_MARCA = $consulta[ID_MARCA]";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $ma = $row['MARCA'];?>
                <form method="POST" action="./modificados.php">
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">ID: </label>
                        <input type="text" class="id" name="id" style="background-color:transparent;" value="<?php echo $consulta['ID_PLACAM']?>" readonly>
                    </div>
                    
                    <div class="form-group row">
                        <label id="lblForm" class="col-form-label col-xl col-lg">PLACA MADRE:</label>
                        <input class="form-control col-xl col-lg" id="placam" type="text" name="placam" placeholder="NOMBRE DEL MODELO" style="text-transform:uppercase;" value="<?php echo $consulta['PLACAM']?>" required>
                    </div>
                        
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">MARCA:</label>
                        <select name="marca" id="marca" class="form-control col-xl col-lg" style="text-transform:uppercase">
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
                    <!-- Campo oculto para la acción -->
                    <input type="hidden" id="accion" name="accion" value="modPLacam">
                    <div class="row justify-content-end">
                        <input onclick="enviar_formulario(this.form, 'modPLacam')" style="width: 20%;"class="btn btn-success" type="button" name="modPLacam" value="MODIFICAR" >
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