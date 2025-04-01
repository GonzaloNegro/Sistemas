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
	<title>CELULARES</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymus"></script>
    <script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<?php
    if (!isset($_POST['buscar'])){$_POST['buscar'] = '';}
    if (!isset($_POST["proveedor"])){$_POST["proveedor"] = '';}
    if (!isset($_POST['modelo'])){$_POST['modelo'] = '';}
    if (!isset($_POST["estado"])){$_POST["estado"] = '';}
    if (!isset($_POST["orden"])){$_POST["orden"] = '';}
    if (!isset($_POST["reparticion"])){$_POST["reparticion"] = '';}
?>
<?php include('../layout/inventario.php'); ?>
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
  <section id="consulta">
		<div id="titulo">
			<h1>CELULARES</h1>
		</div>
        <form method="POST" id="form_filtro" action="./celulares.php" class="contFilter--name">
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">IMEI/Usuario</label>
                        <input type="text" style="text-transform:uppercase;" id="imei" name="buscar"  placeholder="Buscar" class="form-control largo">
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
                        <label class="form-label">Proveedor</label>
                        <select id="proveedor" name="proveedor" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM proveedor WHERE ID_PROVEEDOR BETWEEN 34 AND 35 ORDER BY PROVEEDOR ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_PROVEEDOR']?>"><?php echo $opciones['PROVEEDOR']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Modelo</label>
                        <select id="modelo" name="modelo" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT m.MODELO, ma.MARCA, m.ID_TIPOP, m.ID_MODELO
                            FROM modelo m
                            LEFT JOIN marcas ma ON ma.ID_MARCA = m.ID_MARCA
                            WHERE m.ID_TIPOP = 18 
                            ORDER BY m.MODELO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_MODELO']?>"><?php echo $opciones['MARCA'].' - '.$opciones['MODELO']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Estado</label>
                        <select id="estado" name="estado" class="form-control largo">
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
                    <div>
                        <label class="form-label">Orden</label>
                        <!-- <select id="assigned-tutor-filter" id="orden" name="orden" class="form-control largo"> -->
                        <select id="orden" name="orden" class="form-control largo">
                            <?php if ($_POST["orden"] != ''){ ?>
                                <option value="<?php echo $_POST["orden"]; ?>">
                                    <?php 
                            if ($_POST["orden"] == '1'){echo 'ORDENAR POR USUARIO';}
                            if ($_POST["orden"] == '2'){echo 'ORDENAR POR PROVEEDOR';}
                            if ($_POST["orden"] == '3'){echo 'ORDENAR POR MODELO';} 
                            if ($_POST["orden"] == '4'){echo 'ORDENAR POR ESTADO';}
                            ?>
                            </option>
                            <?php } ?>
                            <option value="">SIN ORDEN</option>
                            <option value="1">ORDENAR POR USUARIO</option>
                            <option value="2">ORDENAR POR PROVEEDOR</option>
                            <option value="3">ORDENAR POR MODELO</option>
                            <option value="4">ORDENAR POR ESTADO</option>
                        </select>
                    </div>
                    <div style="display:flex;justify-content: flex-end;">
                        <!-- <input type="submit" class="btn btn-success" name="busqueda" value="Buscar"> -->
                        <input onClick="filtrar()" class="btn btn-success" name="busqueda" value="Buscar">
                    </div>
                </div>
                <div class="filtros-listadoParalelo">
                    <?php 
                     if ($row['ID_PERFIL'] == 1 || $row['ID_PERFIL'] == 2 || $row['ID_PERFIL'] == 6) {
                        echo'<div>
                            <button class="btn btn-success" style="font-size: 20px;"><a href="./agregarCelular.php" style="text-decoration:none !important;color:white;" target="_blank">Agregar nuevo celular</a></button>
                        </div>';
                    }
                    
                    ?>
                    
                    <div class="export">
                        Exportar a: <button type="submit" form="formu" style="border:none; background-color:transparent;"><i class="fa-solid fa-file-excel fa-2x" style="color: #1f5120;"></i>&nbspCSV</button>
                    </div>
