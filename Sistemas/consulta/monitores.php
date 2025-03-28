<?php 
session_start();
include('../particular/conexion.php');
if(!isset($_SESSION['cuil'])) 
    {       
        header('Location: ../particular/Inicio.php'); 
        exit();
    };
$iduser = $_SESSION['cuil'];
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>INVENTARIO MONITORES</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymus"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css"><script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
    <!--BUSCADOR SELECT-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<!--FIN BUSCADOR SELECT-->
	<!--Estilo bootstrap para select2-->
	<link rel="stylesheet" href="/path/to/select2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
	<style>
        body{
        background-color: #edf0f5;
        }
	</style>
</head>
<body>
<?php
    if (!isset($_POST['buscar'])){$_POST['buscar'] = '';}
    if (!isset($_POST['area'])){$_POST['area'] = '';}
    if (!isset($_POST["tipo"])){$_POST["tipo"] = '';}
    if (!isset($_POST["orden"])){$_POST["orden"] = '';}
    if (!isset($_POST['marca'])){$_POST['marca'] = '';}
    if (!isset($_POST["estado"])){$_POST["estado"] = '';}
    if (!isset($_POST["reparticion"])){$_POST["reparticion"] = '';}
?>
<?php include('../layout/inventario.php'); ?>
<section id="consulta">
		<div id="titulo">
            <h1>INVENTARIO MONITORES</h1>
		</div>
        <form method="POST" action="./monitores.php" class="contFilter--name">
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">Usuario/Monitor</label>
                        <input type="text" style="text-transform:uppercase;" name="buscar"  placeholder="Buscar" class="form-control largo">
                    </div>
                    <div>
                        <label class="form-label">Repartición</label>
                        <select id="subject-filter" id="reparticion" name="reparticion" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM reparticion ORDER BY REPA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_REPA']?>"><?php echo $opciones['REPA']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Área</label>
                        <select id="buscador_area" name="area" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT a.ID_AREA, a.AREA, r.REPA FROM area a inner join reparticion r on a.ID_REPA=r.ID_REPA ORDER BY AREA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_AREA']?>"><?php echo $opciones['AREA']?> - <?php echo $opciones['REPA']?></option>
                                <?php endforeach ?>
                        </select>
                        <!--BUSCADOR-->
						<!--Agregar {theme: 'bootstrap4',} dentro de select-->
						<script>
							$('#buscador_area').select2({theme: 'bootstrap4',});
						</script>
                        <!--BUSCADOR-->
                        <script>
							$(document).ready(function(){
								$('#buscador_area').change(function(){
									buscador='b='+$('#buscador_area').val();
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
                    </div>
                    <div>
                        <label class="form-label">Orden</label>
                        <select id="assigned-tutor-filter" id="orden" name="orden" class="form-control largo">
                            <?php if ($_POST["orden"] != ''){ ?>
                                <option value="<?php echo $_POST["orden"]; ?>">
                                    <?php 
                            if ($_POST["orden"] == '1'){echo 'ORDENAR POR USUARIO';} 
                            if ($_POST["orden"] == '2'){echo 'ORDENAR POR AREA';} 
                            if ($_POST["orden"] == '3'){echo 'ORDENAR POR TIPO';}
                            if ($_POST["orden"] == '4'){echo 'ORDENAR POR MARCA';}
                            if ($_POST["orden"] == '5'){echo 'ORDENAR POR ESTADO';}
                            ?>
                            </option>
                            <?php } ?>
                            <option value="">SIN ORDEN</option>
                            <option value="1">ORDENAR POR USUARIO</option>
                            <option value="2">ORDENAR POR AREA</option>
                            <option value="3">ORDENAR POR TIPO</option>
                            <option value="4">ORDENAR POR MARCA</option>
                            <option value="5">ORDENAR POR ESTADO</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Tipo</label>
                        <select id="subject-filter" id="tipo" name="tipo" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM tipop WHERE ID_TIPOP = 7 OR ID_TIPOP = 8 ORDER BY TIPO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_TIPOP']?>"><?php echo $opciones['TIPO']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Marca</label>
                        <select id="subject-filter" id="marca" name="marca" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM marcas ORDER BY MARCA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_MARCA']?>"><?php echo $opciones['MARCA']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Estado</label>
                        <select id="subject-filter" id="estado" name="estado" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM estado_ws ORDER BY ESTADO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_ESTADOWS']?>"><?php echo $opciones['ESTADO']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div class="export" style="display:flex;justify-content: flex-end;">
                        <input type="submit" class="btn btn-success" name="busqueda" value="Buscar">
                    </div>
                </div>
                    
                <div class="filtros-listadoParalelo" style="margin-right:20px; margin-top:-60px;">
                        <div style="display:flex;justify-content: flex-end;">Exportar a:<button type="submit" form="formu" style="border:none; background-color:transparent;"><i class="fa-solid fa-file-excel fa-2x" style="color: #1f5120;"></i>&nbspCSV</button></div>
                </div>
            </div>
        <?php 

        if ($_POST['buscar'] == ''){ $_POST['buscar'] = ' ';}
        $aKeyword = explode(" ", $_POST['buscar']);

        if ($_POST["buscar"] == '' AND $_POST['ID_TIPOP'] == '' AND $_POST['ID_REPA'] == '' AND $_POST['ID_AREA'] == '' AND $_POST['ID_MARCA'] == '' AND $_POST['ID_ESTADOWS'] == ''){ 
                $query ="SELECT p.ID_PERI, u.NOMBRE, mo.MODELO, t.TIPO, m.MARCA, a.AREA, e.ESTADO, r.REPA			
                FROM periferico p
                LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
                LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO
                LEFT JOIN area AS a ON  a.ID_AREA = p.ID_AREA
                INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP
                LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = p.ID_ESTADOWS
                INNER JOIN reparticion r on a.ID_REPA=r.ID_REPA  
                INNER JOIN marcas AS m ON m.ID_MARCA = mo.ID_MARCA ";
        }elseif(isset($_POST['busqueda'])){
                $query = "SELECT p.ID_PERI, u.NOMBRE, mo.MODELO, t.TIPO, m.MARCA, a.AREA, e.ESTADO, r.REPA			
                FROM periferico p
                LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
                LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO
                LEFT JOIN area AS a ON  a.ID_AREA = p.ID_AREA
                INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP
                LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = p.ID_ESTADOWS
                INNER JOIN reparticion r on a.ID_REPA=r.ID_REPA  
                INNER JOIN marcas AS m ON m.ID_MARCA = mo.ID_MARCA ";

                if ($_POST["buscar"] != '' ){ 
                        $query .= " WHERE p.TIPOP = 'MONITOR' AND (u.NOMBRE LIKE LOWER('%".$aKeyword[0]."%') OR mo.MODELO LIKE LOWER('%".$aKeyword[0]."%')) ";
                
                    for($i = 1; $i < count($aKeyword); $i++) {
                    if(!empty($aKeyword[$i])) {
                        $query .= " OR u.NOMBRE LIKE '%" . $aKeyword[$i] . "%' OR mo.MODELO LIKE '%" . $aKeyword[$i] . "%' ";
                    }
                    }

                }
        
        if ($_POST["reparticion"] != '' ){
            $query .= " AND r.ID_REPA = '".$_POST["reparticion"]."' ";
        }    
        if ($_POST["marca"] != '' ){
            $query .= " AND p.ID_MARCA = '".$_POST["marca"]."' ";
        }
        if ($_POST["area"] != '' ){
            $query .= " AND a.ID_AREA = '".$_POST["area"]."' ";
        }
        if ($_POST["tipo"] != '' ){
            $query .= " AND t.ID_TIPOP = '".$_POST["tipo"]."' ";
        }
        if ($_POST["estado"] != '' ){
            $query .= " AND e.ID_ESTADOWS = '".$_POST["estado"]."' ";
        }


         if ($_POST["orden"] == '1' ){
                $query .= " ORDER BY u.NOMBRE ASC ";
         }

         if ($_POST["orden"] == '2' ){
                $query .= " ORDER BY a.AREA ASC ";
         }

         if ($_POST["orden"] == '3' ){
                $query .= "  ORDER BY t.TIPO ASC ";
         }
         if ($_POST["orden"] == '4' ){
                $query .= " ORDER BY m.MARCA ASC ";
        }
        if ($_POST["orden"] == '5' ){
            $query .= "  ORDER BY e.ESTADO ASC ";
        }

}else{
    $query ="SELECT p.ID_PERI, u.NOMBRE, mo.MODELO, t.TIPO, m.MARCA, a.AREA, e.ESTADO, r.REPA		
    FROM periferico p
    LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
    LEFT JOIN usuarios AS u ON u.ID_USUARIO = p.ID_USUARIO
    LEFT JOIN area AS a ON  a.ID_AREA = p.ID_AREA
    INNER JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP
    LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = p.ID_ESTADOWS
    INNER JOIN marcas AS m ON m.ID_MARCA = mo.ID_MARCA
    INNER JOIN reparticion r on a.ID_REPA=r.ID_REPA
    WHERE p.TIPOP = 'MONITOR'";
}

/*         $consulta=mysqli_query($datos_base, $query); */
         $sql = $datos_base->query($query);

         $numeroSql = mysqli_num_rows($sql);

        ?>
<!--         <div class="contResult">
            <p style="font-weight: bold; color:#53AAE0;"><i class="mdi mdi-file-document"></i> <?php echo $numeroSql; ?> Resultados encontrados</p>
        </div> -->
    </form>
    <?php 
        if($_POST["buscar"] == ' ' AND $_POST['marca'] == '' AND $_POST['reparticion'] == '' AND $_POST['area'] == '' AND $_POST['tipo'] == '' AND $_POST['estado'] == ''){;
        ?>
    <div class="principal-info">
            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE ID_TIPOP = 7 OR ID_TIPOP = 8";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $total = $row6['total'];
            ?>
            <div class="col-md-3">
                <div class="card-counter primary">
                    <div class="card-pri">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <span class="count-numbers"><?php echo $total;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Monitores Registrados</span>
                    </div>
                </div>
            </div>

            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE (ID_TIPOP = 7 OR ID_TIPOP = 8) AND ID_ESTADOWS = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $activo = $row6['total'];
            ?>
            <div class="col-md-3">
                <div class="card-counter success">
                    <div class="card-pri">
                        <i class="fa-sharp fa-solid fa-arrow-up"></i>
                        <span class="count-numbers"><?php echo $activo;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Monitores Activos</span>
                    </div>
                </div>
            </div>


            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE (ID_TIPOP = 7 OR ID_TIPOP = 8) AND ID_ESTADOWS = 2";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $inactivos = $row6['total'];
            ?>
            <div class="col-md-3">
                <div class="card-counter danger">
                    <div class="card-pri">
                        <i class="fa-sharp fa-solid fa-arrow-down"></i>
                        <span class="count-numbers"><?php echo $inactivos;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Monitores Inactivos</span>
                    </div>
                </div>
            </div>
        </div>
        <?php };?>

    <table class="table_id" style="width: 98%; margin: 0 auto;">
        <thead>
            <tr>
                <th><p style="text-align:left; margin-left: 5px;">MONITOR</p></th>
                <th><p style="text-align:left; margin-left: 5px;">USUARIO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">ÁREA</p></th>
                <th><p style="text-align:left; margin-left: 5px;">REPARTICIÓN</p></th>
                <th><p>TIPO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">MARCA</p></th>
                <th><p style="text-align:left;margin-left:5px;">ESTADO</p></th>
                <th><p>MAS DETALLES</p></th>
            </tr>
        </thead>

        <?php $cantidadTotal = 0;?>
        <?php While($rowSql = $sql->fetch_assoc()) {
            $cantidadTotal++;

            $estado = $rowSql['ESTADO']; // Este valor lo obtienes de tu lógica o de una variable
            $color = '';

            if ($estado === "EN USO") {
                $color = "green";  // Si el estado es "solucionado", el color será verde
            } elseif ($estado === "BAJA") {
                $color = "red";  // Si el estado es "anulado" o "suspendido", el color será rojo
            } elseif ($estado === "S/A - STOCK") {
                $color = "blue";  // Si el estado es "derivado" o "en proceso", el color será azul
            }
            echo "
                <tr>
                    <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['MODELO']."</h4></td>
                    <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['NOMBRE']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:14px; text-align: left; margin-left: 5px;'>".$rowSql['AREA']."</h4></td>
                    <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['REPA']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:14px; text-align: center;'>".$rowSql['TIPO']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['MARCA']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:14px; text-align: left;margin-left: 5px;color: ".$color."'>".$rowSql['ESTADO']."</h4></td>


                    <td class='text-center text-nowrap'>
                        <a class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalInfo' 
                            onclick='cargar_informacion(" . $rowSql['ID_PERI'] . ", \"Info\")' 
                            target='_blank' class='mod'>
                            Info
                        </a>
                        <a class='btn btn-success' data-bs-toggle='modal' data-bs-target='#modalMovi' 
                            onclick='cargar_informacion(" . $rowSql['ID_PERI'] . ", \"Movimientos\")' 
                            target='_blank' class='mod'>
                            Mov. Info
                        </a>
                    </td>
                </tr>
            ";
        }
        if($_POST['buscar'] != "" AND $_POST['buscar'] != " " OR $_POST['area'] != "" OR $_POST['reparticion'] != "" OR $_POST['tipo'] != "" OR $_POST['marca'] != "" OR $_POST['estado'] != ""){
            echo "
            <div class=filtrado>
            <h2>Filtrado por:</h2>
                <ul>";
                    if($_POST['buscar'] != "" AND $_POST['buscar'] != " "){
                        echo "<li><u>USUARIO/MONITOR</u>: ".$_POST['buscar']."</li>";
                    }
                    if($_POST['area'] != ""){
                        $sql = "SELECT AREA FROM area WHERE ID_AREA = $_POST[area]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $area = $row['AREA'];
                        echo "<li><u>ÁREA</u>: ".$area."</li>";
                    }
                    if($_POST['reparticion'] != ""){
                        $sql = "SELECT REPA FROM reparticion WHERE ID_REPA = $_POST[reparticion]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $repa = $row['REPA'];
                        echo "<li><u>REPARTICIÓN</u>: ".$repa."</li>";
                    }
                    if($_POST['tipo'] != ""){
                        $sql = "SELECT TIPO FROM tipop WHERE ID_TIPOP = $_POST[tipo]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $tipo = $row['TIPO'];
                        echo "<li><u>TIPO PERIFÉRICO</u>: ".$tipo."</li>";
                    }
                    if($_POST['marca'] != ""){
                        $sql = "SELECT MARCA FROM marcas WHERE ID_MARCA = $_POST[marca]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $marca = $row['MARCA'];
                        echo "<li><u>MARCA</u>: ".$marca."</li>";
                    }
                    if($_POST['estado'] != ""){
                        $sql = "SELECT ESTADO FROM estado_ws WHERE ID_ESTADOWS = $_POST[estado]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $estadows = $row['ESTADO'];
                        echo "<li><u>ESTADO</u>: ".$estadows."</li>";
                    }
                    echo"
                </ul>
                    <h2>Cantidad de registros: </h2>
                    <ul><li>$cantidadTotal</li></ul>
            </div>
            ";
                }
        echo '</table>';
        ?>
		</div>
        <form id="formu" action="../exportar/ExcelMonitores.php" method="POST">
            <input type="text" id="excel" name="sql" class="valorPeque" readonly="readonly" value="<?php echo $query;?>">
        </form>
	</section>
	<footer></footer>

    <!-- MODALES -->
    <div class="modal fade modal--usu" id="modalInfo" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">INFORMACIÓN</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="contenidoInfo" style="display:flex;flex-direction:column;gap:10px;">
                    </div>
                </div>
                <div id="resultado" class="resultado">
                </div>
                <div class="modal-footer" id="no-imprimir">
                    <button id="botonright" type="button" class="btn btn-success" onClick="imprimir()"><i class='bi bi-printer' style="color:white;"></i></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal--usu" id="modalMovi" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">MOVIMIENTOS</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="contenidoMovimiento" style="display:flex;flex-direction:column;gap:10px;">
                    </div>
                </div>
                <div id="resultado" class="resultado">
                </div>
                <div class="modal-footer" id="no-imprimir">
                    <button id="botonright" type="button" class="btn btn-success" onClick="imprimir2()" ><i class='bi bi-printer' style="color:white;"></i></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        function cargar_informacion(id_peri, tipoConsulta) {
            var parametros = {
                "idPeri": id_peri,
                "tipoConsulta": tipoConsulta // Nuevo parámetro para diferenciar la consulta
            };

            $.ajax({
                data: parametros,
                url: "./consultarDatosMonitor.php",
                type: "POST",
                beforeSend: function () {
                    if (tipoConsulta === 'Info') {
                        $("#contenidoInfo").html("Cargando información...");
                    } if (tipoConsulta === 'Movimientos') {
                        $("#contenidoMovimiento").html("Cargando información...");
                    }
                },
                success: function (mensaje) {
                    if (tipoConsulta === 'Info') {
                        $("#contenidoInfo").html(mensaje);
                    } if (tipoConsulta === 'Movimientos') {
                        $("#contenidoMovimiento").html(mensaje);
                    }
                }
            });
        }

    function imprimir() {
    // Guardar el estado original de los elementos
    var contenidoOriginal = document.body.innerHTML;
    
    // Obtener solo el contenido del primer modal
    var contenidoModal = document.getElementById('modalInfo').innerHTML;

    // Obtener los estilos de la página original
    var estilos = '';
    var head = document.head;
    for (var i = 0; i < head.children.length; i++) {
        var child = head.children[i];
        if (child.tagName.toLowerCase() === 'style' || child.tagName.toLowerCase() === 'link') {
            estilos += child.outerHTML;
        }
    }

    // Ocultar todo el contenido de la página
    document.body.style.visibility = 'hidden';

    // Crear una nueva ventana para la impresión
    var ventanaImpresion = window.open('', '', 'height=800,width=600');

    // Escribir el contenido del modal y los estilos en la ventana de impresión
    ventanaImpresion.document.write('<html><head><title>Imprimir Modal</title>' + estilos + '</head><body>');
    ventanaImpresion.document.write('<style>@media print { #no-imprimir { display: none !important; } }</style>');  // Aseguramos que se oculte el #no-imprimir
    ventanaImpresion.document.write('<div style="width:100%;">' + contenidoModal + '</div>');
    ventanaImpresion.document.write('</body></html>');

    // Esperar a que la ventana cargue antes de imprimir
    ventanaImpresion.document.close();
    ventanaImpresion.print();

    // Restaurar la visibilidad de la página original
    document.body.style.visibility = 'visible';
}

function imprimir2() {
    // Guardar el estado original de los elementos
    var contenidoOriginal = document.body.innerHTML;
    
    // Obtener solo el contenido del segundo modal o la parte que deseas imprimir
    var contenidoModal2 = document.getElementById('modalMovi').innerHTML;

    // Obtener los estilos de la página original
    var estilos = '';
    var head = document.head;
    for (var i = 0; i < head.children.length; i++) {
        var child = head.children[i];
        if (child.tagName.toLowerCase() === 'style' || child.tagName.toLowerCase() === 'link') {
            estilos += child.outerHTML;
        }
    }

    // Ocultar todo el contenido de la página
    document.body.style.visibility = 'hidden';

    // Crear una nueva ventana para la impresión
    var ventanaImpresion2 = window.open('', '', 'height=800,width=600');

    // Escribir el contenido del segundo modal y los estilos en la ventana de impresión
    ventanaImpresion2.document.write('<html><head><title>Imprimir Otro Modal</title>' + estilos + '</head><body>');
    ventanaImpresion2.document.write('<style>@media print { #no-imprimir { display: none !important; } }</style>');  // Aseguramos que se oculte el #no-imprimir
    ventanaImpresion2.document.write('<div style="width:100%;">' + contenidoModal2 + '</div>');
    ventanaImpresion2.document.write('</body></html>');

    // Esperar a que la ventana cargue antes de imprimir
    ventanaImpresion2.document.close();
    ventanaImpresion2.print();

    // Restaurar la visibilidad de la página original
    document.body.style.visibility = 'visible';
}



    </script>

    <style>
@media print {
    body * {
        visibility: hidden; /* Oculta todo el contenido de la página */
    }

    #no-imprimir {
        display: none;
    }

    .modal, .modal * {
        visibility: visible !important; /* Muestra solo los modales */
        color: black !important; /* Asegura que el texto sea negro */
        text-shadow: none !important; /* Elimina las sombras de texto */
        background: none !important; /* Elimina los fondos degradados */
        box-shadow: none !important; /* Elimina cualquier sombra */
    }

    .modal-backdrop {
        display: none !important; /* Oculta el fondo del modal */
    }

    .modal-body, .modal-header, .modal-footer {
        color: black !important; /* Texto negro */
        background: none !important; /* Fondo sin degradado */
        text-shadow: none !important; /* Elimina sombras de texto */
    }
}



    </style>

	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
  		AOS.init();
	</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
		const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
		const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
	</script>
	
</body>
</html>