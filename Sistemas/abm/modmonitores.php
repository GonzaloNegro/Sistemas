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

    $sentencia = "SELECT * FROM periferico WHERE ID_PERI='" . $no_tic . "'";
    $resultado = mysqli_query($datos_base, $sentencia);

    return mysqli_fetch_assoc($resultado);
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>MODIFICAR MONITOR</title>
    <link rel="icon" href="../imagenes/logoInfraestructura.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloagregar.css">
</head>
<body>
    <script>
        function validar_formulario(){
			var fieldsToValidate = [
                    {
                        selector: "#nroSerie",
                        errorMessage: "No ingresó número de serie."
                    },
                    {
                        selector: "#modelo",
                        errorMessage: "No seleccionó modelo."
                    }
                    ,
                    {
                        selector: "#estado",
                        errorMessage: "No seleccionó estado."
                    }
                    ,
                    {
                        selector: "#proveedor",
                        errorMessage: "No seleccionó proveedor."
                    }
                    ,
                    {
                        selector: "#tipo",
                        errorMessage: "No seleccionó tipo de monitor."
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
            { id: 'nroGob', label: 'N° Gobierno' },
            { id: 'nroSerie', label: 'N° de serie' },
            { id: 'fact', label: 'Factura'},
            { id: 'obs', label: 'Observación'},
            { id: 'garantia', label: 'Garantía' },
            { id: 'modelo', label: 'Modelo', esSelect: true },
            { id: 'estado', label: 'Estado', esSelect: true  },
            { id: 'proveedor', label: 'Proveedor', esSelect: true },
            { id: 'tipo', label: 'Tipo de monitor', esSelect: true  },
            { id: 'equipo', label: 'Equipo al cuál esta asignado', esSelect: true }
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
        <strong style="color:red;">Recuerde que cambiar los datos del monitor afectará los registros.</strong>`;
        mensajeHtml += '<br><strong>¿Está seguro de modificar este monitor?</strong><br><br>';

        Swal.fire({
            title: "Datos modificados del monitor",
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
            <a id="vlv"  href="../consulta/monitores.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>			
    </div>
    <section id="Inicio">
        <div id="titulo">
            <h1>MODIFICAR MONITOR</h1>
        </div>
        <div id="principalu" style="width: 97%" class="container-fluid">
            <!--  CONSULTA DE DATOS -->
            <?php 
            $sent= "SELECT PROVEEDOR FROM proveedor WHERE ID_PROVEEDOR = '" . $consulta['ID_PROVEEDOR'] . "'";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $prov = $row['PROVEEDOR'];

            $sent= "SELECT ESTADO FROM estado_ws WHERE ID_ESTADOWS = '".$consulta['ID_ESTADOWS']."'";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $est = $row['ESTADO'];

            $sent= "SELECT mo.MODELO, ma.MARCA 
            FROM modelo mo
            INNER JOIN marcas ma ON ma.ID_MARCA = mo.ID_MARCA 
            WHERE mo.ID_MODELO = '".$consulta['ID_MODELO']."'";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $mod = $row['MODELO']." - ".$row['MARCA'];

            $sent= "SELECT TIPO FROM tipop WHERE ID_TIPOP = '".$consulta['ID_TIPOP']."'";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $tip = $row['TIPO'];
            
            $sent= "SELECT ep.ID_WS, i.SERIEG
            FROM equipo_periferico ep
            LEFT JOIN inventario i ON i.ID_WS = ep.ID_WS
            WHERE ep.ID_PERI = $consulta[ID_PERI]
            ORDER BY ep.ID_EQUIPO_PERIFERICO DESC
            LIMIT 1";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $ws = $row['ID_WS'];
            $equip = $row['SERIEG'];

            if($ws == 0 || $ws == null){
                $ws = 0;
            }

            $sent= "SELECT u.NOMBRE
            FROM wsusuario ws
            LEFT JOIN usuarios u ON u.ID_USUARIO = ws.ID_USUARIO
            WHERE ws.ID_WS = $ws
            ORDER BY ws.ID_WSUSU DESC
            LIMIT 1";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $usu = $row['NOMBRE'];
            
            ?>

            <!--  CONSULTA DE DATOS -->

            <form method="POST" action="./modificados.php">
                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">ID:</label>
                    <input type="text" class="id" name="id" value="<?php echo $consulta['ID_PERI']?>" style="background-color:transparent;" readonly>
                </div>
                    <?php
                        if(isset($equip)){
                        echo"
                            <div class='form-group row'>
                                <p style='color:green;font-size:14px;' class='col-form-label col-xl col-lg'>MONITOR ASIGNADO AL EQUIPO:</u> ".$equip."</p>
                            </div>";
                        }else{
                            echo"
                            <div class='form-group row'>
                                <p style='color:red;font-size:14px;' class='col-form-label col-xl col-lg'>ACTUALMENTE EL MONITOR NO ESTA ASIGNADO A UN EQUIPO</p>
                            </div>";
                        }
                    ?>

                <div class="form-group row">
                    <label id="lblForm" class="col-form-label col-xl col-lg">N° GOBIERNO:</label>
                    <input style="margin-top: 5px; text-transform:uppercase;" class="form-control col-form-label col-xl col-lg" type="text" name="serieg" id="nroGob" value="<?php echo $consulta['SERIEG']?>">
                </div>

                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">N° SERIE:<span style="color:red;">*</span></label>
                    <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="serie" id="nroSerie" value="<?php echo $consulta['SERIE']?>" required>
                </div>
                
                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">FACTURA: </label>
                    <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="fac" id="fact" value="<?php echo $consulta['FACTURA']?>">
                </div>

                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">OBSERVACIÓN: </label>
                    <textarea style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" name="obs" id="obs" rows="3"><?php echo $consulta['OBSERVACION']?></textarea>
                </div>
                
                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">GARANTIA: </label>
                    <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="text" name="garantia" id="garantia" value="<?php echo $consulta['GARANTIA']?>">
                </div>

                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">MODELO:<span style="color:red;">*</span></label>
                    <select name="modelo" style="margin-top: 5px text-transform:uppercase" id="modelo" class="form-control col-form-label col-xl col-lg" required>
                    <option selected value="200"><?php echo $mod?></option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA
                    FROM modelo m
                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                    INNER JOIN tipop t ON t.ID_TIPOP = m.ID_TIPOP
                    WHERE (m.ID_TIPOP = 7 OR m.ID_TIPOP = 8) ORDER BY m.MODELO ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA'];?></option>
                    <?php endforeach?>
                    </select>
                </div>

                <div class="form-group row"> 
                    <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:<span style="color:red;">*</span></label>
                    <select name="estado" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" id="estado" required>
                    <option selected value="300"><?php echo $est?></option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT * FROM estado_ws ORDER BY ESTADO ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_ESTADOWS'] ?>><?php echo $opciones['ESTADO']?></option>
                    <?php endforeach?>
                    </select>
                </div>

                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR:<span style="color:red;">*</span></label>
                    <select name="prov" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" id="proveedor" required>
                    <option selected value="400"><?php echo $prov?></option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT * FROM proveedor ORDER BY PROVEEDOR ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_PROVEEDOR'] ?>><?php echo $opciones['PROVEEDOR']?></option>
                    <?php endforeach?>
                    </select>
                </div>
                                
                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">TIPO DE MONITOR:<span style="color:red;">*</span></label>
                    <select name="tipop" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" id="tipo" required>
                    <option selected value="500"><?php echo $tip?></option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT * FROM tipop WHERE ID_TIPOP = 7 OR ID_TIPOP = 8 ORDER BY TIPO ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_TIPOP'] ?>><?php echo $opciones['TIPO']?></option>
                    <?php endforeach?>
                    </select>
                </div>

                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">EQUIPO AL CUÁL ESTÁ ASIGNADO:</label>
                    <select name="equip" style="margin-top: 5px text-transform:uppercase" class="form-control col-form-label col-xl col-lg" id="equipo">
                    <option selected value="600"><?php 
                        if($usu == null || $usu == 0){
                            echo "";                        
                        }else{
                            echo $usu." - ".$equip;
                        }
                    ?></option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT u.NOMBRE, i.SERIEG, w.ID_WS, i.ID_TIPOWS
                    FROM wsusuario w
                    INNER JOIN usuarios u ON u.ID_USUARIO = w.ID_USUARIO
                    INNER JOIN inventario i ON i.ID_WS = w.ID_WS
                    WHERE u.ID_ESTADOUSUARIO = 1 
                    AND w.ID_WS <> 0 
                    AND w.ID_USUARIO <> 277
                    AND i.ID_TIPOWS = 1 /* PC */
                    ORDER BY u.NOMBRE ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                        <option value= <?php echo $opciones['ID_WS'] ?>><?php echo $opciones['NOMBRE']." - ".$opciones['SERIEG']?></option>
                    <?php endforeach?>
                    </select>
                </div>
                <input type="hidden" id="accion" name="accion" value="modMonitores">
                <div class="form-group row justify-content-end">
                    <input onclick="enviar_formulario(this.form, 'modMonitores')" style="width:20%"class="btn btn-success" type="button" name="modMonitores" value="MODIFICAR" class="button">
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