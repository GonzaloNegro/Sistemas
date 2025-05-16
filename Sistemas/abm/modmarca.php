<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{	
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM marcas WHERE ID_MARCA='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_MARCA'],/*0*/
		$filas['MARCA'],/*1*/
	];
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>MODIFICAR MARCA</title>
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
                        selector: "#marca",
                        errorMessage: "No ingresó nombre de la marca."
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
    formulario.querySelector('#accion').value = accion;
    if (validar_formulario()) {
        const campos = [
            { id: 'marca', label: 'Nombre de la marca' }
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
		<strong style="color:red;">Recuerde que cambiar datos de la marca afectará los registros.</strong>`;


        mensajeHtml += '<br><strong>¿Está seguro de modificar esta marca?</strong><br><br>';

        Swal.fire({
            title: "Datos modificados de la marca",
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
            <a id="vlv"  href="abmmarcas.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
		<div id="titulo">
			<h1>MODIFICAR MARCA</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid">
            <form method="POST" action="./modificados.php">
				<div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">ID: </label>
                    <input type="text" class="id" name="id" style="background-color:transparent;" value="<?php echo $consulta[0]?>" readonly>
                </div>
                    <!--//////////////////////////////////AREA//////////////////////////////////////-->
					<div class="form-group row">
                	<label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE DE LA MARCA: </label>
                	<input style="margin-top: 5px"class="form-control col-form-label col-xl col-lg" type="text" name="marca" id="marca" value="<?php echo $consulta[1]?>">
				</div>
                <input type="hidden" id="accion" name="accion" value="modMarca">
				<div class="form-group row justify-content-end">
					<input onclick="enviar_formulario(this.form, 'modMarca')" style="width:20%" class="btn btn-success" type="button" value="MODIFICAR" name="modMarca" class="button">
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