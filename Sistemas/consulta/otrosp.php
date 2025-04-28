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
	<title>INVENTARIO OTROS PERIFÉRICOS</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymus"></script>
    <script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
    <script>
        //Limpiar campos de formulario
        function Limpiar(){
            window.location.href='../consulta/otrosp.php';
        }
    </script>
    <!-- Script para inicializar el Popover -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializa todos los popovers
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        });
    </script>
<?php
    if (!isset($_POST['buscar'])){$_POST['buscar'] = '';}
    if (!isset($_POST['area'])){$_POST['area'] = '';}
    if (!isset($_POST["orden"])){$_POST["orden"] = '';}
    if (!isset($_POST["marca"])){$_POST["marca"] = '';}
    if (!isset($_POST["tipo"])){$_POST["tipo"] = '';}
    if (!isset($_POST["estado"])){$_POST["estado"] = '';}
    if (!isset($_POST["reparticion"])){$_POST["reparticion"] = '';}
?>
<?php include('../layout/inventario.php'); ?>
 <section id="consulta">
		<div id="titulo">
			<h1>INVENTARIO OTROS PERIFÉRICOS</h1>
		</div>
        <div class="botonAgregar">
            <button class="btn btn-success" style="font-size: 20px;"><a href="../abm/agregarotrosperifericos.php" style="text-decoration:none !important;color:white;" target="_blank">Agregar Periférico</a></button>
        </div>
        <form method="POST" action="./otrosp.php" class="contFilter--name">
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">Usu/Mod/Serieg</label>
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
                        <select id="subject-filter" id="area" name="area" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT a.ID_AREA, a.AREA, r.REPA FROM area a inner join reparticion r on a.ID_REPA=r.ID_REPA ORDER BY AREA ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_AREA']?>"><?php echo $opciones['AREA']?> - <?php echo $opciones['REPA']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
  
                </div>
                <div class="filtros-listadoParalelo">
                    <div>
                        <label class="form-label">Orden</label>
                        <select id="assigned-tutor-filter" id="orden" name="orden" class="form-control largo">
                            <?php if ($_POST["orden"] != ''){ ?>
                                <option value="<?php echo $_POST["orden"]; ?>">
                                    <?php 
                            if ($_POST["orden"] == '1'){echo 'ORDENAR POR USUARIO';} 
                            if ($_POST["orden"] == '2'){echo 'ORDENAR POR AREA';} 
                            if ($_POST["orden"] == '3'){echo 'ORDENAR POR MARCA';}
                            if ($_POST["orden"] == '4'){echo 'ORDENAR POR TIPO';} 
                            if ($_POST["orden"] == '5'){echo 'ORDENAR POR ESTADO';}
                            ?>
                            </option>
                            <?php } ?>
                            <option value="">SIN ORDEN</option>
                            <option value="1">ORDENAR POR USUARIO</option>
                            <option value="2">ORDENAR POR AREA</option>
                            <option value="3">ORDENAR POR MARCA</option>
                            <option value="4">ORDENAR POR TIPO</option>
                            <option value="5">ORDENAR POR ESTADO</option>
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
                        <label class="form-label">Tipo</label>
                        <select id="subject-filter" id="tipo" name="tipo" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM tipop WHERE ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12 ORDER BY TIPO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_TIPOP']?>"><?php echo $opciones['TIPO']?></option>
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
                    <div style="display:flex;justify-content: flex-end;">
                        <input type="button" class="btn btn-danger" id="btnLimpiar" onclick="Limpiar()" value="Limpiar">
                        <input type="submit" class="btn btn-success" name="busqueda" value="Buscar">
                        <button type="submit" form="formu" style="border:none; background-color:transparent;"><i class="fa-solid fa-file-excel fa-2x" style="color: #1f5120;"></i>&nbspCSV</button>
                    </div>
                </div>
            </div>
        <?php 
            if ($_POST['buscar'] == '') { $_POST['buscar'] = ' '; }
            $aKeyword = explode(" ", $_POST['buscar']);

            if ($_POST["buscar"] == '' && $_POST['ID_MARCA'] == '' && $_POST['ID_AREA'] == '' && $_POST['ID_REPA'] == '' && $_POST['ID_TIPOP'] == '' && $_POST['ID_ESTADOWS'] == '') {
                // Consulta por defecto al cargar la pantalla
                $query = "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, p.TIPOP, e.ESTADO, r.REPA
                        FROM periferico p 
                        LEFT JOIN modelo mo ON mo.ID_MODELO = p.ID_MODELO
                        LEFT JOIN equipo_periferico ep ON p.ID_PERI = ep.ID_PERI
                        LEFT JOIN inventario i ON ep.ID_WS = i.ID_WS
                        LEFT JOIN wsusuario ws ON i.ID_WS = ws.ID_WS
                        LEFT JOIN usuarios u ON ws.ID_USUARIO = u.ID_USUARIO
                        LEFT JOIN area a ON a.ID_AREA = u.ID_AREA
                        LEFT JOIN marcas m ON m.ID_MARCA = p.ID_MARCA
                        LEFT JOIN estado_ws e ON e.ID_ESTADOWS = p.ID_ESTADOWS
                        LEFT JOIN tipop t ON t.ID_TIPOP = p.ID_TIPOP
                        LEFT JOIN reparticion r ON a.ID_REPA = r.ID_REPA
                        WHERE p.ID_TIPOP IN (5, 6, 9, 11, 12)";
            } elseif (isset($_POST['busqueda'])) {
                // Búsqueda avanzada
                $query = "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, p.TIPOP, e.ESTADO, r.REPA
                FROM periferico p 
                LEFT JOIN modelo mo ON mo.ID_MODELO = p.ID_MODELO
                LEFT JOIN equipo_periferico ep ON p.ID_PERI = ep.ID_PERI
                LEFT JOIN inventario i ON ep.ID_WS = i.ID_WS
                LEFT JOIN wsusuario ws ON i.ID_WS = ws.ID_WS
                LEFT JOIN usuarios u ON ws.ID_USUARIO = u.ID_USUARIO
                LEFT JOIN area a ON a.ID_AREA = u.ID_AREA
                LEFT JOIN marcas m ON m.ID_MARCA = p.ID_MARCA
                LEFT JOIN estado_ws e ON e.ID_ESTADOWS = p.ID_ESTADOWS
                LEFT JOIN tipop t ON t.ID_TIPOP = p.ID_TIPOP
                LEFT JOIN reparticion r ON a.ID_REPA = r.ID_REPA";

            $where = ["p.ID_TIPOP IN (5, 6, 9, 11, 12)"];

            // Filtro de búsqueda por texto
            if (!empty(trim($_POST['buscar']))) {
                $aKeyword = explode(" ", $_POST['buscar']);
                $searchParts = [];

                foreach ($aKeyword as $kw) {
                    $kw = $datos_base->real_escape_string(trim($kw));
                    if ($kw != '') {
                        $searchParts[] = "(u.NOMBRE LIKE LOWER('%$kw%') OR p.SERIEG LIKE LOWER('%$kw%') OR mo.MODELO LIKE LOWER('%$kw%'))";
                    }
                }

                if (!empty($searchParts)) {
                    $where[] = '(' . implode(' OR ', $searchParts) . ')';
                }
            }

            // Filtros por campo
            if (!empty($_POST["reparticion"])) {
                $where[] = "r.ID_REPA = '".intval($_POST["reparticion"])."'";
            }
            if (!empty($_POST["marca"])) {
                $where[] = "m.ID_MARCA = '".intval($_POST["marca"])."'";
            }
            if (!empty($_POST["area"])) {
                $where[] = "u.ID_AREA = '".intval($_POST["area"])."'";
            }
            if (!empty($_POST["tipo"])) {
                $where[] = "t.ID_TIPOP = '".intval($_POST["tipo"])."'";
            }
            if (!empty($_POST["estado"])) {
                $where[] = "e.ID_ESTADOWS = '".intval($_POST["estado"])."'";
            }

            // Concatenar todo
            if (!empty($where)) {
                $query .= ' WHERE ' . implode(' AND ', $where);
            }

            // Ordenamiento
            switch ($_POST["orden"] ?? '') {
                case '1': $query .= " ORDER BY u.NOMBRE ASC"; break;
                case '2': $query .= " ORDER BY a.AREA ASC"; break;
                case '3': $query .= " ORDER BY m.MARCA ASC"; break;
                case '4': $query .= " ORDER BY t.TIPO ASC"; break;
                case '5': $query .= " ORDER BY e.ESTADO ASC"; break;
            }
            } else {
                    // Fallback
                    $query = "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, p.TIPOP, e.ESTADO, r.REPA
                            FROM periferico p 
                            LEFT JOIN modelo mo ON mo.ID_MODELO = p.ID_MODELO
                            LEFT JOIN equipo_periferico ep ON p.ID_PERI = ep.ID_PERI
                            LEFT JOIN inventario i ON ep.ID_WS = i.ID_WS
                            LEFT JOIN wsusuario ws ON i.ID_WS = ws.ID_WS
                            LEFT JOIN usuarios u ON ws.ID_USUARIO = u.ID_USUARIO
                            LEFT JOIN area a ON a.ID_AREA = u.ID_AREA
                            LEFT JOIN marcas m ON m.ID_MARCA = p.ID_MARCA
                            LEFT JOIN estado_ws e ON e.ID_ESTADOWS = p.ID_ESTADOWS
                            LEFT JOIN tipop t ON t.ID_TIPOP = p.ID_TIPOP
                            LEFT JOIN reparticion r ON a.ID_REPA = r.ID_REPA
                            WHERE p.ID_TIPOP IN (5, 6, 9, 11, 12)
                            ORDER BY p.NOMBREP ASC";
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
        if($_POST["buscar"] == ' ' AND $_POST['marca'] == '' AND $_POST['area'] == '' AND $_POST['reparticion'] == '' AND $_POST['tipo'] == ''){;
        ?>
    <div class="principal-info">
            <?php 
                $sql6 = "SELECT COUNT(*) AS total 
                FROM periferico 
                WHERE ID_TIPOP IN (5, 6, 9, 11, 12)";

                $result6 = $datos_base->query($sql6);
                $total = $result6->fetch_assoc()['total'];
            ?>
<!--             <div class="col-md-3">
                <div class="card-counter primary">
                    <div class="card-pri">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <span class="count-numbers"><?php echo $total;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Periféricos Registrados</span>
                    </div>
                </div>
            </div> -->

            <?php 
                $sql6 = "SELECT COUNT(*) AS total 
                FROM periferico 
                WHERE ID_ESTADOWS = 1 
                AND ID_TIPOP IN (5, 6, 9, 11, 12)";
                $result6 = $datos_base->query($sql6);
                $activo = $result6->fetch_assoc()['total'];
            ?>
<!--             <div class="col-md-3">
                <div class="card-counter success">
                    <div class="card-pri">
                        <i class="fa-sharp fa-solid fa-arrow-up"></i>
                        <span class="count-numbers"><?php echo $activo;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Periféricos Activos</span>
                    </div>
                </div>
            </div> -->


            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE ID_ESTADOWS = 2 AND (ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12)";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $inactivos = $row6['total'];

                $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE ID_ESTADOWS = 3 AND (ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12)";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $stock = $row6['total'];
            ?>
<!--             <div class="col-md-3">
                <div class="card-counter danger">
                    <div class="card-pri">
                        <i class="fa-sharp fa-solid fa-arrow-down"></i>
                        <span class="count-numbers"><?php echo $inactivos." - ".$stock;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Periféricos Inactivos - S/A Stock</span>
                    </div>
                </div>
            </div> -->
            <p>Periféricos Registrados: <?php echo $total; ?></p>
            <p>Periféricos Activos: <?php echo $activo; ?></p>
            <p>Periféricos Inactivos: <?php echo $inactivos; ?></p>
            <p>Periféricos en Stock: <?php echo $stock; ?></p>
        </div>
        <?php };?>


    <table class="table_id" style="width: 98%; margin: 0 auto;">
        <thead>
            <tr>
                <th><p style="text-align:left; margin-left: 5px;">MODELO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">USUARIO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">ÁREA</p></th>
                <th><p style="text-align:left; margin-left: 5px;">REPARTICIÓN</p></th>
                <th><p style="text-align:left; margin-left: 5px;">SERIEG</p></th>
                <th><p style="text-align:left; margin-left: 5px;">TIPO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">MARCA</p></th>
                <th><p style="text-align:left; margin-left: 5px;">ESTADO</p></th>
                <th><p>MAS DETALLES</p></th>
            </tr>
        </thead>

        <?php $cantidadTotal = 0;?>
        <?php While($rowSql = $sql->fetch_assoc()) {
            $cantidadTotal++;
            
            $estado = $rowSql['ESTADO']; // Este valor lo obtienes de tu lógica o de una variable

            $color = 'blue';
            $flecha = "<i class='fa-solid fa-box-open' style='color:blue'></i>";
            if ($estado === 'EN USO') {
                $color = 'green';
                $flecha = "<i class='fa-solid fa-arrow-up' style='color:green'></i>";
            } elseif ($estado === 'BAJA') {
                $color = 'red';
                $flecha = "<i class='fa-solid fa-arrow-down' style='color:red'></i>";
            }

            if($rowSql['SERIEG'] === "" || $rowSql['SERIEG'] === "0"){
                $rowSql['SERIEG'] = "-";
            }
            $usuario = $rowSql['NOMBRE'];
            if($usuario==NULL){
                $usuario = "NO ASIGNADO";
            }                

            echo "
                <tr>
                    <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['MODELO']."</h4></td>
                    <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$usuario."</h4></td>
                    <td><h4 class='wrap2' style='font-size:14px; text-align: left; margin-left: 5px;'>".$rowSql['AREA']."</h4></td>
                    <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['REPA']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['SERIEG']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['TIPO']."</h4></td>
                    <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['MARCA']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:14px; text-align: left;margin-left:5px;color:".$color."'>$flecha ".$rowSql['ESTADO']."</h4></td>
                    
                    <td class='text-center text-nowrap'>
                        <span style='display: inline-flex; padding: 3px;'>
                            <a style='padding: 3px; cursor: pointer;'
                            data-bs-toggle='modal'
                            data-bs-target='#modalInfo'
                            onclick='cargar_informacion(" . $rowSql['ID_PERI'] . ")'
                            class='mod'>
                                <i class='fa-solid fa-circle-info fa-2xl'
                                style='color: #0d6efd'
                                data-bs-toggle='popover'
                                data-bs-trigger='hover focus'
                                data-bs-placement='top'></i>
                            </a>
                        </span>

                        <span style='display: inline-flex;padding:3px;'>
                            <a style='padding:3px;' 
                            href='../abm/modotros.php?no=" . $rowSql['ID_PERI'] . "' 
                            target='_blank' 
                            class='mod' 
                            data-bs-toggle='popover' 
                            data-bs-trigger='hover' 
                            data-bs-placement='top' 
                            data-bs-content='Editar'>
                            <i style='color: #198754' class='fa-solid fa-pen-to-square fa-2xl'></i>
                            </a>
                        </span>
                    </td>
                
                </tr>
            ";
        }
        if($_POST['buscar'] != "" AND $_POST['buscar'] != " " OR $_POST['area'] != "" OR $_POST['reparticion'] != "" OR $_POST['marca'] != "" OR $_POST['tipo'] != "" OR $_POST['estado'] != ""){
            echo "
            <div class=filtrado>
            <h2>Filtrado por:</h2>
                <ul>";
                    if($_POST['buscar'] != "" AND $_POST['buscar'] != " "){
                        echo "<li><u>USU/MOD/SERIEG</u>: ".$_POST['buscar']."</li>";
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
                    if($_POST['marca'] != ""){
                        $sql = "SELECT MARCA FROM marcas WHERE ID_MARCA = $_POST[marca]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $marca = $row['MARCA'];
                        echo "<li><u>MARCA</u>: ".$marca."</li>";
                    }
                    if($_POST['tipo'] != ""){
                        $sql = "SELECT TIPO FROM tipop WHERE ID_TIPOP = $_POST[tipo]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $tipo = $row['TIPO'];
                        echo "<li><u>TIPO</u>: ".$tipo."</li>";
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
        <form id="formu" action="../exportar/ExcelOtrosPeri.php" method="POST">
            <input type="text" id="excel" name="sql" class="valorPeque" readonly="readonly" value="<?php echo $query;?>">
        </form>
	</section>
	<footer></footer>
    <!-- MODALES -->
    <div class="modal fade modal--usu" id="modalInfo" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
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

    <script>
        function cargar_informacion(id_Peri) {
            //buscar ES EL ID DEL CASO//
            var parametros = {
                "idPeri": id_Peri
            };
            //LA VARIABLE BUSCAR UTILIZA EL ID CASO Y LA ENVIA AL SERVIDOR DE NOVEDADES///
            $.ajax({
                data: parametros,
                url: "./consultarDatosOtros.php",
                type: "POST",
                beforeSend: function() {
                    $("#contenidoInfo").html("Mensaje antes de Enviar");
                },
                success: function(mensaje) {
                    $("#contenidoInfo").html(mensaje);
                },
                error: function(xhr, status, error) {
                    console.error("ERROR: ", status, error);
                    $("#contenidoInfo").html("Hubo un error al cargar la info");
                }
            });
        };
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
    <script src="../js/script.js"></script>
</body>
</html>