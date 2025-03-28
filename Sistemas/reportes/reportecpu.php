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
    <title>Inventario</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../estilos/estiloreporte.css">
    <link rel="icon" href="../imagenes/logoInfraestructura.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    body {
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
    <!-- ESTE ARCHIVO TIENE EL CODIGO PARA GENERAR EL REPORTE DE EQUIPOS POR AREA, ESTADO, PROVEEDOR, S.0, MICROPRPOCESADOR)-->
    <section id="reporte">
        <div id="mostrar_reporte" style="width: 97%; margin-left: 20px; display: block;">
            <div id="cabecerareport" class="form-group row justify-content-between"
                style="margin: 10px; margin-bottom: 30px; padding:10px;">

                <?php 
                //SE RECIBE EL TIPO DE REPORTE (AREA, ESTADO, PROVEEDOR, S.O, MICROPROCESADOR) DE reporteinventario.php
						$opc=$_GET['opc']; 
						$reparticion=$_GET['repa'];
				if ($opc!='PROVEEDOR') {
                    //SELECT PARA FILTRAR LOS EQUIPOS POR REPARTICION, se usa la funcion onchange para actualizar la pagina
					echo"		
                <div id='boxrepart' class='form-group row'>
                    <a id='vlv' href='reporteinventario.php' class='col-3 btn btn-primary '
                        style='margin-top: 2px; margin-bottom: 2px; height: 42px;' type='button'
                        value='VOLVER'>VOLVER</a>
                    <label id='lblForm' style='font-size:18px; margin-top: 2px; margin-bottom: 2px; width: 100px;'
                        class='col-form-label col-xl col-lg'>SELECCIONE REPARTICION:</label>
						
                        <select id='slcrepart' name='selectorrepart' class='form-control col-xl col-lg'  onChange='window.location.href=this.value' required>
                          <option value='0' selected disabled>-TODOS-</option>
                          <option value='reportecpu.php?repa=1&opc=$opc'>MINISTERIO HUMBERTO PRIMO 725</option>
                          <option value='reportecpu.php?repa=2&opc=$opc'>ARQUITECTURA</option>
                          <option value='reportecpu.php?repa=3&opc=$opc'>VIVIENDA</option>
                          <option value='reportecpu.php?repa=4&opc=$opc'>MINISTERIO HUMBERTO PRIMO 607</option>
                          </select>
                </div>
				
				"?>
                <div id='botonera' class='form-group row'>
                    <div class='btn-group col-2' role='group' style='margin: 5px; margin-right: 5px;'>
                        <button id='botonleft' type='button' class='btn btn-secondary'
                            onclick="location.href='../consulta/consulta.php'"><i style=' margin-bottom:10px;'
                                class='bi bi-house-door'></i></button>
                        <button id='botonright' type='button' class='btn btn-success' onClick='imprimir()'><i
                                class='bi bi-printer'></i></button>
                    </div>
                </div>
                <?php echo"

                <!-- <button id='pr' class='btn btn-secondary' style='width: 50px; height:45px; border-radius: 10px;' onclick='location.href='../consulta/consulta.php''><i style=' margin-bottom:10px;'class='bi bi-house-door'></i></button>
						<button id='pr' class='btn btn-success' style='width: 50px; border-radius: 10px;' onClick='imprimir()'><i class='bi bi-printer'></i></button> -->
            </div>";}
			else {
				echo"
				<div class='form-group row justify-content-between' style='margin: 10px; padding:10px;'>
	      <a id='vlv'  href='reporteinventario.php' class='col-3 btn btn-primary ' type='button'  value='VOLVER'>VOLVER</a>
          <div class='btn-group col-2' role='group' >
                              <button id='botonleft' type='button' class='btn btn-secondary' onclick='location.href='../consulta/consulta.php'' ><i style=' margin-bottom:10px;'class='bi bi-house-door'></i></button>
                              <button id='botonright' type='button' class='btn btn-success' onClick='imprimir()' ><i class='bi bi-printer'></i></button>
                        </div>
		</div>";
			}
			?>




            <style type="text/css" media="print">
            @media print {
                #vlv {
                    display: none;
                }

                #pr,
                #pr2,
                #cabecerareport {
                    display: none;
                }

                #titulo {
                    margin-top: 50px;
                }

                #ind {
                    margin-top: 20px;
                }

                #tablareporte {
                    margin-top: 20px;
                }

                #accion {
                    display: none;
                }

                #cabeceraacc {
                    display: none;
                }
            }
            </style>
            <script>
            function imprimir() {
                window.print();
            }
            </script>

            <?php

