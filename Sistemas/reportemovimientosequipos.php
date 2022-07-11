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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="estiloreporte.css">
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
</head>


    

<body>
<style>
    #h2 {
        text-align: left;
        font-family: TrasandinaBook;
        font-size: 16px;
        color: #edf0f5;
        margin-left: 10px;
        margin-top: 5px;

    }
	</style>
    <section id="inicio">
    <div id="reporteEst" style="width: 97%; margin-left: 20px;">   			
        
		<style type="text/css">
		#filtrosprin{
			margin-top: 100; height: auto; width: 100%; background-color: #dbe5e9; border-top: 1px solid #53AAE0; border-bottom: 1px solid #53AAE0

		}
        </style>

        <h1>REPORTE MOVIMIENTOS EQUIPOS</h1>
		<div id="filtrosprin">




	
		<form id="campos" method="POST" action="reportemovimientosequipos.php">
		
        <div class="form-group row" style="margin-top: 15px; margin-right:10px;">

		<label id='lblForm' style='font-size:18px; margin-top: 2px; margin-bottom: 2px; width: 90px;'
                        class='col-form-label col-xl col-lg'>TIPO DE MOVIMIENTO:</label>
						
                        <select id='slcTipo' name='slcTipo' class='form-control col-xl col-lg' style='width:250px' required>
                          <option value='0' selected disabled>-TODOS-</option>
                          <option value='1'>AREA</option>
                          <option value='2'>USUARIO</option>
                          <option value='3'>ESTADO</option>
                          </select>
		        
                          <!-- <label style='font-size: 18px;' id='lblForm'class='col-form-label col-xl col-lg'>PERIODO:</label> -->
                 <label style='font-size: 18px;' id='lblForm'class='col-form-label col-xl col-lg'>DESDE:</label>
                     <input class='col-xl col-lg form-control' style='margin-top: 10px;' type='date' name='fecha_desde' id='txtfechadesdeA' >
                 
                 <label style='font-size: 18px;' id='lblForm'class='col-form-label col-xl col-lg'>HASTA:</label>
                     <input class='col-xl col-lg form-control' style='margin-top: 10px;' type='date' name='fecha_hasta' id='txtfechahastaA' >
				</div>


                <div class="form-group row justify-content-end" style="margin-right:10px;">
				
					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn2" value="BUSCAR"></input>

					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px; margin-right: 10px;" type="submit" name="btn1" value="LIMPIAR"></input>
				</div>
		</form>
		</div>
		<hr>
        
		

        <?php


        if(isset($_POST['btn2'])){
            $mov=$_POST['slcTipo'];
            $fechadesde=$_POST['fecha_desde'];
            $fechahasta=$_POST['fecha_hasta'];
            if ($fechadesde==""||$fechahasta=="") {
                if ($mov==1) {
                    $fecha = date("Y-m-d");
                    echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
        
        
                    $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, m.FECHA, u.NOMBRE, a.AREA, e.ESTADO, ma.MARCA, s.SIST_OP, m.MASTERIZADA, m.MAC, m.RIP, m.IP, r.RED
                    FROM movimientos m 
                    LEFT JOIN usuarios AS u ON u.ID_USUARIO = m.ID_USUARIO
                    LEFT JOIN area AS a ON a.ID_AREA = m.ID_AREA
                    LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = m.ID_ESTADOWS
                    LEFT JOIN marcas AS ma ON ma.ID_MARCA = m.ID_MARCA
                    LEFT JOIN so AS s ON s.ID_SO = m.ID_SO
                    LEFT JOIN red AS r ON r.ID_RED = m.ID_RED
                    where 
                            m.ID_AREA != ( select AVG(mv.ID_AREA) from movimientos mv
                                where m.ID_WS=mv.ID_WS and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO) ORDER BY a.ID_AREA desc");
                }
                if ($mov==2) {
                    $fecha = date("Y-m-d");
                    echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
        
        
                    $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, m.FECHA, u.NOMBRE, a.AREA, e.ESTADO, ma.MARCA, s.SIST_OP, m.MASTERIZADA, m.MAC, m.RIP, m.IP, r.RED
                    FROM movimientos m 
                    LEFT JOIN usuarios AS u ON u.ID_USUARIO = m.ID_USUARIO
                    LEFT JOIN area AS a ON a.ID_AREA = m.ID_AREA
                    LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = m.ID_ESTADOWS
                    LEFT JOIN marcas AS ma ON ma.ID_MARCA = m.ID_MARCA
                    LEFT JOIN so AS s ON s.ID_SO = m.ID_SO
                    LEFT JOIN red AS r ON r.ID_RED = m.ID_RED
                    where 
                            m.ID_USUARIO != ( select AVG(mv.ID_USUARIO) from movimientos mv
                                where m.ID_WS=mv.ID_WS and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO) ORDER BY u.NOMBRE asc");
                }
                if ($mov==3) {
                    $fecha = date("Y-m-d");
                    echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
        
        
                    $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, m.FECHA, u.NOMBRE, a.AREA, e.ESTADO, ma.MARCA, s.SIST_OP, m.MASTERIZADA, m.MAC, m.RIP, m.IP, r.RED
                    FROM movimientos m 
                    LEFT JOIN usuarios AS u ON u.ID_USUARIO = m.ID_USUARIO
                    LEFT JOIN area AS a ON a.ID_AREA = m.ID_AREA
                    LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = m.ID_ESTADOWS
                    LEFT JOIN marcas AS ma ON ma.ID_MARCA = m.ID_MARCA
                    LEFT JOIN so AS s ON s.ID_SO = m.ID_SO
                    LEFT JOIN red AS r ON r.ID_RED = m.ID_RED
                    where 
                            m.ID_ESTADOWS != ( select AVG(mv.ID_ESTADOWS) from movimientos mv
                                where m.ID_WS=mv.ID_WS and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO) ORDER BY M.ID_MOVIMIENTO DESC");
                
            }
            }
            // if(isset($_POST['fecha_desde']) & isset($_POST['fecha_hasta']))
            else{
                
                if ($mov==1) {
                    $fecha = date("Y-m-d");
                    echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
        
        
                    $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, m.FECHA, u.NOMBRE, a.AREA, e.ESTADO, ma.MARCA, s.SIST_OP, m.MASTERIZADA, m.MAC, m.RIP, m.IP, r.RED
                    FROM movimientos m 
                    LEFT JOIN usuarios AS u ON u.ID_USUARIO = m.ID_USUARIO
                    LEFT JOIN area AS a ON a.ID_AREA = m.ID_AREA
                    LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = m.ID_ESTADOWS
                    LEFT JOIN marcas AS ma ON ma.ID_MARCA = m.ID_MARCA
                    LEFT JOIN so AS s ON s.ID_SO = m.ID_SO
                    LEFT JOIN red AS r ON r.ID_RED = m.ID_RED
                    where 
                            m.ID_AREA != ( select AVG(mv.ID_AREA) from movimientos mv
                                where m.ID_WS=mv.ID_WS and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO) 
                            and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'
                    ORDER BY a.ID_AREA desc");
                }
                if ($mov==2) {
                    $fecha = date("Y-m-d");
                    echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
        
        
                    $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, m.FECHA, u.NOMBRE, a.AREA, e.ESTADO, ma.MARCA, s.SIST_OP, m.MASTERIZADA, m.MAC, m.RIP, m.IP, r.RED
                    FROM movimientos m 
                    LEFT JOIN usuarios AS u ON u.ID_USUARIO = m.ID_USUARIO
                    LEFT JOIN area AS a ON a.ID_AREA = m.ID_AREA
                    LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = m.ID_ESTADOWS
                    LEFT JOIN marcas AS ma ON ma.ID_MARCA = m.ID_MARCA
                    LEFT JOIN so AS s ON s.ID_SO = m.ID_SO
                    LEFT JOIN red AS r ON r.ID_RED = m.ID_RED
                    where 
                            m.ID_USUARIO != ( select AVG(mv.ID_USUARIO) from movimientos mv
                                where m.ID_WS=mv.ID_WS and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO)
                                and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'    
                                 ORDER BY u.NOMBRE asc");
                }
                if ($mov==3) {
                    $fecha = date("Y-m-d");
                    echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
        
        
                    $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, m.FECHA, u.NOMBRE, a.AREA, e.ESTADO, ma.MARCA, s.SIST_OP, m.MASTERIZADA, m.MAC, m.RIP, m.IP, r.RED
                    FROM movimientos m 
                    LEFT JOIN usuarios AS u ON u.ID_USUARIO = m.ID_USUARIO
                    LEFT JOIN area AS a ON a.ID_AREA = m.ID_AREA
                    LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = m.ID_ESTADOWS
                    LEFT JOIN marcas AS ma ON ma.ID_MARCA = m.ID_MARCA
                    LEFT JOIN so AS s ON s.ID_SO = m.ID_SO
                    LEFT JOIN red AS r ON r.ID_RED = m.ID_RED
                    where 
                            m.ID_ESTADOWS != ( select AVG(mv.ID_ESTADOWS) from movimientos mv
                                where m.ID_WS=mv.ID_WS and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO) 
                                and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'    
                                ORDER BY M.ID_MOVIMIENTO DESC");
                
            }
            }
    
}

	else{
        $fecha = date("Y-m-d");
		echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
        
        
        $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, m.FECHA, u.NOMBRE, a.AREA, e.ESTADO, ma.MARCA, s.SIST_OP, m.MASTERIZADA, m.MAC, m.RIP, m.IP, r.RED
        FROM movimientos m 
        LEFT JOIN usuarios AS u ON u.ID_USUARIO = m.ID_USUARIO
        LEFT JOIN area AS a ON a.ID_AREA = m.ID_AREA
        LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = m.ID_ESTADOWS
        LEFT JOIN marcas AS ma ON ma.ID_MARCA = m.ID_MARCA
        LEFT JOIN so AS s ON s.ID_SO = m.ID_SO
        LEFT JOIN red AS r ON r.ID_RED = m.ID_RED
        ORDER BY m.FECHA ASC");}
	
        echo "<table width=100%>
        <thead>
        <tr>
        <th><p class=g>NRO. WS</p></th>
        <th><p class=g>FECHA</p></th>
        <th><p class=g>USUARIO</p></th>
        <th><p class=g>ÁREA</p></th>
        <th><p class=g>ESTADO</p></th>
        <th><p class=g>MARCA</p></th>
        <th><p class=g>S.O.</p></th>
        <th><p class=g>MASTER</p></th>
        <th><p class=g>MAC</p></th>
        <th><p class=g>RIP</p></th>
        <th><p class=g>IP</p></th>
        <th><p class=g>RED</p></th>
    </tr>
        </thead>
        ";
        $contador=0;
        while($listar = mysqli_fetch_array($consultarMovimientos))
        
				
	    {
            $fecord = date("d-m-Y", strtotime($listar['FECHA']));
		echo
		" 
        <tr>
        <td><h4 >".$listar['ID_WS']."</font></h4></td>
        <td><h4 >".$fecord."</h4></td>
        <td><h4 >".$listar['NOMBRE']."</font></h4></td>
        <td><h4 >".$listar['AREA']."</font></h4></td>
        <td><h4 >".$listar['ESTADO']."</font></h4></td>
        <td><h4 >".$listar['MARCA']."</font></h4></td>
        <td><h4 >".$listar['SIST_OP']."</font></h4></td>
        <td><h4 >".$listar['MASTERIZADA']."</font></h4></td>
        <td><h4 >".$listar['MAC']."</font></h4></td>
        <td><h4 >".$listar['RIP']."</font></h4></td>
        <td><h4 >".$listar['IP']."</font></h4></td>
        <td><h4 >".$listar['RED']."</font></h4></td>
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
						echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>CANTIDAD DE MOVIMIENTOS : $contador</h4>
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