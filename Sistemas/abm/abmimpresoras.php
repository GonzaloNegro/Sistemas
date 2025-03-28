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
	<title>ABM IMPRESORAS</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../estilos/estiloallabm.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
			function ok(){
				swal(  {title: "Impresora modificada correctamente",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmimpresoras.php';
						}
						}
						);
			}	
			</script>
<script type="text/javascript">
			function no(){
				swal(  {title: "La impresora ingresada ya está registrada",
						icon: "error",
						})
						.then((confirmar) => {
						if (confirmar) {
							window.location.href='abmimpresoras.php';
						}
						}
						);
			}	
			</script>
    <section id="inicio">
		<div id="reporteEst">   
            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
                <a id="vlv"  href="abm.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
                <a id="agr" href="agregarimpresora.php" class="btn btn-success" type="button">+</a>
            </div>					
        </div>

        <h1>ABM IMPRESORAS</h1>
		<div id="filtro" class="container-fluid">
			<form method="POST" action="abmimpresoras.php">
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
				echo "<table width=100%>
						<thead>
							<tr>
								<th><p>IMPRESORA</p></th>
								<th><p>USUARIO</p></th>
								<th><p>ÁREA</p></th>
								<th><p>REPARTICIÓN</p></th>
                                <th><p>N° GOBIERNO</p></th>
								<th><p>N° SERIE</p></th>
								<th><p>TIPO</p></th>
                                <th><p>MARCA</p></th>";
								if ($row['ID_PERFIL'] != 5) {
									echo"
								<th><p>MODIFICAR</p></th>";}
								echo"
							</tr>
						</thead>
					";
					if(isset($_POST['btn2']))
					{
						$doc = $_POST['buscar'];
						$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, a.AREA, r.REPA, mo.MODELO, p.SERIEG, u.NOMBRE, t.TIPO, m.MARCA, p.SERIE	
						FROM periferico p 
						LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
						LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
                        LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA  
						LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
						INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
						INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
						WHERE p.TIPOP LIKE '%IMPRESORA%' AND (a.AREA LIKE '%$doc%' OR r.REPA LIKE '%$doc%' OR u.NOMBRE LIKE '%$doc%' OR p.SERIEG LIKE '%$doc%' OR mo.MODELO LIKE '%$doc%' OR t.TIPO LIKE '%$doc%' OR m.MARCA LIKE '%$doc%' OR p.SERIE LIKE '%$doc%')
						ORDER BY u.NOMBRE ASC");
							while($listar = mysqli_fetch_array($consultar))
							{
								echo
								" 
									<tr>
										<td><h4 style='font-size:14px;'>".$listar['MODELO']."</h4></td>
										<td><h4 style='font-size:14px;'>".$listar['NOMBRE']."</h4></td>
										<td><h4 style='font-size:14px;'>".$listar['AREA']."</h4></td>
										<td><h4 style='font-size:16px;'>".$listar['REPA']."</h4></td>
										<td><h4 style='font-size:14px;'>".$listar['SERIEG']."</h4></td>
										<td><h4 style='font-size:14px;'>".$listar['SERIE']."</h4></td>
										<td><h4 style='font-size:14px;'>".$listar['TIPO']."</h4></td>
										<td><h4 style='font-size:14px;'>".$listar['MARCA']."</h4></td>";
										if ($row['ID_PERFIL'] != 5) {
											echo"
										<td class='text-center text-nowrap'><a class='btn btn-info' style=' color:white;' href=modimpresora.php?no=".$listar['ID_PERI']." class=mod>Editar</a></td>";
										}
										echo"
									</tr>";
						}
					}
					else
					{
					$consultar=mysqli_query($datos_base, "SELECT p.ID_PERI, a.AREA, r.REPA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, p.SERIE
                    FROM periferico p 
					LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
                    LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
                    LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA 
                    LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO 
                    INNER JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
                    INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP 
                    WHERE p.TIPOP LIKE '%IMPRESORA%'
                    ORDER BY u.NOMBRE ASC");
                        while($listar = mysqli_fetch_array($consultar))
                        {
                            echo
                            " 
                                <tr>
                                    <td><h4 style='font-size:14px;'>".$listar['MODELO']."</h4></td>
                                    <td><h4 style='font-size:14px;'>".$listar['NOMBRE']."</h4></td>
                                    <td><h4 style='font-size:14px;'>".$listar['AREA']."</h4></td>
									<td><h4 style='font-size:16px;'>".$listar['REPA']."</h4></td>
                                    <td><h4 style='font-size:14px;'>".$listar['SERIEG']."</h4></td>
									<td><h4 style='font-size:14px;'>".$listar['SERIE']."</h4></td>
                                    <td><h4 style='font-size:14px;'>".$listar['TIPO']."</h4></td>
                                    <td><h4 style='font-size:14px;'>".$listar['MARCA']."</h4></td>";
									if ($row['ID_PERFIL'] != 5) {
										echo"
									<td class='text-center text-nowrap'><a class='btn btn-info' style=' color:white;' href=modimpresora.php?no=".$listar['ID_PERI']." class=mod>Editar</a></td>";
									}
									echo"
                                </tr>";}
					}
					echo "</table>";
					?>
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
    </section>
		<script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>