if($reparticion==0) {
    //SI NO SE SELECCIONA NINGUNA REPARTICION SE REALIZA UNA CONSULTA PARA OBTENER EL TOTAL DE EQUIPOS, TOTAL DE CPU Y DE NOTEBOOKS
    $conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario i");
	$total = mysqli_fetch_array($conttotal);
    $contPC=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario i where i.ID_TIPOWS=1");
	$totalPC = mysqli_fetch_array($contPC);
	$contNB=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL from inventario i where i.ID_TIPOWS=2");
	$totalNB = mysqli_fetch_array($contNB);
	$fecha = date("Y-m-d");
    // si la opcion elegida es area Y NO SE ELIGE NINGUNA REPATICION SE GENERA LA CABECERA DE LA TABLA DE EQUIPOS POR AREA  Y SE MUESTRA EL TOTAL DE EQUIPOS Y POR TIPO            
	if($opc=='AREA'){
		$fecha = date("Y-m-d");
		echo "
		<h1 id='titulo'>REPORTE DE EQUIPOS POR AREA</h1>
            <hr style='display: block;'>
            <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>REPARTICION: TODAS</h4>
            <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE PC DE ESCRITORIO: ".$totalPC['TOTAL']."</h4>
			<h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE NOTEBOOKS: ".$totalNB['TOTAL']."</h4>
            <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL EQUIPOS:
                ".$total['TOTAL']."</h4>
            <h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
            <table id='tablareporte' width=97%>
                <thead style='border-bottom: solid 5px #073256 !important;'>
                    <tr>
                        <th class='cabecera'>
                            <p>AREA</p>
                        </th>
                        <th class='cabecera'>
                            <p>TOTAL</p>
                        </th>
                        <th id='cabeceraacc' class='cabecera' width=65px>
                            <p>ACCIÓN</p>
                        </th>
                    </tr>
                </thead>
		";
        //CONSULTA SQL PARA OBTENER EL TOTAL DE EQUIPOS POR AREA
		$consultar=mysqli_query($datos_base, "SELECT a.AREA, i.ID_AREA, count(*) as TOTAL from inventario i left join area a on i.ID_AREA=a.ID_AREA
		group by a.AREA");
                    //AGREGAMOS LOS VALORES DE LA TABLA SQL A LAS FILAS DE LA TABLA HTML
					while($listar = mysqli_fetch_array($consultar))
					{
			
						echo
									"<tr style='border-bottom: solid 1px #073256;'>
									<td>
										<h4 style='text-align: left;	'>".$listar['AREA']."</h4>
									</td>
									<td>
										<h4 style='text-align: center;	'>".$listar['TOTAL']."</h4>
									</td>
									<td class='text-center text-nowrap' id='accion'><a class='btn btn-sm btn-outline-primary'
											href=reporteareaequipo.php?Area=".$listar['ID_AREA']." class=mod><svg
												xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5'
												class='bi bi-eye' viewBox='0 0 16 16'>
												<path
													d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z' />
												<path
													d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z' />
											</svg></a></td>
								</tr>
										
									";
            

            }
            }
                // si la opcion elegida es ESTASDO Y NO SE ELIGE NINGUNA REPATYICION SE GENERA LA CABECERA DE LA TABLA DE EQUIPOS POR ESTADO  Y SE MUESTRA EL TOTAL DE EQUIPOS Y POR TIPO            

            if ($opc=='ESTADO') {
            $fecha = date("Y-m-d");
            echo "
            <h1 id='titulo'>REPORTE DE EQUIPOS POR ESTADO</h1>
            <hr style='display: block;'>
            <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>REPARTICION: TODAS</h4>
            <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE PC DE ESCRITORIO: ".$totalPC['TOTAL']."</h4>
            <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE NOTEBOOKS: ".$totalNB['TOTAL']."</h4>
            <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL EQUIPOS:
                ".$total['TOTAL']."</h4>
            <h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
            <table id='tablareporte' width=97%>
                <thead style='border-bottom: solid 5px #073256 !important;'>
                    <tr >
                        <th class='cabecera'>
                            <p>ESTADO</p>
                        </th>
                        <th class='cabecera'>
                            <p>TOTAL</p>
                        </th>
                        <th id='cabeceraacc' class='cabecera' width=65px>
                            <p>ACCIÓN</p>
                        </th>
                    </tr>
                </thead>";
                //CONSULTA SQL PARA OBTENER EL TOTAL DE EQUIPOS POR ESTADO
                $consultar=mysqli_query($datos_base, "SELECT e.ESTADO, I.ID_ESTADOWS, count(*) as TOTAL from inventario
                i left join estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
                group by e.ESTADO");
                //AGREGAMOS LOS VALORES DE LA TABLA SQL A LAS FILAS DE LA TABLA HTML
                while($listar = mysqli_fetch_array($consultar))
                {
                echo
                "
                <tr style='border-bottom: solid 1px #073256;'>
                    <td>
                        <h4 style='text-align: left;	'>".$listar['ESTADO']."</h4>
                    </td>
                    <td>
                        <h4 style='text-align: center;	'>".$listar['TOTAL']."</h4>
                    </td>
                    <td class='text-center text-nowrap' id='accion'><a class='btn btn-sm btn-outline-primary'
                            href=reporteestadoequipo.php?Estado=".$listar['ID_ESTADOWS']."&Repa=$reparticion class=mod><svg
                                xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5'
                                class='bi bi-eye' viewBox='0 0 16 16'>
                                <path
                                    d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z' />
                                <path
                                    d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z' />
                            </svg></a></td>
                </tr>
                ";



                }
                }
    // si la opcion elegida es PROVEEDOR Y NO SE ELIGE NINGUNA REPATICION SE GENERA LA CABECERA DE LA TABLA DE EQUIPOS POR PROVEEDOR  Y SE MUESTRA EL TOTAL DE EQUIPOS Y POR TIPO            
                if ($opc=='PROVEEDOR')
                {
                $fecha = date("Y-m-d");
                echo "
                <h1 id='titulo'>REPORTE DE EQUIPOS POR PROVEEDOR</h1>
                <hr style='display: block;'>
                <h4 id='ind' class='indicadores' style='margin-top: 20px;'>REPARTICION: TODAS</h4>
            <h4 id='ind' class='indicadores' style='margin-top: 20px;'>NRO. DE PC DE ESCRITORIO: ".$totalPC['TOTAL']."</h4>
            <h4 id='ind' class='indicadores' style='margin-top: 20px;'>NRO. DE NOTEBOOKS: ".$totalNB['TOTAL']."</h4>    
            <h4 id='ind' class='indicadores' style='margin-top: 20px;'>TOTAL EQUIPOS:".$total['TOTAL']."</h4>
                <h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
                <table id='tablareporte' width=97%>
                    <thead style='border-bottom: solid 5px #073256 !important;>
                        <tr>
                            <th class='cabecera'>
                                <p>PROVEEDOR</p>
                            </th>
                            <th class='cabecera'>
                                <p>TOTAL</p>
                            </th>
                            <th id='cabeceraacc' class='cabecera' width=65px>
                                <p>ACCIÓN</p>
                            </th>
                        </tr>
                    </thead>";
        //CONSULTA SQL PARA OBTENER EL TOTAL DE EQUIPOS POR PROVEEEDOR
                    $consultar=mysqli_query($datos_base, "SELECT e.PROVEEDOR, i.ID_PROVEEDOR, count(*) as TOTAL from
                    inventario i left join proveedor e on i.ID_PROVEEDOR=e.ID_PROVEEDOR
                    group by e.proveedor");
                    //AGREGAMOS LOS VALORES DE LA TABLA SQL A LAS FILAS DE LA TABLA HTML
                    while($listar = mysqli_fetch_array($consultar))
                    {
                    echo
                    "
                    <tr style='border-bottom: solid 1px #073256;'>
                        <td>
                            <h4 style='text-align: left;	'>".$listar['PROVEEDOR']."</h4>
                        </td>
                        <td>
                            <h4 style='text-align: center;	'>".$listar['TOTAL']."</h4>
                        </td>
                        <td class='text-center text-nowrap' id='accion'><a class='btn btn-sm btn-outline-primary'
                                href=reporteproveedorequipo.php?Proveedor=".$listar['ID_PROVEEDOR']." class=mod><svg
                                    xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor'
                                    margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
                                    <path
                                        d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z' />
                                    <path
                                        d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z' />
                                </svg></a></td>
                    </tr>
                    ";



                    }
                    }
    // si la opcion elegida es SISTEMAS OPERATIVOS Y NO SE ELIGE NINGUNA REPATYICION SE GENERA LA CABECERA DE LA TABLA DE EQUIPOS POR S.O.  Y SE MUESTRA EL TOTAL DE EQUIPOS Y POR TIPO            
                    if ($opc=='SO')
                    {
                    $fecha = date("Y-m-d");
                    echo "
                    <h1 id='titulo'>REPORTE DE EQUIPOS POR SISTEMA OPERATIVO</h1>
                    <hr style='display: block;'>
                    <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>REPARTICION: TODAS
                    </h4>
            <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE PC DE ESCRITORIO: ".$totalPC['TOTAL']."</h4>
            <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE NOTEBOOKS: ".$totalNB['TOTAL']."</h4>        
            <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL EQUIPOS:
                        ".$total['TOTAL']."</h4>
                    <h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."</h4>
                    <table id='tablareporte' width=97%>
                        <thead style='border-bottom: solid 5px #073256 !important;>
                            <tr>
                                <th class='cabecera'>
                                    <p>SO</p>
                                </th>
                                <th class='cabecera'>
                                    <p>TOTAL</p>
                                </th>
                                <th id='cabeceraacc' class='cabecera' width=65px>
                                    <p>ACCIÓN</p>
                                </th>
                            </tr>
                        </thead>";
                         //CONSULTA SQL PARA OBTENER EL TOTAL DE EQUIPOS POR S.O
                        $consultar=mysqli_query($datos_base, "SELECT s.SIST_OP, i.ID_SO, count(*) as TOTAL from
                        inventario i left join so s on i.ID_SO=s.ID_SO
                        group by s.SIST_OP");
                        //AGREGAMOS LOS VALORES DE LA TABLA SQL A LAS FILAS DE LA TABLA HTML
                        while($listar = mysqli_fetch_array($consultar))
                        {
                        echo
                        "
                        <tr style='border-bottom: solid 1px #073256;'>
                            <td>
                                <h4 style='text-align: left;	'>".$listar['SIST_OP']."</h4>
                            </td>
                            <td>
                                <h4 style='text-align: center;	'>".$listar['TOTAL']."</h4>
                            </td>
                            <td class='text-center text-nowrap' id='accion'><a class='btn btn-sm btn-outline-primary'
                                    href=reportesoequipo.php?SO=".$listar['ID_SO']."&Repa=$reparticion class=mod><svg
                                        xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor'
                                        margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
                                        <path
                                            d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z' />
                                        <path
                                            d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z' />
                                    </svg></a></td>
                        </tr>
                        ";


                        }
                        }
                    // si la opcion elegida es MICRO Y NO SE ELIGE NINGUNA REPATYICION SE GENERA LA CABECERA DE LA TABLA DE EQUIPOS POR MICRO  Y SE MUESTRA EL TOTAL DE EQUIPOS Y POR TIPO            
                        if ($opc=='MICRO')
                        {
                       $fecha = date("Y-m-d");
                        echo "
                        <h1 id='titulo'>REPORTE DE EQUIPOS POR MICROPROCESADOR</h1>
                        <hr style='display: block;'>
                        <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>REPARTICION:
                            TODAS</h4>
            <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE PC DE ESCRITORIO: ".$totalPC['TOTAL']."</h4>
            <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE NOTEBOOKS: ".$totalNB['TOTAL']."</h4>            
            <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL EQUIPOS:
                            ".$total['TOTAL']."</h4>
                        <h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."
                        </h4>
                        <table id='tablareporte' width=97%>
                            <thead  style='border-bottom: solid 5px #073256 !important;'>
                                <tr>
                                    <th class='cabecera'>
                                        <p>MICROPROCESADOR</p>
                                    </th>
                                    <th class='cabecera'>
                                        <p>TOTAL</p>
                                    </th>
                                    <th id='cabeceraacc' class='cabecera' width=65px>
                                        <p>ACCIÓN</p>
                                    </th>
                                </tr>
                            </thead>";
                            //CONSULTA SQL PARA OBTENER EL TOTAL DE EQUIPOS POR MICRO
                            $consultar=mysqli_query($datos_base, "SELECT mi.ID_MICRO, mi.MICRO, count(*) as TOTAL from inventario i
                            LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
	                    LEFT JOIN micro AS mi ON mi.ID_MICRO = mw.ID_MICRO
                            group by mi.MICRO ORDER BY TOTAL DESC");
                            //AGREGAMOS LOS VALORES DE LA TABLA SQL A LAS FILAS DE LA TABLA HTML
                            while($listar = mysqli_fetch_array($consultar))
                            {
                            echo
                            "
                            <tr style='border-bottom: solid 1px #073256;'>
                                <td>
                                    <h4 style='text-align: left;	'>".$listar['MICRO']."</h4>
                                </td>
                                <td>
                                    <h4 style='text-align: center;	'>".$listar['TOTAL']."</h4>
                                </td>
                                <td class='text-center text-nowrap' id='accion'><a class='btn btn-sm btn-outline-primary'
                                        href='reportemicroequipo.php?Micro=".$listar['ID_MICRO']."&Repa=$reparticion' class=mod><svg
                                            xmlns='http://www.w3.org/2000/svg' width='20' height='20'
                                            fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
                                            <path
                                                d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z' />
                                            <path
                                                d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z' />
                                        </svg></a></td>
                            </tr>
                            ";

                            #QUEDA PENDIENTE VER MICROPROCESADOR/ AGREGARLE ID

                            }
                            }

                            echo "
                        </table>";
                        }
                        //SE REALIZA UNA CONSULTA PARA OBTENER EL TOTAL DE EQUIPOS, TOTAL DE CPU Y DE NOTEBOOKS POR REPARTICION
                        if ($reparticion>=1){ 
                        $conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL, r.REPA from inventario i left
                        join area a on i.ID_AREA=a.ID_AREA left join reparticion r on a.ID_REPA=r.ID_REPA where
                        a.ID_REPA=$reparticion");
                        $total = mysqli_fetch_array($conttotal);
                        $fecha = date("Y-m-d");
                        $nomrepa=$total['REPA'];
                        $contPC=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL, r.REPA from inventario i left
                        join area a on i.ID_AREA=a.ID_AREA left join reparticion r on a.ID_REPA=r.ID_REPA where
                        a.ID_REPA=$reparticion and i.ID_TIPOWS=1");
	                    $totalPC = mysqli_fetch_array($contPC);
	                    $contNB=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL, r.REPA from inventario i left
                        join area a on i.ID_AREA=a.ID_AREA left join reparticion r on a.ID_REPA=r.ID_REPA where
                        a.ID_REPA=$reparticion and i.ID_TIPOWS=2");
	                    $totalNB = mysqli_fetch_array($contNB);

                        // si la opcion elegida es area  SE GENERA LA CABECERA DE LA TABLA DE EQUIPOS POR AREA Y REPARTICION  Y SE MUESTRA EL TOTAL DE EQUIPOS Y POR TIPO
                        if($opc=='AREA') {
                        
                        echo "
                        <h1 id='titulo'>REPORTE DE EQUIPOS POR AREA</h1>
                        <hr style='display: block;'>
                        <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>REPARTICION:
                            ".$nomrepa."</h4>
                        <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE PC DE ESCRITORIO: ".$totalPC['TOTAL']."</h4>
						<h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE NOTEBOOKS: ".$totalNB['TOTAL']."</h4>
                        <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL EQUIPOS:
                            ".$total['TOTAL']."</h4>
                        <h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL: ".$fecha."
                        </h4>
                        <table id='tablareporte' width=97%>
                            <thead style='border-bottom: solid 5px #073256 !important;>
                                <tr>
                                    <th class='cabecera'>
                                        <p>AREA</p>
                                    </th>
                                    <th class='cabecera'>
                                        <p>TOTAL</p>
                                    </th>
                                    <th id='cabeceraacc' class='cabecera' width=65px>
                                        <p>ACCIÓN</p>
                                    </th>
                                </tr>
                            </thead>";
                            //CONSULTA SQL PARA OBTENER EL TOTAL DE EQUIPOS POR AREA Y FISTRADO POR REPARTICION
                            $consultar=mysqli_query($datos_base, "SELECT a.AREA, i.ID_AREA, a.ID_REPA, r.REPA, count(*)
                            as TOTAL from inventario i left join area a on i.ID_AREA=a.ID_AREA left join reparticion r
                            on a.ID_REPA=r.ID_REPA where a.ID_REPA=$reparticion
                            group by a.AREA");
                            //AGREGAMOS LOS VALORES DE LA TABLA SQL A LAS FILAS DE LA TABLA HTML
                            while($listar = mysqli_fetch_array($consultar))
                            {

                            echo
                            "
                            <tr style='border-bottom: solid 1px #073256;'>
                                <td>
                                    <h4 style='text-align: left;	'>".$listar['AREA']."</h4>
                                </td>
                                <td>
                                    <h4 style='text-align: center;	'>".$listar['TOTAL']."</h4>
                                </td>
                                <td class='text-center text-nowrap' id='accion'><a class='btn btn-sm btn-outline-primary'
                                        href=reporteareaequipo.php?Area=".$listar['ID_AREA']." class=mod><svg
                                            xmlns='http://www.w3.org/2000/svg' width='20' height='20'
                                            fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
                                            <path
                                                d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z' />
                                            <path
                                                d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z' />
                                        </svg></a></td>
                            </tr>
                            ";}
                            }

                            
                            //SE GENERA LA CABECERA DE LA TABLA DE EQUIPOS POR ESTADO  Y SE MUESTRA EL TOTAL DE EQUIPOS Y POR TIPO   FILTRADO POR REPARTICION  
                            if ($opc=='ESTADO') {
                                    
                                    echo "
                                    <h1 id='titulo'>REPORTE DE EQUIPOS POR ESTADO</h1>
                                    <hr style='display: block;'>
                                    <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>
                                        REPARTICION: ".$nomrepa."</h4>
                                    <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE PC DE ESCRITORIO: ".$totalPC['TOTAL']."</h4>
                                    <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE NOTEBOOKS: ".$totalNB['TOTAL']."</h4>
                                    <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>
                                        TOTAL EQUIPOS: ".$total['TOTAL']."</h4>
                                    <h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL:
                                        ".$fecha."</h4>
                                    <table id='tablareporte' width=97%>
                                        <thead style='border-bottom: solid 5px #073256 !important;'>
                                            <tr >
                                                <th class='cabecera'>
                                                    <p>ESTADO</p>
                                                </th>
                                                <th class='cabecera'>
                                                    <p>TOTAL</p>
                                                </th>
                                                <th id='cabeceraacc' class='cabecera' width=65px>
                                                    <p>ACCIÓN</p>
                                                </th>
                                            </tr>
                                        </thead>";
                                        //CONSULTA SQL PARA OBTENER EL TOTAL DE EQUIPOS POR ESTADO
                                        $consultar=mysqli_query($datos_base, "SELECT e.ESTADO, I.ID_ESTADOWS, count(*)
                                        as TOTAL from inventario i LEFT JOIN estado_ws e on i.ID_ESTADOWS=e.ID_ESTADOWS
                                        left join area a on i.ID_AREA=a.ID_AREA left join reparticion r on
                                        a.ID_REPA=r.ID_REPA where a.ID_REPA=$reparticion
                                        group by e.ESTADO");
                                        //AGREGAMOS LOS VALORES DE LA TABLA SQL A LAS FILAS DE LA TABLA HTML
                                        while($listar = mysqli_fetch_array($consultar))
                                        {

                                        echo"
                                        <tr style='border-bottom: solid 1px #073256;'>
                                            <td>
                                                <h4 style='text-align: left;	'>".$listar['ESTADO']."</h4>
                                            </td>
                                            <td>
                                                <h4 style='text-align: center;	'>".$listar['TOTAL']."</h4>
                                            </td>
                                            <td class='text-center text-nowrap' id='accion'><a
                                                    class='btn btn-sm btn-outline-primary'
                                                    href=reporteestadoequipo.php?Estado=".$listar['ID_ESTADOWS']."&Repa=$reparticion
                                                    class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20'
                                                        height='20' fill='currentcolor' margin='5' class='bi bi-eye'
                                                        viewBox='0 0 16 16'>
                                                        <path
                                                            d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z' />
                                                        <path
                                                            d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z' />
                                                    </svg></a></td>
                                        </tr> ";}

                                        }
                        //SE GENERA LA CABECERA DE LA TABLA DE EQUIPOS POR S.O.  Y SE MUESTRA EL TOTAL DE EQUIPOS Y POR TIPO            

                        if ($opc=='SO') {
                            
                                echo "
                                        <h1 id='titulo'>REPORTE DE EQUIPOS POR SISTEMA OPERATIVO</h1>
                                        <hr style='display: block;'>
                                        <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>
                                            REPARTICION: ".$nomrepa."</h4>
                                        <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE PC DE ESCRITORIO: ".$totalPC['TOTAL']."</h4>
                                        <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE NOTEBOOKS: ".$totalNB['TOTAL']."</h4>
                                        <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>
                                            TOTAL EQUIPOS: ".$total['TOTAL']."</h4>
                                        <h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA
                                            ACTUAL: ".$fecha."</h4>
                                        <table id='tablareporte' width=97%>
                                            <thead  style='border-bottom: solid 5px #073256 !important;'>
                                                <tr >
                                                    <th class='cabecera'>
                                                        <p>ESTADO</p>
                                                    </th>
                                                    <th class='cabecera'>
                                                        <p>TOTAL</p>
                                                    </th>
                                                    <th id='cabeceraacc' class='cabecera' width=65px>
                                                        <p>ACCIÓN</p>
                                                    </th>
                                                </tr>
                                            </thead>";
                                            //CONSULTA SQL PARA OBTENER EL TOTAL DE EQUIPOS POR S.O
                            $consultar=mysqli_query($datos_base, "SELECT s.SIST_OP, i.ID_SO, count(*) as TOTAL from
							inventario i left join so s on i.ID_SO=s.ID_SO left join area a on i.ID_AREA=a.ID_AREA left join reparticion r on a.ID_REPA=r.ID_REPA where a.ID_REPA=$reparticion
                             group by s.SIST_OP");
                             //AGREGAMOS LOS VALORES DE LA TABLA SQL A LAS FILAS DE LA TABLA HTML
                            while($listar = mysqli_fetch_array($consultar))
                                {

                                            echo"
                                            <tr style='border-bottom: solid 1px #073256;'>
                                                <td>
                                                    <h4 style='text-align: left;	'>".$listar['SIST_OP']."</h4>
                                                </td>
                                                <td>
                                                    <h4 style='text-align: center;	'>".$listar['TOTAL']."</h4>
                                                </td>
                                                <td class='text-center text-nowrap' id='accion'><a class='btn btn-sm btn-outline-primary'
                                    href=reportesoequipo.php?SO=".$listar['ID_SO']."&Repa=$reparticion class=mod><svg
                                        xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor'
                                        margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
                                        <path
                                            d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z' />
                                        <path
                                            d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z' />
                                    </svg></a></td>
                                            </tr> ";}

                                            }

		    if ($opc=='MICRO') {
			//SE GENERA LA CABECERA DE LA TABLA DE EQUIPOS POR MICRO  Y SE MUESTRA EL TOTAL DE EQUIPOS Y POR TIPO 
			echo "
				<h1 id='titulo'>REPORTE DE EQUIPOS POR MICROPROCESADOR</h1>
				<hr style='display: block;'>
				<h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>
                                            REPARTICION: ".$nomrepa."</h4>
                <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE PC DE ESCRITORIO: ".$totalPC['TOTAL']."</h4>
                <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>NRO. DE NOTEBOOKS: ".$totalNB['TOTAL']."</h4>
				<h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>
				TOTAL EQUIPOS: ".$total['TOTAL']."</h4>
				<h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL:
					".$fecha."</h4>
				<table id='tablareporte' width=97%>
					<thead style='border-bottom: solid 5px #073256 !important;'>
						<tr >
						<th class='cabecera'>
						<p>ESTADO</p>
						</th>
						<th class='cabecera'>
							<p>TOTAL</p>
						</th>
						<th id='cabeceraacc' class='cabecera' width=65px>
							<p>ACCIÓN</p>
						</th>
						</tr>
					</thead>";
                    //CONSULTA SQL PARA OBTENER EL TOTAL DE EQUIPOS POR MICRO
			$consultar=mysqli_query($datos_base, "SELECT mi.ID_MICRO, mi.MICRO, count(*) as TOTAL
            from inventario i 
           left join area a on i.ID_AREA=a.ID_AREA left join reparticion r on
           a.ID_REPA=r.ID_REPA 
           LEFT JOIN microws AS mw ON mw.ID_WS = i.ID_WS
   LEFT JOIN micro AS mi ON mi.ID_MICRO = mw.ID_MICRO
            where a.ID_REPA=$reparticion
			group by mi.MICRO ORDER BY TOTAL DESC");
            //AGREGAMOS LOS VALORES DE LA TABLA SQL A LAS FILAS DE LA TABLA HTML
			while($listar = mysqli_fetch_array($consultar))
				{
			
					echo"
					<tr style='border-bottom: solid 1px #073256;'>
						<td>
							<h4 style='text-align: left;	'>".$listar['MICRO']."</h4>
						</td>
						<td>
						    <h4 style='text-align: center;	'>".$listar['TOTAL']."</h4>
						</td>
						<td class='text-center text-nowrap' id='accion'><a class='btn btn-sm btn-outline-primary'
                                        href='reportemicroequipo.php?Micro=".$listar['ID_MICRO']."&Repa=$reparticion' class=mod><svg
                                            xmlns='http://www.w3.org/2000/svg' width='20' height='20'
                                            fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
                                            <path
                                                d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z' />
                                            <path
                                                d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z' />
                                        </svg></a></td>
					</tr> ";}
			
													}
                                                }										
                                            ?>
    </section>
</body>

</html>


<?php
// if ($reparticion==2 & $opc=='AREA') {
                            // $conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL, r.REPA from inventario i
                            // left join area a on i.ID_AREA=a.ID_AREA left join reparticion r on a.ID_REPA=r.ID_REPA where
                            // a.ID_REPA=$reparticion");
                            // $total = mysqli_fetch_array($conttotal);
                            // $fecha = date("Y-m-d");
                            // $nomrepa=$total['REPA'];
                            // echo "
                            // <h1 id='titulo'>REPORTE DE EQUIPOS POR AREA</h1>
                            
                            // <hr style='display: block;'>
                            // <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>
                            //     REPARTICION: TODAS</h4>
                            // <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>
                            //     REPARTICION: ".$nomrepa."</h4>
                            // <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL
                            //     EQUIPOS: ".$total['TOTAL']."</h4>
                            // <h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL:
                            //     ".$fecha."</h4>
                            // <table id='tablareporte' class='table table-striped table-hover' width=97%>
                            //     <thead>
                            //         <tr >
                            //             <th class='cabecera'>
                            //                 <p>AREA</p>
                            //             </th>
                            //             <th class='cabecera'>
                            //                 <p>TOTAL</p>
                            //             </th>
                            //             <th class='cabecera'>
                            //                 <p>REPARTICION</p>
                            //             </th>
                            //             <th id='cabeceraacc' class='cabecera' width=65px>
                            //                 <p>ACCIÓN</p>
                            //             </th>
                            //             </tr>
                            //         </thead>";
                            //     $consultar=mysqli_query($datos_base, "SELECT a.AREA, i.ID_AREA, a.ID_REPA, r.REPA,
                            //     count(*) as TOTAL from inventario i left join area a on i.ID_AREA=a.ID_AREA left join
                            //     reparticion r on a.ID_REPA=r.ID_REPA where a.ID_REPA=$reparticion
                            //     group by a.AREA");
                            //     while($listar = mysqli_fetch_array($consultar))
                            //     {

                            //     echo
                            //     "
                            //     <tr>
                            //         <td>
                            //             <h4 style='text-align: left;	'>".$listar['AREA']."</h4>
                            //         </td>
                            //         <td>
                            //             <h4 style='text-align: center;	'>".$listar['TOTAL']."</h4>
                            //         </td>
                            //         <td>
                            //             <h4 style='text-align: center;	'>".$listar['REPA']."</h4>
                            //         </td>
                            //         <td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary'
                            //                 href=reporteareaequipo.php?Area=".$listar['ID_AREA']." class=mod><svg
                            //                     xmlns='http://www.w3.org/2000/svg' width='20' height='20'
                            //                     fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
                                                
                            //                     <path
                            //                         d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z' />
                                                
                            //                     <path
                            //                         d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z' />
                                                
                            //                 </svg></a></td>
                            //         </tr>
                            //     ";
                            //     }



                            //     }

                            //     if ($reparticion==3 & $opc=='AREA') {
                            //     $conttotal=mysqli_query($datos_base, "SELECT COUNT(*) as TOTAL, r.REPA from
                            //     inventario i left join area a on i.ID_AREA=a.ID_AREA left join reparticion r on
                            //     a.ID_REPA=r.ID_REPA where a.ID_REPA=$reparticion");
                            //     $total = mysqli_fetch_array($conttotal);
                            //     $fecha = date("Y-m-d");
                            //     $nomrepa=$total['REPA'];
                            //     echo "
                            //     <h1 id='titulo'>REPORTE DE EQUIPOS POR AREA</h1>
                                
                            //     <hr style='display: block;'>
                            //     <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>
                            //         REPARTICION: ".$nomrepa."</h4>
                            //     <h4 id='ind' class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>TOTAL
                            //         EQUIPOS: ".$total['TOTAL']."</h4>
                            //     <h4 class='indicadores' style='margin-top: 20px; margin-bottom: 20px;'>FECHA ACTUAL:
                            //         ".$fecha."</h4>
                            //     <table id='tablareporte' class='table table-striped table-hover' width=97%>
                            //         <thead>
                            //             <tr >
                            //                 <th class='cabecera'>
                            //                     <p>AREA</p>
                            //                 </th>
                            //                 <th class='cabecera'>
                            //                     <p>TOTAL</p>
                            //                 </th>
                            //                 <th class='cabecera'>
                            //                     <p>REPARTICION</p>
                            //                 </th>
                            //                 <th id='cabeceraacc' class='cabecera' width=65px>
                            //                     <p>ACCIÓN</p>
                            //                 </th>
                            //                 </tr>
                            //             </thead>";
                            //         $consultar=mysqli_query($datos_base, "SELECT a.AREA, i.ID_AREA, a.ID_REPA,
                            //         r.REPA, count(*) as TOTAL from inventario i left join area a on i.ID_AREA=a.ID_AREA
                            //         left join reparticion r on a.ID_REPA=r.ID_REPA where a.ID_REPA=$reparticion
                            //         group by a.AREA");
                            //         while($listar = mysqli_fetch_array($consultar))
                            //         {

                            //         echo
                            //         "
                            //         <tr>
                            //             <td>
                            //                 <h4 style='text-align: left;	'>".$listar['AREA']."</h4>
                            //             </td>
                            //             <td>
                            //                 <h4 style='text-align: center;	'>".$listar['TOTAL']."</h4>
                            //             </td>
                            //             <td>
                            //                 <h4 style='text-align: center;	'>".$listar['REPA']."</h4>
                            //             </td>
                            //             <td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary'
                            //                     href=reporteareaequipo.php?Area=".$listar['ID_AREA']." class=mod><svg
                            //                         xmlns='http://www.w3.org/2000/svg' width='20' height='20'
                            //                         fill='currentcolor' margin='5' class='bi bi-eye'
                            //                         viewBox='0 0 16 16'>
                                                    
                            //                         <path
                            //                             d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z' />
                                                    
                            //                         <path
                            //                             d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z' />
                                                    
                            //                     </svg></a></td>
                            //             </tr>
                            //         ";}

                            //         }?>
