<?php 
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>AGREGAR IMPRESORA</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
<script type="text/javascript">
			function ok(){
				// swal(  {title: "Impresora cargada correctamente",
				// 		icon: "success",
				// 		showConfirmButton: true,
				// 		showCancelButton: false,
				// 		})
				// 		.then((confirmar) => {
				// 		if (confirmar) {
				// 			window.location.href='abmimpresoras.php';
				// 		}
				// 		}
				// 		);
                Swal.fire({
                        title: "Impresora cargada correctamente.",
                        icon: "success",
                        showConfirmButton: true,
                        showCancelButton: false,
              confirmButtonColor: '#198754',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: "Cancelar",
                reverseButtons: true,
                        customClass:{
                            actions: 'reverse-button'
                        }
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.location.href='abmimpresoras.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>

<script type="text/javascript">
			function no(){
				// swal(  {title: "La impresora ingresada ya está registrada",
				// 		icon: "error",
				// 		})
				// 		.then((confirmar) => {
				// 		if (confirmar) {
				// 			window.location.href='agregarimpresora.php';
				// 		}
				// 		}
				// 		);
                Swal.fire({
                        title: "La impresora ya está registrada",
                        icon: "error",
                        showConfirmButton: true,
                        showCancelButton: false,
              confirmButtonColor: '#198754',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: "Cancelar",
                reverseButtons: true,
                        customClass:{
                            actions: 'reverse-button'
                        }
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.location.href='agregarimpresora.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
            <script>
        function validar_formulario(){
			
			var fieldsToValidate = [
                    {
                        selector: "#tipoimp",
                        errorMessage: "No seleccionó tipo de impresora."
                    },
                    {
                        selector: "#modelo",
                        errorMessage: "No ingresó modelo."
                    },
                    {
                        selector: "#serieg",
                        errorMessage: "No ingresó Nro. de gobierno."
                    },
                    {
                        selector: "#serie",
                        errorMessage: "No seleccionó Nro. de serie."
                    },
                    {
                        selector: "#proc",
                        errorMessage: "No seleccionó procedencia."
                    },
                    {
                        selector: "#equip",
                        errorMessage: "No seleccionó equipo."
                    },
                    {
                        selector: "#est",
                        errorMessage: "No seleccionó estado."
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
					{ id: 'tipoimp', label: 'Tipo Impresora', esSelect: true },
					{ id: 'modelo', label: 'Modelo', esSelect: true  },
					{ id: 'serieg', label: 'Serieg Gobierno'},
					{ id: 'serie', label: 'N°Serie' },
					{ id: 'proc', label: 'Procedencia', esSelect: true },
					{ id: 'equip', label: 'Equipo al que se asigna', esSelect: true },
					{ id: 'est', label: 'Estado', esSelect: true }
				];

				confirmarEnvioFormulario(
					formulario,
					campos,
					"Datos de la impresora",
					"¿Está seguro de guardar esta impresora?"
				);
			}
		};
    </script>
<main> 
    <div id="reporteEst">   
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
            <a id="vlv"  href="../consulta/impresoras.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
	<section id="Inicio">
		<div id="titulo">
			<h1>AGREGAR IMPRESORA</h1>
		</div>
		<div id="principalu" style="width: auto" class="container-fluid" data-aos="zoom-in">
            <form method="POST" action="./agregados.php">

                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">TIPO IMPRESORA:<span style="color:red;">*</span></label>
                    <select id="tipoimp" name="tipop" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT * FROM tipop WHERE ID_TIPOP <= 4 OR ID_TIPOP = 10 OR ID_TIPOP = 13  ORDER BY TIPO ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_TIPOP'] ?>><?php echo $opciones['TIPO']?></option>
                    <?php endforeach?>
                    </select>
                </div>

                <div class="form-group row" >
                    <label id="lblForm"class="col-form-label col-xl col-lg">MODELO:<span style="color:red;">*</span></label>
                    <select id="modelo" name="modelo" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT m.ID_MODELO, m.MODELO, ma.MARCA
                    FROM modelo m
                    INNER JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                    INNER JOIN tipop t ON t.ID_TIPOP = m.ID_TIPOP
                    WHERE (m.ID_TIPOP = 1 OR m.ID_TIPOP = 2 OR m.ID_TIPOP = 3 OR m.ID_TIPOP = 4 OR m.ID_TIPOP = 10 OR m.ID_TIPOP = 13)  ORDER BY MODELO ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_MODELO'] ?>><?php echo $opciones['MODELO']." - ".$opciones['MARCA']?></option>
                    <?php endforeach?>
                    </select>
                </div>


                <div class="form-group row" >
                    <label id="lblForm" class="col-form-label col-xl col-lg" >N° GOBIERNO:<span style="color:red;">*</span></label> 
                    <input id="serieg" class="form-control col-xl col-lg" placeholder="DE LA IMPRESORA" style="text-transform:uppercase;" name="serieg" required>
                </div>    
                
                <div class="form-group row" >
                    <label id="lblForm" class="col-form-label col-xl col-lg">N° SERIE:<span style="color:red;">*</span></label> 
                    <input id="serie" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="serie" required>
                </div>    
                
                <div class="form-group row" >
                    <label id="lblForm"class="col-form-label col-xl col-lg">PROCEDENCIA:<span style="color:red;">*</span></label>
                    <select id="proc" name="proc" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                    <?php
                    include("../particular/conexion.php");
                    $consulta= "SELECT * FROM procedencia ORDER BY PROCEDENCIA ASC";
                    $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?> 
                    <option value= <?php echo $opciones['ID_PROCEDENCIA'] ?>><?php echo $opciones['PROCEDENCIA']?></option>
                    <?php endforeach?>
                    </select>
                </div>    

                <div class="form-group row" >
                    <label id="lblForm"class="col-form-label col-xl col-lg">EQUIPO AL QUE SE ASIGNA:<span style="color:red;">*</span></label>
                    <select id="equip" name="equip" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                    <?php
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

                <div class="form-group row" >
                    <label id="lblForm"class="col-form-label col-xl col-lg">ESTADO:<span style="color:red;">*</span></label>
                    <select id="est" name="est" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
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

                <div class="form-group row" >
                    <label id="lblForm" class="col-form-label col-xl col-lg">GARANTIA:</label> 
                    <input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="gar" placeholder="TIEMPO DE GARANTIA" >
                </div>

                <div class="form-group row" >
                    <label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR:</label>
                    <select name="prov" style="text-transform:uppercase" class="form-control col-xl col-lg">
                    <option  value="" selected disabled="">-SELECCIONE UNA-</option>
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

                <div class="form-group row" >
                    <label id="lblForm" class="col-form-label col-xl col-lg">FACTURA:</label> 
                    <input class="form-control col-xl col-lg" style="text-transform:uppercase;" name="fac" placeholder="N° Factura">
                </div> 

                <div class="form-group row" >
                    <label id="lblForm" class="col-form-label col-xl col-lg">MAC:</label> 
                    <input class="form-control col-xl col-lg" name="mac" placeholder="N° MAC">
                </div>
                    
                <div class="form-group row" >
                    <label id="lblForm"class="col-form-label col-xl col-lg">RESERVA IP:</label>
                    <select name="reserva" class="form-control col-xl col-lg">
                        <option  value="" selected disabled="">-SELECCIONE UNA-</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>

                <div class="form-group row" >
                    <label id="lblForm" class="col-form-label col-xl col-lg">IP:</label> 
                    <input class="form-control col-xl col-lg" name="ip" placeholder="N° IP">
                </div>
                    
                <div class="form-group row" >
                    <label id="lblForm" class="col-form-label col-xl col-lg">OBSERVACIÓN:</label> 
                    <textarea class="form-control col-xl col-lg" name="obs" placeholder="Observaciónes" style="text-transform:uppercase" rows="3"></textarea>
                </div>
                <!-- Campo oculto para la acción -->
                <input type="hidden" id="accion" name="accion" value="agregarImpresora">
                <?php 
                    if ($row['ID_PERFIL'] != 5) {
                        echo'<div class="form-group row justify-content-end" style="margin: 10px; padding:10px;">
                            <input onClick="enviar_formulario(this.form, \'agregarImpresora\')" style="width: 20%;"class="btn btn-success" type="button" name="agregarImpresora" value="GUARDAR" class="button">
                        </div> ';
                    }
                ?>   
            </form>
                    <?php
				if(isset($_GET['ok'])){
					?>
					<script>ok();</script>
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
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>