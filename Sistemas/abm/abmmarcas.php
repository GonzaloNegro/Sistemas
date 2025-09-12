<?php
session_start();
include('../particular/conexion.php');
include('../particular/auth.php');
if(!isset($_SESSION['cuil']))
    {
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();

//PERMISOS DE ACCESO A LA PAGINA O REDIRECCIÓN
verificarPerfil($row, [1, 2]);
?>
<!DOCTYPE html>
<html>
<head>
	<title>ABM MARCAS</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloallabm.css">
</head>
<body>
    <section id="inicio">
		 <div id="reporteEst">   
            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                <a id="vlv"  href="abm.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
                <a id="agr" href="agregarmarca.php" class="btn btn-success" type="button">+</a>
            </div>					
         </div>

        <h1>ABM MARCAS</h1>
		<div id="filtro" class="container-fluid">
			<form method="POST" action="abmmarcas.php">
				<div>
					<input type="text" style="text-transform:uppercase;" name="buscar"  placeholder="Buscar" class="form-control largo">
				</div>        
				<div>
					<input class="btn btn-success" type="submit" name="btn2" value="BUSCAR"></input>
					<input class="btn btn-danger"  type="submit" name="btn1" value="LIMPIAR"></input>
				</div>
			</form>
		</div>
        <?php
				echo "<table class='table_id tablaLineas' id='tabla_lineas'>
						<thead>
							<tr>
                                <th><p style='text-align:left;padding:5px;'>MARCA</p></th>
								<th><p>MODIFICAR</p></th>
							</tr>
						</thead>
					";        
						if(isset($_POST['btn2']))
						{
							$doc = $_POST['buscar'];
							$consultar=mysqli_query($datos_base, "SELECT * FROM marcas
							WHERE MARCA LIKE '%$doc%'
							ORDER BY MARCA ASC");
								while($listar = mysqli_fetch_array($consultar))
								{
									echo
									" 
										<tr>
											<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['MARCA']."</h4></td>
											<td class='text-center text-nowrap'><a href=modmarca.php?no=".$listar['ID_MARCA']."><i style='color: #198754' class='fa-solid fa-pen-to-square fa-2xl'></i></a></td>
										</tr>
									";
								}
						}
						else{
							$consultar=mysqli_query($datos_base, "SELECT * FROM marcas 
							ORDER BY MARCA ASC");
								while($listar = mysqli_fetch_array($consultar))
								{
									echo
									" 
										<tr>
											<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['MARCA']."</h4></td>
											<td class='text-center text-nowrap'><a href=modmarca.php?no=".$listar['ID_MARCA']."><i style='color: #198754' class='fa-solid fa-pen-to-square fa-2xl'></i></a></td>
										</tr>
									";
								}  
						}
						echo "</table>";?>
    </section>
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="../js/confirmacionForm.js"></script>
	<script>
		const urlParams = new URLSearchParams(window.location.search);

		["ok","okMod","no","noMod"].forEach(param => {
			if (urlParams.has(param)) {
				switch(param) {
					case "ok":
						showAlert("Marca agregada correctamente.", "success");
						break;
					case "okMod":
						showAlert("Marca modificada correctamente.", "success");
						break;
					case "no":
						showAlert("La marca ingresada ya está registrada.", "error");
						break;
					case "noMod":
						showAlert("No se ha podido modificar la marca. Ya se encuentra registrada.", "error");
						break;
				}
			}
		});
	</script>
</body>
</html>