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
    <script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
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
    <script>
	function ok(){
        Swal.fire({
                    title: "Equipo cargado correctamente.",
                    icon: "success",
                    showConfirmButton: true,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: "Cancelar",
                    customClass:{
                        actions: 'reverse-button'
                    }
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        window.location.href='abmequipos.php';


                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })
        }	

	function no(){
        Swal.fire({
                    title: "El equipo ya está registrado",
                    icon: "error",
                    showConfirmButton: true,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: "Cancelar",
                    customClass:{
                        actions: 'reverse-button'
                    }
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        window.location.href='agregarequipo.php';


                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })
        }

    function okMod(){
        Swal,fire(  {title: "Equipo modificado correctamente",
                icon: "success",
                showConfirmButton: true,
                showCancelButton: false,
                })
                .then((confirmar) => {
                if (confirmar) {
                    window.location.href='abmequipos.php';
                }
                }
                );
        }
    function noMod(){
        Swal.fire(  {title: "El equipo ingresado ya está registrado",
                icon: "error",
                })
                .then((confirmar) => {
                if (confirmar) {
                    window.location.href='abmequipos.php';
                }
                }
                );
        }	


    //Funcion que va mostrando que filtros se van utilizando
    function mostrarFiltros(){
        const busqueda = $("#buscar");
        const area = $("#area");
        const reparticion = $("#reparticion");
        const orden = $("#orden"); 
        const tipows = $("#tipows"); 
        const so = $("#so"); 
        const micro = $("#micro"); 
        const estado = $("#estado");
        
        const filtros = $("#filtrosUsados");
        // Vaciar el div antes de agregar nuevos filtros
        filtros.empty();

        
        filtros.append();
        
        if (busqueda.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>BÚSQUEDA</u>: ${busqueda.val()}</li>`);
        }
        
        if (area.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>AREA</u>: ${$("#area option:selected").text()}</li>`);
        }
        if (reparticion.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>REPARTICION</u>: ${$("#reparticion option:selected").text()}</li>`);
        }
        if (tipows.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>TIPO WS</u>: ${$("#tipows option:selected").text()}</li>`);
        }if (so.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>S.O.</u>: ${$("#so option:selected").text()}</li>`);
        }if (micro.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>MICRO</u>: ${$("#micro option:selected").text()}</li>`);
        }if (estado.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>ESTADO</u>: ${$("#estado option:selected").text()}</li>`);
        }
        if (orden.val() != '') {
            filtros.append(`<li style="color:blue; margin-left: 15px;"><u>ORDEN</u>: ${$("#orden option:selected").text()}</li>`);
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
                const area = $("#area").val();
                const reparticion = $("#reparticion").val();
                const orden = $("#orden").val(); 
                const tipows = $("#tipows").val(); 
                const so = $("#so").val(); 
                const micro = $("#micro").val(); 
                const estado = $("#estado").val();
                //Obtener los datos de la tabla de usuarios
                $.ajax({
                    url: "paginador_inventario.php", // Archivo PHP
                    type: "GET",
                    data: { 
                            pagina: pagina,
                            busqueda: busqueda,
                            area: area,
                            reparticion: reparticion,
                            orden: orden,
                            tipows: tipows,
                            so: so,
                            micro: micro,
                            estado: estado,
                             },
                    dataType: "json",
                    //Respuesta obtenida de paginador.php
                    success: function (respuesta) {
                        //Cargamos el nro de incidentes obtenidos en label
                        
                        const lblUsuarios = $("#nroInventario").text("Resultados Encontrados: "+respuesta.totalInventario); 
                         //Mostramos el label con el numero de resultados encontramos
                         if(busqueda=='' && area=='' && reparticion=='' && orden=='' && tipows=='' && so=='' && micro=='' && estado==''){
                            $("#nroInventario").hide();
                        }
                        else{
                            $("#nroInventario").show();
                        }
                        

                        //Cargamos la consulta sql utilizada en el value del input del formulario para generar el excel
                        

                         const inputExcel = $("#excel");
                         inputExcel.val(respuesta.query);

                        // Poblar la tabla
                        const tabla = $("#tabla-datos");
                        tabla.empty();
                        respuesta.datos.forEach(fila => {
                            let estado = fila.ESTADO;  // Este valor lo obtienes de tu lógica o de una variable
                            let color;

                            if (estado === "EN USO") {
                            color = "green";  // Si el estado es "en uso", el color será verde
                            } else if(estado === "BAJA") {
                            color = "red";  // Si el estado no es "baja", el color será rojo
                            } else if(estado === "S/A - STOCK") {
                            color = "blue";  // Si el estado no es "solucionado", el color será rojo
                            }
                            console.log(fila);

                            tabla.append(`<tr>
                                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${fila.REPA}</h4></td>
                                <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${fila.AREA}</h4></td>
                                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${fila.NOMBRE}</h4></td>
                                <td><h4 style='max-width:180px;font-size:14px; text-align:left;margin-left: 5px;'>${fila.SERIEG}</h4></td>
                                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${fila.SIST_OP}</h4></td>
                                <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${fila.MICRO}</h4></td>
                                <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${fila.TIPOWS}</h4></td>
                                <td><h4 style='font-size:14px;text-align:left;margin-left: 5px;'>${fila.OBSERVACION}</h4></td>
                                <td><h4 style='color:${color};font-size:14px;text-align:left;margin-left: 5px;'>${fila.ESTADO}</h4></td>

                                <td class='text-center text-nowrap'>
                                    <span style="display: inline-flex;padding:5px;">
                                        <a target='_blank' 
                                        href=consultadetalleinv.php?no=${fila.ID_WS} 
                                        target=new class=mod 
                                        data-bs-toggle="popover" 
                                        data-bs-trigger="hover" 
                                        data-bs-placement="top" 
                                        data-bs-content="Información">
                                            <i style="color: #0d6efd" 
                                            class="fa-solid fa-circle-info fa-2xl"></i>
                                        </a>
                                    </span>

                                    <span style="display: inline-flex;padding:3px;">
                                        <a style="padding:3px;" 
                                        href='../abm/modequipo.php?no=${fila.ID_WS}' 
                                        target='_blank' 
                                        class='mod' 
                                        data-bs-toggle='popover' 
                                        data-bs-trigger='hover' 
                                        data-bs-placement='top' 
                                        data-bs-content='Editar'>
                                            <i style="color: #198754" 
                                            class="fa-solid fa-pen-to-square fa-2xl"></i>
                                        </a>
                                    </span>

                                    <span style="display: inline-flex;padding:3px;">
                                        <a style="padding:3px;" href="#" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#exampleModal" 
                                            onclick="cargar_informacion('${fila.ID_WS}'); return false;" 
                                            target="_blank" 
                                            class="mod"
                                            title="Movimientos/Mejoras">
                                            <i style="color: #fd7e14" 
                                            class="fa-solid fa-arrow-down-wide-short fa-2xl"></i>
                                        </a>
                                    </span>

                                    <span style="display: inline-flex; padding: 3px;">
                                        <a href="../equipos/${fila.SERIEG}.pdf" 
                                        target="_blank" 
                                        data-bs-toggle="popover" 
                                        data-bs-trigger="hover" 
                                        data-bs-placement="top" 
                                        data-bs-content="Abrir PDF">
                                            <i style="color: #dc3545" 
                                            class="fa-solid fa-file-pdf fa-2xl"></i>
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
    <script>
        //Limpiar campos de formulario
        function Limpiar(){
            window.location.href='../consulta/inventario.php';
        }
    </script>
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
			<h1>INVENTARIO DE EQUIPOS</h1>
		</div>
        <!-- <form method="POST" action="./inventario.php" class="contFilter--name"> -->
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">Usuario/N°WS/Observación</label>
                        <input type="text" style="text-transform:uppercase;" id ="buscar" name="buscar"  placeholder="Buscar" class="form-control largo">
                    </div>
                    <div>
                        <label class="form-label">Área</label>
                        <select id="area" name="area" class="form-control largo">
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
							$('#area').select2({theme: 'bootstrap4',});
						</script>
                        <!--BUSCADOR-->
                        <script>
							$(document).ready(function(){
								$('#area').change(function(){
									buscador='b='+$('#area').val();
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
                        <label class="form-label">Sistema Operativo</label>
                        <select id="so" name="so" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM so ORDER BY SIST_OP ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_SO']?>"><?php echo $opciones['SIST_OP']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Micro</label>
                        <select id="micro" name="micro" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM micro ORDER BY MICRO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_MICRO']?>"><?php echo $opciones['MICRO']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Tipo</label>
                        <select id="tipows" name="tipows" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM tipows ORDER BY TIPOWS ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_TIPOWS']?>"><?php echo $opciones['TIPOWS']?></option>
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
                            if ($_POST["orden"] == '2'){echo 'ORDENAR POR AREA';} 
                            if ($_POST["orden"] == '3'){echo 'ORDENAR POR REPARTICIÓN';}
                            if ($_POST["orden"] == '4'){echo 'ORDENAR POR SISTEMA OPERATIVO';} 
                            if ($_POST["orden"] == '5'){echo 'ORDENAR POR MICRO';}
                            if ($_POST["orden"] == '6'){echo 'ORDENAR POR TIPO';}
                            if ($_POST["orden"] == '7'){echo 'ORDENAR POR ESTADO';}
                            ?>
                            </option>
                            <?php } ?>
                            <option value="">SIN ORDEN</option>
                            <option value="1">ORDENAR POR USUARIO</option>
                            <option value="2">ORDENAR POR AREA</option>
                            <option value="3">ORDENAR POR REPARTICIÓN</option>
                            <option value="4">ORDENAR POR SISTEMA OPERATIVO</option>
                            <option value="5">ORDENAR POR MICRO</option>
                            <option value="6">ORDENAR POR TIPO</option>
                            <option value="7">ORDENAR POR ESTADO</option>
                        </select>
                    </div>

                    <div style="display:flex;justify-content: flex-end;">
                        <input class="btn btn-danger" id="btnLimpiar" name="Limpiar" onclick="Limpiar()" value="Limpiar">
                        <input type="submit" class="btn btn-success" id="btnForm" name="busqueda" value="Buscar">
                    </div>
                </div>
                <div class="filtros-listadoParalelo">
                    <div>
                        <button class="btn btn-success" style="font-size: 20px;"><a href="agregarequipo.php" style="text-decoration:none !important;color:white;" target="_blank">Agregar nuevo equipo</a></button>
                    </div>
                    <div class="export">
                        Exportar a: <button type="submit" form="formu" style="border:none; background-color:transparent;"><i class="fa-solid fa-file-excel fa-2x" style="color: #1f5120;"></i>&nbspCSV</button>
                    </div>
                </div>
            </div>
        

    
   
        <div class="principal-info">
            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM inventario";
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
                        <span class="count-name">Equipos Registrados</span>
                    </div>
                </div>
            </div>

            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM inventario WHERE ID_ESTADOWS = 1";
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
                        <span class="count-name">Equipos Activos</span>
                    </div>
                </div>
            </div>


            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM inventario WHERE ID_ESTADOWS = 2";
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
                        <span class="count-name">Equipos Inactivos</span>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo"<div class=filtrado>
        <label style='color:blue; margin-left: 15px; margin-bottom:20px;' id='nroInventario'>Resultados Encontrados:</label>
        ";    ?>

        <div id="filtrosUsados" style="display:none;">
            <h2>Filtrado por:</h2>
                <ul></ul>
            </div>
    </div>                        
    <table class="table_id" style="width: 98%; margin: 0 auto;">
        <thead>
            <tr>
                <th><p style="text-align:left; margin-left: 5px;">REPARTICIÓN</p></th>
                <th><p style="text-align:left; margin-left: 5px;">ÁREA</p></th>
                <th><p style="text-align:left; margin-left: 5px;">USUARIO</p></th>
                <th><p style="text-align:left; margin-left: 5px;">N° WS</p></th>
                <th><p style="text-align:left; margin-left: 5px;">S.O.</p></th>
                <th><p style="text-align:left; margin-left: 5px;">MICRO</p></th>
                <th><p style="text-align:center;">TIPO</p></th>
                <th><p style="text-align:left; margin-left: 5px;width:220px;">OBSERVACION</p></th>
                <th><p style="text-align:center;">ESTADO</p></th>
                <th><p>MAS DETALLES</p></th>
            </tr>
        </thead>
        <tbody id="tabla-datos"></tbody>

        </table>                      
        
		</div>
        <form id="formu" action="../exportar/ExcelInventario.php" method="POST">
            <input type="text" id="excel" name="sql" class="valorPeque" readonly="readonly" value="">
        </form>
        <?php
            if(isset($_GET['okMod'])){
                ?>
                <script>okMod();</script>
                <?php			
            }

            if(isset($_GET['noMod'])){
                ?>
                <script>noMod();</script>
                <?php			
            }

            if(isset($_GET['ok'])){
                ?>
                <script>ok();</script>
                <?php			
            }

            if(isset($_GET['no'])){
                ?>
                <script>no();</script>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">MOVIMIENTOS Y MEJORAS</h1>
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
    <script>
        function cargar_informacion(id_ws) {
            //buscar ES EL ID DEL CASO//
            var parametros = {
                "idWs": id_ws
            };
            //LA VARIABLE BUSCAR UTILIZA EL ID CASO Y LA ENVIA AL SERVIDOR DE NOVEDADES///
            $.ajax({
                data: parametros,
                url: "./consultarDatosInventario.php",
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