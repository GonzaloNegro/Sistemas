<?php 
session_start();
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
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<!--BUSCADOR SELECT-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<!--FIN BUSCADOR SELECT-->
    <link rel="stylesheet" type="text/css" href="../estilos/estiloreporte.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>

<div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
    <a id="vlv"  href="../reportes/tiporeporte.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="btn-group col-2" role="group" >
            <button id="botonleft" type="button" class="btn btn-secondary" onclick="location.href='../consulta/consulta.php'" ><i style=" margin-bottom:10px;"class='bi bi-house-door'></i></button>
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
                    <script>
                        function limpiar_formulario(form){
                            form.submit();}
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




	<!--FORMULARIO DONDE SE UBICAN TODOS LOS FILTROS PARA REALIZAR LA BUSQUEDA-->
		<form id="campos" method="POST" action="reportemejorasequipos.php">
		
        <div class="form-group row" style="margin-top: 15px; margin-right:10px;">

		<label id='lblForm' style='font-size:18px; margin-top: 2px; margin-bottom: 2px; width: 90px;'
                        class='col-form-label col-xl col-lg'>TIPO DE MEJORA:</label>
						
                        <select id='slcTipo' name='slcTipo'  class='form-control col-xl col-lg' style='width:250px' required>
                          <option value='' selected disabled>-TODOS-</option>
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
                                    #SE OBTIENEN LAS OPCIONES POR CONSULTA SQL
									include("../particular/conexion.php");
									$consulta= "SELECT a.ID_AREA, a.AREA, r.REPA FROM area a inner join reparticion r on a.ID_REPA=r.ID_REPA ORDER BY AREA ASC";
									$ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
									?>
									<?php foreach ($ejecutar as $opciones): ?> 
									<option value="<?php echo $opciones['ID_AREA']?>"><?php echo $opciones['AREA']?> - <?php echo $opciones['REPA']?></option>
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

					<input id="vlva" class="button col-xl-2 col-lg-2" style="margin-left: 10px; margin-top: 10px; margin-right: 10px;" type="button" onClick="limpiar_formulario(this.form)" name="btn1" value="LIMPIAR"></input>
				</div>
		</form>
		</div>
		<hr>

	<title>MEJORAS EQUIPOS</title><meta charset="utf-8">
		
        <br>
        
        
		

        <?php
        #CONDICIONAL QUE DETECTA SI SE RECIBIO UN FORMULARIO O NO
		if (isset($_POST['btn2'])) {
            #CABECERA PARA INDICAR FECHA D EMEJORA, TIPO Y NUMERO
            $mej=$_POST['slcTipo'];
            $fecha = date("Y-m-d");
            echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
            
            if ($mej==1) {
                echo"<h4 class='indicadores' style='margin-bottom: 10px;'>TIPO MEJORA: RAM</h2>";
            }
            if ($mej==2) {
                echo"<h4 class='indicadores' style='margin-bottom: 10px;'>TIPO MEJORA: DISCO</h2>";
            }
            #CONDICIONALES PARA FILTRAR D EACUERDO A SELECCION
            #AREA
            if (isset($_POST['slcarea'])){
                $area= $_POST['slcarea'];
                $consulArea=mysqli_query($datos_base, "SELECT AREA from area where ID_AREA=$area");
                $consulAr=mysqli_fetch_array($consulArea);
                $ar=$consulAr['AREA'];
                echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>AREA: $ar</h4>";
                if ($mej==1) {
                
                #RAM
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, i.SERIEG, m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
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
                                and i.ID_AREA=$area GROUP BY m.ID_MEJORA DESC");
                }
                if ($mej==2) {
                
                #DISCO
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, i.SERIEG, m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
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
                }
            }
            #PERIODO
            if($_POST['fecha_desde']!='' & $_POST['fecha_hasta']!=''){
                $fechadesde=$_POST['fecha_desde'];
                $fechahasta=$_POST['fecha_hasta'];
                echo"
                <h4 class='indicadores' style='margin-bottom: 10px;'>PERIODO</h2>
				 <h4 class='indicadores' style='margin-bottom: 10px;'>DESDE: $fechadesde</h2>
				 <h4 class='indicadores' style='margin-bottom: 10px;'>HASTA: $fechahasta </h2>";
                if ($mej==1) {
                    #RAM
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, i.SERIEG, m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
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
                                and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta' GROUP BY m.ID_MEJORA DESC");
                }
                if ($mej==2) {
                    
                
                #DISCO
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, i.SERIEG, m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
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
                                    where m.ID_WS=me2.ID_WS limit 1)and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'
                        GROUP BY m.ID_MEJORA DESC");
                }
            }
            #PERIODO Y AREA
            if($_POST['fecha_desde']!='' & $_POST['fecha_hasta']!='' & isset($_POST['slcarea'])){
                $fechadesde=$_POST['fecha_desde'];
                $fechahasta=$_POST['fecha_hasta'];
                $area= $_POST['slcarea'];
                if ($mej==1) {
                #RAM
                
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, i.SERIEG, m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                FROM mejoras m
                inner join wsmem w on m.ID_WS=w.ID_WS
                inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                inner join discows ds on m.ID_WS=ds.ID_WS
                inner join disco d on ds.ID_DISCO=d.ID_DISCO
                inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                INNER JOIN inventario i on i.ID_WS=m.ID_WS
                where me.ORDEN_MEMORIA>(SELECT max(me2.ORDEN_MEMORIA) from mejoras ms INNER JOIN
                                memoria me2 on ms.MEMORIA1=me2.ID_MEMORIA where m.ID_WS=ms.ID_WS and m.ID_MEJORA>ms.ID_MEJORA)
                                and i.ID_AREA=$area and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta' GROUP BY m.ID_MEJORA DESC");
                }
                if ($mej==2) {
                
                #DISCO
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, i.SERIEG, m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
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
                                    where m.ID_WS=me2.ID_WS limit 1) and i.ID_AREA=$area and M.FECHA BETWEEN '$fechadesde' AND '$fechahasta'
                        GROUP BY m.ID_MEJORA DESC");
                }
            }
            #SIN SELECCION
            if(empty($_POST['fecha_desde']) & empty($_POST['fecha_hasta']) & empty($_POST['slcarea'])) {
                if ($mej==1) {
                
                #RAM
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, i.SERIEG, m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                FROM mejoras m
                inner join wsmem w on m.ID_WS=w.ID_WS
                inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                inner join discows ds on m.ID_WS=ds.ID_WS
                inner join disco d on ds.ID_DISCO=d.ID_DISCO
                inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                INNER JOIN inventario i on i.ID_WS=m.ID_WS
                where me.ORDEN_MEMORIA>(SELECT max(me2.ORDEN_MEMORIA) from mejoras ms INNER JOIN
                                memoria me2 on ms.MEMORIA1=me2.ID_MEMORIA where m.ID_WS=ms.ID_WS and m.ID_MEJORA>ms.ID_MEJORA)
                    GROUP BY m.ID_MEJORA DESC");
                }
                if ($mej==2) {
                
                #DISCO
                $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, i.SERIEG, m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                FROM mejoras m
                inner join wsmem w on m.ID_WS=w.ID_WS
                inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                inner join discows ds on m.ID_WS=ds.ID_WS
                inner join disco d on m.DISCO1=d.ID_DISCO
                inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                INNER JOIN inventario i on i.ID_WS=m.ID_WS
                where d.ORDEN_DISCO>(SELECT max(di.ORDEN_DISCO) from mejoras mem INNER JOIN
                                disco di on mem.DISCO1=di.ID_DISCO where m.ID_WS=mem.ID_WS and m.ID_MEJORA>mem.ID_MEJORA)
                                    or td.RANKING_TIPOD>(select td2.RANKING_TIPOD  from mejoras me2
                                    inner join discows dw on me2.ID_WS=dw.ID_WS
                                    inner join tipodisco td2 on dw.ID_TIPOD=td2.ID_TIPOD
                                    where m.ID_WS=me2.ID_WS limit 1)
                        GROUP BY m.ID_MEJORA DESC");
                }
            }}
       
        
        else{
            #NO HAY OCIONES SELECCIONADAS DE NINGUN TIPO
            $fecha = date("Y-m-d");
            echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>FECHA: $fecha</h4>";
            
            
            $consultarMovimientos=mysqli_query($datos_base, "SELECT m.ID_WS, i.SERIEG,m.FECHA, m.ID_MEJORA, me.MEMORIA, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
            FROM mejoras m
            inner join wsmem w on m.ID_WS=w.ID_WS
            inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
            inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
            inner join discows ds on m.ID_WS=ds.ID_WS
            inner join disco d on m.DISCO1=d.ID_DISCO
            inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
            inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
            INNER JOIN inventario i on i.ID_WS=m.ID_WS
            where me.ORDEN_MEMORIA>(SELECT max(me2.ORDEN_MEMORIA) from mejoras ms INNER JOIN
                                memoria me2 on ms.MEMORIA1=me2.ID_MEMORIA where m.ID_WS=ms.ID_WS and m.ID_MEJORA>ms.ID_MEJORA)
            or d.ORDEN_DISCO>(SELECT max(di.ORDEN_DISCO) from mejoras mem INNER JOIN
                                disco di on mem.DISCO1=di.ID_DISCO where m.ID_WS=mem.ID_WS and m.ID_MEJORA>mem.ID_MEJORA)
                                    or td.RANKING_TIPOD>(select td2.RANKING_TIPOD  from mejoras me2
                                    inner join discows dw on me2.ID_WS=dw.ID_WS
                                    inner join tipodisco td2 on dw.ID_TIPOD=td2.ID_TIPOD
                                    where m.ID_WS=me2.ID_WS limit 1)
            GROUP BY m.ID_MEJORA DESC");}
        ?>
    <!--CABECERA TAMBLA HTML-->
        <?php echo "<table width=100%>
        <thead>
        <tr>
        <th><p class=g>NRO. WS</p></th>
		<th><p class=g>FECHA</p></th>
		<!--<th><p class=g>Nro. MEJORA</p></th>-->
        <th><p class=g>MEMORIA</p></th>
		<th><p class=g>TIPO MEMORIA</p></th>
        <th><p class=g>DISCO</p></th>
		<th><p class=g>TIPO DISCO</p></th>
		<th><p class=g>PLACA</p></th>
		</tr>
        </thead>
        ";
        $contador=0;
        #SE EXTRAEN TODAS LAS FILAS DE LA CONSULTA SQL FINAL 
        while($listar = mysqli_fetch_array($consultarMovimientos))
        
				
	    {
            $fecord = date("d-m-Y", strtotime($listar['FECHA']));

            $nWS=$listar['ID_WS'];
			                            $memoriaram=mysqli_query($datos_base, "SELECT w.ID_WS,w.ID_MEMORIA, m.MEMORIA, w.SLOT from wsmem w inner join memoria m on w.ID_MEMORIA=m.ID_MEMORIA where w.ID_WS=$nWS");
						                $ram1="";$ram2="";$ram3="";$ram4="";
										while($memram= mysqli_fetch_array($memoriaram)){
											if ($memram['SLOT']==1) {
												$ram1=$memram['MEMORIA'];
											}
											if ($memram['SLOT']==2) {
												$ram2=$memram['MEMORIA'];
											}
											if ($memram['SLOT']==3) {
												$ram3=$memram['MEMORIA'];
											}
											if ($memram['SLOT']==4) {
												$ram4=$memram['MEMORIA'];
											}

										}
										$tiporam=mysqli_query($datos_base, "SELECT w.ID_WS, w.SLOT, t.TIPOMEM from wsmem w inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM where w.ID_WS=$nWS");
						                $tram1="";$tram2="";$tram3="";$tram4="";
										while($tmemram= mysqli_fetch_array($tiporam)){
											if ($tmemram['SLOT']==1) {
												$tram1=$tmemram['TIPOMEM'];
											}
											if ($tmemram['SLOT']==2) {
												$tram2=$tmemram['TIPOMEM'];
											}
											if ($tmemram['SLOT']==3) {
												$tram3=$tmemram['TIPOMEM'];
											}
											if ($tmemram['SLOT']==4) {
												$tram4=$tmemram['TIPOMEM'];
											}

										}

										$discos=mysqli_query($datos_base, "select d.NUMERO, t.DISCO from discows d inner join disco t on d.ID_DISCO=t.ID_DISCO where d.ID_WS=$nWS");
						                $disco1="";$disco2="";
										while($disc= mysqli_fetch_array($discos)){
											if ($disc['NUMERO']==1) {
												$disco1=$disc['DISCO'];
											}
											if ($disc['NUMERO']==2) {
												$disco2=$disc['DISCO'];
											}
											if ($disc['NUMERO']==3) {
												$disco3=$disc['DISCO'];
											}
											if ($disc['NUMERO']==4) {
												$disco4=$disc['DISCO'];
											}

										}

										$tdiscos=mysqli_query($datos_base, "select d.ID_WS, d.ID_DISCO, d.NUMERO, t.TIPOD from discows d inner join tipodisco t on d.ID_TIPOD=t.ID_TIPOD where d.ID_WS=$nWS");
						                $tdisco1="";$tdisco2="";
										while($tdisc= mysqli_fetch_array($tdiscos)){
											if ($tdisc['NUMERO']==1) {
												$tdisco1=$tdisc['TIPOD'];
											}
											if ($tdisc['NUMERO']==2) {
												$tdisco2=$tdisc['TIPOD'];
											}
											if ($tdisc['NUMERO']==3) {
												$tdisco3=$tdisc['TIPOD'];
											}
											if ($tdisc['NUMERO']==4) {
												$tdisco4=$tdisc['TIPOD'];
											}

										}							

        if (isset($_POST['btn2'])) {                          
        if ($mej==1) {
            #MEJORAS DE RAM
            $memoriaram=mysqli_query($datos_base, "SELECT w.ID_WS,w.ID_MEMORIA, m.MEMORIA, m.ORDEN_MEMORIA, w.SLOT from wsmem w inner join memoria m on w.ID_MEMORIA=m.ID_MEMORIA where w.ID_WS=$nWS");
						                $totalram=0;
                                        #EN LA TABLA SQL DE MEMORIA TIENEN UN ORDEN PARA INDICAR TAMAÑO
										while($memram= mysqli_fetch_array($memoriaram)){
                                            #SE OBTIENE EL ORDEN DE CADA SLOT Y SE VAN SUMANDO EN UNA VARIABLE
											if ($memram['SLOT']==1) {
												$totalram=$memram['ORDEN_MEMORIA']+$totalram;
											}
											if ($memram['SLOT']==2) {
												$totalram=$memram['ORDEN_MEMORIA']+$totalram;
											}
											if ($memram['SLOT']==3) {
												$totalram=$memram['ORDEN_MEMORIA']+$totalram;
											}
											if ($memram['SLOT']==4) {
												$ntotalram=$memram['ORDEN_MEMORIA']+$totalram;
											}

										}

            $nroMejora=$listar['ID_MEJORA'];
            #SE OBTIENEN LOS DATOS DE MEMORIA DELMOVIMIENTO ANTERIOR DEL EQUIPO Y SE SUMAN EN OTRA VARIABLE
            $idramAnt1=mysqli_query($datos_base, "SELECT m.MEMORIA1, n.ORDEN_MEMORIA FROM mejoras m inner join memoria n on m.memoria1=n.ID_MEMORIA where m.ID_WS=$nWS and m.ID_MEJORA<$nroMejora limit 1");
            $idramAnt2=mysqli_query($datos_base, "SELECT m.MEMORIA2, n.ORDEN_MEMORIA FROM mejoras m inner join memoria n on m.memoria2=n.ID_MEMORIA where m.ID_WS=$nWS and m.ID_MEJORA<$nroMejora limit 1");
            $idramAnt3=mysqli_query($datos_base, "SELECT m.MEMORIA3, n.ORDEN_MEMORIA FROM mejoras m inner join memoria n on m.memoria3=n.ID_MEMORIA where m.ID_WS=$nWS and m.ID_MEJORA<$nroMejora limit 1");
            $idramAnt4=mysqli_query($datos_base, "SELECT m.MEMORIA4, n.ORDEN_MEMORIA FROM mejoras m inner join memoria n on m.memoria4=n.ID_MEMORIA where m.ID_WS=$nWS and m.ID_MEJORA<$nroMejora limit 1");
            $memramant1= mysqli_fetch_array($idramAnt1);
            $memramant2= mysqli_fetch_array($idramAnt2);
            $memramant3= mysqli_fetch_array($idramAnt3);
            $memramant4= mysqli_fetch_array($idramAnt4);
            $totalramant=$memramant1['ORDEN_MEMORIA']+$memramant2['ORDEN_MEMORIA']+$memramant3['ORDEN_MEMORIA']+$memramant4['ORDEN_MEMORIA'];
            #SI EL TOTAL DE RAM ACTUAL ES MAYOR AL ANTERIOR ESTAMOS ANTE UNA MEJORA Y SE VISUALIZA
            if ($totalram>$totalramant) {
                echo
		" 
        <tr>
        <td><h4 >".$listar['SERIEG']."</font></h4></td>
        <td><h4 >".$fecord."</h4></td>
        <!--<td><h4 >".$listar['ID_MEJORA']."</font></h4></td>-->
        <td><h4 style='font-size:14px;' class='fila'>$ram1-$ram2-$ram3-$ram4</h4></td>
        <td><h4 style='font-size:14px;' class='fila'>$tram1-$tram2-$tram3-$tram4</h4></td>
		<td><h4 style='font-size:14px;' class='fila'>$disco1-$disco2-$disco3-$disco4</h4></td>
		<td><h4 style='font-size:14px;' class='fila'>$tdisco1-$tdisco2-$tdisco3-$tdisco4</h4></td>
        <td><h4 >".$listar['PLACAM']."</font></h4></td>
        </tr>";
            }
            else {
            }
        }
        else {
            echo
		" 
        <tr>
        <td><h4 >".$listar['SERIEG']."</font></h4></td>
        <td><h4 >".$fecord."</h4></td>
        <!--<td><h4 >".$listar['ID_MEJORA']."</font></h4></td>-->
        <td><h4 style='font-size:14px;' class='fila'>$ram1-$ram2-$ram3-$ram4</h4></td>
        <td><h4 style='font-size:14px;' class='fila'>$tram1-$tram2-$tram3-$tram4</h4></td>
		<td><h4 style='font-size:14px;' class='fila'>$disco1-$disco2-$disco3-$disco4</h4></td>
		<td><h4 style='font-size:14px;' class='fila'>$tdisco1-$tdisco2-$tdisco3-$tdisco4</h4></td>
        <td><h4 >".$listar['PLACAM']."</font></h4></td>
        </tr>";
        }}
        else {
            echo
		" 
        <tr>
        <td><h4 >".$listar['SERIEG']."</font></h4></td>
        <td><h4 >".$fecord."</h4></td>
        <!--<td><h4 >".$listar['ID_MEJORA']."</font></h4></td>-->
        <td><h4 style='font-size:14px;' class='fila'>$ram1-$ram2-$ram3-$ram4</h4></td>
        <td><h4 style='font-size:14px;' class='fila'>$tram1-$tram2-$tram3-$tram4</h4></td>
		<td><h4 style='font-size:14px;' class='fila'>$disco1-$disco2-$disco3-$disco4</h4></td>
		<td><h4 style='font-size:14px;' class='fila'>$tdisco1-$tdisco2-$tdisco3-$tdisco4</h4></td>
        <td><h4 >".$listar['PLACAM']."</font></h4></td>
        </tr>";
        }
		
		$contador += 1;}

		echo "<div id=contador class='form-group row justify-content-between'>";
						// if(isset($_POST['buscar'])){
						// 		$filtro = $_POST['buscar'];
						// 		if($filtro != ""){
						// 			$filtro = strtoupper($filtro);
						// 			echo "<p>FILTRADO POR: $filtro</p>";
						// 		}
						// 	}
						echo"<h4 id='ind' class='indicadores' style='margin-bottom: 10px;'>CANTIDAD DE MEJORAS : $contador</h4>
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
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
</body>
</html>

<!-- SELECT m.ID_WS, i.SERIEG, m.FECHA, m.ID_MEJORA, me.MEMORIA,me2.memoria,me3.memoria, t.TIPOMEM , p.PLACAM, d.DISCO, td.TIPOD
                FROM mejoras m
                inner join wsmem w on m.ID_WS=w.ID_WS
                inner join memoria me on m.MEMORIA1=me.ID_MEMORIA
                inner join memoria me2 on m.MEMORIA2=me2.ID_MEMORIA
                inner join memoria me3 on m.MEMORIA3=me3.ID_MEMORIA
                inner join tipomem t on w.ID_TIPOMEM=t.ID_TIPOMEM
                inner join discows ds on m.ID_WS=ds.ID_WS
                inner join disco d on ds.ID_DISCO=d.ID_DISCO
                inner join tipodisco td on ds.ID_TIPOD=td.ID_TIPOD
                inner JOIN placam p on p.ID_PLACAM=m.ID_PLACAM
                INNER JOIN inventario i on i.ID_WS=m.ID_WS
                where me.ORDEN_MEMORIA>(SELECT max(me2.ORDEN_MEMORIA) from mejoras ms INNER JOIN
                                memoria me2 on ms.MEMORIA1=me2.ID_MEMORIA where m.ID_WS=ms.ID_WS and m.ID_MEJORA>ms.ID_MEJORA)
                      or me2.ORDEN_MEMORIA>(SELECT max(me2.ORDEN_MEMORIA) from mejoras ms INNER JOIN
                                memoria me2 on ms.MEMORIA1=me2.ID_MEMORIA where m.ID_WS=ms.ID_WS and m.ID_MEJORA>ms.ID_MEJORA)
                      or me3.ORDEN_MEMORIA>(SELECT max(me2.ORDEN_MEMORIA) from mejoras ms INNER JOIN
                                memoria me2 on ms.MEMORIA1=me2.ID_MEMORIA where m.ID_WS=ms.ID_WS and m.ID_MEJORA>ms.ID_MEJORA)
                    GROUP BY m.ID_MEJORA DESC -->