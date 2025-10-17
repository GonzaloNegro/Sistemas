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

    $sentencia = "SELECT * FROM usuarios WHERE ID_USUARIO='" . $no_tic . "'";
    $resultado = mysqli_query($datos_base, $sentencia);

    return mysqli_fetch_assoc($resultado);
}

?>
<!DOCTYPE html>
<html>
<head>
<title>MODIFICAR USUARIO</title>
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
                        selector: "#nombre",
                        errorMessage: "No ingresó nombre del usuario."
                    },
                    {
                        selector: "#cuil",
                        errorMessage: "No ingresó el cuil del usuario."
                    }
                    ,
                    {
                        selector: "#act",
                        errorMessage: "No seleccionó estado."
                    }
                    ,
                    {
                        selector: "#are",
                        errorMessage: "No seleccionó área."
                    }
                    ,
                    {
                        selector: "#tur",
                        errorMessage: "No seleccionó turno."
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
    formulario.querySelector('#accion').value = accion;

    if (validar_formulario()) {
        const estadoActual = "<?php echo $consulta['ID_ESTADOUSUARIO']; ?>";
        const estadoSeleccionado = document.getElementById("act").value;
        const idUsuario = document.getElementById("id_usuario").value;

        const campos = [
            { id: 'nombre', label: 'Nombre' },
            { id: 'cuil', label: 'Cuil' },
            { id: 'interno', label: 'Interno'},
            { id: 'obs', label: 'Observación'},
            { id: 'correo', label: 'Correo' },
            { id: 'correoPer', label: 'Correo Personal'},
            { id: 'tel', label: 'Teléfono'},
            { id: 'piso', label: 'Piso', esSelect: true },
            { id: 'act', label: 'Estado', esSelect: true  },
            { id: 'are', label: 'Área', esSelect: true },
            { id: 'tur', label: 'Turno', esSelect: true }
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

        // Solo mostrar listado de equipos/periféricos si el usuario va de activo (1) a inactivo (2)
        if (estadoActual === "1" && estadoSeleccionado === "2") {
            fetch('obtener_equipos_perifericos.php?id_usuario=' + idUsuario)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error("Error:", data.error);
                        mensajeHtml += "<p><strong>Equipos y Periféricos actualmente asignados:</strong> Error al cargar.</p>";
                    } else if (data.datos && data.datos.length > 0) {
                        mensajeHtml += "<p><strong>Equipos y Periféricos asignados:</strong></p>";
                        mensajeHtml += "<ul style='text-align:left; padding-left:0; margin-left:5;'>";
                        data.datos.forEach(item => {
                            mensajeHtml += `<li style="margin-left:10; list-style-position: inside;"><strong>${item.serie_equipo}</strong>`;
                            if (item.perifericos && item.perifericos.length > 0) {
                                mensajeHtml += ` → ${item.perifericos.length} periférico(s)`;
                            } else {
                                mensajeHtml += " → Sin periféricos activos";
                            }
                            mensajeHtml += "</li>";
                        });
                        mensajeHtml += "</ul>";
                    } else {
                        mensajeHtml += "<p><strong>Equipos y Periféricos asignados:</strong> Ninguno activo.</p>";
                    }

                    mensajeHtml += `<br>
                        <strong style="color:red;">
                            Recuerde que cambiar el estado del usuario a INACTIVO afectará su funcionamiento.
                            <br>Los periféricos y equipos asignados a este usuario dejarán de tener un usuario asignado.
                        </strong>`;
                    
                    mensajeHtml += '<br><strong>¿Está seguro de modificar este usuario?</strong><br><br>';

                    Swal.fire({
                        title: "Datos modificados del usuario",
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
                })
                .catch(error => {
                    console.error("Error en la carga de equipos:", error);
                    mensajeHtml += "<p><strong>Equipos/Periféricos:</strong> No se pudieron cargar.</p>";
                    mensajeHtml += '<br><strong>¿Está seguro de modificar este usuario?</strong><br><br>';

                    Swal.fire({
                        title: "Datos modificados del usuario",
                        icon: "warning",
                        html: mensajeHtml,
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Confirmar',
                        cancelButtonText: "Cancelar",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formulario.submit();
                        }
                    });
                });
        } else {
            // Para cualquier otro cambio de estado, solo mostrar los datos del usuario sin equipos
            mensajeHtml += '<br><strong>¿Está seguro de modificar este usuario?</strong><br><br>';

            Swal.fire({
                title: "Datos modificados del usuario",
                icon: "warning",
                html: mensajeHtml,
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: "Cancelar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit();
                }
            });
        }
    }
}

    </script>
