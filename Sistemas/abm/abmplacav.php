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
	<title>ABM PLACA DE VIDEO</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloallabm.css">
</head>
<body>
    <section id="inicio">
		 <div id="reporteEst">   
            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                <a id="vlv"  href="abm.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
                <a id="agr" href="agregarplacav.php" class="btn btn-success" type="button">+</a>
            </div>					
         </div>

        <h1>ABM PLACA DE VIDEO</h1>
		<div id="filtro" class="container-fluid">
			<form method="POST" action="abmplacav.php">
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
								<th><p style='text-align:left;padding:5px;'>PLACA</p></th>
								<th><p style='text-align:right;padding:5px;'>MEMORIA</p></th>
                                <th><p style='text-align:left;padding:5px;'>TIPO DE MEMORIA</p></th>
								<th><p>MODIFICAR</p></th>
							</tr>
						</thead>
					";
					if(isset($_POST['btn2']))
					{
						$doc = $_POST['buscar'];
						$consultar=mysqli_query($datos_base, "SELECT pv.ID_PVIDEO, m.MEMORIA, mo.MODELO, t.TIPOMEM
                        FROM pvideo pv 
                        LEFT JOIN memoria AS m ON m.ID_MEMORIA = pv.ID_MEMORIA
                        LEFT JOIN tipomem AS t ON t.ID_TIPOMEM = pv.ID_TIPOMEM 
						LEFT JOIN modelo AS mo ON mo.ID_MODELO = pv.ID_MODELO
						WHERE m.MEMORIA LIKE '%$doc%' OR mo.MODELO LIKE '%$doc%' OR t.TIPOMEM LIKE '%$doc%'
                        ORDER BY mo.MODELO ASC");
							while($listar = mysqli_fetch_array($consultar))
								{

									echo
									" 
										<tr>
											<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['MODELO']."</h4></td>
											<td><h4 style='font-size:14px;text-align:right;padding:5px;'>".$listar['MEMORIA']."</h4></td>
											<td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['TIPOMEM']."</h4></td>
											<td class='text-center text-nowrap'><a href=modplacav.php?no=".$listar['ID_PVIDEO']."><i style='color: #198754' class='fa-solid fa-pen-to-square fa-2xl'></i></a></td>
									</tr>";
						}
					}
					
					else
					{
						$consultar=mysqli_query($datos_base, "SELECT pv.ID_PVIDEO, m.MEMORIA, mo.MODELO, t.TIPOMEM
                        FROM pvideo pv 
                        LEFT JOIN memoria AS m ON m.ID_MEMORIA = pv.ID_MEMORIA
                        LEFT JOIN tipomem AS t ON t.ID_TIPOMEM = pv.ID_TIPOMEM
						LEFT JOIN modelo AS mo ON mo.ID_MODELO = pv.ID_MODELO
                        ORDER BY mo.MODELO ASC");
							while($listar = mysqli_fetch_array($consultar))
								{

										echo
										" 
											<tr>
                                            <td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['MODELO']."</h4></td>
                                            <td><h4 style='font-size:14px;text-align:right;padding:5px;'>".$listar['MEMORIA']."</h4></td>
                                            <td><h4 style='font-size:14px;text-align:left;padding:5px;'>".$listar['TIPOMEM']."</h4></td>
											<td class='text-center text-nowrap'><a href=modplacav.php?no=".$listar['ID_PVIDEO']."><i style='color: #198754' class='fa-solid fa-pen-to-square fa-2xl'></i></a></td>
										</tr>";
						}
					}
					echo "</table>";?>
    </section>
	<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="../js/confirmacionForm.js"></script>
	<script>
		const urlParams = new URLSearchParams(window.location.search);

		["ok","okMod","no","noMod", "repeat"].forEach(param => {
			if (urlParams.has(param)) {
				switch(param) {
					case "ok":
						showAlert("Placa de video modificada correctamente.", "success");
						break;
					case "okMod":
						showAlert("Placa de video modificada correctamente.", "success");
						break;
					case "no":
						showAlert("La placa de video de la marca ingresada ya está registrado.", "error");
						break;
					case "noMod":
						showAlert("No se ha podido modificar la placa de video. Ya se encuentra registrada.", "error");
						break;
					case "repeat":
						showAlert("Placa de video modificada correctamente. Verifique el nombre de la marca, ya que existe este nombre registrado previamente.", "warning");
						break;
				}
			}
		});
	</script>
</body>
</html>