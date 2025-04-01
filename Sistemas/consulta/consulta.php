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

$cu = $row['CUIL'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>CONSULTA</title><meta charset="utf-8">
	<link rel="icon" href="../imagenes/logoInfraestructura.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="../jquery/1/jquery-ui.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="../jquery/1/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../jquery/1/jquery-ui.js"></script>
	<!--BUSCADOR SELECT-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<!--FIN BUSCADOR SELECT-->
	<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ebb188da7c.js" crossorigin="anonymus"></script>
	<!--Estilo bootstrap para select2-->
	<link rel="stylesheet" href="/path/to/select2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <link rel="stylesheet" type="text/css" href="../estilos/estiloconsulta.css">
	<style>
			body{
			background-color: #edf0f5;
			}
	</style>
</head>
<body>
<script type="text/javascript">
			function done(){
				// swal(  {title: "Se han cargado sus incidentes correctamente",
				// 		icon: "success",
				// 		showConfirmButton: true,
				// 		showCancelButton: false,
				// 		})
				// 		.then((confirmar) => {
				// 		if (confirmar) {
				// 			window.location.href='../consulta/consulta.php';
				// 		}
				// 		}
				// 		);
				Swal.fire({
                        title: "Se han cargado sus incidentes correctamente!!",
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
                            window.location.href='../consulta/consulta.php';


                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
			}	
			</script>
            <script type="text/javascript">
			function accept_auth(){
				Swal.fire({
                    icon: "success",
                    title: "Bienvenido!",
                    confirmButtonColor: '#3085d6',
                    });
			}	
			</script>
            <script>
                //Funcion que va mostrando que filtros se van utilizando
                function mostrarFiltros(){
                    const descripcion = $("#desc"); 
                    const fechaDesde = $("#buscafechadesde");
                    const fechaHasta = $("#buscafechahasta");
                    const orden = $("#orden");
                    const usuario = $("#buscador_usuario");
                    const estado = $("#estado");
                    const resolutor = $("#resolutor");
                    const edificio = $("#edificio");
                    const filtros = $("#filtrosUsados");

                    // Vaciar el div antes de agregar nuevos filtros
                    filtros.empty();

                    filtros.show();
                    filtros.append()
                    if (descripcion.val() != '') {
                        filtros.append(`<li style="color:blue; margin-left: 15px;"><u>DESCRIPCIÓN</u>: ${descripcion.val()}</li>`);
                    }
                    if (fechaDesde.val() != '' && fechaHasta.val() != '') {
                        filtros.append(`<li style="color:blue; margin-left: 15px;"><u>PERÍODO DE CREACIÓN</u>: ${fechaDesde.val()} - ${fechaHasta.val()} </li>`);
                    }
                    
                    if (usuario.val() != '') {
                        filtros.append(`<li style="color:blue; margin-left: 15px;"><u>USUARIO</u>: ${$("#buscador_usuario option:selected").text()}</li>`);
                    }
                    if (estado.val() != '') {
                        filtros.append(`<li style="color:blue; margin-left: 15px;"><u>ESTADO</u>: ${$("#estado option:selected").text()}</li>`);
                    }
                    if (resolutor.val() != '') {
                        filtros.append(`<li style="color:blue; margin-left: 15px;"><u>RESOLUTOR</u>: ${$("#resolutor option:selected").text()}</li>`);
                    }
                    if (edificio.val() != '') {
                        filtros.append(`<li style="color:blue; margin-left: 15px;"><u>EDIFICIO</u>: ${$("#edificio option:selected").text()}</li>`);
                    }
                }
            </script>
            <script>
                //Cargar datos en la tabla
        $(document).ready(function () {
            function cargarDatos(pagina = 1) {
                // Obtener valor del formulario
                const descripcion = $("#desc").val(); 
                const fechaDesde = $("#buscafechadesde").val();
                const fechaHasta = $("#buscafechahasta").val();
                const orden = $("#orden").val();
                const usuario = $("#buscador_usuario").val();
                const estado = $("#estado").val();
                const resolutor = $("#resolutor").val();
                const edificio = $("#edificio").val();
                const area = $("#area").val();
                //Obtener los datos de la tabla de incidentes
                $.ajax({
                    url: "paginador_incidentes.php", // Archivo PHP
                    type: "GET",
                    data: { pagina: pagina,
                            descripcion: descripcion,
                            fechaDesde: fechaDesde,
                            fechaHasta: fechaHasta,
                            orden: orden,
                            usuario: usuario,
                            estado: estado,
                            resolutor: resolutor,
                            edificio: edificio,
                            area: area },
                    dataType: "json",
                    //Respuesta obtenida de paginador.php
                    success: function (respuesta) {
                        //Cargamos el nro de incidentes obtenidos en label
                        
                        const lblNroIncidentes = $("#nroIncidentes"); 
                        lblNroIncidentes.text("Resultados Encontrados: "+respuesta.totalIncidentes);

                        //Cargamos la consulta sql utilizada en el value del input del formulario para generar el excel
                        

                        const inputExcel = $("#excel");
                        inputExcel.val(respuesta.query);

                        // Poblar la tabla
                        const tabla = $("#tabla-datos");
                        tabla.empty();
                        respuesta.datos.forEach(fila => {
                            let estado = fila.ESTADO;  // Este valor lo obtienes de tu lógica o de una variable
                            let color;

                            if (estado === "SOLUCIONADO") {
                            color = "green";  // Si el estado es "solucionado", el color será verde
                            } else if(estado === "ANULADO" || estado === "SUSPENDIDO") {
                            color = "red";  // Si el estado no es "solucionado", el color será rojo
                            } else if(estado === "DERIVADO" || estado === "EN PROCESO") {
                            color = "blue";  // Si el estado no es "solucionado", el color será rojo
                            }

                            // Verificar si la fecha de solución es "0000-00-00", en cuyo caso mostrar "-"
                            let fechaSolucion = (fila.FECHA_SOLUCION === "00-00-0000") ? "-" : fila.FECHA_SOLUCION;

                            let boton = fila.ESTADO == "SOLUCIONADO"
                            ? `<td><a class='btn btn-success mod' href='#' data-bs-toggle='modal' data-bs-target='#modalInfo' onclick='cargar_informacion(${fila.ID_TICKET})' style='color:white;margin-left:10px;'>Info</a></td>` 
                            : `<td style='padding:5px;'><a class='btn btn-info' href='modificacion.php?no=${fila.ID_TICKET}' target='new' class='mod' style='color:white;'>Editar</a></td>`;

                            tabla.append(`<tr>
                                <td><h4 style='font-size:14px; text-align:right;margin-right: 5px;'>${fila.ID_TICKET}</h4></td>
                                <td><h4 style='font-size:14px; text-align:center;'>${fila.FECHA_INICIO}</h4></td>
                                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;'>${fila.NOMBRE}</h4></td>
                                <td><h4 style='max-width: 180px;font-size:14px; text-align:left;margin-left: 5px;'>${fila.AREA} -<br/>${fila.REPA}</h4></td>
                                <td><h4 style='font-size:14px; text-align:left;margin-left: 5px;text-transform:uppercase;'>${fila.DESCRIPCION}</h4></td>
                                <td><h4 style='font-size:14px; color:${color};text-align:left;margin-left: 5px;'>${fila.ESTADO}</h4></td>
                                <td><h4 style='font-size:14px; text-align:center;'>${fechaSolucion}</h4></td>
                                <td><h4 style='font-size:14px; text-align:left;margin-right: 5px;'>${fila.RESOLUTOR}</h4></td>
                                ${boton}
                            </tr>`);
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
            window.location.href='../consulta/consulta.php';
        }
    </script>
<?php 
 include('../layout/consulta.php'); 
?>
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
			<h1>CONSULTA DE INCIDENTES</h1>
		</div>
        <!-- <form  class="contFilter--name"> -->
            <div class="filtros">
                <div class="filtros-listado">
                    <div>
                        <label class="form-label">Descripción</label>
                        <input type="text" style="text-transform:uppercase;" name="buscar" id="desc"  placeholder="Buscar" class="form-control largo">
                    </div>
                    <div>
                        <label class="form-label">Período</label>
                        <input type="date" id="buscafechadesde" name="buscafechadesde" class="form-control largo" >
                    </div>
                    <div style="align-items: flex-end;">
                        <label class="form-label">Hasta:</label>
                        <input type="date" id="buscafechahasta" name="buscafechahasta" class="form-control largo" >
                    </div>
                    <div>
                        <label class="form-label">Orden</label>
                        <select id="orden" name="orden" class="form-control largo">
                            <option value="">SIN ORDEN</option>
                            <option value="1">ORDENAR POR INCIDENTE</option>
                            <option value="2">ORDENAR POR USUARIO</option>
                            <option value="3">ORDENAR POR ESTADO</option>
                            <option value="4">ORDENAR POR RESOLUTOR</option>
                            <option value="5">ORDENAR POR FECHA DE SOLUCIÓN</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Usuario</label>
                        <select id="buscador_usuario" name="usuario" class="form-control largo" style="padding-left: -20px !important;">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM usuarios ORDER BY NOMBRE ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_USUARIO']?>"><?php echo $opciones['NOMBRE']?></option>
                                <?php endforeach ?>
                        </select>
                        <!--BUSCADOR-->
						<!--Agregar {theme: 'bootstrap4',} dentro de select-->
						<script>
							$('#buscador_usuario').select2({theme: 'bootstrap4',});
						</script>
                        <!--BUSCADOR-->
                        <script>
							$(document).ready(function(){
								$('#buscador_usuario').change(function(){
									buscador='b='+$('#buscador_usuario').val();
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
                        <label class="form-label">Estado</label>
                        <select id="estado" name="estado" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM estado ORDER BY ESTADO ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_ESTADO']?>"><?php echo $opciones['ESTADO']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Resolutor</label>
                        <select id="resolutor" name="resolutor" class="form-control largo">
                            <option value="">TODOS</option>
                            <?php 
                            $consulta= "SELECT * FROM resolutor ORDER BY RESOLUTOR ASC";
                            $ejecutar= mysqli_query($datos_base, $consulta) or die(mysqli_error($datos_base));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?> 
                                <option value="<?php echo $opciones['ID_RESOLUTOR']?>"><?php echo $opciones['RESOLUTOR']?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Edificio</label>
                        <select id="edificio" name="edificio" class="form-control largo">
                            <option value="">TODOS</option>
                            <option value="1">HUMBERTO PRIMO 607</option>
                            <option value="2">HUMBERTO PRIMO 725</option>
                        </select>
                    </div>
                    <div class="export" style="display:flex;justify-content: flex-end;">
                        <input class="btn btn-danger" id="btnLimpiar" name="Limpiar" onclick="Limpiar()" value="Limpiar">
                        <input type="submit" class="btn btn-success" id="btnForm" name="busqueda" value="Buscar">
                    </div>
                </div>

                <div class="filtros-listadoParalelo" style="margin-right:20px; margin-top:-70px;">
                    <div class="export">
                        Exportar a: <button type="submit" form="formu" style="border:none; background-color:transparent;"><i class="fa-solid fa-file-excel fa-2x" style="color: #1f5120;"></i>&nbspCSV</button>
                    </div>
                </div>
                <!-- </form> -->
            </div>
                    
                <div style="margin-bottom: 15px; margin-top:15px;" class="principal-info">
            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM ticket";
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
                        <span class="count-name">Totales</span>
                    </div>
                </div>
            </div>

            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM ticket WHERE ID_ESTADO = 2";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $solucionado = $row6['total'];
            ?>
            <div class="col-md-3">
                <div class="card-counter success">
                    <div class="card-pri">
                        <i class="fa-regular fa-circle-check"></i>
                        <span class="count-numbers"><?php echo $solucionado;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Solucionados</span>
                    </div>
                </div>
            </div>


            <?php 
                $sql6 = "SELECT COUNT(*) AS total FROM ticket WHERE ID_ESTADO = 1 OR ID_ESTADO = 5";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $finales = $row6['total'];

                $sql6 = "SELECT COUNT(*) AS total FROM ticket WHERE ID_ESTADO = 3 OR ID_ESTADO = 4";
                $result6 = $datos_base->query($sql6);
                $row6 = $result6->fetch_assoc();
                $espera = $row6['total'];
            ?>
            <div class="col-md-3">
                <div class="card-counter danger">
                    <div class="card-pri">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span class="count-numbers"><?php echo $espera . " - " . $finales;?></span>
                    </div>
                    <div class="card-sec">
                        <span class="count-name">Por solucionar - Anulados</span>
                    </div>
                </div>
            </div>
        </div>    
        <?php
        echo"<div class=filtrado>
        <label style='color:blue; margin-left: 15px; margin-bottom:20px;' id='nroIncidentes'>Resultados Encontrados:</label>
        ";    ?>
        
        <div id="filtrosUsados" style="display:none;">
        <h2>Filtrado por:</h2>
                <ul></ul>
        </div>
            </div>
        <table class="table_id" style="width: 98%; margin: 0 auto;">
        <thead>
            <tr>
            <th id="th">N°INCIDENTE</th>
                <th id="th" style="text-align:center;">FECHA INICIO</th>
                <th id="th" style="padding: 5px;">USUARIO</th>
                <th id="th" style="text-align:center;">ÁREA/REPARTICIÓN</th>
                <th id="th" style="padding: 5px;">DESCRIPCIÓN</th>
                <th id="th" style="text-align:left;padding: 5px;">ESTADO</th>
                <th id="th" style="text-align:center;">FECHA SOLUCIÓN</th>
                <th id="th" style="text-align:left;padding: 5px;">RESOLUTOR</th>
                <?php if ($row['ID_PERFIL'] != 5) {
                echo'<th id="th" style="text-align:center;">ACCIÓN</th>';
                }?>
            </tr>
        </thead>

        <tbody id="tabla-datos"></tbody>

            </table> 
        
        <form id="formu" action="../exportar/ExcelIncidentes.php" method="POST">
            <!-- <input type="text" id="excel" name="sql" class="valorPeque" readonly="readonly" value="<?php //echo $query;?>"> -->
            <input type="text" id="excel" name="sql" class="valorPeque" readonly="readonly" value="">
        </form>
        <?php
				if(isset($_GET['okpw'])){
					?>
					<script>accept_auth();</script>
					<?php			
				}
			?>
	</section>

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
                    <div id="contenidoInfo" style="display:flex;flex-direction:column;gap:10px;width:auto;">
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
    
	<footer id="footer_pag"><div class="pagination justify-content-center mt-3" id="paginador"></div></footer>
    <script>
    function cargar_informacion(id_Ticket) {
        //buscar ES EL ID DEL CASO//
        var parametros = {
            "idTicket": id_Ticket
        };
        //LA VARIABLE BUSCAR UTILIZA EL ID CASO Y LA ENVIA AL SERVIDOR DE NOVEDADES///
        $.ajax({
            data: parametros,
            url: "./consultarDatosIncidentes.php",
            type: "POST",
            //TRAE DE FORMA ASINCRONA, CONSUME EL SERVIDOR DE NOVEDADES Y MUESTRA EN EL DIV MOSTRAR_MENSAJE TODAS LAS NOVEDADES RELACIONADAS////
            beforesend: function() {
                $("#contenidoInfo").html("Mensaje antes de Enviar");
            },

            success: function(mensaje) {
                $("#contenidoInfo").html(mensaje);
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
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
  		AOS.init();
	</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	
	<script>
		const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
		const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
	</script>
	
</body>
</html>