<main>
    <div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="../consulta/consultausuario.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
    <div id="titulo">
			<h1>MODIFICAR USUARIO</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid">
                <?php
                include("../particular/conexion.php");
                $sent= "SELECT a.AREA, r.REPA FROM area a inner join reparticion r on a.ID_REPA=r.ID_REPA WHERE ID_AREA = $consulta[ID_AREA]";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $ar = $row['AREA'];
                $repa = $row['REPA'];

                $sent= "SELECT TURNO FROM turnos WHERE ID_TURNO = $consulta[ID_TURNO]";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $turno = $row['TURNO'];

                $sent= "SELECT ESTADO FROM estado_usuario WHERE ID_ESTADOUSUARIO = $consulta[ID_ESTADOUSUARIO]";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $estado = $row['ESTADO'];
                ?>

                <form method="POST" action="./modificados.php">
                    <div class="form-group row">
                        <label id="lblForm"class="col-form-label col-xl col-lg">ID:</label>
                        <input type="text" class="id" name="id" id="id_usuario" value="<?php echo $consulta['ID_USUARIO']?>" style="background-color:transparent;" readonly>
                    </div>
                    
                    <div class="form-group row">
                        <label id="lblForm" class="col-form-label col-xl col-lg">NOMBRE:<span style="color:red;">*</span></label>
                        <input class="form-control col-xl col-lg" type="text" name="nom" id="nombre" value="<?php echo $consulta['NOMBRE']?>" required>
                    </div>

                    <div class="form-group row">
                        <label id="lblForm" class="col-form-label col-xl col-lg">CUIL:<span style="color:red;">*</span></label>
                        <input class="form-control col-xl col-lg" type="number" name="cuil" id="cuil" oninput="if(this.value.length > 11) this.value = this.value.slice(0, 11)" value="<?php echo $consulta['CUIL']?>" required>
                    </div>
                    
                    <div class="form-group row">
                        <label id="lblForm" class="col-form-label col-xl col-lg">INTERNO:</label>
                        <input class="form-control col-xl col-lg" type="number" name="int" id="interno" value="<?php echo $consulta['INTERNO']?>">
                    </div>

                    <div class="form-group row">
                        <label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓN:</label>
                        <textarea class="form-control col-xl col-lg" name="obs" style="text-transform:uppercase" id="obs" rows="3"><?php echo $consulta['OBSERVACION']?></textarea>
                    </div>

                    <div class="form-group row">
                        <label id="lblForm" class="col-form-label col-xl col-lg">CORREO: </label>
                        <input class="form-control col-xl col-lg" type="email" name="cor" id="correo" value="<?php echo $consulta['CORREO']?>">
                    </div>

                    <div class="form-group row">
                        <label id="lblForm" class="col-form-label col-xl col-lg">CORREO PERSONAL: </label>
                        <input class="form-control col-xl col-lg" type="email" name="corp" id="correoPer" value="<?php echo $consulta['CORREO_PERSONAL']?>">
                    </div>
                    
                    <div class="form-group row">
                        <label id="lblForm" class="col-form-label col-xl col-lg">TELEFONO: </label>
                        <input class="form-control col-xl col-lg" id="tel" type="text" name="tel" value="<?php echo $consulta['TELEFONO_PERSONAL']?>">
                    </div>

                    <div class="form-group row">
                        <label id="lblForm" class="col-form-label col-xl col-lg">PISO:</label>
                        <select name="piso" id="piso" class="form-control col-xl col-lg">
                            <option selected value="300"><?php echo $consulta['PISO']?></option>
                            <option value="PB">PB</option>
                            <option value="P1">P1</option>
                            <option value="P2">P2</option>
                            <option value="P3">P3</option>
                            <option value="P4">P4</option>
                            <option value="P5">P5</option>
                            <option value="P6">P6</option>
                            <option value="P7">P7</option>
                            <option value="P8">P8</option>
                            <option value="P9">P9</option>
                            <option value="EP">EP</option>
                            <option value="SUB">SUB</option>
                        </select>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-xl col-lg">ESTADO:<span style="color:red;">*</span></label>
                        <select id="act" class="form-control col-xl col-lg" name="act" required>
                            <option selected value="400"><?php echo $estado?></option>
                            <?php
                            include("../particular/conexion.php");
                            $consulta= "SELECT ID_ESTADOUSUARIO, ESTADO FROM estado_usuario";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            foreach ($ejecutar as $opciones): 
                                    if ($opciones['ESTADO'] == $estado) continue;
                                ?> 
                                <option value="<?php echo $opciones['ID_ESTADOUSUARIO'] ?>">
                                    <?php echo $opciones['ESTADO']?>
                                </option>
                            <?php endforeach?>
                        </select>
                    </div>

                    <div class="form-group row">
                        <label id="lblForm" class="col-form-label col-xl col-lg">ÁREA:<span style="color:red;">*</span></label>
                        <select  class="form-control col-xl col-lg" id="are" name="are" style="text-transform:uppercase" required>
                        <?php   $equipoBD = "$ar - $repa"; ?>
                        <option selected value="200"><?php echo $equipoBD?></option>
                        <?php
                        include("../particular/conexion.php");
                        $consulta= "SELECT a.ID_AREA, a.AREA, r.REPA 
                        FROM area a 
                        INNER JOIN reparticion r ON a.ID_REPA=r.ID_REPA 
                        WHERE a.ID_ESTADOUSUARIO = 1
                        ORDER BY AREA ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php 
                        $areaNueva=$opciones['AREA'];
                        $repaNueva=$opciones['REPA'];
                        $equipoNuevo="$areaNueva - $repaNueva";?>
                        <?php foreach ($ejecutar as $opciones): 
                            if ($equipoNuevo == $equipoBD) continue;?> 
                        <option value= <?php echo $opciones['ID_AREA'] ?>><?php echo $opciones['AREA']?> - <?php echo $opciones['REPA']?></option>
                        <?php endforeach?>
                        </select>
                    </div>

                    <div class="form-group row">
                        <label id="lblForm" class="col-form-label col-xl col-lg">TURNO:<span style="color:red;">*</span></label>
                        <select id="tur" class="form-control col-xl col-lg" name="tur" style="text-transform:uppercase" required>
                        <option selected value="100"><?php echo $turno?></option>
                        <?php
                        include("../particular/conexion.php");
                        $consulta= "SELECT * FROM turnos ORDER BY TURNO ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): 
                            if ($opciones['TURNO'] == $turno) continue;?> 
                        <option value= <?php echo $opciones['ID_TURNO'] ?>><?php echo $opciones['TURNO']?></option>
                        <?php endforeach?>
                        </select>
                    </div>
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                    <!--/////////////////////////////////////MOTIVO///////////////////////////////////////////-->
                    <input type="hidden" id="accion" name="accion" value="modUsuario">
                    <div class="form-group row justify-content-end">
                        <input onclick="enviar_formulario(this.form, 'modUsuario')" style="width:20%"class="btn btn-success" type="button" name="modUsuario" value="MODIFICAR" class="button">
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
<script>
document.addEventListener("DOMContentLoaded", function () {
    const estadoSelect = document.getElementById("act");
    const areaSelect   = document.getElementById("are");
    const pisoSelect   = document.getElementById("piso");
    const turnoSelect  = document.getElementById("tur");

    function verificarDisponibilidadCampos() {
        // Tomo el texto visible de la opción seleccionada y lo paso a mayúsculas
        const estadoTexto = estadoSelect.options[estadoSelect.selectedIndex].text.toUpperCase();

        // Si el texto dice "INACTIVO", deshabilito los campos
        const inactivo = (estadoTexto === "INACTIVO");

        areaSelect.disabled  = inactivo;
        pisoSelect.disabled  = inactivo;
        turnoSelect.disabled = inactivo;
    }

    // 🔹 Verificar al cargar
    verificarDisponibilidadCampos();

    // 🔹 Verificar cada vez que cambie el estado
    estadoSelect.addEventListener("change", verificarDisponibilidadCampos);
});
</script>




<script>
        function cargarEquipos(equipoAnteriorID = "", equipoAnteriorTexto = "") {
            const equipoSelect = document.getElementById("equipo");

            $.ajax({
                url: "../consulta/consultarEquiposAsignadosDisponibles.php",
                type: "GET",
                data: {
                    equipoAnteriorID: equipoAnteriorID,
                    equipoAnteriorTexto: equipoAnteriorTexto
                },
                success: function(data) {
                    equipoSelect.innerHTML = data;

                    // Intentar dejar seleccionado el equipo anterior si aún existe
                    const opcion = equipoSelect.querySelector(`option[value="${equipoAnteriorID}"]`);
                    if (opcion) {
                        equipoSelect.value = equipoAnteriorID;
                    }
                },
                error: function() {
                    alert("Error al cargar los equipos disponibles.");
                }
            });
        }
    </script>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>