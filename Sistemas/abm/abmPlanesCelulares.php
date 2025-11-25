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
verificarPerfil($row, [1, 2, 4]);
?>
<!DOCTYPE html>
<html>
<head>
	<title>ABM PLANES CELULARES</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloallabm.css">
</head>
<body>
    <section id="inicio">
        <div id="reporteEst">   
            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                <a id="vlv"  href="abm.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
                <a id="agr" href="agregarPlan.php" class="btn btn-success" type="button">+</a>
            </div>					
         </div>

        <h1>ABM PLANES CELULARES</h1>
		<div id="filtro" class="container-fluid">
			<form method="POST" action="abmPlanesCelulares.php">
				<div>
					<input type="text" style="text-transform:uppercase;" name="buscar"  placeholder="Buscar" class="form-control largo">
				</div>        
				<div>
					<input class="btn btn-success" type="submit" name="btn2" value="BUSCAR" id="btnForm"></input>
					<input class="btn btn-danger"  type="submit" name="btn1" value="LIMPIAR" id="btnLimpiar"></input>
				</div>
			</form>
		</div>
        
        <?php
				echo "<table table class='table_id tablaLineas' id='tabla_lineas'>
						<thead>
							<tr>
								<th><p style='text-align:left; margin-left: 10px;'>NOMBRE</p></th>
								<th><p style='text-align:left; margin-left: 10px;'>PROVEEDOR</p></th>
								<th><p style='text-align:left; margin-left: 10px;'>CÓDIGO</p></th>
								<th><p style='text-align:right; margin-right: 10px;'>MONTO</p></th>";
								if ($row['ID_PERFIL'] != 5) {
									echo"
                                <th><p>MODIFICAR</p></th>";
								}
								echo"
							</tr>
						</thead>
					";
								if(isset($_POST['btn2']))
								{
									$doc = $_POST['buscar'];
									$consulta=mysqli_query($datos_base, "SELECT n.ID_NOMBREPLAN, n.NOMBREPLAN, p.PROVEEDOR, n.MONTO, pl.PLAN, n.CODIGOP
									FROM nombreplan n
                                    LEFT JOIN proveedor AS p ON p.ID_PROVEEDOR = n.ID_PROVEEDOR
									LEFT JOIN plan pl ON pl.ID_PLAN = n.ID_PLAN
									WHERE n.NOMBREPLAN LIKE '%$doc%'
									ORDER BY n.MONTO DESC
									");
										while($listar = mysqli_fetch_array($consulta)) 
										{
											if($listar['MONTO'] == 0){
												$color = "red";
											}else{
												$color = "black";
											}
											echo
											" 
												<tr>
													<td><h4 style='font-size:14px; text-align: left; margin-left: 5px;color: $color;'>".$listar['NOMBREPLAN']." - ".$listar['PLAN']."</h4 ></td>
													<td><h4 style='font-size:14px; text-align: left; margin-left: 5px;color: $color;'>".$listar['PROVEEDOR']."</h4 ></td>
													<td><h4 style='font-size:14px; text-align: left; margin-left: 5px;color: $color;'>".$listar['CODIGOP']."</h4 ></td>
													<td><h4 style='font-size:14px; text-align: right; margin-right: 5px;color: $color;'>"."$".$listar['MONTO']."</h4 ></td>";
													if ($row['ID_PERFIL'] != 5) {
														echo"
													<td class='text-center text-nowrap'><a href=modPlanes.php?no=".$listar['ID_NOMBREPLAN']."><i style='color: #198754' class='fa-solid fa-pen-to-square fa-2xl'></i></a></td>";
													}
													echo"
												</tr>
											";
										}
								}
	
								else{
									$consulta=mysqli_query($datos_base, "SELECT n.ID_NOMBREPLAN, n.NOMBREPLAN, p.PROVEEDOR, n.MONTO, pl.PLAN, n.CODIGOP
									FROM nombreplan n
                                    LEFT JOIN proveedor p ON p.ID_PROVEEDOR = n.ID_PROVEEDOR
                                    LEFT JOIN plan pl ON pl.ID_PLAN = n.ID_PLAN
									ORDER BY n.MONTO DESC
									");
										while($listar = mysqli_fetch_array($consulta)) 
										{
											if($listar['MONTO'] == 0){
												$color = "red";
											}else{
												$color = "black";
											}
											echo
											" 
												<tr>
													<td><h4 style='font-size:14px; text-align: left; margin-left: 5px;color: $color;'>".$listar['NOMBREPLAN']." - ".$listar['PLAN']."</h4 ></td>
													<td><h4 style='font-size:14px; text-align: left; margin-left: 5px;color: $color;'>".$listar['PROVEEDOR']."</h4 ></td>
													<td><h4 style='font-size:14px; text-align: left; margin-left: 5px;color: $color;'>".$listar['CODIGOP']."</h4 ></td>
													<td><h4 style='font-size:14px; text-align: right; margin-right: 5px;color: $color;'>"."$".$listar['MONTO']."</h4 ></td>";
													if ($row['ID_PERFIL'] != 5) {
														echo"
													<td class='text-center text-nowrap'><a href=modPlanes.php?no=".$listar['ID_NOMBREPLAN']." ><i style='color: #198754' class='fa-solid fa-pen-to-square fa-2xl'></i></a></td>";
													}

													echo"
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
						showAlert("Plan agregado correctamente.", "success");
						break;
					case "okMod":
						showAlert("Plan modificado correctamente.", "success");
						break;
					case "no":
						showAlert("El plan ingresado ya está registrada.", "error");
						break;
					case "noMod":
						showAlert("No se ha podido modificar el plan. Ya se encuentra registrado.", "error");
						break;
				}
			}
		});
	</script>
	<script src="../js/shortcutKeys.js"></script>
</body>
</html>