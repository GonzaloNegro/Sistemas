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
        <div id="mostrar_reporte" style="width: 97%; margin-left: 20px; display:block">   			
        
		<div id="cabecerareport" class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
	           <?php
					$mej=$_GET['mejora'];
					echo"
					<div id='boxrepart' class='form-group row'>
                    <a id='vlv' href='tiporeporte.php' class='col-3 btn btn-primary '
                        style='margin-top: 2px; margin-bottom: 2px; height: 42px;' type='button'
                        value='VOLVER'>VOLVER</a>
					
                    <label id='lblForm' style='font-size:18px; margin-top: 2px; margin-bottom: 2px; width: 100px;'
                        class='col-form-label col-xl col-lg'>SELECCIONE TIPO DE MEJORA:</label>
						
                        <select id='slcrepart' name='selectorrepart' class='form-control col-xl col-lg' style='width:250px'  onChange='window.location.href=this.value' required>
                          <option value='0' selected disabled>-TODOS-</option>
                          <option value='reportemejorasequipos.php?mejora=1'>RAM</option>
                          <option value='reportemejorasequipos.php?mejora=2'>DISCO</option>
                          </select>
					</div>
                	"?>
					<div id='botonera' class='form-group row'>
                    	<div class='btn-group col-2' role='group' style='margin: 5px; margin-right: 5px;'>
                        <button id='botonleft' type='button' class='btn btn-secondary'
                            onclick="location.href='consulta.php'"><i style=' margin-bottom:10px;'
                                class='bi bi-house-door'></i></button>
                        <button id='botonright' type='button' class='btn btn-success' onClick='imprimir()'><i
                                class='bi bi-printer'></i></button>
                    	</div>
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
	<title>MEJORAS EQUIPOS</title><meta charset="utf-8">
		
        <br>
        <h1>MEJORAS EQUIPOS</h1>
		<div id="filtrosprin">
        </div>
        
		

        <?php
		
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
		where d.ORDEN_DISCO>(SELECT max(di.ORDEN_DISCO) from mejoras me INNER JOIN
                         disco di on me.DISCO1=di.ID_DISCO where m.ID_WS=me.ID_WS and m.ID_MEJORA>me.ID_MEJORA)
GROUP BY m.ID_MEJORA DESC");
		}
		

		if($mej==0){
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