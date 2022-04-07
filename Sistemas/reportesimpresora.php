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
	<title>Inventario</title><meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estiloreporte.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>

		<style>
			#h2{
	              text-align: left;	
	              font-family: TrasandinaBook;
	              font-size: 16px;
	              color: #edf0f5;
	              margin-left: 10px;
	              margin-top: 5px;;
               
				}
        </style>
        <section id="reporte">
        <?php
        $seleccion=$_POST['tiporeporteinvent'];
        ?>
        <div id="mostrar_reporte" style="width: 97%; margin-left: 20px; display: block;">
			
		            <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
	                    <a id="vlv" href="tiporeporte.php" class="col-3 btn btn-primary " type="button"  value="VOLVER">VOLVER</a>
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
			        
					if($seleccion=='AREA'){
                        $conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from periferico p
			            where p.TIPOP='IMPRESORA'");
			            $total = mysqli_fetch_array($conttotal);
						echo "
						<h1 >REPORTE DE RESOLUTORES</h1>
                        <hr style='display: block;'>
				        <h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL INCIDENTES: ".$total['TOTAL']."</h2>
						<table class='table table-striped table-hover' width=97%>
						<thead>
						<tr style='background-color: #00519C'>
						<th class='cabecera'><p>AREA</p></th>
						<th class='cabecera'><p>TOTAL</p></th>
						</tr>
						</thead>";
						$consultar=mysqli_query($datos_base, "SELECT a.AREA, count(*) as TOTAL from periferico p left join area a on p.ID_AREA=a.ID_AREA
						and p.TIPOP='IMPRESORA' group by a.AREA");
									while($listar = mysqli_fetch_array($consultar))
									{
										if ($listar['AREA']== null) {
											$nombre = 'SIN AREA';
										}
										else {
											$nombre = $listar['AREA'];
										}
				
													echo
													"
														<tr>
														<td><h4 style='text-align: left;	'>".$nombre."</h4></td>
														<td><h4 style='text-align: center;	'>".$listar['TOTAL']."</h4></td>
														</tr>	
													"; 
												
									}
					}
                    if ($seleccion=='ESTADO') {
                        echo "<table width=100%>
						<thead>
						<tr>
						<th><p>N° WS</p></th>
						<th><p>USUARIO</p></th>
						<th><p>ÁREA</p></th>
						<th><p>MOTHERBOARD</p></th>
						<th><p>S.O.</p></th>
						<th><p>MICRO</p></th>
						<th><p>MAS DETALLES</p></th>
						</tr>
						</thead>";

						$consultar=mysqli_query($datos_base, "");
									while($listar = mysqli_fetch_array($consultar))
									{
										echo
										" 
											<tr>
											<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['MOTHERBOARD']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['SIST_OP']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['MICRO']."</h4></td>
											<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalleinv.php?no=".$listar['ID_WS']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
											<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
											<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
										  </svg></a></td>
											</tr>
										";
									}
                    }
					if ($seleccion=='PROVEEDOR')
					{
						echo "<table width=100%>
						<thead>
						<tr>
						<th><p>N° WS</p></th>
						<th><p>USUARIO</p></th>
						<th><p>ÁREA</p></th>
						<th><p>MOTHERBOARD</p></th>
						<th><p>S.O.</p></th>
						<th><p>MICRO</p></th>
						<th><p>MAS DETALLES</p></th>
						</tr>
						</thead>";
					    $consultar=mysqli_query($datos_base, "");
									while($listar = mysqli_fetch_array($consultar))
									{

										echo
										" 
											<tr>
											<td><h4 style='font-size:16px;'>".$listar['SERIEG']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['NOMBRE']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['AREA']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['MOTHERBOARD']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['SIST_OP']."</h4></td>
											<td><h4 style='font-size:16px;'>".$listar['MICRO']."</h4></td>
											<td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalleinv.php?no=".$listar['ID_WS']." class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
										<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
										<path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
									  </svg></a></td>
											</tr>
										";
										$contador = $contador + 1;
									}
								}
									echo "
					</table>";
					?>
        </section>
</body>
</html>