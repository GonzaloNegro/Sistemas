<?php 
/* error_reporting(0); */
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['no']);

function ConsultarIncidente($no_tic)
{
    try {
        $datos_base = mysqli_connect('localhost', 'root', '', 'incidentes');

        if (!$datos_base) {
            throw new Exception("Error al conectar con la base de datos: " . mysqli_connect_error());
        }

        $no_tic = mysqli_real_escape_string($datos_base, $no_tic);

        $sentencia = "SELECT * FROM resolutor WHERE ID_RESOLUTOR='" . $no_tic . "'";
        $resultado = mysqli_query($datos_base, $sentencia);

        if (!$resultado) {
            throw new Exception("Error al ejecutar la consulta: " . mysqli_error($datos_base));
        }

        return mysqli_fetch_assoc($resultado);
    } catch (Exception $e) {
        // Podés loguear el error, redirigir, o mostrar algo más amigable
        echo "Hubo un problema al consultar el incidente: " . $e->getMessage();
        return null;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>MODIFICAR RESOLUTOR</title>
    <link rel="icon" href="../imagenes/logoInfraestructura.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">

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

        const perfilActual = "<?php echo $consulta['ID_PERFIL']; ?>";
        let perfilCambiado = false;

        document.addEventListener("DOMContentLoaded", function() {
            const selectPerfil = document.getElementById("perfil");

            // Cuando se cambia el perfil, se valida si es distinto al perfil actual
            selectPerfil.addEventListener("change", function() {
                const nuevoPerfil = this.value;
                perfilCambiado = nuevoPerfil !== perfilActual;
            });
        });

function enviar_formulario(formulario) {
    if (validar_formulario()) {
        let mensajeHtml = "";  // Mensaje que se mostrará en el modal
        let datosValidos = false;  // Variable para verificar si hay datos válidos

        // Campos a validar
        const campos = [
            { id: 'nombre_resolutor', label: 'Nombre del resolutor' },
            { id: 'cuil', label: 'Cuil'},
            { id: 'correo', label: 'Correo'},
            { id: 'telefono', label: 'Teléfono' },
            { id: 'tipo', label: 'Tipo', esSelect: true },
            { id: 'perfil', label: 'Perfil', esSelect: true},
        ];

        // Validación de los campos
        let mensajeCampos = "<ul style='text-align:left;'>";
        campos.forEach(campo => {
            const elemento = document.getElementById(campo.id);
            let valor = campo.esSelect
                ? elemento.options[elemento.selectedIndex].text
                : elemento.value;

            if (valor.trim() !== "") {
                mensajeCampos += `<li><strong>${campo.label}:</strong> ${valor}</li>`;
                datosValidos = true;  // Si hay datos válidos, establecemos la bandera
            }
        });
        mensajeCampos += "</ul>";

        // Si no hay datos válidos, mostramos un mensaje de advertencia
        if (!datosValidos) {
    mensajeHtml = "<p style='color:red;'>No hay datos para guardar. Por favor, complete los campos requeridos.</p>";
} else {
    mensajeHtml = mensajeCampos; // Primero los campos válidos

    if (perfilCambiado) {
        // Concatenar el mensaje de advertencia del perfil
        mensajeHtml += `
            <br><strong style="color:red;">El perfil seleccionado podría no tener acceso a algunas funciones o pantallas disponibles para otros perfiles.</strong>`;
    }

    // Finalmente, el mensaje de confirmación
    mensajeHtml += '<br><strong>¿Está seguro de modificar este resolutor?</strong><br><br>';
}


        // Mostramos el modal de confirmación con SweetAlert
        Swal.fire({
            title: "Datos modificados del resolutor",
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
                formulario.submit();  // Si el usuario confirma, se envía el formulario
            }
        });
    }
}

</script>

				
		</script>

    <main>
    <div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="abmresolutor.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
    <div id="titulo">
			<h1>MODIFICAR RESOLUTOR</h1>
		</div>
        <?php 
            try {
                $sent = "SELECT TIPO_RESOLUTOR FROM tipo_resolutor WHERE ID_TIPO_RESOLUTOR = '" . $consulta['ID_TIPO_RESOLUTOR'] . "'";
                $resultado = $datos_base->query($sent);
            
                if (!$resultado) {
                    throw new Exception("Error al obtener el tipo de resolutor: " . $datos_base->error);
                }
            
                $row = $resultado->fetch_assoc();
                $tr = $row['TIPO_RESOLUTOR'];
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            try {
                $sent= "SELECT * FROM perfiles WHERE id_perfil= '".$consulta['ID_PERFIL']."'";
                $resultado = $datos_base->query($sent);
            
                if (!$resultado) {
                    throw new Exception("Error al obtener el tipo de resolutor: " . $datos_base->error);
                }
            
                $row = $resultado->fetch_assoc();
                $tp = $row['PERFILES'];
            } catch (Exception $e) {
                echo $e->getMessage();
            }

        ?>        
		<div id="principalu" style="width: 97%" class="container-fluid">
            <form method="POST" action="./modificados.php">
				<div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">ID: </label>
                    <input type="text" class="id" name="id" style="background-color:transparent;" value="<?php echo $consulta['ID_RESOLUTOR']?>" readonly>
                </div>

                <div class="form-group row">
                    <label id="lblForm" class="col-form-label col-xl col-lg">NOMBRE: </label>
                    <input id="nombre_resolutor" class="form-control col-xl col-lg" style="text-transform:uppercase;" type="text" name="nom" value="<?php echo $consulta['RESOLUTOR']?>">
                </div>
                <div class="form-group row">
                    <label id="lblForm" class="col-form-label col-xl col-lg">CUIL: </label>
                    <input id="cuil" class="form-control col-xl col-lg" type="text" name="cuil" value="<?php echo $consulta['CUIL']?>">
                </div>

                <div class="form-group row">
                    <label id="lblForm" class="col-form-label col-xl col-lg">CORREO: </label>
                    <input id="correo" class="form-control col-xl col-lg" type="text" name="cor" value="<?php echo $consulta['CORREO']?>">
                </div>
                <div class="form-group row">
                    <label id="lblForm" class="col-form-label col-xl col-lg">TELEFONO: </label>
                    <input id="telefono" class="form-control col-xl col-lg" type="text" name="tel" value="<?php echo $consulta['TELEFONO']?>">
                </div>

                <div class="form-group row">
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
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-xl col-lg">PERFIL:</label>
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
                <div class="row justify-content-end">
                    <input onclick="enviar_formulario(this.form)" style="width: 20%;" class="btn btn-success" type="button" name="modResolutor" value="MODIFICAR">
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