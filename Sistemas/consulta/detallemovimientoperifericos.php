<?php 
session_start();
include('conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT CUIL, RESOLUTOR FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>

<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
	                    <a id="vlv"  href="tiporeporte.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
						<div class="btn-group col-2" role="group" >
                              <button id="botonleft" type="button" class="btn btn-secondary" onclick="location.href='consulta.php'" ><i style=" margin-bottom:10px;"class='bi bi-house-door'></i></button>
                              <button id="botonright" type="button" class="btn btn-success" onClick="imprimir()" ><i class='bi bi-printer'></i></button>
                        </div>
		            </div>
		            <style type="text/css" media="print">
                              @media print {
                                             #vlv, #accion, .cabe {display:none;}
                                             #pr, #botonleft, #botonright {display:none;}
		                                     #pr2 {display:none;}
											 #titulo{ margin-top: 50px;}
											 #ind{ margin-bottom: 0px;}
											 #tablareporte{ margin-top: 20px;}
											 #campos{display:none;}
                                            }
                    </style>
		            <script>
                           function imprimir() {
            	             window.print();
                                      }
                    </script>
	<title>MOVIMIENTOS PERIFERICOS</title><meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="estiloallabm.css">
	<script type="text/javascript" src="jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="jquery/1/jquery-ui.js"></script>
	<!--BUSCADOR SELECT-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<!--FIN BUSCADOR SELECT-->
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
    <section id="inicio">
        <div id="reporteEst" style="width: 97%; margin-left: 20px;">   			
        
		<style type="text/css">
		#filtrosprin{
			margin-top: 100; height: auto; width: 100%; background-color: #dbe5e9; border-top: 1px solid #53AAE0; border-bottom: 1px solid #53AAE0

		}
        </style>
        <?php
        $periferico=$_GET['ID_PERI'];
        echo"<h1>MOVIMIENTOS PERIFERICO: $periferico</h1>"?>


        <?php
        
        $fecha = date("Y-m-d");
		echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
        $detalleperi=mysqli_query($datos_base, "SELECT p.ID_PERI, p.TIPOP, t.TIPO from periferico p
        INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP where p.ID_PERI=$periferico");
        $datosPeri=mysqli_fetch_array($detalleperi);
        $tipo=$datosPeri['TIPOP'];
        echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>TIPO PERIFERICO: $tipo</h4>";
        $subtipo=$datosPeri['TIPO'];
        echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>TIPO $tipo: $subtipo</h4>";
        
        $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m 
        inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
        INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
        INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP where m.ID_PERI=$periferico ORDER BY M.ID_MOVIMIENTO DESC");
	
        echo "<table width=100%>
        <thead>
            <tr>
                <th><p>MOVIMIENTO</p></th>
                <th><p>FECHA MOVIMIENTO</p></th>
                <th><p>ÁREA</p></th>
                <th><p>USUARIO</p></th>
                <th><p>ESTADO</p></th>
            </tr>
        </thead>
        ";
        $contador=0;
        while($listar = mysqli_fetch_array($consultarMovimientos))
        
				
	    {
		echo
		" 
			<tr>
				<td><h4 style='font-size:16px;'>".$listar['ID_MOVIMIENTO']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['FECHA']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
                <td><h4 style='font-size:16px;'>".$listar['ESTADO']."</h4></td>											
			</tr>";
		$contador += 1;}

		echo "<div id=contador class='form-group row justify-content-between'>";
						// if(isset($_POST['buscar'])){
						// 		$filtro = $_POST['buscar'];
						// 		if($filtro != ""){
						// 			$filtro = strtoupper($filtro);
						// 			echo "<p>FILTRADO POR: $filtro</p>";
						// 		}
						// 	}
						echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>Nro. Movimientos: $contador</h4>
						<hr>
						</div>
						</table>
						";

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
</body>
</html>