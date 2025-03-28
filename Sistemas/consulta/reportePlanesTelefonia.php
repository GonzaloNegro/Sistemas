<?php 
session_start();
error_reporting(0);
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
	<title>REPORTE PLANES TELEFÓNICOS</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<header id="head" style="display:none;" class="p-3 mb-3 border-bottom altura">
<div class="print-header">
    <img style="width: 150px; height: 50px;" src="../imagenes/logoInfraestructura.png" class="img-fluid">
    <img style="width: 200px; height: 50px;" src="../imagenes/cba-logo.png" class="img-fluid">
</div>					
  </header>
<div id="reporteEst">
    <div class="form-group row justify-content-between" style="margin: 10px; padding:10px;">
        <a id="vlv"  href="./montosLineas.php" type="button" class="btn btn-info" value="VOLVER"><i class="fa-solid fa-arrow-left" style="color:white;"></i></a>
    </div>
</div>
<?php
    if (!isset($_POST['mes'])){$_POST['mes'] = '';}
    if (!isset($_POST['año'])){$_POST['año'] = '';}
?>
<section id="consulta">
		<div id="titulo" style="display: flex; flex-direction: column; gap: 2px;">
			<h1 class="subtitulo">REPORTE DE GASTOS DE TELEFONÍA MÓVIL</h1>
            <h1 class="subtitulo" style="margin-top:5px !important;">DETALLE POR PLANES</h1>
            <!-- <h1 class="sbtRep">REPORTE DE GASTOS DE TELEFONÍA MÓVIL  DETALLE POR PLANES</h1> -->
            <h1 class="sbtRep" style="padding:2px;">REPORTE DE GASTOS DE TELEFONÍA MÓVIL</h1>
            <h1 style="padding:2px;" class="sbtRep" id="subtitulo" >DETALLE POR PLANES</h1>
		</div>
        <form method="POST" id="form_filtro" action="./reportePlanesTelefonia.php" class="contFilter--name">
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">AÑO</label>
                        <!-- <input type="text" style="text-transform:uppercase;" name="buscar"  placeholder="2024" class="form-control largo"> -->
                        <select id="año" name="año" class="form-control largo">
                            <option value="">-SELECCIONAR-</option>
                        </select>
                        <script>
                            // Obtener el año actual
                            const currentYear = new Date().getFullYear();
                            const startYear = 2020; // Año inicial

                            // Referencia al select
                            const yearSelect = document.getElementById('año');

                            // Generar opciones dinámicamente
                            for (let year = currentYear; year >= startYear; year--) {
                                const option = document.createElement('option');
                                option.value = year;
                                option.textContent = year;
                                // Seleccionar el año actual por defecto
                                if (year === currentYear) {
                                    option.selected = true;
                                }
                                yearSelect.appendChild(option);
                            }
                        </script>
                    </div>
                    <div>
                        <label class="form-label">MES DE VENCIMIENTO:</label>
                        <select id="mes" name="mes" class="form-control largo">
                            <option value="">-SELECCIONAR-</option>
                            <option value="1">ENERO - CORRESPONDE A DICIEMBRE</option>
                            <option value="2" >FEBRERO - CORRESPONDE A ENERO</option>
                            <option value="3">MARZO - CORRESPONDE A FEBRERO</option>
                            <option value="4">ABRIL - CORRESPONDE A MARZO</option>
                            <option value="5">MAYO - CORRESPONDE A ABRIL</option>
                            <option value="6">JUNIO - CORRESPONDE A MAYO</option>
                            <option value="7">JULIO - CORRESPONDE A JUNIO</option>
                            <option value="8">AGOSTO - CORRESPONDE A JULIO</option>
                            <option value="9">SEPTIEMBRE - CORRESPONDE A AGOSTO</option>
                            <option value="10">OCTUBRE - CORRESPONDE A SEPTIEMBRE</option>
                            <option value="11">NOVIEMBRE - CORRESPONDE A OCTUBRE</option>
                            <option value="12">DICIEMBRE - CORRESPONDE A NOVIEMBRE</option>
                        </select>
                    </div>
                    <!-- <div>
                        <label class="form-label">Edificio</label>
                        <select id="edificio" name="edificio" class="form-control largo">
                            <option value="">TODOS</option>
                            <option value="1">HUMBERTO PRIMO 607</option>
                            <option value="2">HUMBERTO PRIMO 725</option>
                        </select>
                    </div> -->

                    <div style="display:flex;justify-content: flex-end;">
                        <input onClick="filtrar()" class="btn btn-success" name="busqueda" value="Buscar">
                    </div>
                    <!-- <div style="display:flex;justify-content: flex-end;">
                        <button id="botonright" type="button" class="btn btn-primary" onClick="imprimir()" ><i class='bi bi-printer'></i></button>
                    </div> -->
                    <style type="text/css" media="print">
                              
                    </style>
                    <script>
                        //Funcion para formatear los montos a separados por puntos y decimales con coma
                        $(document).ready(function () {
                            function formatNumber(num) {
                                return num
                                    .toString()
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".") // Agrega puntos como separadores de miles
                                    .replace(/\.(\d+)$/, ',$1'); // Cambia el último punto decimal por coma
                            }

                            $('.number').each(function () {
                                // Obtiene el texto y elimina el símbolo de moneda
                                let text = $(this).text().replace(/[^0-9.]/g, ''); // Elimina todo excepto números y puntos
                                let originalValue = parseFloat(text); // Convierte a número flotante

                                if (!isNaN(originalValue)) {
                                    // Formatea el número con dos decimales y vuelve a agregar el símbolo $
                                    $(this).text('$' + formatNumber(originalValue.toFixed(2)));
                                }
                            });
                        });
                    </script>

		            <script>
                           function imprimir() {
                            const totalPages = document.querySelectorAll('.prov').length;
                            document.documentElement.style.setProperty('--total-pages', totalPages);
                            // Ejecuta la función de impresión
            	             window.print();
                                      }
                    </script>
                </div>
                <div class="filtros-listadoParalelo">
                    
                    <div style="margin-top:60px;">
                        <button id="botonright" type="button" class="btn btn-primary" onClick="imprimir()" style="height:50px; width:50px;" ><i class='bi bi-printer'></i></button>
                    </div>
                </div>
            </div>
            </form>
                <?php 
                $mesFiltro=$_POST['mes'];
                $añoFiltro=$_POST['año'];
                if(isset($_POST['busqueda'])){
                    //Indicadores
                    if($_POST['mes'] != '' && $_POST['año'] != ''){
                    //Indicadores
                    //Obtengo monto total y cantidad de lineas
                    $sent= "SELECT COUNT(ID_MOVILINEA) AS CANTIDAD, SUM(m.MONTOTOTAL) AS totalGr
                    FROM movilinea m
                    INNER JOIN nombreplan n ON n.ID_NOMBREPLAN = m.ID_NOMBREPLAN
                    INNER JOIN plan p ON p.ID_PLAN = n.ID_PLAN
                    INNER JOIN proveedor pr on n.ID_PROVEEDOR=pr.ID_PROVEEDOR
                    WHERE MONTH(m.FECHA) = $mesFiltro and YEAR(m.FECHA) = $añoFiltro AND m.ID_MOVILINEA = (
                                  SELECT MAX(t.ID_MOVILINEA)
                                  FROM movilinea t
                                  WHERE m.id_linea = t.id_linea
                                  and MONTH(t.FECHA) =  $mesFiltro
                                  and YEAR(m.FECHA) = $añoFiltro
                              )";
                    $resultado = $datos_base->query($sent);
                    $row = $resultado->fetch_assoc();
                    $cantidad = $row['CANTIDAD'];
                    $montoTotal = $row['totalGr'];

                    //Obtengo monto de Personal
                    $sent= "SELECT COUNT(ID_MOVILINEA) AS CANTIDAD, SUM(m.MONTOTOTAL) AS totalGr
                    FROM movilinea m
                    INNER JOIN nombreplan n ON n.ID_NOMBREPLAN = m.ID_NOMBREPLAN
                    INNER JOIN plan p ON p.ID_PLAN = n.ID_PLAN
                    INNER JOIN proveedor pr on n.ID_PROVEEDOR=pr.ID_PROVEEDOR
                    WHERE MONTH(m.FECHA) = $mesFiltro and YEAR(m.FECHA) = $añoFiltro AND m.ID_MOVILINEA = (
                                  SELECT MAX(t.ID_MOVILINEA)
                                  FROM movilinea t
                                  WHERE m.id_linea = t.id_linea
                                  and MONTH(t.FECHA) =  $mesFiltro 
                                  and YEAR(m.FECHA) = $añoFiltro
                              )
                              and pr.ID_PROVEEDOR=34";
                    $resultadoP = $datos_base->query($sent);
                    $rowP = $resultadoP->fetch_assoc();
                    $montoPersonal = $rowP['totalGr'];
                    $nroLineasPersonal = $rowP['CANTIDAD'];

                    //Obtengo de Claro
                    $sent= "SELECT COUNT(ID_MOVILINEA) AS CANTIDAD, SUM(m.MONTOTOTAL) AS totalGr
                    FROM movilinea m
                    INNER JOIN nombreplan n ON n.ID_NOMBREPLAN = m.ID_NOMBREPLAN
                    INNER JOIN plan p ON p.ID_PLAN = n.ID_PLAN
                    INNER JOIN proveedor pr on n.ID_PROVEEDOR=pr.ID_PROVEEDOR
                    WHERE MONTH(m.FECHA) = $mesFiltro  and YEAR(m.FECHA) = $añoFiltro AND m.ID_MOVILINEA = (
                                  SELECT MAX(t.ID_MOVILINEA)
                                  FROM movilinea t
                                  WHERE m.id_linea = t.id_linea
                                  and MONTH(t.FECHA) =  $mesFiltro
                                  and YEAR(m.FECHA) = $añoFiltro
                              )
                              and pr.ID_PROVEEDOR=35";
                    $resultadoC = $datos_base->query($sent);
                    $rowC = $resultadoC->fetch_assoc();
                    $montoClaro = $rowC['totalGr'];
                    $nroLineasClaro = $rowC['CANTIDAD'];
                    //////////////////////////////////////////////////////

                    //Planes por Proveedor

                    //Personal
                    $queryy="SELECT COUNT(ID_MOVILINEA) AS CANTIDAD, n.NOMBREPLAN AS nomPlanGr, p.PLAN AS planGr, SUM(m.MONTOTOTAL) AS totalGr, m.MONTOTOTAL as montoUni, pr.PROVEEDOR 
                    FROM movilinea m
                    INNER JOIN nombreplan n ON n.ID_NOMBREPLAN = m.ID_NOMBREPLAN
                    INNER JOIN plan p ON p.ID_PLAN = n.ID_PLAN
                    INNER JOIN proveedor pr on n.ID_PROVEEDOR=pr.ID_PROVEEDOR
                    WHERE MONTH(m.FECHA) = $mesFiltro  and YEAR(m.FECHA) = $añoFiltro AND m.ID_MOVILINEA = (
                                  SELECT MAX(t.ID_MOVILINEA)
                                  FROM movilinea t
                                  WHERE m.id_linea = t.id_linea
                                  and MONTH(t.FECHA) =  $mesFiltro
                                  and YEAR(m.FECHA) = $añoFiltro
                              ) 
                    and pr.ID_PROVEEDOR=34
                    GROUP BY n.NOMBREPLAN, n.ID_PLAN
                         ORDER BY montoUni ASC";
                    $sqliPer = $datos_base->query($queryy);
                    $num_rows_per= mysqli_num_rows($sqliPer);
                    }

                    //Claro
                    $queryy="SELECT COUNT(ID_MOVILINEA) AS CANTIDAD, n.NOMBREPLAN AS nomPlanGr, p.PLAN AS planGr, SUM(m.MONTOTOTAL) AS totalGr, m.MONTOTOTAL as montoUni, pr.PROVEEDOR 
                    FROM movilinea m
                    INNER JOIN nombreplan n ON n.ID_NOMBREPLAN = m.ID_NOMBREPLAN
                    INNER JOIN plan p ON p.ID_PLAN = n.ID_PLAN
                    INNER JOIN proveedor pr on n.ID_PROVEEDOR=pr.ID_PROVEEDOR
                    WHERE MONTH(m.FECHA) = $mesFiltro  and YEAR(m.FECHA) = $añoFiltro AND m.ID_MOVILINEA = (
                                  SELECT MAX(t.ID_MOVILINEA)
                                  FROM movilinea t
                                  WHERE m.id_linea = t.id_linea
                                  and MONTH(t.FECHA) =  $mesFiltro
                                  and YEAR(m.FECHA) = $añoFiltro
                              ) 
                    and pr.ID_PROVEEDOR=35
                    GROUP BY n.NOMBREPLAN, n.ID_PLAN
                         ORDER BY montoUni ASC";
                    $sqliCla = $datos_base->query($queryy);
                    $num_rows_per= mysqli_num_rows($sqliCla);
                    
                        
                }
                ?>
                <!-- Indicadores generales de lineas-->
                <div id="indicadores">
                    <?php 
                     
                        switch ($_POST['mes']) {
                            case '01': $mes = 'Enero';break;
                            case '02': $mes = 'Febrero';break;
                            case '03': $mes = 'Marzo';break;
                            case '04': $mes = 'Abril';break;
                            case '05': $mes = 'Mayo';break;
                            case '06': $mes = 'Junio';break;
                            case '07': $mes = 'Julio';break;
                            case '08': $mes = 'Agosto';break;
                            case '09': $mes = 'Septiembre';break;
                            case '10': $mes = 'Octubre';break;
                            case '11': $mes = 'Noviembre';break;
                            case '12': $mes = 'Diciembre';break;
                            default: $mes = 'Non'; break;
                          } ?>
                    <?php 
                    if (isset($_POST['busqueda'])) {
                        $fechaActual = date("d-m-Y");
                    echo"
                    <hr style='display: block; margin-top:60px;'>
                    <div><h4 id='periodo'  class='ind' style='margin-top: 2px; margin-bottom: 2px; font-size: 22px; font-weight: bold;'>FECHA DE CONSULTA: $fechaActual</h4></div>
                    <div><h4 id='periodo'  class='ind' style='margin-top: 2px; margin-bottom: 2px; font-size: 22px; font-weight: bold;'>PERIODO: $mes - 2024</h4></div>
                    <!--<div><div><h4 class='ind number' style='margin-top: 2px; margin-bottom: 2px;'>MONTO TOTAL: $$montoTotal</h4></div>
                    <div><h4 class='ind' style='margin-top: 2px; margin-bottom: 2px;'>CANTIDAD DE LÍNEAS TOTAL: $cantidad</h4></div>
                    <div><h4 class='ind number' style='margin-top: 2px; margin-bottom: 2px;'>SUBTOTAL PERSONAL: $$montoPersonal</h4></div>
                    <div><h4 class='ind' style='margin-top: 2px; margin-bottom: 2px;'>CANTIDAD DE LÍNEAS PERSONAL: $nroLineasPersonal</h4></div>
                    <div><h4 class='ind number' style='margin-top: 2px; margin-bottom: 2px;'>SUBTOTAL CLARO: $$montoClaro</h4></div>
                    <div><h4 class='ind' style='margin-top: 2px; margin-bottom: 2px;'>CANTIDAD DE LÍNEAS CLARO: $nroLineasClaro</h4></div></div>-->";
                    }

                    

                    ?>
                </div>
                <?php
                if (isset($_POST['busqueda'])) {

                    echo'
                    <div class="table-responsive">
                    <table id="tablaReporte">
                        <thead class="tdReporte">
                            <tr>
                            <th scope="col"></th>
                            <th scope="col" style="text-align: center;">Costo</th>
                            <th scope="col" style="text-align: center;">Cantidad de Lineas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="trReporte">
                            <th scope="row">Total</th>
                            <td class="number" style="text-align: center; font-weight: bold !important;">$'.$montoTotal.'</td>
                            <td style="text-align: center; font-weight: bold !important;">'.$cantidad.'</td>
                            </tr>
                            <tr>
                            <th scope="row">Subtotal Claro</th>
                            <td class="number" style="text-align: center;">$'.$montoClaro.'</td>
                            <td style="text-align: center;">'.$nroLineasClaro.'</td>
                            </tr>
                            <tr>
                            <th scope="row">Subtotal Personal</th>
                            <td class="number" style="text-align: center;">$'.$montoPersonal.'</td>
                            <td colspan="2" style="text-align: center;">'.$nroLineasPersonal.'</td>
                            </tr>
                        </tbody>
                        </table>
                </div>';

                    //Indicadores de Claro
                echo"<div id='claro'>
                <hr id='hrclaro' style='display: block; margin-top:20px;'>
                <h4 class='ind prov' style='margin-top: 2px; margin-bottom: 2px; font-size: 25px;font-weight: bold; text-decoration: underline;'>CLARO</h4>
                
                    
                    <div class='row' style='width:100%;display:flex;flex-direction:row;gap:15px;justify-content: space-between;'>
                    <div class='col plan'><p style='font-size:22px;text-align:left;text-decoration:underline;'>PLAN</p></div>
                    <div class='col'><p style='font-size:22px;text-decoration:underline;'>CANTIDAD DE LINEAS</p></div>
                    <div class='col'><p style='font-size:22px;text-decoration:underline;'>MONTO UNITARIO CON DESCUENTO</p></div>
                    <div class='col'><p style='font-size:22px;text-decoration:underline;'>MONTO FINAl</p></div>
                    </div>";
                    
                        while($rowSqli = $sqliCla->fetch_assoc()) {
                        
                            echo "
                             <div class='row' style='width:100%;display:flex;flex-direction:row;gap:10px;justify-content: space-between;'>
                             <div class='col '><p style='font-size:18px;text-align:left;'>".$rowSqli['nomPlanGr']." - ".$rowSqli['planGr'].": </p></div>
                             <div class='col'><p style='color:green;font-weight:bold;'>".$rowSqli['CANTIDAD']."</p></div>
                             <div class='col'><p class='number' style='color:green;font-weight:bold;'>$".$rowSqli['montoUni']."</p></div>
                             <div class='col'><p class='number' style='color:green;font-weight:bold;'>$".$rowSqli['totalGr']."</p></div>
                             
                             </div>";}
                             echo "
                             <div class='row' style='width:100%;display:flex;flex-direction:row;gap:10px;justify-content: space-between;'>
                             <div class='col '><p style='font-size:18px;text-align:left;'></p></div>
                             <div class='col'><p style='color:green;font-weight:bold;'></p></div>
                             <div class='col'><p id='subtotal' class='number' style='font-weight:bold;'>SUBTOTAL CLARO:</p></div>
                             <div class='col'><p id='subtotal' class='number'style='color:green;font-weight:bold;'>$$montoClaro</p></div>
                             </div>
                             </div>";

                            echo'<div class="footer row justify-content-center">
                            <div class="row" style="width: 1141px;">
                                <div class="col" style="margin-left: 174px;"></div>
                                <div class="col"></div>
                                <div class="col">
                                    <p style="text-align: right; color: gray;" class="pageFooter"></p>
                                </div>
                            </div>
                        </div>';
                //Indicadores de Personal
                echo"<div id='personal'  class='page-break'>
                    <hr style='display: block; margin-top:20px;'>
                    <h4 class='ind prov' style='margin-top: 2px; margin-bottom: 2px; font-size: 25px; font-weight: bold; text-decoration: underline;'>PERSONAL</h4>
                    
                        
                        <div class='row' style='width:100%;display:flex;flex-direction:row;gap:15px;justify-content: space-between;'>
                        <div class='col'><p style='font-size:22px;text-align:left;text-decoration:underline;'>PLAN</p></div>
                        <div class='col'><p style='font-size:22px;text-decoration:underline;'>CANTIDAD DE LINEAS</p></div>
                        <div class='col'><p style='font-size:22px;text-decoration:underline;'>MONTO UNITARIO CON DESCUENTO</p></div>
                        <div class='col'><p style='font-size:22px;text-decoration:underline;'>MONTO FINAl</p></div>
                        </div>";
                        
                            while($rowSqli = $sqliPer->fetch_assoc()) {
                            
                                echo "
                                 <div class='row' style='width:100%;display:flex;flex-direction:row;gap:10px;justify-content: space-between;'>
                                 <div class='col'><p style='font-size:18px;text-align:left;'>".$rowSqli['nomPlanGr']." - ".$rowSqli['planGr'].": </p></div>
                                 <div class='col'><p style='color:green;font-weight:bold;'>".$rowSqli['CANTIDAD']."</p></div>
                                 <div class='col'><p style='color:green;font-weight:bold;' class='number'>$".$rowSqli['montoUni']."</p></div>
                                 <div class='col'><p style='color:green;font-weight:bold;' class='number'>$".$rowSqli['totalGr']."</p></div>
                                 
                                 </div>";} 
                                 echo "
                                 <div class='row' style='width:100%;display:flex;flex-direction:row;gap:10px;justify-content: space-between;'>
                                 <div class='col'><p style='font-size:18px;text-align:left;'></p></div>
                                 <div class='col'><p style='color:green;font-weight:bold;'></p></div>
                                 <div class='col'><p class='number' id='subtotal' style='font-weight:bold;'>SUBTOTAL PERSONAL:</p></div>
                                 <div class='col'><p class='number' id='subtotal' style='color:green;font-weight:bold;'>$$montoPersonal</p></div>
                                 </div>
                                 </div>";
                        
                    //Monto Total
                                 echo "
                                 <hr style='display: block; margin-top:20px;'>
                                 <div id='totalPlanes' class='row' style='width:100%;display:flex;flex-direction:row;gap:10px;justify-content: space-between; margin-top:50px; height: 50px;'>
                                    <div class='col'><p style='font-size:18px;text-align:left;'></p></div>
                                    <div class='col'><p style='color:green;font-weight:bold;'></p></div>
                                    <div class='col'><h4 id='total' class='number' style='font-weight:bold;font-size:22px;color: #00519C;'>TOTAL FINAL DEL GASTO:</h4></div>
                                    <div class='col'><h4 id='total' class='number' style='color:green;font-weight:bold; font-size:22px;'>$$montoTotal</h4></div>
                                 </div>
                                 </div>";
                                 echo'<div class="footer row justify-content-center">
                            <div class="row" style="width: 1141px;">
                                <div class="col" style="margin-left: 174px;"></div>
                                <div class="col"></div>
                                <div class="col">
                                    <p style="text-align: right; color: gray;" class="pageFooter"></p>
                                </div>
                            </div>
                        </div>';
                                }?>


    <script>
        function filtrar(){
            var mes= $("#mes").val();

            if(mes==null || mes==""){
                Swal.fire({
                        title: "Por favor seleccione el mes a visualizar",
                        icon: "warning",
                        showConfirmButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                        customClass:{
                            actions: 'reverse-button'
                        }
                    })
                // alert("Seleccione un mes a visualizar");
                // $("#mes").focus()
            }
            else{
                $("#form_filtro").submit();
            }
        }
    </script>
   <!-- <footer>
        <span id="footer-text" class="print-footer"></span>
    </footer> -->
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>