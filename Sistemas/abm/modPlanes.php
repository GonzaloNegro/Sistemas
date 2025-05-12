<?php 
session_start();
error_reporting(0);
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
	$datos_base=mysqli_connect('localhost', 'root', '', 'incidentes') or exit('No se puede conectar con la base de datos');
	$sentencia =  "SELECT * FROM nombreplan WHERE ID_NOMBREPLAN ='".$no_tic."'";
	$resultado = mysqli_query($datos_base, $sentencia);
	$filas = mysqli_fetch_assoc($resultado);
	return [
		$filas['ID_NOMBREPLAN'],/*0*/
		$filas['NOMBREPLAN'],/*1*/
        $filas['ID_PLAN'],/*2*/
        $filas['ID_PROVEEDOR'],/*3*/
        $filas['MONTO'],/*4*/
	];
}

$idNombrePlan = $consulta[0];
$nbombrePlan = $consulta[1];
$idPlan = $consulta[2];
$idProveedor = $consulta[3];
$monto = $consulta[4];
?>
<!DOCTYPE html>
<html>
<head>
	<title>MODIFICAR PLAN</title><meta charset="utf-8">
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
                        selector: "#nombrePlan",
                        errorMessage: "No ingresó nombre del Plan."
                    },
                    {
                        selector: "#proveedor",
                        errorMessage: "No ingresó proveedor."
                    },
                    {
                        selector: "#plan",
                        errorMessage: "No ingresó plan."
                    },
                    {
                        selector: "#monto",
                        errorMessage: "No ingresó monto."
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
            { id: 'nombrePlan', label: 'Nombre del Plan' },
            { id: 'plan', label: 'Plan', esSelect: true },
            { id: 'proveedor', label: 'Proveedor', esSelect: true },
            { id: 'monto', label: 'Monto' }
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
        <strong style="color:red;">Recuerde que cambiar los datos del Plan actual afectará en los siguientes registros.</strong>`;

        mensajeHtml += '<br><strong>¿Está seguro de modificar este Plan?</strong><br><br>';

        Swal.fire({
            title: "Datos modificados del Plan",
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
            <a id="vlv"  href="./abmPlanesCelulares.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
        </div>					
    </div>
        <section id="Inicio">
		<div id="titulo">
			<h1>MODIFICAR PLAN</h1>
		</div>
		<div id="principalu" style="width: 97%" class="container-fluid" data-aos="zoom-in">
            <?php 
            $sent= "SELECT PLAN FROM plan WHERE ID_PLAN = $idPlan";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $plan = $row['PLAN'];

            $sent= "SELECT PROVEEDOR FROM proveedor WHERE ID_PROVEEDOR = $idProveedor";
            $resultado = $datos_base->query($sent);
            $row = $resultado->fetch_assoc();
            $proveedor = $row['PROVEEDOR'];
            ?>
            <form method="POST" action="./modificados.php">
                <div class="form-group row">
                    <label id="lblForm"class="col-form-label col-xl col-lg">ID: </label>
                    <input type="text" class="id" name="id" style="background-color:transparent;" value="<?php echo $consulta[0]?>" readonly>
                </div>

            <div class="form-group row">
                <label id="lblForm"class="col-form-label col-xl col-lg">NOMBRE PLAN:</label>
                <input type="text" id="nombrePlan" class="form-control col-xl col-lg" style="text-transform:uppercase;" name="nombrePlan" value="<?php echo $nbombrePlan?>">
            </div>
            <div class="form-group row">
                <label id="lblForm"class="col-form-label col-xl col-lg">PLAN:</label>
                <select name="plan" id="plan" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                <option selected value="100"><?php echo $plan?></option>
                        <?php
                        $consulta= "SELECT * FROM plan ORDER BY PLAN ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                            <option value="<?php echo $opciones['ID_PLAN']?>"><?php echo $opciones['PLAN']?></option>						
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group row">
                <label id="lblForm"class="col-form-label col-xl col-lg">PROVEEDOR:</label>
                <select name="proveedor" id="proveedor" style="text-transform:uppercase" class="form-control col-xl col-lg" required>
                    <option selected value="200"><?php echo $proveedor?></option>
                        <?php
                        $consulta= "SELECT * FROM proveedor WHERE ID_PROVEEDOR BETWEEN 34 AND 35 ORDER BY PROVEEDOR ASC";
                        $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?> 
                            <option value="<?php echo $opciones['ID_PROVEEDOR']?>"><?php echo $opciones['PROVEEDOR']?></option>						
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group row">
                <label id="lblForm"class="col-form-label col-xl col-lg">MONTO SIN DESCUENTO:</label>
                <input style="margin-top: 5px; text-transform:uppercase;"class="form-control col-form-label col-xl col-lg" type="number" id="monto" name="monto" step="0.01" placeholder="10,00" required value="<?php echo $monto?>">
            </div>

            <div class="row justify-content-end">
                <input onClick="enviar_formulario(this.form)" style="width: 20%;"class="btn btn-success" name="btnModPlanes" type="button" value="MODIFICAR">
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