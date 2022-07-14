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
	<title>Reporte de Estados</title><meta charset="utf-8">
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
<div id="reporteEst" style="width: 97%; margin-left: 20px;">
       
	   <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
	      <a id="vlv"  href="reporteincidentes.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
          <div class="btn-group col-2" role="group" >
                              <button id="botonleft" type="button" class="btn btn-secondary" onclick="location.href='consulta.php'" ><i style=" margin-bottom:10px;"class='bi bi-house-door'></i></button>
                              <button id="botonright" type="button" class="btn btn-success" onClick="imprimir()" ><i class='bi bi-printer'></i></button>
                        </div>
		</div>
		
		<style type="text/css" media="print">
          @media print {
          #vlv {display:none;}
          #pr, #botonleft, #botonright {display:none;}
		  #pr2 {display:none;}
		  .cabe{display: none;}
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
			$conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from ticket
			where FECHA_INICIO BETWEEN '$fechadesde' and '$fechahasta'");
			$total = mysqli_fetch_array($conttotal);
	 			echo "
				 <h1>REPORTE DE ESTADOS</h1>
			     <hr style='display: block;'>
				 <h4 class='indicadores'>PERIODO</h2>
				 <h4 class='indicadores'>DESDE: $fechadesde</h2>
				 <h4 class='indicadores'>HASTA: $fechahasta </h2>
				 <h4 class='indicadores'>TOTAL INCIDENTES: ".$total['TOTAL']."</h2>

				 <table>
			 		<thead style='border-bottom: solid 5px #073256 !important;'>
                    <tr>
                         <th><p class='cabecera'>ESTADO</p></th>
                         <th><p class='cabecera'>NRO. DE INCIDENTES</p></th>
						 <th class='cabe'><p class='cabecera' style='width: 80px;' >ACCION</p></th>
                    </tr>
			 		</thead>
				 	";
                     
                    $consulta=mysqli_query($datos_base, "SELECT e.ESTADO, r.ID_ESTADO, COUNT(*) as TOTAL from ticket r LEFT JOIN estado e ON r.ID_ESTADO=e.ID_ESTADO 
                    where r.FECHA_INICIO BETWEEN '$fechadesde' and '$fechahasta'
                    GROUP BY e.ESTADO");
					            $nombre = "";
				 				while($listar = mysqli_fetch_array($consulta)) 	
								 {
									 if ($listar['ESTADO']== null) {
										 $nombre = 'SIN ESTADO';
									 }
									 else {
										 $nombre = $listar['ESTADO'];
									 }
// <form method='POST' action='detalleestadoincidentes.php'>
									echo
									"   <input type='hidden' name='fechdesde' value='".$fechadesde."' />
									    <input type='hidden' name='fechhasta' value='".$fechahasta."' />
										<tr style='border-bottom: solid 1px #073256;'>
										<td><h4 style='text-align: center;	'>".$nombre."</h4></td>
										<td><h4 style='text-align: center;	'>".$listar['TOTAL']."</h4></td>
										<td class='text-center text-nowrap cabe'  style='width: 80px;'><a class='btn btn-sm btn-outline-primary' href='detalleestadoincidentes.php?Estado=".$listar['ID_ESTADO']."&desde=$fechadesde&hasta=$fechahasta' class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
																<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
																<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
															  </svg></a></td>
										</tr>
									"; 
								} 
			?>			

					
	    </div>

		
		<script src="sc.js"></script>
</body>
</html>