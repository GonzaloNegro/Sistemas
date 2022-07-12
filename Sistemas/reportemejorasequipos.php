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

        <h1>REPORTE MEJORAS EQUIPOS</h1>
		<div id="filtrosprin">




	
		<form id="campos" method="POST" action="reportemejorasequipos.php">
		
        <div class="form-group row" style="margin-top: 15px; margin-right:10px;">

		<label id='lblForm' style='font-size:18px; margin-top: 2px; margin-bottom: 2px; width: 90px;'
                        class='col-form-label col-xl col-lg'>TIPO DE MOVIMIENTO:</label>
						
                        <select id='slcTipo' name='slcTipo' class='form-control col-xl col-lg' style='width:250px' required>
                          <option value='0' selected disabled>-TODOS-</option>
                          <option value='1'>RAM</option>
                          <option value='2'>DISCO</option>
                          </select>
		        
                          <!-- <label style='font-size: 18px;' id='lblForm'class='col-form-label col-xl col-lg'>PERIODO:</label> -->
                 <label style='font-size: 18px;' id='lblForm'class='col-form-label col-xl col-lg'>DESDE:</label>
                     <input class='col-xl col-lg form-control' style='margin-top: 10px;' type='date' name='fecha_desde' id='txtfechadesdeA' >
                 
                 <label style='font-size: 18px;' id='lblForm'class='col-form-label col-xl col-lg'>HASTA:</label>
                     <input class='col-xl col-lg form-control' style='margin-top: 10px;' type='date' name='fecha_hasta' id='txtfechahastaA' >
				</div>


                <div class="form-group row justify-content-end" style="margin-right:10px;">
                <label style='font-size: 18px;' id='lblForm'class='col-form-label col-xl col-lg'>AREA:</label>
                <select name="slcarea" id="slcarea" class="col-xl col-lg" style="height: 20px;">
									<option value="" selected disabled>-SELECCIONE UNA-</option>
                                    <?php
									include("conexion.php");
									$consulta= "SELECT * FROM area";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_AREA']?>"><?php echo $opciones['AREA']?></option>
									<?php endforeach ?>
								</select>
								<script>
										$('#slcarea').select2();
								</script>
								<script>
										$(document).ready(function(){
											$('#slcarea').change(function(){
												buscador='b='+$('#buscador').val();
												$.ajax({
													type: 'post',
													url: 'Controladores/session.php',
													data: buscador,
													success: function(r){
														$('#tabla').load('Componentes/Tabla.php');
													}
												})
											})
										})
									</script>
				
					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px;" type="submit" name="btn2" value="BUSCAR"></input>

					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px; margin-right: 10px;" type="submit" name="btn1" value="LIMPIAR"></input>
				</div>
		</form>
		</div>
		<hr>

	<title>MEJORAS EQUIPOS</title><meta charset="utf-8">
		
        <br>
        
        
		

        <?php
		
        if(isset($_POST['btn2'])){
            $mej=$_POST['slcTipo'];
            $fechadesde=$_POST['fecha_desde'];
            $fechahasta=$_POST['fecha_hasta'];
            if ($fechadesde==""||$fechahasta=="" & isset($_POST['slcarea'])) {
                $area=$_POST['slcarea'];
                if ($mej==1) {
                    $fecha = date("Y-m-d");
                echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
                
                
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                FROM mejoras m
                inner join wsmem w on m.ID_WS=w.ID_WS
                inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                inner join discows ds on m.ID_WS=ds.ID_WS
                inner join disco d on ds.ID_DISCO=d.ID_DISCO
                inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                inner join inventario i on m.ID_WS=i.ID_WS
                where me.ORDEN_MEMORIA>(SELECT max(me2.ORDEN_MEMORIA) from mejoras ms INNER JOIN
                                memoria me2 on ms.MEMORIA1=me2.ID_MEMORIA where m.ID_WS=ms.ID_WS and m.ID_MEJORA>ms.ID_MEJORA)
                                and i.ID_AREA=$area    GROUP BY m.ID_MEJORA DESC");
                }
                if ($mej==2) {
                    $fecha = date("Y-m-d");
                echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
                
                
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                FROM mejoras m
                inner join wsmem w on m.ID_WS=w.ID_WS
                inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                inner join discows ds on m.ID_WS=ds.ID_WS
                inner join disco d on m.DISCO1=d.ID_DISCO
                inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                inner join inventario i on m.ID_WS=i.ID_WS
                where d.ORDEN_DISCO>(SELECT max(di.ORDEN_DISCO) from mejoras mem INNER JOIN
                                disco di on mem.DISCO1=di.ID_DISCO where m.ID_WS=mem.ID_WS and m.ID_MEJORA>mem.ID_MEJORA)
                                    or td.RANKING_TIPOD>(select td2.RANKING_TIPOD  from mejoras me2
                                    inner join discows dw on me2.ID_WS=dw.ID_WS
                                    inner join tipodisco td2 on dw.ID_TIPOD=td2.ID_TIPOD
                                    where m.ID_WS=me2.ID_WS limit 1) and i.ID_AREA=$area
                        GROUP BY m.ID_MEJORA DESC");
                }}
            if ($fechadesde==""||$fechahasta=="") {
                if ($mej==1) {
                    $fecha = date("Y-m-d");
                echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
                
                
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                FROM mejoras m
                inner join wsmem w on m.ID_WS=w.ID_WS
                inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                inner join discows ds on m.ID_WS=ds.ID_WS
                inner join disco d on ds.ID_DISCO=d.ID_DISCO
                inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                where me.ORDEN_MEMORIA>(SELECT max(me2.ORDEN_MEMORIA) from mejoras ms INNER JOIN
                                memoria me2 on ms.MEMORIA1=me2.ID_MEMORIA where m.ID_WS=ms.ID_WS and m.ID_MEJORA>ms.ID_MEJORA)
                    GROUP BY m.ID_MEJORA DESC");
                }
                if ($mej==2) {
                    $fecha = date("Y-m-d");
                echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
                
                
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                FROM mejoras m
                inner join wsmem w on m.ID_WS=w.ID_WS
                inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                inner join discows ds on m.ID_WS=ds.ID_WS
                inner join disco d on m.DISCO1=d.ID_DISCO
                inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                where d.ORDEN_DISCO>(SELECT max(di.ORDEN_DISCO) from mejoras mem INNER JOIN
                                disco di on mem.DISCO1=di.ID_DISCO where m.ID_WS=mem.ID_WS and m.ID_MEJORA>mem.ID_MEJORA)
                                    or td.RANKING_TIPOD>(select td2.RANKING_TIPOD  from mejoras me2
                                    inner join discows dw on me2.ID_WS=dw.ID_WS
                                    inner join tipodisco td2 on dw.ID_TIPOD=td2.ID_TIPOD
                                    where m.ID_WS=me2.ID_WS limit 1)
                        GROUP BY m.ID_MEJORA DESC");
                }}


                else {
                    if ($mej==1) {
                        $fecha = date("Y-m-d");
                    echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
                    
                    
                    $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                    FROM mejoras m
                    inner join wsmem w on m.ID_WS=w.ID_WS
                    inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                    inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                    inner join discows ds on m.ID_WS=ds.ID_WS
                    inner join disco d on ds.ID_DISCO=d.ID_DISCO
                    inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                    inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                    where me.ORDEN_MEMORIA>(SELECT max(me2.ORDEN_MEMORIA) from mejoras ms INNER JOIN
                                     memoria me2 on ms.MEMORIA1=me2.ID_MEMORIA where m.ID_WS=ms.ID_WS and m.ID_MEJORA>ms.ID_MEJORA)
                                     and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'
                                        GROUP BY m.ID_MEJORA DESC");
                    }
                    if ($mej==2) {
                        $fecha = date("Y-m-d");
                    echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
                    
                    
                    $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                    FROM mejoras m
                    inner join wsmem w on m.ID_WS=w.ID_WS
                    inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                    inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                    inner join discows ds on m.ID_WS=ds.ID_WS
                    inner join disco d on m.DISCO1=d.ID_DISCO
                    inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                    inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                    where d.ORDEN_DISCO>(SELECT max(di.ORDEN_DISCO) from mejoras mem INNER JOIN
                                     disco di on mem.DISCO1=di.ID_DISCO where m.ID_WS=mem.ID_WS and m.ID_MEJORA>mem.ID_MEJORA)
                                        or td.RANKING_TIPOD>(select td2.RANKING_TIPOD  from mejoras me2
                                        inner join discows dw on me2.ID_WS=dw.ID_WS
                                        inner join tipodisco td2 on dw.ID_TIPOD=td2.ID_TIPOD
                                        where m.ID_WS=me2.ID_WS limit 1)
                                        and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'
                            GROUP BY m.ID_MEJORA DESC");
                    }}
                }
    
    
		else{
        $fecha = date("Y-m-d");
		echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
        
        
        $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
        FROM mejoras m
        inner join wsmem w on m.ID_WS=w.ID_WS
        inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
        inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
        inner join discows ds on m.ID_WS=ds.ID_WS
        inner join disco d on m.DISCO1=d.ID_DISCO
        inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
		inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
		GROUP BY m.ID_MEJORA DESC");}?>
	
        <?php echo "<table width=100%>
        <thead>
        <tr>
        <th><p class=g>NRO. WS</p></th>
		<th><p class=g>FECHA</p></th>
		<th><p class=g>MEJORA</p></th>
        <th><p class=g>MEMORIA</p></th>
		<th><p class=g>TIPO MEMORIA</p></th>
		<th><p class=g>PLACA</p></th>
		<th><p class=g>DISCO</p></th>
		<th><p class=g>TIPO DISCO</p></th>
        
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
        <td><h4 >".$listar['ID_MEJORA']."</font></h4></td>
        <td><h4 >".$listar['MEMORIA']."</font></h4></td>
        <td><h4 >".$listar['TIPOMEM']."</font></h4></td>
        <td><h4 >".$listar['PLACAM']."</font></h4></td>
        <td><h4 >".$listar['DISCO']."</font></h4></td>
        <td><h4 >".$listar['TIPOD']."</font></h4></td>
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