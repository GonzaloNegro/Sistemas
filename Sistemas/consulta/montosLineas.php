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
$sql = "SELECT ID_RESOLUTOR, CUIL, RESOLUTOR, ID_PERFIL FROM resolutor WHERE CUIL='$iduser'";
$resultado = $datos_base->query($sql);
$row = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>MONTOS LÍNEAS</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymus"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
</head>
<body>
<script type="text/javascript">
			function ok(){
				Swal.fire(  {title: "Monto/Linea Actualizada Correctamente!!",
						icon: "success",
						showConfirmButton: true,
						showCancelButton: false,
						});
			}	
			</script>
<script type="text/javascript">
			function error(){
				Swal.fire(  {title: "Ya hay líneas actualizadas este mes para Personal o Claro.",
						icon: "error",
						});
			}	
			</script>
<script type="text/javascript">
			function errorp(){
				Swal.fire(  {title: "Ya hay líneas actualizadas este mes para el operador seleccionado.",
						icon: "error",
						});
			}	
			</script>
    <script>
        function actualizar_montos(form){
            var formulario = form;
            Swal.fire({
            title: 'Selecciona una opción',
            html: `
            <div style="flex-direction: column; gap: 8px; color: black;">
                <label style="display: flex; align-items: center; gap: 4px; color: black;">
                    <input style="width:auto;margin:0px;margin-top:0px;margin-left:0px;" type="radio" name="opcion" value="claro">
                    Claro
                </label>
                <label style="display: flex; align-items: center; gap: 4px; color: black;">
                    <input style="width:auto;margin:0px;margin-top:0px;margin-left:0px;" type="radio" name="opcion" value="personal">
                    Personal
                </label>
                <label style="display: flex; align-items: center; gap: 4px; color: black;">
                    <input style="width:auto;margin:0px;margin-top:0px;margin-left:0px;" type="radio" name="opcion" value="todos">
                    Todos
                </label>
            </div>`,
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            preConfirm: () => {
            const selected = document.querySelector('input[name="opcion"]:checked');
            if (!selected) {
                Swal.showValidationMessage('Debes seleccionar una opción');
            }
            return selected ? selected.value : null;
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
            document.getElementById('operadorSeleccionado').value = result.value;
            formulario.submit();
            }
        });
        }
    </script>
    <script>
                //Funcion que va mostrando que filtros se van utilizando
                function mostrarFiltros(){
                    const busqueda = $("#buscar");
                    const nombreplan = $("#nombreplan");
                    const reparticion = $("#reparticion");
                    const orden = $("#orden"); 
                    const estado = $("#estado");
                    const proveedor = $("#proveedor");

                    const filtros = $("#filtrosUsados");
                    // Vaciar el div antes de agregar nuevos filtros
                    filtros.empty();
                    
                    
                    filtros.append();
                    
                    if (busqueda.val() != '') {
                        filtros.append(`<li style="color:#00519C; margin-left: 15px;"><u>BÚSQUEDA</u>: ${busqueda.val()}</li>`);
                    }
                    // alert();
                    if (nombreplan.val() != '') {
                        filtros.append(`<li style="color:#00519C; margin-left: 15px;"><u>NOMBRE DE PLAN</u>: ${$("#nombreplan option:selected").text()}</li>`);
                    }
                    if (proveedor.val() != '') {
                        filtros.append(`<li style="color:#00519C; margin-left: 15px;"><u>PROVEEDOR</u>: ${$("#proveedor option:selected").text()}</li>`);
                    }
                    if (reparticion.val() != '') {
                        filtros.append(`<li style="color:#00519C; margin-left: 15px;"><u>REPARTICIÓN</u>: ${$("#reparticion option:selected").text()}</li>`);
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
                const busqueda = $("#buscar").val();
                const nombreplan = $("#nombreplan").val();
                const reparticion = $("#reparticion").val();
                const orden = $("#orden").val(); 
                const estado = $("#estado").val();
                const proveedor = $("#proveedor").val();
                //Obtener los datos de la tabla de usuarios
                $.ajax({
                    url: "paginador_montosLineas.php", // Archivo PHP
                    type: "GET",
                    data: { 
                            pagina: pagina,
                            busqueda: busqueda,
                            nombreplan: nombreplan,
                            proveedor: proveedor,
                            reparticion: reparticion,
                            orden: orden,
                            estado: estado,
                             },
                    dataType: "json",
                    //Respuesta obtenida de paginador.php
                    success: function (respuesta) {
                        //Cargamos el nro de incidentes obtenidos en label
                        
                        const lblUsuarios = $("#nroLineas").text("Resultados Encontrados: "+respuesta.totalMontosLineas); 
                        // alert(respuesta.totalMontosLineas);
                        //Mostramos el label con el numero de resultados encontramos
                        if(busqueda=='' && nombreplan=='' && reparticion=='' && orden=='' && estado=='' && proveedor==''){
                            $("#nroLineas").hide();
                        }
                        else{
                            $("#nroLineas").show();
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

                            function mostrarValor(valor, simbolo = '', posicion = 'antes', opciones = {}) {
                                if (
                                    valor === null ||
                                    valor === undefined ||
                                    valor === '' ||
                                    valor === '0.00' ||
                                    parseFloat(valor) === 0
                                ) {
                                    return '-';
                                }

                                // Símbolo en la posición adecuada
                                let valorFormateado = (posicion === 'despues')
                                    ? `${valor}${simbolo}`
                                    : `${simbolo}${valor}`;

                                // Aplicar estilo si se solicita
                                let estilo = '';
                                if (opciones.color) {
                                    estilo += `color:${opciones.color};`;
                                }
                                if (opciones.negrita) {
                                    estilo += 'font-weight:bold;';
                                }

                                return `<span style="${estilo}">${valorFormateado}</span>`;
                            }


                            function mostrarPlan(nombrePlan, plan) {
                                const val1 = mostrarValor(nombrePlan);
                                const val2 = mostrarValor(plan);

                                if (val1 === '-' && val2 === '-') {
                                    return '-';
                                } else if (val1 !== '-' && val2 !== '-') {
                                    return `${val1} - ${val2}`;
                                } else {
                                    return val1 !== '-' ? val1 : val2;
                                }
                            }

                            tabla.append(`<tr>
                            <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${mostrarValor(fila.NRO)}</h4></td>
                            <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${mostrarValor(usuario)}</h4></td>
                            <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${mostrarValor(fila.REPA)}</h4></td>
                            <td><h4 style='max-width:180px;font-size:14px; text-align:left;margin-left: 5px;'>${mostrarPlan(fila.NOMBREPLAN, fila.PLAN)}</h4></td>
                            <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${mostrarValor(fila.PROVEEDOR)}</h4></td>
                            <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${mostrarValor(fila.MONTO, '$', 'antes', { color: 'green', negrita: false })}</h4></td>
                            <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${mostrarValor(fila.EXTRAS, '$', 'antes', { color: 'red', negrita: true })}</h4></td>
                            <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${mostrarValor(fila.DESCUENTO, '%', 'despues', { color: 'green', negrita: false })}</h4></td>
                            <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${mostrarValor(fila.MONTOTOTAL, '$', 'antes', { color: 'green', negrita: true })}</h4></td>
                            <td><h4 style='color:${color};font-size:14px;text-align:left;margin-left: 5px;'>${flecha} ${mostrarValor(fila.ESTADO)}</h4></td>

                            <td class='text-center text-nowrap'>
                            <span style='display: inline-flex; padding: 3px;'>
                                <a style='padding: 3px; cursor: pointer;'
                                data-bs-toggle='modal'
                                data-bs-target='#exampleModal'
                                onclick='cargar_informacion("${fila.ID_LINEA}")'
                                class='mod'>
                                    <i class='fa-solid fa-circle-info fa-2xl'
                                    style='color: #0d6efd'
                                    data-bs-toggle='popover'
                                    data-bs-trigger='hover focus'
                                    data-bs-placement='top'></i>
                                </a>
                            </span>

                            <span style='display: inline-flex;padding:3px;'>
                                <a style='padding:3px;' href='#' 
                                    data-bs-toggle='modal' 
                                    data-bs-target='#exampleModal2' 
                                    onclick='cargar_informacion2("${fila.ID_LINEA}")'
                                    class='mod'
                                    title='Movimientos Montos'>
                                    <i style='color: #fd7e14' 
                                    class='fa-solid fa-arrow-down-wide-short fa-2xl'></i>
                                </a>
                            </span>
                            <span style='display: inline-flex;padding:3px;'>
                                <a style='padding:3px;' 
                                href='./modificarLinea.php?num=${fila.ID_LINEA}' 
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
                        </tr>`);
                        });
//                          `;

// if($row['ID_PERFIL'] == 1 || $row['ID_PERFIL'] == 2 || $row['ID_PERFIL'] == 6) 
// { `
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
    
    <script>
        //Limpiar campos de formulario
        function Limpiar(){
            window.location.href='../consulta/montosLineas.php';
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
	              margin-top: 5px;;
               
				}
        </style>
  <section id="consulta">
		<div id="titulo">
			<h1>MONTOS LÍNEAS</h1>
		</div>
        <div class="botonAgregar" style="display:flex;gap:10px;">
            <?php if($row['ID_PERFIL'] == 1 || $row['ID_PERFIL'] == 2 || $row['ID_PERFIL'] == 6){
                echo '<div>
                        <button class="btn btn-success" style="font-size: 20px;"><a href="./agregarLinea.php" style="text-decoration:none !important;color:white;" target="_blank">Agregar Línea</a></button>
                    </div>';
            }
            ?>
            <button class="btn btn-warning" style="font-size: 20px;background-color:#FF7800;"><a href="./montosMensuales.php" style="text-decoration:none !important;color:white;" target="_blank">Montos mensuales</a></button>
        </div>

        <!-- <form method="POST" id="form_filtro" action="./MontosLineas.php" class="contFilter--name"> -->
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">Número/Usuario</label>
                        <input type="text" style="text-transform:uppercase;" id="buscar" name="buscar"  placeholder="Buscar" class="form-control largo">
                    </div>
                    <div>
                        <label class="form-label">Nombre plan</label>
                        <select id="nombreplan" name="nombreplan" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT n.NOMBREPLAN, p.PLAN, n.ID_NOMBREPLAN, e.PROVEEDOR
                            FROM nombreplan n
                            LEFT JOIN plan p ON p.ID_PLAN = n.ID_PLAN inner join proveedor e on n.ID_PROVEEDOR=e.ID_PROVEEDOR
                            WHERE n.MONTO > 0
                            ORDER BY n.NOMBREPLAN ASC
                            ";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_NOMBREPLAN']?>"><?php echo $opciones['NOMBREPLAN']." - ".$opciones['PLAN']?> - <?php echo $opciones['PROVEEDOR']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Proveedor</label>
                        <select id="proveedor" name="proveedor" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "select proveedor, id_proveedor from proveedor where id_proveedor=34 or id_proveedor=35 order by proveedor asc";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['id_proveedor']?>"><?php echo $opciones['proveedor']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="filtros-listadoParalelo">
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
                        <select id="orden" name="orden" class="form-control largo">
                            <?php if ($_POST["orden"] != ''){ ?>
                                <option value="<?php echo $_POST["orden"]; ?>">
                                    <?php 
                            if ($_POST["orden"] == '1'){echo 'ORDENAR POR USUARIO';} 
                            if ($_POST["orden"] == '2'){echo 'ORDENAR POR NOMBRE PLAN';}
                            if ($_POST["orden"] == '3'){echo 'ORDENAR POR ESTADO';}
                            if ($_POST["orden"] == '4'){echo 'ORDENAR POR MONTO TOTAL ASCENDENTE';}
                            if ($_POST["orden"] == '5'){echo 'ORDENAR POR MONTO TOTAL DESCENDENTE';}
                            ?>
                            </option>
                            <?php } ?>
                            <option value="">SIN ORDEN</option>
                            <option value="1">ORDENAR POR USUARIO</option>
                            <option value="2">ORDENAR POR NOMBRE PLAN</option>
                            <option value="3">ORDENAR POR ESTADO</option>
                            <option value="4">ORDENAR POR MONTO TOTAL ASCENDENTE</option>
                            <option value="5">ORDENAR POR MONTO TOTAL DESCENDENTE</option>
                        </select>
                    </div>

                    <div style="display:flex;justify-content: flex-end;">
                        <input type="button" class="btn btn-danger" id="btnLimpiar" onclick="Limpiar()" value="Limpiar">
                        <input type="submit" class="btn btn-success" id="btnForm" name="busqueda" value="Buscar">
                        <button type="submit" form="formu" style="border:none; background-color:transparent;"><i class="fa-solid fa-file-excel fa-2x" style="color: #1f5120;"></i>&nbspCSV</button>
                    </div>
                </div>
            </div>
        </div>
        

     

    <?php
        $añoActual = date('Y');
        $mesActual = date('n');
        // $sqla = "SELECT ID_MOVILINEA AS id, YEAR(FECHA) AS AÑO, MONTH(FECHA) AS MES FROM movilinea ORDER BY FECHA DESC LIMIT 1";
        $sqla = "SELECT 
                        SUM(CASE WHEN n.ID_PROVEEDOR = 34 THEN 1 ELSE 0 END) AS PERSONAL,
                        SUM(CASE WHEN n.ID_PROVEEDOR = 35 THEN 1 ELSE 0 END) AS CLARO
                      FROM movilinea m
                      INNER JOIN linea l ON m.ID_LINEA = l.ID_LINEA
                      INNER JOIN nombreplan n ON l.ID_NOMBREPLAN = n.ID_NOMBREPLAN
                      WHERE YEAR(FECHA) = $añoActual AND MONTH(FECHA) = $mesActual";
        $resultado = $datos_base->query($sqla);
        $row_ = $resultado->fetch_assoc();
        // $idUltimoRegistro = $row_['id'];
        // $añoUltimoRegistro = $row_['AÑO'];
        // $mesUltimoRegistro = $row_['MES'];
        $claro = $row_['CLARO'];
        $personal = $row_['PERSONAL'];
    switch ($mesActual) {
        case '1': $mes = 'Enero';break;
        case '2': $mes = 'Febrero';break;
        case '3': $mes = 'Marzo';break;
        case '4': $mes = 'Abril';break;
        case '5': $mes = 'Mayo';break;
        case '6': $mes = 'Junio';break;
        case '7': $mes = 'Julio';break;
        case '8': $mes = 'Agosto';break;
        case '9': $mes = 'Septiembre';break;
        case '10': $mes = 'Octubre';break;
        case '11': $mes = 'Noviembre';break;
        case '12': $mes = 'Diciembre';break;
        default: $mes = ''; break;
        }

    // if($añoUltimoRegistro == $añoActual && $mesUltimoRegistro == $mesActual){

    // }elseif($añoUltimoRegistro <= $añoActual && $mesUltimoRegistro != $mesActual){
    //     if($row['ID_PERFIL'] == 1 || $row['ID_PERFIL'] == 2){
    if($claro > 0 && $personal > 0){}
    else{
    ?>
    <!-- Boton de actulizar monto mensual-->
    <form method="POST" action="../abm/modificados.php" class="contFilter--name">
    <div style="width:100%;padding:10px 30px;display: flex;justify-content: flex-end;align-items: flex-end;">
        <input type="hidden" name="operador" id="operadorSeleccionado">
        <button type="button" name="btnActualizarMontoMensual" class="btn btn-danger" onclick="actualizar_montos(this.form)">Actualizar montos mes <?php echo $mes;?></button>
<!--         <a href="montosLineasActualizado.php" name="btnActualizarMontoMensual" class="btn btn-danger">Actualizar montos mes <?php echo $mes;?></a> -->

    </div>
    <?php }?>
    </form>
    
    
        <div class="principal-info">
            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM linea";
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
                        <span class="count-name">Líneas Registradas</span>
                    </div>
                </div>
            </div> -->

            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM linea WHERE ID_ESTADOWS = 1";
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
                        <span class="count-name">Líneas Activas</span>
                    </div>
                </div>
            </div> -->


            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM linea WHERE ID_ESTADOWS = 2 OR ID_ESTADOWS = 3";
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
                        <span class="count-name">Líneas Inactivas</span>
                    </div>
                </div>
            </div> -->
            <p>Líneas Registradas: <?php echo $total; ?></p>
            <p>Líneas Activas: <?php echo $activo; ?></p>
            <p>Líneas Inactivas: <?php echo $inactivos; ?></p>
        </div>


        <?php
        echo"<div class=filtrado>
                <label style='color:#00519C; margin-left: 15px; margin-bottom:20px;' id='nroLineas'>Resultados Encontrados:</label>
        ";?>

                <div id="filtrosUsados" style="display:none;">
                    <h2>Filtrado por:</h2>
                    <ul></ul>
                </div>
            </div>  
    <table class="table_id tablaLineas" id="tabla_lineas">
        <thead>
            <tr>
                <th><p style='text-align:right; margin-right: 5px;'>NÚMERO</p></th>
                <th><p style='text-align:left; margin-left: 5px;'>USUARIO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">REPARTICIÓN</p></th>
                <th><p style='text-align:left; margin-left: 5px;'>PLAN</p></th>
                <th><p style='text-align:left; margin-left: 5px;'>PROVEEDOR</p></th>
                <th><p style='text-align:right; margin-right: 5px;'>MONTO</p></th>
                <th><p style='text-align:right; margin-right: 5px;'>EXTRAS</p></th>
                <th><p style='text-align:right; margin-right: 5px;'>DESCUENTO</p></th>
                <!-- <th><p style='text-align:center;'>FECHA DESCUENTO</p></th> -->
                <th><p style='text-align:right; margin-right: 5px;'>MONTO TOTAL</p></th>
                <th><p style='text-align:left; margin-left: 10px;'>ESTADO</p></th>
                <th><p>ACCIÓN</p></th>
            </tr>
        </thead>
        <tbody id="tabla-datos"></tbody>
    </table>
		</div>
        <form id="formu" action="../exportar/ExcelMontosLineas.php" method="POST">
            <input type="text" id="excel" name="sql" class="valorPeque" readonly="readonly" value="<?php echo $query;?>">
        </form>
        <?php
				if(isset($_GET['ok'])){
					?>
					<script>ok();</script>
					<?php			
				}
				if(isset($_GET['error'])){
					?>
					<script>error();</script>
					<?php			
				}
                if(isset($_GET['errorp'])){
					?>
					<script>errorp();</script>
					<?php			
				}
			?> 
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
                    <button id="botonright" type="button" class="btn btn-success" onClick="imprimir2()"><i class='bi bi-printer' style="color:white;"></i></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!--FUNCIONALIDAD EN JQUERY QUE PETICIONA A consultarDatosLinea.php los detalles de la linea-->
    <script>
    function cargar_informacion(id_linea) {
        //buscar ES EL ID DEL CASO//
        var parametros = {
            "idLinea": id_linea
        };
        //LA VARIABLE BUSCAR UTILIZA EL ID CASO Y LA ENVIA AL SERVIDOR DE NOVEDADES///
        $.ajax({
            data: parametros,
            url: "./consultarDatosLinea.php",
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
    function cargar_informacion2(id_linea) {
        //buscar ES EL ID DEL CASO//
        var parametros = {
            "idLinea": id_linea
        };
        //LA VARIABLE BUSCAR UTILIZA EL ID CASO Y LA ENVIA AL SERVIDOR DE NOVEDADES///
        $.ajax({
            data: parametros,
            url: "./consultarDatosLinea2.php",
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
    </script>  
    <script>
        function filtrar(){
            var buscar= $("#buscar").val();
            var nombreplan= $("#nombreplan").val();
            var plan= $("#plan").val();
            var estado= $("#estado").val();
            var orden= $("#orden").val();
            if(buscar=="" && nombreplan=="" && plan=="" && estado=="" && orden==""){
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
            ventanaImpresion.document.write(`
        <style>
            @media print {
                #no-imprimir {
                    display: none !important;
                }
                #grilla {
                    width: 100% !important;
                    overflow-x: hidden !important;
                }
                #grilla table {
                    width: 100% !important;
                    table-layout: auto !important;
                    word-wrap: break-word;
                }
                #grilla th, #grilla td {
                    word-wrap: break-word;
                    white-space: normal;
                    font-size: 12px !important;
                }
                #grilla h4 {
                    font-size: 12px !important;
                    margin: 0 !important;
                }
                body {
                    margin: 0;
                    padding: 10px;
                    zoom: 90%;
                }
            }
        </style>
    `);

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
            
            // Obtener solo el contenido del primer modal
            var contenidoModal = document.getElementById('exampleModal2').innerHTML;

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