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
	<title>CELULARES</title>
    <meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymus"></script>
    <script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
    
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            window.location.href='../consulta/celulares.php';
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
<?php include('../layout/inventario.php'); ?>
    <style>
        #h2{
                text-align: left;	
                font-family: TrasandinaBook;
                font-size: 14px;
                color: #edf0f5;
                margin-left: 10px;
                margin-top: 5px;  
            }
    </style>
    <script>
                //Funcion que va mostrando que filtros se van utilizando
                function mostrarFiltros(){
                    const busqueda = $("#imei");
                    const proveedor = $("#proveedor");
                    const modelo = $("#modelo");
                    const orden = $("#orden"); 
                    const estado = $("#estado");
                    const reparticion = $("#reparticion");
                    
                    const filtros = $("#filtrosUsados");
                    // Vaciar el div antes de agregar nuevos filtros
                    filtros.empty();

                    
                    filtros.append();
                    
                    if (busqueda.val() != '') {
                        filtros.append(`<li style="color:#00519C; margin-left: 15px;"><u>BÚSQUEDA</u>: ${busqueda.val()}</li>`);
                    }
                    
                    if (proveedor.val() != '') {
                        filtros.append(`<li style="color:#00519C; margin-left: 15px;"><u>PROVEEDOR</u>: ${$("#proveedor option:selected").text()}</li>`);
                    }
                    if (reparticion.val() != '') {
                        filtros.append(`<li style="color:#00519C; margin-left: 15px;"><u>REPARTICION</u>: ${$("#reparticion option:selected").text()}</li>`);
                    }
                    if (modelo.val() != '') {
                        filtros.append(`<li style="color:#00519C; margin-left: 15px;"><u>MODELO</u>: ${$("#modelo option:selected").text()}</li>`);
                    }
                    if (estado.val() != '') {
                        filtros.append(`<li style="color:#00519C; margin-left: 15px;"><u>ESTADO</u>: ${$("#estado option:selected").text()}</li>`);
                    }
                    if (orden.val() != '') {
                        filtros.append(`<li style="color:#00519C; margin-left: 15px;"><u>ORDEN</u>: ${$("#orden option:selected").text()}</li>`);
                    }

                    filtros.show();
                }
            </script>
            <script>
                //Cargar datos en la tabla
        $(document).ready(function () {
            function cargarDatos(pagina = 1) {
                // Obtener valor del formulario
                const busqueda = $("#imei").val();
                    const proveedor = $("#proveedor").val();
                    const modelo = $("#modelo").val();
                    const orden = $("#orden").val(); 
                    const estado = $("#estado").val();
                    const reparticion = $("#reparticion").val();
                //Obtener los datos de la tabla de usuarios
                $.ajax({
                    url: "paginador_celulares.php", // Archivo PHP
                    type: "GET",
                    data: { 
                            pagina: pagina,
                            busqueda: busqueda,
                            proveedor: proveedor,
                            reparticion: reparticion,
                            orden: orden,
                            modelo: modelo,
                            estado: estado,
                             },
                    dataType: "json",
                    //Respuesta obtenida de paginador.php
                    success: function (respuesta) {
                        //Cargamos el nro de incidentes obtenidos en label
                        
                        const lblUsuarios = $("#nroCelulares").text("Resultados Encontrados: "+respuesta.totalCelulares); 

                        //Mostramos el label con el numero de resultados encontramos
                        if(busqueda=='' && proveedor=='' && reparticion=='' && orden=='' && modelo==''&& estado==''){
                            $("#nroCelulares").hide();
                        }
                        else{
                            $("#nroCelulares").show();
                        }

                        //Cargamos la consulta sql utilizada en el value del input del formulario para generar el excel
                        

                         const inputExcel = $("#excel");
                         inputExcel.val(respuesta.query);

                        // Poblar la tabla
                        const tabla = $("#tabla-datos");
                        tabla.empty();
                        respuesta.datos.forEach(fila => {
                            let estado = fila.ESTADO;
                            let color = "blue";
                            let flecha = "<i class='fa-solid fa-box-open' style='color:blue'></i>";

                            if (estado === "EN USO") {
                                color = "green";
                                flecha = "<i class='fa-solid fa-arrow-up' style='color:green'></i>";
                            } else if (estado === "BAJA") {
                                color = "red";
                                flecha = "<i class='fa-solid fa-arrow-down' style='color:red'></i>";
                            }

                            let usuario = fila.NOMBRE;
                            if(!usuario){
                                usuario = "NO ASIGNADO";
                            }
                            tabla.append(`<tr>
                            <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${fila.IMEI}</h4></td>
                            <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${usuario}</h4></td>
                            <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${fila.REPA}</h4></td>
                            <td><h4 style='max-width:180px;font-size:14px; text-align:left;margin-left: 5px;'>${fila.PROCEDENCIA}</h4></td>
                            <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${fila.PROVEEDOR}</h4></td>
                            <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${fila.MARCA} - ${fila.MODELO}</h4></td>
                            <td><h4 style='color:${color};font-size:14px;text-align:left;margin-left: 5px;'>${flecha} ${fila.ESTADO}</h4></td>

                            <td class='text-center text-nowrap'>
                                <span style="display: inline-flex;padding:3px;">
                                    <a style="padding:3px;" href="#" 
                                    data-bs-toggle='modal' 
                                    data-bs-target='#modalInfo'
                                    onclick='cargar_informacion(${fila.ID_CELULAR})'
                                    class='mod'>
                                        <i style="color: #0d6efd" 
                                        class="fa-solid fa-circle-info fa-2xl" 
                                        data-bs-toggle="popover" 
                                        data-bs-trigger="hover" 
                                        data-bs-placement="top" 
                                        ></i>
                                    </a>
                                </span>

                                <span style="display: inline-flex;padding:3px;">
                                    <a style="padding:3px;" 
                                    href='../abm/modmonitores.php?no=${fila.ID_CELULAR}' 
                                    target='_blank' 
                                    class='mod' 
                                    data-bs-toggle='popover' 
                                    data-bs-trigger='hover' 
                                    data-bs-placement='top' 
                                    data-bs-content='Editar'>
                                        <i style="color: #198754" class="fa-solid fa-pen-to-square fa-2xl"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>`);
                        });

                        $(function () {
                            // Asegúrate de que los popovers se inicialicen solo una vez después de agregar los elementos
                            $('[data-bs-toggle="popover"]').each(function() {
                                if (!$(this).data('bs.popover')) {
                                    $(this).popover(); // Inicializa el popover solo si no está inicializado
                                }
                            });
                        });

                        // Crear los botones de paginación
                        const paginador = $("#paginador");
                        paginador.empty();
                        
                        
                        const totalPaginas = respuesta.totalPaginas;
                    const paginaActual = respuesta.pagina;

                    // Función para agregar un botón
                    function agregarBoton(pagina, texto, activo = false, desactivado = false) {
                        paginador.append(`
                            <li class="page-item ${activo ? 'active' : ''} ${desactivado ? 'disabled' : ''}">
                                <button class="page-link btn-pagina" data-pagina="${pagina}" ${desactivado ? 'disabled' : ''}>
                                    ${texto}
                                </button>
                            </li>
                        `);
                    }
                    
                    // Botón "Anterior"
                    agregarBoton(paginaActual - 1, '&laquo; Anterior', false, paginaActual === 1);

                    // Primera página
                    agregarBoton(1, '1', paginaActual === 1);

                    // Puntos suspensivos si la página actual está lejos de la primera
                    if (paginaActual > 4) {
                        paginador.append('<li class="page-item disabled"><span class="page-link">...</span></li>');
                    }

                    // Páginas cercanas a la actual
                    for (let i = Math.max(2, paginaActual - 2); i <= Math.min(totalPaginas - 1, paginaActual + 2); i++) {
                        agregarBoton(i, i, paginaActual === i);
                    }

                    // Puntos suspensivos si la página actual está lejos de la última
                    if (paginaActual < totalPaginas - 3) {
                        paginador.append('<li class="page-item disabled"><span class="page-link">...</span></li>');
                    }

                    // Última página
                    agregarBoton(totalPaginas, totalPaginas, paginaActual === totalPaginas);

                    // Botón "Siguiente"
                    agregarBoton(paginaActual + 1, 'Siguiente &raquo;', false, paginaActual === totalPaginas);
                    ////
                    }
                });
            }

            // Manejar el evento del formulario de filtro
            $("#btnForm").on("click", function (e) {
                //e.preventDefault(); // Evitar recarga de la página
                cargarDatos(1); // Cargar datos desde la primera página con el filtro aplicado
                mostrarFiltros();
            });

            // Cargar la página inicial
            cargarDatos();

            // Evento para cambiar de página
            $(document).on("click", ".btn-pagina", function () {
                const pagina = $(this).data("pagina");
                cargarDatos(pagina);
            });
        });
    </script>
  <section id="consulta">
		<div id="titulo">
			<h1>CELULARES</h1>
		</div>
        <div class="botonAgregar">
            <?php 
                if ($row['ID_PERFIL'] == 1 || $row['ID_PERFIL'] == 2 || $row['ID_PERFIL'] == 6) {
                    echo'<div>
                    <button class="btn btn-success" style="font-size: 20px;"><a href="./agregarCelular.php" style="text-decoration:none !important;color:white;" target="_blank">Agregar Celular</a></button>
                    </div>';
                }
                ?>
        </div>
        <!-- <form method="POST" id="form_filtro" action="./celulares.php" class="contFilter--name"> -->
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">IMEI/Usuario</label>
                        <input type="text" style="text-transform:uppercase;" id="imei" name="buscar"  placeholder="Buscar" class="form-control largo">
                    </div>
                    <div>
                        <label class="form-label">Repartición</label>
                        <select id="reparticion" name="reparticion" class="form-control largo">
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
                </div>
                <div class="filtros-listadoParalelo">
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
                        <input type="button" class="btn btn-danger" id="btnLimpiar" onclick="Limpiar()" value="Limpiar">
                        <input type="submit" class="btn btn-success" id="btnForm" name="busqueda" value="Buscar">
                        <button type="submit" form="formu" style="border:none; background-color:transparent;"><i class="fa-solid fa-file-excel fa-2x" style="color: #1f5120;"></i>&nbspCSV</button>
                    </div>
                </div>
            </div>
