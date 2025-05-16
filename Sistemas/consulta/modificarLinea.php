<?php 
error_reporting(0);
session_start();
include('../particular/conexion.php');

$consulta = ConsultarIncidente($_GET['num']);

function ConsultarIncidente($no_tic)
{	
    $datos_base = mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');

	$no_tic = mysqli_real_escape_string($datos_base, $no_tic);

    $sentencia = "SELECT * FROM linea WHERE ID_LINEA='" . $no_tic . "'";
    $resultado = mysqli_query($datos_base, $sentencia);

    return mysqli_fetch_assoc($resultado);
}

$idLinea= $consulta['ID_LINEA'];
$nro= $consulta['NRO'];
$idEstado = $consulta['ID_ESTADOWS'];
$idPlan = $consulta['ID_PLAN'];
$descuento = $consulta['DESCUENTO'];
$fechaDescuento = $consulta['FECHADESCUENTO'];
$idNombrePlan = $consulta['ID_NOMBREPLAN'];
$idRoaming = $consulta['ID_ROAMING'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>MODIFICAR LINEA</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
</head>
<body>
<script>
          function validar_formulario(){
			
			var fieldsToValidate = [
                    {
                        selector: "#cardnumber",
                        errorMessage: "No seleccionó el número."
                    },
                    {
                        selector: "#usuario",
                        errorMessage: "No seleccionó un usuario."
                    },
                    {
                        selector: "#celulares",
                        errorMessage: "No seleccionó un celular."
                    },
                    {
                        selector: "#estado",
                        errorMessage: "No seleccionó un estado."
                    },
                    {
                        selector: "#roaming",
                        errorMessage: "No seleccionó el roaming."
                    },
                    {
                        selector: "#descuento",
                        errorMessage: "No ingresó un descuento."
                    },
                    {
                        selector: "#nombrePlan",
                        errorMessage: "No ingresó un plan."
                    },
                    {
                        selector: "#extras",
                        errorMessage: "No ingresó el monto extra."
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
            { id: 'cardnumber', label: 'Número' },
            { id: 'usuario', label: 'Usuario', esSelect: true },
            { id: 'celulares', label: 'Celular', esSelect: true },
            { id: 'estado', label: 'Estado', esSelect: true },
            { id: 'roaming', label: 'Roaming', esSelect: true },
            { id: 'descuento', label: 'Descuento' },
            { id: 'fechaDescuento', label: 'Fecha descuento' },
            { id: 'nombrePlan', label: 'Nombre del plan', esSelect: true },
            { id: 'extras', label: 'Extras' },
            { id: 'obs', label: 'Observación' },
        ];

        let mensajeHtml = "<ul style='text-align:left;'>"; 

        campos.forEach(campo => {
            const elemento = document.getElementById(campo.id);
            let valor = campo.esSelect
                ? elemento.options[elemento.selectedIndex].text
                : elemento.value;

			const fecha = new Date(valor);
            if (!isNaN(fecha) && campo.id.toLowerCase().includes("fecha")) {
                const dia = String(fecha.getDate()).padStart(2, '0');
                const mes = String(fecha.getMonth() + 1).padStart(2, '0');
                const anio = fecha.getFullYear();
                valor = `${dia}/${mes}/${anio}`;
            }

            if (valor.trim() !== "") {
                mensajeHtml += `<li><strong>${campo.label}:</strong> ${valor.toUpperCase()}</li>`;
            }
        });

        mensajeHtml += "</ul>";

        mensajeHtml += `<br>
            <strong style="color:red;">Recuerde que cambiar los datos del monto/linea afectará los registros.</strong>`;

        mensajeHtml += '<br><strong>¿Está seguro de modificar este monto/linea?</strong><br><br>';

        Swal.fire({
            title: "Datos modificados del monto/linea",
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
            <a id="vlv"  href="./MontosLineas.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
		<div id="titulo">
			<h1>MODIFICAR LINEA</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
				<?php 
                include("../particular/conexion.php");
                $sent= "SELECT ESTADO FROM estado_ws WHERE ID_ESTADOWS = $idEstado";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $estado = $row['ESTADO'];

				$sent= "SELECT n.NOMBREPLAN, p.PLAN, l.ID_LINEA, pr.PROVEEDOR
				FROM linea l
				INNER JOIN nombreplan n ON n.ID_NOMBREPLAN = l.ID_NOMBREPLAN
				INNER JOIN plan p ON p.ID_PLAN = n.ID_PLAN
				inner join proveedor pr on pr.ID_PROVEEDOR=n.ID_PROVEEDOR
				WHERE l.ID_LINEA = $idLinea";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $nombrePlan = $row['NOMBREPLAN'];
                $plan = $row['PLAN'];
				$prove = $row['PROVEEDOR'];

				$sent= "SELECT ROAMING FROM roaming WHERE ID_ROAMING = $idRoaming";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $roaming = $row['ROAMING'];

				$sent= "SELECT ID_USUARIO, ID_MOVILINEA, EXTRAS, OBSERVACION FROM movilinea WHERE ID_LINEA = $idLinea ORDER BY ID_MOVILINEA DESC";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $extras = $row['EXTRAS'];
                $observaciones = $row['OBSERVACION'];
                $idUsuario = $row['ID_USUARIO'];

				$sent= "SELECT NOMBRE FROM usuarios WHERE ID_USUARIO = $idUsuario";
                $resultado = $datos_base->query($sent);
                $row = $resultado->fetch_assoc();
                $usuario = $row['NOMBRE'];
                ?>
			<form method="POST" action="../abm/modificados.php">
			<!-- <form method="POST" action="modificarLinea.php"> -->
				<div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">ID:</label>
                    <input type="text" class="id" name="id" id="id" value="<?php echo $idLinea?>" style="background-color:transparent;" readonly>
                </div>
				
				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">NÚMERO:</label>
					<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="number" name="nro" id="cardnumber" value="<?php echo $nro?>" required readonly>
				</div>

				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">USUARIO:</label>
						<select name="usuario" id="usuario" style="text-transform:uppercase" onchange="cargarCelulares(this.value)" class="form-control col-xl col-lg" required>
						<option selected value="100"><?php echo $usuario;?></option>
						<?php
						include("../particular/conexion.php");
						$consulta= "SELECT * FROM usuarios WHERE ID_ESTADOUSUARIO = 1 ORDER BY NOMBRE ASC";
						$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
						?>
						<?php foreach ($ejecutar as $opciones): ?> 
							<option value="<?php echo $opciones['ID_USUARIO']?>"><?php echo $opciones['NOMBRE']?></option>
						<?php endforeach ?>
						</select>
				</div>

				<div class="form-group row">
<!-- 					<div id="divCelulares" class="col-xl col-lg" style="display:none">
					<label id="lblForm"class="col-form-label col-xl col-lg">ASIGNANDO A CELULAR:</label>
					<div class="col-xl col-lg" >
						<input type="checkbox" class="chkLinea" id="checkCelular">
					</div>
					</div> -->

					<!-- <div id="celularesusuario" style="display:none" class="col-xl col-lg"> -->
						<label id="lblForm"class="col-form-label col-xl col-lg">CELULAR:</label>
						<select name="celular" id="celulares" style="text-transform:uppercase" class="form-control col-xl col-lg"><option value="" selected disabled>- SELECCIONE UNA OPCIÓN -</option></select>
					<!-- </div> -->
				</div>
				
				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:</label>
					<select name="estado" id="estado" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
					<option selected value="200"><?php echo $estado;?></option>
					<?php
					include("../particular/conexion.php");
					$consulta= "SELECT * FROM estado_ws ORDER BY ESTADO ASC";
					$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
					?>
					<?php foreach ($ejecutar as $opciones): ?> 
					<option value="<?php echo $opciones['ID_ESTADOWS']?>"><?php echo $opciones['ESTADO']?></option>
					<?php endforeach ?>
					</select>
				</div>
					
				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">ROAMING:</label>
					<select name="roaming" id="roaming" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
					<option selected value="400"><?php echo $roaming;?></option>
					<?php
					include("../particular/conexion.php");
					$consulta= "SELECT * FROM roaming ORDER BY ROAMING";
					$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
					?>
					<?php foreach ($ejecutar as $opciones): ?> 
					<option value="<?php echo $opciones['ID_ROAMING']?>"><?php echo $opciones['ROAMING']?></option>
					<?php endforeach ?>
					</select>
				</div>
				
				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">DESCUENTO:</label>
					<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="number" id="descuento" name="descuento" step="0.01" placeholder="10,00" required value="<?php echo $descuento?>">
				</div>
					
				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">FECHA DESCUENTO:</label>
					<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="date" id="fechaDescuento" name="fechaDescuento" value="<?php echo $fechaDescuento?>">
				</div>

				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE PLAN:</label>
					<select name="nombrePlan" id="nombrePlan" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
					<option selected value="300"><?php echo $nombrePlan." - ".$plan." - ".$prove;?></option>
					<?php
					include("../particular/conexion.php");
					$consulta= "SELECT n.NOMBREPLAN, p.PLAN, n.ID_NOMBREPLAN, pr.PROVEEDOR
					FROM nombreplan n
					INNER JOIN plan p ON p.ID_PLAN = n.ID_PLAN
					inner join proveedor pr on n.ID_PROVEEDOR=pr.ID_PROVEEDOR
					ORDER BY n.nombreplan";
					$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
					?>
					<?php foreach ($ejecutar as $opciones): ?> 
					<option value= <?php echo $opciones['ID_NOMBREPLAN'] ?>><?php echo $opciones['NOMBREPLAN'].' - '.$opciones['PLAN'].' - '.$opciones['PROVEEDOR']?></option>
					<?php endforeach ?>
					</select>
				</div>  


				<div class="form-group row">
					<label id="lblForm"class="col-form-label col-xl col-lg">EXTRAS:<span style="color:red;">*</span></label>
					<input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="number" id="extras" name="extras" step="0.01" placeholder="1500,00" value="<?php echo $extras?>" required>
				</div>  
				
				<div class="form-group row">
					<label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓN:</label> 
					<textarea class="form-control col-xl col-lg" id="obs" name="obs" placeholder="OBSERVACIÓN" style="text-transform:uppercase" rows="3" ><?php echo $observaciones;?></textarea>
				</div> 
				<!-- Campo oculto para la acción -->
				<input type="hidden" id="accion" name="accion" value="modificarLinea">
				<div class="form-group row justify-content-end">
					<input style="width:20%" onclick="enviar_formulario(this.form, 'modificarLinea')" class="btn btn-success" type="button" name="modificarLinea" value="MODIFICAR" class="button">
				</div>	
				<p style="color:red;text-align:left;font-size:14px;">* Al ingresar los extras de Personal, al precio que sale en la factura agregarle el iva.</br>En el caso de Claro, se ingresa tal cual figura en la factura.</p>
			</form>
			
					<?php
				if(isset($_GET['ok'])){
					?>
					<script>ok();</script>
					<?php			
				}
				if(isset($_GET['repeat'])){
					?>
					<script>repeat();</script>
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
/* 	$(document).ready(function(){
    $("#usuario").change(function(){
		$("#checkCelular").prop('checked', false);
		$("#celularesusuario").hide(0);
        $("#divCelulares").show(1300);
    });

	$("#checkCelular").change(function(){
        $("#celularesusuario").show(1300);
    });
    }); */
	// function cargarLineas() {
    //     var usuario = document.getElementById("usuario").value;
	// 	// alert(usuario)
    //     var xhr = new XMLHttpRequest();
    //     xhr.open("GET", "obtener_celulares.php?usuario=" + usuario, true);
    //     xhr.onreadystatechange = function () {
    //         if (xhr.readyState === 4 && xhr.status === 200) {
    //             document.getElementById("celulares").innerHTML = xhr.responseText;
    //         }
    //     };
    //     xhr.send();
    // }
</script>
<!--FUNCIONALIDAD EN JQUERY QUE PETICIONA A consultarDatosLinea.php los detalles de la linea-->
<script>
    function cargarCelulares(id_usuario, idlinea) {
        
        var parametros = {
            "idUsuario": id_usuario,
			"idLinea": idlinea
        };
        //LA VARIABLE BUSCAR UTILIZA EL ID usuario Y LA ENVIA AL consultarcelulares disponibles///
        $.ajax({
            data: parametros,
            url: "./consultarCelularesDisponibles.php",
            type: "POST",
            //TRAE DE FORMA ASINCRONA, CONSUME EL SERVIDOR DE NOVEDADES Y MUESTRA EN EL DIV MOSTRAR_MENSAJE TODAS LAS NOVEDADES RELACIONADAS////
            beforesend: function() {
                $("#celulares").html("Mensaje antes de Enviar");
            },

            success: function(mensaje) {
                $("#celulares").html(mensaje);
            }
        });
    };
    
    </script> 
	<script>cargarCelulares(<?php echo $idUsuario;?>,<?php echo $idLinea;?>);</script>
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>