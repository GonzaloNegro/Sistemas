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

        <h1>REPORTE MOVIMIENTOS IMPRESORAS/PERIFÉRICOS</h1>
		<div id="filtrosprin">




	
		<form id="campos" method="POST" action="reportemovimientosperifericos.php">
		
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
	<title>MOVIMIENTOS IMPRESORAS/PERIFÉRICOS</title><meta charset="utf-8">
		
		
        
		

        <?php

		if(isset($_POST['btn2'])){
			$mov=$_POST['slcTipo'];
            $fechadesde=$_POST['fecha_desde'];
            $fechahasta=$_POST['fecha_hasta'];
            if ($fechadesde==""||$fechahasta=="") {
				if ($mov==1) {
					$fecha = date("Y-m-d");
				echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
				
				
				$consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m
				inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
						INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
						INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP
						where 
						m.ID_AREA != ( select AVG(mv.ID_AREA) from movimientosperi mv
							where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO) ORDER BY M.ID_MOVIMIENTO DESC");
				}
				if ($mov==2) {
					$fecha = date("Y-m-d");
				echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
				
				
				$consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m
				inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
						INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
						INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP
						where 
						m.ID_USUARIO != ( select AVG(mv.ID_USUARIO) from movimientosperi mv
							where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO) ORDER BY M.ID_MOVIMIENTO DESC");
				}
				if ($mov==3) {
					$fecha = date("Y-m-d");
				echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
				
				
				$consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m
				inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
						INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
						INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP
						where 
						m.ID_ESTADOWS != ( select AVG(mv.ID_ESTADOWS) from movimientosperi mv
							where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO) ORDER BY M.ID_MOVIMIENTO DESC");
				}
			}
			else {
				if ($mov==1) {
					$fecha = date("Y-m-d");
				echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
				
				
				$consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m
				inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
						INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
						INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP
						where 
						m.ID_AREA != ( select AVG(mv.ID_AREA) from movimientosperi mv
							where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO)
							and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'
							 ORDER BY M.ID_MOVIMIENTO DESC");
				}
				if ($mov==2) {
					$fecha = date("Y-m-d");
				echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
				
				
				$consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m
				inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
						INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
						INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP
						where 
						m.ID_USUARIO != ( select AVG(mv.ID_USUARIO) from movimientosperi mv
							where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO)
							and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'
							 ORDER BY M.ID_MOVIMIENTO DESC");
				}
				if ($mov==3) {
					$fecha = date("Y-m-d");
				echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
				
				
				$consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m
				inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
						INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
						INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP
						where 
						m.ID_ESTADOWS != ( select AVG(mv.ID_ESTADOWS) from movimientosperi mv
							where m.ID_PERI=mv.ID_PERI and m.ID_MOVIMIENTO!=mv.ID_MOVIMIENTO)
							and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'
							 ORDER BY M.ID_MOVIMIENTO DESC");
				}
			}
		}

		else{
        $fecha = date("Y-m-d");
		echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
        
        
        $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_MOVIMIENTO, m.ID_PERI, p.TIPOP, t.TIPO, m.FECHA, a.AREA, u.NOMBRE, e.ESTADO from movimientosperi m 
        inner join area a on m.ID_AREA=a.ID_AREA INNER JOIN usuarios u ON u.ID_USUARIO=m.ID_USUARIO 
        INNER JOIN estado_ws e ON m.ID_ESTADOWS=e.ID_ESTADOWS INNER JOIN periferico p ON p.ID_PERI=m.ID_PERI 
        INNER JOIN tipop t ON p.ID_TIPOP=t.ID_TIPOP 
		ORDER BY M.ID_MOVIMIENTO DESC");}?>
	
        <?php echo "<table width=100%>
        <thead>
            <tr>
                <th><p>N° MOVIMIENTO</p></th>
                <th><p>FECHA</p></th>
                <th><p>ID</p></th>
                <th><p>TIPO</p></th>
                <!--<th><p>SUBTIPO</p></th>-->
                <th><p>ÁREA</p></th>
                <th><p>USUARIO</p></th>
                <th><p>ESTADO</p></th>
                <th><p>DETALLES</p></th>
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
				<td><h4 style='font-size:16px;'>".$listar['ID_PERI']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['TIPOP']."</h4></td>
				<!--<td><h4 style='font-size:16px;'>".$listar['TIPO']."</h4></td>-->
				<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
				<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
                <td><h4 style='font-size:16px;'>".$listar['ESTADO']."</h4></td>
                <td class='text-center text-nowrap cabe'  style='width: 80px;'><a class='btn btn-sm btn-outline-primary' href='detallemovimientoperifericos.php?ID_PERI=".$listar['ID_PERI']."'class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
				<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
				<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
				</svg></a></td>												
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



<!-- moejoras memoria
select m.ID_MEJORA, m.ID_WS, m.MEMORIA1, me.ORDEN_MEMORIA  from mejoras m inner join memoria me
on m.MEMORIA1=me.ID_MEMORIA
where me.ORDEN_MEMORIA>(SELECT max(me2.ORDEN_MEMORIA) from mejoras ms INNER JOIN
                         memoria me2 on ms.MEMORIA1=me2.ID_MEMORIA where m.ID_WS=ms.ID_WS and m.ID_MEJORA>ms.ID_MEJORA)
GROUP BY m.ID_MEJORA DESC 


select m.ID_MEJORA, m.ID_WS, m.DISCO1, d.DISCO  from mejoras m inner join disco d
on m.DISCO1=d.ID_DISCO
where d.ORDEN_DISCO>(SELECT max(di.ORDEN_DISCO) from mejoras me INNER JOIN
                         disco di on me.DISCO1=di.ID_DISCO where m.ID_WS=me.ID_WS and m.ID_MEJORA>me.ID_MEJORA)
GROUP BY m.ID_MEJORA DESC
-->