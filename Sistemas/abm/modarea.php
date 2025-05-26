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

    $sentencia = "SELECT * FROM area WHERE ID_AREA='" . $no_tic . "'";
    $resultado = mysqli_query($datos_base, $sentencia);

    return mysqli_fetch_assoc($resultado);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>MODIFICAR ÁREA</title>
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
                        selector: "#area",
                        errorMessage: "No ingresó nombre del área."
                    },
                    {
                        selector: "#repa",
                        errorMessage: "No ingresó repartición."
                    },
                    {
                        selector: "#estado",
                        errorMessage: "No ingresó estado."
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
        const estadoActual = "<?php echo $consulta['ID_ESTADOUSUARIO']; ?>";
        const estadoSeleccionado = document.getElementById("estado").value;

        const campos = [
            { id: 'area', label: 'Nombre del área' },
            { id: 'repa', label: 'Repartición', esSelect: true },
            { id: 'estado', label: 'Estado', esSelect: true },
            { id: 'observacion', label: 'Observaciones' }
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

        if (estadoActual === "1" && estadoSeleccionado === "2") {
            mensajeHtml += `<br>
                <strong style="color:red;">Recuerde que cambiar el estado del área a INACTIVO afectará su funcionamiento.
                <br>Los usuarios asignados a esta área dejarán de tener una área asignada.</strong>`;
        }

        mensajeHtml += '<br><strong>¿Está seguro de modificar esta área?</strong><br><br>';

        Swal.fire({
            title: "Datos modificados del área",
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
            <a id="vlv"  href="abmarea.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
		<div id="titulo">
			<h1>MODIFICAR ÁREA</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid">
                <?php 
                include("../particular/conexion.php");
                $sent= "SELECT REPA FROM reparticion WHERE ID_REPA = $consulta[ID_REPA]";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $repa = $row['REPA'];

                $sent= "SELECT ESTADO FROM estado_usuario WHERE ID_ESTADOUSUARIO = $consulta[ID_ESTADOUSUARIO]";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $estado = $row['ESTADO'];

                ?>
                <form method="POST" action="./modificados.php">
                    <div class="form-group row" >
						<label id="lblForm"class="col-form-label col-xl col-lg">ID:</label>
                        <input type="text" class="id" name="id" style="background-color:transparent;" class="form-control col-form-label col-xl col-lg" value="<?php echo $consulta['ID_AREA']?>" readonly>
					</div>	

                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE DEL ÁREA:<span style="color:red;">*</span></label>
                        <input id="area" style="margin-top: 5px;text-transform:uppercase;" class="form-control col-form-label col-xl col-lg" type="text" name="area" value="<?php echo $consulta['AREA']?>">
                    </div>
                    
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">OBSERVACIONES:</label>
						<textarea class="form-control col-form-label col-xl col-lg" id="observacion" name="obs" style="text-transform:uppercase" rows="3"><?php echo $consulta['OBSERVACION']?></textarea>
                    </div>
                    
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:<span style="color:red;">*</span></label>
                        <select id="estado" name="estado" style="text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                            <option selected value="200"><?php echo $estado?></option>
                            <?php
                            include("../particular/conexion.php");
                            $consulta= "SELECT * FROM estado_usuario";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                            <option value= <?php echo $opciones['ID_ESTADOUSUARIO'] ?>><?php echo $opciones['ESTADO']?></option>
                            <?php endforeach?>
                            </select>
                    </div>
                        
                        
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">REPARTICIÓN:<span style="color:red;">*</span></label>
                        <select id="repa" name="repa" style="text-transform:uppercase" class="form-control col-form-label col-xl col-lg">
                            <option selected value="100"><?php echo $repa?></option>
                            <?php
                            include("../particular/conexion.php");
                            $consulta= "SELECT * FROM reparticion ORDER BY REPA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                            <option value= <?php echo $opciones['ID_REPA'] ?>><?php echo $opciones['REPA']?></option>
                            <?php endforeach?>
                        </select>
                    </div>
                    <!-- Campo oculto para la acción -->
                    <input type="hidden" id="accion" name="accion" value="modArea">
                    <div class="form-group row justify-content-end">
                        <input onclick="enviar_formulario(this.form, 'modArea')" style="width:20%" type="button" value="MODIFICAR" name="modArea" class="btn btn-success">
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