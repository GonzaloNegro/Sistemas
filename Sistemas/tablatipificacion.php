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
	<title>Reporte de Tipificaciones</title><meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloreporte.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<div id="reporteTIPI" style="width: 97%; margin-left: 20px; display: block;">
        <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
	      <a id="vlv"  href="reporteincidentes.php" class="col-1 vlv btn btn-primary" type="button"  value="VOLVER">VOLVER</a>
          <button id="pr" class="btn btn-success" style="width: 50px; border-radius: 10px;" onClick="imprimir()"><i class='bi bi-printer'></i></button>
		</div>
		
		<style type="text/css" media="print">
          @media print {
          #vlv {display:none;}
          #pr {display:none;}
		  #pr2 {display:none;}
          }
         </style>
	  	<script>
          function imprimir() {
            	window.print();
          }
        </script>
		  
	    	<?php
			
			$fechadesde=$_POST['fecha_desde'];
			$fechahasta=$_POST['fecha_hasta'];
			$fecini = date("d/m/Y", strtotime($fechadesde));
			$fecfin = date("d/m/Y", strtotime($fechahasta));
			$conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from ticket
			where FECHA_INICIO BETWEEN '$fechadesde' and '$fechahasta'");
			$total = mysqli_fetch_array($conttotal);
	 			echo "
				 <h1>REPORTE DE TIPIFICACIONES</h1>
				 <hr style='display: block;'>
				 <h4 class='indicadores'>PERIODO</h2>
				 <h4 class='indicadores'>DESDE: $fechadesde</h2>
				 <h4 class='indicadores'>HASTA: $fechahasta </h2>
				 <h4 class='indicadores'>TOTAL INCIDENTES: ".$total['TOTAL']."</h2>
			     <table class='table table-striped table-hover' width=97%>
			 		<thead>
                    <tr style='background-color: #00519C'>
                         <th><p class='cabecera'>TIPIFICACION</p></th>
                         <th><p class='cabecera'>NRO. DE INCIDENTES</p></th>
                    </tr>
			 		</thead>
				 	";

                     $consulta=mysqli_query($datos_base, "SELECT t.ID_TIPIFICACION, r.TIPIFICACION, count(*) as TOTAL FROM ticket t LEFT JOIN tipificacion r ON t.ID_TIPIFICACION = r.ID_TIPIFICACION where t.FECHA_INICIO BETWEEN '$fechadesde' and '$fechahasta'
					 group by t.ID_TIPIFICACION");
					     $nombre = "";
						 while($listar = mysqli_fetch_array($consulta)) 	
						 {
							 if ($listar['TIPIFICACION']=== null) {
								 $nombre = 'SIN TIPIFICACION';
							 }
							 else {
								 $nombre = $listar['TIPIFICACION'];
							 }

									echo
									"
									<tr>
										<td><h4 style='text-align: left;	'>".$nombre."</h4></td>
										<td><h4 style='text-align: center;	'>".$listar['TOTAL']."</h4></td>
										</tr>	
									"; 
								}
			?>		

					
	    </div>

		
		<script src="sc.js"></script>
</body>
</html>