<!--                     <div>
                        <?php
                            $sql3 = "SELECT COUNT(*) AS TOTAL
                            FROM celular 
                            WHERE ID_ESTADOWS = 1 AND ID_PROCEDENCIA = 6";
                            $result3 = $datos_base->query($sql3);
                            $row3 = $result3->fetch_assoc();
                            $totalCelularesPropios = $row3['TOTAL'];

                            $sql3 = "SELECT COUNT(*) AS TOTAL
                            FROM linea 
                            WHERE ID_ESTADOWS = 1";
                            $result3 = $datos_base->query($sql3);
                            $row3 = $result3->fetch_assoc();
                            $totalLineas = $row3['TOTAL'];
                        ?>
                        <p>Cantidad de celulares propios: <?php echo $totalCelularesPropios;?></p>
                    </div> -->
                </div>
            </div>
        <?php 

        if ($_POST['buscar'] == ''){ $_POST['buscar'] = ' ';}
        $aKeyword = explode(" ", $_POST['buscar']);

        if ($_POST["buscar"] == '' AND $_POST['ID_MODELO'] == '' AND $_POST['ID_PROVEEDOR'] == '' AND $_POST['ID_ESTADOWS'] == ''){ 
                $query ="SELECT m.ID_MOVICEL, m.ID_CELULAR, c.IMEI, e.ESTADO, u.NOMBRE, pr.PROVEEDOR, mo.MODELO, p.PROCEDENCIA, ma.MARCA, r.REPA
                FROM movicelular m
                INNER JOIN (
                    SELECT ID_CELULAR, MAX(ID_MOVICEL) AS UltimoID
                    FROM movicelular
                    GROUP BY ID_CELULAR
                ) ultimos ON m.ID_CELULAR = ultimos.ID_CELULAR AND m.ID_MOVICEL = ultimos.UltimoID
                LEFT JOIN celular c ON m.ID_CELULAR = c.ID_CELULAR
                LEFT JOIN estado_ws e ON e.ID_ESTADOWS = c.ID_ESTADOWS
                LEFT JOIN modelo mo ON mo.ID_MODELO = c.ID_MODELO
                LEFT JOIN marcas ma ON ma.ID_MARCA = mo.ID_MARCA
                LEFT JOIN procedencia p ON p.ID_PROCEDENCIA = c.ID_PROCEDENCIA
                LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = c.ID_PROVEEDOR 
                LEFT JOIN usuarios u ON u.ID_USUARIO = m.ID_USUARIO 
                LEFT JOIN area a on a.ID_AREA=u.ID_AREA
                LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA
                ORDER BY u.NOMBRE ASC ";
        }elseif(isset($_POST['busqueda'])){
                $query = "SELECT m.ID_MOVICEL, m.ID_CELULAR, c.IMEI, e.ESTADO, u.NOMBRE, pr.PROVEEDOR, mo.MODELO, p.PROCEDENCIA, ma.MARCA, r.REPA
                FROM movicelular m
                INNER JOIN (
                    SELECT ID_CELULAR, MAX(ID_MOVICEL) AS UltimoID
                    FROM movicelular
                    GROUP BY ID_CELULAR
                ) ultimos ON m.ID_CELULAR = ultimos.ID_CELULAR AND m.ID_MOVICEL = ultimos.UltimoID
                LEFT JOIN celular c ON m.ID_CELULAR = c.ID_CELULAR
                LEFT JOIN estado_ws e ON e.ID_ESTADOWS = c.ID_ESTADOWS
                LEFT JOIN modelo mo ON mo.ID_MODELO = c.ID_MODELO
                LEFT JOIN marcas ma ON ma.ID_MARCA = mo.ID_MARCA
                LEFT JOIN procedencia p ON p.ID_PROCEDENCIA = c.ID_PROCEDENCIA
                LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = c.ID_PROVEEDOR 
                LEFT JOIN usuarios u ON u.ID_USUARIO = m.ID_USUARIO 
                LEFT JOIN area a on a.ID_AREA=u.ID_AREA
                LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA ";

                if ($_POST["buscar"] != '' ){ 
                        $query .= " WHERE (u.NOMBRE LIKE LOWER('%".$aKeyword[0]."%') OR c.IMEI LIKE LOWER('%".$aKeyword[0]."%')) ";
                
                    for($i = 1; $i < count($aKeyword); $i++) {
                    if(!empty($aKeyword[$i])) {
                        $query .= " OR u.NOMBRE LIKE '%" . $aKeyword[$i] . "%' c.IMEI LIKE '%" . $aKeyword[$i] . "%' ";
                    }
                    }

                }
          
        if ($_POST["reparticion"] != '' ){
            $query .= " AND r.ID_REPA = '".$_POST["reparticion"]."' ";
        }
        if ($_POST["proveedor"] != '' ){
            $query .= " AND pr.ID_PROVEEDOR = '".$_POST["proveedor"]."' ";
        }
        if ($_POST["modelo"] != '' ){
            $query .= " AND mo.ID_MODELO = '".$_POST["modelo"]."' ";
        }
        if ($_POST["estado"] != '' ){
            $query .= " AND e.ID_ESTADOWS = '".$_POST["estado"]."' ";
        }


        if ($_POST["orden"] == '1' ){
        $query .= " ORDER BY u.NOMBRE ASC ";
        }
        if ($_POST["orden"] == '2' ){
        $query .= " ORDER BY pr.PROVEEDOR ASC ";
        }
        if ($_POST["orden"] == '3' ){
            $query .= " ORDER BY mo.MODELO ASC ";
        }
        if ($_POST["orden"] == '4' ){
            $query .= "  ORDER BY e.ESTADO ASC ";
        }

}else{
    $query ="SELECT m.ID_MOVICEL, m.ID_CELULAR, c.IMEI, e.ESTADO, u.NOMBRE, pr.PROVEEDOR, mo.MODELO, p.PROCEDENCIA, ma.MARCA, r.REPA
    FROM movicelular m
    INNER JOIN (
        SELECT ID_CELULAR, MAX(ID_MOVICEL) AS UltimoID
        FROM movicelular
        GROUP BY ID_CELULAR
    ) ultimos ON m.ID_CELULAR = ultimos.ID_CELULAR AND m.ID_MOVICEL = ultimos.UltimoID
    LEFT JOIN celular c ON m.ID_CELULAR = c.ID_CELULAR
    LEFT JOIN estado_ws e ON e.ID_ESTADOWS = c.ID_ESTADOWS
    LEFT JOIN modelo mo ON mo.ID_MODELO = c.ID_MODELO
    LEFT JOIN marcas ma ON ma.ID_MARCA = mo.ID_MARCA
    LEFT JOIN procedencia p ON p.ID_PROCEDENCIA = c.ID_PROCEDENCIA
    LEFT JOIN proveedor pr ON pr.ID_PROVEEDOR = c.ID_PROVEEDOR 
    LEFT JOIN usuarios u ON u.ID_USUARIO = m.ID_USUARIO 
    LEFT JOIN area a on a.ID_AREA=u.ID_AREA
    LEFT JOIN reparticion r on a.ID_REPA=r.ID_REPA
    ";
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
        if($_POST["buscar"] == ' ' AND $_POST['proveedor'] == '' AND $_POST['reparticion'] == '' AND $_POST['modelo'] == '' AND $_POST['estado'] == ''){;
        ?>

        <div class="principal-info">
            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM celular";
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
                        <span class="count-name">Celulares Registrados</span>
                    </div>
                </div>
            </div>

            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM celular WHERE ID_ESTADOWS = 1";
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
                        <span class="count-name">Celulares Activos</span>
                    </div>
                </div>
            </div>


            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM celular WHERE ID_ESTADOWS = 2 OR ID_ESTADOWS = 3";
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
                        <span class="count-name">Celulares Inactivos</span>
                    </div>
                </div>
            </div>
        </div>
        <?php };?>


    <table class="table_id" style="width: 98%; margin: 0 auto;">
        <thead>
            <tr>
                <th><p style="text-align:right; margin-right: 5px;">IMEI</p></th>
                <th><p style="text-align:left; margin-left: 5px;">USUARIO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">REPARTICIÓN</p></th>
                <th><p style="text-align:left; margin-left: 5px;">PROCEDENCIA</p></th>
                <th><p style="text-align:left; margin-left: 5px;">PROVEEDOR</p></th>
                <th><p style="text-align:left; margin-left: 5px;">MODELO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">ESTADO</p></th>
                <th><p>ACCIÓN</p></th>
            </tr>
        </thead>

        <?php $cantidadTotal = 0;?>
        <?php While($rowSql = $sql->fetch_assoc()) {
            $cantidadTotal++;
            $NUMERO=$rowSql['IMEI']; 

            $estado = $rowSql['ESTADO']; // Este valor lo obtienes de tu lógica o de una variable
            $color = "";

            if ($estado === "EN USO") {
                $color = "green";  // Si el estado es "en uso", el color será verde
            } elseif ($estado === "BAJA") {
                $color = "red";  // Si el estado es "baja", el color será rojo
            } elseif ($estado === "S/A - STOCK") {
                $color = "blue";  // Si el estado es "S/A - STOCK", el color será azul
            }

            echo "
                <tr>
                    <td><h4 style='font-size:16px; text-align:right;margin-right: 5px;'>".$rowSql['IMEI']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:16px; text-align: left; margin-left: 5px;'>".$rowSql['NOMBRE']."</h4></td>
                    <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".$rowSql['REPA']."</h4></td>
                    <td><h4 style='font-size:16px; text-align:left;margin-left: 5px;'>".$rowSql['PROCEDENCIA']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:16px; text-align:left;margin-left: 5px;'>".$rowSql['PROVEEDOR']."</h4></td>
                    <td><h4 style='font-size:16px; text-align:left;margin-left: 5px;'>".$rowSql['MARCA']." - ".$rowSql['MODELO']."</h4></td>
                    <td><h4 class='wrap2' style='font-size:16px; text-align:left;margin-left: 5px;color:".$color."'>".$rowSql['ESTADO']."</h4></td>

                    <td class='text-center text-nowrap'>
                        <a class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#exampleModal'
                        data-bs-whatever='@mdo' onclick='cargar_informacion(".$rowSql['ID_CELULAR'].")' target=new class=mod>Info</a>

                        <a class='btn btn-success' data-bs-toggle='modal' data-bs-target='#exampleModal2'
                        data-bs-whatever='@mdo' style=' color:white;' onclick='cargar_informacion2(".$rowSql['ID_CELULAR'].")' class=mod>Mov. Info</a>
                        
                        <a class='btn btn-success' data-bs-toggle='modal' data-bs-target='#exampleModal3'
                        data-bs-whatever='@mdo' class='btn btn-warning' style='background-color:#FF7800;' onclick='cargar_informacion3(".$rowSql['ID_CELULAR'].")' class=mod>Mov. Cel</a>
                        ";
                        if ($row['ID_PERFIL'] == 1 || $row['ID_PERFIL'] == 2 || $row['ID_PERFIL'] == 6) {
                            echo"
                        <a class='btn btn-info' style=' color:white;' href=./modificarCelular.php?num=".$rowSql['ID_CELULAR']." target=_blank class=mod>Editar</a>";
                        }
                        echo"
                    </td>
                </tr>
            ";
        }
        if($_POST['buscar'] != "" AND $_POST['buscar'] != " " OR $_POST['reparticion'] != "" OR $_POST['proveedor'] != "" OR $_POST['modelo'] != "" OR $_POST['estado'] != ""){
            echo "
            <div class=filtrado>
            <h2>Filtrado por:</h2>
                <ul>";
                    if($_POST['buscar'] != "" AND $_POST['buscar'] != " "){
                        echo "<li><u>IMEI/USUARIO</u>: ".$_POST['buscar']."</li>";
                    }
                    if($_POST['proveedor'] != ""){
                        $sql = "SELECT PROVEEDOR FROM proveedor WHERE ID_PROVEEDOR = $_POST[proveedor]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $proveedor = $row['PROVEEDOR'];
                        echo "<li><u>PROVEEDOR</u>: ".$proveedor."</li>";
                    }
                    if($_POST['reparticion'] != ""){
                        $sql = "SELECT REPA FROM reparticion WHERE ID_REPA = $_POST[reparticion]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $repa = $row['REPA'];
                        echo "<li><u>REPARTICIÓN</u>: ".$repa."</li>";
                    }
                    if($_POST['modelo'] != ""){
                        $sql = "SELECT MODELO FROM modelo WHERE ID_MODELO = $_POST[modelo]";
                        $resultado = $datos_base->query($sql);
                        $row = $resultado->fetch_assoc();
                        $modelo = $row['MODELO'];
                        echo "<li><u>MODELO</u>: ".$modelo."</li>";
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
        <form id="formu" action="../exportar/ExcelCelulares.php" method="POST">
            <input type="text" id="excel" name="sql" class="valorPeque" readonly="readonly" value="<?php echo $query;?>">
        </form>
	</section>
	<footer></footer>

    <div class="modal fade modal--usu" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">INFORMACIÓN</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="mostrar_mensaje" style="display:flex;flex-direction:column;gap:10px;">
                    </div>
                </div>
                <div id="resultado" class="resultado">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal--usu" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="display:flex;justify-content:center;width:100%;">
            <div class="modal-content"  style="width:auto;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">HISTORIAL MOVIMIENTOS DE INFORMACIÓN</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="mostrar_mensaje2"></table>
                </div>
                <div id="resultado" class="resultado">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal--usu" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="display:flex;justify-content:center;width:100%;">
            <div class="modal-content"  style="width:auto;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">HISTORIAL MOVIMIENTOS CELULAR</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="mostrar_mensaje3"></table>
                </div>
                <div id="resultado" class="resultado">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!--FUNCIONALIDAD EN JQUERY QUE PETICIONA A consultarDatosLinea.php los detalles de la linea-->
    <script>
    function cargar_informacion(id_celular) {
        //buscar ES EL ID DEL CASO//
        var parametros = {
            "idCelular": id_celular
        };
        //LA VARIABLE BUSCAR UTILIZA EL ID CASO Y LA ENVIA AL SERVIDOR DE NOVEDADES///
        $.ajax({
            data: parametros,
            url: "./consultarDatosCelular.php",
            type: "POST",
            //TRAE DE FORMA ASINCRONA, CONSUME EL SERVIDOR DE NOVEDADES Y MUESTRA EN EL DIV MOSTRAR_MENSAJE TODAS LAS NOVEDADES RELACIONADAS////
            beforesend: function() {
                $("#mostrar_mensaje").html("Mensaje antes de Enviar");
            },

            success: function(mensaje) {
                $("#mostrar_mensaje").html(mensaje);
            }
        });
    };
    function cargar_informacion2(id_celular) {
        //buscar ES EL ID DEL CASO//
        var parametros = {
            "idCelular": id_celular
        };
        //LA VARIABLE BUSCAR UTILIZA EL ID CASO Y LA ENVIA AL SERVIDOR DE NOVEDADES///
        $.ajax({
            data: parametros,
            url: "./consultarDatosCelular2.php",
            type: "POST",
            //TRAE DE FORMA ASINCRONA, CONSUME EL SERVIDOR DE NOVEDADES Y MUESTRA EN EL DIV MOSTRAR_MENSAJE TODAS LAS NOVEDADES RELACIONADAS////
            beforesend: function() {
                $("#mostrar_mensaje2").html("Mensaje antes de Enviar");
            },

            success: function(mensaje) {
                $("#mostrar_mensaje2").html(mensaje);
            }
        });
    };
    function cargar_informacion3(id_celular) {
        //buscar ES EL ID DEL CASO//
        var parametros = {
            "idCelular": id_celular
        };
        //LA VARIABLE BUSCAR UTILIZA EL ID CASO Y LA ENVIA AL SERVIDOR DE NOVEDADES///
        $.ajax({
            data: parametros,
            url: "./consultarDatosCelular3.php",
            type: "POST",
            //TRAE DE FORMA ASINCRONA, CONSUME EL SERVIDOR DE NOVEDADES Y MUESTRA EN EL DIV MOSTRAR_MENSAJE TODAS LAS NOVEDADES RELACIONADAS////
            beforesend: function() {
                $("#mostrar_mensaje3").html("Mensaje antes de Enviar");
            },

            success: function(mensaje) {
                $("#mostrar_mensaje3").html(mensaje);
            }
        });
    };
    </script>
    <script>
        function filtrar(){
            var procedencia= $("#procedencia").val();
            var imei= $("#imei").val();
            var proveedor= $("#proveedor").val();
            var modelo= $("#modelo").val();
            var estado= $("#estado").val();
            var orden= $("#orden").val();
            if(procedencia=="" && imei=="" && proveedor=="" && modelo=="" && estado=="" && orden==""){
                Swal.fire({
                        title: "Por favor seleccione una opción a filtrar.",
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
