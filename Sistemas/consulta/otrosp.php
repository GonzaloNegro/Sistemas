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
	<title>INVENTARIO EQUIPOS</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymus"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
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
        <form method="POST" action="./otrosp.php" class="contFilter--name">
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">Usuario/Modelo/Serieg</label>
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
                    <div class="export" style="display:flex;justify-content: flex-end;">
                        <input type="submit" class="btn btn-success" name="busqueda" value="Buscar">
                    </div>
                </div>
                <div class="filtros-listadoParalelo">
                    <div>
                        <button class="btn btn-success" style="font-size: 20px;"><a href="../abm/agregarotrosperifericos.php" style="text-decoration:none !important;color:white;" target="_blank">Agregar nuevo periférico</a></button>
                    </div>
                    <div class="export">
                        <div>Exportar a: <button type="submit" form="formu" style="border:none; background-color:transparent;"><i class="fa-solid fa-file-excel fa-2x" style="color: #1f5120;"></i>&nbspCSV</button></div>
                    </div>
                </div>
            </div>
        <?php 

        if ($_POST['buscar'] == ''){ $_POST['buscar'] = ' ';}
        $aKeyword = explode(" ", $_POST['buscar']);

        if ($_POST["buscar"] == '' AND $_POST['ID_MARCA'] == '' AND $_POST['ID_AREA'] == '' AND $_POST['ID_REPA'] == '' AND $_POST['ID_TIPOP'] == '' AND $_POST['ID_ESTADOWS'] == ''){ 
                $query ="SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, p.TIPOP, e.ESTADO, r.REPA			
                FROM periferico p 
                LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
                LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
                LEFT JOIN equipo_periferico ep ON p.ID_PERI=ep.ID_PERI
                LEFT JOIN inventario i ON ep.ID_WS=i.ID_WS
                LEFT JOIN wsusuario ws ON i.ID_WS=ws.ID_WS
                LEFT JOIN usuarios u ON ws.ID_USUARIO=u.ID_USUARIO
                LEFT JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
                LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = p.ID_ESTADOWS 
                LEFT JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP
                INNER JOIN reparticion r on a.ID_REPA=r.ID_REPA   ";
        }elseif(isset($_POST['busqueda'])){
                $query = "SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, p.TIPOP, e.ESTADO, r.REPA		
                FROM periferico p 
                LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
                LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA  
                LEFT JOIN equipo_periferico ep ON p.ID_PERI=ep.ID_PERI
                LEFT JOIN inventario i ON ep.ID_WS=i.ID_WS
                LEFT JOIN wsusuario ws ON i.ID_WS=ws.ID_WS
                LEFT JOIN usuarios u ON ws.ID_USUARIO=u.ID_USUARIO
                LEFT JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
                LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = p.ID_ESTADOWS 
                LEFT JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP
                INNER JOIN reparticion r on a.ID_REPA=r.ID_REPA    ";

                if ($_POST["buscar"] != '' ){ 
                        $query .= " WHERE (t.ID_TIPOP = 5 OR t.ID_TIPOP = 6 OR t.ID_TIPOP = 9 OR t.ID_TIPOP = 11 OR t.ID_TIPOP = 12) AND (u.NOMBRE LIKE LOWER('%".$aKeyword[0]."%') OR p.SERIEG LIKE LOWER('%".$aKeyword[0]."%') OR mo.MODELO LIKE LOWER('%".$aKeyword[0]."%')) ";
                
                    for($i = 1; $i < count($aKeyword); $i++) {
                    if(!empty($aKeyword[$i])) {
                        $query .= " OR u.NOMBRE LIKE '%" . $aKeyword[$i] . "%' OR p.SERIEG LIKE '%" . $aKeyword[$i] . "%' ";
                    }
                    }

                }
        if ($_POST["reparticion"] != '' ){
            $query .= " AND r.ID_REPA = '".$_POST["reparticion"]."' ";
        }    
        if ($_POST["marca"] != '' ){
            $query .= " AND m.ID_MARCA = '".$_POST["marca"]."' ";
        }
        if ($_POST["area"] != '' ){
            $query .= " AND p.ID_AREA = '".$_POST["area"]."' ";
            // $query .= " AND u.ID_AREA = '".$_POST["area"]."' ";
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
                $query .= "  ORDER BY m.MARCA ASC ";
         }
            if ($_POST["orden"] == '4' ){
                    $query .= "  ORDER BY t.TIPO ASC ";
            }
            if ($_POST["orden"] == '5' ){
                $query .= "  ORDER BY e.ESTADO ASC ";
            }


}else{
    $query ="SELECT p.ID_PERI, a.AREA, u.NOMBRE, p.SERIEG, mo.MODELO, t.TIPO, m.MARCA, p.TIPOP, e.ESTADO, r.REPA			
    FROM periferico p 
    LEFT JOIN modelo AS mo ON mo.ID_MODELO = p.ID_MODELO 
    LEFT JOIN area AS a ON a.ID_AREA = p.ID_AREA 
    LEFT JOIN equipo_periferico ep ON p.ID_PERI=ep.ID_PERI
    LEFT JOIN inventario i ON ep.ID_WS=i.ID_WS
    LEFT JOIN wsusuario ws ON i.ID_WS=ws.ID_WS
    LEFT JOIN usuarios u ON ws.ID_USUARIO=u.ID_USUARIO
    LEFT JOIN marcas AS m ON m.ID_MARCA = p.ID_MARCA 
    LEFT JOIN estado_ws AS e ON e.ID_ESTADOWS = p.ID_ESTADOWS
    LEFT JOIN tipop AS t ON t.ID_TIPOP = p.ID_TIPOP
    INNER JOIN reparticion r on a.ID_REPA=r.ID_REPA 
    WHERE (t.ID_TIPOP = 5 OR t.ID_TIPOP = 6 OR t.ID_TIPOP = 9 OR t.ID_TIPOP = 11 OR t.ID_TIPOP = 12) ORDER BY p.NOMBREP ASC";
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
                $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12";
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
                        <span class="count-name">Periféricos Registrados</span>
                    </div>
                </div>
            </div>

            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE ID_ESTADOWS = 1 AND (ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12)";
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
                        <span class="count-name">Periféricos Activos</span>
                    </div>
                </div>
            </div>


            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM periferico WHERE ID_ESTADOWS = 2 AND (ID_TIPOP = 5 OR ID_TIPOP = 6 OR ID_TIPOP = 9 OR ID_TIPOP = 11 OR ID_TIPOP = 12)";
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
                        <span class="count-name">Periféricos Inactivos</span>
                    </div>
                </div>
            </div>
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
            $color = "";

            if ($estado === "EN USO") {
                $color = "green";  // Si el estado es "en uso", el color será verde
            } elseif ($estado === "BAJA") {
                $color = "red";  // Si el estado es "baja", el color será rojo
            } elseif ($estado === "S/A - STOCK") {
                $color = "blue";  // Si el estado es "S/A - STOCK", el color será azul
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
                    <td><h4 class='wrap2' style='font-size:14px; text-align: left;margin-left:5px;color:".$color."'>".$rowSql['ESTADO']."</h4></td>
                    <td class='text-center text-nowrap'><a class='btn btn-sm btn-outline-primary' href=consultadetalleotros.php?no=".$rowSql['ID_PERI']." target=new class=mod><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentcolor' margin='5' class='bi bi-eye' viewBox='0 0 16 16'>
                    <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                    <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/></svg></a></td>
                </tr>
            ";
        }
        if($_POST['buscar'] != "" AND $_POST['buscar'] != " " OR $_POST['area'] != "" OR $_POST['reparticion'] != "" OR $_POST['marca'] != "" OR $_POST['tipo'] != "" OR $_POST['estado'] != ""){
            echo "
            <div class=filtrado>
            <h2>Filtrado por:</h2>
                <ul>";
                    if($_POST['buscar'] != "" AND $_POST['buscar'] != " "){
                        echo "<li><u>USUARIO/MODELO/SERIEG</u>: ".$_POST['buscar']."</li>";
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