<!--         
    </form> -->

        <div class="principal-info">
            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM celular";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $total = $row6['total'];
            ?>
<!--             <div class="col-md-3">
                <div class="card-counter primary">
                    <div class="card-pri">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <span class="count-numbers"><?php echo $total;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Celulares Registrados</span>
                    </div>
                </div>
            </div> -->

            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM celular WHERE ID_ESTADOWS = 1";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $activo = $row6['total'];
            ?>
<!--             <div class="col-md-3">
                <div class="card-counter success">
                    <div class="card-pri">
                        <i class="fa-sharp fa-solid fa-arrow-up"></i>
                        <span class="count-numbers"><?php echo $activo;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Celulares Activos</span>
                    </div>
                </div>
            </div> -->


            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM celular WHERE ID_ESTADOWS = 2 OR ID_ESTADOWS = 3";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $inactivos = $row6['total'];
            ?>
<!--             <div class="col-md-3">
                <div class="card-counter danger">
                    <div class="card-pri">
                        <i class="fa-sharp fa-solid fa-arrow-down"></i>
                        <span class="count-numbers"><?php echo $inactivos;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Celulares Inactivos</span>
                    </div>
                </div>
            </div> -->

            <p>Celulares Registrados: <?php echo $total; ?></p>
            <p>Celulares Activos: <?php echo $activo; ?></p>
            <p>Celulares Inactivos: <?php echo $inactivos; ?></p>
        </div>
        
        <?php
        echo"<div class=filtrado>
                <label style='color:#00519C; margin-left: 15px; margin-bottom:20px;' id='nroCelulares'>Resultados Encontrados:</label>
        ";?>

                <div id="filtrosUsados" style="display:none;">
                    <h2>Filtrado por:</h2>
                    <ul></ul>
                </div>
            </div>  


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
        <?php 
        function mostrarValor($valor) {
            return ($valor === null || $valor === '' || strtolower($valor) === 'null' || strtolower($valor) === 'undefined') ? '-' : $valor;
        }

        While($rowSql = $sql->fetch_assoc()) {
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

            $color = 'blue';
            $flecha = "<i class='fa-solid fa-box-open' style='color:blue'></i>";
            if ($estado === 'EN USO') {
                $color = 'green';
                $flecha = "<i class='fa-solid fa-arrow-up' style='color:green'></i>";
            } elseif ($estado === 'BAJA') {
                $color = 'red';
                $flecha = "<i class='fa-solid fa-arrow-down' style='color:red'></i>";
            }

            echo "
                <tr>
                <td><h4 style='font-size:14px; text-align:right;margin-right: 5px;'>".mostrarValor($rowSql['IMEI'])."</h4></td>
                <td><h4 class='wrap2' style='font-size:14px; text-align: left; margin-left: 5px;'>".mostrarValor($rowSql['NOMBRE'])."</h4></td>
                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".mostrarValor($rowSql['REPA'])."</h4></td>
                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".mostrarValor($rowSql['PROCEDENCIA'])."</h4></td>
                <td><h4 class='wrap2' style='font-size:14px; text-align:left;margin-left: 5px;'>".mostrarValor($rowSql['PROVEEDOR'])."</h4></td>
                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>".mostrarValor($rowSql['MARCA'])." - ".mostrarValor($rowSql['MODELO'])."</h4></td>
                <td><h4 class='wrap2' style='font-size:14px; text-align:left;margin-left: 5px;color:".$color."'>".$flecha." ".mostrarValor($rowSql['ESTADO'])."</h4></td>

                    <td class='text-center text-nowrap'>
                        <span style='display: inline-flex; padding: 3px;'>
                            <a style='padding: 3px; cursor: pointer;'
                            data-bs-toggle='modal'
                            data-bs-target='#exampleModal'
                            onclick='cargar_informacion(" . $rowSql['ID_CELULAR'] . ")'
                            class='mod'>
                                <i class='fa-solid fa-circle-info fa-2xl'
                                style='color: #0d6efd'
                                data-bs-toggle='popover'
                                data-bs-trigger='hover focus'
                                data-bs-placement='top'></i>
                            </a>
                        </span>";
                        
                        if ($row['ID_PERFIL'] == 1 || $row['ID_PERFIL'] == 2 || $row['ID_PERFIL'] == 6) {
                            echo"
                                <span style='display: inline-flex;padding:3px;'>
                                    <a style='padding:3px;' 
                                    href='./modificarCelular.php?num=" . $rowSql['ID_CELULAR'] . "' 
                                    target='_blank' 
                                    class='mod' 
                                    data-bs-toggle='popover' 
                                    data-bs-trigger='hover' 
                                    data-bs-placement='top' 
                                    data-bs-content='Editar'>
                                    <i style='color: #198754' class='fa-solid fa-pen-to-square fa-2xl'></i>
                                    </a>
                                </span>";
                        }
                        echo"
                    </td>
                </tr>
            ";}

            ?>
                <div class="filtrado">
            <?php
        if($_POST['buscar'] != "" AND $_POST['buscar'] != " " OR $_POST['reparticion'] != "" OR $_POST['proveedor'] != "" OR $_POST['modelo'] != "" OR $_POST['estado'] != ""){
            echo "
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
	<footer id="footer_pag"><div class="pagination justify-content-center mt-3" id="paginador"></div></footer>

    <div class="modal fade modal--usu" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
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
                    <button id="botonright" type="button" class="btn btn-success" onClick="imprimir()"><i class='bi bi-printer' style="color:white;"></i></button>
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
    <script>
            function imprimir() {
            // Guardar el estado original de los elementos
            var contenidoOriginal = document.body.innerHTML;
            
            // Obtener solo el contenido del primer modal
            var contenidoModal = document.getElementById('exampleModal').innerHTML;

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
	
</body>
</html>
